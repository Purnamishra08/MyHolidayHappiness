<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends CI_Controller {

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
		
 	}

	public function index()
	{
		$data['message'] = $this->session->flashdata('message');		
		$data['row'] = $this->Common_model->get_records("*","tbl_packages","","packageid DESC","","");
		$this->load->view('admin/manage_packages',$data);
	}

	public function add()
	{
		$data['messageadd'] = $this->session->flashdata('messageadd');
		if (isset($_POST['btnSubmitPlace']) && !empty($_POST))
		{
			$this->form_validation->set_rules('place_name', 'place name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('place_url', 'place url', 'trim|required|xss_clean');
			// $this->form_validation->set_rules('place_type', 'place type', 'trim|required|xss_clean');		
			$this->form_validation->set_rules('destination_id', 'destination', 'trim|required|xss_clean');
			$this->form_validation->set_rules('getatagid[]', 'getawaytags', 'trim|required|xss_clean');	
			$this->form_validation->set_rules('short_desc', 'short_desc', 'trim|required|xss_clean');	
			$this->form_validation->set_rules('trip_duration', 'trip_duration', 'trim|required|xss_clean');	
			// $this->form_validation->set_rules('transport', 'transport', 'trim|required|xss_clean');	
			//$this->form_validation->set_rules('travel_tips', 'travel_tips', 'trim|required|xss_clean');	
			$this->form_validation->set_rules('google_map', 'google_map', 'trim|required|xss_clean');

			if ($this->form_validation->run() == true)
			{			
				$place_name = $this->input->post('place_name');				 
				$place_url = $this->input->post('place_url');	
				$place_types = $this->input->post('place_type');	
				$destination_id = $this->input->post('destination_id');	
				$placeimg = $this->input->post('placeimg');	
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

				$noof_duprec = $this->Common_model->noof_records("placeid","tbl_places","place_name = '$place_name' and destination_id ='$destination_id'");				
				$date = date("Y-m-d H:i:s");

					
			if($noof_duprec < 1)	{						
				
				//For place image
				
				if (isset($_FILES) && !empty($_FILES))
				{					
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
					$config['max_size'] = '0';
					$config['overwrite'] = FALSE;
					$config['encrypt_name'] = TRUE;
			
					$this->load->library('upload', $config);
					if($this->upload->do_upload('placeimg'))
					{						
						$this->load->library('image_lib');
						$photo_path = $this->upload->data();
						$filename = $photo_path['file_name'];
						$config['create_thumb'] = TRUE;
						$config['thumb_marker'] = '_thumb';
						
						//resize:
						$config['new_image'] = $this->upload->upload_path.$this->upload->file_name;
						$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
						$config['maintain_ratio'] = FALSE;
						$config['width'] = 268;
						$config['height'] = 180;
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
					}
					else
					{
						$filename = '';	
					}
				}
				else
				{
					$filename = '';
				}
				
				// end of place image	
						$insert_data = array(
							'place_name'		=> $place_name,
							'place_url'			=> $place_url,
							'destination_id'	=> $destination_id,
							'distance_from_nearest_city'	=> $distance_from_nearest_city,
							'about_place'		=> $short_desc,
							'placeimg'		    => $filename,
							'trip_duration'		=> $trip_duration,
							'travel_tips'		=> $travel_tips,
							'google_map'		=> $google_map,
							'meta_title'		=> $meta_title,
							'meta_keywords'		=> $meta_keywords,
							'meta_description'	=> $meta_description,
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
											'place_id'		=> $last_id,
											'multdest_name'=> $place_type				
										 );	
										 $insertdb = $this->Common_model->insert_records('tbl_multdest_type', $insert_data);	
									}
								}								
								
								/*Data insert to tag table*/	
								if(!empty($getatagids)) {
									foreach($getatagids as $getatagid) { 
										 $insert_data = array(
											'place_id'		=> $last_id,
											'tag_name'      => $getatagid				
										 );	

										 $insertdb = $this->Common_model->insert_records('tbl_destination_tag', $insert_data);	
									}
								}
																
								/*Data insert to transport table */
								
								if(!empty($transports)) {
									foreach($transports as $transport) { 						
									 $insert_data = array(
										'place_id'		=> $last_id,
										'transport_name'=> $transport				
									 );								
								 		$insertdb = $this->Common_model->insert_records('tbl_place_transport', $insert_data);
									}
								}
								
								$this->session->set_flashdata('messageadd','<div class="successmsg notification"><i class="fa fa-check"></i> Place added successfully to destination.</div>');
							} else {
								$this->session->set_flashdata('messageadd','<div class="errormsg notification"><i class="fa fa-times"></i> place could not added. Please try again.</div>');
							}
					} else	{
							$this->session->set_flashdata('messageadd','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added this place to this destination.</div>');
					}
						redirect(base_url().'admin/tpackages/add','refresh');
			}
			else
			{
				$data['messageadd'] = (validation_errors() ? validation_errors() : $this->session->flashdata('messageadd'));
			}
		}
		
		$this->load->view('admin/add_tpackages',$data);
	}

	public function delete()
	{
		$delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("placeid","tbl_places","placeid='$delid'");
		
		if($noof_rec > 0)
		{
			$placeimo = $this->Common_model->showname_fromid("placeimg","tbl_places","placeid=$delid");				
			  $unlinkimage = getcwd().'/uploads/'.$placeimo;
				$array = explode('.',$placeimo);
				$felement = current($array);
				$extension = end($array); 
				
				$unlinkimage = getcwd().'/uploads/'.$placeimo;
				$unlink_thumbimage = getcwd().'/uploads/'.$felement.'_thumb.'.$extension;		
														
					if (file_exists($unlinkimage) && !is_dir($unlinkimage))
					{
						unlink($unlinkimage);
					}
					if (file_exists($unlink_thumbimage) && !is_dir($unlink_thumbimage))
					{
						unlink($unlink_thumbimage);
					}
			
			
			$del = $this->Common_model->delete_records("tbl_place_type","place_id = $delid");
			$del = $this->Common_model->delete_records("tbl_destination_tag","place_id = $delid");
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

		
		
		
		
		/////////////////////////////
		
		if (isset($_POST['btnEditPlace']) && !empty($_POST))
		{			
			$this->form_validation->set_rules('place_name', 'place name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('place_url', 'place url', 'trim|required|xss_clean');
			// $this->form_validation->set_rules('place_type', 'place type', 'trim|required|xss_clean');		
			$this->form_validation->set_rules('destination_id', 'destination', 'trim|required|xss_clean');
			$this->form_validation->set_rules('getatagid[]', 'getawaytags', 'trim|required|xss_clean');	
			$this->form_validation->set_rules('short_desc', 'short_desc', 'trim|required|xss_clean');	
			$this->form_validation->set_rules('trip_duration', 'trip_duration', 'trim|required|xss_clean');	
			// $this->form_validation->set_rules('transport', 'transport', 'trim|required|xss_clean');	
			//$this->form_validation->set_rules('travel_tips', 'travel_tips', 'trim|required|xss_clean');	
			$this->form_validation->set_rules('google_map', 'google_map', 'trim|required|xss_clean');

			
			if ($this->form_validation->run() == true)
			{				
				
				$place_name = $this->input->post('place_name');				 
				$place_url = $this->input->post('place_url');	
				$place_types = $this->input->post('place_type');	
				$destination_id = $this->input->post('destination_id');	
				$placeimg = $this->input->post('placeimg');	
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
				
				$noof_duprec = $this->Common_model->noof_records("placeid","tbl_places","place_name ='$place_name' and placeid!='$editid'");
				
				if($noof_duprec < 1)
				{
				
				///Start impage upload
				$rimage = $this->Common_model->showname_fromid("placeimg","tbl_places","placeid=$editid");
                //echo $rimage; die();
				if (isset($_FILES) && !empty($_FILES))
				{					
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
					$config['max_size'] = '0';
					$config['overwrite'] = FALSE;
					$config['encrypt_name'] = TRUE;
			
					$this->load->library('upload', $config);
					if($this->upload->do_upload('placeimg'))
					{	
						
						$array = explode('.',$rimage);
						$felement = current($array);
						$extension = end($array); 
				
				
						$unlinkimage = getcwd().'/uploads/'.$rimage;
						$unlink_thumbimage = getcwd().'/uploads/'.$felement.'_thumb.'.$extension;	
						
						if (file_exists($unlinkimage) && !is_dir($unlinkimage))
						{
							unlink($unlinkimage);
						}
												
						//for thumb						
						if (file_exists($unlink_thumbimage) && !is_dir($unlink_thumbimage))
						{
							unlink($unlink_thumbimage);
						}
											
						$this->load->library('image_lib');
						$photo_path = $this->upload->data();
						
						$filename = $photo_path['file_name'];
					
						$config['create_thumb'] = TRUE;
						$config['thumb_marker'] = '_thumb';
						
						//resize:
						$config['new_image'] = $this->upload->upload_path.$this->upload->file_name;
						$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
						$config['maintain_ratio'] = FALSE;
						$config['width'] = 268;
						$config['height'] = 180;
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
					}
					else
					{
						$filename = $rimage;	
					}
				}
				else
				{
					$filename = $rimage;
				}
					$date = date("Y-m-d H:i:s");
				$update_data = array(
					'place_name'		=> $place_name,
					'place_url'			=> $place_url,
					'destination_id'	=> $destination_id,
					'distance_from_nearest_city'	=> $distance_from_nearest_city,
					'about_place'		=> $short_desc,
					'placeimg'		    => $filename,
					'trip_duration'		=> $trip_duration,
					'travel_tips'		=> $travel_tips,
					'google_map'		=> $google_map,
					'meta_title'		=> $meta_title,
					'meta_keywords'		=> $meta_keywords,
					'meta_description'	=> $meta_description,
					'entry_fee'			=> $entry_fee,
					'timing'			=> $timing,
					'rating'			=> $rating,
					'created_date'		=> $date,				
					'status'			=> 1					
				);	
						
				
				$querydb = $this->Common_model->update_records('tbl_places',$update_data,"placeid=$editid");
				if($querydb){
										
					$this->Common_model->delete_records("tbl_multdest_type","place_id=$editid");
						foreach($place_types as $place_type)
							{
								$insert_data_types = array(
									'place_id'     	=> $editid,	
									'multdest_name'=> $place_type
								);
								$insertmodule = $this->Common_model->insert_records('tbl_multdest_type', $insert_data_types);
							
							}	
								
					$this->Common_model->delete_records("tbl_destination_tag","place_id=$editid");
						foreach($getatagids as $getatagid)
							{
								$insert_data_getatags = array(
									'place_id'=> $editid,	
									'tag_name'=> $getatagid
								);
								$insertmodule = $this->Common_model->insert_records('tbl_destination_tag', $insert_data_getatags);
							
							}
							
					$this->Common_model->delete_records("tbl_place_transport","place_id=$editid");
						foreach($transports as $transport)
							{
								$insert_data_transports = array(
									'place_id'=> $editid,	
									'transport_name'=> $transport
								);
								$insertmodule = $this->Common_model->insert_records('tbl_place_transport', $insert_data_transports);
							
							}	
							
					$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Place edited successfully.</div>');
				}
				else{
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Place could not edited. Please try again.</div>');
				}
			}

			else
			{
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added a place with this name. </div>');
			
			}
				redirect(base_url().'admin/places/edit/'.$editid,'refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
			
			
		/////////////////////////////
		
			
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
            $status = $rowss1['status'];
				
			
            
        }
        ?>
        <div class="modal-header">
			<button type="button" class="close-btn " data-dismiss="modal">&times;</button>
			<h4 class="modal-title pupop-title">Place Details</h4>
		</div>
		<div class="modal-body">
			<div class="modal-sub-body">
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
								$getplacetypeids = $this->Common_model->get_records("multdest_name","tbl_multdest_type","place_id='$placeid'","");
							$hasComma = false;
							foreach($getplacetypeids as $getplacetypeid)
							{
								if ($hasComma){ 
									echo ", "; 
								}
								$newplacetyid = $getplacetypeid['multdest_name'];
								$gettypename = $this->Common_model->showname_fromid("destination_type_name", "tbl_destination_type", "destination_type_id='$newplacetyid'");
								echo ucfirst($gettypename);   
								$hasComma=true;
							}
			
							?> </div>
						</div>
					</div>
					
					
					

					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Getaway Tags : </label></div>
							<div class="col-md-8"> <?php 
								$getawaystagids = $this->Common_model->get_records("tag_name","tbl_destination_tag","place_id='$placeid'","");
							$hasComma = false;
							foreach($getawaystagids as $getawaystagid)
							{
								if ($hasComma){ 
									echo ", "; 
								}
								$newgetawaystagid = $getawaystagid['tag_name'];
								$gettagname = $this->Common_model->showname_fromid("tag_name", "tbl_menutags", "tagid='$newgetawaystagid'");
								echo ucfirst($gettagname);   
								$hasComma=true;
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
								$transportgids = $this->Common_model->get_records("transport_name","tbl_place_transport","place_id='$placeid'","");
							$hasComma = false;
							foreach($transportgids as $transportgid)
							{
								if ($hasComma){ 
									echo ", "; 
								}
								$newtransportgid = $transportgid['transport_name'];
								$getvehiclename = $this->Common_model->showname_fromid("vehicle_name", "tbl_vehicletypes", "vehicleid='$newtransportgid'");
								echo ucfirst($getvehiclename);   
								$hasComma=true;
							}
			
							?> </div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Travel Tips : </label></div>
							<div class="col-md-8"> <?php echo ($rowss1['travel_tips']) ? $rowss1['travel_tips'] : '-' ; ?></div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Google Map :  </label></div>
							<div class="col-md-8"> <?php echo $rowss1['google_map']; ?></div>
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
							<div class="col-md-4"> <label> Entry Fee : </label></div>
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
							<div class="col-md-4"> <label> Place Image : </label></div>
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
					<div class="clearfix"></div>
					
					<div class="col-md-12">
						<div class="gap row">
							<div class="col-md-4"> <label> About Place : </label></div>
							<div class="col-md-8"> <?php echo $rowss1['about_place']; ?></div>
						</div>
					</div>				  
				</div>
			</div>
			<div class="clearfix"></div>
		</div>            
    <?php
    }	
}
}



