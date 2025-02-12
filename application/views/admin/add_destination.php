<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php"); ?>
    <link href="<?php echo base_url(); ?>assets/admin/css/chosen.css" rel="stylesheet" type="text/css" />
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include("header.php"); ?>

        <?php include("sidemenu.php"); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="header-icon">
                    <i class="fa fa-map-marker"></i>
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
                                        <h4><i class="fa fa-plus-circle"></i> Manage Destination</h4>
                                    </a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php echo $message; ?>
                                <?php echo form_open('', array('id' => 'form_destination', 'name' => 'form_destination', 'class' => 'add-user', 'enctype' => 'multipart/form-data')); ?>

                                <div class="box-main">
                                    <h3>Destination Details</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Destination Name</label>
                                                <input type="text" class="form-control" placeholder="Enter destination name" name="destination_name" id="destination_name" value="<?php echo set_value('destination_name'); ?>">

                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Destination Url</label>
                                                <input type="text" class="form-control" readonly placeholder="Enter destination url" name="destination_url" id="destination_url" value="<?php echo set_value('destination_url'); ?>">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Destination Types</label>
                                                <?php
                                                $get_desti = $this->Common_model->get_records("destination_type_id, destination_type_name", "tbl_destination_type", "status = '1'", "destination_type_name asc", "");
                                                ?>
                                                <select data-placeholder="Choose destination type" class="chosen-select efilter" multiple tabindex="4" id="destination_type" name="destination_type[]" style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
                                                    <?php foreach ($get_desti as $get_destis) { ?>
                                                        <option value="<?= $get_destis['destination_type_id'] ?>">
                                                            <?= $get_destis['destination_type_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>State</label>
                                                <select class="form-control" name="state" id="state">
                                                    <option value="">Select State</option>
                                                    <?php
                                                    $state = set_value('state');
                                                    echo $this->Common_model->populate_select($state, "state_id", "state_name", "tbl_state", "status='1'", "state_name");
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <!--******************* Destination will come under getaways and destination *******************-->

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Destination Categories</label>
                                                <?php
                                                $get_desti = $this->Common_model->get_records("catid, cat_name", "tbl_menucateories", "status = '1' and menuid !='3' ", "cat_name asc", "");
                                                ?>
                                                <select data-placeholder="Choose destination category" class="chosen-select efilter" multiple tabindex="4" id="edesti" name="edesti[]" style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">

                                                    <?php foreach ($get_desti as $get_destis) { ?>
                                                        <option value="<?= $get_destis['catid'] ?>">
                                                            <?= $get_destis['cat_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label> Getaway Tags </label>
                                                <?php
                                                $get_getawaytags = $this->Common_model->get_records("tagid, tag_name", "tbl_menutags", "status = '1' and menuid != '3'", "tag_name asc", "");
                                                ?>

                                                <select data-placeholder="Choose getaway tags" class="chosen-select" multiple tabindex="4" id="getatagid" name="getatagid[]" style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
                                                    <?php foreach ($get_getawaytags as $get_getawaytag) { ?>
                                                        <option value="<?= $get_getawaytag['tagid'] ?>">
                                                            <?= $get_getawaytag['tag_name'] ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label> Banner Image</label>
                                                <input name="destiimg" id="destiimg" type="file">
                                                <span>Image size should be 2000px X 350px </span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Destination Image</label>
                                                <input name="destismallimg" id="destismallimg" type="file">
                                                <span>Image size should be 300px X 225px </span>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label> Alt Tag For Banner Image</label>
                                                <input type="text" class="form-control" placeholder="Enter Alt tag for banner image" name="alttag_banner" id="alttag_banner" value="<?php echo set_value('alttag_banner'); ?>" maxlength="60">
                                            </div>
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label> Alt Tag For Destination Image</label>
                                                <input type="text" class="form-control" placeholder="Enter Alt tag for destination image" name="alttag_thumb" id="alttag_thumb" value="<?php echo set_value('alttag_thumb'); ?>" maxlength="60">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div> 

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label> Destination Type (For showing in home page) </label>
                                                <select class="form-control" name="desttype_for_home" id="desttype_for_home">
                                                    <option value=''>-- Select Destination Type --</option>
                                                    <?php echo $this->Common_model->populate_select($dispid = 0, "parid", "par_value", "tbl_parameters", "param_type = 'TD'", "par_value asc", ""); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label> Show on footer menu</label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="checkbox" name="show_on_footer" id="show_on_footer" value="1">
                                                        For footer menu
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Pick / Drop Price
                                                    (<?php echo $this->Common_model->currency; ?>)</label>
                                                <input type="text" class="form-control" placeholder="Enter Pick or Drop Price" name="pick_drop_price" id="pick_drop_price" value="<?php echo set_value('pick_drop_price'); ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Minimum Accomodation Price /Person
                                                    (<?php echo $this->Common_model->currency; ?>)</label>
                                                <input type="text" class="form-control" placeholder="Enter Minimum Accomodation price" name="accomodation_price" id="accomodation_price" value="<?php echo set_value('accomodation_price'); ?>">
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Latitude</label>
                                                <input type="text" class="form-control" placeholder="Destination Latitude" name="latitude" id="latitude" value="<?php echo set_value('latitude'); ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Longitude</label>
                                                <input type="text" class="form-control" placeholder="Destination Longitude" name="longitude" id="longitude" value="<?php echo set_value('longitude'); ?>">
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>To Find Latitude and Longitude Click <a href="http://www.latlong.net" target="_blank" style="color:#18c4c0">http://www.latlong.net</a></label>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>About Destination</label>
                                                <textarea name="short_desc" id="short_desc" class="form-control "><?php echo set_value("short_desc"); ?></textarea>
                                                <div id="proddesc_errorloc"></div>
                                            </div>
                                            <div id="aboutdest_err"></div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Places to Visit Text</label>
                                                <textarea name="places_to_visit_desc" id="places_to_visit_desc" class="form-control "><?php echo set_value("places_to_visit_desc"); ?></textarea>
                                                <div id="proddesc_errorloc"></div>
                                            </div>
                                            <div id="placesdesc_errorloc"></div>
                                        </div>

                                        <div class="clearfix"></div>

                                    </div>
                                </div>

                                <div class="box-main">
                                    <h3>Common Information</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Ideal Trip Duration</label>

                                                <!--  <select class="form-control" name="trip_duration" id="trip_duration">
														 <option value=''>-- Select Duration --</option>
                                                             <?php echo $this->Common_model->populate_select($dispid = 0, "durationid", "duration_name", "tbl_package_duration", "", "duration_name asc", ""); ?>
                                                    </select>  -->
                                                <input type="text" class="form-control" placeholder="Ex- 3days / 2night" name="trip_duration" id="trip_duration" value="<?php echo set_value('trip_duration'); ?>">


                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nearest City</label>
                                                <input type="text" class="form-control" placeholder="Enter Nearest City" name="nearest_city" id="nearest_city" value="<?php echo set_value('nearest_city'); ?>">
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Best Time To Visit</label>
                                                <input type="text" class="form-control" placeholder="Enter Visit Time" name="visit_time" id="visit_time" value="<?php echo set_value('visit_time'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Peak Season</label>
                                                <input type="text" class="form-control" placeholder="Enter Peak season" name="peak_season" id="peak_season" value="<?php echo set_value('peak_season'); ?>">
                                            </div>
                                        </div>


                                        <div class="clearfix"></div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Weather Info</label>
                                                <input type="text" class="form-control" placeholder="Enter Weather info" name="weather_info" id="weather_info" value="<?php echo set_value('weather_info'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Similar Destination</label>

                                                <?php

                                                $get_desti = $this->Common_model->get_records("destination_id, destination_name", " tbl_destination", "status = '1'", "destination_name asc", "");
                                                ?>

                                                <select data-placeholder="Choose Similar Destination" class="chosen-select efilter" multiple tabindex="4" id="other_info" name="other_info[]" style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
                                                    <?php foreach ($get_desti as $get_destis) { ?>
                                                        <option value="<?= $get_destis['destination_id'] ?>">
                                                            <?= $get_destis['destination_name'] ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Near By Place</label>
                                                <?php

                                                $get_desti = $this->Common_model->get_records("destination_id, destination_name", " tbl_destination", "status = '1'", "destination_name asc", "");
                                                ?>

                                                <select data-placeholder="Choose Near By Place" class="chosen-select efilter" multiple tabindex="4" id="near_info" name="near_info[]" style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
                                                    <?php foreach ($get_desti as $get_destis) { ?>
                                                        <option value="<?= $get_destis['destination_id'] ?>">
                                                            <?= $get_destis['destination_name'] ?></option>
                                                    <?php } ?>
                                                </select>


                                            </div>
                                        </div>



                                    </div>
                                </div>



                                <div class="box-main">
                                    <h3>Other Information</h3>
                                    <div class="row">



                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Internet Availability</label>
                                                <input type="text" class="form-control" placeholder=" Enter Internet Availability" name="internet_avl" id="internet_avl" value="<?php echo set_value('internet_avl'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Std Code</label>
                                                <input type="text" class="form-control" placeholder="Enter Std Code" name="std_code" id="std_code" value="<?php echo set_value('std_code'); ?>">
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Languages Spoken</label>
                                                <input type="text" class="form-control" placeholder="Enter Languages Spoken" name="lng_spk" id="lng_spk" value="<?php echo set_value('lng_spk'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Major Festivals</label>
                                                <input type="text" class="form-control" placeholder="Enter Major Festivals" name="mjr_fest" id="mjr_fest" value="<?php echo set_value('mjr_fest'); ?>">
                                            </div>
                                        </div>


                                        <div class="clearfix"></div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Notes/Tips</label>
                                                <textarea class="form-control" placeholder="Notes/Tips..." name="note_tips" id="note_tips" value="<?php echo set_value('note_tips'); ?>"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Google Map</label>
                                                <textarea class="form-control" placeholder="Enter Google Map" name="google_map" id="google_map" value="<?php echo set_value('google_map'); ?>"></textarea>
                                                Example : &lt;iframe
                                                src="https://www.google.com/maps/d/embed?mid=19xHbU7LdnDtVsj_gR5u6EpnQ4OM&hl=en"
                                                width="100%" height="300" frameborder="0" style="border:0"
                                                allowfullscreen&gt; &lt;/iframe&gt;
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>






                                    </div>
                                </div>



                                <div class="box-main">
                                    <h3>Overview Meta Tags</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Title</label>
                                                <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="meta_title" id="meta_title"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Keyword</label>
                                                <textarea name="meta_keywords" id="meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1"></textarea>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Description</label>
                                                <textarea name="meta_description" id="meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea"></textarea>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                    </div>
                                </div>
                                
                                
                                <div class="box-main">
                                    <h3>Place Meta Tags</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Title</label>
                                                <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="place_meta_title" id="place_meta_title"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Keyword</label>
                                                <textarea name="place_meta_keywords" id="place_meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1"></textarea>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Description</label>
                                                <textarea name="place_meta_description" id="place_meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea"></textarea>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                    </div>
                                </div>
                                <div class="box-main">
                                    <h3> Package Meta Tags</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Title</label>
                                                <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="pckg_meta_title" id="pckg_meta_title"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Keyword</label>
                                                <textarea name="pckg_meta_keywords" id="pckg_meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1"></textarea>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Description</label>
                                                <textarea name="pckg_meta_description" id="pckg_meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea"></textarea>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-md-6">
                                    <div class="reset-button">
                                        <button type="submit" class="btn redbtn" name="btnSubmit" id="btnSubmit">Save</button>
                                        <button name='reset' type="reset" value='Reset' class="btn blackbtn">Reset</button>
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
        <script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript">
        </script>
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
            CKEDITOR.replace('places_to_visit_desc');

            $(document).ready(function() {
                $('#edesti').chosen();
                $('#near_info').chosen();
                $('#other_info').chosen();
                $('#destination_type').chosen();
                $('#getatagid').chosen();
                $("#edesti").change(function() {
                    var menu = $(this);
                });
            });
        </script>

</body>

</html>