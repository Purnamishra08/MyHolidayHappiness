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
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="header-title">
                        <h1>General Settings</h1>
                        <small>Manage General Settings</small>
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
													<th>Parameter</th>
													<th width="60%">Parameter Value</th>
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
													$parid = $rows['parid'];
													$parameter = $rows['parameter'];
													$par_value = $rows['par_value'];
													$input_type = $rows['input_type'];
													
													
											?>
                                                <tr>
													<td><?php echo $cnt; ?></td>
													<td><?php echo $parameter; ?></td>
													<td>
														<?php 
															if($input_type!=3) {
																if($parid==4)
																	echo "Edit to view this code";
																else
																	echo $par_value; 
                                                            }
															else 
															{ 
																echo '<a href="'.base_url().'uploads/'.$par_value.'" target="_blank"><img src="'.base_url().'uploads/'.$par_value.'" style="width:150px;height:auto" /></a>';
															}  
														?>                                                    
													</td>
                                                    <td>
														<a href="<?php echo base_url().'admin/general_settings/edit/'.$parid; ?>" class="btn btn-success btn-sm  tbl-icon-btm" title="Edit"> <i class="fa fa-pencil"></i></a>  
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

