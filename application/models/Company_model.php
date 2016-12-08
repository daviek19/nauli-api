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

                //update the person who created it as the user
                $user_data = array(
                    'company_id' => $id,
                );

                $this->db->where('user_id', $data['company_created_by']);
                $this->db->update('people', $user_data);
                log_message("debug", " Company set to user " . $data['company_created_by']);
                return $new_record->row();
            } else {
                return FALSE;
            }
        } else {
            log_message("debug", " Company name was empty.Exit");
            return FALSE;
        }
    }

    public function edit_company($data, $id) {
        log_message("debug", "Getting ready to edit... " . json_encode($data));

        if (!empty($data['company_name'])) {
            $this->db->where('company_id', $id);
            if ($this->db->update('company', $data)) {
                $new_record = $this->db->get_where('company', array('company_id' => $id));
                log_message("debug", " Company Updated " . json_encode($new_record->row()));
                return $new_record->row();
            } else {
                return FALSE;
            }
        } else {
            log_message("debug", " Company name was empty. Exit");
            return FALSE;
        }
    }

    public function get_company($id) {
        $query = $this->db->query("SELECT * FROM `company` WHERE `company_id` = $id LIMIT 1");
        log_message("debug", $this->db->last_query());
        log_message("debug", "found..." . json_encode($query->row()));
        return $query->row();
    }
    
    public function get_employees($id){
      $query = $this->db->query("SELECT * FROM `people` WHERE `company_id` = $id AND `is_employee` = '1'");
        log_message("debug", $this->db->last_query());
        log_message("debug", "found employees..." . json_encode($query->row()));
        return $query->result();   
    }

}
