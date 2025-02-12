<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicleprice extends CI_Controller {

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
		if(!(in_array(5, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}	
		
 	}

	public function index()
	{
		$data['messageadd'] = $this->session->flashdata('messageadd');
		
		$data['row'] = $this->Common_model->get_records("*","tbl_vehicleprices","","priceid DESC","","");

		/*Add price*/


		if (isset($_POST['btnSubmitvehicleprice']) && !empty($_POST))
		{			
			$this->form_validation->set_rules('price', 'price', 'trim|required|xss_clean');
			$this->form_validation->set_rules('destination', 'destination', 'trim|required|xss_clean');
			$this->form_validation->set_rules('vehicle_name', 'vehicle', 'trim|required|xss_clean');			
			
			if ($this->form_validation->run() == true)
			{				
				$price = $this->input->post('price');				 
				$destination = $this->input->post('destination');				 
				$vehicle_name = $this->input->post('vehicle_name');			

				$noof_duprec = $this->Common_model->noof_records("priceid","tbl_vehicleprices","vehicle_name ='$vehicle_name' and destination = '$destination'");				

				if($noof_duprec < 1)
				{
					$insert_data = array(
						'vehicle_name'	=> $vehicle_name,
						'destination'	=> $destination,
						'price'	        => $price,
						'status'		=> 1					
					);				

				$insertdb = $this->Common_model->insert_records('tbl_vehicleprices', $insert_data);
				if($insertdb) {
					$this->session->set_flashdata('messageadd','<div class="successmsg notification"><i class="fa fa-check"></i> Price added successfully.</div>');
				} else {
					$this->session->set_flashdata('messageadd','<div class="errormsg notification"><i class="fa fa-times"></i> Price could not added. Please try again.</div>');
				}
			}
			else
				{
					$this->session->set_flashdata('messageadd','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added Price to this destination and vehicle.</div>');
				}
				redirect(base_url().'admin/vehicleprice','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['messageadd'] = (validation_errors() ? validation_errors() : $this->session->flashdata('messageadd'));
			}
		}

		/*Edit price*/

		$data['message'] = $this->session->flashdata('message');
		if (isset($_POST['btnUpdate']) && !empty($_POST))
		{
			
			$this->form_validation->set_rules('destination', 'destination', 'trim|required|xss_clean');			
			$this->form_validation->set_rules('vehicle_name', 'vehicle name', 'trim|required|xss_clean');			
			$this->form_validation->set_rules('price', 'price', 'trim|required|xss_clean');			
			
			if ($this->form_validation->run() == true)
			{
				
				$price = $this->input->post('price');				 
				$destination = $this->input->post('destination');	 		 
				$vehicle_name = $this->input->post('vehicle_name');	
				$editid = $this->input->post('priceid');	


				$noof_duprec = $this->Common_model->noof_records("priceid","tbl_vehicleprices","vehicle_name='$vehicle_name' and destination ='$destination' and priceid!='$editid'");

				$noof_rec = $this->Common_model->noof_records("priceid","tbl_vehicleprices","priceid='$editid'");
                if($noof_duprec < 1)
				{

				$update_data = array(
					'price'	            => $price,	
					'vehicle_name'	    => $vehicle_name,	
					'destination'		=> $destination		
					);	
				
				$querydb = $this->Common_model->update_records('tbl_vehicleprices',$update_data,"priceid=$editid");
				if($querydb){
					$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> vehicle price edited successfully.</div>');
				}
				else{
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> vehicle price could not edited. Please try again.</div>');
				}
			}

			else
			{
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added price to this destination or vehicle</div>');
			
			}
				redirect(base_url().'admin/vehicleprice','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}

		$this->load->view('admin/manage_vehicleprice',$data);
	}	

	// public function view()
	// {
		
	// 	$viewid = $this->uri->segment(4);
	// 	$noof_rec = $this->Common_model->noof_records("vehicleid","tbl_vehicleprices","vehicleid='$viewid'");
	// 	if($noof_rec>0)
	// 	{
			
	// 		$data['countrynm'] = $this->Common_model->get_records("*","tbl_vehicleprices","vehicleid=$viewid","");
			
	// 		$this->load->view('admin/view_country',$data);
	// 	}
	// }

	public function delete()
	{
		$delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("priceid","tbl_vehicleprices","priceid='$delid'");
		if($noof_rec>0)
		{
			$del = $this->Common_model->delete_records("tbl_vehicleprices","priceid=$delid");
			if($del)
				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Vehicle price has been deleted successfully.</div>');
			else
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Vehicle price could not deleted. Please try again.</div>');
		}
		redirect(base_url().'admin/vehicleprice','refresh');
	}

	public function changestatus()
	{
		$stsid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("priceid","tbl_vehicleprices","priceid='$stsid'");
		if($noof_rec>0)
		{
			$status = $this->Common_model->showname_fromid("status","tbl_vehicleprices","priceid=$stsid");
			if($status==1)
				$updatedata = array('status' => 0);
			else
				$updatedata = array('status' => 1);
			$updatestatus = $this->Common_model->update_records("tbl_vehicleprices",$updatedata,"priceid=$stsid");
			if($updatestatus)
				echo $status;
			else
				echo "error";
		}
		exit();
	}

	



	public function vpriceeditpopup()
	{
		$editid = $this->uri->segment(4);

		$noof_rec = $this->Common_model->noof_records("priceid","tbl_vehicleprices","priceid='$editid'");
		if($noof_rec > 0)
		{
			$data = $this->Common_model->get_records("*","tbl_vehicleprices","priceid='$editid'");
			foreach ($data as $rows)
			{			

				    $priceid = $rows['priceid'];
				    $destination = $rows['destination'];
				    $vehicle_name = $rows['vehicle_name'];
				    $price = $rows['price'];
				    $status = $rows['status'];
    
				
			}
			// echo $destination;
	?>

        <div class="modal-header">
			<button type="button" class="close-btn " data-dismiss="modal">&times;</button>
			<h4 class="modal-title pupop-title">Edit Vehicle Price</h4>
		</div>
		<div class="modal-body">
			<div class="modal-sub-body">
				<div class="row">
						<?php echo form_open(base_url('admin/vehicleprice'), array( 'id' => 'form_editvehicleprice', 'name' => 'form_editvehicleprice', 'class' => 'col-md-12 modalform'));?>
						
											<div class="col-md-6"> 
                                                <div class="form-group">
                                                <label> Vehicle Type</label>
                                                <select class="form-control fld" name="vehicle_name" id="vehicle_name">
                                                    <option value=""> --Select Vehicle--</option>
                                                    <?php  echo $this->Common_model->populate_select($dispid = $vehicle_name, "vehicleid", "vehicle_name", "tbl_vehicletypes", "", "vehicle_name asc", ""); ?>

                                                </select>
                                                 <input type="hidden" name="priceid" id="priceid" value="<?php echo set_value('price',$priceid); ?>">
                                                </div>
                                            </div>

                                             <div class="col-md-6"> 
                                                <div class="form-group">
                                                <label> Destination </label> 
                                               
                                                <select class="form-control"  id="destination"  name="destination" >
                                                             <option value="">-- Select destination --</option>
                                                           <?php  echo $this->Common_model->populate_select($dispid = $destination, "destination_id", "destination_name", "tbl_destination", "", "destination_name asc", ""); ?>
                                                </select> 


                                                </div>
                                            </div>


					     					<div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label> Price / Day (<?php echo $this->Common_model->currency; ?>)</label>
                                                    <input type="text" class="form-control fld" placeholder="Enter vehicle capacity" name="price" id="price" value="<?php echo set_value('price',$price); ?>"> 
                                                </div>
                                            </div>

                                            <div class="clearfix"></div>
											<div class="form-group">
												<label class="col-md-3"></label>
												<div class="reset-button col-md-9">
												  <input type="hidden" name="editid" id="editid" value="<?php echo $editid; ?>" />
												  <button type="submit" class="btn redbtn btnUpdate" name="btnUpdate" id="btnUpdate">Update</button>
												</div>
											</div>


					<?php echo form_close(); ?>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	<?php
		}
		exit();
	}







	
	
}








   
