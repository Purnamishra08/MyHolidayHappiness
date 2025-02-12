<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
 	{
		parent::__construct();
		$this->load->helper('url','form');
		$this->load->library('session');
		$this->load->helper('security');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="errormsg notification"><i class="fa fa-times"></i> ', '</div>');
		$this->load->database();
		$this->load->model('Common_model');
 	}

	public function index()
	{
		$data['message'] = $this->session->flashdata('message');

		if (isset($_POST['btnSignincust']) && !empty($_POST))
		{
			$this->form_validation->set_rules('login_email','Email','trim|required|valid_email');
			$this->form_validation->set_rules('login_password','Password','trim|required');
			if ($this->form_validation->run() == true)
			{
				//Check Login
				$login_email = trim($this->input->post('login_email'));
				$login_password = $this->input->post('login_password');
				
				$hasingpwd=$this->Common_model->showname_fromid("password","tbl_customers","email_id='$login_email' and status=1");
				if(password_verify("$login_password", $hasingpwd))
				{
					$checkdb = $this->Common_model->get_records("customer_id, fullname, email_id","tbl_customers","email_id='$login_email' and status=1","","1");
					$sess_array = array();
					foreach($checkdb as $row)
					{
						$customer_id = $row['customer_id'];
						$fullname = $row['fullname'];
						$email_id = $row['email_id'];
					}
					
					$sess_array = array(
						'customer_id' => $customer_id,
						'fullname' => $fullname,
						'email_id' => $email_id,
						'sess_id' => session_id()						
					);
					$this->session->set_userdata($sess_array);
					redirect(base_url().'booking','refresh');
				}
				else
				{
					$data['message'] = '<div class="errormsg notification"><i class="fa fa-times"></i> Invalid Login. Please try again.</div>';
				}									
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		$this->load->view('login', $data);
	}


    public function forgot_email()
    {
        $email = $this->input->get('forgotemail');
		$numuserqryinactive = $this->Common_model->noof_records("customer_id","tbl_customers","email_id='$email' and status=0");
		$numuseractive = $this->Common_model->noof_records("customer_id","tbl_customers","email_id='$email' and status=1");
        if ($numuseractive > 0) {
           $row = $this->Common_model->get_records("*","tbl_customers","email_id='$email' and status=1","");
            foreach ($row as $rows) {
                $getcustid = $rows['customer_id'];
				$getcust_name = $rows['fullname'];
            }
            
            $getlink_id    = $this->getGUID();
            $getenclink_id = hash('sha1', $getlink_id);
            $curdatetime   = strtotime("now");
            $expdatetime   = strtotime('+1 day');
            
            $updatedata   = array(
                'temp_password' => $getenclink_id,
                'pwd_created' => $curdatetime
            );
            $updaterecord = $this->Common_model->update_records("tbl_customers",$updatedata,"customer_id=$getcustid");
            
            $linktomail = base_url() . 'forgot_password?id=' . $getlink_id;
            if ($updaterecord) {
               $company_mail = $this->Common_model->show_parameter(2);
				/** Start - Sending Mail **/
			    
			    	$mailconfig = Array(
					'mailtype' => 'html',
					'charset' => 'iso-8859-1',
					'wordwrap' => TRUE,
					'newline'=>'\n',
					'crlf'=>'\n'
				);
				
				$mailcontent = "<!doctype html>
				<html>
				<head>
					<meta charset='utf-8'>
				</head>
				<body style='font-family:sans-serif;font-size:13px; line-height:22px;'>
				<div style='width: 100%;background:#f5f5f5;color: #000;'> 
				<div style='padding:30px 30px 60px 30px;'>       
				  <div style='text-align:center'><a href='".base_url()."'><img src='".base_url()."assets/images/logo.png' style='margin:auto; margin-top:12px; margin-bottom:12px'></a>
				  </div>

				 <div style='background-color:#FFF;border:#EAEAEA 1px solid; padding:15px;'>
					<p style='margin-top:30px;'>
						Dear $getcust_name, <br><br>
						Recently a request was submitted to reset your password. If you did not request this, please ignore this email. It will expire and become useless in 24 hours time.<br><br>
						
						To reset your password, please visit the url below:<br>
						<a href='$linktomail'>$linktomail</a><br>
						When you visit the link above, you will have the opportunity to choose a new password.
					</p>
					
				  	<div style='line-height:25px; margin-top:20px'>
						<div>Sincerely,</div>
						<div>Organic</div>
				 	</div>
				 </div>
					 
				  </div>        
				</div>

				</body>";
				
				$subject = "Password Reset E-mail";
				$from_mail = $this->Common_model->show_parameter(9);
				
			 //   $this->load->library('email', $mailconfig);
    //             $this->email->from($from_mail, "Holidays");
    //             $this->email->to($email);
    //             $this->email->subject($subject);
    //             $this->email->message($mailcontent);
    //             @$this->email->send();
                
                
                $headers = 'From:  myholidayhappiness.com <'.$from_mail.">\r\n" .
                        
                        'X-Mailer: PHP/' . phpversion();
                 $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";   
                mail($email, $subject, $mailcontent, $headers);
                
                
                // echo $mailcontent; 
                /** End - Send Mail **/

                 echo 1;
                 //echo "one" ;
                //echo "<div class='successmsg notification'><i class='fa fa-check'></i> A link has been sent to your Email ID to change your password. </div>";
            } else {
                echo 2;
            	//echo "two";
                //echo "<div class='errormsg notification'><i class='fa fa-times'></i> Unable to process your request.</div>";
            }

        } else if ($numuserqryinactive > 0) {
            echo 3;
            //echo "<div class='errormsg notification'><i class='fa fa-times'></i> This email id is inactive.</div>";
        } else {
            echo 4;
           // echo "<div class='errormsg notification'><i class='fa fa-times'></i> Invalid email id.</div>";
        }
    //exit();
    }

    public function booking_login()
	{
		$recaptchaResponse = $this->Common_model->verifyCaptcha($this->input->post('g-recaptcha-response'));

		if (!$recaptchaResponse) {
			echo "captcha-error";
			exit();
		}
		
		$this->form_validation->set_rules('login_email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('login_password','Password','trim|required');

		$login_email = trim($this->input->post('login_email'));
		$login_password = $this->input->post('login_password');

		if($this->form_validation->run() == false){
			echo "error";
			exit;
		}
		
		if( ($login_email != '') && ($login_password != ''))
		{
			$hasingpwd=$this->Common_model->showname_fromid("password","tbl_customers","email_id='$login_email' and status=1");
			if(password_verify("$login_password", $hasingpwd))
			{
				$checkdb = $this->Common_model->get_records("customer_id, fullname, email_id","tbl_customers","email_id='$login_email' and status=1","","1");
				$sess_array = array();
				foreach($checkdb as $row)
				{
					$customer_id = $row['customer_id'];
					$fullname = $row['fullname'];
					$email_id = $row['email_id'];
				}
				
				$sess_array = array(
					'customer_id' => $customer_id,
					'fullname' => $fullname,
					'email_id' => $email_id,
					'sess_id' => session_id()						
				);
				$this->session->set_userdata($sess_array);
				echo "success";
			}
			else
			{
				echo "error";
			}
		}
		else
		{
			echo "error";
		}
		exit();
	}
	
    public function getGUID() //Generate GUID - Global unique Identifier
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }        
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

}
