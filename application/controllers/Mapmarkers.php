<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mapmarkers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url', 'form');
        $this->load->library('session');
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model('Common_model');		
    }

    public function destinations() 
	{		
		// Start XML file, create parent node
		$dom = new DOMDocument("1.0");
		$node = $dom->createElement("markers");
		$parnode = $dom->appendChild($node);
		
		header("Content-type: text/xml");
		
		$destinations=$this->Common_model->get_records("destination_id, destination_name, destination_url, latitude, longitude","tbl_destination","destination_id in (SELECT DISTINCT(destination_id) FROM tbl_itinerary_destination) and status=1 and (latitude!='' and longitude!='')");
        foreach ($destinations as $destination)
		{
			$destination_id = $destination['destination_id'];
			$noof_popup_packages = $this->Common_model->noof_records("DISTINCT(tourpackageid) as package_id", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $destination_id) and status=1");

			if ($noof_popup_packages>0) {	
				$tourPackMinPrice = $this->Common_model->showname_fromid("MIN(price)", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $destination_id) and status=1");
				
				// Add to XML document node
				$node = $dom->createElement("marker");
				$newnode = $parnode->appendChild($node);
				$newnode->setAttribute("id",$destination_id);
				$newnode->setAttribute("name",$destination['destination_name']);
				$newnode->setAttribute("address", $destination['destination_url']);
				$newnode->setAttribute("lat", $destination['latitude']);
				$newnode->setAttribute("lng", $destination['longitude']);
				$newnode->setAttribute("price", $tourPackMinPrice);
			}
		}
		
		echo $dom->saveXML();
		exit();
    }
	
	public function itinerary() 
	{
		// Start XML file, create parent node
		$dom = new DOMDocument("1.0");
		$node = $dom->createElement("markers");
		$parnode = $dom->appendChild($node);
		
		header("Content-type: text/xml");
		
		$itinerary_id = $this->uri->segment(3);
		
		$assoc_places = $this->Common_model->get_records("*","tbl_itinerary_daywise","itinerary_id=$itinerary_id and place_id!=''");
		$dayno = 1; 	
		foreach ($assoc_places as $assoc_place)
		{
			$daywise_places = $assoc_place['place_id'];
			if($daywise_places != "") {
				$itinerary_places = $this->Common_model->get_records("*","tbl_places","placeid in ($daywise_places)");
				foreach($itinerary_places as $place_data)
				{
					$itinerary_place_id = $place_data['placeid'];
					$itinerary_destid = $place_data['destination_id'];
					$itinerary_place_url = $place_data['place_url'];
					
					$place_dest_data = $this->Common_model->join_records("a.destination_url, b.state_url","tbl_destination as a","tbl_state as b", "a.state=b.state_id", "a.destination_id=$itinerary_destid");
					foreach ($place_dest_data as $itinerary_placedest)
					{
						$itinerary_destinationurl = $itinerary_placedest['destination_url'];
						$itinerary_state_url =  $itinerary_placedest['state_url'];
					}
					
					$place_url = 'place/'.$itinerary_state_url.'/'.$itinerary_destinationurl.'/'.$itinerary_place_url;
					// Add to XML document node
					$node = $dom->createElement("marker");
					$newnode = $parnode->appendChild($node);
					$newnode->setAttribute("id", $itinerary_place_id);
					$newnode->setAttribute("name", $place_data['place_name']);
					$newnode->setAttribute("placeurl", $place_url);
					$newnode->setAttribute("lat", $place_data['latitude']);
					$newnode->setAttribute("lng", $place_data['longitude']);
					$newnode->setAttribute("day", $dayno);
				}
			}
			$dayno++;
		}
		
		echo $dom->saveXML();
		exit();
    }
	
	public function places() 
	{
		// Start XML file, create parent node
		$dom = new DOMDocument("1.0");
		$node = $dom->createElement("markers");
		$parnode = $dom->appendChild($node);
		
		header("Content-type: text/xml");
		
		$destination_id = $this->uri->segment(3);		
		
		$itinerary_places = $this->Common_model->get_records("*","tbl_places","destination_id='$destination_id' and status=1");
		foreach($itinerary_places as $place_data)
		{
			$itinerary_place_id = $place_data['placeid'];
			$itinerary_destid = $place_data['destination_id'];
			$itinerary_place_url = $place_data['place_url'];
			
			$place_dest_data = $this->Common_model->join_records("a.destination_url, b.state_url","tbl_destination as a","tbl_state as b", "a.state=b.state_id", "a.destination_id=$itinerary_destid");
			foreach ($place_dest_data as $itinerary_placedest)
			{
				$itinerary_destinationurl = $itinerary_placedest['destination_url'];
				$itinerary_state_url =  $itinerary_placedest['state_url'];
			}
			
			$place_url = 'place/'.$itinerary_state_url.'/'.$itinerary_destinationurl.'/'.$itinerary_place_url;
			// Add to XML document node
			$node = $dom->createElement("marker");
			$newnode = $parnode->appendChild($node);
			$newnode->setAttribute("id", $itinerary_place_id);
			$newnode->setAttribute("name", $place_data['place_name']);
			$newnode->setAttribute("placeurl", $place_url);
			$newnode->setAttribute("lat", $place_data['latitude']);
			$newnode->setAttribute("lng", $place_data['longitude']);
		}
			
		
		echo $dom->saveXML();
		exit();
    }

}
