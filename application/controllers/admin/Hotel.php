<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hotel extends CI_Controller {

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

		if($this->session->userdata('userid') == "")
		{
			redirect(base_url().'admin/logout','refresh');
		}
		
		$allusermodules = $this->session->userdata('allpermittedmodules');
		if(!(in_array(12, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
			
		}
 	}


	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		//$data['row'] = $this->Common_model->get_records("*","tbl_hotel","", " hotel_id DESC","","");
		$this->load->view('admin/manage_hotel', $data);
	}

	public function datatable(){
		$arrPageData = $_REQUEST;
		$hotel_name = isset($arrPageData['hotel_name']) ? $arrPageData['hotel_name'] : "";
		$destination_name = isset($arrPageData['destination_name']) ? $arrPageData['destination_name'] : 0;
		$hotel_type = isset($arrPageData['hotel_type']) ? $arrPageData['hotel_type'] : 0;
		$t_status = isset($arrPageData['t_status']) ? $arrPageData['t_status'] : 0;
		$whereCond = '';
		if($hotel_name != ''){
			$whereCond .= "(hotel_name like '%".$hotel_name."%') and ";
		}
		if($destination_name > 0){
			$whereCond .= "destination_name = $destination_name and ";
		}
		if($hotel_type > 0){
			$whereCond .= "hotel_type = $hotel_type and ";
		}
		if($t_status > 0){
			if($t_status == 1){
				$whereCond .= "status = $t_status and ";
			} else {
				$whereCond .= "status = 0 and";
			}
		}
		$whereCond = rtrim($whereCond, " and ");
 
		$rowCnt = $this->Common_model->noof_records("hotel_id","tbl_hotel","$whereCond");
		if ($arrPageData['length'] == -1) {
			$rows = $this->Common_model->get_records("*","tbl_hotel","$whereCond", " hotel_id DESC");
		} else {
			$rows = $this->Common_model->get_records("*","tbl_hotel","$whereCond", " hotel_id DESC",$arrPageData['length'], $arrPageData['start']);
		}

		if(!empty($rows) && count((array)$rows) > 0) {
			foreach ($rows as $key => $val) {
				$rows[$key]['sl_no'] = ++$arrPageData['start'];

				$rows[$key]['destination_name'] = $this->Common_model->showname_fromid("destination_name","tbl_destination","destination_id='".$rows[$key]['destination_name']."'");
				$rows[$key]['hotel_type_name'] = $this->Common_model->showname_fromid("hotel_type_name","tbl_hotel_type","hotel_type_id='".$rows[$key]['hotel_type']."'");
			}
		} else {
			$rows = [];
		}
	
		echo json_encode([
            'draw' => isset($arrPageData['draw']) ? intval($arrPageData['draw']) : 0,
            'recordsTotal' => $rowCnt,
            // 'whereCond' => $whereCond,
            'recordsFiltered' => $rowCnt, // For simplicity, assuming no filtering
            'data' => $rows
        ]);
		exit;
	}

	public function add()
	{
		$data['message'] = $this->session->flashdata('message');		
		if (isset($_POST['btnSubmit']) && !empty($_POST))
		{
			$this->form_validation->set_rules('hotel_name', 'Hotel Name', 'trim|required|xss_clean');			
			$sess_userid = $this->session->userdata('userid');
			$date = date("Y-m-d H:i:s");
			if ($this->form_validation->run() == true)
			{				
				$hname 		= $this->input->post('hotel_name');
				$destname	= $this->input->post('destination_name');
				$htype		= $this->input->post('hotel_type');
				$hdprice 	= $this->input->post('default_price');
				
				$room_type		= $this->input->post('room_type');
				$trip_url		= $this->input->post('trip_url');
				$star_ratings 	= $this->input->post('star_ratings');
				
			 $noof_duprec = $this->Common_model->noof_records("hotel_id","tbl_hotel","hotel_name = '$hname' and destination_name = '$destname'");
			 
			  if($noof_duprec < 1)	{	
				
				$insert_data = array(
					'hotel_name'		    => $hname ,
					'destination_name'	    => $destname,
					'hotel_type'		    => $htype,
                    'default_price'		    => $hdprice,
					'room_type'	   			=> $room_type,
					'trip_advisor_url'		=> $trip_url,
                    'star_rating'		    => $star_ratings,
					'status'		        => 1,
					'created_by'	        => $sess_userid,
					'created_date'	        => $date
				);
								
				$insertdb = $this->Common_model->insert_records('tbl_hotel', $insert_data);
				
				if($insertdb) 
				{                        
                        $last_id = $this->db->insert_id();				
				        $hseasontype= $this->input->post('season_type');
						$fsmonth    = $this->input->post('from_startmonth');
						$femonth    = $this->input->post('from_endmonth');
						$fsdate     = $this->input->post('from_startdate');
						$fedate     = $this->input->post('from_enddate');
						$haprice    = $this->input->post('adult_price');
						$hcprice    = $this->input->post('couple_price');
						$hkprice    = $this->input->post('kid_price');
						$haeprice   = $this->input->post('adult_extra');
				     
					 if(count($fsmonth)>0)
					 {
							for ( $i = 0; $i < count($fsmonth); $i++ )
							{

								$hseasontype_row = $hseasontype[$i];
								$fsmonth_row   	 = $fsmonth[$i];
								$femonth_row     = $femonth[$i];
								$fsdate_row = $fsdate[$i];
								$fedate_row = $fedate[$i];
								$haprice_row = $haprice[$i];
								$hcprice_row = $hcprice[$i];
								$hkprice_row = $hkprice[$i];
								$haeprice_row = $haeprice[$i];							
						
									$query_data = array(
										'hotel_id'		        => $last_id,
										'season_type'		    => $hseasontype_row,
										'sesonstart_month'      => $fsmonth_row,
										'sesonend_month'        => $femonth_row,
										'sesonstart_day'        => $fsdate_row,
										'sesonend_day'          => $fedate_row,						
										'adult_price'	        => $haprice_row, 
										'couple_price'	        => $hcprice_row,  	
										'kid_price'	            => $hkprice_row,
										'adult_extra'	        => $haeprice_row,
										'status'	            => 1,                    
										'created_date'		    => $date,
										'created_by'		    => $sess_userid
									);
									
							$querydb = $this->Common_model->insert_records('tbl_season', $query_data);
						
							}
						
						}
					
					$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Hotel added successfully.</div>');
				}
				else
				{
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> User could not added. Please try again.</div>');
				}
				
			} else {
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added this hotel to this destination .</div>');
			}
				redirect(base_url().'admin/hotel/add','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		$this->load->view('admin/add_hotel',$data);
	}

	public function edit()
	{
		$editid = $this->uri->segment(4);	
		$data['message'] = $this->session->flashdata('message');	
		$data['messageseas'] = $this->session->flashdata('messageseas');		
			if($editid > 0){
				$data['row'] = $this->Common_model->get_records("*","tbl_hotel","hotel_id='$editid'","");
	    	}
	    	
			if (isset($_POST['btnSubmit']) && !empty($_POST))
			{
				$this->form_validation->set_rules('hotel_name', 'Hotel Name', 'trim|required|xss_clean');
				$sess_userid = $this->session->userdata('userid');
				$date = date("Y-m-d H:i:s");
				if ($this->form_validation->run() == true)
				{
					$hname 		= $this->input->post('hotel_name');
					$destname	= $this->input->post('destination_name');
					$htype		= $this->input->post('hotel_type');
					$hdprice 	= $this->input->post('default_price');
					
					$room_type		= $this->input->post('room_type');
					$trip_url		= $this->input->post('trip_url');
					$star_ratings 	= $this->input->post('star_ratings');
					
					$update_data = array(
						'hotel_name'		    => $hname ,
						'destination_name'	    => $destname,
						'hotel_type'		    => $htype,
						'default_price'		    => $hdprice,
						'room_type'	   			=> $room_type,
						'trip_advisor_url'		=> $trip_url,
						'star_rating'		    => $star_ratings,
						'status'		        => 1,
						'created_by'	        => $sess_userid,
						'created_date'	        => $date
					);
						
					$updatedb = $this->Common_model->update_records('tbl_hotel',$update_data,"hotel_id=$editid");
					if($updatedb)
					{						
						$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Hotel edited successfully.</div>');
					}
					else
					{	
						$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Hotel could not edited. Please try again.</div>');
					}
					
					redirect(base_url().'admin/hotel/edit/'.$editid,'refresh');
				}
				else
				{
					$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				}
			}		
			
			
			/*****************************************Add season price********************************************/
			
			
			if (isset($_POST['btnAddseas']) && !empty($_POST))
			{	
				
				
				$this->form_validation->set_rules('season_type[]',     'season type.', 'trim|required|xss_clean');
				$this->form_validation->set_rules('from_startmonth[]', 'from smonth.', 'trim|required|xss_clean');
				$this->form_validation->set_rules('from_endmonth[]',   'from emonth.', 'trim|required|xss_clean');
				$this->form_validation->set_rules('from_startdate[]',  'from sdate.', 'trim|required|xss_clean');
				$this->form_validation->set_rules('from_enddate[]',    'from edate.', 'trim|required|xss_clean');
				$this->form_validation->set_rules('adult_price[]',     'adult price.', 'trim|required|xss_clean');
				$this->form_validation->set_rules('couple_price[]',    'couple price.', 'trim|required|xss_clean');
				$this->form_validation->set_rules('kid_price[]',       'kid price.', 'trim|required|xss_clean');
				$this->form_validation->set_rules('adult_extra[]',     'adult extra.', 'trim|required|xss_clean');
				
				$sess_userid = $this->session->userdata('userid');
				$date = date("Y-m-d H:i:s");
					
				if ($this->form_validation->run() == true)
				{
						
					$hseasontype= $this->input->post('season_type');
					$fsmonth    = $this->input->post('from_startmonth');
					$femonth    = $this->input->post('from_endmonth');
					$fsdate     = $this->input->post('from_startdate');
					$fedate     = $this->input->post('from_enddate');
					$haprice    = $this->input->post('adult_price');
					
					$hcprice    = $this->input->post('couple_price');
					$hkprice    = $this->input->post('kid_price');
					$haeprice   = $this->input->post('adult_extra');
					
						 
						 if(count($fsmonth)>0)
						 {
								for ( $i = 0; $i < count($fsmonth); $i++ )
								{

									$hseasontype_row = $hseasontype[$i];
									$fsmonth_row   	 = $fsmonth[$i];
									$femonth_row     = $femonth[$i];
									$fsdate_row = $fsdate[$i];
									$fedate_row = $fedate[$i];
									$haprice_row = $haprice[$i];
									$hcprice_row = $hcprice[$i];
									$hkprice_row = $hkprice[$i];
									$haeprice_row = $haeprice[$i];							
							
										$query_data = array(
											'hotel_id'		        => $editid,
											'season_type'		    => $hseasontype_row,
											'sesonstart_month'      => $fsmonth_row,
											'sesonend_month'        => $femonth_row,
											'sesonstart_day'        => $fsdate_row,
											'sesonend_day'          => $fedate_row,						
											'adult_price'	        => $haprice_row, 
											'couple_price'	        => $hcprice_row,  	
											'kid_price'	            => $hkprice_row,
											'adult_extra'	        => $haeprice_row,
											'status'	            => 1,                    
											'created_date'		    => $date,
											'created_by'		    => $sess_userid
										);
										
								$querydb = $this->Common_model->insert_records('tbl_season', $query_data);
							
								}
									$this->session->set_flashdata('messageseas','<div class="successmsg notification"><i class="fa fa-check"></i> Season price added successfully.</div>');					
								}
								else
								{
									$this->session->set_flashdata('messageseas','<div class="errormsg notification"><i class="fa fa-times"></i> Season price could not edited, please try again.</div>');
								}
								redirect(base_url().'admin/hotel/edit/'.$editid,'refresh');
				}
				else
				{
					$data['messageseas'] = (validation_errors() ? validation_errors() : $this->session->flashdata('messageseas'));
				}
			} 
			
			
		$this->load->view('admin/edit_hotel',$data);
	}





	public function delete_hotel()
	{
		$delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("hotel_id","tbl_hotel","hotel_id='$delid'");
		if($noof_rec>0)
		{	
			$del = $this->Common_model->delete_records("tbl_hotel","hotel_id=$delid");
			if($del)
			{
				$del_season_tbl = $this->Common_model->delete_records("tbl_season","hotel_id=$delid");
				
					$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Hotel has been deleted successfully.</div>');
				
			}
			else
			{
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Hotel could not deleted. Please try again.</div>');
			}
		}
		redirect(base_url().'admin/hotel','refresh');
	}



	public function delete_season()	
	{
		$hotelid = $this->uri->segment(4);
		$delid = $this->uri->segment(5);
		$noof_rec = $this->Common_model->noof_records("season_id","tbl_season","season_id='$delid'");
		if($noof_rec>0)		
		{
            
			$del = $this->Common_model->delete_records("tbl_season","season_id=$delid");
			if($del)
			{
				
				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i>season price has been deleted  successfully.</div>');
			}
			else{
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i>season price could not deleted. Please try again.</div>');
			}
		}
		redirect(base_url().'admin/hotel/edit/'.$hotelid,'refresh');
	}



	public function edit_season()
	{
		$editid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("season_id","tbl_season","season_id='$editid'");
		if($noof_rec>0)
		{
			$data['message'] = $this->session->flashdata('message');
			$data['row'] = $this->Common_model->get_records("*","tbl_season","season_id=$editid","");
			if (isset($_POST['btnSubmit']) && !empty($_POST))
			{
				$this->form_validation->set_rules('season_type',     'season type.', 'trim|required|xss_clean');
				$this->form_validation->set_rules('from_startmonth', 'from smonth.', 'trim|required|xss_clean');
				$this->form_validation->set_rules('from_endmonth',   'from emonth.', 'trim|required|xss_clean');
				$this->form_validation->set_rules('from_startdate',  'from sdate.', 'trim|required|xss_clean');
				$this->form_validation->set_rules('from_enddate',    'from edate.', 'trim|required|xss_clean');
				$this->form_validation->set_rules('adult_price',     'adult price.', 'trim|required|xss_clean');
				$this->form_validation->set_rules('couple_price',    'couple price.', 'trim|required|xss_clean');
				$this->form_validation->set_rules('kid_price',       'kid price.', 'trim|required|xss_clean');
				$this->form_validation->set_rules('adult_extra',     'adult extra.', 'trim|required|xss_clean');

                $date = date("Y-m-d H:i:s");
                $sess_userid = $this->session->userdata('userid');
                if ($this->form_validation->run() == true)
				{	

					$season_type = $this->input->post('season_type');
					$from_startmonth = $this->input->post('from_startmonth');
					$from_endmonth = $this->input->post('from_endmonth');
					$from_startdate = $this->input->post('from_startdate');
					$from_enddate = $this->input->post('from_enddate');
					$adult_price = $this->input->post('adult_price');
					$couple_price = $this->input->post('couple_price');
					$kid_price = $this->input->post('kid_price');
					$adult_extra = $this->input->post('adult_extra');
					
					
					$update_data = array(
						'season_type' 	        => $season_type,
						'sesonstart_month'		=> $from_startmonth,
						'sesonend_month'		=> $from_endmonth,
						'sesonstart_day'		=> $from_startdate,
						'sesonend_day' 	        => $from_enddate,
						'adult_price'		    => $adult_price,
						'couple_price'			=> $couple_price,
						'kid_price'			    => $kid_price,
						'adult_extra'			=> $adult_extra,
						'updated_date'			=> $date,
						'updated_by'			=> $sess_userid

					);
							
					$updatedb = $this->Common_model->update_records('tbl_season',$update_data,"season_id=$editid");
					if($updatedb)
					{
						$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Season price edited successfully.</div>');
					}
					else
					{
						$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Season price could not edited. Please try again.</div>');
					}
					
					redirect(base_url().'admin/hotel/edit_season/'.$editid,'refresh');
				}
				else
				{					
					$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				}
			}
			$this->load->view('admin/edit_season', $data);
		}
		else
			redirect(base_url().'admin/hotel','refresh');
	}




	public function changestatus()
	{
		$stsid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("hotel_id","tbl_hotel","hotel_id='$stsid' ");
		if($noof_rec>0)
		{			
			$status = $this->Common_model->showname_fromid("status","tbl_hotel","hotel_id=$stsid");
			if($status==1)
				$updatedata = array('status' => 0);
			else
				$updatedata = array('status' => 1);
			$updatestatus = $this->Common_model->update_records("tbl_hotel",$updatedata,"hotel_id=$stsid");
			if($updatestatus)
				echo $status;
			else
				echo "error";			
		}
		exit();
	}

	

	public function view()
	{
		$data['message'] = $this->session->flashdata('message');
		$viewid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("hotel_id","tbl_hotel","hotel_id='$viewid'");
		if($noof_rec>0)
		{
			$data['dstype'] = $this->Common_model->get_records("*","tbl_hotel","hotel_id=$viewid","");
			
			 //$data['dstype'] = $this->Common_model->join_records("a.*, b.*", "tbl_hotel as a", "tbl_season as b", "a.hotel_id=b.hotel_id", "b.hotel_id = $viewid", "a.hotel_id desc");	
			 //print_r($data['dstype']); exit;
			  
			$this->load->view('admin/view_hotel',$data);
		}
	}












}
 
	
