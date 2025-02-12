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
                        <i class="fa fa-question-circle"></i>
                    </div>
                    <div class="header-title">
                        <h1>Manage Status List</h1>
                        <small>Status List</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">

                        <div class="col-sm-4">
                            <div  style="margin-bottom: 25px;box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16);
                                  background-color:#fff; padding:25px;border-radius: 4px;">
                                <!-- <form name="colour" id="colour" method="post"> -->

                                    <?php echo form_open('', array( 'id' => 'form_statuslist', 'name' => 'form_statuslist'));?>
                                    <?php echo $message; ?>
                                    <div class="form-group">
                                        <label>Status Name</label>
                                        <input type="text"  class="form-control" placeholder="Enter Status Name" name="status_name" id="status_name" value="<?php echo set_value('status_name'); ?>">
                                    </div>

                                    <div class="reset-button">
                                        <button type="submit" class="btn redbtn" name="btnSubmit" id="btnSubmit">Save</button>
                                        <button type="reset" class="btn blackbtn">Reset</button>
                                    </div>


                                 <?php echo form_close(); ?>
                                <!-- </form> -->
                            </div></div>


                        <div class="col-sm-8">
                            <div style="margin-bottom: 25px;box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16);
                                 background-color:#fff; padding:25px;border-radius: 4px;">
                                <div class="panel">
                                    <div class="panel-body">
                                        <?php echo $m_message; ?>                           
                                        <div class="table-responsive">
                                            <table id="example1" class="table table-bordered table-striped table-hover">
                                                <thead>

                                                    <tr class="info">
                                                        <th width="11%" >Sl #</th>
                                                        <th width="27%">Status Name</th>
                                                        <th width="16%">Status</th>
                                                        <th width="26%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $cnt = isset($startfrom) ? $startfrom : 0;
                                                    if (!empty($row)) {
                                                        foreach ($row as $rows) {
                                                            $cnt++;
                                                            $status_id = $rows['id'];
                                                            $status_name = $rows['name'];
                                                            $status = $rows['status'];
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $cnt; ?></td>
                                                                <td><?php echo $status_name; ?></td>
                                                                <td>
                                                                    <?php if ($status == 1) { ?>
                                                                        <span class="status" data-id="<?php echo "status-" . $status_id; ?>"><a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a></span>
                                                                    <?php } else { ?>
                                                                        <span class="status" data-id="<?php echo "status-" . $status_id; ?>"><a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a></span>
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:void(0);" data-id="<?php echo $status_id; ?>" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm view" title="View"><i class="fa fa-pencil"></i></a>
                                                                    <a onClick="return confirm('Are you sure to delete this status name?')" href="<?php echo base_url() . 'admin/status-list/delete/' . $status_id; ?>" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash-o"></i> </a>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center" colspan="4"> No data available in table </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div></div></div><div class="clearfix"></div>
                    </div>      
                </section>
            </div>


            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">


                    </div>

                </div>
            </div>

    <?php include("footer.php"); ?>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/additional-methods.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>
            <script type="text/javascript">

                $(document).on('click', '.view', function () {
                    jQuery('#myModal .modal-content').html('<div style="text-align:center;margin-top:150px;margin-bottom:100px;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-3x"></i> <span>Processing...</span></div>');
                    var val = $(this).data("id");


                    $.ajax({
                        url: "<?php echo base_url(); ?>admin/status-list/edit_pop/" + val,
                        type: 'post',
                        data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
                        cache: false,
                        //processData: false,
                        success: function (modal_content) {
                            jQuery('#myModal .modal-content').html(modal_content);
                            // LOADING THE AJAX MODAL
                            $('#myModal').modal('show');
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                            $('#errMessage').html('<div class="errormsg"><i class="fa fa-times"></i> Your query could not executed. Please try again.</div>');
                        }
                    });
                });



                $(document).on('click', '.status', function () {
                    if (confirm('Are you sure to change the status?'))
                    {
                        var val = $(this).data("id");
                        var valsplit = val.split("-");
                        var id = valsplit[1];
                        jQuery('[data-id=' + val + ']').after('<div class="spinner" style="text-align:center;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-1x"></i></div>');
                        $.ajax({
                            url: "<?php echo base_url(); ?>admin/status-list/changestatus/" + id,
                            type: 'post',
                            data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
                            cache: false,
                            //processData: false,
                            success: function (data) {
                                jQuery('.spinner').remove();
                                if (data == 1) //Inactive
                                {
                                    jQuery('[data-id=' + val + ']').html('<a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a>');
                                } else if (data == 0) //Active
                                {
                                    jQuery('[data-id=' + val + ']').html('<a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a>');
                                } else
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
        $('#example1').DataTable();
    });
</script>
  </body>
</html>

