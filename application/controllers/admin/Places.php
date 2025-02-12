<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Places extends CI_Controller {

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
		$this->load->library('pagination');
		if($this->session->userdata('userid') == "")
		{
			redirect(base_url().'admin/logout','refresh');
		}	
		
		$allusermodules = $this->session->userdata('allpermittedmodules');
		if(!(in_array(6, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}	
		
 	}

	public function index()
	{
		$data['message'] = $this->session->flashdata('message');		
		// $data['row'] = $this->Common_model->get_records("*","tbl_places","","placeid DESC","","");
		$this->load->view('admin/manage_places',$data);
	}

	public function datatable(){
		$arrPageData = $_REQUEST;
		$place_name = isset($arrPageData['place_name']) ? $arrPageData['place_name'] : "";
		$destination_name = isset($arrPageData['destination_name']) ? $arrPageData['destination_name'] : 0;
		$t_status = isset($arrPageData['t_status']) ? $arrPageData['t_status'] : 0;
		$whereCond = '';
		if($place_name != ''){
			$whereCond .= "(place_name like '%".$place_name."%') and ";
		}
		if($destination_name > 0){
			$whereCond .= "destination_id = $destination_name and ";
		}
		if($t_status > 0){
			if($t_status == 1){
				$whereCond .= "status = $t_status and ";
			} else {
				$whereCond .= "status = 0 and";
			}
		}
		$whereCond = rtrim($whereCond, " and ");
 
		$rowCnt = $this->Common_model->noof_records("placeid","tbl_places","$whereCond");
		if ($arrPageData['length'] == -1) {
			$rows = $this->Common_model->get_records("*","tbl_places","$whereCond", " placeid DESC");
		} else {
			$rows = $this->Common_model->get_records("*","tbl_places","$whereCond", " placeid DESC",$arrPageData['length'], $arrPageData['start']);
		}

		if(!empty($rows) && count((array)$rows) > 0) {
			foreach ($rows as $key => $val) {
				$rows[$key]['sl_no'] = ++$arrPageData['start'];
				$destination_id = $rows[$key]['destination_id'];
				$placeimg = $rows[$key]['placeimg'];
				$placethumbimg = $rows[$key]['placethumbimg'];

				$stateid=$this->Common_model->showname_fromid("state","tbl_destination","destination_id='$destination_id'");
				$stateurl=$this->Common_model->showname_fromid("state_url","tbl_state","state_id='$stateid'");
				$desturl=$this->Common_model->showname_fromid("destination_url","tbl_destination","destination_id='$destination_id'");
				$en_admin = $this->Common_model->encode("admin"); 

				$rows[$key]['place_url'] = base_url().'place/'.$stateurl.'/'.$desturl.'/'.$rows[$key]['place_url'].'/?preview='.$en_admin;

				$rows[$key]['destination_name'] = ucfirst($this->Common_model->showname_fromid("destination_name", "tbl_destination", "destination_id='$destination_id'"));

				$rows[$key]['placeimg'] = (file_exists("./uploads/".$placeimg) && ($placeimg!='')) ? base_url().'uploads/'.$placeimg : '';
				$rows[$key]['placethumbimg'] = (file_exists("./uploads/".$placethumbimg) && ($placethumbimg!='')) ? base_url().'uploads/'.$placethumbimg : '';
			}
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
		$data['messageadd'] = $this->session->flashdata('messageadd');
					
		if (isset($_POST['btnSubmitPlace']) && !empty($_POST))
		{
			//print_r($_POST); exit;
			$this->form_validation->set_rules('place_name', 'place name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('place_url', 'place url', 'trim|required|xss_clean');						
			$this->form_validation->set_rules('destination_id', 'destination', 'trim|required|xss_clean');
			$this->form_validation->set_rules('short_desc', 'short_desc', 'trim|required|xss_clean');
			$this->form_validation->set_rules('latitude', 'Place Latitude', 'trim|required|xss_clean');
			$this->form_validation->set_rules('longitude', 'Place Longitude', 'trim|required|xss_clean');			

			if ($this->form_validation->run() == true)
			{	
				$place_name = $this->input->post('place_name');
				$place_url = $this->input->post('place_url');
				$platitude 	= $this->input->post('latitude');
				$plongitude = $this->input->post('longitude');
				$place_types = $this->input->post('place_type');	
				$destination_id = $this->input->post('destination_id');	
				$placeimg = $this->input->post('placeimg');	
				$placethumbimg = $this->input->post('placethumbimg');	
				$getatagids = $this->input->post('getatagid');	
				$short_desc = $this->input->post('short_desc');	
				$trip_duration = $this->input->post('trip_duration');	
				$transports = $this->input->post('transport');	
				$travel_tips = $this->input->post('travel_tips');	
				$distance_from_nearest_city = $this->input->post('distance_from_nearest_city');	
				$google_map = $this->input->post('google_map');	
				
				$entry_fee = $this->input->post('entry_fee');	
				$timing = $this->input->post('timing');	
				$rating = $this->input->post('rating');	
				
				$meta_title = $this->input->post('meta_title');	
				$meta_keywords = $this->input->post('meta_keywords');	
				$meta_description = $this->input->post('meta_description');	
				
				$pckg_meta_title = $this->input->post('pckg_meta_title');	
				$pckg_meta_keywords = $this->input->post('pckg_meta_keywords');	
				$pckg_meta_description = $this->input->post('pckg_meta_description');	
				
                $alttag_banner 		= $this->input->post('alttag_banner');
                $alttag_thumb 		= $this->input->post('alttag_thumb');

				$noof_duprec = $this->Common_model->noof_records("placeid","tbl_places","place_name = '$place_name' or place_url = '$place_url'");					
			
				$date = date("Y-m-d H:i:s");
									
					if($noof_duprec < 1)	{	
						
					/************For place Image***************/	
                    $imofilename = $this->Common_model->seo_friendly_url($alttag_banner);
                    $thumbfilename = $this->Common_model->seo_friendly_url($alttag_thumb);
				    if (isset($_FILES['placeimg']) && $_FILES['placeimg']['name'] != '') {
						$filename = $this->Common_model->ddoo_upload('placeimg', 1140 , 350, $imofilename);
					} else {
						$filename = NULL;
					} 
					
					if (isset($_FILES['placethumbimg']) && $_FILES['placethumbimg']['name'] != '') {
						$placethumb_imgnew = $this->Common_model->thumbddoo_upload('placethumbimg', 500 , 300, $thumbfilename);
					} else {
						$placethumb_imgnew = NULL;
					} 
					
				    /***************End of place image*********/
				
								$insert_data = array(
									'place_name'		=> $place_name,
									'place_url'			=> $place_url,
									'latitude'	    	=> $platitude,
									'longitude'	    	=> $plongitude,
									'destination_id'	=> $destination_id,
									'distance_from_nearest_city'	=> $distance_from_nearest_city,
									'about_place'		=> $short_desc,
									'placeimg'		    => $filename,
									'placethumbimg'		=> $placethumb_imgnew,
									'alttag_banner' 	=> $alttag_banner,
									'alttag_thumb' 		=> $alttag_thumb,
									'trip_duration'		=> $trip_duration,
									'travel_tips'		=> $travel_tips,
									'google_map'		=> $google_map,
									'meta_title'		=> $meta_title,
									'meta_keywords'		=> $meta_keywords,
									'meta_description'	=> $meta_description,
									'pckg_meta_title'		=> $pckg_meta_title,
									'pckg_meta_keywords'		=> $pckg_meta_keywords,
									'pckg_meta_description'	=> $pckg_meta_description,
									'entry_fee'			=> $entry_fee,
									'timing'			=> $timing,
									'rating'			=> $rating,
									'created_date'		=> $date,				
									'status'			=> 1					
								);	
									$insertdb = $this->Common_model->insert_records('tbl_places', $insert_data);
									
									if($insertdb) {
										 $last_id = $this->db->insert_id();										
										/*Data insert to tbl_multdest_type table*/	
										if(!empty($place_types)) {
											foreach($place_types as $place_type) { 							
												 $insert_data = array(
													'loc_id'		 => $last_id,
													'loc_type'       => 2,
													'loc_type_id'    => $place_type							
												 );	
												 $insertdb = $this->Common_model->insert_records('tbl_multdest_type', $insert_data);	
											}
										}								
										
										/*Data insert to tag table*/	
										if(!empty($getatagids)) {
											foreach($getatagids as $getatagid) { 
												 $insert_data = array(
													'type_id'  	=> $last_id,
													'type'      => 2,				
													'tagid'     => $getatagid				
												 );	
												 $insertdb = $this->Common_model->insert_records('tbl_tags', $insert_data);	
											}
										}
																		
										/*Data insert to transport table */
										
										if(!empty($transports)) {
											foreach($transports as $transport) { 						
											 $insert_data = array(
												'place_id'		=> $last_id,
												'transport_id'=> $transport				
											 );								
												$insertdb = $this->Common_model->insert_records('tbl_place_transport', $insert_data);
											}
										}
										
										$this->session->set_flashdata('messageadd','<div class="successmsg notification"><i class="fa fa-check"></i> Place added successfully to destination.</div>');
									} else {
										$this->session->set_flashdata('messageadd','<div class="errormsg notification"><i class="fa fa-times"></i> place could not added. Please try again.</div>');
									}
							} else	{
									$this->session->set_flashdata('messageadd','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added this place, place name or URL must be unique .</div>');
							}
								redirect(base_url().'admin/places/add','refresh');
					}
					else
					{
						$data['messageadd'] = (validation_errors() ? validation_errors() : $this->session->flashdata('messageadd'));
					}
		}
		
		$this->load->view('admin/add_places',$data);
	}

	public function delete()
	{
		$delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("placeid","tbl_places","placeid='$delid'");
		
		if($noof_rec > 0)
		{
			$placeimo = $this->Common_model->showname_fromid("placeimg","tbl_places","placeid=$delid");				
			$place_thumb_imo = $this->Common_model->showname_fromid("placethumbimg","tbl_places","placeid=$delid");				
			  $unlinkimage = getcwd().'/uploads/'.$placeimo;
			  $unlink_thumb_image = getcwd().'/uploads/'.$place_thumb_imo;	
														
					if (file_exists($unlinkimage) && !is_dir($unlinkimage))
					{
						unlink($unlinkimage);
					}
					if (file_exists($unlink_thumb_image) && !is_dir($unlink_thumb_image))
					{
						unlink($unlink_thumb_image);
					}			
			
			$del = $this->Common_model->delete_records("tbl_multdest_type","loc_id = $delid and loc_type = 2");
			$del = $this->Common_model->delete_records("tbl_tags","type_id = $delid and type = 2");
			$del = $this->Common_model->delete_records("tbl_place_transport","place_id = $delid");
			
			if($del) {
				$this->Common_model->delete_records("tbl_places","placeid = $delid");
				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Place has been deleted successfully.</div>');
			} else{
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Place could not deleted. Please try again.</div>');
			}
		}
		redirect(base_url().'admin/places','refresh');
	}
	
	public function changestatus()
	{
		$stsid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("placeid","tbl_places","placeid='$stsid'");
		if($noof_rec>0)
		{
			$status = $this->Common_model->showname_fromid("status","tbl_places","placeid=$stsid");
			if($status==1)
				$updatedata = array('status' => 0);
			else
				$updatedata = array('status' => 1);
			$updatestatus = $this->Common_model->update_records("tbl_places",$updatedata,"placeid=$stsid");

			if($updatestatus)
				echo $status;
			else
				echo "error";
		}
		exit();
	}

	public function edit()
	{
		$editid = $this->uri->segment(4);
		$data['message'] = $this->session->flashdata('message');
		$noof_rec = $this->Common_model->noof_records("placeid","tbl_places","placeid='$editid'");
		if($noof_rec > 0)
		{
		$data['editplace'] = $this->Common_model->get_records("*","tbl_places","placeid='$editid'");
			
		}
				
		if (isset($_POST['btnEditPlace']) && !empty($_POST))
		{			
			$this->form_validation->set_rules('place_name', 'place name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('place_url', 'place url', 'trim|required|xss_clean');		
			$this->form_validation->set_rules('destination_id', 'destination', 'trim|required|xss_clean');
			$this->form_validation->set_rules('short_desc', 'short_desc', 'trim|required|xss_clean');
			$this->form_validation->set_rules('latitude', 'Place Latitude', 'trim|required|xss_clean');
			$this->form_validation->set_rules('longitude', 'Place Longitude', 'trim|required|xss_clean');	
			
			if ($this->form_validation->run() == true)
			{		
				$place_name = $this->input->post('place_name');				 
				$place_url = $this->input->post('place_url');
				$platitude 	= $this->input->post('latitude');
				$plongitude = $this->input->post('longitude');				
				$place_types = $this->input->post('place_type');	
				$destination_id = $this->input->post('destination_id');	
				$placeimg = $this->input->post('placeimg');	
				$placethumbimg = $this->input->post('placethumbimg');	
				$getatagids = $this->input->post('getatagid');	
				$short_desc = $this->input->post('short_desc');	
				$trip_duration = $this->input->post('trip_duration');	
				$transports = $this->input->post('transport');	
				$travel_tips = $this->input->post('travel_tips');	
				$distance_from_nearest_city = $this->input->post('distance_from_nearest_city');	
				$google_map = $this->input->post('google_map');					
				$entry_fee = $this->input->post('entry_fee');	
				$timing = $this->input->post('timing');	
				$rating = $this->input->post('rating');	
				
				 $meta_title = $this->input->post('meta_title');	
				 $meta_keywords = $this->input->post('meta_keywords');	
				 $meta_description = $this->input->post('meta_description');
				 
				 
				$pckg_meta_title = $this->input->post('pckg_meta_title');	
				$pckg_meta_keywords = $this->input->post('pckg_meta_keywords');	
				$pckg_meta_description = $this->input->post('pckg_meta_description');
				 
				 
				 $alttag_banner 		= $this->input->post('alttag_banner');
				 $alttag_thumb 		= $this->input->post('alttag_thumb');
				
				$noof_duprec = $this->Common_model->noof_records("placeid","tbl_places","(place_name = '$place_name' or place_url = '$place_url') and placeid!='$editid'");
				
				
				if($noof_duprec < 1)
				{
					/************For place Image***************/
					$imofilename = $this->Common_model->seo_friendly_url($alttag_banner);
					$thumbfilename = $this->Common_model->seo_friendly_url($alttag_thumb);	
					$rimage = $this->Common_model->showname_fromid("placeimg","tbl_places","placeid='$editid'");
				    if (isset($_FILES['placeimg']) && $_FILES['placeimg']['name'] != '') {						
						$unlinkimage = getcwd().'/uploads/'.$rimage;
						if (file_exists($unlinkimage) && !is_dir($unlinkimage))
						{
							unlink($unlinkimage);
						}
						$filename = $this->Common_model->ddoo_upload('placeimg', 1140 , 350, $imofilename);
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
					
						
					$rthumb_image = $this->Common_model->showname_fromid("placethumbimg","tbl_places","placeid='$editid'");
					if (isset($_FILES['placethumbimg']) && $_FILES['placethumbimg']['name'] != '') {						
						$unlinkimagethumb = getcwd().'/uploads/'.$rthumb_image;	
						if (file_exists($unlinkimagethumb) && !is_dir($unlinkimagethumb))
						{
							unlink($unlinkimagethumb);
						}
						$placethumb_imgnew = $this->Common_model->thumbddoo_upload('placethumbimg', 500 , 300, $thumbfilename);
					} else {
						$oldname = getcwd().'/uploads/'.$rthumb_image;
						if(file_exists($oldname)) {
							$extensionArr = explode(".", $rthumb_image);
							$extension = end($extensionArr);
							$newname = getcwd().'/uploads/'.$thumbfilename.'.'.$extension;
							rename($oldname, $newname);
							$placethumb_imgnew = $thumbfilename.'.'.$extension;
						} else {
							$placethumb_imgnew = $rthumb_image;
						}
					} 
					
				    /***************End of place image*********/
				    
				  
					$date = date("Y-m-d H:i:s");
					$update_data = array(
						'place_name'		=> $place_name,
						'place_url'			=> $place_url,
						'latitude'	    	=> $platitude,
						'longitude'	    	=> $plongitude,
						'destination_id'	=> $destination_id,
						'distance_from_nearest_city'	=> $distance_from_nearest_city,
						'about_place'		=> $short_desc,
						'placeimg'		    => $filename,
						'placethumbimg'		=> $placethumb_imgnew,
						'alttag_banner' 	=> $alttag_banner,
						'alttag_thumb' 		=> $alttag_thumb,
						'trip_duration'		=> $trip_duration,
						'travel_tips'		=> $travel_tips,
						'google_map'		=> $google_map,
						'meta_title'		=> $meta_title,
						'meta_keywords'		=> $meta_keywords,
						'meta_description'	=> $meta_description,
						'pckg_meta_title'		=> $pckg_meta_title,
						'pckg_meta_keywords'		=> $pckg_meta_keywords,
						'pckg_meta_description'	=> $pckg_meta_description,
						'entry_fee'			=> $entry_fee,
						'timing'			=> $timing,
						'rating'			=> $rating,
						'created_date'		=> $date,				
						'status'			=> 1					
					);	
						
				
				$querydb = $this->Common_model->update_records('tbl_places',$update_data,"placeid=$editid");
				if($querydb){
					if(!empty($place_types)){					
						$this->Common_model->delete_records("tbl_multdest_type","loc_id=$editid and loc_type = 2");
							foreach($place_types as $place_type)
								{
									$insert_data_types = array(									
										'loc_id'		 => $editid,
										'loc_type'       => 2,
										'loc_type_id'    => $place_type														
									);
									$insertmodule = $this->Common_model->insert_records('tbl_multdest_type', $insert_data_types);
								
								}
						}	
						if(!empty($getatagids)){		
							$this->Common_model->delete_records("tbl_tags","type_id=$editid and type = 2");
								foreach($getatagids as $getatagid)
									{
										$insert_data_getatags = array(									
											'type_id'  	=> $editid,
											'type'      => 2,				
											'tagid'      => $getatagid	
										);
										$insertmodule = $this->Common_model->insert_records('tbl_tags', $insert_data_getatags);
									
									}
						}
						if(!empty($transports)){	
							$this->Common_model->delete_records("tbl_place_transport","place_id=$editid");
								foreach($transports as $transport)
									{
										$insert_data_transports = array(
											'place_id'=> $editid,	
											'transport_id'=> $transport
										);
										$insertmodule = $this->Common_model->insert_records('tbl_place_transport', $insert_data_transports);
									
									}	
						}
							
					$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Place edited successfully.</div>');
				}
				else{
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Place could not edited. Please try again.</div>');
				}
			}

			else
			{
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added this place, place name or URL must be unique. </div>');
				
			
			}
				redirect(base_url().'admin/places/edit/'.$editid,'refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
			
			
		}
		$this->load->view('admin/edit_places',$data);
		
	}

		
        
	
	
	
	public function view_pop() 
	{
        $viewid = $this->uri->segment(4);
        $rows1 = $this->Common_model->get_records("*","tbl_places","placeid='$viewid'","placeid DESC","","");
        if (!empty($rows1)) {
            foreach ($rows1 as $rowss1) {
            $placeid = $rowss1['placeid'];
            $destination_id = $rowss1['destination_id'];
            $placeimg = $rowss1['placeimg'];
            $placethumbimg = $rowss1['placethumbimg'];
            $status = $rowss1['status'];
            $meta_title = $rowss1['meta_title'];
            $meta_keywords = $rowss1['meta_keywords'];
            $meta_description = $rowss1['meta_description'];
				
			$latitude  = $rowss1['latitude'];
			$longitude = $rowss1['longitude'];
            
        }
        ?>
        <div class="modal-header">
			<button type="button" class="close-btn " data-dismiss="modal">&times;</button>
			<h4 class="modal-title pupop-title">Place Details</h4>
		</div>
		<div class="modal-body">
			<div class="">
				<div class="row">

					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Place Name : </label></div>
							<div class="col-md-8"> <?php echo $rowss1['place_name']; ?></div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Destination :  </label></div>
							<div class="col-md-8"> <?php echo ucfirst($this->Common_model->showname_fromid("destination_name", "tbl_destination", "destination_id='$destination_id'")); ?></div>
						</div>
					</div>					
					<div class="clearfix"></div>
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label>Place Type : </label></div>
							<div class="col-md-8"> <?php 
								$getplacetypeids = $this->Common_model->get_records("loc_type_id","tbl_multdest_type","loc_id='$placeid' and loc_type = 2","");
							$hasComma = false;
							if(!empty($getplacetypeids)){
							foreach($getplacetypeids as $getplacetypeid)
							{
								if ($hasComma){ 
									echo ", "; 
								}
								$newplacetyid = $getplacetypeid['loc_type_id'];
								$gettypename = $this->Common_model->showname_fromid("destination_type_name", "tbl_destination_type", "destination_type_id='$newplacetyid'");
								echo ucfirst($gettypename);   
								$hasComma=true;
							}}
			
							?> </div>
						</div>
					</div>
					
					
					

					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Getaway Tags : </label></div>
							<div class="col-md-8"> <?php 
								$getawaystagids = $this->Common_model->get_records("tagid","tbl_tags","type_id='$placeid' and type = 2","");
							$hasComma = false;
							if(!empty($getawaystagids)){
								foreach($getawaystagids as $getawaystagid)
								{
									if ($hasComma){ 
										echo ", "; 
									}
									$newgetawaystagid = $getawaystagid['tagid'];
									$gettagname = $this->Common_model->showname_fromid("tag_name", "tbl_menutags", "tagid='$newgetawaystagid'");
									echo ucfirst($gettagname);   
									$hasComma=true;
								}
						    }
			
							?>  </div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Trip duration (including travel in hours) : </label></div>
							<div class="col-md-8"><?php echo $rowss1['trip_duration']; ?></div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Transportation Options: </label></div>
							<div class="col-md-8">  <?php 
								$transportgids = $this->Common_model->get_records("transport_id","tbl_place_transport","place_id='$placeid'","");
							$hasComma = false;
							if(!empty($transportgids)){
								foreach($transportgids as $transportgid)
								{
									if ($hasComma){ 
										echo ", "; 
									}
									$newtransportgid = $transportgid['transport_id'];
									$getvehiclename = $this->Common_model->showname_fromid("vehicle_name", "tbl_vehicletypes", "vehicleid='$newtransportgid'");
									echo ucfirst($getvehiclename);   
									$hasComma=true;
								}
							}
			
							?> </div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Travel Tips : </label></div>
							<div class="col-md-8"> <?php echo (trim($rowss1['travel_tips'])) ? trim($rowss1['travel_tips']) : '-' ; ?></div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Google Map :  </label></div>
							<div class="col-md-8 g-map"> <?php echo $rowss1['google_map']; ?></div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Distance from near by city :  </label></div>
							<div class="col-md-8"> <?php echo $rowss1['distance_from_nearest_city']; ?></div>
						</div>
					</div>
					
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Entry Fee (<?php echo $this->Common_model->currency; ?>) : </label></div>
							<div class="col-md-8"> <?php echo ($rowss1['entry_fee']) ? $rowss1['entry_fee'] : '-'; ?></div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Timing : </label></div>
							<div class="col-md-8"> <?php echo ($rowss1['timing']) ? $rowss1['timing'] : '-' ; ?></div>
						</div>
					</div>
					
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Rating : </label></div>
							<div class="col-md-8"> <?php echo ($rowss1['rating']) ? $rowss1['rating'] : '-'; ?></div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Banner Image : </label></div>
							<div class="col-md-8">
								<?php
									if(file_exists("./uploads/".$placeimg) && ($placeimg!=''))
									{ 
										echo '<a href="'.base_url().'uploads/'.$placeimg.'" target="_blank"><img src="'.base_url().'uploads/'.$placeimg.'" style="width:86px;height:59px" alt="image" /></a>';
									}
								?>
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Place Image : </label></div>
							<div class="col-md-8">
								<?php
									if(file_exists("./uploads/".$placethumbimg) && ($placethumbimg!=''))
									{ 
										echo '<a href="'.base_url().'uploads/'.$placethumbimg.'" target="_blank"><img src="'.base_url().'uploads/'.$placethumbimg.'" style="width:86px;height:59px" alt="image" /></a>';
									}
								?>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Place Latitude : </label></div>
							<div class="col-md-8"> <?php echo $latitude ; ?></div>
						</div>
					</div>
					
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Place Longitude : </label></div>
							<div class="col-md-8"> <?php echo $longitude ; ?></div>
						</div>
					</div>
					<div class="clearfix"></div>
					
					<div class="col-md-12">
						<div class="gap row">
							<div class="col-md-2"> <label> About Place : </label></div>
							<div class="col-md-10"> <?php echo $rowss1['about_place']; ?></div>
						</div>
					</div>	
					<h4 style="margin-left:10px">Place Meta Tags</h4>
					<div class="col-md-12">
						<div class="gap row">
							<div class="col-md-2"> <label> Meta Title : </label></div>
							<div class="col-md-10"> <?php echo ($rowss1['meta_title']) ?  : '-'; ?></div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-12">
						<div class="gap row">
							<div class="col-md-2"> <label> Meta Keyword : </label></div>
							<div class="col-md-10"> <?php echo ($rowss1['meta_keywords'] ) ?  : '-' ; ?></div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="gap row">
							<div class="col-md-2"> <label> Meta Description : </label></div>
							<div class="col-md-10"> <?php echo ($rowss1['meta_description'] ) ?  : '-'; ?></div>
						</div>
					</div>
					<h4 style="margin-left:10px">Package Meta Tags</h4>
					<div class="col-md-12">
						<div class="gap row">
							<div class="col-md-2"> <label> Meta Title : </label></div>
							<div class="col-md-10"> <?php echo ($rowss1['pckg_meta_title']) ?  : '-'; ?></div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-12">
						<div class="gap row">
							<div class="col-md-2"> <label> Meta Keyword : </label></div>
							<div class="col-md-10"> <?php echo ($rowss1['pckg_meta_keywords'] ) ?  : '-' ; ?></div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="gap row">
							<div class="col-md-2"> <label> Meta Description : </label></div>
							<div class="col-md-10"> <?php echo ($rowss1['pckg_meta_description'] ) ?  : '-'; ?></div>
						</div>
					</div>
					
					<div class="clearfix"></div>
								  
				</div>
			</div>
			<div class="clearfix"></div>
		</div>            
    <?php
    }	
}

}



