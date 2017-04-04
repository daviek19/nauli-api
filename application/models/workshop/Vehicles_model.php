<?php

class Vehicles_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_all_vehicles($company_id = '0')
    {
        $select_query =
            "SELECT
    `vehicle_master`.`vehicle_id`
    , `vehicle_master`.`company_id`
    , `vehicle_master`.`vehicle_code`
    , `vehicle_master`.`vehicle_name`
    , `vehicle_master`.`group_id`
    , `vehicle_master`.`description_id`
    , `vehicle`.`description_name`
    , `vehicle_master`.`item_unit_id`
    , `units`.`description_name` AS item_unit_name
    , `vehicle_master`.`selling_price`
    , `vehicle_master`.`cost`
    , `vehicle_master`.`make_id`
    , `make`.`description_name` AS make_name
    , `vehicle_master`.`model_no`
    , `model`.`description_name` AS model_name
    , `vehicle_master`.`body_type`
    , `body`.`description_name` AS body_type_name
    , `vehicle_master`.`make_year`
    , `vehicle_master`.`date_created`
FROM
    `workshop`.`vehicle_master`
    INNER JOIN `workshop`.`parameter_description` AS `vehicle`
        ON (`vehicle_master`.`description_id` = `vehicle`.`description_id`)
    INNER JOIN `workshop`.`parameter_description` AS `units`
        ON (`vehicle_master`.`item_unit_id` = `units`.`description_id`)
    INNER JOIN `workshop`.`parameter_description` AS `make`
        ON (`vehicle_master`.`make_id` = `make`.`description_id`)
    INNER JOIN `workshop`.`parameter_description` AS `model`
        ON (`vehicle_master`.`model_no` = `model`.`description_id`)
    INNER JOIN `workshop`.`parameter_description` AS `body`
        ON (`vehicle_master`.`body_type` = `body`.`description_id`)
        WHERE `vehicle_master`.`company_id` IN (?,?);";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found departments..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting departments.');

            return false;
        }
    }

    public function get_single_vehicle($company_id = '0', $group_id)
    {
        log_message("debug", "*********** fetching get_single_group ***********");

        if (!empty($group_id)) {

            $select_query =
                "SELECT * FROM `group_master` JOIN `parameter_description`
					ON group_master.description_id = parameter_description.description_id 
					WHERE group_master.group_id = {$group_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->workshop_db->last_query());

                log_message("debug", "found group..." . json_encode($query->result()));

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

    public function create_vehicle($data)
    {
        log_message("debug", "create_group...data " . json_encode($data));

        if ($this->workshop_db->insert('group_master', $data)) {

            log_message("debug", "group create query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('group_master', array('group_id' => $id));

            log_message("debug", " group created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function vehicle_exists($group_name, $company_id)
    {

        $this->workshop_db->where('group_name', $group_name);

        $this->workshop_db->where('company_id', $company_id);

        $query = $this->workshop_db->get('group_master');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function update_vehicle($data)
    {

        log_message("debug", "Getting ready to update_group... " . json_encode($data));

        if (empty($data['group_id'])) {

            log_message("debug", " group id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('group_id', $data['group_id']);

        if ($this->workshop_db->update('group_master', $data) == FALSE) {

            return FALSE;
        }
        log_message("debug", "update_group " . $this->workshop_db->last_query());
        //All went well
        $new_record = $this->workshop_db->get_where('group_master', array('group_id' => $data['group_id']));

        log_message("debug", " update_group query " . $this->workshop_db->last_query());

        log_message("debug", " Group Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }

    public function vehicle_id_exists($group_id)
    {
        $this->workshop_db->where('group_id', $group_id);

        $query = $this->workshop_db->get('group_master');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function get_vehicle_by_classification($company_id = 0, $classification_id)
    {
        log_message("debug", "*********** fetching get_groups_by_classification ***********");

        if (!empty($classification_id)) {

            $select_query =
                "SELECT * FROM `group_master` JOIN `parameter_description`
					ON group_master.description_id = parameter_description.description_id
					WHERE group_master.description_id = {$classification_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->workshop_db->last_query());

                log_message("debug", "found group..." . json_encode($query->result()));

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
}