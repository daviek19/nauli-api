<?php

class Parameters_model extends CI_Model {

    private $workshop_db;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_all_parameters($company_id = '0') {

        $select_query = "SELECT * FROM `parameter_item`
					WHERE `company_id` IN (?,?) ORDER BY `date_created` DESC;";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found parameters..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting parameters.');

            return false;
        }
    }

    public function get_single_parameter($company_id = '0', $item_id) {
        log_message("debug", "*********** fetching get_single_parameter ***********");

        if (!empty($item_id)) {

            $select_query = "SELECT * FROM `parameter_item`
                        WHERE `item_id` = {$item_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->db->last_query());

                log_message("debug", "found parameter..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting group.');

                return false;
            }
        } else {
            //The department_id was empty
            return FALSE;
        }
    }

    public function create_parameter($data) {
        log_message("debug", "create_parameter...data " . json_encode($data));

        if ($this->workshop_db->insert('parameter_item', $data)) {

            log_message("debug", "create_parameter query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('parameter_item', array('item_id' => $id));

            log_message("debug", " parameter created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function parameter_exists($item_name, $company_id) {

        $this->workshop_db->where('item_name', $item_name);

        $this->workshop_db->where('company_id', $company_id);

        $query = $this->workshop_db->get('parameter_item');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function update_parameter($data) {

        log_message("debug", "Getting ready to update_parameter... " . json_encode($data));

        if (empty($data['item_id'])) {

            log_message("debug", " item id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('item_id', $data['item_id']);

        if ($this->workshop_db->update('parameter_item', $data) == FALSE) {

            return FALSE;
        }
        log_message("debug", "update_parameter " . $this->workshop_db->last_query());
        //All went well
        $new_record = $this->workshop_db->get_where('parameter_item', array('item_id' => $data['item_id']));

        log_message("debug", " update_parameter query " . $this->workshop_db->last_query());

        log_message("debug", " parameter Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }

    public function parameter_id_exists($item_id) {
        $this->workshop_db->where('item_id', $item_id);

        $query = $this->workshop_db->get('parameter_item');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

   

}
