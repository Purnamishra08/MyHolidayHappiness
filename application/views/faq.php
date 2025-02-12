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

        <div class="container ">
            <ul class="cbreadcrumb my-4">
                 
                  <li><a href="/">Home</a></li>
                  <li><a href="#">FAQ</a></li>
                </ul>
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mb-2" style="font-size: 1.5rem;;">Search & Book a Tour</h1>
                    <div id="accordion" role="tablist" aria-multiselectable="true" class="faqaccordion">
						<?php
						$cnt = 0;
						if (!empty($row)) {
							foreach ($row as $key => $rows) {
								$cnt++;
								$faq_id = $rows['faq_id'];
								$created_date = $rows['created_date'];
								$status = $rows['status'];
								?>
						
								<div class="card">							
									<div class="card-header" role="tab" id="heading<?php echo $cnt; ?>">
										<div class="mb-0">
											<a data-toggle="collapse" href="#collapse<?php echo $cnt; ?>" aria-expanded="true" aria-controls="collapse<?php echo $cnt; ?>" class="collapsed">
												<img src="<?php echo base_url(); ?>assets/images/headingarrow.png" class="fa-pull-left">
												<h2> <?php echo $rows['faq_question']; ?></h2>                                      
											</a>
										</div>
									</div>

									<div id="collapse<?php echo $cnt; ?>" class="collapse"  aria-labelledby="heading<?php echo $cnt; ?>" data-parent="#accordion">
										<div class="card-block">
											<?php echo $rows['faq_answer']; ?>
										</div>
									</div>
								</div>
							<?php
							}
						}
						?>                      
                    </div>  
                </div>
                <div class="col-md-12 mt-3 mb-3"><hr></div>                
                <div class="col-md-12 text-center ">
                    <h2>Didn't find an answer to your question?</h2>
                    <p>Get in touch with us for details on additional services and custom work pricing</p>
                    <a href="<?php echo base_url().'contactus#contactform'; ?>" class="faqbtn">Contact us</a>
                </div> 
                <div class="col-md-12 mt-3 mb-3"><hr></div>                
            </div>
        </div>

		<?php include("footer.php"); ?> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    </body>
</html>
