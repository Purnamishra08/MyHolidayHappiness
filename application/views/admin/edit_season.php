<?php
foreach ($row as $rows)
{

    $hotelid       = $rows['hotel_id'];                
    $seasontype    = $rows['season_type'];
    $fsmonth       = $rows['sesonstart_month'];
    $fsdate        = $rows['sesonstart_day'];
    $femonth       = $rows['sesonend_month'];
    $fedate        = $rows['sesonend_day'];
    $adultprice    = $rows['adult_price'];
    $coupleprice   = $rows['couple_price'];
    $kidprice      = $rows['kid_price'];
    $adultextra    = $rows['adult_extra'];
    $status        = $rows['status'];   
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
                                   
        <?php echo form_open('', array( 'id' => 'form_season', 'name' => 'form_season', 'class' => 'add-user', ));?>
                                    

                                          <div class="box-main">
                                          <h3>Season Wise Price(In <?php echo $this->Common_model->currency; ?>)</h3>
                                         

                                       <div class="row">                                                
                                              <div class="col-md-12">
                                                <div class="table-responsive">
                                         <table id="addRowTable" class="table table-bordered table-striped table-hover">
                                                      <thead>
                                                          <tr class="info">
                                                              <th width="15%">Season Type</th>
                                                              <th width="20%">Season Start Duration</th>
                                                              <th width="20%">Season End Duration </th>
                                                              <th width="10%">Price/Adult (<?php echo $this->Common_model->currency; ?>)</th>
                                                              <th width="10%">Price/Couple (<?php echo $this->Common_model->currency; ?>)</th>
                                                              <th width="10%">Price/Kids (<?php echo $this->Common_model->currency; ?>)</th>
                                                              <th width="10%">Extra Bed/Adult</th>                                                             
                                                          </tr>
                                                      </thead>
                                                      <tbody>  
                                                          <tr>
                                                              <td>

                                                   <select class="form-control"  id="season_type"  name="season_type" >
                                                           <option value="">-- Select Type --</option>
                                                         <?php  echo $this->Common_model->populate_select($seasontype, "season_type_id", "season_type_name", " tbl_season_type", "", "season_type_name asc", ""); ?>
                                                      </select>

                                                        <div id="seasontype_err">  </div>
                                                              </td>
                                                              

                                                              <td>
                                                       <div class="row">      
														<div class="col-md-6 col-sm-6 col-xs-6">
															<select name="from_startmonth" class="form-control" id="from_startmonth" >
																<option value="">--Month--</option>
																<option value="01" <?php if($fsmonth == 1 ){ echo 'selected="selected"'; } ?> >January</option>
																<option value="02" <?php if($fsmonth == 2 ){ echo 'selected="selected"'; } ?>>February</option>
																<option value="03" <?php if($fsmonth == 3 ){ echo 'selected="selected"'; } ?>>March</option>
																<option value="04" <?php if($fsmonth == 4 ){ echo 'selected="selected"'; } ?>>April</option>
																<option value="05" <?php if($fsmonth == 5 ){ echo 'selected="selected"'; } ?>>May</option>
																<option value="06" <?php if($fsmonth == 6 ){ echo 'selected="selected"'; } ?>>June</option>
																<option value="07" <?php if($fsmonth == 7 ){ echo 'selected="selected"'; } ?>>July</option>
																<option value="08" <?php if($fsmonth == 8 ){ echo 'selected="selected"'; } ?>>August</option>
																<option value="09" <?php if($fsmonth == 9 ){ echo 'selected="selected"'; } ?>>September</option>
																<option value="10" <?php if($fsmonth == 10 ){ echo 'selected="selected"'; } ?>>October</option>
																<option value="11" <?php if($fsmonth == 11 ){ echo 'selected="selected"'; } ?>>November</option>
																<option value="12" <?php if($fsmonth == 12 ){ echo 'selected="selected"'; } ?>>December</option>
															</select>
															<div id="fromstartmonth_err">  </div>
													  </div>

                                         
                                           <div class="col-md-6 col-sm-6 col-xs-6">
                                              
                                              <select name="from_startdate" class="form-control" id="from_startdate">
                                              <option value="">--Day--</option>
                                           
                                              <?php
                                              for ($i = 1; $i < 32; $i++) {
                                                  ?><option value="<?php echo $i ?>" <?php if($fsdate == $i) { ?> selected="selected" <?php } ?> ><?php echo $i ?></option>
                                                  <?php
                                              }
                                              ?>    
                                            
                                             </select>
                                              <div id="fromstartdate_err">  </div>
                                           </div>

                                             
                                            </div>

                                             </td>

                                             <td>
                                               <div class="row">      
													<div class="col-md-6 col-sm-6 col-xs-6">
														<select name="from_endmonth" class="form-control" id="from_endmonth" >
															<option value="">--Month--</option>
															<option value="01" <?php if($femonth == 1 ){ echo 'selected="selected"'; } ?> >January</option>
															<option value="02" <?php if($femonth == 2 ){ echo 'selected="selected"'; } ?>>February</option>
															<option value="03" <?php if($femonth == 3 ){ echo 'selected="selected"'; } ?>>March</option>
															<option value="04" <?php if($femonth == 4 ){ echo 'selected="selected"'; } ?>>April</option>
															<option value="05" <?php if($femonth == 5 ){ echo 'selected="selected"'; } ?>>May</option>
															<option value="06" <?php if($femonth == 6 ){ echo 'selected="selected"'; } ?>>June</option>
															<option value="07" <?php if($femonth == 7 ){ echo 'selected="selected"'; } ?>>July</option>
															<option value="08" <?php if($femonth == 8 ){ echo 'selected="selected"'; } ?>>August</option>
															<option value="09" <?php if($femonth == 9 ){ echo 'selected="selected"'; } ?>>September</option>
															<option value="10" <?php if($femonth == 10 ){ echo 'selected="selected"'; } ?>>October</option>
															<option value="11" <?php if($femonth == 11 ){ echo 'selected="selected"'; } ?>>November</option>
															<option value="12" <?php if($femonth == 12 ){ echo 'selected="selected"'; } ?>>December</option>
														</select>
														<div id="fromendmonth_err"></div>
													</div>
                                         
                                           
                                         
                                               <div class="col-md-6 col-sm-6 col-xs-6">  
                                              <select name="from_enddate" class="form-control" id="from_enddate">
                                              <option value="">--Day--</option>
                                           
                                              <?php
                                              for ($i = 1; $i < 32; $i++) {
                                                  ?><!-- <option value="<?php echo $i ?>"><?php echo $i ?></option> -->
                                                  <option value="<?php echo $i ?>" <?php if($fedate == $i) { ?> selected="selected" <?php } ?> ><?php echo $i ?></option>
                                                  <?php
                                              }
                                              ?>    

                                             </select>
                                               <div id="fromenddate_err"></div>
                                            </div>
                              
                                          </div>
                                             </td>

                                                             
                                                              

                                                              <td>
                                                                  <input type="text" class="form-control" placeholder="Price" name="adult_price" id="adult_price" value="<?php echo set_value('adult_price' ,$adultprice); ?>"> 
                                                                   
                                                                  <div id="adultprice_err">  </div>     
                                                              </td>

                                                              <td>
                                                                   <input type="text" class="form-control" placeholder="Price" name="couple_price" id="couple_price" value="<?php echo set_value('couple_price' ,$coupleprice); ?>">  

                                                                    <div id="coupleprice_err">  </div> 
 
                                                                   </td>    
                                                              </td>

                                                               <td>
                                                                    <input type="text" class="form-control" placeholder="Price" name="kid_price" id="kid_price" value="<?php echo set_value('kid_price' ,$kidprice); ?>">

                                                                    <div id="kidprice_err">  </div> 
                                                              </td>


                                                               <td>
                                                                   <input type="text" class="form-control" placeholder="Price" name="adult_extra" id="adult_extra" value="<?php echo set_value('adult_extra' ,$adultextra); ?>">  

                                                                    <div id="adultextra_err">  </div>  
                                                              </td>

                                                            

                                                          </tr>           
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
                                      <button type="button" class="btn blackbtn" onClick="window.location='<?php echo base_url()."admin/hotel/edit/".$hotelid ; ?>'">back</button> 
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

