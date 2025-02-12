<!doctype html>
<html>
    <head>
        <?php include("head.php"); ?> 


    </head>
    <body>
        <?php include("header.php"); ?> 

        <section>
            <img src="<?php echo base_url(); ?>assets/images/destinationbanner.jpg" class="img-fluid">  
        </section>

        <section class="destinationsection mb100 mt-5">
            <div class="destinationtop">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12"><h2> Most popular destinations in India</h2></div>

                        <?php
                        if (!empty($allDestins)) {
                            foreach ($allDestins as $allDestin) {
                                $stateidc = $allDestin['state'];
                                $destiimg_thumb = $allDestin['destiimg_thumb'];
                                $destination_urlc = $allDestin['destination_url'];
                                $state_urlc = $this->Common_model->showname_fromid("state_url", "tbl_state", "state_id ='$stateidc'");
                                if (file_exists("./uploads/" . $destiimg_thumb) && ($destiimg_thumb != '')) {
                                    $destiimg = base_url() . "uploads/" . $destiimg_thumb;
                                } else
                                    $destiimg = base_url() . "assets/images/delhicity.jpg";
                                ?>
                                <div class="col-lg-3 col-md-6 singledestination destinationholder mb-3">
                                    <a href="<?php echo base_url().'destination/'.$state_urlc.'/'.$destination_urlc; ?>" target="_blank">
                                        <div class="newimg">
                                            <img src="<?php echo $destiimg; ?>" alt="Destination Image">
                                        </div>
                                        <div class="padcontent">
                                            <p><?php echo $allDestin['destination_name'] ?></p>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                        }
                        ?>

                    </div>
                    <?php echo $pagination; ?>
                </div>
            </div>    
        </section>



        <?php include("footer.php"); ?>      

    </body>
</html>
