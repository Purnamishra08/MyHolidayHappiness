<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menutags extends CI_Controller {

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
		if(!(in_array(8, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}	
 	}

	public function index()
	{
		$data['messageadd'] = $this->session->flashdata('messageadd');	
		$data['message'] = $this->session->flashdata('message');
		$data['row'] = $this->Common_model->get_records("*","tbl_menutags","","tagid DESC","","");

		$this->load->view('admin/manage_menutags',$data);
	}
	
	public function add()
	{
		$data['messageadd'] = $this->session->flashdata('messageadd');

		if (isset($_POST['btnSubmitcats']) && !empty($_POST))
		{				
			$this->form_validation->set_rules('tag_name', 'Tag Name', 'trim|required|xss_clean');	
			$this->form_validation->set_rules('tag_url', 'Tag URL', 'trim|required|xss_clean|is_unique[tbl_menutags.tag_url]');
			$this->form_validation->set_rules('menuid', 'Menu', 'trim|required|xss_clean');
			$this->form_validation->set_rules('catId', 'Category', 'trim|required|xss_clean');				
			//$this->form_validation->set_rules('menutag_img', 'Menu tag image ', 'trim|required|xss_clean');				
			
			if ($this->form_validation->run() == true)
			{				
				$tag_name = $this->input->post('tag_name');	
				$tag_url = $this->input->post('tag_url');	
				$menuid = $this->input->post('menuid');				 
				$catId = $this->input->post('catId');				
				$about_tag = $this->input->post('about_tag');
				$meta_title = $this->input->post('meta_title');				 
				$meta_keywords = $this->input->post('meta_keywords');				
				$meta_description = $this->input->post('meta_description');
				$menutag_img = $this->input->post('menutag_img');
				$menutagthumb_img = $this->input->post('menutagthumb_img');
                $alttag_banner 	= $this->input->post('alttag_banner');
                $alttag_thumb 	= $this->input->post('alttag_thumb');
				$show_on_home = $this->input->post('show_on_home');
				$show_on_footer = $this->input->post('show_on_footer');
				
				$show_on_homenew = ($show_on_home > 0) ? $show_on_home : '0';
				$show_on_footernew = ($show_on_footer > 0) ? $show_on_footer : '0';

				$noof_duprec = $this->Common_model->noof_records("tagid","tbl_menutags","menuid = $menuid and (tag_name ='$tag_name' or tag_url = '$tag_url' )");	
							
				$date = date("Y-m-d H:i:s");
				$sess_userid = $this->session->userdata('userid');
				
				/************For menutag banner***************/	
                    $imofilename = $this->Common_model->seo_friendly_url($alttag_banner);
                    $thumbfilename = $this->Common_model->seo_friendly_url($alttag_thumb);
					if (isset($_FILES['menutag_img']) && $_FILES['menutag_img']['name'] != '') {
						$filename = $this->Common_model->ddoo_upload('menutag_img', 1920 , 488, $imofilename);
					} else {
						$filename = NULL;
					} 
					
					if (isset($_FILES['menutagthumb_img']) && $_FILES['menutagthumb_img']['name'] != '') {
						$filename_thumb = $this->Common_model->thumbddoo_upload('menutagthumb_img', 500 , 350, $thumbfilename);
					} else {
						$filename_thumb = NULL;
					} 
				
				/*****************End of menutag image******************/
				if($noof_duprec < 1)
				{
					$insert_data = array(
						'menuid'	=> $menuid,
						'cat_id'	=> $catId,
						'tag_name'	=> $tag_name,
						'about_tag'	=> $about_tag,
						'menutag_img'	=> $filename,
						'menutagthumb_img'	=> $filename_thumb,
						'alttag_banner' 	=> $alttag_banner,
						'alttag_thumb'		=> $alttag_thumb,
						'show_on_home'	=> $show_on_homenew,
						'show_on_footer'	=> $show_on_footernew,
						'tag_url'	    => $tag_url,
						'meta_title'		=> $meta_title,
						'meta_keywords'		=> $meta_keywords,
						'meta_description'	=> $meta_description,
						'status'		=> 1,
						'created_date'	=> $date,
						'created_by'	=>	$sess_userid									
					);	
								

					$insertdb = $this->Common_model->insert_records('tbl_menutags', $insert_data);
					if($insertdb) {
						$this->session->set_flashdata('messageadd','<div class="successmsg notification"><i class="fa fa-check"></i> Tag added successfully.</div>');
					} else {
						$this->session->set_flashdata('messageadd','<div class="errormsg notification"><i class="fa fa-times"></i> Tag could not added. Please try again.</div>');
					}
				}
				else
				{
					$this->session->set_flashdata('messageadd','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added this tag to this menus and category.</div>');
				}
				redirect(base_url().'admin/menutags/add','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['messageadd'] = (validation_errors() ? validation_errors() : $this->session->flashdata('messageadd'));
			}
		}
		
		$this->load->view('admin/add_menutags',$data);
	}

	public function delete()
	{
		$delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("tagid","tbl_menutags","tagid='$delid'");
		if($noof_rec>0)
		{
			
			$mtagimo = $this->Common_model->showname_fromid("menutag_img","tbl_menutags","tagid=$delid");				
			$menutagthumb_imo = $this->Common_model->showname_fromid("menutagthumb_img","tbl_menutags","tagid=$delid");				
			 	
				$unlinkimage = getcwd().'/uploads/'.$mtagimo;															
					if (file_exists($unlinkimage) && !is_dir($unlinkimage))
					{
						unlink($unlinkimage);
					}
					
									
				$unlink_thumb_image = getcwd().'/uploads/'.$menutagthumb_imo;															
					if (file_exists($unlink_thumb_image) && !is_dir($unlink_thumb_image))
					{
						unlink($unlink_thumb_image);
					}				
			
			$del = $this->Common_model->delete_records("tbl_menutags","tagid=$delid");
			if($del)
				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Tag has been deleted successfully.</div>');
			else
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Tag could not deleted. Please try again.</div>');
		}
		redirect(base_url().'admin/menutags','refresh');
	}

	public function changestatus()
	{
		$stsid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("tagid","tbl_menutags","tagid='$stsid'");
		if($noof_rec>0)
		{
			$status = $this->Common_model->showname_fromid("status","tbl_menutags","tagid=$stsid");
			if($status==1)
				$updatedata = array('status' => 0);
			else
				$updatedata = array('status' => 1);
			$updatestatus = $this->Common_model->update_records("tbl_menutags",$updatedata,"tagid=$stsid");

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
		$noof_rec = $this->Common_model->noof_records("tagid","tbl_menutags","tagid='$editid'");
		if($noof_rec > 0)
		{
			$data['message'] = $this->session->flashdata('message');
			$data['tags'] = $this->Common_model->get_records("*","tbl_menutags","tagid='$editid'");
			
			if (isset($_POST['btnUpdatetag']) && !empty($_POST))
			{			
				$this->form_validation->set_rules('tag_name', 'Tag Name', 'trim|required|xss_clean');	
				$this->form_validation->set_rules('tag_url', 'Tag URL', 'trim|required|xss_clean');
				$this->form_validation->set_rules('menuid', 'Menu', 'trim|required|xss_clean');
				$this->form_validation->set_rules('catId', 'Category', 'trim|required|xss_clean');	
				
				if ($this->form_validation->run() == true)
				{				
					$tag_name = $this->input->post('tag_name');	
					$tag_url = $this->input->post('tag_url');	
					$menuid = $this->input->post('menuid');				 
					$catId = $this->input->post('catId');				
					$about_tag = $this->input->post('about_tag');
					$meta_title = $this->input->post('meta_title');				 
					$meta_keywords = $this->input->post('meta_keywords');				
					$meta_description = $this->input->post('meta_description');	 
					$menutag_img = $this->input->post('menutag_img');	 
					$menutagthumb_img = $this->input->post('menutagthumb_img');
					$alttag_banner 	= $this->input->post('alttag_banner');
					$alttag_thumb 	= $this->input->post('alttag_thumb');	 
					$show_on_home = $this->input->post('show_on_home');	 
					$show_on_footer = $this->input->post('show_on_footer');	 
					$date = date("Y-m-d H:i:s");
					$sess_userid = $this->session->userdata('userid');
										
					$noof_duprec = $this->Common_model->noof_records("tagid","tbl_menutags","menuid = $menuid and tagid!='$editid' and (tag_name ='$tag_name' or tag_url = '$tag_url' )");
					
					$show_on_homenew = ($show_on_home > 0) ? $show_on_home : '0';
					$show_on_footernew = ($show_on_footer > 0) ? $show_on_footer : '0';
	
					
					
					if($noof_duprec < 1)
					{			
									
						/******************Edit menutag photo**********************/
							$imofilename = $this->Common_model->seo_friendly_url($alttag_banner);
							$thumbfilename = $this->Common_model->seo_friendly_url($alttag_thumb);
							$rimage = $this->Common_model->showname_fromid("menutag_img","tbl_menutags","tagid=$editid");
								
								if (isset($_FILES['menutag_img']) && $_FILES['menutag_img']['name'] != '') {                      
									$unlinkimage = getcwd().'/uploads/'.$rimage;
									if (file_exists($unlinkimage) && !is_dir($unlinkimage))
									{
										unlink($unlinkimage);
									}
									$filename = $this->Common_model->ddoo_upload('menutag_img', 1920 , 488, $imofilename);
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
								
									
								$rimagethumb = $this->Common_model->showname_fromid("menutagthumb_img","tbl_menutags","tagid='$editid'");
								if (isset($_FILES['menutagthumb_img']) && $_FILES['menutagthumb_img']['name'] != '') {
									$unlinkimagethumb = getcwd().'/uploads/'.$rimagethumb;
									if (file_exists($unlinkimagethumb) && !is_dir($unlinkimagethumb))
									{
										unlink($unlinkimagethumb);
									}
									$thumb_imgnew = $this->Common_model->thumbddoo_upload('menutagthumb_img', 500 , 350, $thumbfilename);
								} else {
									$oldname = getcwd().'/uploads/'.$rimagethumb;
									if(file_exists($oldname)) {
										$extensionArr = explode(".", $rimagethumb);
										$extension = end($extensionArr);
										$newname = getcwd().'/uploads/'.$thumbfilename.'.'.$extension;
										rename($oldname, $newname);
										$thumb_imgnew = $thumbfilename.'.'.$extension;
									} else {
										$thumb_imgnew = $rimagethumb;
									}
								} 						
							
						/*******************End of menu tag photo*********************/
						
						
						$update_data = array(
							'menuid'	=> $menuid,
							'cat_id'	=> $catId,
							'tag_name'	=> $tag_name,
							'menutag_img'	=> $filename,
							'menutagthumb_img'	=> $thumb_imgnew,
							'alttag_banner' => $alttag_banner,
							'alttag_thumb' 	=> $alttag_thumb,
							'about_tag'	=> $about_tag,
							'tag_url'	=> $tag_url,
							'show_on_home'	=> $show_on_homenew,
							'show_on_footer'	=> $show_on_footernew,
							'meta_title'		=> $meta_title,
							'meta_keywords'		=> $meta_keywords,
							'meta_description'	=> $meta_description,
							'status'		=> 1,
							'updated_date'	=> $date,
							'updated_by'	=> $sess_userid	
						);	
						
						$querydb = $this->Common_model->update_records('tbl_menutags',$update_data,"tagid=$editid");
						if($querydb){
							$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Tag edited successfully.</div>');
						}
						else{
							$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Tag could not edited. Please try again.</div>');
						}
					}
					else
					{
						$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added tags to this menu and category</div>');
					
					}
					redirect(base_url().'admin/menutags/edit/'.$editid,'refresh');
				}
				else
				{
					//set the flash data error message if there is one
					$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				}
			}
			
			$this->load->view('admin/edit_menutags', $data);
		}
		else
			redirect(base_url().'admin/menutags','refresh');
	}
	
	public function view_pop() 
	{
        $viewid = $this->uri->segment(4);
        $rows1 = $this->Common_model->get_records("*","tbl_menutags","tagid='$viewid'","tagid DESC","","");
        if (!empty($rows1)) {
            foreach ($rows1 as $rowss1) {
            $placeid = $rowss1['tagid'];
            $menuid = $rowss1['menuid'];
            $cat_id = $rowss1['cat_id'];
            $status = $rowss1['status'];
            $menutag_img = $rowss1['menutag_img'];
            $menutagthumb_img = $rowss1['menutagthumb_img'];
            $show_on_home = $rowss1['show_on_home'];
            $show_on_footer = $rowss1['show_on_footer'];
            
        }
        ?>
        <div class="modal-header">
			<button type="button" class="close-btn " data-dismiss="modal">&times;</button>
			<h4 class="modal-title pupop-title">Menutag Details</h4>
		</div>
		<div class="modal-body">
			<div class="modal-sub-body">
				<div class="row">

					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Tag Name : </label></div>
							<div class="col-md-8"> <?php echo ucfirst($rowss1['tag_name']); ?></div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Menu Name :  </label></div>
							<div class="col-md-8"> <?php echo ucfirst($this->Common_model->showname_fromid("menu_name", "tbl_menus", "menuid='$menuid'")); ?></div>
						</div>
					</div>					
					<div class="clearfix"></div>
					
					
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label>Category Name : </label></div>
							<div class="col-md-8"> <?php echo ucfirst($this->Common_model->showname_fromid("cat_name", "tbl_menucateories", "menuid='$menuid'"));
			
							?> </div>
						</div>
					</div>
					
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Tag URL	 : </label></div>
							<div class="col-md-8"> <?php echo (trim($rowss1['tag_url'])) ? trim($rowss1['tag_url']) : '-' ; ?></div>
						</div>
					</div>
					
					<div class="clearfix"></div>
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label>Tag Banner : </label></div>
							<div class="col-md-8"> <?php
							
							
									if(file_exists("./uploads/".$menutag_img) && ($menutag_img!=''))
									{ 
										echo '<a href="'.base_url().'uploads/'.$menutag_img.'" target="_blank"><img src="'.base_url().'uploads/'.$menutag_img.'" style="width:86px;height:59px" alt="image" /></a>';
									}
								?>
							 </div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label>Tag Image (For Home Page) : </label></div>
							<div class="col-md-8"> <?php
							
							
									if(file_exists("./uploads/".$menutagthumb_img) && ($menutagthumb_img!=''))
									{ 
										echo '<a href="'.base_url().'uploads/'.$menutagthumb_img.'" target="_blank"><img src="'.base_url().'uploads/'.$menutagthumb_img.'" style="width:86px;height:59px" alt="image" /></a>';
									}
								?>
							 </div>
						</div>
					</div>
					
					<div class="clearfix"></div>
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Show on home page  : </label></div>
							
							<div class="col-md-8"> <span><i class="<?php echo ($show_on_home == '1') ? 'fa fa-check-square' : 'fa fa-window-close' ; ?>"></i>
															For top weekend getaways / Most popular tours	</span> </div>
					
						</div>
					</div>	
					
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Show on footer menu : </label></div>
							
							<div class="col-md-8"> <span><i class="<?php echo ($show_on_footer == '1') ? 'fa fa-check-square' : 'fa fa-window-close' ; ?>"></i>
							For footer menu </span> </div>
					
						</div>
					</div>	
					
					<div class="clearfix"></div>
					
					<div class="col-md-12">
						<div class="gap row">
							<div class="col-md-2"> <label> About Tag : </label></div>
							<div class="col-md-10"> <?php echo ($rowss1['about_tag']) ? $rowss1['about_tag'] : '-' ; ?></div>
						</div>
					</div>	
					<div class="clearfix"></div>	
					<div class="col-md-12">
						<div class="gap row">
							<div class="col-md-2"> <label> Meta Title :  </label></div>
							<div class="col-md-10"> <?php echo ($rowss1['meta_title']) ? $rowss1['meta_title'] :'-'; ?></div>
						</div>
					</div>
					<div class="clearfix"></div>	
					<div class="col-md-12">
						<div class="gap row">
							<div class="col-md-2"> <label> Meta keyword :  </label></div>
							<div class="col-md-10"> <?php echo ($rowss1['meta_keywords']) ? $rowss1['meta_keywords'] : '-'; ?></div>
						</div>
					</div>
					<div class="clearfix"></div>	
					
					<div class="col-md-12">
						<div class="gap row">
							<div class="col-md-2"> <label> Meta Description : </label></div>
							<div class="col-md-10"> <?php echo ($rowss1['meta_description']) ? $rowss1['meta_description'] : '-'; ?></div>
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
	
	public function getcategory()
	{			
		$categoryId=$_REQUEST['categoryId']; 
		if($categoryId > 0)
		{ 
			$selsubcategory_name = set_value('cat_id');				
			echo $this->Common_model->populate_select($selsubcategory_name,"catid","cat_name","tbl_menucateories","menuid='$categoryId'","");
			exit;
		} else { ?>
			<option value="0">-- Select Category --</option>
		<?php }
		exit();
	}
}
