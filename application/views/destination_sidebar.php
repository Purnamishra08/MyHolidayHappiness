<?php $dessegment = $this->uri->segment(1); ?>
<nav class='leftsidemenulist mb-4' >
    <ul>
        <?php if($dessegment == "destination"){ ?>
		<li id="pscroll"><a href="javascript:void(0)"><?php echo $destiname; ?> overview</a></li>
		<?php } else { ?>
		<li id="pscroll"><a href="<?php echo base_url() . 'destination/' . $stateurl . '/' . $destination_url; ?>"><?php echo $destiname; ?> overview</a></li>
		<?php } ?>
        
		<?php if ($noof_places_in_destination > 0) { ?>
            <li><a href="<?php echo base_url() . 'places-to-visit/' . $stateurl . '/' . $destination_url; ?>">Top <?php echo $noof_places_in_destination; ?> places to visit in <?php echo $destiname; ?></a></li>
        <?php } ?>
        <?php if (!empty($noof_popup_packages)) { ?>
            <li><a href="<?php echo base_url() . 'destination-package/' . $destination_url; ?>"><?php echo $noof_popup_packages; ?> Tour Package(s) from <?php echo $this->Common_model->currency; ?><?php echo $tourPackMinPrice; ?></a></li>
        <?php } ?>
    </ul>
</nav>

<?php echo $google_map; ?>

<div class="mapbtmdescp">
    <h5>Other Info</h5>
    <ul class="placelist">
        <?php if ($internet_availability != "") { ?>
            <li>Internet Availability:<span><?php echo $internet_availability; ?></span></li>
        <?php } ?>
        <?php if ($std_code != "") { ?>
            <li>STD Code:<span><?php echo $std_code; ?></span></li>
        <?php } ?>
        <?php if ($language_spoken != "") { ?>
            <li>Languages Spoken:<span><?php echo $language_spoken; ?></span></li>
        <?php } ?>
        <?php if ($major_festivals != "") { ?>
            <li>Major Festivals:<span><?php echo $major_festivals; ?></span></li>
        <?php } ?>
        <li>Notes/Tips:<span><?php echo ($note_tips != "") ? $note_tips : "None"; ?></span></li>
    </ul>
</div>
<div class="mobile-hidden">
    <?php
    $noof_near_places = $this->Common_model->noof_records("a.dest_placeid", "tbl_destination_places as a, tbl_destination as b", "a.simdest_id=b.destination_id and a.destination_id=$destination_id and a.type=2 and b.status=1");
    if ($noof_near_places > 0) {
        ?>
        <div class="thumbplaces">
            <h5 class="mt-5 mb-2">Near by places</h5>
            <div class="row">
                <?php
                $count = 1;
                $near_places = $this->Common_model->join_records("a.*, b.destination_url, b.destination_name, b.destiimg_thumb, b.alttag_thumb, b.state", "tbl_destination_places as a", "tbl_destination as b", "a.simdest_id=b.destination_id", "a.destination_id=$destination_id and a.type=2 and b.status=1", "b.destination_name asc");
                foreach ($near_places as $nearplace) {
                    $place_destinationurl = $nearplace['destination_url'];
                    $place_stateid = $nearplace['state'];
                    $alttag_thumb = $nearplace['alttag_thumb'];
                    $place_state_url = $this->Common_model->showname_fromid("state_url", "tbl_state", "state_id ='$place_stateid'");
                    ?>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-2 nearplacesbox">
                        <a href="<?php echo base_url() . 'destination/' . $place_state_url . '/' . $place_destinationurl; ?>" target="_blank"> 
                            <div class="thumbimgholder">
                                <img src="<?php echo base_url() . "uploads/" . $nearplace['destiimg_thumb']; ?>" class="img-fluid" alt="<?php echo (!empty($alttag_thumb)) ? $alttag_thumb : $nearplace['destination_name']; ?>">
                                <div class="thumbheadingname"><?php echo $nearplace['destination_name']; ?></div>
                            </div>                                            
                        </a>
                    </div>
                    <?php if ($count % 2 == 0): ?><div class="clearfix"></div><?php endif; ?>
                    <?php $count++;
                }
                ?>
            </div>
        </div>
    <?php } ?>

    <?php
    $noof_similar_dest = $this->Common_model->noof_records("a.dest_placeid", "tbl_destination_places as a, tbl_destination as b", "a.simdest_id=b.destination_id and a.destination_id=$destination_id and a.type=1 and b.status=1");
    if ($noof_similar_dest > 0) {
	?>
        <div class="thumbplaces">
            <h5 class="mt-5 mb-2">Similar destinations</h5>
            <div class="row">
                <?php
                $count1 = 1;
                $similar_dests = $this->Common_model->join_records("a.*, b.destination_url, b.destination_name, b.destiimg_thumb, b.alttag_thumb, b.state", "tbl_destination_places as a", "tbl_destination as b", "a.simdest_id=b.destination_id", "a.destination_id=$destination_id and a.type=1 and b.status=1", "b.destination_name asc");

                foreach ($similar_dests as $similardest) {
                    $dest_destinationurl = $similardest['destination_url'];
                    $dest_stateid = $similardest['state'];
                    $salttag_thumb = $similardest['alttag_thumb'];
                    $dest_state_url = $this->Common_model->showname_fromid("state_url", "tbl_state", "state_id ='$dest_stateid'");
				?>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-2 nearplacesbox">
                        <a href="<?php echo base_url() . 'destination/' . $dest_state_url . '/' . $dest_destinationurl; ?>" target="_blank"> 
                            <div class="thumbimgholder">
                                <img src="<?php echo base_url() . "uploads/" . $similardest['destiimg_thumb']; ?>" class="img-fluid" alt="<?php echo (!empty($salttag_thumb)) ? $salttag_thumb : $similardest['destination_name']; ?>">
                                <div class="thumbheadingname"><?php echo $similardest['destination_name']; ?></div>
                            </div>                                            
                        </a>
                    </div> 

                    <?php if ($count1 % 2 == 0): ?><div class="clearfix"></div><?php endif; ?>
				<?php $count1++; } ?>		
            </div>
        </div>
	<?php } ?>

    <div class="rightbookingbox">
        <h3>Get our assistance for easy booking</h3>
        <a href="<?php echo base_url().'contactus#contactform'; ?>" target="_blank"><span class="cullusbtn">Want us to call you?</span></a>
        <p>Or call us at</p>
        <h5> <?php echo $this->Common_model->show_parameter(3); ?> </h5>
    </div>
</div>
