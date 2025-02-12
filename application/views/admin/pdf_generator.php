<!DOCTYPE html>
<html lang="en">
  <head>
      <?php include("head.php"); ?>
      <link href="<?php echo base_url(); ?>assets/admin/css/chosen.css" rel="stylesheet" type="text/css"/>
      <link href="<?php echo base_url(); ?>assets/css/fontawesome-all.css" rel="stylesheet" type="text/css"/>
      <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <style>
          .ui-datepicker-trigger{
              display:none;
          }
      </style>
  </head>
  <body class="hold-transition sidebar-mini">
      <div class="wrapper">
         <?php include("header.php"); ?>

         <?php include("sidemenu.php"); ?>
          <div class="content-wrapper">
              <section class="content-header">
                  <div class="header-icon">
                      <i class="fa fa-superpowers"></i>
                  </div>
                  <div class="header-title">
                      <h1>Package PDF</h1>
                      <small>Genrate Sample Package PDF</small>
                  </div>
              </section>
              <!-- Main content -->
			  <img src="<?php echo base_url();?>assets/images/My_Holiday_Logo-min.png" style="display:none" id="main_site_logo" ?>
				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-bd lobidrag">
								<div class="panel-heading">
								</div>
								<div class="panel-body">
                                    
									<div class="box-main">
										<h3>Package Details</h3>
										 <form id="form_calculate">
                                            <div class="row">

											
                                       
											<div class="col-md-6"> 
												<div class="form-group">
													<label> Select Package </label>
													
													<select data-placeholder="Choose tour Place Type" class="chosen-select"  tabindex="4" id="package_id"  name="hid_packageid" onchange="getPackageDetails()"
													style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
														    	<option value=''>-- Select Package --</option>
														<?php foreach ($row as $data) { ?>
														<option value="<?= $data['tourpackageid'] ?>"><?= $data['tpackage_name'] ?></option>
														<?php } ?>
													</select> 
												</div>
											</div>
											 <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>(Adults: 12+ Yrs)</label>
                                                    <div class="input-group">
                                                        <input type="button" value="-" class="button-minus" data-field="quantity_adult">
                                                        <input type="text" step="1" max="20" value="0" name="quantity_adult" id="quantity_adult" class="quantity-field" readonly style="width: 50px;">
                                                        <input type="button" value="+" class="button-plus" data-field="quantity_adult">
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="col-md-3">
                                                <div class="form-group ">
                                                    <label>(Children: 6-12 Yrs)</label>
                                                    <div class="input-group">
                                                        <input type="button" value="-" class="button-minus" data-field="quantity_child">
                                                        <input type="text" step="1" max="20" value="0" name="quantity_child" id="quantity_child" class="quantity-field" readonly style="width: 50px;">
                                                        <input type="button" value="+" class="button-plus" data-field="quantity_child">
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="vehicle">Vehicle</label>
                                                    <select class="form-control" id="vehicle" name="vehicle">
                                                        <option value="">-Select Vehicle-</option>
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                             <div class="col-md-6">
                                                <div class="form-group datepickerbox">
                                                    <label for="date">Date of travel</label>
                                                    <input type="text" class="form-control datepicker" id="travel_date" name="travel_date" placeholder="dd/mm/yyyy" format="dd/mm/yyyy"  >
                                                </div>
                                            </div>
											    <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="date">Accommodation Type</label>
                                                        <select class="form-control" id="accommodation_type" name="accommodation_type">		
                                                            <option value=""> - - Select Accommodation - - </option>
                                                            
                                                        </select>
                                                        <span for="accomodation" class="chk-hotl" data-toggle="modal" data-target="#Hotel-check" style="float:right;cursor:pointer">Check Hotels</span>
                                                    </div>
                                                </div>    
											<div class="clearfix"></div> 
											    <div class="col-md-12" id="error_message"></div>	
										</div>
                                        </form>
										
									</div>

																	
                                   
      
									<div class="clearfix"></div>
									<div class="col-md-6">
        										<div class="reset-button"> 
        											<button type="button" class="btn redbtn" name="btnSubmit" id="btnSubmit" onclick="generate()">Generate PDF</button>
        										</div>
        									</div>   
        								<div class="col-md-6">
        										<div class="reset-button"> 
        											<button type="button" class="btn redbtn" name="btnSubmit" id="btnSubmit2" onclick="generateDoc()">Generate DOC</button>
        										</div>
        									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				<div id="result" style='display:none'></div>
				<div id="iternary" style='display:none'></div>
				 <div class="modal fade" id="Hotel-check">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Hotels</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="hotel-chk-sec">
                                                <div class="row" id="accomodation_result">
                                                    <div class="col-xl-12 col-lg-12">
                                                        <h4 style="color:#6583bb; padding-bottom:20px;">Select accommodation first to check hotels.</h4>
                                                    </div>
                                                </div>
												<div class="row">
													<div class="col-xl-12 col-lg-12 text-center">
                                                        <input type="button" class="btn btn-primary" value="OK" data-dismiss="modal">
                                                    </div>
												</div>
                                            </div>
                                        </div>

                                        <!-- Modal footer -->

                                    </div>
                                </div>
                            </div>
			</div>
		<?php include("footer.php"); ?>
		
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.js" type="text/javascript"></script>
       <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	

		<script>
			$(document).ready(function(){
				$('#package_id').chosen();
				 $(function () {
                $(".datepicker").datepicker({
                    minDate: +2,
                    showOtherMonths: true,
                    dateFormat: 'dd/mm/yy',
                    showOn: "both",
                    buttonImage: "<?php echo base_url(); ?>assets/images/modal-small-calendar.jpg",
                    buttonImageOnly: true,
                    buttonText: "Select date",
                    changeMonth: true,
                    changeYear: true
                });
            });
			});
		</script>

		<script>
		function getPackageDetails(){
		     $.ajax({
                    url: "<?php echo base_url(); ?>packages/get-package-max-capacity?package_id=" +$('#package_id').val(),
                    type: 'post',
                    data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                    success: function (result) {
                          $("quantity_adult").attr("max",result);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                    }
                });
             $.ajax({
                    url: "<?php echo base_url(); ?>packages/get-package-iternaries?package_id=" +$('#package_id').val(),
                    type: 'post',
                    data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                    success: function (result) {
                          $("#iternary").html(result);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                    }
                });
             $.ajax({
                    url: "<?php echo base_url(); ?>packages/get-package-accommodations?package_id=" +$('#package_id').val(),
                    type: 'post',
                    data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                    success: function (result) {
                          $("#accommodation_type").html(result);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                    }
                });
            checkcapacity();
		}
		function generateDoc(){
		   // var dateTypeVar = $('#travel_date').datepicker('getDate');
		   // console.log(dateTypeVar);
		    let error=0;
		             if ( $("#package_id").val() == "")
                    {
                        $("#package_id").addClass("errorfield");
                        error += 1;
                    } else
                    {
                        $("#package_id").removeClass("errorfield");
                    }
		            if (!$("#quantity_adult").val())
                    {
                        $("#quantity_adult").addClass("errorfield");
                        error += 1;
                    } else
                    {
                        $("#quantity_adult").removeClass("errorfield");
                    }

                    if (!$("#vehicle").val())
                    {
                        $("#vehicle").addClass("errorfield");
                        error += 1;
                    } else
                    {
                        $("#vehicle").removeClass("errorfield");
                    }

                    if (! $("#travel_date").val() )
                    {
                        $("#travel_date").addClass("errorfield");
                        error += 1;
                    } else
                    {
                        $("#travel_date").removeClass("errorfield");
                    }

                    if ( !$("#accommodation_type").val() )
                    {
                        $("#accommodation_type").addClass("errorfield");
                        error += 1;
                    } else
                    {
                        $("#accommodation_type").removeClass("errorfield");
                    }
                   

                    if (error == 0)
                    {
                        $("#error_message").html('');
                       
                         var formData = new FormData();
                         
                        for(let i=0; i< document.querySelectorAll('.form-check-input').length; i++){
                            /*for(let j=0; j< document.getElementsByName(document.querySelectorAll('.form-check-input')[i].name).length; j++){*/
                             if(document.querySelectorAll('.form-check-input')[i].checked){
                                 formData.append(document.querySelectorAll('.form-check-input')[i].name , document.querySelectorAll('.form-check-input')[i].value );
                             }
                            /*}  */  
                       
                        }
                        console.log('coming');
                         formData.append('accommodation_type', $("#accommodation_type").val());
                          formData.append('travel_date', $("#travel_date").val());
                           formData.append('vehicle', $("#vehicle").val());
                            formData.append('quantity_adult', $("#quantity_adult").val());
                             formData.append('hid_packageid', $("#package_id").val());
                             
                             formData.append('quantity_child', $("#quantity_child").val());
                             
                             formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
                              console.log('coming');
                         /*let formData ={
                                'accommodation_type':$("#accommodation_type").val(),
                                'travel_date':$("#travel_date").val(),
                                'vehicle':$("#vehicle").val(),
                                'quantity_adult':$("#quantity_adult").val(),
                                'hid_packageid':$("#package_id").val(),
                                 'quantity_child':$("#quantity_child").val(),
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                            
                        };*/
                               /* for (const value of formData.values()) {
                                      console.log(value);
                                    }
                                    for (const value of formData.keys()) {
                                      console.log(value);
                                    }*/
                        $.ajax({
                            url: "<?php echo base_url(); ?>packages/get-docs?pag2=1",
                            type: 'post',
                            data: formData,
                            processData: false,
                            contentType: false,
                            beforeSend: function () {
                            },
                            success: function (result) {
                                $('#result').html(result);
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                            }
                        });
                    } else
                    {
                        $("#error_message").html('<div class="errormsg" style="font-size:15px;">Please fill up all above mandatory fields.</div>');
                        return false;
                    }
		}
		function generate(){
		    let error=0;
		    
		             if ( $("#package_id").val() == "")
                    {
                        $("#package_id").addClass("errorfield");
                        error += 1;
                    } else
                    {
                        $("#package_id").removeClass("errorfield");
                    }
		            if (!$("#quantity_adult").val())
                    {
                        $("#quantity_adult").addClass("errorfield");
                        error += 1;
                    } else
                    {
                        $("#quantity_adult").removeClass("errorfield");
                    }

                    if (!$("#vehicle").val())
                    {
                        $("#vehicle").addClass("errorfield");
                        error += 1;
                    } else
                    {
                        $("#vehicle").removeClass("errorfield");
                    }

                    if (! $("#travel_date").val() )
                    {
                        $("#travel_date").addClass("errorfield");
                        error += 1;
                    } else
                    {
                        $("#travel_date").removeClass("errorfield");
                    }

                    if ( !$("#accommodation_type").val() )
                    {
                        $("#accommodation_type").addClass("errorfield");
                        error += 1;
                    } else
                    {
                        $("#accommodation_type").removeClass("errorfield");
                    }
                   

                    if (error == 0)
                    {
                        $("#error_message").html('');
                       
                         var formData = new FormData();
                         
                        for(let i=0; i< document.querySelectorAll('.form-check-input').length; i++){
                            /*for(let j=0; j< document.getElementsByName(document.querySelectorAll('.form-check-input')[i].name).length; j++){*/
                             if(document.querySelectorAll('.form-check-input')[i].checked){
                                 formData.append(document.querySelectorAll('.form-check-input')[i].name , document.querySelectorAll('.form-check-input')[i].value );
                             }
                            /*}  */  
                       
                        }
                        console.log('coming');
                         formData.append('accommodation_type', $("#accommodation_type").val());
                          formData.append('travel_date', $("#travel_date").val());
                           formData.append('vehicle', $("#vehicle").val());
                            formData.append('quantity_adult', $("#quantity_adult").val());
                             formData.append('hid_packageid', $("#package_id").val());
                             
                             formData.append('quantity_child', $("#quantity_child").val());
                             
                             formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
                              console.log('coming');
                         /*let formData ={
                                'accommodation_type':$("#accommodation_type").val(),
                                'travel_date':$("#travel_date").val(),
                                'vehicle':$("#vehicle").val(),
                                'quantity_adult':$("#quantity_adult").val(),
                                'hid_packageid':$("#package_id").val(),
                                 'quantity_child':$("#quantity_child").val(),
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                            
                        };*/
                               /* for (const value of formData.values()) {
                                      console.log(value);
                                    }
                                    for (const value of formData.keys()) {
                                      console.log(value);
                                    }*/
                        $.ajax({
                            url: "<?php echo base_url(); ?>packages/get-pdfs?pag2=1",
                            type: 'post',
                            data: formData,
                            processData: false,
                            contentType: false,
                            beforeSend: function () {
                            },
                            success: function (result) {
                                $('#result').html(result);
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                            }
                        });
                    } else
                    {
                        $("#error_message").html('<div class="errormsg" style="font-size:15px;">Please fill up all above mandatory fields.</div>');
                        return false;
                    }
		}
		 $(document).on('change', '#accommodation_type', function () {
                var accommodation_type = $(this).val();
                if (accommodation_type != "")
                {
                    $("#Hotel-check").modal('show');
                    //alert(accommodation_type);
                    
                    $.ajax({
                        url: "<?php echo base_url(); ?>packages/getaccomodation?accommodation_type=" + accommodation_type + "&packageid=" +$("#package_id").val(),
                        type: 'post',
                        data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                        beforeSend: function () {
                            $("#accomodation_result").html('<div style="text-align:center; padding:50px;"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading Hotels</div>');
                        },
                        success: function (result) {
                            console.log('coming');
                            $('#accomodation_result').html(result);
                            $('#accommodation').val(accommodation_type);
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                        }
                    });
                } else
                {
                    $("#accomodation_result").html('<h4 style="color:#6583bb; padding-bottom:20px;">Select accommodation first to check hotels.</h4>');
                }
            })
            //plus/minus input//
            function incrementValue(e) {
                e.preventDefault();
                var fieldName = $(e.target).data('field');
                var parent = $(e.target).closest('div');
                var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

                if (!isNaN(currentVal)) {
                    parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
                } else {
                    parent.find('input[name=' + fieldName + ']').val(0);
                }
            }

            function decrementValue(e) {
                e.preventDefault();
                var fieldName = $(e.target).data('field');
                var parent = $(e.target).closest('div');
                var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

                if (!isNaN(currentVal) && currentVal > 0) {
                    parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
                } else {
                    parent.find('input[name=' + fieldName + ']').val(0);
                }
            }

            $('.input-group').on('click', '.button-plus', function (e) {
                incrementValue(e);
                checkcapacity();
            });

            $('.input-group').on('click', '.button-minus', function (e) {
                decrementValue(e);
                checkcapacity();
            });

            function checkcapacity()
            {
                var maxcapacity = 20;
                var adultcount = $("#quantity_adult").val();
                var childcount = $("#quantity_child").val();
                var totalcount = parseInt(adultcount) + parseInt(childcount);
                if (totalcount > maxcapacity)
                {
                    $("#calculate_price").prop("disabled", true);
                    alert("Maximum 20 no of travellers can be booked for this package. Please make a inquiry below for more traveller.");
                    $("#Enquiry-now").modal('show');
                    $("#noof_adult").val(adultcount);
                    $("#noof_child").val(childcount);
                } else
                {
                    $("#calculate_price").prop("disabled", false);
                    $("#noof_adult").val(adultcount);
                    $("#noof_child").val(childcount);
                }

                $.ajax({
                    url: "<?php echo base_url(); ?>packages/getvehicles?totalcount=" + totalcount + "&package_id=" +$('#package_id').val(),
                    type: 'post',
                    data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                    success: function (result) {
                        //alert(result);
                        $('#vehicle').html(result);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                    }
                });

            }
        </script>
  </body>
</html>

