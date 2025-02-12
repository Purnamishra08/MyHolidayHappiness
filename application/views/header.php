<style>
    .float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:40px;
	right:40px;
/*	background-color:#25d366;*/
	color:#FFF;
	border-radius:50px;
	text-align:center;
  font-size:30px;
	box-shadow: 2px 2px 3px #999;
  z-index:100;
}

.my-float{
	
		width:60px;
	height:60px;
}
</style>
<a href="https://api.whatsapp.com/send?phone=+919886525253&text=Hi%20there%2E" class="float" target="_blank" rel="nofollow">
<img src="<?php echo base_url(); ?>assets/images/whatsapp1.png" class=" my-float" alt="logo">
</a>   
    <header>
		<div class="topheader">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-1"></div>
					<div class="col-lg-5 col-md-7">
						<ul class="topleftlist">
							<li><a href="tel:+919886525253" rel="nofollow"><?php echo $this->Common_model->show_parameter(3); ?></a></li>
							<li><a href="mailto:support@myholidayhappiness.com" rel="nofollow"><?php echo $this->Common_model->show_parameter(2); ?></a></li>
						</ul>
					</div>

					<div class="col-lg-5 col-md-5">
						<ul class="toprightlist" id="header_account">
							<?php if(($this->session->userdata('customer_id') != "") && ($this->session->userdata('customer_id')>0)) { ?>
							<li><a href="<?php echo base_url()?>booking">Bookings</a></li>
							<li><a href="<?php echo base_url()?>profile">Profile</a></li>
							<li><a href="<?php echo base_url()?>logout">Log out</a></li>
							<?php } else { ?>
							<li><a href="<?php echo base_url()?>login">Login</a></li>
							<li><a href="<?php echo base_url()?>register">Sign Up</a></li>
							<?php } ?>
						</ul>
					</div>

					<div class="col-lg-1"></div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>

		<div class="logoheader" data-toggle="sticky-onscroll">
			<div class="container-fluid menuholder">
				<div class="droopmenu-navbar">
					<div class="droopmenu-inner">
						<div class="droopmenu-header">
							<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/logo.png" class="img-fluid" alt="logo"  width="202" height="78"></a>
							<a href="#" class="droopmenu-toggle"></a>
						</div>
						<div class="droopmenu-nav">
							<ul class="droopmenu">
								<li><a href="<?php echo base_url(); ?>">Home</a></li>
								<?php
									$menus = $this->Common_model->get_records("menuid, menu_name","tbl_menus","status=1 ","menuid DESC","","");
									if( !empty($menus) )
									{
										foreach ($menus as $menu)
										{
											$menu_id = $menu['menuid'];
											$menu_name = $menu['menu_name'];
											$seomenu_name = $this->Common_model->makeSeoUrl($menu_name);
								?>
								<li><a href="javascript:void(0)"><?php echo $menu_name; ?></a>
									<ul class="droopmenu-megamenu droopmenu-grid">
										<li class="droopmenu-tabs droopmenu-tabs-vertical">	
											<?php
											$submenus = $this->Common_model->get_records("*","tbl_menucateories","menuid=$menu_id and status=1 ","cat_name DESC","","");
											if( !empty($submenus) )
											{
												foreach ($submenus as $submenu)
												{
													$cat_id = $submenu['catid'];
													$submenu_id = $submenu['menuid'];
													$submenu_name = $submenu['cat_name'];
													$seocat_name = $this->Common_model->makeSeoUrl($submenu_name);
											?>	<!-- TAB ONE -->
											<div class="droopmenu-tabsection">
												<a href="javascript:void(0)" class="droopmenu-tabheader"><?php echo $submenu_name; ?></a>
												<div class="droopmenu-tabcontent">
													<div class="droopmenu-row">
														<ul class="droopmenu-col droopmenu-col8">
															<?php
															if(($menu_id == 1) || ($menu_id == 3))
															{
																$menutags = $this->Common_model->get_records("*","tbl_menutags","cat_id='$cat_id' and status=1","tag_name ASC","","");
																if( !empty($menutags))
																{
																	foreach ($menutags as $menutag)
																	{
																		$tagid = $menutag['tagid'];
																		$tag_name = $menutag['tag_name'];
																		$tag_url = $menutag['tag_url'];													  
															?>
																<?php if($menu_id == 1){?>
																<li><a href="<?php echo base_url().'getaways/'.$seocat_name.'/'.$tag_url; ?>"><?php echo $tag_name; ?></a></li>
																<?php } ?>
																
																<?php if($menu_id == 3){?>
																<li><a href="<?php echo base_url().'tours/'.$seocat_name.'/'.$tag_url; ?>"><?php echo $tag_name; ?></a></li>
																<?php } ?>
															<?php
																	}
																}
															}
															
															if($menu_id == 2)
															{
																$destitags = $this->Common_model->join_records("a.*, b.destination_url, b.destination_name, b.state","tbl_destination_cats as a","tbl_destination as b", "a.destination_id=b.destination_id", "a.cat_id='$cat_id' and b.status=1","b.destination_name asc");
																if( !empty($destitags))
																{
																	foreach ($destitags as $destitag)
																	{
																		$destcat_id = $destitag['destcat_id'];
																		$destinationname = $destitag['destination_name']; 
																		$destinationurl = $destitag['destination_url'];
																		$stateid = $destitag['state'];	
																		$state_url = $this->Common_model->showname_fromid("state_url","tbl_state","state_id ='$stateid'");
															?>
															<li><a href="<?php echo base_url().'destination/'.$state_url.'/'.$destinationurl; ?>"><?php echo $destinationname; ?></a></li>
															<?php } } } ?>
														</ul>
														<ul class="droopmenu-col droopmenu-col4 listimage"> 
															<li><img src="#" data-src="<?php echo base_url(); ?>assets/images/mahabaleshwar-destination.jpg" alt="Destination" class="img-fluid lazy"></li>
														</ul>                                                                                              
													</div>
												</div>
											</div>
											   <?php
												}
											}
											?>
											
											<?php if($menu_id == 2) { ?>
											<div class="droopmenu-tabsection">
												<a href="javascript:void(0)" class="droopmenu-tabheader">Explore States</a>
												<div class="droopmenu-tabcontent">
													<div class="droopmenu-row">
														<ul class="droopmenu-col droopmenu-col8">
															<?php
															$statetags = $this->Common_model->get_records("state_name, state_url","tbl_state","showmenu=1 and status=1","state_name asc");
																if( !empty($statetags))
																{
																	foreach ($statetags as $statetag)
																	{
																		$tag_state_name = $statetag['state_name']; 
																		$tag_state_url = $statetag['state_url'];
															?>
															<li><a href="<?php echo base_url().'state/'.$tag_state_url; ?>"><?php echo $tag_state_name; ?></a></li>
															<?php } } ?>
														</ul>
													</div>
												</div>
											</div>										
											<?php } ?>
										</li>
										
									</ul>
								</li>
								<?php
										}
									}
								?>      
								<li><a href="<?php echo base_url()?>blog">Blog<em class="droopmenu-topanim"></em></a></li>
								<li><a href="<?php echo base_url()?>contactus">contact us<em class="droopmenu-topanim"></em></a></li>
							</ul>
						</div>

						<!-- droopmenu-nav -->
						<div class="droopmenu-extra">
						    	<div class="dekstop-search1">
							<div class="droopmenu mt-3 search">
							<div class="form-group">
                                <select class="selectpicker" id="header_search" data-live-search="true" data-live-search-placeholder="Search" title="Search Destination" >
                                    <?php  echo $this->Common_model->populate_select("", "destination_url", "destination_name", "tbl_destination", "", "destination_name asc", ""); ?>
                                </select>
                            </div>								
							</div>
							</div>
							
						
						</div>
						
						
						
					</div>
				</div>
			</div>
		</div>
	</header>
