<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mentions_model extends CI_Model {
	public function __construct(){
        parent::__construct();
        // Your own constructor code
    }

    public function getMentions(){
    	$query = $this->db->get('mention');
    	$row = array();

    	if(count($query->result_array()) > 0){
    		foreach ($query->result_array() as $key => $mention){
				$row[$key] = $mention;
			}
			return $row;
    	}
		

		return false;
    }
}