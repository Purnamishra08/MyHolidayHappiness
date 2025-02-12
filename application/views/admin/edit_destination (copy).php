<?php
foreach ($row as $rows)
{
    $destid    = $rows['destination_id'];
    $dname     = $rows['destination_name'];
    $durl      = $rows['destination_url'];
    //$dtype     = $rows['destination_type'];
    $dstate    = $rows['state'];                  
    $dtrip     = $rows['trip_duration'];
    $dcity     = $rows['nearest_city'];
    $dtime     = $rows['visit_time'];
    $dpeak     = $rows['peak_season'];
    $dweather  = $rows['weather_info'];
    $dmap      = $rows['google_map'];
    $dinfo     = $rows['other_info'];
    $dprice    = $rows['pick_drop_price'];
    $ddesc     = $rows['about_destination'];
    $internet  = $rows['internet_availability'];
    $std       = $rows['std_code'];
    $lspeak    = $rows['language_spoken'];
    $mfest     = $rows['major_festivals'];
    $ntips     = $rows['note_tips'];
    $destpic = $rows['destiimg']; 
    $status = $rows['status'];

    $statename=$this->Common_model->showname_fromid("state_name","tbl_state","state_id='$dstate'");


    $destiplace= $this->Common_model->join_records("b.place_name","tbl_place_type as a", "tbl_places as b", "a.placetype_name=b.placeid", "a.destination_id=$destid");
    
     $alldestiplaces = array();
     $showalldestiplaces = "";
     if($destiplace != "")
     {
        foreach($destiplace as $destiplaces)
        {
            $alldestiplaces[] = $destiplaces["place_name"];
        }
        $showalldestiplaces = implode(', ', $alldestiplaces);
     }


}





?>

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
                        <i class="fa fa-users"></i>
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

        <?php echo form_open('', array( 'id' => 'form_editdestination', 'name' => 'form_editdestination', 'class' => 'add-user', 'enctype' => 'multipart/form-data'));?>
                                       
                                          <div class="box-main">
                                            <h3>Destination Details</h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                      <label>Destination Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter Destination Name" name="destination_name" id="destination_name" value="<?php echo set_value('destination_name',$dname); ?>">
                                                
                                                    </div>   
                                                   
                                                </div>
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Destination Url</label>
                                                    <input type="text" class="form-control" placeholder="Enter destination url" name="destination_url" id="destination_url" value="<?php echo set_value('destination_url' ,$durl); ?>">
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>                                                

                                                <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Destination Type</label>
                                                   <?php   

                                                          $get_desti = $this->Common_model->get_records("destination_type_id, destination_type_name", "tbl_destination_type", "status = '1'", "destination_type_name asc", "");
                                                        ?>

                                                    <select data-placeholder="Choose Destination Type" class="chosen-select efilter" multiple tabindex="4" id="destination_type"  name="destination_type[]"
                                                         style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
                                                            <?php foreach ($get_desti as $get_destis) { ?>
                                                            <option value="<?= $get_destis['destination_type_id'] ?>"><?= $get_destis['destination_type_name'] ?></option>
                                                            <?php } ?>
                                                        </select> 


                                                </div>

                                                    <?php 
                                                        $destypes= $this->Common_model->join_records("a.multdest_name, b.destination_type_name","tbl_multdest_type as a", "tbl_destination_type as b", "a.multdest_name=b.destination_type_id", "a.destinationid=$destid");
                                                        if(!empty($destypes)){
                                                            foreach ($destypes as $destype) {
                                                                $typeid = $destype['multdest_name'];
                                                                $types = $destype['destination_type_name'];
                                                    ?>
                                               
                                                        <div class="a-remove-tag1" id="remove_tps-<?php echo $typeid;?>"><?php echo ' ' . $types; ?><input title="Delete" type="button" name="imgdelete" id="imgdelete" class="buttondel" onClick="removethistype('<?php echo $destid ; ?>','<?php echo  $typeid; ?>');"></div>
                                                    <?php }  } ?>







                                                </div>
                                                <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>State</label>
                                                        <select class="form-control" name="state" id="state" >
                                                            <option value="0">Select State</option>
                                                            <?php
                                                               // $state = set_value('state');
                                                                echo $this->Common_model->populate_select($dstate ,"state_id","state_name","tbl_state", "status='1'", "state_name"); 
                                                            ?>
                                                    </select>
                                                </div>
                                                </div>

                                                <div class="clearfix"></div>
                                                
                                              <div class="col-md-6"> 
                                                   <div class="form-group">
                                                        <label>Destination Tag</label>
                                                        <?php
                                                          $get_desti = $this->Common_model->get_records("catid, cat_name", "tbl_menucateories", "status = '1' & menuid='1' ", "cat_name asc", "");
                                                        ?>
                                                        <select data-placeholder="Choose Destination Tag" class="chosen-select efilter" multiple tabindex="4" id="edesti"  name="edesti[]"
                                                         style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
                                                            <?php foreach ($get_desti as $get_destis) { ?>
                                                            <option value="<?= $get_destis['catid'] ?>"><?= $get_destis['cat_name'] ?></option>
                                                            <?php } ?>
                                                        </select> 
                                                    </div>
                            <?php 
                                    $tags= $this->Common_model->join_records("a.tag_name, b.cat_name","tbl_destination_tag as a", "tbl_menucateories as b", "a.tag_name=b.catid", "a.destination_id=$destid");
                                                        if(!empty($tags)) {
                                                            foreach ($tags as $tag) {
                                                                $tagid = $tag['tag_name'];
                                                                $tagss = $tag['cat_name'];
                                                    ?>
                                               
                                    <div class="a-remove-tag1" id="remove_tgs-<?php echo $tagid;?>"><?php echo ' ' . $tagss; ?><input title="Delete" type="button" name="imgdelete" id="imgdelete" class="buttondel" onClick="removethistag('<?php echo $destid; ?>','<?php echo $tagid; ?>');"></div>
                                                    <?php }  } ?>
                                 

                                                </div>

                                              <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Pick & Drop Price (<?php echo $this->Common_model->currency; ?>)</label>
                                                    <input type="text" class="form-control" placeholder="Enter Pick & Drop Price" name="pick_drop_price" id="pick_drop_price" value="<?php echo set_value('pick_drop_price' , $dprice); ?>">
                                                </div>
                                                </div>
                                                
                                    
                                                <div class="clearfix"></div>                                                

                                               <div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Destination Image</label>
                                                    <input name="destiimg" id="destiimg" type="file"><span>Image size should be 400px*800px</span></td>
                                                </div>
                                                </div>

                                                <div class="col-md-6">
                                                        <?php
                                                        if (file_exists("./uploads/" . $destpic) && ($destpic != '')) {
                                                            echo '<a href="' . base_url() . 'uploads/' . $destpic . '" target="_blank"><img src="' . base_url() . 'uploads/' . $destpic . '" style="width:100px;height:auto;" /></a>';
                                                        }
                                                        ?>
                                                    </div>
                                            
                                              
                                                <div class="clearfix"></div>
                                               
                                                <div class="col-md-12">
                                                     <div class="form-group">
                                                        <label>About Destination</label>
                                                        <textarea name="short_desc" id="short_desc" class="form-control" ><?php echo set_value("short_desc", $ddesc); ?> </textarea>
                                                        <div id="proddesc_errorloc"></div>
                                                    </div>
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
                                                    <input type="text" class="form-control" placeholder=" 2-3 Days" name="trip_duration" id="trip_duration" value="<?php echo set_value('trip_duration' , $dtrip ); ?>">
                                                </div>
                                                </div>
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Nearest City</label>
                                                    <input type="text" class="form-control" placeholder="Enter Nearest City" name="nearest_city" id="nearest_city" value="<?php echo set_value('nearest_city' ,$dcity); ?>">
                                                </div>
                                                </div>
                                                
                                                <div class="clearfix"></div>
                                                
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Best time to visit</label>
                                                    <input type="text" class="form-control" placeholder="Enter Visit Time" name="visit_time" id="visit_time" value="<?php echo set_value('visit_time' ,$dtime); ?>">
                                                </div>
                                                </div>
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Peak season</label>
                                                    <input type="text" class="form-control" placeholder="Enter Peak season" name="peak_season" id="peak_season" value="<?php echo set_value('peak_season' , $dpeak); ?>">
                                                </div>
                                                </div>
                                                
                                                
                                                <div class="clearfix"></div> 
                                                
                                                
                                                <div class="col-md-6"> 
                                                   <div class="form-group">
                                                    <label>Weather info</label>
                                                    <input type="text" class="form-control" placeholder="Enter Weather info" name="weather_info" id="weather_info" value="<?php echo set_value('weather_info' ,$dweather); ?>">
                                                </div>
                                                </div>
                                                <div class="col-md-6"> 
                                                   <div class="form-group">
                                                    <label>Similar Destination</label>
                                                    <input type="text" class="form-control" placeholder="Enter Similar Destination" name="other_info" id="other_info" value="<?php echo set_value('other_info' , $dinfo); ?>">
                                                </div>
                                                </div>
                                               
                                                <div class="clearfix"></div> 


                                                  <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Near By Place</label>
                                                   <?php   

                                                          $get_desti = $this->Common_model->get_records("placeid, place_name", "tbl_places", "status = '1'", "place_name asc", "");
                                                        ?>

                                                    <select data-placeholder="Choose Near By Place" class="chosen-select efilter" multiple tabindex="4" id="near_info"   name="near_info[]"
                                                         style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
                                                            <?php foreach ($get_desti as $get_destis) { ?>
                                                            <option value="<?= $get_destis['placeid'] ?>"><?= $get_destis['place_name'] ?></option>
                                                            <?php } ?>
                                                        </select> 
                                                     </div>


                                                     <?php 

                                     $destiplace= $this->Common_model->join_records("a.placetype_name, b.place_name","tbl_place_type as a", "tbl_places as b", "a.placetype_name=b.placeid", "a.destination_id=$destid");

                                                        if(!empty($destiplace)){
                                                            foreach ($destiplace as $destiplaces) {
                                                                $placetagid = $destiplaces['placetype_name'];
                                                                $placetagss = $destiplaces['place_name'];
                                                    ?>
                                               
                                    <div class="a-remove-tag1" id="remove_tgs-<?php echo $tagid;?>"><?php echo ' ' . $placetagss; ?><input title="Delete" type="button" name="imgdelete" id="imgdelete" class="buttondel" onClick="removethistag('<?php echo $destid; ?>','<?php echo $placetagid; ?>');"></div>
                                                    <?php }  } ?>
                                 

                                                </div>


                                            </div>
                                        </div> 
                                         


                                          <div class="box-main">
                                            <h3>Other Information</h3>
                                            <div class="row">
                                                
                                                
                                              
                                                <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Internet Availability</label>
                                                    <input type="text" class="form-control" placeholder=" Enter Internet Availability" name="internet_avl" id="internet_avl" value="<?php echo set_value('internet_avl' , $internet); ?>">
                                                </div>
                                                </div>
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Std Code</label>
                                                    <input type="text" class="form-control" placeholder="Enter Std Code" name="std_code" id="std_code" value="<?php echo set_value('std_code' , $std); ?>">
                                                </div>
                                                </div>
                                                
                                                <div class="clearfix"></div>
                                                
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Languages Spoken</label>
                                                    <input type="text" class="form-control" placeholder="Enter Languages Spoken" name="lng_spk" id="lng_spk" value="<?php echo set_value('lng_spk' , $lspeak); ?>">
                                                </div>
                                                </div>
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Major Festivals</label>
                                                    <input type="text" class="form-control" placeholder="Enter Major Festivals" name="mjr_fest" id="mjr_fest" value="<?php echo set_value('mjr_fest' , $mfest); ?>">
                                                </div>
                                                </div>
                                                
                                                
                                                <div class="clearfix"></div> 
                                                
                                                
                                                <div class="col-md-6"> 
                                                   <div class="form-group">
                                                    <label>Notes/Tips</label>
                                                   <textarea class="form-control" placeholder="Notes/Tips..." name="note_tips" id="note_tips" ><?php echo set_value("note_tips", $ntips); ?></textarea>
                                                </div>

                                                </div>
                                                <div class="col-md-6"> 
                                                   <div class="form-group">
                                                  <label>Google Map</label>
                                                       <textarea class="form-control" placeholder="Enter Google Map" name="google_map" id="google_map" ><?php echo set_value("google_map", $dmap); ?></textarea>


                                                </div>
                                                </div>
                                               
                                                <div class="clearfix"></div> 
                                            </div>
                                        </div>            



                                        <div class="box-main">
                                            <h3>Meta Tags</h3>
                                            <div class="row">
                                                
                                                
                                              
                                                <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Meta Title</label>
                                                    <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="meta_title" id="meta_title"></textarea>
                                                </div>
                                                </div>
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Meta Keywords</label>
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
                </section>
            </div>
    <?php include("footer.php"); ?>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/additional-methods.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.js" type="text/javascript"></script>


<script type="text/javascript">

        CKEDITOR.replace('short_desc');

                $(document).ready(function(){
                    $('#edesti').chosen();    
                    $('#near_info').chosen();   
                    $('#destination_type').chosen();    
                    $("#edesti").change(function () {
                        var menu = $(this);
                    });
                });
        </script>




    <script type="text/javascript"> 
        function removethistype(pid, tid)
        {
            /*var con = confirm("Are you Sure to delete this tag ?");
            if (con){*/

                //var csrfName = '<?php //echo $this->security->get_csrf_token_name(); ?>',
                //csrfHash = '<?php //echo $this->security->get_csrf_hash(); ?>';
               // var dataJson = { [csrfName]: csrfHash, posid: pid, ta_id: tid};
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'admin/destination/delete_apptag'; ?>",
                    data: "posid=" + pid + "&ta_id=" + tid,
                    //data: dataJson,
                    success: function (html)
                    {
                        alert(html);
                        $('.remove_tps').remove();
                        $('#remove_tps-'+tid).remove();    
                    }
                });
            /*} 
            else{
                return false;
            }*/
        }        
    </script>



<script type="text/javascript"> 
        function removethistag(ptid, ttid)
        {
            /*var con = confirm("Are you Sure to delete this tag ?");
            if (con){*/
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'admin/destination/delete_desttag'; ?>",
                    data: "possid=" + ptid + "&tat_id=" + ttid,
                    success: function (html)
                    {
                        alert(html);
                        $('.remove_tgs').remove();
                        $('#remove_tgs-'+tid).remove();    
                    }
                });
            /*} 
            else{
                return false;
            }*/
        }        
    </script>





    </body>
</html>

