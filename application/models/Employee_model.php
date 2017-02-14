<?php

class Employee_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_employee_types() {
        log_message("debug", "*********** fetching get_employee_types ***********");

        $select_query = "SELECT * FROM `payroll_employee_types` order by `id`;";

        if ($query = $this->db->query($select_query)) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "employee_types..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error employee_types.');

            return false;
        }
    }

}
