<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_view extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url', 'form');
        $this->load->library('session');
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="errormsg notification"><i class="fa fa-times"></i> ', '</div>');
        $this->load->database();
        $this->load->model('Common_model');

        if ($this->session->userdata('userid') == "") {
            redirect(base_url() . 'admin/logout', 'refresh');
        }

        $allusermodules = $this->session->userdata('allpermittedmodules');
        if (!(in_array(1, $allusermodules))) {
            redirect(base_url() . 'admin/dashboard', 'refresh');
        }
    }

    public function index() {
        $data['message'] = $this->session->flashdata('message');
        $data['row'] = $this->Common_model->get_records("*", "tbl_admin", "", "admin_type ASC, adminid DESC", "", "");
        $this->load->view('admin/booking_view', $data);
    }

    public function add() {
        $data['message'] = $this->session->flashdata('message');
        $data['row'] = $this->Common_model->get_records("*", "tbl_modules", "status=1", "moduleid ASC");

        if (isset($_POST['btnSubmit']) && !empty($_POST)) {
            $this->form_validation->set_rules('uname', 'User Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('utype', 'User Type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('contact', 'Contact No.', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email ID', 'trim|required|xss_clean|valid_email|is_unique[tbl_admin.email_id]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[12]|matches[cpassword]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required');

            $sess_userid = $this->session->userdata('userid');
            $date = date("Y-m-d H:i:s");
            if ($this->form_validation->run() == true) {
                $uname = $this->input->post('uname');
                $utype = $this->input->post('utype');
                $contact = $this->input->post('contact');
                $email = $this->input->post('email');
                $password = $this->input->post('password');

                $costvalue = $this->Common_model->costvalue;
                $options = ['cost' => $costvalue];
                $inspwdfrdb = password_hash("$password", PASSWORD_BCRYPT, $options);

                $insert_data = array(
                    'admin_name' => $uname,
                    'contact_no' => $contact,
                    'email_id' => $email,
                    'password' => $inspwdfrdb,
                    'admin_type' => $utype,
                    'status' => 1,
                    'created_by' => $sess_userid,
                    'created_date' => $date
                );

                $insertdb = $this->Common_model->insert_records('tbl_admin', $insert_data);
                if ($insertdb) {
                    $userid = $this->db->insert_id();
                    $delmodules = $this->Common_model->delete_records("tbl_admin_modules", "adminid=$userid");
                    if (($utype != 1) && ($utype != 2)) { //If Not Super Admin
                        $modules = $this->input->post('modules');
                        foreach ($modules as $moduleid) {
                            $insert_module = array(
                                'adminid' => $userid,
                                'moduleid' => $moduleid,
                                'created_by' => $sess_userid,
                                'created_date' => $date
                            );
                            $insertmodule = $this->Common_model->insert_records('tbl_admin_modules', $insert_module);
                        }
                    }
                    $this->session->set_flashdata('message', '<div class="successmsg notification"><i class="fa fa-check"></i> User added successfully.</div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="errormsg notification"><i class="fa fa-times"></i> User could not added. Please try again.</div>');
                }
                redirect(base_url() . 'admin/users/add', 'refresh');
            } else {
                //set the flash data error message if there is one
                $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            }
        }
        $this->load->view('admin/add_user', $data);
    }

    public function edit() {
        $editid = $this->uri->segment(4);
        $noof_rec = $this->Common_model->noof_records("adminid", "tbl_admin", "adminid='$editid' ");
        if ($noof_rec > 0) {
            $data['message'] = $this->session->flashdata('message');
            $data['row'] = $this->Common_model->get_records("*", "tbl_modules", "status='1'", "moduleid ASC");
            $data['user'] = $this->Common_model->get_records("*", "tbl_admin", "adminid=$editid", "");
            $data['modules'] = $this->Common_model->get_records("a.moduleid, a.module", "tbl_modules a, tbl_admin_modules b", "a.moduleid=b.moduleid and b.adminid=$editid", "");
            if (isset($_POST['btnSubmit']) && !empty($_POST)) {
                $this->form_validation->set_rules('uname', 'User Name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('utype', 'User Type', 'trim|required|xss_clean');
                $this->form_validation->set_rules('contact', 'Contact No.', 'trim|required|xss_clean');
                $this->form_validation->set_rules('email', 'Email ID', 'trim|required|xss_clean|valid_email');

                $sess_userid = $this->session->userdata('userid');
                $date = date("Y-m-d H:i:s");
                if ($this->form_validation->run() == true) {
                    $uname = $this->input->post('uname');
                    $utype = $this->input->post('utype');
                    $contact = $this->input->post('contact');
                    $email = $this->input->post('email');

                    $noof_duprec = $this->Common_model->noof_records("adminid", "tbl_admin", "email_id='$email'  and adminid!='$editid'");
                    if ($noof_duprec < 1) {
                        $update_data = array(
                            'admin_name' => $uname,
                            'contact_no' => $contact,
                            'email_id' => $email,
                            'admin_type' => $utype,
                            'updated_by' => $sess_userid,
                            'updated_date' => $date
                        );

                        $updatedb = $this->Common_model->update_records('tbl_admin', $update_data, "adminid=$editid");
                        if ($updatedb) {
                            $delmodules = $this->Common_model->delete_records("tbl_admin_modules", "adminid=$editid");
                            if (($utype != 1) && ($utype != 2)) { //If Not Super Admin
                                $modules = $this->input->post('modules');
                                foreach ($modules as $moduleid) {
                                    $insert_module = array(
                                        'adminid' => $editid,
                                        'moduleid' => $moduleid,
                                        'created_by' => $sess_userid,
                                        'created_date' => $date
                                    );
                                    $insertmodule = $this->Common_model->insert_records('tbl_admin_modules', $insert_module);
                                }
                            }
                            $this->session->set_flashdata('message', '<div class="successmsg notification"><i class="fa fa-check"></i> User edited successfully.</div>');
                        } else {
                            $this->session->set_flashdata('message', '<div class="errormsg notification"><i class="fa fa-times"></i> User could not edited. Please try again.</div>');
                        }
                    } else {
                        $this->session->set_flashdata('message', '<div class="errormsg notification"><i class="fa fa-times"></i> The Email ID field must contain a unique value.</div>');
                    }
                    redirect(base_url() . 'admin/users/edit/' . $editid, 'refresh');
                } else {
                    //set the flash data error message if there is one
                    $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
                }
            }
            $this->load->view('admin/edit_user', $data);
        } else
            redirect(base_url() . 'admin/users', 'refresh');
    }

    public function delete() {
        $delid = $this->uri->segment(4);
        $noof_rec = $this->Common_model->noof_records("adminid", "tbl_admin", "adminid='$delid' and admin_type!=1");
        if ($noof_rec > 0) {
            $delmodule = $this->Common_model->delete_records("tbl_admin_modules", "adminid=$delid");
            if ($delmodule) {
                $del = $this->Common_model->delete_records("tbl_admin", "adminid=$delid");
                if ($del)
                    $this->session->set_flashdata('message', '<div class="successmsg notification"><i class="fa fa-check"></i> User has been deleted successfully.</div>');
                else
                    $this->session->set_flashdata('message', '<div class="errormsg notification"><i class="fa fa-times"></i> User could not deleted. Please try again.</div>');
            }
            else {
                $this->session->set_flashdata('message', '<div class="errormsg notification"><i class="fa fa-times"></i> User could not deleted. Please try again.</div>');
            }
        }
        redirect(base_url() . 'admin/users', 'refresh');
    }

    public function changestatus() {
        $stsid = $this->uri->segment(4);
        $noof_rec = $this->Common_model->noof_records("adminid", "tbl_admin", "adminid='$stsid' and admin_type!=1");
        if ($noof_rec > 0) {
            $status = $this->Common_model->showname_fromid("status", "tbl_admin", "adminid=$stsid");
            if ($status == 1)
                $updatedata = array('status' => 0);
            else
                $updatedata = array('status' => 1);
            $updatestatus = $this->Common_model->update_records("tbl_admin", $updatedata, "adminid=$stsid");
            if ($updatestatus)
                echo $status;
            else
                echo "error";
        }
        exit();
    }

    public function view_pop() {
        $viewid = $this->uri->segment(4);
        $rows1 = $this->Common_model->get_records("*", "tbl_admin", "adminid='$viewid'", "adminid DESC", "", "");
        if (!empty($rows1)) {
            foreach ($rows1 as $rowss1) {
                $userid = $rowss1['adminid'];
                $user_name = $rowss1['admin_name'];
                $contact_no = $rowss1['contact_no'];
                $email_id = $rowss1['email_id'];
                $user_type = $rowss1['admin_type'];
                $status = $rowss1['status'];

                if ($user_type == 1)
                    $adimtypenm = 'Super Admin';
                elseif ($user_type == 2)
                    $adimtypenm = 'Admin';
                else
                    $adimtypenm = 'User';
            }
        }
        ?>
        <div class="modal-header">
            <button type="button" class="close-btn " data-dismiss="modal">&times;</button>
            <h4 class="modal-title pupop-title">User Details</h4>
        </div>
        <div class="modal-body">
            <div class="modal-sub-body">
                <div class="row">

                    <div class="col-md-6">
                        <div class="gap row">
                            <div class="col-md-4"> <label> Name</label></div>
                            <div class="col-md-8"> <?php echo $user_name; ?></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="gap row">
                            <div class="col-md-4"> <label> Type</label></div>
                            <div class="col-md-8"> <?php echo $adimtypenm; ?></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-6">
                        <div class="gap row">
                            <div class="col-md-4"> <label> Email</label></div>
                            <div class="col-md-8"> <?php echo $email_id; ?></div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="gap row">
                            <div class="col-md-4"> <label> Contact No.</label></div>
                            <div class="col-md-8"> <?php echo $contact_no; ?></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-6">
                        <div class="gap row">
                            <div class="col-md-4"> <label>Module</label></div>
                            <div class="col-md-8"> <?php
        if (($user_type == 1) || ($user_type == 2))
            $usermodules = $this->Common_model->get_records("*", "tbl_modules", "status=1", "moduleid ASC");
        else
            $usermodules = $this->Common_model->get_records("a.*, b.module", "tbl_admin_modules a, tbl_modules b", "a.moduleid=b.moduleid and a.adminid='$userid'", "moduleid ASC");

        $module = array();
        foreach ($usermodules as $modules) {
            $module[] = $modules['module'];
        }
        echo implode(", ", $module);
        ?>  </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="gap row">
                            <div class="col-md-4"> <label> Status</label></div>
                            <div class="col-md-8"><?php
        if ($status == 1)
            echo "Active";
        else
            echo "Inactive";
        ?></div>
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
