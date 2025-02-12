<?php
foreach ($row as $rows) {
    $destid    = $rows['destination_id'];
    $dname     = $rows['destination_name'];
    $durl      = $rows['destination_url'];
    $latitude  = $rows['latitude'];
    $longitude = $rows['longitude'];
    $dstate    = $rows['state'];
    $dtrip     = $rows['trip_duration'];
    $dcity     = $rows['nearest_city'];
    $dtime     = $rows['visit_time'];
    $dpeak     = $rows['peak_season'];
    $dweather  = $rows['weather_info'];
    $dmap      = $rows['google_map'];
    $ddesc     = $rows['about_destination'];
    $pvdesc    = $rows['places_visit_desc'];
    $internet  = $rows['internet_availability'];
    $std       = $rows['std_code'];
    $lspeak    = $rows['language_spoken'];
    $mfest     = $rows['major_festivals'];
    $ntips     = $rows['note_tips'];
    $meta_title        = $rows['meta_title'];
    $meta_keywords     = $rows['meta_keywords'];
    $meta_description  = $rows['meta_description'];
    
    $place_meta_title        = $rows['place_meta_title'];
    $place_meta_keywords     = $rows['place_meta_keywords'];
    $place_meta_description  = $rows['place_meta_description'];
    
    
    $package_meta_title        = $rows['package_meta_title'];
    $package_meta_keywords     = $rows['package_meta_keywords'];
    $package_meta_description  = $rows['package_meta_description'];
    
    $destpic = $rows['destiimg'];
    $destiimg_thumb = $rows['destiimg_thumb'];
    $alttag_banner = $rows['alttag_banner'];
    $alttag_thumb = $rows['alttag_thumb'];
    $status = $rows['status'];
    $desttype_for_home = $rows['desttype_for_home'];
    $show_on_footer = $rows['show_on_footer'];
    $pick_drop_price = $rows['pick_drop_price'];
    $accomodation_price = $rows['accomodation_price'];

    $statename = $this->Common_model->showname_fromid("state_name", "tbl_state", "state_id='$dstate'");
}

$destiplace = $this->Common_model->get_records("simdest_id", "tbl_destination_places", "destination_id='$destid' and type='2' ", "");
$simarrayp = '';
if (!empty($destiplace)) {
    foreach ($destiplace as $destiplaces) {
        $simarrayp .= $destiplaces['simdest_id'] . ', ';
    }
}

//for destination types
$getdesttypeids = $this->Common_model->get_records("loc_type_id", "tbl_multdest_type", "loc_id='$destid' and loc_type = 1", "");
$typeisarray = '';
if (!empty($getdesttypeids)) {
    foreach ($getdesttypeids as $getdesttypeid) {
        $typeisarray .= $getdesttypeid['loc_type_id'] . ', ';
    }
}

//for destinsation category	
$getdesttagids = $this->Common_model->get_records("cat_id", "tbl_destination_cats", "destination_id='$destid'", "");
$catarray = '';
if (!empty($getdesttagids)) {
    foreach ($getdesttagids as $getdesttagid) {
        $catarray .= $getdesttagid['cat_id'] . ', ';
    }
}

//for simillar destinsation     
$getdestsimids = $this->Common_model->get_records("simdest_id", "tbl_destination_places", "destination_id='$destid' and type='1' ", "");
$simarray = '';
if (!empty($getdestsimids)) {
    foreach ($getdestsimids as $getdestsimid) {
        $simarray .= $getdestsimid['simdest_id'] . ', ';
    }
}

//for getaways tags      
$getdesttagids = $this->Common_model->get_records("tagid", "tbl_tags", "type_id='$destid' and type = 1", "");
$tagarray = '';
if (!empty($getdesttagids)) {
    foreach ($getdesttagids as $getdesttagid) {
        $tagarray .= $getdesttagid['tagid'] . ', ';
    }
}
?>

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
                    <h1>Destination</h1>
                    <small>Edit Destination</small>
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

                                <?php echo form_open('', array('id' => 'form_editdestination', 'name' => 'form_editdestination', 'class' => 'add-user', 'enctype' => 'multipart/form-data')); ?>

                                <div class="box-main">
                                    <h3>Destination Details</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Destination Name</label>
                                                <input type="text" class="form-control" placeholder="Enter Destination Name" name="destination_name" id="destination_name" value="<?php echo set_value('destination_name', $dname); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Destination Url</label>
                                                <input type="text" class="form-control" placeholder="Enter destination url" name="destination_url" id="destination_url" value="<?php echo set_value('destination_url', $durl); ?>">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Destination Types</label>
                                                <?php
                                                $get_desti = $this->Common_model->get_records("destination_type_id, destination_type_name", "tbl_destination_type", "status = '1'", "destination_type_name asc", "");
                                                ?>
                                                <select data-placeholder="Choose Destination Type" class="chosen-select efilter" multiple tabindex="4" id="destination_type" name="destination_type[]" style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
                                                    <?php foreach ($get_desti as $get_destis) { ?>
                                                        <option value="<?= $get_destis['destination_type_id'] ?>">
                                                            <?= $get_destis['destination_type_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div id="destinationtype_err"> </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>State</label>
                                                <select class="form-control" name="state" id="state">
                                                    <option value="">-- Select State --</option>
                                                    <?php
                                                    // $state = set_value('state');
                                                    echo $this->Common_model->populate_select($dstate, "state_id", "state_name", "tbl_state", "status='1'", "state_name");
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Destination Categories</label>
                                                <?php
                                                $get_desti = $this->Common_model->get_records("catid, cat_name", "tbl_menucateories", "status = '1'  and menuid !='3' ", "cat_name asc", "");
                                                ?>
                                                <select data-placeholder="Choose destination category" class="chosen-select efilter" multiple tabindex="4" id="edesti" name="edesti[]" style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
                                                    <?php foreach ($get_desti as $get_destis) { ?>
                                                        <option value="<?= $get_destis['catid'] ?>">
                                                            <?= $get_destis['cat_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div id="edesti_err"></div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label> Getaway Tags </label>
                                                <?php
                                                $get_getawaytags = $this->Common_model->get_records("tagid, tag_name", "tbl_menutags", "status = '1' and menuid != '3'", "tag_name asc", "");
                                                ?>
                                                <select data-placeholder="Choose getaway tags" class="chosen-select" multiple tabindex="4" id="gettagid" name="gettagid[]" style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
                                                    <?php foreach ($get_getawaytags as $get_getawaytag) { ?>
                                                        <option value="<?= $get_getawaytag['tagid'] ?>">
                                                            <?= $get_getawaytag['tag_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <?php
                                            if (file_exists("./uploads/" . $destpic) && ($destpic != '')) {
                                                echo '<a href="' . base_url() . 'uploads/' . $destpic . '" target="_blank"><img src="' . base_url() . 'uploads/' . $destpic . '" style="width:100px;height:auto;" /></a>';
                                            }
                                            ?>
                                            <div class="form-group">
                                                <label>Banner Image</label>
                                                <input name="destiimg" id="destiimg" type="file">
                                                <span>Image size should be 2000px X 350px </span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <?php
                                            if (file_exists("./uploads/" . $destiimg_thumb) && ($destiimg_thumb != '')) {
                                                echo '<a href="' . base_url() . 'uploads/' . $destiimg_thumb . '" target="_blank"><img src="' . base_url() . 'uploads/' . $destiimg_thumb . '" style="width:100px;height:auto;" /></a>';
                                            }
                                            ?>
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
                                                <input type="text" class="form-control" placeholder="Enter Alt tag for banner image" name="alttag_banner" id="alttag_banner" value="<?php echo set_value('alttag_banner', $alttag_banner); ?>" maxlength="60">
                                            </div>
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label> Alt Tag For Destination Image</label>
                                                <input type="text" class="form-control" placeholder="Enter Alt tag for destination image" name="alttag_thumb" id="alttag_thumb" value="<?php echo set_value('alttag_thumb', $alttag_thumb); ?>" maxlength="60">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div> 

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label> Destination Type (For showing in home page) </label>
                                                <select class="form-control" name="desttype_for_home" id="desttype_for_home">
                                                    <option value=''>-- Select Destination Type --</option>
                                                    <?php echo $this->Common_model->populate_select($dispid = $desttype_for_home, "parid", "par_value", "tbl_parameters", "param_type = 'TD'", "par_value asc", ""); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="accomodation"> Show on footer menu </label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="checkbox" name="show_on_footer" id="show_on_footer" value="1" <?php if ($show_on_footer == 1) { ?> checked="checked" <?php } ?>>
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
                                                <input type="text" class="form-control" placeholder="Enter Pick or Drop Price" name="pick_drop_price" id="pick_drop_price" value="<?php echo set_value('pick_drop_price', $pick_drop_price); ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Minimum Accomodation Price /Person
                                                    (<?php echo $this->Common_model->currency; ?>)</label>
                                                <input type="text" class="form-control" placeholder="Enter Minimum Accomodation price" name="accomodation_price" id="accomodation_price" value="<?php echo set_value('accomodation_price', $accomodation_price); ?>">
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Latitude</label>
                                                <input type="text" class="form-control" placeholder="Destination Latitude" name="latitude" id="latitude" value="<?php echo set_value('latitude', $latitude); ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Longitude</label>
                                                <input type="text" class="form-control" placeholder="Destination Longitude" name="longitude" id="longitude" value="<?php echo set_value('longitude', $longitude); ?>">
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
                                                <textarea name="short_desc" id="short_desc" class="form-control"><?php echo set_value("short_desc", $ddesc); ?> </textarea>
                                                <div id="proddesc_errorloc"></div>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Places to Visit Text</label>
                                                <textarea name="places_to_visit_desc" id="places_to_visit_desc" class="form-control "><?php echo set_value("places_to_visit_desc", $pvdesc); ?></textarea>
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

                                                <input type="text" class="form-control" placeholder="Ex- 3days / 2night" name="trip_duration" id="trip_duration" value="<?php echo set_value('trip_duration', $dtrip); ?>">


                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nearest City</label>
                                                <input type="text" class="form-control" placeholder="Enter Nearest City" name="nearest_city" id="nearest_city" value="<?php echo set_value('nearest_city', $dcity); ?>">
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Best time to visit</label>
                                                <input type="text" class="form-control" placeholder="Enter Visit Time" name="visit_time" id="visit_time" value="<?php echo set_value('visit_time', $dtime); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Peak season</label>
                                                <input type="text" class="form-control" placeholder="Enter Peak season" name="peak_season" id="peak_season" value="<?php echo set_value('peak_season', $dpeak); ?>">
                                            </div>
                                        </div>


                                        <div class="clearfix"></div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Weather info</label>
                                                <input type="text" class="form-control" placeholder="Enter Weather info" name="weather_info" id="weather_info" value="<?php echo set_value('weather_info', $dweather); ?>">
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
                                                $get_desti =  $this->Common_model->get_records("destination_id, destination_name", " tbl_destination", "status = '1'", "destination_name asc", "");
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
                                                <input type="text" class="form-control" placeholder=" Enter Internet Availability" name="internet_avl" id="internet_avl" value="<?php echo set_value('internet_avl', $internet); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Std Code</label>
                                                <input type="text" class="form-control" placeholder="Enter Std Code" name="std_code" id="std_code" value="<?php echo set_value('std_code', $std); ?>">
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Languages Spoken</label>
                                                <input type="text" class="form-control" placeholder="Enter Languages Spoken" name="lng_spk" id="lng_spk" value="<?php echo set_value('lng_spk', $lspeak); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Major Festivals</label>
                                                <input type="text" class="form-control" placeholder="Enter Major Festivals" name="mjr_fest" id="mjr_fest" value="<?php echo set_value('mjr_fest', $mfest); ?>">
                                            </div>
                                        </div>


                                        <div class="clearfix"></div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Notes/Tips</label>
                                                <textarea class="form-control" placeholder="Notes/Tips..." name="note_tips" id="note_tips"><?php echo set_value("note_tips", $ntips); ?></textarea>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Google Map</label>
                                                <textarea class="form-control" placeholder="Enter Google Map" name="google_map" id="google_map"><?php echo set_value("google_map", $dmap); ?></textarea>
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
                                                <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="meta_title" id="meta_title"><?php echo $meta_title ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Keyword</label>
                                                <textarea name="meta_keywords" id="meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1"><?php echo $meta_keywords ?></textarea>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Description</label>
                                                <textarea name="meta_description" id="meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea"><?php echo $meta_description ?></textarea>
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
                                                <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="place_meta_title" id="place_meta_title"><?php echo $place_meta_title ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Keyword</label>
                                                <textarea name="place_meta_keywords" id="place_meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1"><?php echo $place_meta_keywords ?></textarea>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Description</label>
                                                <textarea name="place_meta_description" id="place_meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea"><?php echo $place_meta_description ?></textarea>
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
                                                <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="package_meta_title" id="package_meta_title"><?php echo $package_meta_title ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Keyword</label>
                                                <textarea name="package_meta_keywords" id="package_meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1"><?php echo $package_meta_keywords ?></textarea>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Description</label>
                                                <textarea name="package_meta_description" id="package_meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea"><?php echo $package_meta_description ?></textarea>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="col-md-6">
                                    <div class="reset-button">
                                        <button type="submit" class="btn redbtn" name="btnSubmit" id="btnSubmit">Update</button>
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
            </section>
        </div>
        <?php include("footer.php"); ?>
        <script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript">
        </script>
        <script src="<?php echo base_url(); ?>assets/admin/js_validation/additional-methods.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/ckeditor/ckeditor.js" type="text/javascript"></script>



        <script type="text/javascript">
            CKEDITOR.replace('short_desc');
            CKEDITOR.replace('places_to_visit_desc');

            $(document).ready(function() {
                $('#edesti').chosen();
                $('#other_info').chosen();
                $('#near_info').chosen();
                $('#destination_type').chosen();
                $('#gettagid').chosen();

                $("#edesti").change(function() {
                    var menu = $(this);
                });
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                var type_params = "<?php echo $typeisarray ?>";
                if (type_params != '') {
                    var rstr1 = type_params.replace(/,\s*$/, ""); //remove last comma from string
                    var type_array_data = rstr1.split(",");
                    $.each(type_array_data, function(index, val) {
                        $("#destination_type option[value=" + val + "]").attr('selected', 'selected');
                    });
                    $('#destination_type').trigger('chosen:updated');
                }
            });

            $(document).ready(function() {
                var cat_params = "<?php echo $catarray ?>";
                if (cat_params != '') {
                    var rstr2 = cat_params.replace(/,\s*$/, ""); //remove last comma from string
                    var cat_array_data = rstr2.split(",");
                    $.each(cat_array_data, function(index, val) {
                        $("#edesti option[value=" + val + "]").attr('selected', 'selected');
                    });
                    $('#edesti').trigger('chosen:updated');
                }
            });


            $(document).ready(function() {
                //for destination tags
                var tags_params = "<?php echo $tagarray ?>";
                if (tags_params != '') {
                    var rstr5 = tags_params.replace(/,\s*$/, ""); //remove last comma from string
                    var tag_array_data = rstr5.split(",");

                    $.each(tag_array_data, function(index, val) {
                        $("#gettagid option[value=" + val + "]").attr('selected', 'selected');
                    });
                    $('#gettagid').trigger('chosen:updated');
                }
            });


            $(document).ready(function() {
                //for simillar destination
                var sim_params = "<?php echo $simarray ?>";
                if (sim_params != '') {
                    var rstr4 = sim_params.replace(/,\s*$/, ""); //remove last comma from string
                    var sim_array_data = rstr4.split(",");
                    $.each(sim_array_data, function(index, val) {
                        $("#other_info option[value=" + val + "]").attr('selected', 'selected');
                    });
                    $('#other_info').trigger('chosen:updated');
                }
            });


            $(document).ready(function() {
                //for place
                var place_params = "<?php echo $simarrayp ?>";
                if (place_params != '') {
                    var rstr3 = place_params.replace(/,\s*$/, ""); //remove last comma from string
                    var place_array_data = rstr3.split(",");
                    $.each(place_array_data, function(index, val) {
                        $("#near_info option[value=" + val + "]").attr('selected', 'selected');
                    });
                    $('#near_info').trigger('chosen:updated');
                }
            });
        </script>

</body>

</html>