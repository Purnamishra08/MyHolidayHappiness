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
                        <h1>Vehicle</h1>
                        <small>Add vehicle price</small>
                    </div>                    
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/vehicleprice">
                                            <h4><i class="fa fa-plus-circle"></i> Manage vehicle</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <?php echo $message; ?>
									<?php echo form_open('', array( 'id' => 'form_vehicleprice', 'name' => 'form_vehicleprice', 'class' => 'add-user'));?>
                                        <div class="row">

                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label> Price </label>
                                                    <input type="text" class="form-control fld" placeholder="Enter vehicle capacity" name="price" id="price" value="<?php echo set_value('price'); ?>">                                                       
                                                </div>
                                            </div>

                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                <label> Destination </label> 
                                                <select class="form-control fld" name="destination" id="destination">
                                                    <option value=""> --Select Vehicle--</option>
                                                    <option value="1"> abc</option>
                                                    <option value="2"> xyz </option>
                                                    <!-- <?php // echo $this->Common_model->populate_select($dispid = 0, "vehicleid", "vehicle_name", "tbl_vehicletypes", "", "vehicle_name asc", ""); ?> -->
                                                </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                <label> Vehicle Type</label>
                                                <select class="form-control fld" name="vehicle_name" id="vehicle_name">
                                                    <option value=""> --Select Vehicle--</option>
                                                    <?php  echo $this->Common_model->populate_select($dispid = 0, "vehicleid", "vehicle_name", "tbl_vehicletypes", "", "vehicle_name asc", ""); ?>
                                                </select>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="clearfix"></div>  
                                        <div class="col-md-6">
                                            <div class="reset-button"> 
                                                  <button type="submit" class="btn redbtn" name="btnSubmitvehicleprice" id="btnSubmitvehicle">Save</button>
                                                <button type="reset" class="btn blackbtn">Reset</button>  
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
        <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>

<script>
        $(".chk").on('change', function() {
          var checkFlag = 'unchecked';
          if ($(this).is(':checked')) {
            checkFlag = 'checked';
            var id = $(this).attr("id");
            alert(id); 
            $("#checkstate_").val('1');

          }


          console.log(checkFlag);

        });
</script>
    </body>
</html>

