<?php

class Banks_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_all_banks($company_id = '0')
    {
        $select_query =
            "SELECT * FROM `bank_master`
					WHERE bank_master.company_id IN (?,?)
					ORDER BY bank_master.date_created DESC;";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found banks..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting boqs.');

            return false;
        }
    }

    public function get_single_bank($company_id = '0', $bank_id)
    {
        if (!empty($bank_id)) {

            $select_query = "SELECT * FROM `bank_master`
					WHERE bank_master.bank_id = {$bank_id}";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->workshop_db->last_query());

                log_message("debug", "found banks..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting bank.');

                return false;
            }
        } else {
            return FALSE;
        }
    }

    public function create_bank($data)
    {
        if ($this->workshop_db->insert('bank_master', $data)) {

            log_message("debug", "bank query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('bank_master', array('bank_id' => $id));

            log_message("debug", " bank created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function bank_exists($bank_name, $branch_code, $company_id)
    {
        $this->workshop_db->where('bank_name', $bank_name);

        $this->workshop_db->where('branch_code', $branch_code);

        $this->workshop_db->where('company_id', $company_id);

        $query = $this->workshop_db->get('bank_master');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function update_bank($data)
    {
        log_message("debug", "Getting ready to update_bank... " . json_encode($data));

        if (empty($data['bank_id'])) {

            log_message("debug", "bank_id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('bank_id', $data['bank_id']);

        if ($this->workshop_db->update('bank_master', $data) == FALSE) {

            return FALSE;
        }
        log_message("debug", "update_bank " . $this->workshop_db->last_query());
        //All went well
        $new_record = $this->workshop_db->get_where('bank_master', array('bank_id' => $data['bank_id']));

        log_message("debug", "update_bank query " . $this->workshop_db->last_query());

        log_message("debug", "bank Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }

    public function bank_id_exists($bank_id)
    {
        $this->workshop_db->where('bank_id', $bank_id);

        $query = $this->workshop_db->get('bank_master');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }
}