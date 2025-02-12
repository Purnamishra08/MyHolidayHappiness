<!--<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
<link rel="preload" rel="stylesheet"  href="https://fonts.googleapis.com/css?family=Encode+Sans+Semi+Condensed|Questrial&display=swap" as="style">-->
<!--<link rel="preload" href="<?php echo base_url(); ?>assets/main.min.css?version=7" as="style">-->

<!--<link
    rel="preload"
    href="https://fonts.googleapis.com/css?family=Encode+Sans+Semi+Condensed|Questrial&display=swap"
    as="style"
    onload="this.onload=null;this.rel='stylesheet'"
/>
<noscript>
    <link
        href="https://fonts.googleapis.com/css?family=Encode+Sans+Semi+Condensed|Questrial&display=swap"
        rel="stylesheet"
        type="text/css"
    />
</noscript>-->

<link rel="preload" href="https://fonts.gstatic.com/s/questrial/v18/QdVUSTchPBm7nuUeVf70sCFlq20.woff2" as="font" crossorigin="anonymous">
<link rel="preload" href="https://fonts.gstatic.com/s/questrial/v18/QdVUSTchPBm7nuUeVf70viFl.woff2" as="font" crossorigin="anonymous">
<script async src="https://www.googletagmanager.com/gtag/js?id=G-VB2RKHN8NJ"></script>
<?php
$first_segment = $this->uri->segment(1);
$seco_segment = $this->uri->segment(2);
$thrd_segment = $this->uri->segment(3);


$getSeoMetaTags = $this->Common_model->get_records("par_value", "tbl_parameters", "parid in (25, 26, 27)", "parid asc");
$meta_title = $getSeoMetaTags[0]['par_value'];
$meta_description = $getSeoMetaTags[1]['par_value'];
$meta_keywords = $getSeoMetaTags[2]['par_value'];

if (($first_segment == "") || ($first_segment == 'home') || ($first_segment == 'contactus') || ($first_segment == 'about') || ($first_segment == 'review') || ($first_segment == 'faq') || ($first_segment == 'hiring') || ($first_segment == 'travel-agent') || ($first_segment == 'advertise') || ($first_segment == 'destinations') || ($first_segment == 'tour-packages') || ($first_segment == 'getaway') || ($first_segment == 'itineraries')) {
    
    if (($first_segment == "") || ($first_segment == 'home')) {
        $seowhere = "content_id=1";
    } else if ($first_segment == 'contactus') {
        $seowhere = "content_id=3";
    } else if ($first_segment == 'about') {
        $seowhere = "content_id=4";
    } else if ($first_segment == 'blog') {
        $seowhere = "content_id=5";
    } else if ($first_segment == 'faq') {
        $seowhere = "content_id=6";
    } else if ($first_segment == 'review') {
        $seowhere = "content_id=7";
    } else if ($first_segment == 'hiring') {
        $seowhere = "content_id=8";
    } else if ($first_segment == 'travel-agent') {
        $seowhere = "content_id=9";
    } else if ($first_segment == 'advertise') {
        $seowhere = "content_id=10";
    } else if ($first_segment == 'destinations') {
        $seowhere = "content_id=11";
    } else if ($first_segment == 'tour-packages') {
        $seowhere = "content_id=12";
    } else if ($first_segment == 'getaway') {
        $seowhere = "content_id=13";
    } else if ($first_segment == 'itineraries') {
        $seowhere = "content_id=14";
    } 
    
    $getseo_findrec = $this->Common_model->get_records("seo_title, seo_description, seo_keywords", "tbl_contents", "$seowhere", "");
    
    if(!empty($getseo_findrec)){
        foreach ($getseo_findrec as $rowseo_rec) {
            $title = $rowseo_rec['seo_title'];
            $description = $rowseo_rec['seo_description'];
            $keywords = $rowseo_rec['seo_keywords'];
        }
    }
    $meta_title = ($title != "") ? $title : $meta_title;
    /* if ($first_segment == 'blog' && isset($blog_title)) {
        $meta_title =$blog_title;
    }  */   
    
    $meta_description = ($description != "") ? $description : $meta_description;
    $meta_keywords = ($keywords != "") ? $keywords : $meta_keywords;
    
}   else if (($first_segment == 'tours') || ($first_segment == 'getaways')) {
    $tag_url = $this->uri->segment(3); 
    $getTagSeos = $this->Common_model->get_records("meta_title,meta_keywords,meta_description", "tbl_menutags", "tag_url ='$tag_url'", "", "1");
	if(!empty($getTagSeos)){
		foreach ($getTagSeos as $getTagSeos) {
			$title = $getTagSeos['meta_title'];
			$description = $getTagSeos['meta_description'];
			$keywords = $getTagSeos['meta_keywords'];
		}
	
        $meta_title = ($title != "") ? $title : $meta_title;
        $meta_description = ($description != "") ? $description : $meta_description;
        $meta_keywords = ($keywords != "") ? $keywords : $meta_keywords;
	}
}   else if ($first_segment == 'packages') {  
    $pack_url = $this->uri->segment(2);  
    $gettourseos = $this->Common_model->get_records("meta_title,meta_keywords,meta_description", "tbl_tourpackages", "tpackage_url ='$pack_url'", "", "1");
    if(!empty($gettourseos)){
		foreach ($gettourseos as $gettourseo) {
			$title = $gettourseo['meta_title'];
			$description = $gettourseo['meta_description'];
			$keywords = $gettourseo['meta_keywords'];
		}
	
        $meta_title = ($title != "") ? $title : $meta_title;
        $meta_description = ($description != "") ? $description : $meta_description;
        $meta_keywords = ($keywords != "") ? $keywords : $meta_keywords;
    }
}   else if (($first_segment == 'destination') || ($first_segment == 'destination-package') || ($first_segment == 'places-to-visit')) {  
    if($first_segment == 'destination-package') {
            $dest_url = $this->uri->segment(2);  
    } else {
            $dest_url = $this->uri->segment(3);  
    }

    $getdestseos = $this->Common_model->get_records("meta_title,meta_keywords,meta_description,package_meta_title,package_meta_description,package_meta_keywords,place_meta_title,place_meta_description,place_meta_keywords", "tbl_destination", "destination_url ='$dest_url'", "", "1");
    if(!empty($getdestseos)){
        foreach ($getdestseos as $getdestseo) {
            
            if ($first_segment == 'destination'){
                 $title = $getdestseo['meta_title'];
                $description = $getdestseo['meta_description'];
                $keywords = $getdestseo['meta_keywords'];
            }else if($first_segment == 'destination-package'){
                 $title = $getdestseo['package_meta_title'];
                $description = $getdestseo['package_meta_description'];
                $keywords = $getdestseo['package_meta_keywords'];
            }else if($first_segment == 'places-to-visit'){
                 $title = $getdestseo['place_meta_title'];
                $description = $getdestseo['place_meta_description'];
                $keywords = $getdestseo['place_meta_keywords'];
            }
           
        }
        
        $meta_title = ($title != "") ? $title : $meta_title;
        $meta_description = ($description != "") ? $description : $meta_description;
        $meta_keywords = ($keywords != "") ? $keywords : $meta_keywords;
    }
    
}   else if ( ($first_segment == 'place') || ($first_segment == 'place-package') ) {  
		
    if($first_segment == 'place'){
            $dest_url = $this->uri->segment(4);  
             $place_url = $this->uri->segment(4);  
    } else {
            $dest_url = $this->uri->segment(2);  
             $place_url = $this->uri->segment(2);  
    }
   
    $getPLaceseos = $this->Common_model->get_records("meta_title,meta_keywords,meta_description,pckg_meta_title,pckg_meta_description,pckg_meta_keywords", "tbl_places", "place_url ='$place_url'", "", "1");
     
    if(!empty($getPLaceseos)){
        
        foreach ($getPLaceseos as $getPLaceseo) {
            if($first_segment == 'place-package'){
                $title       = $getPLaceseo['pckg_meta_title'];
                $description = $getPLaceseo['pckg_meta_description'];
                $keywords    = $getPLaceseo['pckg_meta_keywords'];
            }else{
                $title       = $getPLaceseo['meta_title'];
                $description = $getPLaceseo['meta_description'];
                $keywords    = $getPLaceseo['meta_keywords'];
            }
            
            
          
        }
        
        $meta_title = ($title != "") ? $title : $meta_title;
        $meta_description = ($description != "") ? $description : $meta_description;
        $meta_keywords = ($keywords != "") ? $keywords : $meta_keywords;
    }
    
}	else if ($first_segment == 'itinerary') {
    $itinerary_url = $this->uri->segment(2);  
    $getItineraryseos = $this->Common_model->get_records("meta_title,meta_keywords,meta_description", "tbl_itinerary", "itinerary_url ='$itinerary_url'", "", "1");
    if(!empty($getItineraryseos)){
        foreach ($getItineraryseos as $getItineraryseo) {
            $title       = $getItineraryseo['meta_title'];
            $description = $getItineraryseo['meta_description'];
            $keywords    = $getItineraryseo['meta_keywords'];
        }
        
        $meta_title = ($title != "") ? $title : $meta_title;
        $meta_description = ($description != "") ? $description : $meta_description;
        $meta_keywords = ($keywords != "") ? $keywords : $meta_keywords;
    }
}	else if ($first_segment == 'state') {
    $state_url = $this->uri->segment(2);  
    $getStateseos = $this->Common_model->get_records("state_meta_title,state_meta_keywords,state_meta_description", "tbl_state", "state_url ='$state_url'", "", "1");
    if(!empty($getStateseos)){
        foreach ($getStateseos as $getStateseo) {
            $title       = $getStateseo['state_meta_title'];
            $description = $getStateseo['state_meta_description'];
            $keywords    = $getStateseo['state_meta_keywords'];
        }
        
        $meta_title = ($title != "") ? $title : $meta_title;
        $meta_description = ($description != "") ? $description : $meta_description;
        $meta_keywords = ($keywords != "") ? $keywords : $meta_keywords;
    }
    
}else if ($first_segment == 'blog') {
    $blog_url = $this->uri->segment(2);  
    $getBlogseos = $this->Common_model->get_records("blog_meta_title,blog_meta_keywords,blog_meta_description", "tbl_blog", "blog_url ='$blog_url'", "", "1");
    if(!empty($getBlogseos)){
        foreach ($getBlogseos as $getBlogseo) {
            $title       = $getBlogseo['blog_meta_title'];
            $description = $getBlogseo['blog_meta_description'];
            $keywords    = $getBlogseo['blog_meta_keywords'];
        }
      
        if ($title == "" && isset($blog_title)) {
            $title = $blog_title;
        } 
        $meta_title = ($title != "") ? $title : $meta_title;
        $meta_description = ($description != "") ? $description : $meta_description;
        $meta_keywords = ($keywords != "") ? $keywords : $meta_keywords;
    }
    
}	else {
    $meta_title = $meta_title;
    $meta_description = $meta_description;
    $meta_keywords = $meta_keywords;
}

?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
              
        <title> <?php echo $meta_title; ?>   </title>
		<meta name="description" content="<?php echo $meta_description; ?>">
		<meta name="keywords" content="<?php echo $meta_keywords; ?>"> 
         <?php

    $canonical_url = current_url();
    ?>

       <link rel="canonical" href="<?php echo $canonical_url; ?>" />
         
        <link rel="icon" href="<?php echo base_url(); ?>assets/admin/img/fav-icon.png" sizes="16x16" type="image/png">
       <!-- <link href="https://fonts.googleapis.com/css?family=Encode+Sans+Semi+Condensed|Questrial&display=swap" rel="stylesheet">-->
        <link href="<?php echo base_url(); ?>assets/css/fontawesome-all.css?v=1" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/Pe-icon-7-stroke.css?v=1">
        <link href="<?php echo base_url(); ?>assets/css/slick.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/slick-theme.css" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/menu.min.css?version=2" rel="stylesheet" type="text/css"> 
        
        <link href="<?php echo base_url(); ?>assets/main.min.css?version=11" rel="stylesheet" type="text/css" />
        <style>
            /* vietnamese */
            @font-face {
              font-family: 'Encode Sans Semi Condensed';
              font-style: normal;
              font-weight: 400;
              font-display: swap;
              src: url(/assets/fonts/encodesanssemicondensed/3qT4oiKqnDuUtQUEHMoXcmspmy55SFWrXFRp9FTOG1yZ9MR_Rg.woff2) format('woff2');
              unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
            }
            /* latin-ext */
            @font-face {
              font-family: 'Encode Sans Semi Condensed';
              font-style: normal;
              font-weight: 400;
              font-display: swap;
              src: url(/assets/fonts/encodesanssemicondensed/3qT4oiKqnDuUtQUEHMoXcmspmy55SFWrXFRp9FTOG1yY9MR_Rg.woff2) format('woff2');
              unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
              font-family: 'Encode Sans Semi Condensed';
              font-style: normal;
              font-weight: 400;
              font-display: swap;
              src: url(/assets/fonts/encodesanssemicondensed/3qT4oiKqnDuUtQUEHMoXcmspmy55SFWrXFRp9FTOG1yW9MQ.woff2) format('woff2');
              unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
            /* vietnamese */
            @font-face {
              font-family: 'Questrial';
              font-style: normal;
              font-weight: 400;
              font-display: swap;
              src: url(/assets/fonts/questrial/QdVUSTchPBm7nuUeVf70sSFlq20.woff2) format('woff2');
              unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
            }
            /* latin-ext */
            @font-face {
              font-family: 'Questrial';
              font-style: normal;
              font-weight: 400;
              font-display: swap;
              src: url(/assets/fonts/questrial/QdVUSTchPBm7nuUeVf70sCFlq20.woff2) format('woff2');
              unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
              font-family: 'Questrial';
              font-style: normal;
              font-weight: 400;
              font-display: swap;
              src: url(/assets/fonts/questrial/QdVUSTchPBm7nuUeVf70viFl.woff2) format('woff2');
              unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
        </style>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/modernizr.custom.26633.js"></script>
		<meta name="google-site-verification" content="zbDHPDUYhNl_bkP8oDUwmj7fqBlIe9YzyJVKd4GAPGo" />
		<!-- Google tag (gtag.js) -->
        
        <script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-VB2RKHN8NJ');
        </script>

		<!--Start of Tawk.to Script-->
	<!--	<script type="text/javascript">
		var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
	    (function(){
		var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
	    s1.async=true;
	    s1.src='https://embed.tawk.to/5cfaa9ceb534676f32addf88/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
		})();
		</script>-->
		<!--End of Tawk.to Script-->
		
		
<?php
// Get the current page URL
$page_url = current_url(); // Get the full URL of the current page

// Organization Schema for Homepage
$organization_schema = [
    '@context' => 'http://schema.org',
    '@type' => 'TravelAgency',
    'name' => 'My Holiday Happiness - Package Tours & Travel',
    'brand' => 'My Holiday Happiness',
    'url' => 'https://myholidayhappiness.com/',
    'logo' => 'https://myholidayhappiness.com/assets/images/logo.png',
    'email' => 'support@myholidayhappiness.com',
    'makesOffer' => 'holiday packages, tour packages, tours & travels, travel packages, 2 night 3 days package, ooty packages, Coorg Packages, Mysore Tour Packages, Pondicherry Tour package, Munnar Tour Packages, Mangalore tour package, Madurai Tour Packages, Kerala Tour Packages, Karnataka Packages',
    'description' => "My Holiday Happiness is India’s leading travel and tourism company providing tour packages across India.",
    'sameAs' => [
        'https://www.facebook.com/myholhap/',
        'https://x.com/MyHolidayHappi1',
        'https://www.linkedin.com/company/28728838',
        'https://www.youtube.com/channel/UCyLkNG2GAarulXDyj8Zl3uw'
    ],
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => 'No. 66 (old no 681), Ist Floor, 10th C Main Rd, near Dosa Camp, 6th Block, Rajajinagar',
        'addressLocality' => 'Bengaluru',
        'addressRegion' => 'Karnataka',
        'postalCode' => '560010'
    ]
];

// JSON-LD for the Organization
$organization_json = json_encode($organization_schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

// Check if it's the homepage
if ($this->uri->uri_string() == '') {
    // Output the organization schema for the homepage
    echo "<script type='application/ld+json'>\n$organization_json\n</script>";
} else {
    // Schema JSON-LD for other pages
    $page_schema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => $meta_title, // Use the meta title here
        'url' => $page_url, // Use the current page URL here
        'offers' => $meta_keywords, // Use the meta keywords here
        'description' => $meta_description, // Use the meta description here
        'publisher' => $organization_schema // Include the organization schema
    ];

    // Convert the page schema array to JSON
    $page_schema_json = json_encode($page_schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    // Output the schema for other pages
    echo "<script type='application/ld+json'>\n$page_schema_json\n</script>";
}
?>


		
		
