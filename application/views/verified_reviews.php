<div class="container">
	<div class="row">
		<div class="col-lg-7"><div class="mb-4" style="font-weight: 600;color: #111;">Verified Google Reviews</div> </div>
		
		<div class="col-lg-3">
			<a href="https://www.google.com/search?q=my+holiday+happiness&oq=my+&aqs=chrome.0.69i59j69i57j69i60l2j69i61j69i60.1286j0j4&sourceid=chrome&ie=UTF-8" target="_blank" class="reviewviewbtn">View all google reviews</a>			
		</div>

		<div class="col-lg-2">
			<a href="<?php echo base_url().'review'; ?>" class="reviewviewbtn2">View all reviews</a>
		</div>
		
		<?php
			// $tour_tagid = '';
			function getVerifiedReviews($tour_tagid) {
				$tour_tagid = isset($_GET['tour_tagid']) ? $_GET['tour_tagid'] : '';
			}
		?>
		<div class="sb-container col-md-12 container-example1">						
			<?php 
				$where_conditions = "status = 1";

				// Add the conditions dynamically if the parameters are available
				if (isset($tour_tagid) && $tour_tagid != '') {
					$where_conditions .= " AND FIND_IN_SET($tour_tagid, tourtagid)";
				}

				$all_reviews = $this->Common_model->get_records(
					"*", 
					"tbl_reviews", 
					$where_conditions,  // Use the dynamic WHERE conditions
					"review_id DESC", 
					"40"
				);

				// print_r($all_reviews);exit;
				if(!empty($all_reviews)) {
				foreach($all_reviews as $all_review) {
					$no_of_star =  $all_review['no_of_star'] ; 
			?>
			<div class="googlereview-innerbox">
				<div class="googlereview-txt">
					<span class="r-circle"><?php echo substr($all_review['reviewer_name'], 0, 1); ?></span>
					<div><?php echo $all_review['reviewer_name'] ; ?></div>
					<span class="googlereview-place"><?php echo $all_review['reviewer_loc'] ; ?></span>
					<span class="reviewdate"><?php echo $this->Common_model->dateformat($all_review['created_date']); ?> </span>
					<p>
						<?php
							for ($x = 1; $x <= $no_of_star; $x++) {
								echo '<i class="fa fa-star"></i> ';
							}
							if (fmod($no_of_star, 1) !== 0.00) {
								echo '<i class="fas fa-star-half-alt"></i> ';
								$x++;
							}
							while ($x <= 5) {
								echo '<i class="fa fa-star-o"></i> ';
								$x++;
							}																
							// echo $this->Common_model->short_str($all_review['feedback_msg'],400) ;
							echo "<br>".nl2br($all_review['feedback_msg']);
						?>
					</p>
				</div>
			</div>
			
			<?php } 
			}
			?>
			
		</div>
    </div>
 </div>
            
