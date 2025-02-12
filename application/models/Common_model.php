<?php
class Common_model extends CI_Model
{    
    public function __construct()
    {
        parent::__construct();
        // error_reporting(E_ALL & ~E_NOTICE);
    }
    public $currency = "&#x20b9;";
    public $per_page = 10; //Used in Pagination => display no. of items in per page 
    public $num_links = 2; //Used in Pagination => display no. of page links in the pagination bar 
    public $costvalue = 10; //Password hashing estimated cost time
	public $product_per_page = 20;	
    
    /* insert record to database */
    public function insert_records($table, $insert_arr)
    {
        $insert = $this->db->insert($table, $insert_arr);
        if ($insert) {
            return true;
        } else {
            return false;
        }
    }
    
    /* get records from database */
    public function get_records($fields, $table, $where = '', $orderby = '', $limit = '', $start = '')
    {
        $this->db->select($fields);
        $this->db->from($table);
        
        if ($where != '')
            $this->db->where($where);
        
        if ($orderby != '')
            $this->db->order_by($orderby);
        
        if ($limit != '') {
            //if($start != '')
            $this->db->limit($limit, $start);
            //else
            //$this->db->limit($limit);
        }
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    
    /* Join table records from database */
    public function join_records($fields, $table1, $table2, $joinon, $where = '', $orderby = '', $limit = '', $start = '')
    {
        $this->db->select($fields);
        $this->db->from($table1);
        $this->db->join($table2, $joinon);
        
        if ($where != '')
            $this->db->where($where);
        
        if ($orderby != '')
            $this->db->order_by($orderby);
        
        if ($limit != '') {
            //if($start != '')
            $this->db->limit($limit, $start);
            //else
            //$this->db->limit($limit);
        }
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    
    /* count no. of record from database */
    public function noof_records($fields, $table, $where = '')
    {
        $this->db->select($fields);
        $this->db->from($table);
        
        if ($where != '')
            $this->db->where($where);
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }
    
    /* delete record from database */
    public function delete_records($table, $where)
    {
        $this->db->where($where);
        $delquery = $this->db->delete($table);
        if ($delquery) {
            return true;
        } else {
            return false;
        }
    }
    
    /* update record in database */
    public function update_records($table, $fields, $where)
    {
        $this->db->where($where);
        $query = $this->db->get($table);
        
        if ($query->num_rows() > 0) {
            $this->db->where($where);
            $update = $this->db->update($table, $fields);
            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    /* populate selectbox from database */
    public function populate_select($dispid, $fid, $fname, $table, $where = '', $orderby = '', $joininfid = '')
    {
        $this->db->select($fid);
        $this->db->select($fname);
        $this->db->from($table);
        
        if ($where != '')
            $this->db->where($where);
        
        if ($orderby != '')
            $this->db->order_by($orderby);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $options = '';
            $rows    = $query->result_array();
            foreach ($rows as $row) {
                $selectid = $row[$fid];
                if ($joininfid != '')
                    $selectid = $selectid . '__' . $joininfid;
                
                $selectname = $row[$fname];
                if ($selectid == $dispid)
                    $options .= "<option value=\"$selectid\" selected>$selectname</option>";
                else
                    $options .= "<option value=\"$selectid\">$selectname</option>";
            }
            return $options;
        } else {
            return false;
        }
    }

    /* show name from an id */
    public function showname_fromid($field, $table, $where = '')
    {
        $this->db->select($field);
        $this->db->from($table);
        
        if ($where != '')
            $this->db->where($where);
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->$field;
        } else {
            return false;
        }
    }
    
    /* populate number combo box */
    public function generate_numberbox($startval, $endval, $shwval = 0, $intvl = 1)
    {
        $showDetails = '';
        for ($i = $startval; $i <= $endval; $i = $i + $intvl) {
            if ($shwval == $i)
                $showDetails .= "<OPTION value=\"$i\" selected>$i</OPTION>";
            else
                $showDetails .= "<OPTION value=\"$i\">$i</OPTION>";
        }
        return $showDetails;
    }
    
    /** Short String Cut **/
    public function short_str($inputstring, $char = 100)
    {
        $inputstring = strip_tags($inputstring);
        $inputstring = trim(preg_replace('/\s+/', ' ', $inputstring));
        if (strlen($inputstring) > $char) {
            $string      = explode("\n", wordwrap($inputstring, $char));
            $inputstring = $string[0] . '...';
        }
        return $inputstring;
    }
    
    public function truncate($string, $length = 100, $append = "&hellip;")
    {
        $string = trim($string);
        
        if (strlen($string) > $length) {
            $string = wordwrap($string, $length);
            $string = explode("\n", $string, 2);
            $string = $string[0] . $append;
        }
        return $string;
    }
    
    /** Display Price **/
    public function numberformat($price)
    {
        if ($price > 0)
            return number_format($price, 0, "", ",");
        else
            return $price;
    }
    
    /* Display Date */
    public function dateformat($date)
    {
        if ($date != "")
            return date('dS M Y', strtotime($date));
        else
            return $date;
    }
    
    /* Display Date */
    function startend_date_format($start_date, $end_date)
    {
        // echo $final_date;exit;
        if ($start_date != $end_date) {
            //for date
            $statNewDate  = date('d', strtotime($start_date));
            $endNewDate   = date('d', strtotime($end_date));
            //for month
            $statNewMonth = date('F', strtotime($start_date));
            $endNewMonth  = date('F', strtotime($end_date));
            //for year
            $statNewYear = date('Y', strtotime($start_date));
            $endNewYear = date('Y', strtotime($end_date));            
            
            if ($statNewDate != $endNewDate) {
                $date = $statNewDate . '-' . $endNewDate . ' ' . $statNewMonth . ' ' . $statNewYear;                
            }
            if ($statNewMonth != $endNewMonth) {
                $date = $this->Common_model->dateformat($start_date) . ' - ' . $this->Common_model->dateformat($end_date);
            } 
            if (($statNewDate != $endNewDate) && ($statNewMonth != $endNewMonth)) {
                $date = $this->Common_model->dateformat($start_date) . ' - ' . $this->Common_model->dateformat($end_date);
            }  
            if (($statNewYear != $endNewYear)) {
                $date = $this->Common_model->dateformat($start_date) . ' - ' . $this->Common_model->dateformat($end_date);
            }             
            $final_date = $date;
            
        } else {
            $final_date = $this->Common_model->dateformat($start_date);
        }

        return $final_date;
    }
    
    /** Remove White Space and replace with Underscore **/
    public function remove_whitespace($str)
    {
        return preg_replace('/\s+/', '_', trim($str));
    }
    
    public function remove_underscore($str)
    {
        return str_replace('_', ' ', trim($str));
    }
    
    /** Encode & Decode **/
    public function encode($str)
    {
        return base64_encode($str);
    }
    public function decode($str)
    {
        return base64_decode($str);
    }
    
    /* get distinct records from database */
    public function get_distinctrecords($fields, $table, $where = '', $orderby = '', $limit = '', $start = '')
    {
        $this->db->distinct();
        $this->db->select($fields);
        $this->db->from($table);
        
        if ($where != '')
            $this->db->where($where);
        
        if ($orderby != '')
            $this->db->order_by($orderby);
        
        if ($limit != '') {
            //if($start != '')
            $this->db->limit($limit, $start);
            //else
            //$this->db->limit($limit);
        }
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    
    /* get groupby records from database */
    public function get_groupbyrecords($groupbycol, $fields, $table, $where = '', $orderby = '', $limit = '', $start = '')
    {
        $this->db->select($fields);
        $this->db->group_by($groupbycol);
        $this->db->from($table);
        
        if ($where != '')
            $this->db->where($where);
        
        if ($orderby != '')
            $this->db->order_by($orderby);
        
        if ($limit != '') {
            //if($start != '')
            $this->db->limit($limit, $start);
            //else
            //$this->db->limit($limit);
        }
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    
    /* group by count no. of record from database */
    public function noof_recordsgrpby($groupbycol, $fields, $table, $where = '')
    {
        $this->db->select($fields);
        $this->db->group_by($groupbycol);
        $this->db->from($table);
        
        if ($where != '')
            $this->db->where($where);
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }
    
    /* Display random password */
    //lopa//
    function randomPassword()
    {
        $alphabet    = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass        = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n      = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    
    function makeSeoUrl($url)
    {
        if ($url) {
            $url   = trim($url);
            $value = preg_replace("![^a-z0-9]+!i", "-", $url);
            $value = trim($value, "-");
            return strtolower($value);
        }
    }
    
    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }


    function dateDisplay($datetime) {
        if ($datetime != "" && $datetime != "NULL" && $datetime != "0000-00-00 00:00:00") {
            return date("M d, Y", strtotime($datetime));
        } else {
            return false;
        }
    }
    //lopa//

    public function show_parameter ($where='')
    {
        $this->db->select("par_value");
        $this->db->from("tbl_parameters");
        $this->db->where("parid='$where'");
             
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row->par_value;
        }
        else
        {
            return false;
        }
    }
    
    
    function ddoo_upload($filename, $width, $height, $replacefilename = "")
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'jpg|jpeg|png';	
		$config['overwrite'] = FALSE;
        if($replacefilename != "") {
            $config['encrypt_name'] = FALSE;
            $config['file_name'] = $replacefilename;
        } else {
            $config['encrypt_name'] = TRUE;
        }
		
		$this->load->library('upload', $config);
				
		if ( ! $this->upload->do_upload($filename)) {			
			echo $this->upload->display_errors();die();
			return NULL;			
		} else {
									
			$data = $this->upload->data();			
			$filename = $data['file_name'];
			
			$config1['image_library'] = 'gd2';
			$config1['source_image'] = $this->upload->upload_path.$this->upload->file_name;
			$config1['maintain_ratio'] = FALSE;
			$config1['width'] = $width;
			$config1['height'] = $height;
			
			$this->load->library('image_lib', $config1);
			$this->image_lib->resize();
			$this->image_lib->clear();
						
			return $filename;
		}	
	} 
	
	
    function thumbddoo_upload($filename, $width, $height, $replacedoofilename = "")
	{
		$thumbconfig['upload_path'] = './uploads/';
		$thumbconfig['allowed_types'] = 'jpg|jpeg|png';	
		$thumbconfig['overwrite'] = FALSE;
        if($replacedoofilename != "") {
            $thumbconfig['encrypt_name'] = FALSE;
            $thumbconfig['file_name'] = $replacedoofilename;
        } else {
            $thumbconfig['encrypt_name'] = TRUE;
        }
		
		$this->load->library('upload', $thumbconfig);
		
		$this->upload->do_upload($filename);
		
		$data = $this->upload->data();			
		$filename = $data['file_name'];
		$config1['image_library'] = 'gd2';
		$config1['source_image'] = $this->upload->upload_path.$this->upload->file_name;
		$config1['width'] = $width;
		$config1['height'] = $height;
		$this->load->library('image_lib', $config1);
		$this->image_lib->initialize($config1);
		$this->image_lib->resize();
		
		return $filename;
	} 
	
	/* get random tag id from package id who has more than one package */
    public function get_package_id($package_id)
    {
        $this->db->select("tagid");
        $this->db->from("tbl_tags");
        $this->db->where("type_id='$package_id' and type=3");
        $this->db->order_by("RAND()");
        //$this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
			$rows = $query->result_array();
            foreach($rows as $row){
				$tagid = $row["tagid"];
				$noof_package = $this->noof_records("distinct(type_id) as packageid", "tbl_tags", "type=3 and tagid=$tagid and type_id!=$package_id");
				if($noof_package > 0)
				{
					return $tagid;
					break;
				}
			}					
        } else {
            return false;
        }
    }
	
	public function populate_duration($destination = '', $dispid = '')
    {
        if($destination != ''){
            $destinationid = $this->Common_model->decode($_REQUEST["destination"]);
            $destinationid = $this->db->escape($destinationid);
            $condition = " and destination_id=".$destinationid;
        }
        
        $this->db->select('a.durationid, a.duration_name');
        $this->db->from('tbl_package_duration as a');
        $this->db->where('a.status', 1);
        $this->db->where("EXISTS (SELECT 1 FROM tbl_tourpackages as b where a.durationid=b.package_duration and b.status=1 and EXISTS (SELECT 1 FROM tbl_itinerary_destination as c WHERE c.itinerary_id=b.itinerary ".$condition."))");        
                
        $this->db->order_by('a.no_ofdays ASC');
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $options = '';
            $rows    = $query->result_array();
            foreach ($rows as $row) {
                $selectid = $this->encode($row['durationid']);                
                $selectname = $row['duration_name'];
                if ($selectid == $dispid)
                    $options .= "<option value=\"$selectid\" selected>$selectname</option>";
                else
                    $options .= "<option value=\"$selectid\">$selectname</option>";
            }
            return $options;
        } else {
            return false;
        }
    }
	
	public function populate_destination($dispid = '')
    {
        $this->db->select('a.destination_id, a.destination_name');
        $this->db->from('tbl_destination as a');
        $this->db->where('a.status', 1);
        $this->db->where('EXISTS (SELECT 1 FROM tbl_itinerary_destination as b WHERE a.destination_id=b.destination_id AND EXISTS (SELECT 1 FROM tbl_tourpackages as c WHERE b.itinerary_id=c.itinerary AND c.status=1))');       
        $this->db->order_by('a.destination_name ASC');
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $options = '';
            $rows    = $query->result_array();
            foreach ($rows as $row) {
                $selectid = $this->encode($row['destination_id']);                
                $selectname = $row['destination_name'];
                if ($selectid == $dispid)
                    $options .= "<option value=\"$selectid\" selected>$selectname</option>";
                else
                    $options .= "<option value=\"$selectid\">$selectname</option>";
            }
            return $options;
        } else {
            return false;
        }
    }
	
    public function verifyCaptcha($captchaResponse)
    {
        $recaptchaResponse = trim($captchaResponse); 
        $userIp=$this->input->ip_address();     
        $secret = $this->config->item('google_secret');   
        $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;
 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);      
         
        $response_keys = json_decode($output, true);
        if (intval($response_keys["success"]) !== 1) {
            return false;
        } else {
            return true;
        }
    }
	
	public function htmlencode($str=""){
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8', TRUE);
    }

    public function htmldecode($str=""){
        return htmlspecialchars_decode($str, ENT_QUOTES);
    }
	
	public function seo_friendly_url($string)
    {
        // convert to entities
        $string = htmlentities( $string, ENT_QUOTES, 'UTF-8' );
        // regex to convert accented chars into their closest a-z ASCII equivelent
        $string = preg_replace( '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $string );
        // convert back from entities
        $string = html_entity_decode( $string, ENT_QUOTES, 'UTF-8' );
        // any straggling caracters that are not strict alphanumeric are replaced with a dash
        $string = preg_replace( '~[^0-9a-z]+~i', '-', $string );
        // trim / cleanup / all lowercase
        $string = trim( $string, '-' );
        $string = strtolower( $string );
        return $string.'-'.rand(1000,9999);
    }
	
}
