<?php
$segment = $this->uri->segment(2);
$sub_segment = $this->uri->segment(3);
$allusermodules = $this->session->userdata('allpermittedmodules');
?>
<aside class="main-sidebar">
    <!-- sidebar -->
    <div class="sidebar">
        <!-- sidebar menu -->
        <ul class="sidebar-menu">

            <?php
            if ($segment == 'dashboard')
                $classactive = 'class="active"';
            else
                $classactive = "";
            ?>
            <li <?php echo $classactive; ?>>
                <a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-tachometer"></i><span>Dashboard</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>

            <?php
            if (in_array(1, $allusermodules)) {
                if ($segment == 'users')
                    $classactive = 'class="active"';
                else
                    $classactive = "";
            ?>
                <li <?php echo $classactive; ?>>
                    <a href="<?php echo base_url(); ?>admin/users">
                        <i class="fa fa-users"></i><span>Users</span>
                    </a>
                </li>
            <?php } ?>

            <?php
            if (in_array(5, $allusermodules)) {
                if ($segment == 'vehicletype' || $segment == 'vehicleprice') {
                    $collapse = "collapsed";
                    $show = "show";
                } else {
                    $collapse = "";
                    $show = "";
                }
            ?>
                <li data-toggle="collapse" data-target="#master-vehicletype" class="<?php echo $show; ?>">
                    <a href="javascript:void(0)"><i class="fa fa-truck"></i> Vehicles
                        <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse <?php echo $show; ?>" id="master-vehicletype">

                    <?php
                    if ($segment == 'vehicletype')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/vehicletype"><i class="fa fa-car"></i> Vehicle Type </a> </li>

                    <?php
                    if ($segment == 'vehicleprice')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/vehicleprice"><i class="fa fa-money "></i> Vehicle Price </a> </li>

                </ul>
            <?php
            }
            ?>

            <?php
            if (in_array(12, $allusermodules)) {
                if ($segment == 'hotel_type' || $segment == 'season_type' || $segment == 'hotel') {
                    $collapse = "collapsed";
                    $show = "show";
                } else {
                    $collapse = "";
                    $show = "";
                }
            ?>

                <li data-toggle="collapse" data-target="#master-hoteltype" class="<?php echo $show; ?>">
                    <a href="javascript:void(0)"><i class="fa fa-hotel"></i> Manage Hotels
                        <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse <?php echo $show; ?>" id="master-hoteltype">

                    <?php
                    if ($segment == 'hotel_type')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/hotel_type"><i class="fa fa-hotel"></i> Hotel Type </a> </li>

                    <?php
                    if ($segment == 'season_type')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/season_type"><i class="fa fa-hotel "></i> Season Type </a> </li>

                    <?php
                    if ($segment == 'hotel')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/hotel"><i class="fa fa-hotel "></i> Hotel </a> </li>

                </ul>
            <?php
            }
            ?>

            <?php
            if (in_array(6, $allusermodules)) {
                if ($segment == 'state' || $segment == 'destination' || $segment == 'destination_type' || $segment == 'places') {
                    $collapse = "collapsed";
                    $show = "show";
                } else {
                    $collapse = "";
                    $show = "";
                }
            ?>
                <li data-toggle="collapse" data-target="#location" class="<?php echo $show; ?>">
                    <a href="javascript:void(0)"><i class="fa fa-globe"></i> Location
                        <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse <?php echo $show; ?>" id="location">

                    <?php
                    if ($segment == 'state')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/state"><i class="fa fa-flag "></i> State</a> </li>

                    <?php
                    if ($segment == 'destination_type')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/destination_type"><i class="fa fa-map-marker "></i> Destination Type</a></li>

                    <?php
                    if ($segment == 'destination')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/destination"><i class="fa fa-map-marker "></i> Destinations</a> </li>

                    <?php
                    if ($segment == 'places')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/places"><i class="fa fa-bookmark"></i> Places</a> </li>

                </ul>
            <?php
            }
            ?>


            <?php
            if (in_array(11, $allusermodules)) {
                if ($segment == 'itinerary')
                    $classactive = 'class="active"';
                else
                    $classactive = "";
            ?>
                <li <?php echo $classactive; ?>>
                    <a href="<?php echo base_url(); ?>admin/itinerary">
                        <i class="fa fa-superpowers"></i><span>Itinerary</span>
                    </a>
                </li>
            <?php } ?>


            <?php
            if (in_array(8, $allusermodules)) {
                if ($segment == 'menutabs' || $segment == 'menutags') {
                    $collapse = "collapsed";
                    $show = "show";
                } else {
                    $collapse = "";
                    $show = "";
                }
            ?>
                <li data-toggle="collapse" data-target="#menu" class="<?php echo $show; ?>">
                    <a href="javascript:void(0)"><i class="fa fa-th-list"></i> Menus
                        <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse <?php echo $show; ?>" id="menu">

                    <?php
                    if ($segment == 'menutabs')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/menutabs"><i class="fa fa-gg"></i> Category </a> </li>

                    <?php
                    if ($segment == 'menutags')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/menutags"><i class="fa fa-tag"></i> Category Tags </a></li>
                </ul>
            <?php }
            ?>

            <?php
            if (in_array(10, $allusermodules)) {
                if ($segment == 'package_duration' || $segment == 'tour-packages' || $segment == 'tour_packages' || $segment == 'package-iternary') {
                    $collapse = "collapsed";
                    $show = "show";
                } else {
                    $collapse = "";
                    $show = "";
                }
            ?>
                <li data-toggle="collapse" data-target="#package" class="<?php echo $show; ?>">
                    <a href="javascript:void(0)"><i class="fa fa-ravelry"></i> Packages
                        <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse <?php echo $show; ?>" id="package">

                    <?php
                    if ($segment == 'package-duration')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/package_duration"><i class="fa fa-clock-o"></i> Package Durations </a> </li>

                    <?php
                    if ($segment == 'tpackages')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/tour-packages"><i class="fa fa-globe"></i> Tour packages </a></li>
                    <?php
                    if ($sub_segment == 'pdf-generator')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <!--  <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/tour-packages/pdf-generator"><i class="fa fa-globe"></i> Package PDF  </a></li>-->
                </ul>
            <?php } ?>
            <?php
            if($this->session->userdata('usertype') == 1) {
                if ($sub_segment == 'pdf-generator')
                    $classactive = 'class="active"';
                else
                    $classactive = "";
            ?>
            <li <?php echo $classactive; ?>>
                <a href="<?php echo base_url(); ?>admin/pdf/pdf-generator">
                    <i class="fa fa-file"></i><span> Package PDF</span>
                </a>
            </li>
            <?php } ?>


            <?php
            if (in_array(19, $allusermodules)) {
                if ($segment == 'bookings')
                    $classactive = 'class="active"';
                else
                    $classactive = "";
            ?>
                <li <?php echo $classactive; ?>>
                    <a href="<?php echo base_url(); ?>admin/bookings">
                        <i class="fa fa-book"></i><span>Bookings</span>
                    </a>
                </li>
            <?php } ?>


            <?php
            if (in_array(2, $allusermodules)) {
                if ($segment == 'general_settings')
                    $classactive = 'class="active"';
                else
                    $classactive = "";
            ?>
                <li <?php echo $classactive; ?>>
                    <a href="<?php echo base_url(); ?>admin/general_settings">
                        <i class="fa fa-cogs"></i><span>General settings</span>
                    </a>
                </li>
            <?php } ?>

            <?php
            if (in_array(3, $allusermodules)) {
                if ($segment == 'cms')
                    $classactive = 'class="active"';
                else
                    $classactive = "";
            ?>
                <li <?php echo $classactive; ?>>
                    <a href="<?php echo base_url(); ?>admin/cms">
                        <i class="fa fa-tasks"></i><span>CMS</span>
                    </a>
                </li>
            <?php } ?>

            <?php
                if ((in_array(4, $allusermodules)) || (in_array(15, $allusermodules)) || (in_array(18, $allusermodules))) {
                    if ($segment == 'enquiry' || $segment == 'itinerary-enquiry' || $segment == 'package-enquiry') {
                        $collapse = "collapsed";
                        $show = "show";
                    } else {
                        $collapse = "";
                        $show = "";
                    }
            ?>
                <li data-toggle="collapse" data-target="#enquiries" class="<?php echo $show; ?>">
                    <a href="javascript:void(0)"><i class="fa fa-user-o"></i> Enquiries
                        <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse <?php echo $show; ?>" id="enquiries">
                    <?php
                    if (in_array(4, $allusermodules)) {
                        if ($segment == 'enquiry')
                            $classactive = 'class="active"';
                        else
                            $classactive = "";
                    ?>
                        <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/enquiry"><i class="fa fa-clock-o"></i> Enquiry </a> </li>
                    <?php } ?>

                    <?php
                    if (in_array(15, $allusermodules)) {
                        if ($segment == 'itinerary-enquiry')
                            $classactive = 'class="active"';
                        else
                            $classactive = "";
                    ?>
                        <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/itinerary-enquiry"><i class="fa fa-question-circle "></i> Itinerary Enquiry </a></li>
                    <?php } ?>

                    <?php
                    if (in_array(18, $allusermodules)) {
                        if ($segment == 'package-enquiry')
                            $classactive = 'class="active"';
                        else
                            $classactive = "";
                    ?>
                        <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/package-enquiry"><i class="fa fa-globe"></i> Package Enquiry </a></li>
                    <?php } ?>
                </ul>
            <?php } ?>
<!-- 
                <li data-toggle="collapse" data-target="#followupEnquiries" class="<?php // echo $show; ?>">
                    <a href="javascript:void(0)"><i class="fa fa-user-o"></i> Follow Up Enquiries
                        <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse <?php // echo $show; ?>" id="followupEnquiries">
                    <li <?php // echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/sources"><i class="fa fa-question-circle"></i> Sources </a> </li>

                    <li <?php // echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/itinerary-enquiry"><i class="fa fa-clock-o"></i> Status List </a></li>

                    <li <?php // echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/package-enquiry"><i class="fa fa-globe"></i> Enquiries </a></li>
                </ul> -->


                <?php
            if (in_array(20, $allusermodules)) {
                if ($segment == 'status-list' || $segment == 'sources' || $segment == 'enquiries-entry' || $segment == 'enquiries-report') {
                    $collapse = "collapsed";
                    $show = "show";
                } else {
                    $collapse = "";
                    $show = "";
                }
            ?>

                <li data-toggle="collapse" data-target="#followupEnquiries" class="<?php echo $show; ?>">
                    <a href="javascript:void(0)"><i class=" fa fa-server"></i> Follow Up Enquiries
                        <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse <?php echo $show; ?>" id="followupEnquiries">
                    <?php
                    if ($segment == 'sources')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/sources"><i class="fa fa-cc"></i> Sources </a> </li>
                    <?php
                    if ($segment == 'status-list')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/status-list"><i class="fa fa-commenting-o "></i> Status List </a></li>

                    <?php
                    if ($segment == 'enquiries-entry')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/enquiries-entry"><i class="fa fa-cc"></i> Enquiries Entry </a> </li>
                    <?php
                    if ($segment == 'enquiries-report')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/enquiries-report"><i class="fa fa-commenting-o "></i> Enquiries Report </a></li>
                </ul>
            <?php }
            ?>

            <?php
            if (in_array(13, $allusermodules)) {
                if ($segment == 'review')
                    $classactive = 'class="active"';
                else
                    $classactive = "";
            ?>
                <li <?php echo $classactive; ?>>
                    <a href="<?php echo base_url(); ?>admin/review">
                        <i class="fa fa-comment-o"></i><span>Reviews</span>
                    </a>
                </li>
            <?php } ?>

            <?php
            if (in_array(16, $allusermodules)) {
                if ($segment == 'faqs' || $segment == 'packagefaqs') {
                    $collapse = "collapsed";
                    $show = "show";
                } else {
                    $collapse = "";
                    $show = "";
                }
            ?>
                <li data-toggle="collapse" data-target="#master-faq" class="<?php echo $show; ?>">
                    <a href="javascript:void(0)"><i class="fa fa-question"></i> Faqs
                        <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse <?php echo $show; ?>" id="master-faq">

                    <?php
                    if ($segment == 'faqs')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/faqs"><i class="fa fa-question"></i> Common Faqs </a> </li>

                    <?php
                    if ($segment == 'packagefaqs')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/packagefaqs"><i class="fa fa-question-circle "></i> Package Faqs </a> </li>

                </ul>
            <?php
            }
            ?>

            <?php
            if (in_array(17, $allusermodules)) {
                if ($segment == 'season_destination')
                    $classactive = 'class="active"';
                else
                    $classactive = "";
            ?>
                <li <?php echo $classactive; ?>>
                    <a href="<?php echo base_url(); ?>admin/season-destination 	">
                        <i class="fa fa-picture-o"></i><span> Season Destination </span>
                    </a>
                </li>
            <?php } ?>


            <?php
            if (in_array(14, $allusermodules)) {
                if ($segment == 'blog' || $segment == 'comments') {
                    $collapse = "collapsed";
                    $show = "show";
                } else {
                    $collapse = "";
                    $show = "";
                }
            ?>

                <li data-toggle="collapse" data-target="#blog" class="<?php echo $show; ?>">
                    <a href="javascript:void(0)"><i class=" fa fa-cc-diners-club"></i> Blog
                        <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse <?php echo $show; ?>" id="blog">
                    <?php
                    if ($segment == 'blog')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/blog"><i class="fa fa-cc"></i>
                            Blogs </a> </li>
                    <?php
                    if ($segment == 'comments')
                        $classactive = 'class="menuactive"';
                    else
                        $classactive = "";
                    ?>
                    <li <?php echo $classactive; ?>><a href="<?php echo base_url(); ?>admin/comments"><i class="fa fa-commenting-o "></i> Comments </a></li>
                </ul>
            <?php } ?>

            <?php
            if ($segment == 'change_password')
                $classactive = 'class="active"';
            else
                $classactive = "";
            ?>
            <li <?php echo $classactive; ?>>
                <a href="<?php echo base_url(); ?>admin/change_password">
                    <i class="fa fa-home"></i> <span>Change Password</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>

            <li>
                <a href="<?php echo base_url(); ?>admin/logout">
                    <i class="fa fa-stop-circle"></i> <span>Logout</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar -->
</aside>