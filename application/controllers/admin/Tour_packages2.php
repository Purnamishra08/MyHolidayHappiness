<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tour_packages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url', 'form');
        $this->load->library('session');
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="errormsg notification"><i class="fa fa-times"></i> ', '</div>');
        $this->load->database();
        $this->load->model('Common_model');
        $this->load->library('pagination');
        if ($this->session->userdata('userid') == "") {
            redirect(base_url() . 'admin/logout', 'refresh');
        }
        
        $allusermodules = $this->session->userdata('allpermittedmodules');
		if(!(in_array(10, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}
    }

    public function index() {
        $data['message'] = $this->session->flashdata('message');
        // $data['row'] = $this->Common_model->get_records("*", "tbl_tourpackages", "", "tourpackageid DESC", "", "");
        $this->load->view('admin/manage_tpackages', $data);
    }

    public function datatable(){
		$arrPageData = $_REQUEST;
		$packages = isset($arrPageData['packages']) ? $arrPageData['packages'] : "";
		$starting_city = isset($arrPageData['starting_city']) ? $arrPageData['starting_city'] : 0;
		$itinerary = isset($arrPageData['itinerary']) ? $arrPageData['itinerary'] : 0;
		$pduration = isset($arrPageData['pduration']) ? $arrPageData['pduration'] : 0;
		$statusid = isset($arrPageData['statusid']) ? $arrPageData['statusid'] : 0;
		$whereCond = '';
        if($packages != ''){
			$whereCond .= "tpackage_name like '%".$packages."%' and ";
		}

		if($starting_city > 0){
			$whereCond .= "starting_city = $starting_city and ";
		}

		if($itinerary > 0){
			$whereCond .= "itinerary = $itinerary and ";
		}

		if($pduration > 0){
			$whereCond .= "package_duration = $pduration and ";
		}
		if($statusid > 0){
			if($statusid == 1){
				$whereCond .= "status = $statusid and ";
			} else {
				$whereCond .= "status = 0 and";
			}
		}
		$whereCond = rtrim($whereCond, " and ");
 
		$rowCnt = $this->Common_model->noof_records("tourpackageid","tbl_tourpackages","$whereCond");
		if ($arrPageData['length'] == -1) {
			$rows = $this->Common_model->get_records("*","tbl_tourpackages","$whereCond", " tourpackageid DESC");
		} else {
			$rows = $this->Common_model->get_records("*","tbl_tourpackages","$whereCond", " tourpackageid DESC",$arrPageData['length'], $arrPageData['start']);
		}
      
		if(!empty($rows) && count((array)$rows) > 0) {
			foreach ($rows as $key => $val) {
				$rows[$key]['sl_no'] = ++$arrPageData['start'];

                $en_admin = $this->Common_model->encode("admin");
				$rows[$key]['tpackage_url'] = base_url().'packages/'.$rows[$key]['tpackage_url'].'/?preview='.$en_admin;

                $package_itinerary = $rows[$key]['itinerary'];
                $rows[$key]['package_itinerary_name'] = $this->Common_model->showname_fromid("itinerary_name","tbl_itinerary","itinerary_id=$package_itinerary");
                $rows[$key]['package_itinerary_url'] = base_url().'admin/itinerary/view/'.$package_itinerary;;
		
                $package_starting_city = $rows[$key]['starting_city'];
                $rows[$key]['package_starting_city_name'] = $this->Common_model->showname_fromid("destination_name","tbl_destination","destination_id=$package_starting_city");
                                                     
                $package_duration = $rows[$key]['package_duration'];
                $rows[$key]['package_durationnew'] = $this->Common_model->showname_fromid("duration_name","tbl_package_duration","durationid=$package_duration");
                
                $tpackage_image = $rows[$key]['tpackage_image'];
                $rows[$key]['tpackage_image_url'] = "";
                if(file_exists("./uploads/".$tpackage_image) && ($tpackage_image!=''))
                { 
                    $rows[$key]['tpackage_image_url'] = base_url().'uploads/'.$tpackage_image;
                }
                
                $tour_thumb = $rows[$key]['tour_thumb'];
                if(file_exists("./uploads/".$tour_thumb) && ($tour_thumb!=''))
                { 
                    $rows[$key]['tour_thumb'] = base_url().'uploads/'.$tour_thumb;
                }
			}
		} else {
			$rows = [];
		}
	
		echo json_encode([
            'draw' => isset($arrPageData['draw']) ? intval($arrPageData['draw']) : 0,
            'recordsTotal' => $rowCnt,
            'whereCond' => $whereCond,
            'recordsFiltered' => $rowCnt, // For simplicity, assuming no filtering
            'data' => $rows
        ]);
		exit;
	}

/*    public function pdf_generator(){
        $data['message'] = $this->session->flashdata('message');
        $data['row'] = $this->Common_model->get_records("*", "tbl_tourpackages", "", "tourpackageid DESC", "", "");
		$this->load->view('admin/pdf_generator',$data);
    }*/
    
	public function get_package_max_capacity()
	{
	    echo 1;
		    $package_data=$this->Common_model->get_records("starting_city","tbl_tourpackages","tourpackageid=".$_REQUEST["package_id"]);
    		foreach ($package_data as $packages) {
    			$package_startingcity = $this->db->escape($packages["starting_city"]);
    		} 
		
	      echo 2;
		 $noof_vehicle = $this->Common_model->noof_records("a.priceid", "tbl_vehicleprices as a, tbl_vehicletypes as b", "a.vehicle_name=b.vehicleid and a.destination='$package_startingcity' and a.status=1");

            $max_vehicle_capacity = 0;
            if ($noof_vehicle > 0) {
                $max_vehicle_capacity = $this->Common_model->showname_fromid("max(b.capacity)", "tbl_vehicleprices as a, tbl_vehicletypes as b", "a.vehicle_name=b.vehicleid and a.destination=$package_startingcity and a.status=1");
            }
             echo 3;
        echo $max_vehicle_capacity;
		exit();
	}
		public function get_package_accommodations()
	{
	    
		    $package_data=$this->Common_model->get_records("starting_city","tbl_tourpackages","tourpackageid=".$_REQUEST["package_id"]);
    		foreach ($package_data as $packages) {
    			$package_startingcity = $this->db->escape($packages["starting_city"]);
    		} 
		
		    $tourpackageid=$_REQUEST["package_id"];
	
		  $accommodation_types = $this->Common_model->join_records("DISTINCT(a.hotel_type) as hotel_type_id", "tbl_hotel as a", "tbl_hotel_type as b", "a.hotel_type=b.hotel_type_id", "a.status=1 and a.destination_name in ( select destination_id from tbl_package_accomodation where package_id=$tourpackageid)", "b.hotel_type_name desc");
            ?>  <option value=""> - - Select Accommodation - - </option> <?php
            $hotel_typeids = array();
            if (!empty($accommodation_types)) {
                foreach ($accommodation_types as $accommodation_type) {
                    $hotel_typeids[] = $accommodation_type["hotel_type_id"];
                }
                $hotel_typeid = implode(", ", $hotel_typeids);
                $first_hoteltype = $hotel_typeids[0];
                echo $this->Common_model->populate_select($dispid = "", "hotel_type_id", "hotel_type_name", " tbl_hotel_type", "hotel_type_id in ($hotel_typeid)", "hotel_type_name desc", "");
            }
		exit();
	}
    public function add() {
        $data['messageadd'] = $this->session->flashdata('messageadd');
        if (isset($_POST['btnSubmitPlace']) && !empty($_POST)) {
            $this->form_validation->set_rules('tpackage_name', 'Package name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('tpackage_url', 'Package URL', 'trim|required|xss_clean|is_unique[tbl_tourpackages.tpackage_url]');		
            $this->form_validation->set_rules('tpackage_code', 'Package code', 'trim|required|xss_clean|is_unique[tbl_tourpackages.tpackage_code]');
            $this->form_validation->set_rules('pduration', 'Package duration', 'required');
			$this->form_validation->set_rules('price', 'Price', 'trim|required|xss_clean');
			$this->form_validation->set_rules('fakeprice', 'Fake price', 'trim|required|xss_clean');
            $this->form_validation->set_rules('getatagid[]', 'Getaway tags', 'required');
            $this->form_validation->set_rules('pmargin_perctage', 'Profit margin perctage', 'trim|required|xss_clean');
			$this->form_validation->set_rules('itinerary', 'Itinerary', 'trim|required|xss_clean');
			$this->form_validation->set_rules('starting_city', 'Starting city', 'trim|required|xss_clean');	
            $this->form_validation->set_rules('inclusion', 'Inclusion / Exclusion', 'trim|required|xss_clean');

            if ($this->form_validation->run() == true) {
                $tpackage_name = $this->input->post('tpackage_name');
                $tpackage_url = $this->input->post('tpackage_url');
                $tpackage_code = $this->input->post('tpackage_code');
                $pduration = $this->input->post('pduration');
                $pmargin_perctage = $this->input->post('pmargin_perctage');
                $rating = $this->input->post('rating');
                $getatagids = $this->input->post('getatagid');
                $tourimo = $this->input->post('tourimo');                
                $price = $this->input->post('price');
                $fakeprice = $this->input->post('fakeprice');
                $inclusion = $this->input->post('inclusion');
				$itinerary_note = $this->input->post('itinerary_note');
                $dest_name = $this->input->post('dest_name');
                $accomodation = $this->input->post('accomodation');
                $tourtransport = $this->input->post('tourtransport');
                $sightseeing = $this->input->post('sightseeing');
                $breakfast = $this->input->post('breakfast');
				$waterbottle = $this->input->post('waterbottle');
				$packtype = $this->input->post('packtype');
				$itinerary = $this->input->post('itinerary');
				$starting_city = $this->input->post('starting_city');
                $meta_title = $this->input->post('meta_title');
                $meta_keywords = $this->input->post('meta_keywords');
                $meta_description = $this->input->post('meta_description'); 
                
                $show_video_itinerary = $this->input->post('show_video_itinerary')=='on'?1:0;
                $video_itinerary_link = $this->input->post('video_itinerary_link'); 
                
                $noof_duprec = $this->Common_model->noof_records("tourpackageid", "tbl_tourpackages", "tpackage_code = '$tpackage_code' or tpackage_url = '$tpackage_url' ");              
                $date = date("Y-m-d H:i:s");
                $accomodationnew = ($accomodation > 0) ? $accomodation : '0';
                $tourtransportnew = ($tourtransport > 0) ? $tourtransport : '0';
                $sightseeingnew = ($sightseeing > 0) ? $sightseeing : '0';
                $breakfastnew = ($breakfast > 0) ? $breakfast : '0';
				$waterbottlenew = ($waterbottle > 0) ? $waterbottle : '0';
				
                if ($noof_duprec < 1) {
                    /*********************For tour package image ********************/

                    if (isset($_FILES['tourimo']) && $_FILES['tourimo']['name'] != '') {
                        $filename = $this->Common_model->ddoo_upload('tourimo', 745 , 450);
                    } else {
                        $filename = NULL;
                    } 
                    
                    if (isset($_FILES['tourthumb']) && $_FILES['tourthumb']['name'] != '') {
                        $tourthumb_imgnew = $this->Common_model->thumbddoo_upload('tourthumb', 300 , 225);
                    } else {
                        $tourthumb_imgnew = NULL;
                    } 
                    
                   /*********************end of package image********************/
                    $insert_data = array(
                        'tpackage_name' => $tpackage_name,
                        'tpackage_url' => $tpackage_url,
                        'tpackage_code' => $tpackage_code,
                        'package_duration' => $pduration,
                        'pmargin_perctage' => $pmargin_perctage,
                        'tpackage_image' => $filename, 
                        'tour_thumb' => $tourthumb_imgnew, 
                        'price'         => $price,
						'fakeprice'     => $fakeprice,
                        'ratings' => $rating,
                        'inclusion_exclusion' => $inclusion,
						'itinerary_note' => $itinerary_note,
                        'accomodation' => $accomodationnew,
                        'tourtransport' => $tourtransportnew,
                        'sightseeing' => $sightseeingnew,
                        'breakfast' => $breakfastnew,
						'waterbottle' => $waterbottlenew,
						'status' => 1,
						'pack_type' => $packtype,
						'itinerary' => $itinerary,
						'starting_city' => $starting_city,
                        'meta_title' => $meta_title,
                        'meta_keywords' => $meta_keywords,
                        'meta_description' => $meta_description,
						'show_video_itinerary'=>$show_video_itinerary,
						'video_itinerary_link'=>$video_itinerary_link,
                        'created_date' => $date
                    );                   
                    
                    $data['pakdurations'] = $pduration;
                    $insertdb = $this->Common_model->insert_records('tbl_tourpackages', $insert_data);
                    if ($insertdb) {
                        $last_id = $this->db->insert_id();
                        /* Data insert to tag table */
                        if (!empty($getatagids)) {
                            foreach ($getatagids as $getatagid) {
                                $insert_data = array(                                     
                                    'type_id'  	=> $last_id,
									'type'      => 3,				
									'tagid'      => $getatagid														
                                );
                                $insertdb = $this->Common_model->insert_records('tbl_tags', $insert_data);
                            }
                        }
						
						$destination_id= $this->input->post('destination_id');
						$no_ofdays    = $this->input->post('no_ofdays');
							
						if(count($destination_id) > 0)
						{
							for ( $i = 0; $i < count($destination_id); $i++ )
							{
								$destination_id_row = $destination_id[$i];
								$no_ofdays_row   	 = $no_ofdays[$i];
								
								$query_data = array(
									'package_id'		=> $last_id,
									'destination_id'	=> $destination_id_row,
									'noof_days'      	=> $no_ofdays_row
								);
								$querydb = $this->Common_model->insert_records('tbl_package_accomodation', $query_data);
							}
						}
						
						$this->session->set_flashdata('messageadd', '<div class="successmsg notification"><i class="fa fa-check"></i> Package added successfully.</div>');
						//redirect(base_url().'admin/package-iternary/add/'.$last_id, 'refresh');                        
                    } else {
                        $this->session->set_flashdata('messageadd', '<div class="errormsg notification"><i class="fa fa-times"></i> Package could not added. Please try again.</div>');
                    }
                     redirect(base_url().'admin/tour-packages/add/', 'refresh');
                } else {
                    $this->session->set_flashdata('messageadd', '<div class="errormsg notification"><i class="fa fa-times"></i> You have already added this tour package, package name or URL must be unique.</div>');
                }
                redirect(base_url() . 'admin/tour-packages/add/', 'refresh');
            } else {
                $data['messageadd'] = (validation_errors() ? validation_errors() : $this->session->flashdata('messageadd'));
            }
        }
        $this->load->view('admin/add_tpackages', $data);
    }

    public function delete() {
        $delid = $this->uri->segment(4);
        $noof_rec = $this->Common_model->noof_records("tourpackageid", "tbl_tourpackages", "tourpackageid='$delid'");

        if ($noof_rec > 0) {
			$proimg=$this->Common_model->showname_fromid("tpackage_image","tbl_tourpackages","tourpackageid='$delid'");                
			$dest_thumbimg=$this->Common_model->showname_fromid("tour_thumb","tbl_tourpackages","tourpackageid='$delid'");              
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

            $del = $this->Common_model->delete_records("tbl_tags", "type_id = $delid and type = 3");
			$del = $this->Common_model->delete_records("tbl_package_accomodation", "package_id = $delid");

            if ($del) {
                $this->Common_model->delete_records("tbl_tourpackages", "tourpackageid = $delid");
                $this->session->set_flashdata('message', '<div class="successmsg notification"><i class="fa fa-check"></i> Tour package has been deleted successfully.</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="errormsg notification"><i class="fa fa-times"></i> Tour package could not deleted. Please try again.</div>');
            }
        }
        redirect(base_url() . 'admin/tour-packages', 'refresh');
    }

    public function changestatus() {
        $stsid = $this->uri->segment(4);
        $noof_rec = $this->Common_model->noof_records("tourpackageid", "tbl_tourpackages", "tourpackageid='$stsid'");
        if ($noof_rec > 0) {
            $status = $this->Common_model->showname_fromid("status", "tbl_tourpackages", "tourpackageid=$stsid");
            if ($status == 1)
                $updatedata = array('status' => 0);
            else
                $updatedata = array('status' => 1);
            $updatestatus = $this->Common_model->update_records("tbl_tourpackages", $updatedata, "tourpackageid=$stsid");

            if ($updatestatus)
                echo $status;
            else
                echo "error";
        }
        exit();
    }

    public function edit() {
        $editid = $this->uri->segment(4);
        $data['message'] = $this->session->flashdata('message');

        $noof_rec = $this->Common_model->noof_records("tourpackageid", "tbl_tourpackages", "tourpackageid='$editid'");
        
        if ($noof_rec > 0) {
            $data['edittourpackages'] = $this->Common_model->get_records("*", "tbl_tourpackages", "tourpackageid='$editid'");
        }
        
        $this->form_validation->set_rules('tpackage_name', 'Package name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('tpackage_url', 'Package url', 'trim|required|xss_clean');
        $this->form_validation->set_rules('tpackage_code', 'Package code', 'trim|required|xss_clean');
        $this->form_validation->set_rules('price', 'Price', 'trim|required|xss_clean');
        $this->form_validation->set_rules('fakeprice', 'Fake price', 'trim|required|xss_clean');
        $this->form_validation->set_rules('getatagid[]', 'Petaway tags', 'trim|required|xss_clean');
        $this->form_validation->set_rules('pmargin_perctage', 'Profit margin perctage', 'trim|required|xss_clean');
		$this->form_validation->set_rules('itinerary', 'Itinerary', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('starting_city', 'Starting city', 'trim|required|xss_clean');	
        $this->form_validation->set_rules('inclusion', 'Inclusion / Exclusion', 'trim|required|xss_clean');

        if ($this->form_validation->run() == true) {
            $tpackage_name = $this->input->post('tpackage_name');
            $tpackage_url = $this->input->post('tpackage_url');
            $tpackage_code = $this->input->post('tpackage_code');
            $pduration = $this->input->post('pduration');            
            $price = $this->input->post('price');
            $fakeprice = $this->input->post('fakeprice');              
            $pmargin_perctage = $this->input->post('pmargin_perctage');
            $rating = $this->input->post('rating');
            $getatagids = $this->input->post('getatagid');
            $tourimo = $this->input->post('tourimo');
            $inclusion = $this->input->post('inclusion');
			$itinerary_note = $this->input->post('itinerary_note');
            $dest_name = $this->input->post('dest_name');
            $accomodation = $this->input->post('accomodation');
            $tourtransport = $this->input->post('tourtransport');
            $sightseeing = $this->input->post('sightseeing');
            $breakfast = $this->input->post('breakfast');
			$waterbottle = $this->input->post('waterbottle');
			$pack_type = $this->input->post('packtype');
			$itinerary = $this->input->post('itinerary');
			$starting_city = $this->input->post('starting_city');
            $meta_title = $this->input->post('meta_title');
            $meta_keywords = $this->input->post('meta_keywords');
            $meta_description = $this->input->post('meta_description');
            
            $show_video_itinerary = $this->input->post('show_video_itinerary')=='on'?1:0; 
            $video_itinerary_link = $this->input->post('video_itinerary_link'); 
            
            
            $noof_duprec = $this->Common_model->noof_records("tourpackageid", "tbl_tourpackages", "(tpackage_code = '$tpackage_code'  or tpackage_url = '$tpackage_url') and  tourpackageid!='$editid'");

            if ($noof_duprec < 1) {

                $date = date("Y-m-d H:i:s");
                $accomodationnew = ($accomodation > 0) ? $accomodation : '0';
                $tourtransportnew = ($tourtransport > 0) ? $tourtransport : '0';
                $sightseeingnew = ($sightseeing > 0) ? $sightseeing : '0';
                $breakfastnew = ($breakfast > 0) ? $breakfast : '0';
				$waterbottlenew = ($waterbottle > 0) ? $waterbottle : '0';	

                ///Start impage upload
                    $rimage = $this->Common_model->showname_fromid("tpackage_image","tbl_tourpackages","tourpackageid='$editid'");
                    if (isset($_FILES['tourimo']) && $_FILES['tourimo']['name'] != '') {                      
                        $unlinkimage = getcwd().'/uploads/'.$rimage;
                        
                        if (file_exists($unlinkimage) && !is_dir($unlinkimage))
                        {
                            unlink($unlinkimage);
                        }           
                        
                        $filename = $this->Common_model->ddoo_upload('tourimo', 745 , 450);
                        
                    } else {
                        $filename = $rimage;
                    }                 
                        
                    $rimagethumb = $this->Common_model->showname_fromid("tour_thumb","tbl_tourpackages","tourpackageid='$editid'");
                    if (isset($_FILES['tourthumb']) && $_FILES['tourthumb']['name'] != '') {
                        
                        $unlinkimagethumb = getcwd().'/uploads/'.$rimagethumb;
                        
                        if (file_exists($unlinkimagethumb) && !is_dir($unlinkimagethumb))
                        {
                            unlink($unlinkimagethumb);
                        }
                        
                        $thumb_imgnew = $this->Common_model->thumbddoo_upload('tourthumb', 300 , 225);
                    } else {
                        $thumb_imgnew = $rimagethumb;
                    }                     
                
					$date = date("Y-m-d H:i:s");
               
					$update_data = array(
						'tpackage_name' => $tpackage_name,
						'tpackage_url' => $tpackage_url,
						'tpackage_code' => $tpackage_code,
						'package_duration' => $pduration,
						'price'         => $price,
						'fakeprice'     => $fakeprice,
						'pmargin_perctage' => $pmargin_perctage,
						'tpackage_image' => $filename,
						'tour_thumb' => $thumb_imgnew,
						'ratings' => $rating,
						'inclusion_exclusion' => $inclusion,
						'itinerary_note' => $itinerary_note,
						'accomodation' => $accomodationnew,
						'tourtransport' => $tourtransportnew,
						'sightseeing' => $sightseeingnew,
						'breakfast' => $breakfastnew,
						'waterbottle' => $waterbottlenew,
						'status' => 1,
						'pack_type' => $pack_type,
						'itinerary' => $itinerary,
						'starting_city' => $starting_city,
						'meta_title' => $meta_title,
						'meta_keywords' => $meta_keywords,
						'meta_description' => $meta_description,
						'show_video_itinerary'=>$show_video_itinerary,
						'video_itinerary_link'=>$video_itinerary_link,
						'created_date' => $date
					);
                
					$querydb = $this->Common_model->update_records('tbl_tourpackages', $update_data, "tourpackageid=$editid");
					if ($querydb) {
						$this->Common_model->delete_records("tbl_tags", "type_id=$editid and type= 3");
						foreach ($getatagids as $getatagid) {
							$insert_data_getatags = array( 
								'type_id'  	=> $editid,
								'type'      => 3,				
								'tagid'      => $getatagid										
							);
							$insertmodule = $this->Common_model->insert_records('tbl_tags', $insert_data_getatags);
						}
						
						$destination_id= $this->input->post('destination_id');
						$no_ofdays    = $this->input->post('no_ofdays');							
						
						if(count($destination_id)>0)
						{
							$this->Common_model->delete_records("tbl_package_accomodation", "package_id = $editid");	
							for ( $i = 0; $i < count($destination_id); $i++ )
							{
								$destination_id_row = $destination_id[$i];
								$no_ofdays_row   	 = $no_ofdays[$i];
								
								$query_data = array(
									'package_id'		    => $editid,
									'destination_id'		=> $destination_id_row,
									'noof_days'             => $no_ofdays_row
								);
								$querydb = $this->Common_model->insert_records('tbl_package_accomodation', $query_data);							
							}
						}

						$this->session->set_flashdata('message', '<div class="successmsg notification"><i class="fa fa-check"></i> Tour package edited successfully.</div>');
						//redirect(base_url() . 'admin/tour-packages/edit/' . $editid, 'refresh');
					} else {
						$this->session->set_flashdata('message', '<div class="errormsg notification"><i class="fa fa-times"></i> Tour package could not edited. Please try again.</div>');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="errormsg notification"><i class="fa fa-times"></i> You have already added this tour package, package name or URL must be unique. </div>');
            }
            redirect(base_url() . 'admin/tour-packages/edit/' . $editid, 'refresh');
        } else {
            //set the flash data error message if there is one
            $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
        }
        $this->load->view('admin/edit_tpackages', $data);
    }

    public function view() {
        $viewid = $this->uri->segment(4);
        $noof_rec = $this->Common_model->noof_records("tourpackageid", "tbl_tourpackages", "tourpackageid='$viewid'");
        if ($noof_rec > 0) {
            $data['rows1'] = $this->Common_model->get_records("*", "tbl_tourpackages", "tourpackageid='$viewid'", "tourpackageid DESC", "", "");            
            $this->load->view('admin/view_tour_package', $data);
        }
    }

	public function mark_as_featured()
    {
        $t_id = $this->input->post('tid');        
        $noof_rec = $this->Common_model->noof_records("tourpackageid", "tbl_tourpackages", "tourpackageid='$t_id' and status=1 and is_featured = 0");
        if ($noof_rec > 0) {
            $query_data = array(
                'is_featured' => '1'
            );
            $querydb    = $this->Common_model->update_records('tbl_tourpackages', $query_data, "tourpackageid='$t_id'");
            if ($querydb) {
                echo '<div class="successmsg"><i class="fa fa-check"></i> Package featured successfully.</div>';
            } else {
                echo '<div class="errormsg"><i class="fa fa-check"></i> Package could not featured.</div>';
            }
        } else {
            echo '<div class="errormsg"><i class="fa fa-check"></i> Either the package deactivated or not found.</div>';
        }
        exit();
    }    
    
	public function mark_as_unfeatured()
    {
        $t_id = $this->input->post('tid');        
        $noof_rec = $this->Common_model->noof_records("tourpackageid", "tbl_tourpackages", "tourpackageid='$t_id' and is_featured = 1");
        if ($noof_rec > 0) {
            $query_data = array(
                'is_featured' => '0'
            );
            $querydb    = $this->Common_model->update_records('tbl_tourpackages', $query_data, "tourpackageid='$t_id'");
            if ($querydb) {
                echo '<div class="successmsg"><i class="fa fa-check"></i> Package unfeatured successfully.</div>';
            } else {
                echo '<div class="errormsg"><i class="fa fa-check"></i> Package could not unfeatured.</div>';
            }
        } else {
            echo '<div class="errormsg"><i class="fa fa-check"></i> Package not found.</div>';
        }
        exit();
    }
	
	
}
