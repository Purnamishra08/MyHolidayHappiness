        <footer>
            <div class="ratingholder" style="display:none">
			<!--	<a href="https://www.google.com/search?q=my+holiday+happiness&amp;oq=my+&amp;aqs=chrome.0.69i59j69i57j69i60l4.938j0j4&amp;sourceid=chrome&amp;ie=UTF-8" target="_blank">-->
			<a href="https://www.google.com/search?q=myholidayhappiness&oq=myholidayhappiness&aqs=chrome..69i57j35i39j0j69i59j69i60l2j69i61j69i60.4919j0j4&sourceid=chrome&ie=UTF-8#lrd=0x3bae3f2ed2301e45:0x89e7ba8485a43c37,1" target="_blank"  rel="nofollow" >
				<img src="#" data-src="<?php echo base_url(); ?>assets/images/googlelogo.png" alt="Google " class="lazy"  width="120" height="40">
				<h4>My Holiday Happiness </h4>
				<span>  
					<?php echo $google_review = $this->Common_model->show_parameter(23); ?> 
					<?php
					$google_floorval = floor($google_review);
					$google_decval = $google_review - $google_floorval;
					$google_balanceint = 5 - $google_review;
					echo str_repeat('<i class="fas fa-star"></i>', $google_floorval);
					echo ($google_decval > 0) ? '<i class="fas fa-star-half-alt"></i>' : '';
					echo str_repeat('<i class="far fa-star"></i>', $google_balanceint);
					?>
				</span>
				<span><?php echo $this->Common_model->show_parameter(24); ?> reviews</span></a>
				<span class="googlereview-close">X</span> 
            </div>
            <div class="container">
                <div class="row">
                    <h3 class="col-md-5 mb-5">Find more popular<br> destinations lists in India</h3>
                    <div class="col-md-6 mb-5 buttonright"><h5 class="footersignup">For Travel agent signup here</h5></div>
                    <div class="clearfix"></div>

                    <div class="col-md-4 footerlistcontent mb-4">
                        <div class="title-1 rotated-text"> Weekend Getaways </div>
                        <ul class="footer-list">
							<?php 
																					
								$getFooterMenuGetawas = $this->Common_model->join_records("a.cat_name, b.tag_name,b.tag_url","tbl_menucateories as a","tbl_menutags as b", "a.catid=b.cat_id", "a.status=1 and b.status=1 and b.menuid = 1 and b.show_on_footer = 1","b.tag_name asc","9");	
								
								if(!empty($getFooterMenuGetawas)){ 
									foreach($getFooterMenuGetawas as $getFooterMenuGetawa) {
										$seocat_name = $this->Common_model->makeSeoUrl($getFooterMenuGetawa['cat_name']);		
										$tag_url = $getFooterMenuGetawa['tag_url'];		
							?>
														
                            <li><a href="<?php echo base_url().'getaways/'.$seocat_name.'/'.$tag_url; ?>"><?php echo $getFooterMenuGetawa['tag_name'] ?></a></li>
                             <?php } } ?> 
                        </ul>
                        <a href="<?php echo base_url().'getaway' ?>" class="footerbtn">view all</a>
                    </div>

                    <div class="col-md-4 footerlistcontent mb-4">
                        <div class="title-1 rotated-text"> Tourist Destination in India </div>
                        <ul class="footer-list footermiddlelist">
							<?php 																					
								$getFooterMenuDests = $this->Common_model->join_records("a.state_url, b.destination_name,b.destination_url","tbl_state as a","tbl_destination as b", "a.state_id=b.state", "a.status=1 and b.status=1 and b.show_on_footer = 1","b.destination_name asc","16");	
								
								if(!empty($getFooterMenuDests)){ 
									foreach($getFooterMenuDests as $getFooterMenuDest) {
							?>
                            <li><a href="<?php echo base_url().'destination/'.$getFooterMenuDest['state_url'].'/'.$getFooterMenuDest['destination_url']; ?>"><?php echo $getFooterMenuDest['destination_name'] ?></a></li>
                            
                            <?php } } ?> 
                            
                        </ul>
                        <a href="<?php echo base_url().'destinations' ?>" class="footerbtn">view all</a>
                    </div>

                    <div class="col-md-4 footerlistcontent mb-4">
                        <div class="title-1 rotated-text"> Best Tour Packages </div>
                        <ul class="footer-list">
							<?php 								
								$getFooterMenuTours = $this->Common_model->join_records("a.cat_name, b.tag_name,b.tag_url","tbl_menucateories as a","tbl_menutags as b", "a.catid=b.cat_id", "a.status=1 and b.status=1 and b.menuid = 3 and b.show_on_footer = 1","b.tag_name asc","9");
								//echo $this->db->last_query();
								
								if(!empty($getFooterMenuTours)){ 
									foreach($getFooterMenuTours as $getFooterMenuTour) {
										$seocat_nametours = $this->Common_model->makeSeoUrl($getFooterMenuTour['cat_name']);		
										$tag_urltours = $getFooterMenuTour['tag_url'];	
							?>
                            <li><a href="<?php echo base_url().'tours/'.$seocat_nametours.'/'.$tag_urltours; ?>"><?php echo $getFooterMenuTour['tag_name']; ?></a></li>
                            <?php } }?>  
                           <li><a href="https://myholidayhappiness.com/tours/popular-tour-packages/ooty-packages">Ooty Tour Packages</a></li>
                        </ul>
                        <a href="<?php echo base_url().'tour-packages'?>" class="footerbtn">view all</a>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-12 footerhr">
                        <hr>
                    </div>
                    <div class="col-md-12 text-center">
                        <div class="mt-4" style="color: #111;font-weight: 600;">Tour consult expert : <a href="tel:+919886525253" rel="nofollow"><?php echo $this->Common_model->show_parameter(3); ?></a></div></div>

                    <div class="text-center col-md-12">
                        <ul class="footermenulist">
                            <li><a href="<?php echo base_url()?>about">About Us</a></li>
                            <li><a href="<?php echo base_url()?>contactus">Contact Us</a></li>
                            <li><a href="<?php echo base_url()?>review">Reviews</a></li>
                            <li><a href="<?php echo base_url()?>privacy-policy">Privacy Policy</a></li>
							<li><a href="<?php echo base_url()?>terms-conditions">Terms &amp; Conditions</a></li>
							<li><a href="<?php echo base_url()?>booking-policy">Booking Policy</a></li>
                            <li><a href="<?php echo base_url()?>faq">FAQs</a></li>
                            <li><a href="<?php echo base_url()?>hiring">Hiring</a></li>
                            <li><a href="<?php echo base_url()?>travel-agents">Travel agents</a></li>
                            <li><a href="<?php echo base_url()?>advertise">Advertise</a></li>
                        </ul>
                    </div>

                    <div class="col-md-12 footerhr">
                        <hr>
                    </div>
                    <div class="clearfix"></div>
                    
                    
                    <div class="col-md-3 col-sm-3 mb-3 socialicon">
                        <div class="mt-2 mb-1">Follow us</div>
                        <div class="socialicon-img">
                            <a href="<?php echo $this->Common_model->show_parameter(29); ?>" target="_blank"  rel="noopener noreferrer" ><img class="lazy" src="#" data-src="<?php echo base_url(); ?>assets/images/fbook.png" alt="facebook" width="29" height="25"></a>
                        </div>
                        <div class="socialicon-img">
                            <a href="<?php echo $this->Common_model->show_parameter(30); ?>" target="_blank"  rel="noopener noreferrer" ><img  class="lazy" src="#" data-src="<?php echo base_url(); ?>assets/images/twitter.png" alt="twitter" width="29" height="25"></a>
                        </div>
                        <div class="socialicon-img">
                            <a href="<?php echo $this->Common_model->show_parameter(32); ?>" target="_blank"  rel="noopener noreferrer" ><img  class="lazy" src="#" data-src="<?php echo base_url(); ?>assets/images/linkedin.png" alt="linkedin" width="29" height="25"></a>
                        </div>
                        <div class="socialicon-img">
                            <a href="https://www.instagram.com/myholidayhappiness/" target="_blank"  rel="noopener noreferrer" ><img  class="lazy" src="#" data-src="<?php echo base_url(); ?>assets/images/instagram.png" alt="Instagram" width="29" height="25"></a>
                        </div>
                    </div>
                    
                    
                    <div class="col-md-4 col-sm-4 mb-3 paymentbox socialicon text-center">
                        <div class="mt-2 mb-1">100% secure payments</div>
                        <img  class="lazy" src="#" data-src="<?php echo base_url(); ?>assets/images/payments.png" alt="payments" width="200" height="30">
                    </div>
                    
                    <div class="col-md-5 col-sm-5 mb-3 paymentbox featuredbox-footer">
                        <div class="mt-2 mb-1">Featured In</div>
                      <a href="https://raindrops-insider.beehiiv.com/p/how-yellosa-khoday-is-providing-one-click-holiday-solutions-with-his-startup-my-holiday-happiness" target="_blank"><img src="#" data-src="<?php echo base_url(); ?>assets/images/timesnext-logo.png" alt="timesnext" width="104" height="23" class="lazy"></a>
                      
                      <a href="https://startup.siliconindia.com/vendor/my-holiday-happiness-innovating-the-future-of-tourism-while-prioritizing-customer-satisfaction-cid-20513.html" target="_blank"><img width="104" height="42"   class="lazy" src="#" data-src="<?php echo base_url(); ?>assets/images/startupcity-logo.jpg" alt="startupcity" style="margin-left: 20px;"></a>
                    <a href="https://corporateconnectglobal.com/category/impact-recognition-indias-highly-trusted-tours-travels-agency-to-watchout-2024/" target="_blank"><img  class="lazy" src="#" data-src="<?php echo base_url(); ?>assets/images/corporateconnectglobal.jpeg" alt="corporateconnectglobal" width="104" height="24" ></a>
                      
                    </div>
                    
                    <div class="clearfix"></div>

                    <div class="col-md-12 footerhr2">
                        <hr>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-12 copyrightcontainer text-center">
                        Copyright &copy; <?php echo date("Y"); ?> Myholidayhappiness.com. All Rights Reserved
                        
                    </div>
                    
                </div>
            </div>
            <img src="#" data-src="<?php echo base_url(); ?>assets/images/footer_bg.jpg" class="img-fluid footerbg lazy"  alt="footer_bg">
            
        </footer>
        <?php if($this->uri->segment(1)=='contactus'){ ?>
        <script src="https://code.jquery.com/jquery-1.9.1.min.js "></script>
        <?php } else { ?>
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.slim.min.js"  type="text/javascript" ></script>
        <?php } ?>
        <script  type="text/javascript"   src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

        <script>var base_url = "<?php echo base_url(); ?>";</script>
        <script src="<?php echo base_url(); ?>assets/js/menu.js"></script>
        <script>
        
        	
            $(function () {
               // $('.selectpickertest').selectpicker();
            });
       
       
            $(document).ready(function () {
                $(".googlereview-close").click(function () {
                    $(".ratingholder").hide();
                });
            });
            
             $(document).ready(function () {
                setTimeout(function(){
				  $(".ratingholder").show();
				}, 10000);
            });
            
            jQuery(function ($) {
                $('.droopmenu-navbar').droopmenu({
                    dmAnimationEffect: 'dmslideup'
                });
            });
        </script>  

        <script>
			// Sticky navbar
			// =========================
            $(document).ready(function () {
                // Custom function which toggles between sticky class (is-sticky)
                var stickyToggle = function (sticky, stickyWrapper, scrollElement) {
                    var stickyHeight = sticky.outerHeight();
                    var stickyTop = stickyWrapper.offset().top;
                    if (scrollElement.scrollTop() >= stickyTop) {
                        stickyWrapper.height(stickyHeight);
                        sticky.addClass("is-sticky");
                    } else {
                        sticky.removeClass("is-sticky");
                        stickyWrapper.height('auto');
                    }
                };

                // Find all data-toggle="sticky-onscroll" elements
                $('[data-toggle="sticky-onscroll"]').each(function () {
                    var sticky = $(this);
                    var stickyWrapper = $('<div>').addClass('sticky-wrapper'); // insert hidden element to maintain actual top offset on page
                    sticky.before(stickyWrapper);
                    sticky.addClass('sticky');

                    // Scroll & resize events
                    $(window).on('scroll.sticky-onscroll resize.sticky-onscroll', function () {
                        stickyToggle(sticky, stickyWrapper, $(this));
                    });

                    // On page load
                    stickyToggle(sticky, stickyWrapper, $(window));
                });
            });
        </script>
		
		<script>
		    $('#header_search').change(function() {
			   var destination = this.value; 
			   
			   var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
					csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
			   var dataJson = { [csrfName]: csrfHash, "destinationurl": destination };
			   
			   $.ajax({
                    url: base_url+"about/getstateurl",
                    type: 'post',
                    data: dataJson,                     
                    success: function(result) {
                        window.location.href = base_url+"destination/" + result + "/" + destination;                  
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                    }
                });				
		    });

            $('#searchDestination').change(function() {
			    var destination = (this.value).trim(); 

                if(destination != ""){			   
                    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
                        csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
                    var dataJson = { [csrfName]: csrfHash, "destination": destination };
                
                    $.ajax({
                        url: base_url+"home/getDuration",
                        type: 'post',
                        data: dataJson,                     
                        success: function(result) {
                            $('#searchDuration').html(result);
                            $('.selectpicker').selectpicker('refresh');          
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                        }
                    });		
                } else {
                    $('#searchDuration').html('<option value="">Select Duration</option>');   
                    $('.selectpicker').selectpicker('refresh'); 
                }
		    });
		    
        function lazyLoad() {
           
            document.addEventListener("DOMContentLoaded", function() {
                var a; 
                if ("IntersectionObserver" in window) {
                    
                    a = document.querySelectorAll(".lazy");
                    var b = new IntersectionObserver(function(a) {
                        a.forEach(function(a) {
                            if (a.isIntersecting) {
                                var c = a.target;
                                /*if (navigator.userAgent.indexOf("Chrome") != -1) {
        
                                } else if (navigator.userAgent.indexOf("Safari") != -1) {
                                    c.dataset.src = c.dataset.src.replace(".webp", ".png");
                                } else if (navigator.userAgent.indexOf("MSIE") != -1) {
                                    c.dataset.src = c.dataset.src.replace(".webp", ".png");
                                }*/
                                c.src = c.dataset.src, c.classList.remove("lazy"), b.unobserve(c)
                            }
                        })
                    });
                    a.forEach(function(a) {
                        b.observe(a)
                    })
                } else {
                    function b() {
                        c && clearTimeout(c), c = setTimeout(function() {
                            var c = window.pageYOffset;
                            a.forEach(function(a) {
                                a.offsetTop < window.innerHeight + c && (a.src = a.dataset.src, a.classList.remove("lazy"))
                            }), 0 == a.length && (document.removeEventListener("scroll", b), window.removeEventListener("resize", b), window.removeEventListener("orientationChange", b))
                        }, 20)
                    }
                    var c;
                    a = document.querySelectorAll(".lazy"), document.addEventListener("scroll", b), window.addEventListener("resize", b), window.addEventListener("orientationChange", b)
                }
            });
            
            document.addEventListener("DOMContentLoaded", function() {
              var lazyBackgrounds = [].slice.call(document.querySelectorAll(".lazy-background"));
            
              if ("IntersectionObserver" in window) {
                let lazyBackgroundObserver = new IntersectionObserver(function(entries, observer) {
                  entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                      entry.target.classList.add("visible");
                      lazyBackgroundObserver.unobserve(entry.target);
                    }
                  });
                });
            
                lazyBackgrounds.forEach(function(lazyBackground) {
                  lazyBackgroundObserver.observe(lazyBackground);
                });
              }
            });
        
        }
        lazyLoad();
		</script>
		
