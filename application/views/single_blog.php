<?php
$page_desc = $this->Common_model->showname_fromid("page_content", "tbl_contents", "content_id=2", "");
?>

<?php
if (!empty($row)) {
    foreach ($row as $rows) {

        $disid = $rows['blogid'];
        $blog_title = $rows['title'];
        $dis_image = $rows['image'];
        $alttag_image = $rows['alttag_image'];
        $contents = $rows['content'];
        $blog_url = $rows['blog_url'];
        $blog_url = $rows['blog_url'];
        $show_comments = $rows['show_comment'];
        $status = $rows['status'];
        $date = $rows['created_date'];
        $sess_userid = $rows['created_by'];
    }
}
?>

<!doctype html>
<html>
    <head>
        <?php include("head.php"); ?> 
    </head>
    <body>
      <?php include("header.php"); ?> 

      <img src="<?php echo base_url(); ?>assets/images/delhicity.jpg" class="img-fluid" alt="My Holiday Happiness"/>



        <section class="mt80 mb100">
            <div class="container">
                <ul class="cbreadcrumb">
                 
                  <li><a href="/">Home</a></li>
                  <li><a href="/blog">Blogs</a></li>
                  <li><a href="#"><?php echo $blog_title;?></a></li>
                </ul>
                <div class="row">
                    <div class="col-lg-8">
                     
       <div class="blogsection mt30 mb30">
                        <div class="blogimg"><?php if (file_exists("./uploads/" . $dis_image) && ($dis_image != '')) {
            ?><img src="<?php echo base_url() . 'uploads/' . $dis_image; ?>" class="img-fluid" alt="<?php echo (!empty($alttag_image)) ? $alttag_image : "My Holiday Happiness"; ?>"><?php } ?></div>
                        <h3><?php echo $blog_title; ?></h3>
                        <div class="postlist">
                            <span class="postdetails"> <i class="fa fa-calendar-o"></i><?php echo date('dS F Y', strtotime($date)); ?></span> 
                            <?php if ($show_comments == "1") { ?>  <span class="postdetails">  <i class="fa fa-comment-o"></i><?php echo $noofcomments = $this->Common_model->noof_records("commentid", "tbl_comments", "status='1' and blogid='$disid'"); ?> Comments </span><?php } ?></div>
                        <p class="blogcontent"><?php echo $contents; ?></p>

                        <hr>
                        <div class="shareicons mt-3">Share : <a href="http://www.facebook.com/sharer.php?u=<?php echo base_url() . 'blog/' . $blog_url; ?>"  target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com/share?url=<?php echo base_url() . 'blog/' . $blog_url; ?>"  target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="https://plus.google.com/share?url=<?php echo base_url() . 'blog/' . $blog_url; ?>"  target="_blank"><i class="fab fa-google-plus-g"></i></a>   
                            <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo base_url() . 'blog/' . $blog_url; ?>"  target="_blank"><i class="fab fa-linkedin-in"></i></a>    </div>  
                        <hr>
                        <?php if ($show_comments == 1) { ?>
                            <h2 class="formhdng">Leave a comment</h2>
                            <p class="mt10">Your email address will not be published. Required fields are marked *</p>

                            <?php echo form_open('', array( 'id' => 'discussion', 'name' => 'discussion', 'class' => 'mt40'));?>
                                <div class="form-group mb20">
                                    <label>Comment</label>
                                    <textarea type="text" class="form-control"  name="comment" id="comment"  maxlength="500"></textarea> 
                                    <div id="comment_error"></div>
                                </div>

                                <div class="form-group mb20">
                                    <label>Name</label>                          
                                    <input type="text" class="form-control"  name="username" id="username"  maxlength="50"> 
                                    <div id="name_error"></div>
                                </div>

                                <div class="form-group mb20">
                                    <label>Email</label>                             
                                    <input type="text" class="form-control"  name="emailid" id="emailid"  maxlength="80">
                                    <div id="email_error"></div>
                                </div>

                                <div class="form-group mb20">
                                    <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>"></div>
                                </div>

                                <div class="form-group mb20">
                                    <input type="hidden" class="form-control" name="disid" id="disid"  value="<?php echo $disid; ?>">
                                    <button name="btnSubmit" id="btnSubmit" type="submit" value="Send message" class="btn requestquotebtn">Send message</button>
                                    <div id="frmError1"></div>
                                </div>

                            <?php echo form_close(); ?>
                        <?php } ?>
                    </div>


                    <?php
                    if ($show_comments == 1) {
                        $datarecent = $this->Common_model->get_records("*", "tbl_comments", "status='1' and blogid='$disid' and parentid is null", "commentid DESC", "", "");
                        if (!empty($datarecent)) {
                            foreach ($datarecent as $datarecents) {
                                $commentid = $datarecents['commentid'];
                                $user_name = $datarecents['user_name'];
                                $comments = $datarecents['comments'];
                                $parentid = $this->Common_model->showname_fromid("parentid", "tbl_comments", "blogid ='$disid' and parentid>0");
                                $created_date = $datarecents['created_date'];
                                $noofcomments = $this->Common_model->noof_records("commentid", "tbl_comments", "status='1'");
                                ?>
                                <div class="blocreplyrection">
                                    <div><h5><i class="fa fa-user-o"></i> <?php echo $user_name; ?></h5></div>
                                    <div><i class="fa fa-calendar"></i> <?php echo date('dS F , Y', strtotime($created_date)); ?></div>
                                    <div><i class="fa fa-comment-o"></i> <?php echo $comments; ?> </div>                
                                    <div class="blog-replybtn"><a href="#" data-toggle="modal" data-target="#myModal" onclick="setcommnetid(<?php echo $commentid; ?>)"><i class="fa fa-share" aria-hidden="true"></i> Reply </a></div>

                                    <?php
                                    //echo "asdfasdf-".$parentid;
                                    if ($parentid > 0) {
                                        $datarecentchldcmnt = $this->Common_model->get_records("*", "tbl_comments", "status='1' and blogid='$disid' and parentid='$commentid'", "commentid DESC", "", "");
                                        if (!empty($datarecentchldcmnt)) {
                                            foreach ($datarecentchldcmnt as $datarecentchldcmnts) {
                                                $commentschild = $datarecentchldcmnts['comments'];
                                                $user_namechild = $datarecentchldcmnts['user_name'];
                                                $created_datechild = $datarecentchldcmnts['created_date'];
                                                ?>

                                                <div class="blog-replycontent"> 
                                                    <div><h5><i class="fa fa-user-o"></i> <?php echo $user_namechild; ?></h5></div>
                                                    <div><i class="fa fa-calendar"></i> <?php echo date('dS F , Y', strtotime($created_datechild)); ?></div>
                                                    <div><i class="fa fa-comment-o"></i> <?php echo $commentschild; ?> </div>           
                                                </div>

                                                <?php
                                            }
                                        }
                                    }
                                    ?>

                                </div>
                                <?php
                            }
                        }
                    }
                    ?>  



                        </div>
       
            <div class="col-lg-4 blogrght">
            <?php include ( "blog_sidebar.php" ); ?>
            </div>
    
    
           <div class="clearfix"></div>
                     
                    
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </section>
         
          <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close modalclosebtn" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">Leave a Reply</h3>
                    </div>
                    <div class="modal-body">
                    <?php echo form_open('', array( 'id' => 'reply', 'name' => 'reply'));?>

                            <div class="form-group mb20">
                                <label>Comment</label>
                                <textarea type="text" class="form-control"  name="comment1" id="comment1" maxlength="500"></textarea>   
                                <div id="comment_error1"></div>
                            </div>

                            <div class="form-group mb20">
                                <label>Name</label>                          
                                <input type="text" class="form-control"  name="username1" id="username1" maxlength="50">   
                                <div id="name_error"></div>
                            </div>

                            <div class="form-group mb20">
                                <label>Email</label>                             
                                <input type="text" class="form-control"  name="emailid1" id="emailid1" maxlength="80">
                                <div id="email_error"></div>
                            </div>

                            <div class="form-group mb20">
                                <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>"></div>
                            </div>

                            <div class="form-group mb20">
                                <input type="hidden" class="form-control" name="reply_disid" id="reply_disid"  value="<?php echo $disid; ?>">
                                <input type="hidden" class="form-control" name="reply_commentid" id="reply_commentid">
                                <button name="btnSubmit" id="btnSubmit" type="submit" value="Send message" class="btn requestquotebtn">Send message</button>
                                <div id="frmError2"></div>
                            </div>
                         <?php echo form_close(); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    
        <?php include("footer.php"); ?>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js_validation/jquery.validate.js"></script>
        <script src="<?php echo base_url(); ?>assets/js_validation/validation.js"></script>      
       
     <script type="text/javascript">
    

     jQuery("#discussion").validate({
        rules: {
            comment: {
                required: true                
            },
             username: {
                required: true                
            },
             emailid: {
                required: true,
                email: true                
            }            
        },
        messages: {
            comment: {
                required: "Enter comment"             
            },
            username: {
                required: "Enter Name"             
            },
            emailid: {
                required: "Enter Email",
                email: "Enter valid email"             
            }            
        },
        errorPlacement: function (error, element)
        {
            if (element.attr("name") === "comment" )
                error.appendTo("#comment_error");
            else
                error.insertAfter(element);
        },
        submitHandler: function(form) {
            $('#frmError1').html('<div style="text-align:center"><i style="color:#377b9e" class="fa fa-spinner fa-spin fa-3x"></i> <span style="color:#377b9e">Processing...</span></div>');
            $.ajax({
                url: base_url + "single_blog/comment",
                type: 'post',
                cache: false,
                processData: false,
                data: $('#discussion').serialize(),
                success: function(result) {
                    grecaptcha.reset();
                    data = jQuery.parseJSON(result); 
                    if (data.status == "success") { 
                        jQuery('#discussion')[0].reset();
                        $('#frmError1').html('<div class="successmsg"><i class="fa fa-check"></i> '+data.message+' </div>');                        
                    } else{
                        $('#frmError1').html('<div class="errormsg"><i class="fa fa-times"></i> '+data.message+' </div>');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    grecaptcha.reset();
                    alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                    $('#frmError1').html('<div class="errormsg"><i class="fa fa-times"></i> Unable to process your request. Please try again.</div>');
                }
            });
            return false;
        }
    });

</script>

<script type="text/javascript">

    jQuery("#reply").validate({
        rules: {
            comment1: {
                required: true                
            },
             username1: {
                required: true                
            },
            emailid1: {
                required: true,
                email: true                
            }            
        },
        messages: {
            comment1: {
                required: "Enter comment"             
            },
            username1: {
                required: "Enter Name"             
            },
            emailid1: {
                required: "Enter Email",
                email: "Enter valid email"             
            }            
        },
        errorPlacement: function (error, element)
        {
            if (element.attr("name") === "comment1" )
                error.appendTo("#comment_error1");
            else
                error.insertAfter(element);
        },
        submitHandler: function(form) {
            $('#frmError2').html('<div style="text-align:center"><i style="color:#377b9e" class="fa fa-spinner fa-spin fa-3x"></i> <span style="color:#377b9e">Processing...</span></div>');
            $.ajax({
                url: base_url + "single_blog/comment_reply",
                type: 'post',
                cache: false,
                processData: false,
                data: $('#reply').serialize(),
                success: function(result) {
                    grecaptcha.reset();
                    data = jQuery.parseJSON(result); 
                    if (data.status == "success") { 
                        jQuery('#reply')[0].reset();
                        $('#frmError2').html('<div class="successmsg"><i class="fa fa-check"></i> '+data.message+' </div>');                        
                    } else{
                        $('#frmError2').html('<div class="errormsg"><i class="fa fa-times"></i>  '+data.message+' </div>');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    grecaptcha.reset();
                    alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                    $('#frmError2').html('<div class="errormsg"><i class="fa fa-times"></i> Unable to process your request. Please try again.</div>');
                }
            });
            return false;
        }

    });

</script>

<script type="text/javascript">
        function setcommnetid(cmntid) {
            //alert(cmntid);
            ///ocument.getElemnetByid("reply_commentid").value=cmntid;
            $("#reply_commentid").val(cmntid);
        }
</script>

    </body>
</html>
