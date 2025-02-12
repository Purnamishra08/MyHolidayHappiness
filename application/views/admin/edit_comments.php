<?php
foreach ($row as $rows)
{
	$commentid = $rows['commentid'];
	$user_name = $rows['user_name'];
	$email_id = $rows['email_id'];
	$comments = $rows['comments'];					
	$status = $rows['status'];
}
?>

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
                        <small>Edit Comment</small>
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
                              <?php echo form_open('', array( 'id' => 'comments', 'name' => 'comments', 'class' => 'add-user'));?>
				              <div class="row">
				                <div class="form-group col-md-6">
				                	<label for="comment">Name:</label>
				                  <input type="text" class="form-control" name="username" id="username" readonly value=" <?php echo set_value('username',$user_name); ?>">
				                </div>
				                <div class="form-group col-md-6">
				                	<label for="comment">Email:</label>
				                  <input type="text" class="form-control" name="emailid" id="emailid" readonly value=" <?php echo set_value('emailid',$email_id); ?>">
				                </div>
				                <div class="clearfix"></div>
				               <div class="form-group col-md-12">
				              <label for="comment">Comment:</label>
				              <textarea class="form-control" rows="5" id="comment" name="comment"><?php echo set_value('comment',$comments); ?></textarea>

				              <div id="comment_error"></div>
				             <button type="submit" class="btn blackbtn" name="btnSubmit" id="btnSubmit" style="margin-top: 5px;">Submit</button>
				             <button type="button" style="margin-top: 5px;" class="btn blackbtn" onClick="window.location='<?php echo base_url(); ?>admin/comments'">Back</button>
				          <div id="frmError1"></div>
				      </div>
				      <?php echo form_close(); ?> 
				                  </div>
                                </div>                          
                            </div>
                        </div>
                    </div>
                </section>
            </div>


        <?php include("footer.php"); ?>
        
    </body>
</html>


