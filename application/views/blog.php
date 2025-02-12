<?php
$showsearch = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
?>

<!doctype html>
<html>
    <head>
        <?php include("head.php"); ?>

    </head>
    <body>
        <?php include("header.php"); ?> 

        <img src="<?php echo base_url(); ?>assets/images/delhicity.jpg" class="img-fluid" alt=""/>



        <section class="mt80 mb100">
            <div class="container">
                <ul class="cbreadcrumb">
                 
                  <li><a href="/">Home</a></li>
                  <li><a href="#">Blogs</a></li>
                </ul>
                <div class="row">
                    <div class="col-lg-8">

                        <?php if ($showsearch) { ?><div class="mt30 col-lg-12" id="searchareabox"> <h4>Search for :  <?php echo $showsearch; ?></h4> </div><?php } ?>
                        <?php
                        $cnt = 0;
                        if (!empty($row)) {
                            $countrow = count($row);
                            foreach ($row as $rows) {
                                //echo "asdfasdfasdfasd-".$cnt;
                                $disid = $rows['blogid'];
                                $title = $rows['title'];
                                $dis_image = $rows['image'];
                                $alttag_image = $rows['alttag_image'];
                                $contents = $rows['content'];
                                $blog_url = $rows['blog_url'];
                                $show_comments = $rows['show_comment'];
                                $status = $rows['status'];
                                $date = $rows['created_date'];
                                $sess_userid = $rows['created_by'];
                                $cnt++;
                                $c_cnt = $cnt % 3;
                                ?>

                                <?php if ($c_cnt == 1 || $c_cnt == 2) { ?>
                                    <div class="mt30 mb30 <?php
                                    if ($c_cnt == 2) {
                                        echo 'row';
                                    }
                                    ?>">
                                         <?php } ?>

                                    <?php
                                    if ($c_cnt != 1) {
                                        echo '<div class="col-md-6">';
                                    }
                                    ?>
                                    <div class="blogsection">
                                        <div class="blogimg"><a href="<?php echo base_url() . 'blog/' . $blog_url; ?>"><?php if (file_exists("./uploads/" . $dis_image) && ($dis_image != '')) {
                                        ?><img src="<?php echo base_url() . 'uploads/' . $dis_image; ?>" class="img-fluid" alt="<?php echo (!empty($alttag_image)) ? $alttag_image : "My Holiday Happiness"; ?>" ><?php } ?></a></div>
                                        <h1><a href="<?php echo base_url() . 'blog/' . $blog_url; ?>"><?php echo $title; ?></a></h1>
                                        <div class="postlist">
                                            <span class="postdetails"> <i class="fa fa-calendar-o"></i><?php echo date('dS F , Y', strtotime($date)); ?></span> 
                                            <?php if ($show_comments == "1") { ?><span class="postdetails">  <i class="fa fa-comment-o"></i><?php echo $noofcomments = $this->Common_model->noof_records("commentid", "tbl_comments", "status='1' and blogid='$disid'"); ?> Comments</span><?php } ?></div>
                                        <p class="blogcontent"><?php echo $this->Common_model->short_str($contents, 140); ?></p>
                                        <div class="read-more">
                                            <a href="<?php echo base_url() . 'blog/' . $blog_url; ?>" title="Read More">Read More<i class="fa fa-angle-right"></i></a>
                                        </div>              
                                    </div>
                                    <?php
                                    if ($c_cnt != 1) {
                                        echo '</div>';
                                    }
                                    ?>

                                    <?php if ($c_cnt != 2 || $countrow == $cnt) { ?>
                                        <div class="clearfix"></div>
                                    </div>
                                    <hr>
                                <?php } ?>

                                <?php
                            }
                        } else {
                            ?> 
                            <div class="mt30 mb30 row">
                                <div class="noblogpost">Sorry, no blog posts found.</div>

                            </div>

                            <?php
                        }
                        ?>


                        <div class="clearfix"></div>

                    </div>

                    <div class="col-lg-4 blogrght">
                        <?php include ( "blog_sidebar.php" ); ?>
                    </div>


                    <div class="clearfix"></div>


                </div>
                <div class="clearfix"></div>
                <?php echo $pagination; ?>
            </div>
        </div>
    </section>


    <?php include("footer.php"); ?>  
     
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    
    
        <script>
            $(function () {
                $('.selectpicker').selectpicker();
            });
        </script>  

</body>
</html>