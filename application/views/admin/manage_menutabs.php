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
                        <i class="fa fa-gg"></i>
                    </div>
                    <div class="header-title">
                        <h1> Category </h1>
                        <small>Manage category </small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">

                        <div class="col-sm-4">
                            <div  style="margin-bottom: 25px;box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16);
                                  background-color:#fff; padding:25px;border-radius: 4px;">
                                <!-- <form name="colour" id="colour" method="post"> -->

                                   <?php echo form_open('', array( 'id' => 'form_cats', 'name' => 'form_cats'));?>
                                    <?php echo $messageadd; ?>
                                        
                                    <div class="form-group">
                                         <label> Menu </label>
                                        <select class="form-control fld" name="menuid" id="menuid">
                                            <option value=""> --Select menu tab--</option>
                                            <?php  echo $this->Common_model->populate_select($dispid = 0, "menuid", "menu_name", "tbl_menus", "", "menu_name asc", ""); ?> 

                                            <!--<option value="1">  Destinations </option>
                                            <option value="2">  Getaways </option>
                                            <option value="3">  Tours </option> -->
                                        </select>
                                    </div>
                                     
                                     <div class="form-group">
                                        <label> Category</label>
                                        <input type="text" class="form-control fld" placeholder="Enter category" name="cat_name" id="cat_name" value="<?php echo set_value('cat_name'); ?>">  
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="reset-button">  
                                        <button type="submit" class="btn redbtn" name="btnSubmitcats" id="btnSubmitcats">Save</button>
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
                                        <?php echo $message; ?>                           
                                        <div class="table-responsive">
                                            <table id="example1" class="table table-bordered table-striped table-hover">
                                                <thead>

                                                     <tr class="info">
                                                        <th width="6%" style="text-align: center;">Sl #</th>    
                                                        <th width="10%"> Menus </th>
                                                        <th width="10%"> Categories </th>
                                                        <th width="10%">Status</th>
                                                        <th width="14%">Action</th>
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
                                                            $catid = $rows['catid'];    
                                                            $menuid = $rows['menuid'];  
                                                            $status = $rows['status'];
                                                                        
                                                            if ($menuid == 1) {
                                                                $menu_name = 'Getaways';
                                                            } else if ($menuid == 2){
                                                                 $menu_name = 'Destinations';
                                                            } else {
                                                                $menu_name ='Tours';
                                                            }
                                                ?>
                                                <tr>
                                                        <td><?php echo $cnt; ?></td>                                                       
                                                        <td><?php echo $menu_name; ?></td>                                                      
                                                        <td><?php echo $rows['cat_name']; ?></td>
                                                        <td>                                                        
                                                        <?php if($status==1) { ?>
                                                            <span class="status" data-id="<?php echo "status-".$catid; ?>"><a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a></span>
                                                        <?php } else { ?>
                                                        <span class="status" data-id="<?php echo "status-".$catid; ?>"><a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a></span>
                                                         <?php } ?>
                                                        </td>
                                                        <td>
                                                            
                                                            <a href="javascript:void(0);" data-id="<?php echo $catid; ?>" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm edit" title="Edit"><i class="fa fa-pencil"></i></a>

                                                            <!-- <a href="#" data-id="" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm view" title="Add state"><i class="fa fa-globe"></i></a> -->
                                                            
                                                            <a onClick="return confirm('Are you sure to delete this category?')" href="<?php echo base_url().'admin/menutabs/delete/'.$catid; ?>" class="btn btn-danger btn-sm" title=""><i class="fa fa-trash-o"></i> </a>
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
    $(document).ready(function () {
        $('#example1').DataTable();
    });

  $(document).on('click', '.status', function(){
                if(confirm('Are you sure to change the status?'))
                {
                    var val = $(this).data("id");
                    var valsplit = val.split("-");
                    var id = valsplit[1];
                    jQuery('[data-id='+val+']').after('<div class="spinner" style="text-align:center;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-1x"></i></div>');
    
                    $.ajax({
                        url: "<?php echo base_url(); ?>admin/menutabs/changestatus/"+id,
                        type: 'post',
                        data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
                        cache: false,
                        success: function (data) {
                            //alert(data);
                            jQuery('.spinner').remove();                        
                            if(data == '1') //Inactive
                            {
                                jQuery('[data-id='+val+']').html('<a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a>');
                            }
                            else if(data == '0') //Active
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



                $(document).on('click', '.edit', function () {
                    jQuery('#myModal .modal-content').html('<div style="text-align:center;margin-top:150px;margin-bottom:100px;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-3x"></i> <span>Processing...</span></div>');
                    var val = $(this).data("id");


                    $.ajax({
                        url: "<?php echo base_url(); ?>admin/menutabs/menucateditpopup/" + val,
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


</script>
  </body>
</html>

