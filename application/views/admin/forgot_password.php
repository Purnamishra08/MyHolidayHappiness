<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Organic</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/admin/css/style.css" rel="stylesheet" type="text/css">
    </head>

    <style>
        .loginform {padding: 33px 25px 0px;}
        .loginform .form-control{
            border-radius: 0px;
            box-shadow:none;
            border:#ddd 1px solid;
        }
        .loginform .control-label {
            padding-top: 7px;
            margin-bottom: 0;
            text-align: right;
            text-transform: uppercase;
            font-size: 12px;
        }
        .loginform-content .panel-heading{
            padding:15px 0;
        }
        .loginform-content .panel-footer {
            background:#676565;
            color: #fff;
            font-size:13px;
            letter-spacing:0.5px;
            padding: 12px 15px;
            border-radius:0;
        }
        .loginform-content .panel-footer a{ color:#fff}
        .loginform-content .panel{ 
            border:none;
            border-radius:0;
            background: rgba(255, 255, 255, 0.78);
        }
        .loginform-content .checkbox {
            min-height: 27px;
            margin-top: -10px;
        }
        .loginform a{ color:#000}
        .redbtn {
            background-color:#8ad629;
            color:#fff;
            display: inline-block;
            text-transform: uppercase;
            font-size: 14px;
            font-family: "Open Sans";
            font-weight: 600;
            margin-right:5px;
            border-width: 2px;
            border-style: solid;
            border-color: #8ad629;
            border-image: initial;
            padding: 6px 16px;
            transition: all 0.5s linear;
        }
        .blackbtn {
            background-color: #333;
            border: #333 2px solid;
            color: #fff;
            padding: 6px 16px;
            display: inline-block;
            text-transform: uppercase;
            transition: all linear 0.5s;
            font-size: 14px;
            font-family: 'Open Sans';
            font-weight: 600;
        }
        .redbtn:hover, .blackbtn:hover{ color:#EAEAEA} 
    </style>

    <body style="background:url(<?php echo base_url(); ?>assets/admin/img/loginbg.jpg) no-repeat; background-size:cover">
        <div class="wrapper">
            <?php //include("header.php"); ?> 

            <div class="container">
                <div class="row">
                    <div class="col-md-6 loginform-content">
                        <div class="login">
                            <div class="panel panel-default">
                                <div class="panel-heading"> <img src="<?php echo base_url(); ?>assets/admin/img/login-logo.png" class="center-block"> </div>
                                <div class="panel-body">
                                    <form class="loginform" name="change_password" id="change_password" method="post" >
                                         <?php echo form_open('', array( 'id' => 'change_password', 'name' => 'change_password', 'class' => 'loginform' ));?>

                                        <?php echo $message; ?>
                                        <?php
                                        if ($validmsg != '') {
                                            ?>
                                            <div class="form-group">
                                                <div class="col-xl-12 col-lg-12 text-center">
                                                    <span style="color:#990000;"><b>
                                                            <?php echo $validmsg; ?> </b></span>
                                                </div>
                                            </div>
                                            <?php
                                        } else if (($diffrnc >= 0) && ($numuserforgot > 0)) {
                                            ?>  

                                            <div class="login-title-forgot">Forgot Password</div>
                                            <div id="login-1st">
                                                <div class="form-group">
                                                    <i class="fa fa-lock"></i>
                                                    <input class="form-control" placeholder="New Password " type="password" id="new_pwd" name="new_pwd" maxlength="20"/>
                                                </div>
                                                <div id="rplc_new_pwd"></div>
                                                <div class="form-group">
                                                    <i class="fa fa-lock"></i>
                                                    <input class="form-control" placeholder="Confirm New Password " type="password" id="cnf_pwd" name="cnf_pwd" maxlength="20"/>
                                                </div>
                                                <div id="rplc_cnf_pwd"></div>
                                                <div class=" form-group text-center">
                                                    <button type="submit" class="btn redbtn btn-sm" id="btnSubmit" name="btnSubmit"  >Submit</button>
                                                    <button type="reset" class="btn redbtn btn-sm">Reset</button>                       
                                                </div>
                                               
                                            </div>

                                            <?php
                                        } else {
                                            ?>
                                            <?php
                                        }
                                        ?> 

                                         <div class="new-sign-up">
                                                    <div class="new-forgotpage-txt"> <a href="<?php echo base_url() . 'admin' ?>"><strong>Log in</strong></a></div>
                                                </div>
                                                                 
                                        <input type="hidden" name="hiduserid" id="hiduserid" value="<?php echo $getuserid; ?>"/>
                                    <!-- </form> -->
                                     <?php echo form_close();?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="<?php echo base_url(); ?>assets/admin/js/jquery-1.12.4.min.js" type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/admin/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/admin/js/jquery.slimscroll.min.js" type="text/javascript"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js"></script>
            <script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/admin/js_validation/additional-methods.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>
            <script src="<?php echo base_url(); ?>assets/admin/js/custom.js" type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/admin/js/dashboard.js" type="text/javascript"></script> 

    </body>
</html>

