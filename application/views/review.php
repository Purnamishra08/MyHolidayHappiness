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

        <div class="container  mt60 mb100">
             <ul class="cbreadcrumb mt-3">
                 
                  <li><a href="/">Home</a></li>
                  <li><a href="#">Reviews</a></li>
                </ul>
            <div class="row">

                <div class="col-lg-9"><h1 class="mb-4">Recent My Holiday Happiness Reviews</h1> </div>
                <!--div class="col-lg-3"><a href="add-review.html" class="reviewviewbtn">Review your trip</a></div-->
				<?php if(!empty($getAllReviews)) {
					  foreach($getAllReviews as $getAllReview) {
						   $created_date = $getAllReview['created_date'];
						   $no_of_star 	 = $getAllReview['no_of_star'];
						   $feedback_msg = $getAllReview['feedback_msg'];
				?>
                <div class="col-md-12 mb-2">
                <div class="googlereview-innerbox2">
                    <div class="googlereview-txt">
                        <span class="r-circle"><?php echo substr($getAllReview['reviewer_name'], 0, 1); ?></span>
                        <div><?php echo $getAllReview['reviewer_name'] ; ?></div>
                        <span class="googlereview-place"><?php echo $getAllReview['reviewer_loc'] ; ?> </span>
                        <span class="reviewdate"><?php echo $this->Common_model->dateformat($created_date); ?> </span>
                        <p>							
							<?php
								for ($x = 1; $x <= $no_of_star; $x++) {
									echo '<i class="fa fa-star"></i> ';
								}
								if (fmod($no_of_star, 1) !== 0.00) {
									echo '<i class="fa fa-star-half-o"></i> ';
									$x++;
								}
								while ($x <= 5) {
									echo '<i class="fa fa-star-o"></i> ';
									$x++;
								}
							    // echo $this->Common_model->short_str($feedback_msg, 140); 
                                echo "<br>".nl2br($feedback_msg);
							?>
						</p>
                       <!-- <h6>(Travelled to Ooty - Mysore - Coorg)</h6>-->
                    </div>
                </div>
                </div>
                
                <?php }
                
                } ?>
			<div class="col-md-12">
                <?php echo $pagination; ?>
            </div>
            </div>
           
        </div>

		<?php include("footer.php"); ?> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    </body>
</html>
