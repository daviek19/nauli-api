<?php

class Nhif_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_nhif_rates() {
        log_message("debug", "*********** fetching Nhif_model nhif_rates ***********");

        $select_query = "SELECT * FROM `payroll_nhif` order by `id`;";

        if ($query = $this->db->query($select_query)) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "Nhif rates..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting Nhif Rates.');

            return false;
        }
    }

}
