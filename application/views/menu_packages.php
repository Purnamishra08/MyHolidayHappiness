<?php
 if (!empty($cat_slug)) {
    foreach ($tag_data as $allTpackage) {
                            
    $cat_name = $allTpackage['cat_name'];
    $cat_seomenu = $this->Common_model->makeSeoUrl($cat_name);
    break;

 } 
     
 }else{
    $cat_name = "Tours";
    $cat_seomenu = "tours";
 }
 ?>

<!doctype html>
<html>
    <head>
        <?php include("head.php"); ?> 




    </head>
    <body>
        <?php include("header.php"); ?> 

        <section class="main">
            <div id="ri-grid" class="ri-grid ri-grid-size-2 ">
                <img class="ri-loading-image" src="<?php echo base_url(); ?>assets/images/loading.gif" alt="My Holiday Happiness"/>
                <ul>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/1.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/2.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/3.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/4.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/5.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/6.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/7.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/8.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/9.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/10.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/11.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/12.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/13.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/14.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/15.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/16.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/17.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/18.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/19.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/20.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/21.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/22.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/23.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/24.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/25.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/26.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/27.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/28.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/29.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/30.jpg" alt="My Holiday Happiness"/></a></li>

                </ul>
            </div>              
        </section>


       

        <section class="bg01" style="padding-top:10px">
             <div class="container">
            <ul class="cbreadcrumb mt-3">
                 
                  <li><a href="/">Home</a></li>
                  <li><a href="/tours">Tours</a></li>
                   <?php if (!empty($cat_slug)) { ?> <li><a href="#"><?php echo $cat_name?></a></li>  <?php }?>
                </ul>
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class="inner-topsearch-box text-center" style="background:transparent;padding: 15px 25px;">
                        <h1>Explore <?php if (!empty($cat_slug)) { ?> <?php echo $cat_name?> across India  <?php }else{?> popular destinations packages in India <?php }?></h1>                 
                       
                    </div>
                </div>
                <div class="col-lg-2"></div>
                <div class="clearfix"></div>              
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h2><?php echo $cat_name?></h2>
                        <p class="headingcontent">check out our best promotion tours!</p>
                    </div>
                    <div class="clearfix"></div>

                    <?php
                    if (!empty($tag_data)) {
                        foreach ($tag_data as $allTpackage) {
                            $tagid = $allTpackage['tagid'];
                            $tag_name = $allTpackage['tag_name'];
                            $tag_url = $allTpackage['tag_url'];
                            $menutagthumb_img = $allTpackage['menutagthumb_img'];
                            $menutagalttag_thumb = $allTpackage['alttag_thumb'];
                            $cat_name = $allTpackage['cat_name'];
                            $cat_seomenu = $this->Common_model->makeSeoUrl($cat_name);

                            $noof_popular_tourpackages = $this->Common_model->noof_records("DISTINCT(a.type_id) as package_id", "tbl_tags as a, tbl_tourpackages as b", "a.type_id = b.tourpackageid and a.tagid ='$tagid' and a.type=3 and b.status=1");

                            $tourpackages_MinPrice = $this->Common_model->showname_fromid("MIN(b.price)", "tbl_tags as a, tbl_tourpackages as b", "a.type_id=b.tourpackageid and a.tagid ='$tagid' and a.type=3 and b.status=1");
                            ?>
                            <div class="col-xl-3 col-lg-4 col-md-6 touristlist-box">
                                <div class="tour-item">

                                    <h3 class="tour-heading"><a href="<?php echo base_url().'tours/'.$cat_seomenu.'/'.$tag_url; ?>" target="_blank"><?php echo $tag_name; ?></a></h3>
                                    <div class="tour-head">
                                        <?php
                                        if (file_exists("./uploads/" . $menutagthumb_img) && ($menutagthumb_img != '')) {
                                            $menutagthumb_img = base_url() . "uploads/" . $menutagthumb_img;
                                        } else
                                            $menutagthumb_img = base_url() . "assets/images/noimgavail.jpg";
                                        ?>
                                        <a href="<?php echo base_url().'tours/'.$cat_seomenu.'/'.$tag_url; ?>" target="_blank">
                                            <img src="<?php echo $menutagthumb_img; ?>" alt="Tour Package" class="img-fluid" alt="<?php echo (!empty($menutagalttag_thumb)) ? $menutagalttag_thumb : $tag_name; ?>">
                                        </a>
                                        <div class="explore hometag"><?php echo $noof_popular_tourpackages; ?>Tour Packages</div>
                                    </div>

                                    <div class="tour-content">

                                        <div class="tour-sub-content">
                                            <span style="font-size:15px;">Tour Starts From</span> 
                                            <span class="packageCost"><?php echo $this->Common_model->currency; ?><?php echo $tourpackages_MinPrice; ?></span>
                                        </div>

                                        <div class="tourbutton"><a href="<?php echo base_url().'tours/'.$cat_seomenu.'/'.$tag_url; ?>" class="viwebtn" target="_blank">View details</a></div>

                                        <div class="tourprice">									                                    
                                            <ul class="iconlist">
                                                <li><img src="<?php echo base_url(); ?>assets/images/bed.png" title="Accomodation" alt="Accomodation"></li>
                                                <li><img src="<?php echo base_url(); ?>assets/images/car.png" title="Transportation" alt="Transportation"></li>
                                                <li><img src="<?php echo base_url(); ?>assets/images/binoculars.png" title="Sightseeing" alt="Sightseeing"></li>	
                                                <li><img src="<?php echo base_url(); ?>assets/images/cutlery.png" title="Breakfast" alt="Breakfast"></li>
                                                <li><img src="<?php echo base_url(); ?>assets/images/waterbtl.png" title="Water Bottle" alt="Water Bottle"></li>
                                            </ul>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    }
                    ?>                  
                </div>


            </div>

        </section>



        <section class="destinationsection mb100">
            <div class="destinationtop">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        $topdesti1s = $this->Common_model->get_records("destiimg_thumb,state,destination_url,destination_name,alttag_thumb", "tbl_destination", "status='1' and desttype_for_home='18'", "destination_name asc", "6", "0");
                        if (!empty($topdesti1s)) {
                            foreach ($topdesti1s as $topdesti1) {
                                $desti_thumb1 = $topdesti1['destiimg_thumb'];
                                $stateid = $topdesti1['state'];
                                $alttag_thumb1 = $topdesti1['alttag_thumb'];
                                $state_url = $this->Common_model->showname_fromid("state_url", "tbl_state", "state_id ='$stateid'");

                                if (file_exists("./uploads/" . $desti_thumb1) && ($desti_thumb1 != '')) {
                                    $desti_thumb1 = base_url() . "uploads/" . $desti_thumb1;
                                } else
                                    $desti_thumb1 = base_url() . "assets/images/noimgavail.jpg";
                                ?> 
                                <div class="col-lg-2 col-md-6 destinationholder">
                                    <a href="<?php echo base_url() . 'destination/' . $state_url . '/' . $topdesti1['destination_url']; ?>" target="_blank">
                                        <div class="newimg">
                                            <img src="<?php echo $desti_thumb1; ?>" alt="Destination Image" alt="<?php echo (!empty($alttag_thumb1)) ? $alttag_thumb1 : $topdesti1['destination_name']; ?>">
                                        </div>
                                        <div class="padcontent">
                                            <p><?php echo $topdesti1['destination_name']; ?></p>
                                        </div>
                                    </a>
                                </div>
                            <?php
                            }
                        }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>


            <div class="destinationmiddle">
                <div class="container-fluid">
                    <div class="row">

                        <?php
                        $topdesti2s = $this->Common_model->get_records("destiimg_thumb,state,destination_url,destination_name,alttag_thumb", "tbl_destination", "status='1' and desttype_for_home='18'", "destination_name asc", "2", "6");
                        if (!empty($topdesti2s)) {
                            foreach ($topdesti2s as $topdesti2) {
                                $destiimg_thumb2 = $topdesti2['destiimg_thumb'];
                                $alttag_thumb2 = $topdesti2['alttag_thumb'];
                                $stateidb = $topdesti2['state'];
                                $state_urlb = $this->Common_model->showname_fromid("state_url", "tbl_state", "state_id ='$stateidb'");

                                if (file_exists("./uploads/" . $destiimg_thumb2) && ($destiimg_thumb2 != '')) {
                                    $destiimg_thumb2 = base_url() . "uploads/" . $destiimg_thumb2;
                                } else
                                    $destiimg_thumb2 = base_url() . "assets/images/noimgavail.jpg";
                                ?>     

                                <div class="col-lg-2 destinationholder">
                                    <a href="<?php echo base_url() . 'destination/' . $state_url . '/' . $topdesti2['destination_url']; ?>" target="_blank">
                                        <div class="newimg">
                                            <img src="<?php echo $destiimg_thumb2; ?>" alt="Destination Image" alt="<?php echo (!empty($alttag_thumb2)) ? $alttag_thumb2 : $topdesti2['destination_name']; ?>">
                                        </div>
                                        <div class="padcontent">
                                            <p><?php echo $topdesti2['destination_name']; ?> </p>
                                        </div>
                                    </a>
                                </div>

    <?php }
}
?>


                        <div class="col-md-4 destinationcontent text-center">
                            <h3>Our top Destinations</h3>
                            <a href="<?php echo base_url() . 'destinations' ?>" class="morebutton" target="_blank">View all destinations</a>
                        </div>
                        <?php
                        $topdesti3s = $this->Common_model->get_records("destiimg_thumb,state,destination_url,destination_name,alttag_thumb", "tbl_destination", "status='1' and desttype_for_home='18'", "destination_name asc", "2", "8");
                        if (!empty($topdesti3s)) {
                            foreach ($topdesti3s as $topdesti3) {
                                $destiimg_thumb3 = $topdesti3['destiimg_thumb'];
                                $stateida = $topdesti3['state'];
                                $alttag_thumb3 = $topdesti3['alttag_thumb'];
                                $state_urla = $this->Common_model->showname_fromid("state_url", "tbl_state", "state_id ='$stateida'");

                                if (file_exists("./uploads/" . $destiimg_thumb3) && ($destiimg_thumb3 != '')) {
                                    $destiimg_thumb3 = base_url() . "uploads/" . $destiimg_thumb3;
                                } else
                                    $destiimg_thumb3 = base_url() . "assets/images/noimgavail.jpg";
                                ?>  
                                <div class="col-md-2 destinationholder">
                                    <a href="<?php echo base_url() . 'destination/' . $state_url . '/' . $topdesti3['destination_url']; ?>" target="_blank">
                                        <div class="newimg">
                                            <img src="<?php echo $destiimg_thumb3; ?>" alt="Destination Image" alt="<?php echo (!empty($alttag_thumb3)) ? $alttag_thumb3 : $topdesti3['destination_name']; ?>">
                                        </div>
                                        <div class="padcontent">
                                            <p><?php echo $topdesti3['destination_name']; ?></p>
                                        </div>
                                    </a>
                                </div>
    <?php }
}
?>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </section>

<?php include("footer.php"); ?> 		
        <script src="https://code.jquery.com/jquery-1.9.1.min.js "></script>     
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.gridrotator.js"></script>
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
    </body>
</html>
