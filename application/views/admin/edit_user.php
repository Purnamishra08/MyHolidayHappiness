<?php
foreach ($user as $rows)
{
    $userid = $rows['adminid'];
    $user_name = $rows['admin_name'];
    $contact_no = $rows['contact_no'];
    $email_id = $rows['email_id'];                  
    $user_type = $rows['admin_type'];
    $status = $rows['status'];
}
?>

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
                        <h1>Users</h1>
                        <small>Edit User</small>
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
                                    <?php echo $message; ?>
									<?php echo form_open('', array( 'id' => 'userform', 'name' => 'userform', 'class' => 'add-user'));?>
                                        <div class="row">
                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter name" name="uname" id="uname" value="<?php echo set_value('uname',$user_name); ?>">
                                                </div></div>

                                            <div class="col-md-6">
                                                <label>User Type</label>
                                                <div class="">
                                                     <?php if($user_type==1){ ?>
                                                    <div class="radio radio-info radio-inner">
                                                        <input type="radio" name="utype" id="utype1" value="1" <?php if($user_type==1) echo 'checked'; ?>> <label for="utype1">Super Admin </label>
                                                    </div>
                                                     <?php } else { ?>
                                                    <div class="radio radio-info radio-inner">
                                                        <input type="radio" name="utype" id="utype1" value="2" <?php if($user_type==2) echo 'checked'; ?>> <label for="utype2">Admin</label>
                                                    </div>

                                                    <div class="radio radio-info radio-inner">
                                                        <input type="radio" name="utype" id="utype2" value="3" <?php if($user_type==3) echo 'checked'; ?>> <label for="utype2">User</label>
                                                    </div>
                                                        <?php } ?>
                                                    <div id="utype_errorloc"></div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Contact No.</label>
                                            <input type="text" class="form-control" placeholder="Enter Contact no" name="contact" id="contact" value="<?php echo set_value('contact',$contact_no); ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" placeholder="Enter Emai Id" name="email" id="email" value="<?php echo set_value('email',$email_id); ?>">
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>

                                         


                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Modules</label>
                                                    <div class="chkbx-inner">
                                                      <?php
                                            $mod_id = array();
                                            if(!empty($modules))
                                            {
                                                foreach ($modules as $module)
                                                {
                                                    $mod_id[] = $module['moduleid'];
                                                }
                                            }
                                            $cnt=0;
                                            foreach ($row as $rows)
                                            {
                                                $cnt++;
                                                $moduleid = $rows['moduleid'];
                                                $module = $rows['module'];
                                                $ModuleChecked ="";
                                                if($mod_id!="")
                                                {
                                                    if(@in_array($moduleid,$mod_id, TRUE ))
                                                    {
                                                        $ModuleChecked = 'checked=checked';
                                                    }
                                                }
                                                $checked = ''; $disabled = '';
                                                if(($user_type == 1) || ($user_type == 2))
                                                {
                                                    $checked = 'checked="checked"'; $disabled = 'disabled="disabled"';
                                                }
                                            ?>
                                                        <div class="col-md-6">
                                                            <div class="checkbox checkbox-info">
                                                                <input  type="checkbox" name="modules[]" id="modules_<?php echo $cnt; ?>" value="<?php echo $moduleid; ?>"  <?php echo set_checkbox('modules[]', $moduleid); ?> <?php echo $ModuleChecked.' '.$checked.' '.$disabled; ?>>
                                                                <label  for="modules_<?php echo $cnt; ?>"><?php echo $module; ?></label>
                                                            </div>                 
                                                        </div>

                                                         <?php
                                                if($cnt%2=='0') { echo '<div class="clearfix"></div>'; }
                                            }
                                            ?>
                                                <div style="margin-left: 15px;" id="modules_errorloc"></div>
                                                       

                                                    </div>
                                                </div>
                                            </div></div>

                                        <div class="clearfix"></div>  
                                        <div class="col-md-6">
                                            <div class="reset-button"> 
                                                <!--   <button type="submit" class="btn redbtn" name="btnSubmit" id="btnSubmit">Save</button>
                                                <button type="reset" class="btn blackbtn">Reset</button>   -->

                                                <button type="submit" class="btn redbtn" name="btnSubmit" id="btnSubmit">Update</button>
												<button type="button" class="btn blackbtn" onClick="window.location='<?php echo base_url(); ?>admin/users'">Back</button> 
                                               <!--  <a href="#" class="btn redbtn">Save</a>
                                                <a href="#" class="btn blackbtn">Reset</a>  -->
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

