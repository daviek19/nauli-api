<?php

class People_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_person($id) {

        $query = $this->db->query("SELECT * FROM `people` WHERE `id` = $id LIMIT 1");
        log_message("debug", $this->db->last_query());
        log_message("debug", "found...".json_encode($query->row()));
        return $query->row();
        
    }

    public function create_person($data) {
        if ($this->db->insert('people', $data)) {
            $id = $this->db->insert_id();
            $new_record = $this->db->get_where('people', array('id' => $id));
            log_message("debug", json_encode($this->db->last_query()));
            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function get_user($id) {

        $query = $this->db->query("SELECT * FROM `people` WHERE `user_id` = $id LIMIT 1");
        log_message("error", $this->db->last_query());
        return $query->row();
    }

}
