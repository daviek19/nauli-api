<?php

class Subparameters_model extends CI_Model
{
    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_all_subparameters($company_id = '0')
    {

        log_message("debug", "*********** fetching get_all_subparameters ***********");

        $select_query = "SELECT * FROM `parameter_description` JOIN `parameter_item` on parameter_description.item_id = parameter_item.item_id
						 WHERE parameter_description.company_id IN (?,?)
						 ORDER BY parameter_description.item_id, parameter_description.date_created DESC;";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found subparameters..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting subparameters.');

            return false;
        }
    }

    public function get_single_subparameters($company_id = '0', $description_id)
    {
        log_message("debug", "*********** fetching get_single_subgroup ***********");

        if (!empty($description_id)) {

            $select_query =
                "SELECT * FROM `parameter_description` JOIN `parameter_item` on parameter_description.item_id = parameter_item.item_id
						 WHERE parameter_description.description_id = {$description_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->db->last_query());

                log_message("debug", "found subgroup..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting subgroup.');

                return FALSE;
            }
        } else {
            //The department_id was empty
            return FALSE;
        }
    }

    public function subparameter_exists($description_name, $company_id, $item_id)
    {

        $this->workshop_db->where('description_name', $description_name);

        $this->workshop_db->where('company_id', $company_id);

        $this->workshop_db->where('item_id', $item_id);

        $query = $this->workshop_db->get('parameter_description');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function create_subparameter($data)
    {
        log_message("debug", "create_subparameter...data " . json_encode($data));

        if ($this->workshop_db->insert('parameter_description', $data)) {

            log_message("debug", "create_subparameter query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('parameter_description', array('description_id' => $id));

            log_message("debug", " subparameter created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function subparameter_id_exists($description_id)
    {
        $this->workshop_db->where('description_id', $description_id);

        $query = $this->workshop_db->get('parameter_description');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function update_subparameter($data)
    {
        log_message("debug", "Getting ready to update_subparameter... " . json_encode($data));

        if (empty($data['description_id'])) {

            log_message("debug", " description id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('description_id', $data['description_id']);

        $update_data = array(
            'item_id' => $data['item_id'],
            'description_name' => $data['description_name']
        );

        if ($this->workshop_db->update('parameter_description', $update_data) == FALSE) {

            return FALSE;
        }

        //All went well
        $new_record = $this->workshop_db->get_where('parameter_description', array('description_id' => $data['description_id']));

        log_message("debug", " update_subparameter query " . $this->workshop_db->last_query());

        log_message("debug", " subparameter Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }
}