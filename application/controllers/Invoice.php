<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."libraries/lib/config_paytm.php");
require_once(APPPATH."libraries/lib/encdec_paytm.php");

class Invoice extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url', 'form');
        $this->load->library('session');
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="errormsg notification"><i class="fa fa-times"></i> ', '</div>');
        $this->load->database();
        $this->load->model('Common_model');
    }

    public function index() {		
		$invoice_no = $this->uri->segment(2);
		$booking_id = $this->Common_model->decode($this->uri->segment(3));
		$noof_rec = $this->Common_model->noof_records("booking_id","tbl_bookings","booking_id='$booking_id' and invoice_no='$invoice_no'");
		if($noof_rec > 0)
		{
			$data['message'] = $this->session->flashdata('message');
			
			$paytmChecksum = "";
			$paramList = array();
			$isValidChecksum = "FALSE";

			$paramList = $_POST;
			$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

			//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
			$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
			
			if($isValidChecksum == "TRUE") {
				//echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
				if ($_POST["STATUS"] == "TXN_SUCCESS") {
					
					$payment_amount = $_POST['TXNAMOUNT'];
					$txn_id = $_POST['TXNID'];
					if ($payment_amount>0)
					{
						$updatedata = array('payment_status' => 1,'transactin_id' => $txn_id);
						$updatequery = $this->Common_model->update_records("tbl_bookings",$updatedata,"booking_id='$booking_id'");
					}
					$data['message'] = '<div class="successmsg notification"><i class="fa fa-check"></i> Thank you for the payment. Transaction processed successfully.</div>';
				}
				else {
					$data['message'] = '<div class="errormsg notification"><i class="fa fa-times"></i> Transaction failed. Please try again.</div>';
				}
			}
			else {
				//$data['message'] = '<div class="errormsg notification"><i class="fa fa-times"></i> Transaction failed due to some mismatch. Please try again.</div>';
			}

			/*start -- checking payment status */
			
			/* initialize an array */
			$paytmParams = array();

			/* Find your MID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
			$paytmParams["MID"] = PAYTM_MERCHANT_MID;

			/* Enter your order id which needs to be check status for */
			$paytmParams["ORDERID"] = $invoice_no;

			/**
			* Generate checksum by parameters we have
			* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
			*/
			$checksum = getChecksumFromArray($paytmParams, PAYTM_MERCHANT_KEY);

			/* put generated checksum value here */
			$paytmParams["CHECKSUMHASH"] = $checksum;

			/* prepare JSON string for request */
			$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

			/* for Staging */
			//$url = "https://securegw-stage.paytm.in/order/status";

			/* for Production */
			$url = "https://securegw.paytm.in/order/status";

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));  
			$response = curl_exec($ch);
			
			$response_data = json_decode($response, TRUE);
			//print_r($response_data);
			if(isset($response_data['STATUS']) && isset($response_data['RESPCODE']))
			{				
				$web_pay_status = $this->Common_model->showname_fromid("payment_status", "tbl_bookings", "booking_id='$booking_id' and invoice_no='$invoice_no'");
				if($web_pay_status == 1)
					$web_pay_status = 1;
				else
					$web_pay_status = 0;
				
				if(($response_data['STATUS']=="TXN_SUCCESS") && ($response_data['RESPCODE']=="01"))
					$paytm_pay_status = 1;
				else
					$paytm_pay_status = 0;
				
				if($web_pay_status != $paytm_pay_status)
				{
					$txn_id = $response_data['TXNID'];
					$updatedata = array('payment_status' => $paytm_pay_status,'transactin_id' => $txn_id);
					$updatequery = $this->Common_model->update_records("tbl_bookings",$updatedata,"booking_id='$booking_id'");
				}
			}
			/*End -- checking payment status */
			
			$bookings=$this->Common_model->get_records("*","tbl_bookings","booking_id='$booking_id' and invoice_no='$invoice_no'");
			$data['bookings'] = $bookings;
			
			foreach ($bookings as $booking_res)
			{
				$email_status = $booking_res['email_status'];
				$payment_status = $booking_res['payment_status'];
				$sms_status = $booking_res['sms_status'];
				
				$invoice_no = $booking_res['invoice_no'];
				$customer_id = $booking_res['customer_id'];
				
				$customers = $this->Common_model->get_records("fullname, contact, email_id","tbl_customers","customer_id='$customer_id'");
				foreach ($customers as $customer)
				{
					$customer_name = $customer['fullname'];
					$customer_phone = $customer['contact'];
					$customer_email = $customer['email_id'];
				}

				$package_id = $booking_res['package_id'];
				$package_name = $this->Common_model->showname_fromid("tpackage_name", "tbl_tourpackages", "tourpackageid ='$package_id'");
				$package_url = $this->Common_model->showname_fromid("tpackage_url","tbl_tourpackages","tourpackageid = $package_id");
				$full_package_url = base_url().'packages/'.$package_url;
				
				$transaction_amount = $booking_res['paid_amount'];
				
				if(($email_status==0) && ($payment_status==1)) 
				{						
					$date_of_travel = $booking_res['date_of_travel'];
					$booking_date = $booking_res['booking_date'];
					$show_travel_date = $this->Common_model->dateformat($date_of_travel);
					$show_booking_date = $this->Common_model->dateformat($booking_date);
					
					$package_duration = $booking_res['package_duration'];
					$show_duration = $this->Common_model->showname_fromid("duration_name", "tbl_package_duration", "durationid ='$package_duration'");
					
					$noof_adults = $booking_res['noof_adults'];
					$noof_childs = $booking_res['noof_childs'];
					
					$vehicle_id = $booking_res['vehicle_id'];
					$vehicle_name = $this->Common_model->showname_fromid("vehicle_name", "tbl_vehicletypes", "vehicleid ='$vehicle_id'");
					
					$accomodation_type = $booking_res['accomodation_type'];
					$accomodation_name = $this->Common_model->showname_fromid("hotel_type_name", "tbl_hotel_type", "hotel_type_id ='$accomodation_type'");
					
					$accomodation_hotels = $booking_res['accomodation_hotels'];
					$hotel_ids = explode(",",$accomodation_hotels);
					$hotel_names = array();
					foreach($hotel_ids as $hotel_id)
					{
						$hotel_names[] = $this->Common_model->showname_fromid("hotel_name", "tbl_hotel", "hotel_id ='$hotel_id'");
					}
					
					$show_hotel_names = implode(", ", $hotel_names);
					
					$airport_pickup = $booking_res['airport_pickup'];
					$show_airport_pickup = ($airport_pickup == 1)?"Yes":"No";
					$airport_drop = $booking_res['airport_drop'];
					$show_airport_drop = ($airport_drop == 1)?"Yes":"No";
					
					$payment_percentage = $booking_res['payment_percentage'];
					$paid_amount = $this->Common_model->currency.$booking_res['paid_amount'];
					$total_price = $this->Common_model->currency.$booking_res['total_price'];
					
					$mailconfig   = Array(
						'mailtype' => 'html',
						'charset' => 'iso-8859-1',
						'wordwrap' => TRUE,
						'newline' => '\n',
						'crlf' => '\n'
					);
					
					$common_mailcontent = "<div style='line-height:25px;font-size:14px;width:40%; float:left;'>
									<span style='color:#1fc0be;font-size:16px;'>$customer_name</span><br>
									<span style='font-size:15px;'>$customer_phone</span>
								</div>	
								<div style='line-height:25px;font-size:14px;width:45%; float:right;text-align:right;'>
									Invoice No: <b>$invoice_no</b><br>
									Invoice date: <b>$show_booking_date</b><br>
									travel date: <b>$show_travel_date</b>
								</div>	
								<div style='clear:both;'></div>
								<div style='background: #e8fbfa;margin-bottom: 20px;padding: 18px;margin-top: 10px;padding-bottom: 10px;'>
									<div style='font-size: 16px;color: #000;border-bottom: 1px solid #d3f5f3;padding-bottom: 3px;margin-bottom: 2px;'><a href='$full_package_url'>$package_name ( $show_duration )</a></div>
									<div style='font-size: 16px;color: #000;border-bottom: 1px solid #d3f5f3;padding-bottom: 3px;margin-bottom: 2px;'>$noof_adults Adults $noof_childs Childrens</div>
									<div style='font-size: 16px;color: #000;border-bottom: 1px solid #d3f5f3;padding-bottom: 3px;margin-bottom: 2px;'>$vehicle_name</div>
									<div style='font-size: 16px;color: #000;border-bottom: 1px solid #d3f5f3;padding-bottom: 3px;margin-bottom: 2px;'>$accomodation_name ( $show_hotel_names )</div>
									<div style='font-size: 16px;color: #000;border-bottom: 1px solid #d3f5f3;padding-bottom: 3px;margin-bottom: 2px;'>Pickup: <span style='color:#008a88;font-weight:bold;'>$show_airport_pickup</span> &nbsp; &nbsp; Drop: <span style='color:#008a88;font-weight:bold;'> $show_airport_drop </span></div>
									<div style='font-size: 16px;color: #000;border-bottom: 1px solid #d3f5f3;padding-bottom: 3px;margin-bottom: 2px;'>Payment Status: <span style='color:#008a88;font-weight:bold;'>$paid_amount ( $payment_percentage% ) PAID</span></div>
									<div style='font-size: 16px;color: #000;padding-bottom: 3px;margin-bottom: 2px;'>Total Price : <span style='color:#008a88;font-weight:bold;'> $total_price</span></div>
								</div>
								<div style='clear:both;'></div>";
								
					$customer_mailcontent = "<!doctype html>
					<html>
						<head>
							<meta charset='utf-8'>
						</head>
						<body style='font-family:sans-serif;font-size:13px; line-height:22px;'>
							<div style='width: 100%;background: #F5F5F5;color: #000;'>
								<div style='text-align:center'><a href='".base_url()."'><img src='".base_url()."assets/images/logo.png'></a></div>				
								<div style='clear:both'></div>
							</div>
							
							<div style='padding:10px 30px;'>				  	
								<div style='margin-top:30px;margin-bottom:20px;line-height:25px;font-size:14px'>Hello <b>$customer_name</b>,<br>Thank you for booking with us. We will let you know about your booking status very soon.</div>
								".$common_mailcontent."
								<div style='margin-top:10px;margin-bottom:20px;line-height:25px;font-size:14px'>Other details can be viewed from your customer account. Login to your account and check details, let us know if you have any query. You can call us at <span style='color:#008a88;'>+91 988-652-5253</span>  or mail us to <span style='color:#008a88;'> support@myholidayhappiness.com </span>. </div>
							</div>				
							
							<div style='background:#f5f5f5; padding:10px 30px 5px; color:#000;'>
								<div style='color:#15c; font-size:13px; text-align:center; margin-bottom:10px;'>
									&copy; ".date("Y")." All right reserved. myholidayhappiness.com
								</div>
							</div>
						</body>
					</html>";
					//echo $customer_mailcontent;
					
					$subject = "Your booking is completed successfully in My Holiday Happiness";
					$from_mail = $this->Common_model->show_parameter(9);
					$to_mail = $customer_email;
					
				// 	$this->load->library('email', $mailconfig);
				// 	$this->email->from($from_mail, "myholidayhappiness.com");
				// 	$this->email->to($to_mail);
				// 	$this->email->reply_to($from_mail, "myholidayhappiness.com");
				// 	$this->email->subject($subject);
				// 	$this->email->message($customer_mailcontent);
				// 	@$this->email->send(); 
					
					$headers = 'From:  myholidayhappiness.com <'.$from_mail.">\r\n" .
                        'Reply-To: myholidayhappiness.com <'.$from_mail.">\r\n" .
                        'X-Mailer: PHP/' . phpversion();
                 $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";   
                mail($to_mail, $subject, $customer_mailcontent, $headers);
					
					$admin_mailcontent = "<!doctype html>
					<html>
						<head>
							<meta charset='utf-8'>
						</head>
						<body style='font-family:sans-serif;font-size:13px; line-height:22px;'>
							<div style='width: 100%;background: #F5F5F5;color: #000;'>
								<div style='text-align:center'><a href='".base_url()."'><img src='".base_url()."assets/images/logo.png'></a></div>				
								<div style='clear:both'></div>
							</div>
							
							<div style='padding:10px 30px;'>				  	
								<div style='margin-top:30px;margin-bottom:20px;line-height:25px;font-size:14px'>There is a new booking from My Holiday Happiness. Please check details below.</div>
								".$common_mailcontent."
								<div style='margin-top:10px;margin-bottom:20px;line-height:25px;font-size:14px'>Other details can be checked in admin panel booking module. </div>
							</div>				
							
							<div style='background:#f5f5f5; padding:10px 30px 5px; color:#000;'>
								<div style='color:#15c; font-size:13px; text-align:center; margin-bottom:10px;'>
									&copy; ".date("Y")." All right reserved. myholidayhappiness.com
								</div>
							</div>
						</body>
					</html>";
					
					$admin_subject = "New booking $invoice_no from  My Holiday Happiness";
					$admin_tomail = $this->Common_model->show_parameter(2);
					
					$this->load->library('email', $mailconfig);
					$this->email->from($from_mail, "myholidayhappiness.com");
					$this->email->to($admin_tomail);
					$this->email->reply_to($from_mail, "myholidayhappiness.com");
					$this->email->subject($admin_subject);
					$this->email->message($admin_mailcontent);
					@$this->email->send(); 
						
					$headers = 'From:  myholidayhappiness.com <'.$from_mail.">\r\n" .
                        'Reply-To: myholidayhappiness.com <'.$from_mail.">\r\n" .
                        'X-Mailer: PHP/' . phpversion();
                 $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";   
                mail($admin_tomail, $admin_subject, $admin_mailcontent, $headers);
                
                
					$query_data = array( 'email_status' => 1);
					$querydb = $this->Common_model->update_records('tbl_bookings', $query_data, "booking_id='$booking_id'");
				}
				
				if(($sms_status==0) && ($payment_status==1)) 
				{					
					// Authorisation details.
					$username = "support@myholidayhappiness.com";
					$hash = "ba82c8a1b8810d4e7ddeaae92e6559bcf3a4e99a3f11d570f41d001687b8a930";

					// Config variables. Consult http://api.textlocal.in/docs for more info.
					$test = "0";

					// Data for text message. This is the text message data.
					$sender = "TXTLCL"; //TXTLCL This is who the message appears to be from.
					$numbers = $customer_phone; // A single number or a comma-seperated list of numbers
					$update_pkg_name =  str_replace("|", "-", $package_name);
					$message = "Thank for booking with MHH. We have received your Rs. $transaction_amount for your travel package '$update_pkg_name'. Thanks";
					// 612 chars or less
					// A single number or a comma-seperated list of numbers
					$message = urlencode($message);
					//$smsdata = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
					$smsdata = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers;
					$ch = curl_init('http://api.textlocal.in/send/?');
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $smsdata);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$result = curl_exec($ch); // This is the result from the API
					curl_close($ch);
					
					$updatesms = array('sms_status' => 1);
					$updatesmsquery = $this->Common_model->update_records("tbl_bookings",$updatesms,"booking_id='$booking_id'");
				}
			}
			
			$this->load->view('invoice', $data);
		}
		else
		{
			redirect(base_url(),'refresh');
		}
    }


}
