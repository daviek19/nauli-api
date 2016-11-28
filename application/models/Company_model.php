<?php

class Company_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_company($data) {
        log_message("debug", "Getting ready to insert... " . json_encode($data));

        if (!empty($data['company_name'])) {
            if ($this->db->insert('company', $data)) {
                $id = $this->db->insert_id();
                $new_record = $this->db->get_where('company', array('company_id' => $id));
                log_message("debug", " Company created " . json_encode($new_record->row()));
                return $new_record->row();
            } else {
                return FALSE;
            }
        } else {
            log_message("debug", " Company name was empty.Exit");
            return FALSE;
        }
    }

    public function get_company($id) {
        $query = $this->db->query("SELECT * FROM `company` WHERE `company_id` = $id LIMIT 1");
        log_message("debug", $this->db->last_query());
        log_message("debug", "found..." . json_encode($query->row()));
        return $query->row();
    }

}
