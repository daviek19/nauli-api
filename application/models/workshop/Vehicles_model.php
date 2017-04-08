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
    , `vehicle_type`.`group_name` AS group_id_name
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
	, `year`.`description_name` AS make_year_name
    , `vehicle_master`.`date_created`
FROM
    `workshop`.`vehicle_master`
	INNER JOIN `workshop`.`group_master` AS `vehicle_type`
        ON (`vehicle_master`.`group_id` = `vehicle_type`.`group_id`)
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
    INNER JOIN `workshop`.`parameter_description` AS `year`
        ON (`vehicle_master`.`make_year` = `year`.`description_id`)
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

    public function get_single_vehicle($company_id = '0', $vehicle_id)
    {
        if (!empty($vehicle_id)) {

            $select_query =
                   "SELECT
    `vehicle_master`.`vehicle_id`
    , `vehicle_master`.`company_id`
    , `vehicle_master`.`vehicle_code`
    , `vehicle_master`.`vehicle_name`
    , `vehicle_master`.`group_id`
	, `vehicle_type`.`group_name` AS group_id_name
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
	, `year`.`description_name` AS make_year_name
    , `vehicle_master`.`date_created`
FROM
    `workshop`.`vehicle_master`
	INNER JOIN `workshop`.`group_master` AS `vehicle_type`
        ON (`vehicle_master`.`group_id` = `vehicle_type`.`group_id`)
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
    INNER JOIN `workshop`.`parameter_description` AS `year`
        ON (`vehicle_master`.`make_year` = `year`.`description_id`)
        WHERE `vehicle_master`.`vehicle_id` = {$vehicle_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->workshop_db->last_query());

                log_message("debug", "found vehicle..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting vehicle.');

                return false;
            }
        } else {
            //The vehicle_id was empty
            return FALSE;
        }
    }

    public function create_vehicle($data)
    {
        log_message("debug", "create_vehicle...data " . json_encode($data));

        if ($this->workshop_db->insert('vehicle_master', $data)) {

            log_message("debug", "group vehicle query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('vehicle_master', array('vehicle_id' => $id));

            log_message("debug", " vehicle created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function vehicle_exists($vehicle_name, $company_id)
    {
        $this->workshop_db->where('vehicle_name', $vehicle_name);

        $this->workshop_db->where('vehicle_id', $company_id);

        $query = $this->workshop_db->get('vehicle_master');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function update_vehicle($data)
    {

        log_message("debug", "Getting ready to update_vehicle... " . json_encode($data));

        if (empty($data['vehicle_id'])) {

            log_message("debug", " vehicle_id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('vehicle_id', $data['vehicle_id']);

        if ($this->workshop_db->update('vehicle_master', $data) == FALSE) {

            return FALSE;
        }
        log_message("debug", "update_vehicle " . $this->workshop_db->last_query());
        //All went well
        $new_record = $this->workshop_db->get_where('vehicle_master', array('vehicle_id' => $data['vehicle_id']));

        log_message("debug", " update_vehicle query " . $this->workshop_db->last_query());

        log_message("debug", " vehicle Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }

    public function vehicle_id_exists($vehicle_id)
    {
        $this->workshop_db->where('vehicle_id', $vehicle_id);

        $query = $this->workshop_db->get('vehicle_master');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }
}