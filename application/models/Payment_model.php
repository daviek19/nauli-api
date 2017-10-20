<?php

class Payment_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	
	public function get_payments($trip_id){
		
		if(empty($trip_id)){
			return [];
		}
		
		$query = $this->db->query("SELECT * FROM `payments` WHERE `payments`.`trip_id` = '{$trip_id}'");	
		return $query->result();
	}
	
}
	