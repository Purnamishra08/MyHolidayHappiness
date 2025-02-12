<!DOCTYPE html>
<html lang="en">

    <head>
        <?php include("head.php"); ?>
        <link href="<?php echo base_url(); ?>assets/admin/css/chosen.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
           <?php include("header.php"); ?>

           <?php include("sidemenu.php"); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="header-icon">
                        <i class="fa fa-flag"></i>
                    </div>
                    <div class="header-title">
                        <h1>Destinations</h1>
                        <small>Add Destination</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/destination">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Destinations</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <?php echo $message; ?>
									<?php echo form_open('', array( 'id' => 'form_destination', 'name' => 'form_destination', 'class' => 'add-user', 'enctype' => 'multipart/form-data'));?>
                                        <div class="row">
                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Destination Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter Destination Name" name="destination_name" id="destination_name" value="<?php echo set_value('destination_name'); ?>">
                                                </div></div>

                                                 <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Destination Url</label>
                                                    <input type="text" class="form-control" placeholder="Enter destination url" name="destination_url" id="destination_url" value="<?php echo set_value('destination_url'); ?>">
                                                </div></div>

                                            <div class="clearfix"></div>

                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Destination Type</label>
                                                        <select class="form-control" name="destination_type" id="destination_type" >
                                                            <option value="0">Select Destination Type</option>
                                                            <?php
                                                                $destination_type = set_value('destination_type');
                                                                echo $this->Common_model->populate_select($destination_type,"destination_type_id","destination_type_name","tbl_destination_type", "status='1'", "destination_type_name"); 
                                                            ?>
                                                    </select>
                                                </div>
                                            </div>

                                           <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>State</label>
                                                        <select class="form-control" name="state" id="state" >
                                                            <option value="0">Select State</option>
                                                            <?php
                                                                $state = set_value('state');
                                                                echo $this->Common_model->populate_select($state,"state_id","state_name","tbl_state", "status='1'", "state_name"); 
                                                            ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                             <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Ideal Trip Duration</label>
                                                    <input type="text" class="form-control" placeholder=" 2-3 Days" name="trip_duration" id="trip_duration" value="<?php echo set_value('trip_duration'); ?>">
                                                </div></div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nearest City</label>
                                                    <input type="text" class="form-control" placeholder="Enter Nearest City" name="nearest_city" id="nearest_city" value="<?php echo set_value('nearest_city'); ?>">
                                                </div>
                                            </div><div class="clearfix"></div>

                                             <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Best time to visit</label>
                                                    <input type="text" class="form-control" placeholder="Enter Visit Time" name="visit_time" id="visit_time" value="<?php echo set_value('visit_time'); ?>">
                                                </div></div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Peak season</label>
                                                    <input type="text" class="form-control" placeholder="Enter Peak season" name="peak_season" id="peak_season" value="<?php echo set_value('peak_season'); ?>">
                                                </div>
                                            </div><div class="clearfix"></div>

                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Weather info</label>
                                                    <input type="text" class="form-control" placeholder="Enter Weather info" name="weather_info" id="weather_info" value="<?php echo set_value('weather_info'); ?>">
                                                </div></div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Destination Image</label>
                                                    <input name="destiimg" id="destiimg" type="file"></td>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>

                                          

                                        <div class="clearfix"></div> 

                                        <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Rating</label>
                                                <select class="form-control" name="rating" id="rating" >
                                                    <option value="0">Select Rating</option>
                                                    <option value="1">1</option>
                                                    <option value="1.5">1.5</option>
                                                    <option value="2">2</option>
                                                    <option value="2.5">2.5</option>
                                                    <option value="3">3</option>
                                                    <option value="3.5">3.5</option>
                                                    <option value="4">4</option>
                                                    <option value="4.5">4.5</option>
                                                    <option value="5">5</option>
                                                </select>
                                                </div></div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Google Map</label>
                                                    <input type="text" class="form-control" placeholder="Enter Google Map" name="google_map" id="google_map" value="<?php echo set_value('google_map'); ?>">
                                                </div>
                                            </div><div class="clearfix"></div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Other Info</label>
                                                    <input type="text" class="form-control" placeholder="Enter Other Info" name="other_info" id="other_info" value="<?php echo set_value('other_info'); ?>">
                                                </div>
                                            </div>

                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Pick & Drop Price (<?php echo $this->Common_model->currency; ?>)</label>
                                                    <input type="text" class="form-control" placeholder="Enter Pick & Drop Price" name="pick_drop_price" id="pick_drop_price" value="<?php echo set_value('pick_drop_price'); ?>">
                                                </div>

                                            </div><div class="clearfix"></div>


                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                        <label>Destination Tag</label>
                                                        <?php
                                                          $get_desti = $this->Common_model->get_records("state_id, state_name", "tbl_state", "status = '1'", "state_name asc", "");
                                                        ?>
                                                        <select data-placeholder="Choose Destination Tag" class="chosen-select efilter" multiple tabindex="4" id="edesti"  name="edesti[]"
                                                         style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
                                                            <?php foreach ($get_desti as $get_destis) { ?>
                                                            <option value="<?= $get_destis['state_id'] ?>"><?= $get_destis['state_name'] ?></option>
                                                            <?php } ?>
                                                        </select> 
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>About Destination</label>
                                                        <textarea name="short_desc" id="short_desc" class="form-control "><?php echo set_value("short_desc"); ?></textarea>
                                                        <div id="proddesc_errorloc"></div>
                                                    </div>
                                                </div>
                                               <div class="clearfix"></div>
                                           
                                        <div class="col-md-6">
                                            <div class="reset-button"> 
                                                  <button type="submit" class="btn redbtn" name="btnSubmit" id="btnSubmit">Save</button>
                                        <button name='reset' type="reset" value='Reset' class="btn blackbtn">Reset</button>  
                                               <!--  <a href="#" class="btn redbtn">Save</a>
                                                <a href="#" class="btn blackbtn">Reset</a>  -->
                                            </div>
                                        </div>
                                    <?php echo form_close(); ?>
                                   </div>
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
    <script src="<?php echo base_url(); ?>assets/admin/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.js" type="text/javascript"></script>

    <script>
    $(document.body).on('keyup change', '#destination_name', function() {
        $("#destination_url").val(name_to_url($(this).val()));
    });
    function name_to_url(name) {
        name = name.toLowerCase(); // lowercase
        name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
        name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
        name = name.replace(/[^a-z0-9-]/g, ''); // remove everything that is not [a-z] or -
        return name;
    }
    </script>

    <script type="text/javascript">

        CKEDITOR.replace('short_desc');

                $(document).ready(function(){
                    $('#edesti').chosen();
                    $("#edesti").change(function () {
                        var menu = $(this);
                    });
                });
        </script>

    </body>
</html>

