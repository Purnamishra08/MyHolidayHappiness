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
                        <i class="fa fa-cc"></i>
                    </div>
                    <div class="header-title">
                        <h1>Blogs</h1>
                        <small>Manage Blog</small>
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
                                        <a href="<?php echo base_url(); ?>admin/blog/add">
                                            <h4><i class="fa fa-plus-circle"></i> Add Blog</h4>
                                        </a> 
									</div>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr class="info">
                                                    <th width="5%">Sl #</th>
                                                    <th width="25%">Post Title</th>
                                                    <th width="5%">Featured Image</th>
                                                    <th width="30%">Content</th>
                                                    <th width="15%">Created Date</th>
                                                    <th width="2%">Show Comments</th>
                                                    <th width="10%">Status</th>
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>                                               
											<?php
                                                $cnt = isset($startfrom) ? $startfrom : 0;
                                                if (!empty($row)) {
                                                    foreach ($row as $rows) {
                                                        $cnt++;
                                                        $disid = $rows['blogid'];
                                                        $title = $rows['title'];
                                                        $dis_image = $rows['image'];
                                                        $contents = $rows['content'];
                                                        $status = $rows['status'];
                                                        $show_comment = $rows['show_comment'];
                                                        
                                                        $date = $rows['created_date'];
                                                        $sess_userid = $rows['created_by'];
                                                        ?>									
                                                <tr>
                                                    <td><?php echo $cnt; ?></td>
                                                    <td><?php echo $title; ?></td>
                                                    <td>
													<?php
													if (file_exists("./uploads/" . $dis_image) && ($dis_image != '')) {
														echo '<a href="' . base_url() . 'uploads/' . $dis_image . '" target="_blank"><img src="' . base_url() . 'uploads/' . $dis_image . '" style="width:150px;height:70px" alt="image" /></a>';
													}
													?>
                                                    </td>
                                                    <td><?php echo $this->Common_model->short_str($contents, 140); ?></td>
                                                    <td><?php echo date('dS F Y', strtotime($date)); ?></td>
                                                    <td><?php if($show_comment == 1) echo 'Yes'; else echo 'No'; ?></td>
                                                    <td>
                                                         <?php if($status==1) { ?>
															<span class="status" data-id="<?php echo "status-".$disid; ?>"><a href="javascript:void(0)" title="Status is Approve. Click here to make it Reject."><span class="label-custom label label-success">Active</span></a></span>
														  <?php } else { ?>
															<span class="status" data-id="<?php echo "status-".$disid; ?>"><a href="javascript:void(0)" title="Status is Reject. Click here to make it Approve."><span class="label-custom label label-danger">Inactive</span></a></span>
														  <?php } ?>
                                                     </td>
                                                     <td>
															<a href="<?php echo base_url() . 'admin/blog/edit/' . $disid; ?>" class="btn btn-success btn-sm edit" title="Edit"><i class="fa fa-pencil"></i></a>
															<a onClick="return confirm('Are you sure to delete this Post?')" href="<?php echo base_url() . 'admin/blog/delete/' . $disid; ?>" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash-o"></i> </a>
                                                     </td>
                                                     </tr>
                                                <?php
                                        
													}
												}
												else
												{
												?>
												<tr>
													<td class="text-center" colspan="5"> No data available in table </td>
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

            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content"> </div>
                </div>
            </div>

        <?php include("footer.php"); ?>
        

		<script type="text/javascript">
			
		   $(document).on('click', '.status', function(){
				if(confirm('Are you sure to change the status?'))
				{
					var val = $(this).data("id");
					var valsplit = val.split("-");
					var id = valsplit[1];
					$('[data-id='+val+']').after('<div class="spinner" style="text-align:center;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-1x"></i></div>');
					$.ajax({
						url: "<?php echo base_url(); ?>admin/blog/changestatus/"+id,
						type: 'post',
						data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
						cache: false,
						success: function (data) {
							$('.spinner').remove();                        
							if(data == '1') //Inactive
							{                                
								$('[data-id='+val+']').html('<a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a>');
							}
							else if(data == '0') //Active
							{
								$('[data-id='+val+']').html('<a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a>');
							}
							else
							{
								alert("Sorry! Unable to change status.");
							}
						},
						error: function (XMLHttpRequest, textStatus, errorThrown) {
							alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
						}
					});
}
		   });

		</script>
		
		<script type="text/javascript">
			$(document).ready(function () {
				$('#example').DataTable();
			});
		</script>
		
    </body>
</html>

