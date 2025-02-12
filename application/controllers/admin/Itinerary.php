<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itinerary extends CI_Controller {

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
		if(!(in_array(11, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}
 	}

	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		// $data['row'] = $this->Common_model->get_records("*","tbl_itinerary","", " itinerary_id DESC","","");
		$this->load->view('admin/manage_itinerary',$data);
	}

	public function datatable(){
		$arrPageData = $_REQUEST;
		$itinerary_name = isset($arrPageData['itinerary_name']) ? $arrPageData['itinerary_name'] : "";
		$starting_city = isset($arrPageData['starting_city']) ? $arrPageData['starting_city'] : 0;
		$trip_duration = isset($arrPageData['trip_duration']) ? $arrPageData['trip_duration'] : 0;
		$ratings = isset($arrPageData['ratings']) ? $arrPageData['ratings'] : 0;
		$whereCond = '';
		if($itinerary_name != ''){
			$whereCond .= "(itinerary_name like '%".$itinerary_name."%') and ";
		}
		if($starting_city > 0){
			$whereCond .= "starting_city = $starting_city and ";
		}
		if($trip_duration > 0){
			$whereCond .= "iti_duration = $trip_duration and ";
		}
		if($ratings > 0){
			$whereCond .= "ratings = $ratings and ";
		}
		$whereCond = rtrim($whereCond, " and ");
 
		$rowCnt = $this->Common_model->noof_records("itinerary_id","tbl_itinerary","$whereCond");
		if ($arrPageData['length'] == -1) {
			$rows = $this->Common_model->get_records("*","tbl_itinerary","$whereCond", " itinerary_id DESC");
		} else {
			$rows = $this->Common_model->get_records("*","tbl_itinerary","$whereCond", " itinerary_id DESC",$arrPageData['length'], $arrPageData['start']);
		}

		if(!empty($rows) && count((array)$rows) > 0) {
			foreach ($rows as $key => $val) {
				$rows[$key]['sl_no'] = ++$arrPageData['start'];
				$iti_duration 	= $rows[$key]['iti_duration'];
				$itinerary_url 	= $rows[$key]['itinerary_url'];
				$rows[$key]['iti_ratings'] 	= $rows[$key]['ratings'];
				$rows[$key]['duration_name'] =$this->Common_model->showname_fromid("duration_name","tbl_package_duration","durationid='$iti_duration'");
				
				$iti_image = $rows[$key]['itineraryimg'];
				$iti_thumb = $rows[$key]['itinerarythumbimg'];
				$iti_starting_city = $rows[$key]['starting_city'];
				$rows[$key]['iti_starting_city_name'] = $this->Common_model->showname_fromid("destination_name","tbl_destination","destination_id=$iti_starting_city");
				
				$en_admin = $this->Common_model->encode("admin");

				$rows[$key]['itinerary_url'] = base_url().'itinerary/'.$itinerary_url.'/?preview='.$en_admin;
				$rows[$key]['iti_image'] = (file_exists("./uploads/".$iti_image) && ($iti_image!='')) ? base_url().'uploads/'.$iti_image : '';
				$rows[$key]['iti_thumb'] = (file_exists("./uploads/".$iti_thumb) && ($iti_thumb!='')) ? base_url().'uploads/'.$iti_thumb : '';
			}
		}
	
		echo json_encode([
            'draw' => isset($arrPageData['draw']) ? intval($arrPageData['draw']) : 0,
            'recordsTotal' => $rowCnt,
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
			$this->form_validation->set_rules('itinerary_name', 'Itinerary Name', 'trim|required|xss_clean|is_unique[tbl_itinerary.itinerary_name]');
			$this->form_validation->set_rules('itinerary_url', 'Itinerary Url', 'trim|required|xss_clean|is_unique[tbl_itinerary.itinerary_url]');
			$this->form_validation->set_rules('getplacetypeid[]', 'Place Type', 'trim|required|xss_clean');
			$this->form_validation->set_rules('duration', 'Trip Duration', 'trim|required|xss_clean');
			$this->form_validation->set_rules('starting_city', 'Starting city', 'trim|required|xss_clean');	
			
			$sess_userid = $this->session->userdata('userid');
			$date = date("Y-m-d H:i:s");
			if ($this->form_validation->run() == true)
			{
				$itinerary_name = $this->input->post('itinerary_name');
				$itinerary_url 	= $this->input->post('itinerary_url');
				$travel_mode 	= $this->input->post('travel_mode');
				$ideal_time 	= $this->input->post('ideal_time');
				$duration	    = $this->input->post('duration');
				$rating	        = $this->input->post('rating');				
				$show_in_home	= $this->input->post('show_in_home');
				$itineraryimg	= $this->input->post('itineraryimg');
				$itinerarythumbimg	= $this->input->post('itinerarythumbimg');
				$starting_city = $this->input->post('starting_city');
				$meta_title = $this->input->post('meta_title');	
				$meta_keywords = $this->input->post('meta_keywords');	
				$meta_description = $this->input->post('meta_description');	
                $alttag_banner 		= $this->input->post('alttag_banner');
                $alttag_thumb 		= $this->input->post('alttag_thumb');

			    $noof_duprec = $this->Common_model->noof_records("itinerary_id","tbl_itinerary","itinerary_name ='$itinerary_name' or itinerary_url = '$itinerary_url'");
			    $show_in_homenew = ($show_in_home > 0) ? $show_in_home : '0';			    			    
					 	
				if($noof_duprec < 1)
				{					
					/************For itinary Image***************/		
                    $imofilename = $this->Common_model->seo_friendly_url($alttag_banner);
                    $thumbfilename = $this->Common_model->seo_friendly_url($alttag_thumb);
				    if (isset($_FILES['itineraryimg']) && $_FILES['itineraryimg']['name'] != '') {
						$filename = $this->Common_model->ddoo_upload('itineraryimg', 2000 , 450, $imofilename);
					} else {
						$filename = NULL;
					} 
					
					if (isset($_FILES['itinerarythumbimg']) && $_FILES['itinerarythumbimg']['name'] != '') {
						$itinerarythumb_imgnew = $this->Common_model->thumbddoo_upload('itinerarythumbimg', 400 , 500, $thumbfilename);
					} else {
						$itinerarythumb_imgnew = NULL;
					} 
					
					/***************End of itinary image*********/			   
			   
					$insert_data = array(
						'itinerary_name'		=> $itinerary_name ,
						'itinerary_url'		    => $itinerary_url ,
						'ratings'		        => $rating,
						'iti_travelmode'	    => $travel_mode,
						'iti_idealstime'		=> $ideal_time,
						'iti_duration'	        => $duration,
						'itineraryimg'	        => $filename,
						'itinerarythumbimg'	    => $itinerarythumb_imgnew,
						'alttag_banner' 		=> $alttag_banner,
						'alttag_thumb'			=> $alttag_thumb,
						'starting_city' 		=> $starting_city,
						'status'		        => 1,
						'show_in_home'		    => $show_in_homenew,
						'created_by'	        => $sess_userid,						
						'meta_title'			=> $meta_title,
						'meta_keywords'			=> $meta_keywords,
						'meta_description'		=> $meta_description,
						'created_date'	        => $date
					);
				
					$insertdb = $this->Common_model->insert_records('tbl_itinerary', $insert_data);
					if($insertdb) 
					{
						$last_id = $this->db->insert_id();
						$getplacetypeid= $this->input->post('getplacetypeid');

						if(!empty($getplacetypeid)){
							foreach ( $getplacetypeid as $getplacetypeids ) {
								$insert_data = array(
									'itinerary_id' => $last_id ,
									'placetype_id' => $getplacetypeids
								);
								$insertdb = $this->Common_model->insert_records('tbl_itinerary_placetype', $insert_data);
							}
						}

						$getatagid= $this->input->post('getatagid');
						if(!empty($getatagid)){
							foreach ( $getatagid as $getatagids ) {
								$insert_data = array(
									'itinerary_id' => $last_id ,
									'tourtagid'	   => $getatagids
								);
								$insertdb = $this->Common_model->insert_records('tbl_itinerary_tourtags', $insert_data);
							}
						}

						$destination_id= $this->input->post('destination_id');
						$no_ofdays    = $this->input->post('no_ofdays');
						$no_ofnight    = $this->input->post('no_ofnight');
							
						if(count($destination_id) > 0)
						{
							for ( $i = 0; $i < count($destination_id); $i++ )
							{
								$destination_id_row = $destination_id[$i];
								$no_ofdays_row   	 = $no_ofdays[$i];
								$no_ofnight_row = $no_ofnight[$i];
								
								$query_data = array(
									'itinerary_id'		=> $last_id,
									'destination_id'	=> $destination_id_row,
									'noof_days'      	=> $no_ofdays_row,
									'noof_nights'       => $no_ofnight_row,                 
									'created_date'		=> $date,
									'created_by'		=> $sess_userid
								);
								$querydb = $this->Common_model->insert_records('tbl_itinerary_destination', $query_data);
							}
						}

						$title= $this->input->post('title');
						$place_id = $this->input->post('getplaceid');
						//$places =  implode(",",$place_id);
							
						if(count($title)>0)
						{
							for ( $k = 0; $k < count($title); $k++ )
							{
								$title_row  = $title[$k];
								$places_row = $place_id[$k];
								if(!empty($places_row))
									$places = implode(",",$places_row);
								else
									$places = NULL;
							
								$query_data = array(
									'itinerary_id'	=> $last_id,
									'title'		    => $title_row,
									'place_id'      => $places,      
									'created_date'	=> $date,
									'created_by'	=> $sess_userid
								);
								$querydb = $this->Common_model->insert_records('tbl_itinerary_daywise', $query_data);
						   }
						}							
						$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Itinerary added successfully.</div>');
					}
					else
					{
						$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Itinerary could not added. Please try again.</div>');
					}				
				} 
				else
				{
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added this itinerary, Itinerary name and Itinerary URL must be unique. </div>');
				}
				redirect(base_url().'admin/itinerary/add','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		$this->load->view('admin/add_itinerary',$data);
	}

	public function edit()
	{
		$editid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("itinerary_id","tbl_itinerary","itinerary_id='$editid' ");
		if($noof_rec>0)
		{
			$data['message'] = $this->session->flashdata('message');
			$data['edititerdatas'] = $this->Common_model->get_records("*","tbl_itinerary","itinerary_id='$editid'","");
			if (isset($_POST['btnSubmit']) && !empty($_POST))
			{
				$this->form_validation->set_rules('itinerary_name', 'Itinerary Name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('itinerary_url', 'Itinerary Url', 'trim|required|xss_clean');
				$this->form_validation->set_rules('getplacetypeid[]', 'Place Type', 'trim|required|xss_clean');
				$this->form_validation->set_rules('duration', 'Trip Duration', 'trim|required|xss_clean');	
				$this->form_validation->set_rules('starting_city', 'Starting city', 'trim|required|xss_clean');	

				$sess_userid = $this->session->userdata('userid');
				$date = date("Y-m-d H:i:s");
				
				if ($this->form_validation->run() == true)
				{		
					$itinerary_name = $this->input->post('itinerary_name');
					$itinerary_url = $this->input->post('itinerary_url');
					$travel_mode 	    = $this->input->post('travel_mode');
					$ideal_time 		= $this->input->post('ideal_time');
					$duration	        = $this->input->post('duration');
					$rating	        = $this->input->post('rating');
					$show_in_home	        = $this->input->post('show_in_home');
					$itineraryimg	        = $this->input->post('itineraryimg');
					$itinerarythumbimg	        = $this->input->post('itinerarythumbimg');	
					$starting_city = $this->input->post('starting_city');
					$meta_title = $this->input->post('meta_title');	
					$meta_keywords = $this->input->post('meta_keywords');	
					$meta_description = $this->input->post('meta_description');
					$alttag_banner 		= $this->input->post('alttag_banner');
					$alttag_thumb 		= $this->input->post('alttag_thumb');
						
					$noof_duprec = $this->Common_model->noof_records("itinerary_id","tbl_itinerary","(itinerary_name ='$itinerary_name' or itinerary_url = '$itinerary_url') and itinerary_id!='$editid'");
					$show_in_homenew = ($show_in_home > 0) ? $show_in_home : '0';
				
					if($noof_duprec < 1)
					{
						/************For itinary Image***************/	
						$imofilename = $this->Common_model->seo_friendly_url($alttag_banner);
						$thumbfilename = $this->Common_model->seo_friendly_url($alttag_thumb);
						$rimage = $this->Common_model->showname_fromid("itineraryimg","tbl_itinerary","itinerary_id='$editid'");
						if (isset($_FILES['itineraryimg']) && $_FILES['itineraryimg']['name'] != '') 
						{						
							$unlinkimage = getcwd().'/uploads/'.$rimage;							
							if (file_exists($unlinkimage) && !is_dir($unlinkimage))
							{
								unlink($unlinkimage);
							}							
							$filename = $this->Common_model->ddoo_upload('itineraryimg', 2000 , 450, $imofilename);							
						} else {
							$oldname_b = getcwd().'/uploads/'.$rimage;
							if(file_exists($oldname_b)) {
								$extensionBArr = explode(".", $rimage);
								$extensionB = end($extensionBArr);
								$newname_b = getcwd().'/uploads/'.$imofilename.'.'.$extensionB;
								rename($oldname_b, $newname_b);
								$filename = $imofilename.'.'.$extensionB;
							} else {
								$filename = $rimage;
							}
						}
							
						$rthumb_image = $this->Common_model->showname_fromid("itinerarythumbimg","tbl_itinerary","itinerary_id ='$editid'");
						if (isset($_FILES['itinerarythumbimg']) && $_FILES['itinerarythumbimg']['name'] != '') {						
							$unlinkimagethumb = getcwd().'/uploads/'.$rthumb_image;	
							if (file_exists($unlinkimagethumb) && !is_dir($unlinkimagethumb))
							{
								unlink($unlinkimagethumb);
							}							
							$itinerarythumb_imgnew = $this->Common_model->thumbddoo_upload('itinerarythumbimg', 400 , 500, $thumbfilename);							
						} else {
							$oldname = getcwd().'/uploads/'.$rthumb_image;
							if(file_exists($oldname)) {
								$extensionArr = explode(".", $rthumb_image);
								$extension = end($extensionArr);
								$newname = getcwd().'/uploads/'.$thumbfilename.'.'.$extension;
								rename($oldname, $newname);
								$itinerarythumb_imgnew = $thumbfilename.'.'.$extension;
							} else {
								$itinerarythumb_imgnew = $rthumb_image;
							}
						} 
						
						/***************End of itinary image*********/
										
						$update_data = array(
							'itinerary_name'		=> $itinerary_name ,
							'itinerary_url'		    => $itinerary_url ,
							'ratings'		        => $rating,
							'iti_travelmode'	    => $travel_mode,
							'iti_idealstime'		=> $ideal_time,
							'iti_duration'	        => $duration,					
							'itineraryimg'	        => $filename,					
							'itinerarythumbimg'	    => $itinerarythumb_imgnew,
							'alttag_banner' 		=> $alttag_banner,
							'alttag_thumb' 			=> $alttag_thumb,
							'starting_city' 		=> $starting_city,
							'show_in_home'	        => $show_in_homenew,
							'updated_by'	        => $sess_userid,							
							'meta_title'			=> $meta_title,
							'meta_keywords'			=> $meta_keywords,
							'meta_description'		=> $meta_description,
							'updated_date'	        => $date
						);						
							
						$updatedb = $this->Common_model->update_records('tbl_itinerary',$update_data,"itinerary_id=$editid");
						if($updatedb)
						{	
							$getplacetypeid = $this->input->post('getplacetypeid');                    
							$this->Common_model->delete_records("tbl_itinerary_placetype", "itinerary_id = $editid");

							if(!empty($getplacetypeid)) {
								foreach ( $getplacetypeid as $getplacetypeids ) {
									$insert_data = array(
										'itinerary_id' => $editid ,
										'placetype_id' => $getplacetypeids,
									);
									$insertdb = $this->Common_model->insert_records('tbl_itinerary_placetype', $insert_data);
								}
							}							
					
							$getatagid = $this->input->post('getatagid');                    
							$this->Common_model->delete_records("tbl_itinerary_tourtags", "itinerary_id = $editid");

							if(!empty($getatagid)) {
								foreach ( $getatagid as $getatagids ) {
									$insert_data = array(
									'itinerary_id' => $editid ,
									'tourtagid'	   => $getatagids,
									);
									$insertdb = $this->Common_model->insert_records('tbl_itinerary_tourtags', $insert_data);
								}
							}
							
							/* for Associated destinations */
							$destination_id= $this->input->post('destination_id');
							$no_ofdays    = $this->input->post('no_ofdays');
							$no_ofnight    = $this->input->post('no_ofnight');							
							
							if(count($destination_id)>0)
							{
								$this->Common_model->delete_records("tbl_itinerary_destination", "itinerary_id = $editid");	
								for ( $i = 0; $i < count($destination_id); $i++ )
								{
									$destination_id_row = $destination_id[$i];
									$no_ofdays_row   	 = $no_ofdays[$i];
									$no_ofnight_row = $no_ofnight[$i];
									
										$query_data = array(
											'itinerary_id'		    => $editid,
											'destination_id'		=> $destination_id_row,
											'noof_days'             => $no_ofdays_row,
											'noof_nights'           => $no_ofnight_row,
											'created_date'		    => $date,
											'created_by'		    => $sess_userid
										);
									$querydb = $this->Common_model->insert_records('tbl_itinerary_destination', $query_data);							
								}
							}

							/* for Day Wise */	
							$title = $this->input->post('title');
							$place_id = $this->input->post('getplaceid');
					        $otherIternaryPlaces = $this->input->post('otherIternaryPlaces');
							if(count($title)>0)
							{
								$this->Common_model->delete_records("tbl_itinerary_daywise", "itinerary_id = $editid");	
								for ( $k = 0; $k < count($title); $k++ )
								{
									$title_row  = $title[$k];
									$places_row = $place_id[$k];
									
									if(!empty($places_row))
										$places = implode(",",$places_row);
									else
										$places = NULL;
									
									$query_data1 = array(
										'itinerary_id'		    => $editid,
										'title'		            => $title_row,
										'place_id'              => $places,      
										'created_date'		    => $date,
										'created_by'		    => $sess_userid,
										'other_iternary_places'   => $otherIternaryPlaces[$k]
									);
									
									$querydb = $this->Common_model->insert_records('tbl_itinerary_daywise', $query_data1);
								} 
							}
							
							$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Itinerary edited successfully, tap view to see the details.</div>');
						} else
						{	
							$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Itinerary could not edited. Please try again.</div>');
						}
					} 
					else
					{
						$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added a itinerary with this name. </div>');
					}
					redirect(base_url().'admin/itinerary/edit/'.$editid,'refresh');		
				}
				else
				{
					//set the flash data error message if there is one
					$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				}
			}
			$this->load->view('admin/edit_itinerary', $data);
		}
		else
			redirect(base_url().'admin/itinerary','refresh');
	}


	public function delete()
	{
		$delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("itinerary_id","tbl_itinerary","itinerary_id='$delid'");
		if($noof_rec>0)
		{
			$itiimo = $this->Common_model->showname_fromid("itineraryimg","tbl_itinerary","itinerary_id=$delid");				
			$iti_thumb_imo = $this->Common_model->showname_fromid("itinerarythumbimg","tbl_itinerary","itinerary_id=$delid");				
			$unlinkimage = getcwd().'/uploads/'.$itiimo;
			$unlink_thumb_image = getcwd().'/uploads/'.$iti_thumb_imo;	
														
			if (file_exists($unlinkimage) && !is_dir($unlinkimage))
			{
				unlink($unlinkimage);
			}
			if (file_exists($unlink_thumb_image) && !is_dir($unlink_thumb_image))
			{
				unlink($unlink_thumb_image);
			}
			$this->Common_model->delete_records("tbl_itinerary_tourtags","itinerary_id=$delid");
			$this->Common_model->delete_records("tbl_itinerary_placetype","itinerary_id=$delid");
			$this->Common_model->delete_records("tbl_itinerary_daywise","itinerary_id=$delid");
			$this->Common_model->delete_records("tbl_itinerary_destination","itinerary_id=$delid");
			$del = $this->Common_model->delete_records("tbl_itinerary","itinerary_id=$delid");
			if($del)
			{
				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Itinerary has been deleted successfully.</div>');
			}
			else
			{
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Itinerary could not deleted. Please try again.</div>');
			}
		}
		redirect(base_url().'admin/itinerary','refresh');
	}


	public function changestatus()
	{
		$stsid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("itinerary_id","tbl_itinerary","itinerary_id='$stsid' ");
		if($noof_rec>0)
		{			
			$status = $this->Common_model->showname_fromid("status","tbl_itinerary","itinerary_id=$stsid");
			if($status==1)
				$updatedata = array('status' => 0);
			else
				$updatedata = array('status' => 1);
			$updatestatus = $this->Common_model->update_records("tbl_itinerary",$updatedata,"itinerary_id=$stsid");
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
		$noof_rec = $this->Common_model->noof_records("itinerary_id","tbl_itinerary","itinerary_id='$viewid'");
		if($noof_rec>0)
		{
			$data['itinerary'] = $this->Common_model->get_records("*","tbl_itinerary","itinerary_id=$viewid","");
			$this->load->view('admin/view_itinerary',$data);
		}
	}


	public function getdaywise()
	{
		$durationid=$this->uri->segment(4);
		//$durationid=$_REQUEST['durationid'];
		$noof_rec = $this->Common_model->noof_records("durationid","tbl_package_duration","durationid='$durationid'");
		$noofday=$this->Common_model->showname_fromid("no_ofdays","tbl_package_duration","durationid='$durationid'");
		if($noof_rec > 0)
		{ 
			$get_place = $this->Common_model->get_records("placeid, place_name", "tbl_places", "status = '1' ", "place_name asc", "");
	?>
		<div class="box-main">
			<h3>Iternary Details</h3> 
			<div class="col-md-12">
				<!-- <div class="col-md-12 dest-title"> <label> Day Wise : </label> </div> -->
				<?php $arr=0; for ($i = 1; $i <= $noofday ; $i++) { ?>
					<div class="row mb10">                                                  
						<div class="col-md-1">
							<?php if($i == 1) { ?><label> Day </label> <br><?php } ?>
							<label>  <?php echo $i; ?>: </label>
						</div>
					
						<div class="col-md-6">
							<?php if($i == 1) { ?> <label>Iternary Title</label> <?php } ?>
							<input type="text" class="form-control" placeholder="Iternary Title" name="title[]" id="title" value="<?php echo set_value('title[]'); ?>">
						</div>

						<div class="col-md-5" >
							<?php if($i == 1) { ?> <label>Iternary places</label> <?php } ?>							
							<select data-placeholder="Choose iternary places" class="chosen-select" multiple tabindex="4" id="getplaceid_<?php echo $i; ?>"  name="getplaceid[<?php echo $arr; ?>][]" style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
								<?php foreach ($get_place as $get_places) { ?>
								<option value="<?php echo $get_places['placeid']; ?>"><?php echo $get_places['place_name']; ?></option>
								<?php } ?>
							</select>
							
							 <input type="text" class="form-control" style="margin-top:5px" placeholder="Iternary Places" name="otherIternaryPlaces[]" id="otherIternaryPlaces_<?php echo $i; ?>" >				 
						
						</div>                                                               
					</div>
					<div class="clearfix"></div> 
				<?php $arr++; } ?>
			</div>
		</div> 
		<script type="text/javascript">
			$(document).ready(function(){
				<?php for ($i = 1; $i <= $noofday ; $i++) { ?>
				$("#getplaceid_<?php echo $i; ?>").chosen();
				<?php }  ?>
			});
		</script>
	<?php  	
		} 
		exit();
	}

	
	public function editdaywise()
	{
		$durationid = $this->uri->segment(4);
		$itinerary_id = $this->uri->segment(5);
		$noof_rec = $this->Common_model->noof_records("durationid","tbl_package_duration","durationid='$durationid'");
		$noofday=$this->Common_model->showname_fromid("no_ofdays","tbl_package_duration","durationid='$durationid'");
		if($noof_rec > 0)
		{ 
			$get_place = $this->Common_model->get_records("placeid, place_name", "tbl_places", "status = '1' ", "place_name asc", "");
			$edit_iternary = $this->Common_model->get_records("*","tbl_itinerary_daywise","itinerary_id='$itinerary_id'","itinerary_daywiseid asc");
	?>
		<div class="box-main">
			<h3>Iternary Details</h3> 
			<div class="col-md-12">
				<!-- <div class="col-md-12 dest-title"> <label> Day Wise : </label> </div> -->
				<?php $arr=0; for ($i = 1; $i <= $noofday ; $i++) { ?>
					<div class="row mb10">                                                  
						<div class="col-md-1">
							<?php if($i == 1) { ?><label> Day </label> <br><?php } ?>
							<label>  <?php echo $i; ?>: </label>
						</div>
					
						<div class="col-md-6">
							<?php if($i == 1) { ?> <label>Iternary Title</label> <?php } ?>
							<?php 
								$iternary_title = (array_key_exists($arr, $edit_iternary))? $edit_iternary[$arr]['title']:"";
								$iternary_other_places = (array_key_exists($arr, $edit_iternary))? $edit_iternary[$arr]['other_iternary_places']:"";
							?>
							<input type="text" class="form-control" placeholder="Iternary Title" name="title[]" id="title" value="<?php echo set_value('title[]', $iternary_title); ?>">
						</div>

						<div class="col-md-5" >
							<?php if($i == 1) { ?> <label>Iternary places</label> <?php } ?>							
							<select data-placeholder="Choose iternary places" class="chosen-select" multiple tabindex="4" id="getplaceid_<?php echo $i; ?>"  name="getplaceid[<?php echo $arr; ?>][]" style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
								<?php foreach ($get_place as $get_places) { ?>
								<option value="<?php echo $get_places['placeid']; ?>"><?php echo $get_places['place_name']; ?></option>
								<?php } ?>
							</select>		
							 <input type="text" class="form-control" style="margin-top:5px"  placeholder="Iternary Places" name="otherIternaryPlaces[]" id="otherIternaryPlaces_<?php echo $i; ?>" value="<?php echo set_value('other_iternary_places[]',$iternary_other_places); ?>">				 
						
						</div>                                                               
					</div>
					<div class="clearfix"></div> 
				<?php $arr++; } ?>
			</div>
		</div> 
		<script type="text/javascript">
			$(document).ready(function(){
				<?php $arr1=0; for ($i = 1; $i <= $noofday ; $i++) { ?>
					$("#getplaceid_<?php echo $i; ?>").chosen();
				
					<?php 
						$iternary_place = (array_key_exists($arr1, $edit_iternary))? $edit_iternary[$arr1]['place_id']:"";
						if($iternary_place !="")
						{							
					?>
					var tag_params = "<?php echo $iternary_place ?>";
                    var rstr = tag_params.replace(/,\s*$/, ""); //remove last comma from string
                    var tag_array_data = rstr.split(",");
                    $.each(tag_array_data, function (index, val) {
                        $("#getplaceid_<?php echo $i; ?> option[value=" + val + "]").attr('selected', 'selected');
                    });
                    $("#getplaceid_<?php echo $i; ?>").trigger('chosen:updated');
					<?php } ?>
				<?php $arr1++; } ?>
			});
		</script>
	<?php  	
		} 
		exit();
	}
	
	 
	public function mark_as_featured()
    {
        $t_id = $this->input->post('tid');        
        $noof_rec = $this->Common_model->noof_records("itinerary_id", "tbl_itinerary", "itinerary_id='$t_id' and status=1 and is_featured = 0");
        if ($noof_rec > 0) {
            $query_data = array(
                'is_featured' => '1'
            );
            $querydb    = $this->Common_model->update_records('tbl_itinerary', $query_data, "itinerary_id='$t_id'");
            if ($querydb) {
                echo '<div class="successmsg"><i class="fa fa-check"></i> Itinerary featured successfully.</div>';
            } else {
                echo '<div class="errormsg"><i class="fa fa-check"></i> Itinerary could not featured.</div>';
            }
        } else {
            echo '<div class="errormsg"><i class="fa fa-check"></i> Either the Itinerary deactivated or not found.</div>';
        }
        exit();
    }  
	
    
	public function mark_as_unfeatured()
    {
        $t_id = $this->input->post('tid');        
        $noof_rec = $this->Common_model->noof_records("itinerary_id", "tbl_itinerary", "itinerary_id='$t_id' and is_featured = 1");
        if ($noof_rec > 0) {
            $query_data = array(
                'is_featured' => '0'
            );
            $querydb    = $this->Common_model->update_records('tbl_itinerary', $query_data, "itinerary_id='$t_id'");
            if ($querydb) {
                echo '<div class="successmsg"><i class="fa fa-check"></i> Itinerary unfeatured successfully.</div>';
            } else {
                echo '<div class="errormsg"><i class="fa fa-check"></i> Itinerary could not unfeatured.</div>';
            }
        } else {
            echo '<div class="errormsg"><i class="fa fa-check"></i> Itinerary not found.</div>';
        }
        exit();
    }
	
	

}
 
	
