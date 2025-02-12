<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Destination extends CI_Controller {

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
		if(!(in_array(6, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}
 	}

	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		// $data['row'] = $this->Common_model->get_records("*","tbl_destination","", " destination_id DESC","","");
		$this->load->view('admin/manage_destination',$data);
	}

	public function datatable(){
		$arrPageData = $_REQUEST;
		$destination_name = isset($arrPageData['destination_name']) ? $arrPageData['destination_name'] : "";
		$state = isset($arrPageData['state']) ? $arrPageData['state'] : 0;
		$homepage_type = isset($arrPageData['homepage_type']) ? $arrPageData['homepage_type'] : 0;
		$whereCond = '';
		if($destination_name != ''){
			$whereCond .= "(destination_name like '%".$destination_name."%') and ";
		}
		if($state > 0){
			$whereCond .= "state = $state and ";
		}
		if($homepage_type > 0){
			$whereCond .= "desttype_for_home = $homepage_type and ";
		}
		$whereCond = rtrim($whereCond, " and ");
 
		$rowCnt = $this->Common_model->noof_records("destination_id","tbl_destination","$whereCond");
		if ($arrPageData['length'] == -1) {
			$rows = $this->Common_model->get_records("*","tbl_destination","$whereCond", " destination_id DESC");
		} else {
			$rows = $this->Common_model->get_records("*","tbl_destination","$whereCond", " destination_id DESC",$arrPageData['length'], $arrPageData['start']);
		}

		if(!empty($rows) && count((array)$rows) > 0) {
			foreach ($rows as $key => $val) {
				$rows[$key]['sl_no'] = ++$arrPageData['start'];
				$durl = $rows[$key]['destination_url'];
				$destpic = $rows[$key]['destiimg'];
				$destiimg_thumb = $rows[$key]['destiimg_thumb'];

				$dstate= $rows[$key]['state'];
				$desttype_for_home = $rows[$key]['desttype_for_home'];
				$rows[$key]['desttype_home'] = $this->Common_model->show_parameter($desttype_for_home);

				$statename=$this->Common_model->showname_fromid("state_url","tbl_state","state_id='$dstate'");
				$en_admin = $this->Common_model->encode("admin"); 
				$rows[$key]['statename'] = $statename;

				$rows[$key]['durl'] = base_url().'destination/'.$statename.'/'.$durl.'/?preview='.$en_admin;
				$rows[$key]['destpic'] = (file_exists("./uploads/".$destpic) && ($destpic!='')) ? base_url().'uploads/'.$destpic : '';
				$rows[$key]['destiimg_thumb'] = (file_exists("./uploads/".$destiimg_thumb) && ($destiimg_thumb!='')) ? base_url().'uploads/'.$destiimg_thumb : '';
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
		$data['message'] = $this->session->flashdata('message');
				
		if (isset($_POST['btnSubmit']) && !empty($_POST))
		{
			$this->form_validation->set_rules('destination_name', 'Destination Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('state', 'state', 'trim|required|xss_clean');
			$this->form_validation->set_rules('pick_drop_price', 'Pick / Drop Price', 'trim|required|xss_clean');
			$this->form_validation->set_rules('accomodation_price', 'Minimum Accomodation Price ', 'trim|required|xss_clean');
			$this->form_validation->set_rules('latitude', 'Destination Latitude', 'trim|required|xss_clean');
			$this->form_validation->set_rules('longitude', 'Destination Longitude', 'trim|required|xss_clean');
			
			$sess_userid = $this->session->userdata('userid');
			$date = date("Y-m-d H:i:s");
			if ($this->form_validation->run() == true)
			{
				$dname 		= $this->input->post('destination_name');
				$durl 		= $this->input->post('destination_url');
				$dlatitude 	= $this->input->post('latitude');
				$dlongitude = $this->input->post('longitude');
				$dtypes		= $this->input->post('destination_type');
				$dstate 	= $this->input->post('state');
				$dtrip      = $this->input->post('trip_duration');
				$dcity      = $this->input->post('nearest_city');
				$dtime      = $this->input->post('visit_time');
				$dpeak      = $this->input->post('peak_season');
				$dweather   = $this->input->post('weather_info');      
                $dmap       = $this->input->post('google_map');  
				$ddesc 	    = $this->input->post('short_desc');
				$pvdesc 	= $this->input->post('places_to_visit_desc');
				$edestis 	= $this->input->post('edesti');
				$internet   = $this->input->post('internet_avl');
				$std        = $this->input->post('std_code');
				$lspeak     = $this->input->post('lng_spk');
				$mfest      = $this->input->post('mjr_fest');
				$getatagids = $this->input->post('getatagid');
				$ntips      = $this->input->post('note_tips');
				$nearinfo 	= $this->input->post('near_info');
				$desttype_for_home 	= $this->input->post('desttype_for_home');
				$show_on_footer 	= $this->input->post('show_on_footer');
				$pick_drop_price 	= $this->input->post('pick_drop_price');
				$accomodation_price	= $this->input->post('accomodation_price');
				$destiimg 	        = $this->input->post('destiimg');
				$destismallimg	 	= $this->input->post('destismallimg');
				
				$place_meta_title	 	    = $this->input->post('place_meta_title');
				$place_meta_keywords	 	= $this->input->post('place_meta_keywords');
				$place_meta_description	= $this->input->post('place_meta_description');
				
				$package_meta_title	 	    = $this->input->post('package_meta_title');
				$package_meta_keywords	 	= $this->input->post('package_meta_keywords');
				$package_meta_description	= $this->input->post('package_meta_description');
				
				$meta_title	 	    = $this->input->post('meta_title');
				$meta_keywords	 	= $this->input->post('meta_keywords');
				$meta_description	= $this->input->post('meta_description');
				
                $alttag_banner 		= $this->input->post('alttag_banner');
                $alttag_thumb 		= $this->input->post('alttag_thumb');
				
				$noof_duprec = $this->Common_model->noof_records("destination_name","tbl_destination","destination_name = '$dname' or destination_url = '$durl'");	
				
													
				if($noof_duprec < 1)	{	
					
					/************For destination Image***************/
                    $imofilename = $this->Common_model->seo_friendly_url($alttag_banner);
                    $thumbfilename = $this->Common_model->seo_friendly_url($alttag_thumb);
				    if (isset($_FILES['destiimg']) && $_FILES['destiimg']['name'] != '') {
						$filename = $this->Common_model->ddoo_upload('destiimg', 2000 , 350, $imofilename);
					} else {
						$filename = NULL;
					} 
					
					if (isset($_FILES['destismallimg']) && $_FILES['destismallimg']['name'] != '') {
						$destbannerthumb_imgnew = $this->Common_model->thumbddoo_upload('destismallimg', 300 , 225, $thumbfilename);
					} else {
						$destbannerthumb_imgnew = NULL;
					} 
					
				    /***************End of destination image*********/	
				    
				    $show_on_footernew = ($show_on_footer > 0) ? $show_on_footer : '0';			
				
					$insert_data = array(
						'destination_name'		=> $dname,
						'destination_url'	    => $durl,
						'latitude'	    		=> $dlatitude,
						'longitude'	    		=> $dlongitude,
						'state'		            => $dstate,
						'trip_duration'	        => $dtrip,  	
						'nearest_city'	        => $dcity, 
						'visit_time'	        => $dtime,  	
						'peak_season'	        => $dpeak,
						'weather_info'	        => $dweather,
						'destiimg'	            => $filename,
						'destiimg_thumb'	    => $destbannerthumb_imgnew,
						'alttag_banner' 		=> $alttag_banner,
						'alttag_thumb' 			=> $alttag_thumb,
						'google_map'	        => $dmap, 
						'about_destination'	    => $ddesc, 
						'places_visit_desc'	    => $pvdesc, 
						'internet_availability' => $internet,
						'std_code'              => $std,
						'language_spoken'       => $lspeak,
						'major_festivals'       => $mfest,
						'note_tips'             => $ntips,
						'meta_title'            => $meta_title,
						'meta_keywords'         => $meta_keywords,
						'meta_description'      => $meta_description,
						
						'place_meta_title'            => $place_meta_title,
						'place_meta_keywords'         => $place_meta_keywords,
						'place_meta_description'      => $place_meta_description,
						
						'package_meta_title'            => $package_meta_title,
						'package_meta_keywords'         => $package_meta_keywords,
						'package_meta_description'      => $package_meta_description,
						
						'status'		        => 1,
						'created_by'	        => $sess_userid,
						'created_date'	        => $date,
						'desttype_for_home'	    => $desttype_for_home,
						'show_on_footer'	    => $show_on_footernew,
						'pick_drop_price'	    => $pick_drop_price,
						'accomodation_price'	=> $accomodation_price
					);
				
					$insertdb = $this->Common_model->insert_records('tbl_destination', $insert_data);
					if($insertdb) 
					{
						$dinfo   = $this->input->post('other_info');
						$last_id = $this->db->insert_id();						
						if(!empty($edestis)){
							foreach ( $edestis as $edesti ) {
								$insert_data = array(
									'destination_id' => $last_id ,
									'cat_id'	     => $edesti,
								);
								$insertdb = $this->Common_model->insert_records('tbl_destination_cats', $insert_data);
							}
					    }
					    
						if(!empty($dtypes)){
							foreach ( $dtypes as $dtype ) {
								$insert_data = array(
									'loc_id'         => $last_id,
									'loc_type'       => 1,
									'loc_type_id'	 => $dtype,
								);
								$insertdb = $this->Common_model->insert_records('tbl_multdest_type', $insert_data);
							}
					    }
						
						if(!empty($getatagids)){
							foreach ( $getatagids as $getatagid ) {
								$insert_data = array(
									'type' 		=> 1 ,
									'type_id'	=> $last_id ,
									'tagid'	    => $getatagid,
								);
								$insertdb = $this->Common_model->insert_records('tbl_tags', $insert_data);
							}
						}
						
						if(!empty($nearinfo)){
							foreach ($nearinfo as $nearinfos ) {
								$insert_data = array(
									'destination_id'    => $last_id ,
									'type'    => 2 ,
									'simdest_id'	=> $nearinfos,
								);
								$insertdb = $this->Common_model->insert_records('tbl_destination_places', $insert_data);
							}
						}

						if(!empty($dinfo)){
							foreach ( $dinfo as $otherinfos ) {
								$insert_data = array(
									'destination_id'  => $last_id ,
									'type'  => 1 ,
									'simdest_id'	  => $otherinfos,
								);
								$insertdb = $this->Common_model->insert_records('tbl_destination_places', $insert_data);
							}
						}
						
						$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Destination added successfully.</div>');
					}
					else
					{
						$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> User could not added. Please try again.</div>');
					}
				} 
				else
				{
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added this destination, destination name or URL must be unique .</div>');
				}
				redirect(base_url().'admin/destination/add','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		$this->load->view('admin/add_destination',$data);
	}

	public function edit()
	{
		$editid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("destination_id","tbl_destination","destination_id='$editid' ");
		if($noof_rec>0)
		{
			$data['message'] = $this->session->flashdata('message');
			$data['row'] = $this->Common_model->get_records("*","tbl_destination","destination_id='$editid'","");
			if (isset($_POST['btnSubmit']) && !empty($_POST))
			{
				$this->form_validation->set_rules('destination_name', 'destination_name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('destination_url',  'destination_url', 'trim|required|xss_clean');
				$this->form_validation->set_rules('state', 'state.',  'trim|required|xss_clean');
				$this->form_validation->set_rules('pick_drop_price', 'Pick / Drop Price', 'trim|required|xss_clean');
				$this->form_validation->set_rules('accomodation_price', 'Minimum Accomodation Price ', 'trim|required|xss_clean');
				$this->form_validation->set_rules('latitude', 'Destination Latitude', 'trim|required|xss_clean');
				$this->form_validation->set_rules('longitude', 'Destination Longitude', 'trim|required|xss_clean');
				
				$sess_userid = $this->session->userdata('userid');
				$date = date("Y-m-d H:i:s");
				if ($this->form_validation->run() == true)
				{					
					$dname 		= $this->input->post('destination_name');
					$durl 		= $this->input->post('destination_url');
					$dlatitude 	= $this->input->post('latitude');
					$dlongitude = $this->input->post('longitude');
					$dstate 	= $this->input->post('state');
					$dtrip      = $this->input->post('trip_duration');
					$dcity      = $this->input->post('nearest_city');
					$dtime      = $this->input->post('visit_time');
					$dpeak      = $this->input->post('peak_season');
					$dweather   = $this->input->post('weather_info');      
					$drating    = $this->input->post('rating'); 
					$dmap       = $this->input->post('google_map'); 
					$ddesc 	    = $this->input->post('short_desc');
					$pvdesc 	= $this->input->post('places_to_visit_desc');
					$internet   = $this->input->post('internet_avl');
					$std        = $this->input->post('std_code');
					$lspeak     = $this->input->post('lng_spk');
					$mfest      = $this->input->post('mjr_fest');
					$ntips      = $this->input->post('note_tips');
					$desttype_for_home  = $this->input->post('desttype_for_home');
					$show_on_footer     = $this->input->post('show_on_footer');
					$pick_drop_price 	= $this->input->post('pick_drop_price');
					$accomodation_price	= $this->input->post('accomodation_price');
					$gettagids      = $this->input->post('gettagid');
					$edestis      	= $this->input->post('edesti');				
					$destiimg      	= $this->input->post('destiimg');
					$destismallimg      = $this->input->post('destismallimg');					
					$meta_title	 	    = $this->input->post('meta_title');					
					$meta_keywords	 	= $this->input->post('meta_keywords');					
					$meta_description	= $this->input->post('meta_description');
					
				$place_meta_title	 	    = $this->input->post('place_meta_title');
				$place_meta_keywords	 	= $this->input->post('place_meta_keywords');
				$place_meta_description	= $this->input->post('place_meta_description');
				
				$package_meta_title	 	    = $this->input->post('package_meta_title');
				$package_meta_keywords	 	= $this->input->post('package_meta_keywords');
				$package_meta_description	= $this->input->post('package_meta_description');
				
					$alttag_banner 		= $this->input->post('alttag_banner');
					$alttag_thumb 		= $this->input->post('alttag_thumb');
					
					$noof_duprec = $this->Common_model->noof_records("destination_name","tbl_destination","(destination_name = '$dname' or destination_url = '$durl') and destination_id!='$editid' ");	
				
					$show_on_footernew = ($show_on_footer > 0) ? $show_on_footer : '0';
													
					if($noof_duprec < 1)	
					{	
						/************For destination Image***************/	
						$imofilename = $this->Common_model->seo_friendly_url($alttag_banner);
						$thumbfilename = $this->Common_model->seo_friendly_url($alttag_thumb);					
						$rimage = $this->Common_model->showname_fromid("destiimg","tbl_destination","destination_id='$editid'");
						if (isset($_FILES['destiimg']) && $_FILES['destiimg']['name'] != '') {						
							$unlinkimage = getcwd().'/uploads/'.$rimage;
							if (file_exists($unlinkimage) && !is_dir($unlinkimage))
							{
								unlink($unlinkimage);
							}
							$filename = $this->Common_model->ddoo_upload('destiimg', 2000 , 350, $imofilename);
							
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
						
						$rimagethumb = $this->Common_model->showname_fromid("destiimg_thumb","tbl_destination","destination_id='$editid'");
						if (isset($_FILES['destismallimg']) && $_FILES['destismallimg']['name'] != '') {
							$unlinkimagethumb = getcwd().'/uploads/'.$rimagethumb;
							if (file_exists($unlinkimagethumb) && !is_dir($unlinkimagethumb))
							{
								unlink($unlinkimagethumb);
							}
							$destbannerthumb_imgnew = $this->Common_model->thumbddoo_upload('destismallimg', 300 , 225, $thumbfilename);
						} else {
							$oldname = getcwd().'/uploads/'.$rimagethumb;
							if(file_exists($oldname)) {
								$extensionArr = explode(".", $rimagethumb);
								$extension = end($extensionArr);
								$newname = getcwd().'/uploads/'.$thumbfilename.'.'.$extension;
								rename($oldname, $newname);
								$destbannerthumb_imgnew = $thumbfilename.'.'.$extension;
							} else {
								$destbannerthumb_imgnew = $rimagethumb;
							}
						} 
					
						/***************End of destination image*********/
					
						$update_data = array(
							'destination_name'		=> $dname,
							'destination_url'	    => $durl,
							'latitude'	    		=> $dlatitude,
							'longitude'	    		=> $dlongitude,
							'state'		            => $dstate,
							'trip_duration'	        => $dtrip,  	
							'nearest_city'	        => $dcity, 
							'visit_time'	        => $dtime,  	
							'peak_season'	        => $dpeak,
							'weather_info'	        => $dweather,
							'destiimg'	            => $filename,
							'destiimg_thumb'	    => $destbannerthumb_imgnew,
							'alttag_banner' 		=> $alttag_banner,
							'alttag_thumb' 			=> $alttag_thumb,
							'google_map'	        => $dmap,
							'about_destination'	    => $ddesc, 
							'places_visit_desc'	    => $pvdesc,
							'internet_availability' => $internet,
							'std_code'              => $std,
							'language_spoken'       => $lspeak,
							'major_festivals'       => $mfest,
							'note_tips'             => $ntips,
							'meta_title'            => $meta_title,
							'meta_keywords'         => $meta_keywords,
							'meta_description'      => $meta_description,
							
							'place_meta_title'            => $place_meta_title,
    						'place_meta_keywords'         => $place_meta_keywords,
    						'place_meta_description'      => $place_meta_description,
    						
    						'package_meta_title'            => $package_meta_title,
    						'package_meta_keywords'         => $package_meta_keywords,
    						'package_meta_description'      => $package_meta_description,
    						
							'updated_by'	        => $sess_userid,
							'updated_date'	        => $date,
							'desttype_for_home'	    => $desttype_for_home,
							'show_on_footer'	    => $show_on_footernew,
							'pick_drop_price'	    => $pick_drop_price,
							'accomodation_price'	=> $accomodation_price
						);
						
						$updatedb = $this->Common_model->update_records('tbl_destination',$update_data,"destination_id=$editid");
						if($updatedb)
						{
							$type_id = $this->input->post('destination_type');                     
							$tagid   = $this->input->post('edesti');
							$placeid   = $this->input->post('near_info');
							$destination_id   = $this->input->post('other_info');
							$datee = date("Y-m-d H:i:s");
							
							$this->Common_model->delete_records("tbl_multdest_type","loc_id=$editid");
							if (($type_id != '')) {
								$countmtt = sizeof($type_id);
								for($k=0; $k<$countmtt; $k++)
								{
									$vatag = $type_id[$k];
									$valltagid = $vatag;								

									$noof_duprc1 = $this->Common_model->noof_records("loc_type_id, multdest_id", "tbl_multdest_type", "loc_id='$editid' and loc_type = 1 and loc_type_id='$vatag'");								
									if($noof_duprc1<1)
									{
										$query_datachild1 = array(																			
											'loc_id'         => $editid,
											'loc_type'       => 1,
											'loc_type_id'	 => $vatag,						
										);
										$insert_record1 = $this->Common_model->insert_records("tbl_multdest_type", $query_datachild1);
									}
								}  
							}  
							
							$this->Common_model->delete_records("tbl_destination_cats","destination_id=$editid");
                      
							if (($edestis != '')) {
								$countmtt = sizeof($edestis);
								for($k=0; $k < $countmtt; $k++)
								{
									$vaatag = $edestis[$k];	
										$query_datachild1 = array(
											'destination_id'	=> $editid,
											'cat_id'		    => $vaatag							
										);
									$insert_record1 = $this->Common_model->insert_records("tbl_destination_cats", $query_datachild1);
								}  
							} 						
						
							$this->Common_model->delete_records("tbl_tags","type_id=$editid and type= 1");
							if (($gettagids != '')) {														
								$countmtt = sizeof($gettagids);
								for($k=0; $k < $countmtt; $k++)
								{
									$vaatag = $gettagids[$k];
									$valltagid = $vaatag;
																	
									$query_datachild2 = array(
										'type'		=> 1,
										'type_id'	=> $editid,
										'tagid'		=> $vaatag							
									);
									//print_r($query_datachild2); 
									$insert_record1 = $this->Common_model->insert_records("tbl_tags", $query_datachild2);
								}  
							}					
						
							$this->Common_model->delete_records("tbl_destination_places","destination_id=$editid and type=2");
							if (($placeid != '')) {
								$countmtt = sizeof($placeid);
								for($k=0; $k<$countmtt; $k++)
								{
									$placetag = $placeid[$k];
									$placetagid = $placetag;								

									$noof_duprc1 = $this->Common_model->noof_records("destination_id, dest_placeid", "tbl_destination_places", "destination_id='$editid' and type=2 and simdest_id='$placetag'");
									if($noof_duprc1<1)
									{
										$query_datachild1 = array(
											'destination_id'	=> $editid,
											'type'	=> 2,
											'simdest_id' => $placetag				
										);
										$insert_record1 = $this->Common_model->insert_records("tbl_destination_places", $query_datachild1);
									}
								}  
							} 
						
							$this->Common_model->delete_records("tbl_destination_places","destination_id=$editid and type=1");

							if (($destination_id != '')) {
								$countmtt = sizeof($destination_id);
								for($k=0; $k<$countmtt; $k++)
								{
									$simdest = $destination_id[$k];
									$simdesttid = $simdest;								

									$noof_duprc1 = $this->Common_model->noof_records("destination_id, dest_placeid", "tbl_destination_places", "destination_id='$editid' and type=1 and simdest_id='$simdest'");
									if($noof_duprc1<1)
									{
										$query_datachild1 = array(
											'destination_id'	=> $editid,
											 'type'	=> 1,
											'simdest_id'		    => $simdest,
											//'updated_date'	=> $datee							
										);
										$insert_record1 = $this->Common_model->insert_records("tbl_destination_places", $query_datachild1);
									}
								}  
							}
							
							$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Destination edited successfully.</div>');
						}
						else
						{	
							$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Destination could not edited. Please try again.</div>');
						}
					}
					else
					{	
						$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i>  You have already added this destination, destination name or URL must be unique .</div>');
					}					
					redirect(base_url().'admin/destination/edit/'.$editid,'refresh');
				}
				else
				{
					//set the flash data error message if there is one
					$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				}
			}
			$this->load->view('admin/edit_destination', $data);
		}
		else
			redirect(base_url().'admin/destination','refresh');
	}

	public function delete_destination()
	{
		$delid = $this->uri->segment(4);
        $noof_rec = $this->Common_model->noof_records("destination_id","tbl_destination","destination_id='$delid'");
        if($noof_rec>0)
        {		

            $proimg=$this->Common_model->showname_fromid("destiimg","tbl_destination","destination_id='$delid'");				
            $dest_thumbimg=$this->Common_model->showname_fromid("destiimg_thumb","tbl_destination","destination_id='$delid'");				
			  $unlinkimage = getcwd().'/uploads/'.$proimg;
			  $unlink_thumb_image = getcwd().'/uploads/'.$dest_thumbimg;														
					if (file_exists($unlinkimage) && !is_dir($unlinkimage))
					{
						unlink($unlinkimage);
					}
					if (file_exists($unlink_thumb_image) && !is_dir($unlink_thumb_image))
					{
						unlink($unlink_thumb_image);
					}
			
            $del_dest_tag = $this->Common_model->delete_records("tbl_destination_cats","destination_id=$delid");
            $del_multdest_type = $this->Common_model->delete_records("tbl_multdest_type","loc_id=$delid");
            $del_simillar_dest = $this->Common_model->delete_records("tbl_destination_places","destination_id=$delid");
			//$del_dest_place = $this->Common_model->delete_records("tbl_place_type","destination_id=$delid");
            $del = $this->Common_model->delete_records("tbl_destination","destination_id=$delid");

            if($del)
            {    
                $this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Destination has been deleted successfully.</div>');
            }
            else
            {
                $this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Destination could not deleted. Please try again.</div>');
            }
        }
		redirect(base_url().'admin/destination','refresh');
	}
	
	public function changestatus()
	{
		$stsid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("destination_id","tbl_destination","destination_id='$stsid' ");
		if($noof_rec>0)
		{			
			$status = $this->Common_model->showname_fromid("status","tbl_destination","destination_id=$stsid");
			if($status==1)
				$updatedata = array('status' => 0);
			else
				$updatedata = array('status' => 1);
			$updatestatus = $this->Common_model->update_records("tbl_destination",$updatedata,"destination_id=$stsid");
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
		$noof_rec = $this->Common_model->noof_records("destination_id","tbl_destination","destination_id='$viewid'");
		if($noof_rec>0)
		{
			$data['dstype'] = $this->Common_model->get_records("*","tbl_destination","destination_id=$viewid","");
			$this->load->view('admin/view_destination',$data);
		}
	}
	 	
	/*function ddoo_upload($filename, $width='', $height='')
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'jpg|jpeg';
		$config['overwrite'] = FALSE;
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);
		
		$config['width'] = $width;
		$config['height'] = $height;
				
		$config['x_axis'] = $width;
		$config['y_axis'] = $height;
		
		$this->load->library('image_lib', $config);								
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
		
		if ($this->upload->do_upload($filename)) {
			$data = $this->upload->data();
			print_r($data); exit;
			$filename = $data['file_name'];			
			return $filename;
		} else {			
			echo $this->upload->display_errors();die();
			return NULL;
		}
	}	*/	

	






}
 
	
