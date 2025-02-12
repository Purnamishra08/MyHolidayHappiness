  <?php
  $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
  ?>

		       <form class="searchbx mb50" method="get" action="<?php echo base_url().'blog'; ?>">
					<div class=" col-md-12 srchbx"><div class="form-group">
			<input type="text" class="form-control" placeholder="Search" name="search"  value="<?php echo $search;?>" autocomplete="off">
					</div></div>
					<div class=" col-md-12 srchbtn"><button type="submit" class="btn btn-default srchsubmit" >Search Here</button></div><div class="clearfix"></div>
				  </form>

				  <h4>Recent Blogs</h4>

                                <?php
   $datarecent = $this->Common_model->get_records("*","tbl_blog","status='1'","blogid DESC","4","0");
    if( !empty($datarecent) )
             {
      foreach ($datarecent as $datarecents)
      {
      $pdisid = $datarecents['blogid'];
      $stitle = $datarecents['title'];
      $dis_image = $datarecents['image'];
      $alttag_image = $datarecents['alttag_image'];
      $contents = $datarecents['content'];
       $blog_url = $datarecents['blog_url'];
       $show_comments = $datarecents['show_comment'];
      $sdate = $datarecents['created_date'];
            ?>
				  <div class="row sideblog mt20 mb20">
				    <div class="col-md-6"><a href="<?php echo base_url().'blog/'.$blog_url; ?>"><?php if(file_exists("./uploads/".$dis_image) && ($dis_image!=''))
                                 {?><img src="<?php echo base_url().'uploads/'.$dis_image; ?>" class="img-fluid" alt="<?php echo (!empty($alttag_image)) ? $alttag_image : "My Holiday Happiness"; ?>"><?php } ?></a></div>
					<div class="col-md-6"><h5><a href="<?php echo base_url().'blog/'.$blog_url; ?>"><?php echo $stitle; ?></a></h5></div><div class="clearfix"></div>	
                       <div class="postlist">
				                      <span class="postdetails"> <i class="fa fa-calendar-o"></i><?php echo date('dS F , Y', strtotime($sdate)); ?></span> 
									  <?php if($show_comments=="1") { ?><span class="postdetails">  <i class="fa fa-comment-o"></i><?php echo $noofcomments = $this->Common_model->noof_records("commentid","tbl_comments","status='1' and blogid='$pdisid'");?> Comments</span> <?php } ?></div>					
				  </div>
				  <?php
                                }
                                }?>
	
				  <div class="clearfix"></div>
				  
				   <h4 class="mt50">Archieve</h4>
				   <?php
$reportdtls = $this->db->query("select DISTINCT DATE_FORMAT(created_date, '%Y-%m') as created_dates from tbl_blog where status='1'");
             
              $archive=$reportdtls->result();
              
     if( !empty($archive) )
             {
      foreach ($archive as $archives)
      {
      
      $date = $archives->created_dates;
      $noofrecsperdt = $this->Common_model->noof_records("blogid","tbl_blog","DATE_FORMAT(created_date, '%Y-%m')='$date' and status='1'");
     
      ?>
				 <!--  <ul class="archievelist">
				     <li><i class="fa fa-check-circle"></i><a href="#">April , 2018 (6)</a></li>
					  <li><i class="fa fa-check-circle"></i><a href="#">March , 2018 (1)</a></li>
					   <li><i class="fa fa-check-circle"></i><a href="#">January , 2018(5)</a></li>
					    <li><i class="fa fa-check-circle"></i><a href="#">December , 2018 (6)</a></li>
					  <li><i class="fa fa-check-circle"></i><a href="#">November , 2018 (1)</a></li>
					   <li><i class="fa fa-check-circle"></i><a href="#">January , 2018(5)</a></li>
				   </ul>-->

				   <ul class="archievelist">
				     <li><i class="fa fa-check-circle"></i><a href="<?php echo base_url().'blog?archive='.$date;?>"><?php echo date(' F , Y', strtotime($date)); ?> <span>(<?php echo $noofrecsperdt;  ?>)</span> </a></li>
					  
				   </ul>

<?php
          }
        }
            ?>
				
