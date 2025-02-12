<!DOCTYPE html>
<html lang="en">

    <head>
       <?php include("head.php"); ?>
       <link href="<?php echo base_url(); ?>assets/admin/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
             <?php include("header.php"); ?>

            <?php include("sidemenu.php"); ?>

            <div class="content-wrapper">
                <section class="content-header">
                    <div class="header-icon">
                        <i class="fa fa-picture-o"></i>
                    </div>
                    <div class="header-title">
                        <h1>Season Destination </h1>
                        <small>Season Destination </small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <?php echo $message; ?>
                        <div class="col-sm-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <!--<a href="<?php echo base_url(); ?>admin/users/add">
                                            <h4><i class="fa fa-plus-circle"></i> Add User</h4>
                                        </a> --> 
									</div>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr class="info">
                                                    <th>Sl#</th>
													<th>Destination</th>
													<th>Season Destination Image</th>
													<th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
											$cnt = 0;
											if( !empty($row) )
											{
												foreach ($row as $rows)
												{
													$cnt++;
													$parid = $rows['seadestinationid'];
													$destination_id = $rows['destination_id'];
													$par_value = $rows['par_value'];
													
													$destination_name= $this->Common_model->showname_fromid("destination_name","tbl_destination", "destination_id='$destination_id'");	
											?>
                                                <tr>
													<td><?php echo $cnt; ?></td>
													<td><?php echo $destination_name; ?></td>
													<td><?php echo '<a href="'.base_url().'uploads/'.$par_value.'" target="_blank"><img src="'.base_url().'uploads/'.$par_value.'" style="width:150px;height:auto" /></a>'; ?>        
													</td>
                                                    <td>
														<a href="<?php echo base_url().'admin/season-destination/edit/'.$parid; ?>" class="btn btn-success btn-sm  tbl-icon-btm" title="Edit"> <i class="fa fa-pencil"></i></a>  
													</td>
                                                </tr>
                                            <?php                                        
												}
											}
											else
											{
											?>
												<tr>
													<td class="text-center" colspan="8"> No data available in table </td>
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
                </section>
            </div>

            <?php include("footer.php"); ?>
			<script src="<?php echo base_url(); ?>assets/admin/js/jscolor.js" type="text/javascript"></script>
				<script type="text/javascript">
				$(document).ready(function () {
					$('#example1').DataTable();
				});
			</script>
    </body>
</html>

