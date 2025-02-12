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
                        <i class="fa fa-commenting-o"></i>
                    </div>
                    <div class="header-title">
                        <h1>Comments</h1>
                        <small>Manage Comments</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                       
                        <div class="col-sm-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/comments">
                                            <h4><i class="fa fa-plus-circle"></i> Comments</h4>
                                        </a> 
                  </div>
                                </div>
                                <div class="panel-body">
                                   <?php echo $message; ?>
                                 <div class="table-responsive">
                              <table id="example" class="table table-bordered table-striped table-hover">
                                 <thead>
                                    <tr class="info">
                                        <th width="5%">Sl #</th>
                                        <th width="25%">Post Title</th>
                                        <th width="8%">Name</th>
                                        <th width="10%">Email</th>
                                        <th width="20%">Comments</th>
                                        <th width="10%">Created Date</th>
                                        <th width="8%">Status</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                                      $cnt = isset($startfrom) ? $startfrom : 0;
                                    if( !empty($row) )
                                    {
                                        foreach ($row as $rows)
                                        {
                                            $cnt++;
                                            $disid = $rows['blogid'];
                                            $commentid = $rows['commentid'];
                                            $user_name = $rows['user_name'];
                                            $email_id = $rows['email_id'];
                                            $comments = $rows['comments'];
                                            $created_date = $rows['created_date'];
                                            $status = $rows['status'];
                                    ?>
                                    <tr>
                                        <td><?php echo $cnt; ?></td>
                                        <td><a href="<?php echo base_url() . 'admin/blog/edit/' . $disid; ?>" target="_blank"><?php echo $this->Common_model->showname_fromid("title","tbl_blog","blogid='$disid'"); ?></a></td>
                                        <td><?php echo $user_name; ?></td>
                                        <td><?php echo $email_id; ?></td>
                                        <td><?php echo $this->Common_model->short_str($comments, 140); ?></td>
                                       <td><?php echo date('dS F Y', strtotime($created_date)); ?></td>

                                        <td>
                                            
                                        <?php if($status==1) { ?>
										<span class="status" data-id="<?php echo "status-".$commentid; ?>"><a href="javascript:void(0)" title="Status is Approve. Click here to make it Reject."><span class="label-custom label label-success">Active</span></a></span>
									  <?php } else { ?>
										<span class="status" data-id="<?php echo "status-".$commentid; ?>"><a href="javascript:void(0)" title="Status is Reject. Click here to make it Approve."><span class="label-custom label label-danger">Inactive</span></a></span>
                                            <?php } ?>

                                        </td>
                                        <td>
                                            <a href="<?php echo base_url().'admin/comments/edit/'.$commentid; ?>" class="btn btn-success btn-sm edit" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <a onClick="return confirm('Are you sure to delete this comment?')" href="<?php echo base_url().'admin/comments/delete/'.$commentid; ?>" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash-o"></i> </a>
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
        

        <script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    });
    </script>
   <script type="text/javascript">
$(document).on('click', '.status', function(){
  if(confirm('Are you sure to change the status?'))
  {
    var val = $(this).data("id");
    var valsplit = val.split("-");
    var id = valsplit[1];
    jQuery('[data-id='+val+']').after('<div class="spinner" style="text-align:center;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
    $.ajax({
      url: "<?php echo base_url(); ?>admin/comments/changestatus/"+id,
      type: 'post',
      data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
      cache: false,
     // processData: false,
      success: function (data) {
        jQuery('.spinner').remove();
        if(data == 1) //Inactive
        {
          jQuery('[data-id='+val+']').html('<a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a>');
        }
        else if(data == 0) //Active
        {
          jQuery('[data-id='+val+']').html('<a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a>');
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
    
    </body>
</html>


