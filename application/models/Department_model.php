<?php

class Company_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_department($data) {
        log_message("debug", "create_department...data " . json_encode($data));

        if ($this->db->insert('departments', $data)) {

            log_message("debug", "department create query " . $this->db->last_query());

            $id = $this->db->insert_id();

            $new_record = $this->db->get_where('departments', array('department_id' => $id));

            log_message("debug", " department created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function get_department($company_id) {

        $select_query = "SELECT * FROM `departments` 
                        WHERE `company_id` IN (?,?);";

        if ($query = $this->db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found department..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting department.');

            return false;
        }
    }

    public function update_department($data) {
        
    }

}
