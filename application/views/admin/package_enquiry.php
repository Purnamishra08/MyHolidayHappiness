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
                    <h1>Package Enquiry</h1>
                    <small>Manage Package Enquiry</small>
                </div>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-bd lobidrag">
                            <div class="panel-body">
                                <?php echo $message; ?>
                                <form class="search-sec" id="search_form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3"> <label for="package_id">Package Name</label></div>
                                                    <div class="col-md-9">
                                                        <select class="form-control" name="package_id" id="package_id">
                                                            <option value="0">--Select Package--</option>
                                                            <?php echo $this->Common_model->populate_select($dispid = 0, "tourpackageid", "tpackage_name", "tbl_tourpackages", "status='1'", "tpackage_name asc", ""); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3"> <label for="enquiry_name">Name</label></div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="Name" name="enquiry_name" id="enquiry_name" maxlength="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3"> <label for="email_id">Email Id</label></div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="Email Id" name="email_id" id="email_id" maxlength="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3"> <label for="contact_no">Contact No</label></div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="Contact No" name="contact_no" id="contact_no" maxlength="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group datepickerbox">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="from_date">From Enquiry Date</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control datepicker" id="from_date" name="from_date" placeholder="dd/mm/yyyy" style="background-color:#fff;" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group datepickerbox">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="to_date">To Enquiry Date</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control datepicker" id="to_date" name="to_date" placeholder="dd/mm/yyyy" style="background-color:#fff;" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group text-center">
                                                <a href="javascript:void(0)" class="btn redbtn" onclick="return searchValidator();"><i class="fa fa-search"></i> Search</a>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                                <div class="table-responsive">

                                    <table id="datatable" data-toggle="table" class="table table-bordered table-striped table-hover" data-url="<?php echo base_url(); ?>admin/package-enquiry/datatable" data-view-url="<?php echo base_url(); ?>admin/package-enquiry/view/ID" data-delete-url="<?php echo base_url(); ?>admin/package-enquiry/delete/ID">
                                        <thead>
                                            <tr class="table-heading">
                                                <th width="6%">SI #</th>
                                                <th width="18%">Package Name</th>
                                                <th width="16%">Traveller Name</th>
                                                <th width="16%">Email Id</th>
                                                <th width="12%">Phone No</th>
                                                <th width="12%">Travel Date </th>
                                                <th width="12%">Enquiry Date</th>
                                                <th width="8%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <div class="footer-background border-success text-center" id="norecord" style="display:none">No record found.</div>
                                </div>

                            </div>
                        </div>
                    </div>
            </section>
        </div>
        <?php include("footer.php"); ?>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.datepicker').datepicker({
                    format: 'dd/mm/yyyy',
                    todayHighlight: true,
                    autoclose: true,

                });

                searchValidator();
            });

            function searchValidator() {
                $('#datatable').css('display', 'none');

                if ($('#package_id').val() > 0) {
                    package_id = $('#package_id').val();
                } else {
                    package_id = '';
                }

                if ($('#enquiry_name').val() != '') {
                    enquiry_name = $('#enquiry_name').val();
                } else {
                    enquiry_name = '';
                }

                if ($('#email_id').val() != '') {
                    email_id = $('#email_id').val();
                } else {
                    email_id = '';
                }

                if ($('#contact_no').val() != '') {
                    contact_no = $('#contact_no').val();
                } else {
                    contact_no = '';
                }

                if ($('#from_date').val() != '') {
                    from_date = $('#from_date').val();
                } else {
                    from_date = '';
                }

                if ($('#to_date').val() != '') {
                    to_date = $('#to_date').val();
                } else {
                    to_date = '';
                }

                var table = $('#datatable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "autoWidth": true,
                    "responsive": true,
                    "searching": false,
                    "ordering": false,
                    "responsive": true,
                    "bDestroy": true,
                    "lengthChange": true,
                    "lengthMenu": [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    "ajax": {
                        "url": $('#datatable').data('url'),
                        "type": "POST",
                        "dataType": 'json',
                        "data": {
                            'package_id': package_id,
                            'enquiry_name': enquiry_name,
                            'email_id': email_id,
                            'contact_no': contact_no,
                            'from_date': from_date,
                            'to_date': to_date,
                            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                    },
                    "columns": [{
                            data: "sl_no"
                        },
                        {
                            data: "tpackage_name",
                            render: function(data, type, row) {
                                var str = "";
                                if (row.tpackage_name != "") {
                                    str = '<a href="' + row.tpackage_url + '" target="_blank">' + row.tpackage_name + '</a> ';
                                }
                                return str;
                            }
                        },
                        {
                            data: "full_name"
                        },
                        {
                            data: "emailid"
                        },
                        {
                            data: "phone"
                        },
                        {
                            data: "tour_date"
                        },
                        {
                            data: "inquiry_date"
                        },
                        {
                            data: "enq_id",
                            render: function(data, type, row) {
                                var str = '<a href="' + $('#datatable').data('view-url').replace("ID", row.enq_id) + '"  class="btn btn-primary btn-sm view" title="View"> <i class="fa fa-eye"></i></a>';

                                str += '<a onClick="return confirm(\'Are you sure to delete this package enquiry?\')" href="' + $('#datatable').data('delete-url').replace("ID", row.enq_id) + '"  class="btn btn-danger btn-sm " title="Delete"><i class="fa fa-trash-o"></i> </a>';

                                return str;
                            }
                        },
                    ],
                    "initComplete": function(settings, json) {
                        $("#datatable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                    },
                    drawCallback: function(settings) {
                        if (settings._iRecordsTotal < settings._iDisplayLength) {
                            $('#datatable_paginate').css('display', 'none');

                        } else {
                            $('#datatable_paginate').css('display', 'inline-table');

                        }
                        $('#datatable_length').addClass('noPrint');
                        $('#defaultRcord').css('display', 'none');
                        if (settings.aiDisplay.length <= 0) {
                            $('#datatable').css('display', 'none');
                            $('#norecord').css('display', 'inline-table');
                            $('#datatable_wrapper').css('display', 'none');
                        } else {
                            $('#datatable').css('display', 'inline-table');
                            $('#norecord').css('display', 'none');
                            $('#datatable_wrapper').css('display', 'inline-table');
                        }
                    },
                    "initComplete": function(settings, json) {
                        $("#datatable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                    },
                });

            }
        </script>
</body>

</html>