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
                        <h1>Country</h1>
                        <small>Add Country</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/country">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Country</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <?php echo $message; ?>
									<?php echo form_open('', array( 'id' => 'form_country', 'name' => 'form_country', 'class' => 'add-user'));?>
                                        <div class="row">
                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label> Country </label>
                                                    <input type="text" class="form-control fld" placeholder="Enter Country" name="country_name" id="country_name" value="<?php echo set_value('country_name'); ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>  
                                        <div class="col-md-6">
                                            <div class="reset-button"> 
                                                  <button type="submit" class="btn redbtn" name="btnSubmit" id="btnSubmit">Save</button>
                                                <button type="reset" class="btn blackbtn">Reset</button>  
                                               <!--  <a href="#" class="btn redbtn">Save</a>
                                                <a href="#" class="btn blackbtn">Reset</a>  -->
                                            </div>
                                        </div>
                                    <?php echo form_close(); ?>

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

