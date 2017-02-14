<?php

class Paye_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_paye_rates() {

        log_message("debug", "*********** fetching Payee_model paye_rates ***********");

        $select_query = "SELECT * FROM `payroll_paye` order by `id`;";

        if ($query = $this->db->query($select_query)) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "paye rates..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting paye Rates.');

            return false;
        }
    }

}
