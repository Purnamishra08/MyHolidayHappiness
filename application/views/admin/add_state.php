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
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="header-title">
                        <h1>State</h1>
                        <small>Add State</small>
                    </div>                    
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/country">
                                            <h4><i class="fa fa-plus-circle"></i> Manage country</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <?php echo $message; ?>
									<?php echo form_open('', array( 'id' => 'form_state', 'name' => 'form_state', 'class' => 'add-user'));?>
                                        <div class="row">
                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label> State </label>
                                                    <!-- <input type="text" class="form-control fld" placeholder="Enter State" name="state_name" id="state_name" value="<?php //echo set_value('state_name'); ?>"> -->

                                                        <div class="option-name" id="optnshwhd">
                                                            <table class="table border-none" id="addRowTable">
                                                                <tr>
                                                                    <td>
                                                                        <?php $checked = 'checked="checked"'; ?>
                                                                        <input type="checkbox" class="custom-control-input chk" id="checkstate" name="checkstate[]" >

                                                                        <input type="text" class="form-control" placeholder="Enter State" name="state_name[]" id="state_name">                                         
                                                                    </td>
                                                                    <td>   
                                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm view addrowbtn" title="Add"><i class="fa fa-plus"></i></a>
                                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm view delrowbtn" title="Delete" name="del[]" id="del_0"><i class="fa fa-trash-o"></i></a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>

                                                </div>


                                            </div>
                                        </div>

                                        <div class="clearfix"></div>  
                                        <div class="col-md-6">
                                            <div class="reset-button"> 
                                                  <button type="submit" class="btn redbtn" name="btnSubmitstate" id="btnSubmitstate">Save</button>
                                                <button type="reset" class="btn blackbtn">Reset</button>  
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
        
        <script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>

<script>
        $(".chk").on('change', function() {
          var checkFlag = 'unchecked';
          if ($(this).is(':checked')) {
            checkFlag = 'checked';
            var id = $(this).attr("id");
            alert(id); 
            $("#checkstate_").val('1');

          }


          console.log(checkFlag);

        });
</script>
    </body>
</html>

