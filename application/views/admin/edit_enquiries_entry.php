<?php
foreach ($row as $rows) {
    $customer_name    = $rows['customer_name'];
    $email_address     = $rows['email_address'];
    $phone_number      = $rows['phone_number'];
    $source_id  = $rows['source_id'];
    $status_id = $rows['status_id'];
    $trip_name    = $rows['trip_name'];
    $trip_start_date     = date('m/d/Y', strtotime($rows['trip_start_date']));
    $follow_up_date     = date('m/d/Y', strtotime($rows['followup_date']));
    $no_of_travellers     = $rows['travellers_count'];
    $comment     = $rows['comments'];
    $inquiry_number     = $rows['inquiry_number'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php"); ?>
    <link href="<?php echo base_url(); ?>assets/admin/css/chosen.css" rel="stylesheet" type="text/css" />
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
                    <h1>Enquiries</h1>
                    <small>Edit Enquiries</small>
                </div>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bd lobidrag">
                            <div class="panel-heading">
                                <div class="btn-group" id="buttonexport">
                                    <a href="<?php echo base_url(); ?>admin/enquiries-entry">
                                        <h4><i class="fa fa-plus-circle"></i> Manage Enquiries</h4>
                                    </a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php echo $message; ?>

                                <?php echo form_open('', array('id' => 'form_edit_enquiry_entry', 'name' => 'form_edit_enquiry_entry', 'class' => 'add-user', 'enctype' => 'multipart/form-data')); ?>

                                <div class="box-main">
                                    <h3>Enquiries Details</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Customer Name</label>
                                                <input type="text" class="form-control" placeholder="Enter Customer Name" name="customer_name" id="customer_name" value="<?php echo set_value('customer_name', $customer_name); ?>">
                                                <input type="hidden" class="form-control"  name="inquiry_number" id="inquiry_number" value="<?php echo set_value('inquiry_number', $inquiry_number); ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email Address</label>
                                                <input type="text" class="form-control" placeholder="Enter Email Address" name="email_address" id="email_address" value="<?php echo set_value('email_address', $email_address); ?>">
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input type="text" class="form-control" placeholder="Enter Phone Number" name="phone_number" id="phone_number" value="<?php echo set_value('phone_number', $phone_number); ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Source</label>
                                                <select class="form-control" id="source_id" name="source_id">
                                                    <option value="">-- Select Source --</option>
                                                    <?php echo $this->Common_model->populate_select($dispid = $source_id, "id", "name", "tbl_sources", "", "name asc", ""); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control" id="status_id" name="status_id">
                                                    <option value="">-- Select Status --</option>
                                                    <?php echo $this->Common_model->populate_select($dispid = $status_id, "id", "name", " tbl_statuses", "", "name asc", ""); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Trip Name</label>
                                                <input type="text" class="form-control" placeholder="Enter Trip Name" name="trip_name" id="trip_name" value="<?php echo set_value('trip_name', $trip_name); ?>">
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group datepickerbox">
                                                <label for="date">Trip Start Date</label>
                                                <input type="text" class="form-control datepicker" id="trip_start_date" name="trip_start_date" value="<?php echo set_value('trip_start_date', $trip_start_date); ?>" placeholder="dd/mm/yyyy" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group datepickerbox">
                                                <label for="date">Follow Up Date</label>
                                                <input type="text" class="form-control datepicker" id="follow_up_date" name="follow_up_date" value="<?php echo set_value('follow_up_date', $follow_up_date); ?>" placeholder="dd/mm/yyyy" readonly>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No. of Travellers</label>
                                                <input type="number" class="form-control" placeholder="Enter No. of Travellers" name="no_of_travellers" id="no_of_travellers" value="<?php echo set_value('no_of_travellers', $no_of_travellers); ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Comment</label>
                                                <textarea class="form-control" rows="2" placeholder="Comment" name="comment" id="comment"><?php echo $comment ?></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="col-md-6">
                                    <div class="reset-button">
                                        <button type="submit" class="btn redbtn" name="btnSubmit" id="btnSubmit">Update</button>
                                        <button type="button" class="btn blackbtn" onClick="window.location='<?php echo base_url(); ?>admin/enquiries-entry'">Back</button> 
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
        <script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript">
        </script>
        <script src="<?php echo base_url(); ?>assets/admin/js_validation/additional-methods.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/ckeditor/ckeditor.js" type="text/javascript"></script>
        <script>
            $(function() {
                $(".datepicker").datepicker({
                    minDate: +2,
                    showOtherMonths: true,
                    autoclose: true,
                    showOn: "both",
                    buttonImage: "<?php echo base_url(); ?>assets/images/modal-small-calendar.jpg",
                    buttonImageOnly: true,
                    buttonText: "Select date",
                    changeMonth: true,
                    changeYear: true
                });
            });
        </script>

</body>

</html>