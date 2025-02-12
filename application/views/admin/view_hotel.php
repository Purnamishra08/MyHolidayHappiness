<?php
foreach ($dstype as $rows)
{
    $hotelid       = $rows['hotel_id'];
    $hotelname     = $rows['hotel_name'];
    $destname      = $rows['destination_name'];
    $hoteltype     = $rows['hotel_type'];
    $defaultprice  = $rows['default_price']; 
	$room_type      = $rows['room_type'];
    $trip_advisor_url     = $rows['trip_advisor_url'];
    $star_rating  	= $rows['star_rating']; 
   
    $destinationname=$this->Common_model->showname_fromid("destination_name","tbl_destination","destination_id='$destname'");
    $hoteltype=$this->Common_model->showname_fromid("hotel_type_name","tbl_hotel_type","hotel_type_id='$hoteltype'");
}
?>

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
                        <i class="fa fa-hotel"></i>
                    </div>
                    <div class="header-title">
                        <h1>Hotel</h1>
                        <small>View Hotel </small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/hotel">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Hotel</h4>
                                        </a> 
									</div>
								
                                </div>
                                <div class="panel-body">
                                    <div class="row">
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Hotel Name</label></div>
												<div class="col-md-8"> <?php echo $hotelname;?></div>
											</div>
										</div>
									
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Destination Name </label></div>
												<div class="col-md-8"> <?php echo $destinationname;?></div>
											</div>
										</div>
                                    
										<div class="clearfix"></div>
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Hotel Type</label></div>
												<div class="col-md-8"><?php echo $hoteltype; ?></div>
											</div>
										</div>
									
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Room Type </label></div>
												<div class="col-md-8"><?php echo $room_type ; ?></div>
											</div>
										</div> 
										<div class="clearfix"></div>
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Trip Advisor URL</label></div>
												<div class="col-md-8"><?php echo $trip_advisor_url; ?></div>
											</div>
										</div>
									
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Default Price </label></div>
												<div class="col-md-8"><?php echo $defaultprice ; ?></div>
											</div>
										</div> 
										<div class="clearfix"></div>
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Star Ratings (Out of 5)</label></div>
												<div class="col-md-8"><?php echo $star_rating; ?></div>
											</div>
										</div>
									
                                    <br><br>
									<div class="col-md-12 table-responsive">
                                        <table id="example" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr class="info">                                                  
                                                    <th width="13%">Season Type</th>
                                                    <th width="10%">Season start month</th> 
                                                    <th width="10%">Season start date</th> 
                                                    <th width="10%">Season end month</th> 
                                                    <th width="10%">Season end date</th> 
                                                    <th width="9%">Adult Price (<?php echo $this->Common_model->currency; ?>)</th> 
                                                    <th width="9%">Couple Price (<?php echo $this->Common_model->currency; ?>)</th> 
                                                    <th width="9%">Kid Price (<?php echo $this->Common_model->currency; ?>)</th> 
                                                    <th width="9%">Adult Extra Price (<?php echo $this->Common_model->currency; ?>)</th> 
                                                </tr>
                                            </thead>
                                           
                                                  <tbody>

                                                <?php
                                                $cnt = isset($startfrom) ? $startfrom : 0;
                                                $stype = $this->Common_model->get_records("*","tbl_season","hotel_id=$hotelid","");                                              


                                                if (!empty($stype)) { 
                                                    foreach ($stype as $stypes) {
                                                     $cnt++;
                                                     
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
								</div>						
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        <?php include("footer.php"); ?>
    </body>
</html>

