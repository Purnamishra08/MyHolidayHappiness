<?php $page_desc = $this->Common_model->showname_fromid("page_content", "tbl_contents", "content_id=3", ""); ?>
<!doctype html>
<html>

<head>
    <?php include("head.php"); ?>
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/input-material.css' ?>">
</head>

<body>
    <?php include("header.php"); ?>

    <section class="main">
        <div id="ri-grid" class="ri-grid ri-grid-size-2 ">
            <img class="ri-loading-image" src="<?php echo base_url(); ?>assets/images/loading.gif" />
            <ul>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/1.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/2.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/3.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/4.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/5.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/6.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/7.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/8.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/9.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/10.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/11.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/12.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/13.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/14.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/15.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/16.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/17.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/18.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/19.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/20.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/21.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/22.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/23.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/24.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/25.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/26.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/27.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/28.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/29.jpg" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/30.jpg" alt="" /></a></li>

            </ul>
        </div>
    </section>

    <div class="container  mt60 mb60">
        <ul class="cbreadcrumb">
                 
          <li><a href="/">Home</a></li>
          <li><a href="#">Contact Us</a></li>
        </ul>
        <div class="row">
            <div class="col-md-4 text-center box-min">
                <div class="box-cont">
                    <!-- img src="<?php echo base_url(); ?>assets/images/icon2.jpg" class="mb-3" -->
                    <h4>Corporate Office</h4>
                    <p><i class="fa fa-map-marker"></i><?php echo $this->Common_model->show_parameter(1); ?></p>
                    <p><i class="fa fa-envelope"></i> support@myholidayhappiness.com</p>
                </div>
            </div>
            <div class="col-md-4 text-center box-min">
                <div class="box-cont">
                    <!-- img src="<?php echo base_url(); ?>assets/images/icon2.jpg" class="mb-3" -->
                    <h4>Ooty Office</h4>
                    <p><i class="fa fa-map-marker"></i><?php echo $this->Common_model->show_parameter(36); ?></p>
                    <p><i class="fa fa-envelope"></i> ooty@myholidayhappiness.com</p>
                </div>
            </div>

            <div class="col-md-4 text-center box-min">
                <div class="box-cont">
                    <!-- img src="<?php echo base_url(); ?>assets/images/icon2.jpg" class="mb-3" -->
                    <h4>Bhubaneswar Office</h4>
                    <p><i class="fa fa-map-marker"></i>402, Panchamukhi Enclave, RaghunathPur, Bhubaneswar, Dist
                        Khurdha,Pin- 751002, Odisha</p>
                    <p><i class="fa fa-envelope"></i> bhubaneswar@myholidayhappiness.com</p>
                </div>
            </div>

            <div class="col-md-4 text-center box-min">
                <div class="box-cont">
                    <!-- img src="<?php echo base_url(); ?>assets/images/icon2.jpg" class="mb-3" -->
                    <h4>Andaman Office</h4>
                    <p><i class="fa fa-map-marker"></i>Near N.K International sea shore road anarkali, Port Blair,
                        Andaman and Nicobar Islands 744102</p>
                    <p><i class="fa fa-envelope"></i> andaman@myholidayhappiness.com</p>
                </div>
            </div>

            <div class="col-md-4 text-center box-min">
                <div class="box-cont">
                    <!-- img src="<?php echo base_url(); ?>assets/images/icon2.jpg" class="mb-3" -->
                    <h4>Shimla Office</h4>
                    <p><i class="fa fa-map-marker"></i>Near Court Complex, Chakkar, Shimla, Himachal Pradesh 171005</p>
                    <p><i class="fa fa-envelope"></i> shimla@myholidayhappiness.com</p>
                </div>
            </div>
            <div class="col-md-4 text-center box-min">
                <div class="box-cont">
                    <!-- img src="<?php echo base_url(); ?>assets/images/icon1.jpg" class="mb-3" -->
                    <h4>Contact Us</h4>
                    <p><i class="fa fa-map-marker"></i><?php echo $this->Common_model->show_parameter(14); ?><br>
                        <p><i class="fa fa-envelope"></i><?php echo $this->Common_model->show_parameter(2); ?>


                </div>
            </div>
            <!--div class="col-md-4 text-center">
                    <img src="<?php echo base_url(); ?>assets/images/icon3.jpg" class="mb-3">
                    <h4>Email</h4> <?php echo $this->Common_model->show_parameter(2); ?>
                </div-->
            <div class="clearfix"></div>
        </div>
    </div>

    <section class="contact-content" id="contactform">
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <?php
						$cont=$this->Common_model->showname_fromid("page_content","tbl_contents","content_id='3'");
						echo $cont; 
					?>
                <div class="col-md-2"></div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>

    <div class="container mb100">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 form-wrapper">
                <div style="width: 100%">
                    <iframe width="100%" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31101.190428780643!2d77.54881629413453!3d12.994300031713436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae3f2ed2301e45%3A0x89e7ba8485a43c37!2sMy%20Holiday%20Happiness!5e0!3m2!1sen!2sin!4v1694344629737!5m2!1sen!2sin"></iframe>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="clearfix"></div>
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <?php echo form_open(base_url('contactus'), array( 'id' => 'form_contact', 'name' => 'form_contact', 'class' => 'contactform row' ));?>
                <div class="col-md-6">
                    <div class="form-group input-material">
                        <input type="text" class="form-control" name="cont_name" id="cont_name"
                            value="<?php echo set_value('cont_name'); ?>" maxlength="50">
                        <label for="name-field">Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-material">
                        <input type="email" class="form-control" name="cont_email" id="cont_email"
                            value="<?php echo set_value('cont_email'); ?>" maxlength="80">
                        <label for="email-field">Email</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group input-material">
                        <input type="text" class="form-control" name="cont_phone" id="cont_phone"
                            value="<?php echo set_value('cont_phone'); ?>" maxlength="10">
                        <label for="phone-field">Phone</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-material">
                        <textarea class="form-control" name="cont_details" id="cont_details" rows="3"  maxlength="500"></textarea>
                        <label for="textarea-field">Your Message (Maximum 500 Character)</label>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group" style="padding-top: 30px;">
                        <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>"></div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-3">
                    <input type="hidden" name="pagename" id="pagename" value="Contact Page">
                    <button type="submit" class="btn btn-primary contactsubmit">Send</button>
                </div>
                <div class="col-md-9">
                    <div id="errMessage" style="padding-top: 12px;"></div>
                </div>
                <?php echo form_close();?>
                <div class="clearfix"></div>
                <div class="col-md-1"></div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-1"></div>
            <div class="clearfix"></div>
        </div>
    </div>

    <?php include("footer.php"); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.gridrotator.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/materialize-inputs.jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <script type="text/javascript">
        $(function () {

            $('#ri-grid').gridrotator({
                rows: 2,
                columns: 10,
                animType: 'fadeInOut',
                animSpeed: 1000,
                interval: 600,
                step: 1,
                w320: {
                    rows: 3,
                    columns: 4
                },
                w240: {
                    rows: 3,
                    columns: 4
                }
            });

        });
    </script>
    <script>
        var base_url = "<?php echo base_url(); ?>";
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js_validation/jquery.validate.js"></script>
    <script src="<?php //echo base_url(); ?>assets/js_validation/validation.js"></script>

    <script>
        $('document').ready(function () {
            $('body').materializeInputs();
        });
    </script>
</body>

</html>