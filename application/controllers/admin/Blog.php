<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

	public function __construct()
 	{
		parent::__construct();
		$this->load->helper('url','form');
		$this->load->library('session');
		$this->load->helper('security');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="errormsg notification"><i class="fa fa-times"></i> ', '</div>');
		$this->load->database();
		$this->load->library('pagination');
		$this->load->model('Common_model');
		if($this->session->userdata('userid') == "")
		{
			redirect(base_url().'admin/logout','refresh');
		}
		$allusermodules = $this->session->userdata('allpermittedmodules');
		if(!(in_array(14, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}
 	}

	public function index()
	{	
	$data['message'] = $this->session->flashdata('message'); 
		/** Pagination Config **/
	$data['row'] = $this->Common_model->get_records("*","tbl_blog","","blogid DESC","","");
		$this->load->view('admin/manage_blog',$data);
	}

	public function add()
	{
		$data['message'] = $this->session->flashdata('message');
		
		if (isset($_POST['title']) && !empty($_POST))
		{
			$this->form_validation->set_rules('title', 'title', 'trim|required|xss_clean');
			$this->form_validation->set_rules('contents', 'discussion', 'trim|required|xss_clean');
			$this->form_validation->set_rules('blog_url', 'Blog Url', 'trim|required|xss_clean|is_unique[tbl_blog.blog_url]');
			$this->form_validation->set_rules('contents', 'Content', 'trim|required|xss_clean');
			
			$title = $this->input->post('title');
			$contents = $this->input->post('contents');
			$show_comments = $this->input->post('show_comments');
			$show_home = $this->input->post('show_home');
			$blog_url = $this->input->post('blog_url');
			$alttag_image = $this->input->post('alttag_image');
			
			$blog_meta_title = $this->input->post('blog_meta_title');
			$blog_meta_keywords = $this->input->post('blog_meta_keywords');
			$blog_meta_description = $this->input->post('blog_meta_description');

			if(isset($_POST['show_comments'])){
                 $show_comments = $_POST['show_comments'];
                         }else{
                  $show_comments = "";
                           }	


               if(isset($_POST['show_home'])){
                 $show_home = $_POST['show_home'];
                         }else{
                  $show_home = "";
                           }						
						
				$sess_userid = $this->session->userdata('userid');
				$date = date("Y-m-d H:i:s");
				if ($this->form_validation->run() == true)
				{
					$noof_duprec = $this->Common_model->noof_records("blogid","tbl_blog","blog_url = '$blog_url'");	
					if($noof_duprec < 1)	{
					        $imgfilename = $this->Common_model->seo_friendly_url($alttag_image);
							if (isset($_FILES) && !empty($_FILES))
							{
								$config['upload_path'] = './uploads/';
								$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
								$config['max_size'] = '0';
								$config['overwrite'] = FALSE;
								If($imgfilename != "") {
									$config['encrypt_name'] = FALSE;
									$config['file_name'] = $imgfilename;
								} else {
									$config['encrypt_name'] = TRUE;
								}
						
								$this->load->library('upload', $config);
								if($this->upload->do_upload('dis_image'))
								{
									$this->load->library('image_lib');
									$photo_path = $this->upload->data();
									$filename = $photo_path['file_name'];
									//resize:
									$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
									$config['maintain_ratio'] = FALSE;
									$config['width'] = 1920;
									$config['height'] = 702;
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
							
							$query_data = array(
								'title'			=>	$title,
								'image'			=>	$filename,
								'alttag_image'	=>	$alttag_image,
								'content'		=>	$contents,
								'blog_url'		=>	$blog_url,
								'blog_meta_title'		=>	$blog_meta_title,
								'blog_meta_keywords'		=>	$blog_meta_keywords,
								'blog_meta_description'		=>	$blog_meta_description,
								'show_comment'		=>	$show_comments,
								'show_in_home'		=>	$show_home,
								'status'			=>	1,
								'created_date'		=>	$date,
								'created_by'		=>	$sess_userid
							);

						$querydb = $this->Common_model->insert_records('tbl_blog', $query_data);
						
						if($querydb)
							$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Post added successfully.</div>');
						else
							$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Post could not added. Please try again.</div>');
					} else	{
						$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Blog  URL must be unique .</div>');
					}
				   redirect(base_url().'admin/blog/add','refresh');
				} else
				{
					//set the flash data error message if there is one
					$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				}
		}
		$this->load->view('admin/add_blog',$data);
	}


	public function changestatus()
	{
		$stsid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("blogid","tbl_blog","blogid='$stsid'");
		if($noof_rec>0)
		{
			$status = $this->Common_model->showname_fromid("status","tbl_blog","blogid=$stsid");
			if($status==1)
				$updatedata = array('status' => 0);
			else
				$updatedata = array('status' => 1);
			$updatestatus = $this->Common_model->update_records("tbl_blog",$updatedata,"blogid=$stsid");
			if($updatestatus)
				echo $status;
			else
				echo "error";
		}
		exit();
	}
	



	public function delete()
	
	{
		$delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("blogid","tbl_blog","blogid='$delid'");
		if($noof_rec>0)
		{
			$rimage = $this->Common_model->showname_fromid("image","tbl_blog","blogid=$delid");
			$del = $this->Common_model->delete_records("tbl_blog","blogid=$delid");
			if($del)
			{
				$unlinkimage = getcwd().'/uploads/'.$rimage;
					if (file_exists($unlinkimage) && !is_dir($unlinkimage))
					{
						unlink($unlinkimage);
					}


				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Post has been deleted successfully.</div>');
				}
			else
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Post could not deleted. Please try again.</div>');
		}
		redirect(base_url().'admin/blog','refresh');
	}

public function edit()
	{
		$data['message'] = $this->session->flashdata('message');
		$editid = $this->uri->segment(4);

		$noof_rec = $this->Common_model->noof_records("blogid", "tbl_blog", "blogid='$editid'");
		if($noof_rec > 0)
		{
			$data['row'] = $this->Common_model->get_records("*","tbl_blog","blogid=$editid","");
			if (isset($_POST['title']) && !empty($_POST))
			{
				$blog_url = $this->Common_model->showname_fromid("blog_url","tbl_blog","blogid=$editid");
				
				if($this->input->post('blog_url') != $blog_url) {
				   $is_unique =  '|is_unique[tbl_blog.blog_url]';
				} else {
				   $is_unique =  '';
				}
				$this->form_validation->set_rules('contents', 'Contents', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('short_desc', 'Short Desc', 'trim|required|xss_clean');
				$this->form_validation->set_rules('title', 'title', 'trim|required|xss_clean');
				$this->form_validation->set_rules('blog_url', 'Blog Url', 'trim|required|xss_clean'.$is_unique);
				$sess_userid = $this->session->userdata('userid');
				$date = date("Y-m-d H:i:s");
				if ($this->form_validation->run() == true)
				{
					$title = $this->input->post('title');
					$contents = $this->input->post('contents');
					$show_comments = $this->input->post('show_comments');
					$show_home = $this->input->post('show_home');
					$blog_url = $this->input->post('blog_url');
					$alttag_image = $this->input->post('alttag_image');
					
					
        			$blog_meta_title = $this->input->post('blog_meta_title');
        			$blog_meta_keywords = $this->input->post('blog_meta_keywords');
        			$blog_meta_description = $this->input->post('blog_meta_description');
					
					if(isset($_POST['show_comments'])){
					 $show_comments = $_POST['show_comments'];
						    }else{
					 $show_comments = "";
							  }

				   if(isset($_POST['show_home'])){
					 $show_home = $_POST['show_home'];
						    }else{
					 $show_home = "";
							  }
					
					
					$filename = $this->input->post('txthimage');
                    $imgfilename = $this->Common_model->seo_friendly_url($alttag_image);
					if (isset($_FILES) && !empty($_FILES) && !empty($_FILES['dis_image']['name']))
					{
						$config['upload_path'] = './uploads/';
						$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
						$config['max_size'] = '0';
						$config['overwrite'] = FALSE;
						If($imgfilename != "") {
							$config['encrypt_name'] = FALSE;
							$config['file_name'] = $imgfilename;
						} else {
							$config['encrypt_name'] = TRUE;
						}

						$this->load->library('upload', $config);
						if($this->upload->do_upload('dis_image'))
						{
							$unlinkimage = getcwd().'/uploads/'.$filename;
							if (file_exists($unlinkimage) && !is_dir($unlinkimage))
							{
								unlink($unlinkimage);
							}
							$this->load->library('image_lib');
							$photo_path = $this->upload->data();
							$filename = $photo_path['file_name'];
							//resize:
							$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
							$config['maintain_ratio'] = FALSE;
							$config['width'] = 1920;
							$config['height'] = 702;
							$this->image_lib->initialize($config);
							$this->image_lib->resize();
						}
						else
						{
							$filename = $filename;		
						}
					}
					else
					{
                        $oldname_b = getcwd().'/uploads/'.$filename;
                        if(file_exists($oldname_b)) {
                            $extensionBArr = explode(".", $filename);
                            $extensionB = end($extensionBArr);
                            $newname_b = getcwd().'/uploads/'.$imgfilename.'.'.$extensionB;
                            rename($oldname_b, $newname_b);
                            $filename = $imgfilename.'.'.$extensionB;
                        } else {
                            $filename = $filename;
                        }
					}

					$query_data = array(
						'title'			=>	$title,
						'image'			=>	$filename,
						'alttag_image'	=>	$alttag_image,
						'content'		=>	$contents,
						'blog_meta_title'		=>	$blog_meta_title,
						'blog_meta_keywords'		=>	$blog_meta_keywords,
						'blog_meta_description'		=>	$blog_meta_description,
						'show_comment'		=>	$show_comments,
						'show_in_home'		=>	$show_home,
						'blog_url'		=>	$blog_url,
						'updated_date'		=>	$date,
						'updated_by'		=>	$sess_userid
						
						
					);
					
					$updatedb = $this->Common_model->update_records('tbl_blog',$query_data,"blogid=$editid");
					if($updatedb)
						$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Post edited successfully.</div>');
					else
						$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Post could not edited. Please try again.</div>');
					
					redirect(base_url().'admin/blog/edit/'.$editid,'refresh');
				}
				else
				{
					//set the flash data error message if there is one
					$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				}
			}
			$this->load->view('admin/edit_blog',$data);
		}
		else
		{
			redirect(base_url().'admin/blog','refresh');
		}
	}
	 
    // Remote check page url
    public function check_pageurl() {
        $chkblog_url = $_REQUEST["chkblog_url"];
        $where_page = "";
        if (isset($_REQUEST["id"])) {
            $blog_id = $_REQUEST["id"];
            $where_page = " and blogid!='$blog_id'";
        }
        $noof_rec = $this->Common_model->noof_records("blogid", "tbl_blog", "blog_url='$chkblog_url' $where_page");
        if ($noof_rec > 0)
            echo(json_encode(false));
        else
            echo(json_encode(true)); // if there's nothing matching
        exit();
    }




}
