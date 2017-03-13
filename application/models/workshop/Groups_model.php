<?php

class Groups_model extends CI_Model {
	
	private $workshop_db;

    public function __construct() {
        parent::__construct();
        $this->load->database();
		$this->workshop_db = $this->load->database('workshop', true);
    }
	
public function get_all_groups($company_id = '0') {

	log_message("debug", "*********** fetching get_all_groups ***********");

	$select_query = "SELECT * FROM `group_master` 
					WHERE `company_id` IN (?,?) ORDER BY `date_created` DESC;";

	if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

		log_message("debug", $this->db->last_query());

		log_message("debug", "found departments..." . json_encode($query->result()));

		return $query->result();
	} else {

		log_message("error", 'Error getting departments.');

		return false;
	}
}
}