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
                      <small>Add Hotel</small>
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
									<?php echo form_open('', array( 'id' => 'form_hotel', 'name' => 'form_hotel', 'class' => 'add-user', 'enctype' => 'multipart/form-data'));?>
                                    
                                        <div class="box-main">
											<h3>Hotel Details</h3>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Hotel Name</label>
														<input type="text" class="form-control" placeholder="Enter Hotel Name" name="hotel_name" id="hotel_name" value="<?php echo set_value('hotel_name'); ?>">                                              
													</div>                                                    
												</div>
												
												<div class="col-md-6"> 
													<div class="form-group">
														<label>Destination</label>
														<select class="form-control"  id="destination_name"  name="destination_name" >
															<option value="">-- Select destination --</option>
															<?php  echo $this->Common_model->populate_select($dispid = 0, "destination_id", "destination_name", "tbl_destination", "", "destination_name asc", ""); ?>
														</select>
													</div>
												</div>
												<div class="clearfix"></div>                                                

												<div class="col-md-6"> 
													<div class="form-group">
														<label>Hotel Type</label>
														<select class="form-control"  id="hotel_type"  name="hotel_type" >
															<option value="">-- Select Hotel Type --</option>
															<?php  echo $this->Common_model->populate_select($dispid = 0, "hotel_type_id", "hotel_type_name", " tbl_hotel_type", "", "hotel_type_name asc", ""); ?>
														</select>
													</div>
													<div id="hoteltype_err"> </div>
												</div>
												
												<div class="col-md-6"> 
													<div class="form-group">
														<label>Room Type</label>
														<input type="text" class="form-control" placeholder="Enter Room Type" name="room_type" id="room_type" value="<?php echo set_value('room_type'); ?>">
													</div>
												</div>
                                  
												<div class="clearfix"></div> 
												
												<div class="col-md-6"> 
													<div class="form-group">
														<label>Trip Advisor URL</label>
														<input type="text" class="form-control" placeholder="Enter Trip Advisor URL" name="trip_url" id="trip_url" value="<?php echo set_value('trip_url'); ?>">
													</div>
												</div>
												
												<div class="col-md-6"> 
													<div class="form-group">
														<label>Default Price (<?php echo $this->Common_model->currency; ?>)</label>
														<input type="text" class="form-control" placeholder="Enter Default Price" name="default_price" id="default_price" value="<?php echo set_value('default_price'); ?>">
													</div>
												</div>
                                  
												<div class="clearfix"></div> 
												
												<div class="col-md-6"> 
													<div class="form-group">
														<label>Star Ratings (Out of 5)</label>
														<input type="text" class="form-control" placeholder="Enter Star Ratings. Eg. 4 or 4.5 " name="star_ratings" id="star_ratings" value="<?php echo set_value('star_ratings'); ?>">
													</div>
												</div>
                                              
											</div>
										</div>


                                        <div class="box-main">
											<h3>Season Wise Price (In <?php echo $this->Common_model->currency; ?>)</h3>  
										    <div class="row">                                                
												<div class="col-md-12">                                                 
													<table id="addRowTable" class="table table-bordered table-striped table-hover">
														<thead>
															<tr class="info">
																<th width="17%">Season Type</th>
																<th width="20%">Season Start Duration</th>
																<th width="20%">Season End Duration </th>
																<th width="9%">Price/Adult (<?php echo $this->Common_model->currency; ?>)</th>
																<th width="9%">Price/Couple (<?php echo $this->Common_model->currency; ?>)</th>
																<th width="9%">Price/Kids (<?php echo $this->Common_model->currency; ?>)</th>
																<th width="9%">Extra Bed/Adult</th>
																<th width="7%"></th>
															</tr>
														</thead>
														<tbody>  
															<tr>
																<td>
																	<select class="form-control"  id="season_type"  name="season_type[]" >
																		<option value="">-- Select Type --</option>
																		<?php  echo $this->Common_model->populate_select($dispid = 0, "season_type_id", "season_type_name", " tbl_season_type", "", "season_type_name asc", ""); ?>
																	</select>
																	<div id="seasontype_err"></div>
																</td>                                                             

																<td>
																	<div class="row">      
																		<div class="col-md-6 col-sm-6 col-xs-6 months">
																			<select name="from_startmonth[]" class="form-control" id="from_startmonth" >
																				<option value="">--Month-- </option>
																				<option value="01">January</option>
																				<option value="02">February</option>
																				<option value="03">March</option>
																				<option value="04">April</option>
																				<option value="05">May</option>
																				<option value="06">June</option>
																				<option value="07">July</option>
																				<option value="08">August</option>
																				<option value="09">September</option>
																				<option value="10">October</option>
																				<option value="11">November</option>
																				<option value="12">December</option>
																			</select>
																			<div id="fromstartmonth_err">  </div>
																		</div>

																		<div class="col-md-6 col-sm-6 col-xs-6 months">
																			<select name="from_startdate[]" class="form-control" id="from_startdate">
																				<option value="">--Day--</option>                                           
																				<?php for ($i = 1; $i < 32; $i++) { ?>
																				<option value="<?php echo $i ?>"><?php echo $i ?></option>
																				<?php } ?>   
																			</select>
																			<div id="fromstartdate_err">  </div>
																		</div>
																	</div>
																</td>

																<td>
																	<div class="row">      
																		<div class="col-md-6 col-sm-6 col-xs-6 months">  
																			<select name="from_endmonth[]" class="form-control" id="from_endmonth" >
																				<option value="">--Month--</option>
																				<option value="01">January</option>
																				<option value="02">February</option>
																				<option value="03">March</option>
																				<option value="04">April</option>
																				<option value="05">May</option>
																				<option value="06">June</option>
																				<option value="07">July</option>
																				<option value="08">August</option>
																				<option value="09">September</option>
																				<option value="10">October</option>
																				<option value="11">November</option>
																				<option value="12">December</option>
																			</select>
																			<div id="fromendmonth_err"></div>
																		</div>

																		<div class="col-md-6 col-sm-6 col-xs-6 months">  
																			<select name="from_enddate[]" class="form-control" id="from_enddate">
																			<option value="">--Day--</option>
																			<?php for ($i = 1; $i < 32; $i++) { ?>
																			<option value="<?php echo $i ?>"><?php echo $i ?></option>
																			<?php } ?> 
																			</select>
																			<div id="fromenddate_err"></div>
																		</div>											  
																	</div>
																</td>                                                              

																<td>
																	<input type="text" class="form-control" placeholder="Price" name="adult_price[]" id="adult_price" value="<?php echo set_value('adult_price'); ?>">                                                                   
																	<div id="adultprice_err">  </div>     
																</td>

																<td>
																	<input type="text" class="form-control" placeholder="Price" name="couple_price[]" id="couple_price" value="<?php echo set_value('couple_price'); ?>">  
                                                                    <div id="coupleprice_err">  </div>  
																</td>

																<td>
                                                                    <input type="text" class="form-control" placeholder="Price" name="kid_price[]" id="kid_price" value="<?php echo set_value('kid_price'); ?>">
                                                                    <div id="kidprice_err">  </div> 
																</td>

																<td>
																	<input type="text" class="form-control" placeholder="Price" name="adult_extra[]" id="adult_extra" value="<?php echo set_value('adult_extra'); ?>"> 
                                                                    <div id="adultextra_err">  </div>  
																</td>

																<td>
																	<a href="javascript:void(0);" class="btn btn-success btn-sm views addrowbtn" title="Add"><i class="fa fa-plus"></i></a>
																	<a href="javascript:void(0);" class="btn btn-danger btn-sm views delrowbtn" title="Delete" name="del[]" id="del_0"><i class="fa fa-trash-o"></i></a> 
																</td>
															</tr>           
														</tbody>
													</table>
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
  <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

 <!--  <script>
  $(document.body).on('keyup change', '#hotel_name', function() {
      $("#destination_url").val(name_to_url($(this).val()));
  });
  function name_to_url(name) {
      name = name.toLowerCase(); // lowercase
      name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
      name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
      name = name.replace(/[^a-z0-9-]/g, ''); // remove everything that is not [a-z] or -
      return name;
  }
  </script> -->

 <!--  <script type="text/javascript">

      CKEDITOR.replace('short_desc');

              $(document).ready(function(){
                  $('#hotel_type').chosen(); 
                  $('#season_type').chosen();    
                  $("#hotel_type").change(function () {
                      var menu = $(this);
                  });
              });
      </script> -->

      <script>

      $(function () {
              $('.datepicker').datepicker({
                  format: 'dd/mm/yyyy',
                  todayHighlight: true,
                  autoclose: true,

              });
      });


      </script>


      <script>
          
   var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

  for (i = new Date().getFullYear() ; i > 2008; i--) {
      $.each(months, function (index, value) {
          $('#yearMonthInput').append($('<option />').val(index + "_" + i).html(value + " " + i));
      });                
  }





      </script>

      <!-- <script> 
      var date = new Date(); 
        
      document.getElementById('#yearMonthInput').innerHTML 
              = date.getDate(); 
     </script>
-->


  </body>
</html>

