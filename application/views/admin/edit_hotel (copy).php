<?php
foreach ($row as $rows)
{
    $hotelid       = $rows['hotel_id'];
    $hotelname     = $rows['hotel_name'];
    $destname      = $rows['destination_name'];
    $hoteltype     = $rows['hotel_type'];
    $defaultprice  = $rows['default_price'];                  
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
                        <i class="fa fa-hotel"></i>
                    </div>
                    <div class="header-title">
                        <h1>Hotel</h1>
                        <small>Edit Hotel</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/hotel">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Hotel</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <?php echo $message; ?>
                                   
        <?php echo form_open('', array( 'id' => 'form_edithotel', 'name' => 'form_edithotel', 'class' => 'add-user', 'enctype' => 'multipart/form-data'));?>
                                    
                                        <div class="box-main">
                                          <h3>Hotel Details</h3>
                                          <div class="row">
                                              <div class="col-md-6">
                                              <div class="form-group">
                                                    <label>Hotel Name</label>
                                                  <input type="text" class="form-control" placeholder="Enter Hotel Name" name="hotel_name" id="hotel_name" value="<?php echo set_value('hotel_name' ,$hotelname); ?>">
                                              
                                                  </div>   
                                                 
                                              </div>
                                              <div class="col-md-6"> 
                                                  <div class="form-group">
                                                  <label>Destination</label>
                                                  <select class="form-control"  id="destination_name"  name="destination_name" >
                                                           <option value="">-- Select destination --</option>
                                                         <?php  echo $this->Common_model->populate_select($destname, "destination_id", "destination_name", "tbl_destination", "", "destination_name asc", ""); ?>
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="clearfix"></div>                                                

                                              <div class="col-md-6"> 
                                              <div class="form-group">
                                                  <label>Hotel Type</label>
													 <select class="form-control"  id="hotel_type"  name="hotel_type" >
														<option value="">-- Select Hotel Type --</option>
														<?php  echo $this->Common_model->populate_select($hoteltype, "hotel_type_id", "hotel_type_name", " tbl_hotel_type", "", "hotel_type_name asc", ""); ?>
													 </select>
                                              </div>
                                              </div>
                                              
                                              <div class="col-md-6"> 
                                              <div class="form-group">
                                                  <label>Default Price (<?php echo $this->Common_model->currency; ?>)</label>
                                                  <input type="text" class="form-control" placeholder="Enter Default Price" name="default_price" id="default_price" value="<?php echo set_value('default_price' ,$defaultprice); ?>">
                                              </div>
                                              </div>

                                  
                                              <div class="clearfix"></div>                                                

                                              
                                          </div>
                                      </div>


                                          <div class="box-main">
                                          <h3>Season Wise Price(<?php echo $this->Common_model->currency; ?>)</h3>
                                         

                                       <div class="row">                                                
                                              <div class="col-md-12">
                                                <div class="table-responsive">
                                        <table id="example" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr class="info">
                                                  
                                                    <th width="13%">Season Type</th>
                                                    <th width="9%">Season start month</th> 
                                                    <th width="9%">Season start date</th> 
                                                    <th width="9%">Season end month</th> 
                                                    <th width="9%">Season end date</th> 

                                                    <th width="9%">Adult Price</th> 
                                                    <th width="9%">Couple Price</th> 
                                                    <th width="9%">Kid Price</th> 
                                                    <th width="9%">Adult Extra Price</th>
                                                    <th width="9%">Action</th>  
                                                  
                                                
                                                   
                                                </tr>
                                            </thead>
                                           
                                                  <tbody>

                                                <?php
                                                $cnt = isset($startfrom) ? $startfrom : 0;
                                                $stype = $this->Common_model->get_records("*","tbl_season","hotel_id=$hotelid","");

                                                


                                                if (!empty($stype)) { 
                                                    foreach ($stype as $stypes) {
                                                     $cnt++;
                                                     $seasonid    = $stypes['season_id'];
                                                     $seasontype    = $stypes['season_type'];
                                                     $seasonsmonth    = $stypes['sesonstart_month'];
                                                     $seasonsdate   = $stypes['sesonend_month'];

                                                     $seasonemonth    = $stypes['sesonstart_day'];
                                                     $seasonedate    = $stypes['sesonend_day'];
                                                     $adultprice    = $stypes['adult_price'];
                                                     $coupleprice   = $stypes['couple_price'];
                                                     $kidprice      = $stypes['kid_price'];
                                                     $adultextra    = $stypes['adult_extra'];

                                                    $monthNum  = $seasonsmonth;
                                                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                    $monthstartName = $dateObj->format('F');

                                                    $monthNume  = $seasonsdate;
                                                    $dateObje   = DateTime::createFromFormat('!m', $monthNume);
                                                    $monthendName = $dateObje->format('F');


                                                   //$monthstart = sprintf("%02s", $seasonsmonth);
                                                   //$monthstartName = date("F", strtotime($seasonsmonth));

                                                   //$monthend = sprintf("%02s", $seasonemonth);
                                                   //$monthendName = date("F", strtotime($seasonemonth));


                                               $seasontypeaa=$this->Common_model->showname_fromid("season_type_name","tbl_season_type","season_type_id='$seasontype'");


                                                        ?>
                                                        <tr>
                                                      
                                                            <td><?php echo $seasontypeaa; ?></td>
                                                            <td><?php echo $monthstartName; ?></td>
                                                            <td><?php echo $seasonemonth; ?></td>
                                                            <td><?php echo $monthendName; ?></td>
                                                            <td><?php echo $seasonedate; ?></td>
                                                            <td><?php echo $adultprice; ?></td>
                                                            <td><?php echo $coupleprice; ?></td>
                                                            <td><?php echo $kidprice; ?></td>
                                                            <td><?php echo $adultextra; ?></td>
                                                            
                                                              <td>
                                                        <a href="<?php echo base_url().'admin/hotel/edit_season/'.$seasonid; ?>"  class="btn btn-success btn-sm view" title="View"> <i class="fa fa-pencil"></i></a>
                            
                                                        <a href="<?php echo base_url().'admin/hotel/delete_season/'.$hotelid.'/'.$seasonid; ?>"   onClick="return confirm('Are you sure to delete this season price?')"  class="btn btn-danger btn-sm " title=""><i class="fa fa-trash-o"></i> </a>

                                                                </td>
                                                           

                                                          
                                                        </tr>

                                                        <?php
                                                           }
                                                      } else {
                                                           ?>
                                                    <tr>
                                                        <td class="text-center" colspan="7"> No data available in table </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>


                                            
                                                                     
                                            </tbody>
                                        </table>
                                       
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
                    </div>
                </section>
            </div>

    <?php include("footer.php"); ?>
     <script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/additional-methods.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
   


<!-- <script type="text/javascript">

        CKEDITOR.replace('short_desc');

                $(document).ready(function(){
                    $('#edesti').chosen(); 
                    $('#other_info').chosen();     
                    $('#near_info').chosen();  
                    $('#destination_type').chosen();    
                    $("#edesti").change(function () {
                        var menu = $(this);
                    });
                });
        </script>
 -->



   



 <script type="text/javascript"> 
    
     $(document).ready(function () {        
		 var type_params = "<?php echo $typeisarray ?>"; 	
		 var rstr = type_params.replace(/,\s*$/, ""); //remove last comma from string
		 var type_array_data = rstr.split(",");
		 $.each(type_array_data, function (index, val) {
			 $("#destination_type option[value=" + val + "]").attr('selected', 'selected');
		 });
		 $('#destination_type').trigger('chosen:updated');
		 
		 var tag_params = "<?php echo $tagarray ?>"; 	
		 var rstr = tag_params.replace(/,\s*$/, ""); //remove last comma from string
		 var tag_array_data = rstr.split(",");
		 $.each(tag_array_data, function (index, val) {
			 $("#edesti option[value=" + val + "]").attr('selected', 'selected');
		 });
		 $('#edesti').trigger('chosen:updated');
		 
		 //for place
		 var place_params = "<?php echo $placetagssarray ?>"; 	
		 var rstr = place_params.replace(/,\s*$/, ""); //remove last comma from string
		 var place_array_data = rstr.split(",");
		 $.each(place_array_data, function (index, val) {
			 $("#near_info option[value=" + val + "]").attr('selected', 'selected');
		 });
		 $('#near_info').trigger('chosen:updated');

          //for simillar destination
         var sim_params = "<?php echo $simarray ?>";   
         var rstr = sim_params.replace(/,\s*$/, ""); //remove last comma from string
         var sim_array_data = rstr.split(",");
         $.each(sim_array_data, function (index, val) {
             $("#other_info option[value=" + val + "]").attr('selected', 'selected');
         });
         $('#other_info').trigger('chosen:updated');
		 
		 
		 
    });


</script>
		 


        <script>

        $(function () {
                $('.datepicker').datepicker({
                    format: 'dd/mm/yyyy',
                    todayHighlight: true,
                    autoclose: true,

                });
            });


        </script>



    </body>
</html>

