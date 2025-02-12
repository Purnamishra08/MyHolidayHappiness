<?php
$tourPackId = $this->uri->segment(4);
$package_duration = $this->Common_model->showname_fromid("package_duration","tbl_tourpackages","tourpackageid=$tourPackId");

$tourPack_rec = $this->Common_model->get_records("no_ofdays, no_ofnights","tbl_package_duration","durationid=$package_duration");
foreach ($tourPack_rec as $tourPack)
{
	$no_ofdays = $tourPack["no_ofdays"];
	$no_ofnights = $tourPack["no_ofnights"];
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
                        <i class="fa fa-globe"></i>
                    </div>
                    <div class="header-title">
                        <h1>Tour Packages</h1>
                        <small>Add Tour Package</small>
                    </div>
                </section>
                <!-- Main content --> 
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/tour-packages">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Tour Package</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">									
								<div class="col-md-12">
									<ul class="tab-btn">
										<li><a href="<?php echo base_url().'admin/tour_packages/edit/'.$tourPackId; ?>">Package Details</a></li>
										<li class="active" ><a href="<?php echo base_url().'admin/package-iternary/add/'.$tourPackId; ?>">Iternary </a></li>
										
									</ul>
                                </div>

                                   <?php echo $messageadd; ?>
                                    <?php echo form_open('', array( 'id' => 'form_packageiternary', 'name' => 'form_packageiternary', 'class' => 'add-user', 'enctype' => 'multipart/form-data'));?>
                                       
										<div class="box-main">
                                            <h3>Iternary Information</h3>
                                            <div class="row"> 
												<div class="col-md-12 dest-title"> <label> Associated Destinations </label>  </div>  
												
											   <div class="col-md-12">
												    <div class="col-md-12 label-head">														
														<div class="row"> 
															<div class="col-md-5" style="text-align:center;">Destination Name:</div>
															<div class="col-md-3">No of Days:</div>
															<div class="col-md-3">No of Nights:</div>
														</div>
												    </div>
												  
                                                    <div class="option-name" id="optnshwhd">
                                                        <table class="table border-none" id="addRowTable">
                                                            <tr>
                                                                <td>
																	<div class="col-md-5" >
																		<select class="form-control"  id="destination_id"  name="destination_id[]" >
																			<option value="">-- Select destination --</option>
																			<?php  echo $this->Common_model->populate_select($dispid = 0, "destination_id", "destination_name", "tbl_destination", "", "destination_name asc", ""); ?>
																		</select> 
																	</div>

																	<div class="col-md-3">  
																		<select class="form-control" name="no_ofdays[]" id="no_ofdays">
																			<option value=''>-- Select Days --</option>
																			<?php  echo $this->Common_model->generate_numberbox(0, $no_ofdays,"1"); ?>
																		</select>    
																	</div>

																	<div class="col-md-3" >	
																		<select class="form-control" name="no_ofnight[]" id="no_ofnight">
																			<option value=''>-- Select Nights --</option>
																			<?php  echo $this->Common_model->generate_numberbox(0, $no_ofnights); ?>
																		</select> 
																	</div>  
                                                                </td>
                                                                <td>                                                                
                                                                    <a href="javascript:void(0);" class="btn btn-success btn-sm view addrowbtn" title="Add"><i class="fa fa-plus"></i></a>
                                                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm view delrowbtn" title="Delete" name="del[]" id="del_0"><i class="fa fa-trash-o"></i></a>                                                              
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>													
                                               </div>
                                               
												<?php 
													$get_places = $this->Common_model->get_records("placeid, place_name", "tbl_places", "status = '1'", "place_name asc");
													if($no_ofdays) 
													{ 
												?>
													<div class="col-md-12 dest-title"> <label> Iternaries : </label> </div> 
													<div class="col-md-12">  
													<?php $arr=0; for ($i = 1; $i <= $no_ofdays ; $i++) { ?>
													    <div class="row mb10">                                              
															<div class="col-md-1">
																<?php if($i == 1) { ?>
																<label> Days </label> <br>
																<?php } ?>
																<label> <?php echo $i; ?> : </label>
															</div>
															
															<div class="col-md-6">
																<?php if($i == 1) { ?>
																<label> Iternary Titles </label> 
																<?php } ?>
																<input type="text" class="form-control" placeholder="EX- Start at 11 AM from Delhi -Hal-day Delhi Sightseeing" name="iternary_title[]" id="iternary_title" value="<?php echo set_value('iternary_title[]'); ?>">
															</div>

															<div class="col-md-5" >
																<?php if($i == 1) { ?>
																<label>Iternary places</label>
																<?php } ?>
																<select data-placeholder="Choose iternary places" class="chosen-select" multiple tabindex="4" id="getplaceid_<?php echo $i; ?>"  name="iternary_detais[<?php echo $arr; ?>][]" style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
																	<?php foreach ($get_places as $getplace) { ?>
																	<option value="<?php echo $getplace['placeid']; ?>"><?php echo $getplace['place_name']; ?></option>
																	<?php } ?>
																</select> 
															</div>                                                               
														</div>
														<div class="clearfix"></div> 
													<?php $arr++; } ?>
													</div>
													
													<div class="clearfix"></div> 
													<div class="col-md-12">
														 <div class="form-group">
															<label> Iternary Note	</label>
															<textarea name="itinerary_note" id="itinerary_note" class="form-control "><?php echo set_value("itinerary_note"); ?></textarea>
														</div>
														<div id="inclusion_err"></div>
													</div>
													<div class="clearfix"></div>
												<?php }  ?>
                                            </div>
												                                                                      
    										<div class="col-md-6">
                                                <div class="reset-button"> 
                                                      <button type="submit" class="btn redbtn" name="btnSubmitIter" id="btnSubmitIter">Save</button>
                                            		  <button name='reset' type="reset" value='Reset' class="btn blackbtn">Reset</button> 
                                                </div>
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
		<script src="<?php echo base_url(); ?>assets/admin/ckeditor/ckeditor.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.js" type="text/javascript"></script>
		<script type="text/javascript">
			CKEDITOR.replace('itinerary_note'); 
			$(document).ready(function(){
				<?php for ($i = 1; $i <= $no_ofdays ; $i++) { ?>
				$("#getplaceid_<?php echo $i; ?>").chosen();
				<?php }  ?>
			});
		</script>
   
    </body>
</html>

	
