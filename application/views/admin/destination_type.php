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
                        <i class="fa fa-map-marker"></i>
                    </div>
                    <div class="header-title">
                        <h1>Destination Type</h1>
                        <small>Destination Type</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">

                        <div class="col-sm-4">
                            <div  style="margin-bottom: 25px;box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16);
                                  background-color:#fff; padding:25px;border-radius: 4px;">
                                <!-- <form name="colour" id="colour" method="post"> -->

                                    <?php echo form_open('', array( 'id' => 'form_destination_type', 'name' => 'form_destination_type'));?>
                                    <?php echo $message; ?>
                                    <div class="form-group">
                                        <label>Destination Type</label>
                                        <input type="text"  class="form-control" placeholder="Enter Destination type" name="destination_type_name" id="destination_type_name" value="<?php echo set_value('destination_type_name'); ?>">
                                    </div>

                                    <div class="reset-button">                                   
                                        <!--  <a href="#" class="btn redbtn">Save</a> 
                                         <a href="#" class="btn blackbtn">Reset</a>  -->
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
                                                        <th width="27%">Destination Type</th>
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
                                                            $destination_type_id = $rows['destination_type_id'];
                                                            $destination_type_name = $rows['destination_type_name'];
                                                            $status = $rows['status'];
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $cnt; ?></td>
                                                                <td><?php echo $destination_type_name; ?></td>
                                                        
                                                                <td><!-- <span class="label-custom label label-default">Active</span> -->
                                                                    <?php if ($status == 1) { ?>
                                                                        <span class="status" data-id="<?php echo "status-" . $destination_type_id; ?>"><a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a></span>
                                                                    <?php } else { ?>
                                                                        <span class="status" data-id="<?php echo "status-" . $destination_type_id; ?>"><a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a></span>

                                                                    <?php } ?>


                                                                </td>
                                                                <td>
                                                                    <!-- <button type="button" class="btn btn-add btn-sm">
                                                                        <i class="fa fa-pencil"></i></button> -->
                                                                    <a href="javascript:void(0);" data-id="<?php echo $destination_type_id; ?>" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm view" title="View"><i class="fa fa-pencil"></i></a>
                                                                    <!-- <button type="button" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash-o"></i> </button> -->
                                                                    <a onClick="return confirm('Are you sure to delete this Destination type?')" href="<?php echo base_url() . 'admin/destination_type/delete/' . $destination_type_id; ?>" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash-o"></i> </a>
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
                        url: "<?php echo base_url(); ?>admin/destination_type/edit_pop/" + val,
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
                            url: "<?php echo base_url(); ?>admin/destination_type/changestatus/" + id,
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

