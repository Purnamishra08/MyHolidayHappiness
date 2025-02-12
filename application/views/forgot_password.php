<!DOCTYPE html>

<html>
    <head>
         <?php include("head.php"); ?>
    </head>
    <body>
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
            background-color:#00afeb;
            color:#fff;
            display: inline-block;
            text-transform: uppercase;
            font-size: 14px;
            font-family: "Open Sans";
            font-weight: 600;
            margin-right:5px;
            border-width: 2px;
            border-style: solid;
            border-color: #00afeb;
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
        .forgot {
    background: #fff;
    padding: 50px 40px;
    margin-top: 30px;
    box-shadow: 0 5px 8px 2px #ecebeb;
}
.forgot .form-control {
    border-radius: 0;
    box-shadow: none;
    background: #f1f1f1;
    border: 1px solid #ececec;
    padding: 20px 10px;
}
.forgot .btn-primary {
    color: #fff;
    background-color: #70c800;
    border-color: #70c800;
    border-radius: 0;
    font-size: 16px;
    margin-top: 2px;}
    .login-title-forgot {
    margin-bottom: 8px;
}
        .redbtn:hover, .blackbtn:hover{ color:#EAEAEA} 
    </style>

         <?php include("header.php"); ?>

        <div class="min-height">
            <section class="inr-body-sec login-body">
                <div class="container">

                    <div class="row">

                        <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="forgot">
                                <?php echo form_open(base_url( 'forgot_password' ), array( 'id' => 'change_password', 'name' => 'change_password', 'class' => 'login-form-inr' ));?>
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
                                                    
                                                <input class="form-control" placeholder="New Password " type="password" id="new_pwd" name="new_pwd" maxlength="20"/>
                                                </div>
                                                <div id="rplc_new_pwd"></div>
                                                <div class="form-group">
                                                    
                                                    <input class="form-control" placeholder="Confirm New Password " type="password" id="cnf_pwd" name="cnf_pwd" maxlength="20"/>
                                                </div>
                                                <div id="rplc_cnf_pwd"></div>
                                                <div class=" form-group ">
                                                    <button type="submit" class="btn btn-primary" id="btnSubmit" name="btnSubmit"  >Submit</button>
                                                    <button type="reset" class="btn btn-primary">Reset</button>                       
                                                </div>
                                              
                                            </div>
                                           

                                            <?php
                                        } else {
                                            ?>
                                            <?php
                                        }
                                        ?>   

                                          <div class="new-sign-up">
                                                    <div class="new-forgotpage-txt"> <a href="<?php echo base_url() . 'login' ?>"><strong>Log in</strong></a></div>
                                                </div>
                                                               
                                        <input type="hidden" name="hiduserid" id="hiduserid" value="<?php echo $getuserid; ?>"/>
                                    <?php echo form_close();?>
                                     </div>
                        </div>
                     <div class="col-md-3"></div>


                    </div>

                </div>
            </section>  





        </div>
         <?php include("footer.php"); ?>
         <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js"></script>
         <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>
    </body>
</html>
