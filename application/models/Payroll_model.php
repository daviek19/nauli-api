<?php

class Payroll_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_posting($data) {
        log_message("debug", "create_posting...data " . json_encode($data));

        if (!empty($data['employee_id'])) {
            if ($this->db->insert('payroll_postings', $data)) {
                log_message("debug", "create_posting query " . $this->db->last_query());
                $id = $this->db->insert_id();
                $new_record = $this->db->get_where('payroll_postings', array('posting_id' => $id));
                log_message("debug", " Posting created " . json_encode($new_record->row()));
                return $new_record->row();
            } else {
                return FALSE;
            }
        } else {
            log_message("debug", " employee_id was empty when creating posting.Exit");
            return FALSE;
        }
    }

    public function update_posting($data) {
        log_message("debug", "Getting ready to edit... " . json_encode($data));

        if (!empty($data['employee_id'])) {
            $this->db->where('employee_id', $data['employee_id']);
            $this->db->where('payroll_month', $data['payroll_month']);
            if ($this->db->update('payroll_postings', $data)) {
                log_message("debug", "update_posting query " . $this->db->last_query());
                //Get the record
                $new_record = $this->db->get_where('payroll_postings', array('employee_id' => $data['employee_id'], 'payroll_month' => $data['payroll_month']));
                log_message("debug", " Psoting Updated... " . json_encode($new_record->row()));
                return $new_record->row();
            } else {
                log_message("debug", " Error with db, check query");
                return FALSE;
            }
        } else {
            log_message("debug", " employee_id was empty when creating posting.Exit");
            return FALSE;
        }
    }

}
