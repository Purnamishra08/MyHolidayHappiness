<!doctype html>
<html>
    <head>
        <?php include("head.php"); ?> 
    </head>
    <body>
        <?php include("header.php"); ?>      

        <section>
            <img src="<?php echo base_url(); ?>assets/images/reviewbanner.jpg" class="img-fluid" alt=""/>  
        </section>

        <div class="container  ">
             <ul class="cbreadcrumb mt-3">
                 
                  <li><a href="/">Home</a></li>
                  <li><a href="#">Privacy Policy</a></li>
                </ul>
            <div class="about-content-text about-text-cont">
                <?php
					$content=$this->Common_model->showname_fromid("page_content","tbl_contents","content_id='15'");
					echo $content; 
				?>                 
            </div>
		</div>

        <?php include("footer.php"); ?> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    </body>
</html>
