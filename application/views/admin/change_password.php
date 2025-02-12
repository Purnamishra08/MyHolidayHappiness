<!DOCTYPE html>
<html lang="en">

    <head>
        <?php include("head.php"); ?>
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <?php include("header.php"); ?>

            <?php include("sidemenu.php"); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="header-icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="header-title">
                        <h1>User</h1>
                        <small>Change Password</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/users">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Users</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
									<?php echo form_open('', array( 'id' => 'change_password', 'name' => 'change_password', 'class' => 'add-user'));?>
                                        <?php echo $message; ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email ID</label>
                                                    <input type="text" class="form-control" name="uname" id="uname" value="<?php echo $this->session->userdata('useremail'); ?>" readonly="readonly">
                                                </div>

                                                <div class="form-group">
                                                    <label>New Password</label>
                                                    <input type="password" class="form-control" placeholder="Enter new password" name="new_pwd" id="new_pwd" maxlength="20">
                                                </div>

                                                <div class="form-group">
                                                    <label>Confirm Password</label>
                                                    <input type="password" class="form-control" placeholder="Enter confirm password" name="cnf_pwd" id="cnf_pwd" maxlength="20">
                                                </div>

                                                <div class="reset-button"> 
                                                    <button type="submit" class="redbtn" name="btnSubmit" id="btnSubmit">Save</button>
                                                    <button type="reset" class="blackbtn">Reset</button>  
                                                </div>
                                            </div>
                                        </div>
                                    <?php echo form_close();?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php include("footer.php"); ?>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/additional-methods.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>
    </body>
</html>

