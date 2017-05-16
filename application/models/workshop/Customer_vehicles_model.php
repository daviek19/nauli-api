<?php

class Customer_vehicles_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_all_customer_vehicles($company_id = '0')
    {
        $select_query =
            "SELECT
`customer_vehicle`.`customer_vehicle_id`
,`customer_vehicle`.`company_id`
,`customer_vehicle`.`customer_id`
,`customer`.`customer_name`
,`customer_vehicle`.`vehicle_id`
,`vehicle`.`vehicle_name`
,`vehicle`.`vehicle_code`
,`customer_vehicle`.`chassis_no`
,`customer_vehicle`.`engine_no`
,`customer_vehicle`.`delivery_date`
,`customer_vehicle`.`user_id`
,`customer_vehicle`.`date_created`
, `make`.`description_name` AS make_name
, `model`.`description_name` AS model_name
FROM customer_vehicle
LEFT JOIN customer AS customer
 ON (`customer`.`customer_id` = `customer_vehicle`.`customer_id`)
LEFT JOIN vehicle_master AS vehicle
 ON (`vehicle`.`vehicle_id` = `customer_vehicle`.`vehicle_id`)
INNER JOIN `workshop`.`parameter_description` AS `make`
ON (`vehicle`.`make_id` = `make`.`description_id`)
 INNER JOIN `workshop`.`parameter_description` AS `model`
        ON (`vehicle`.`model_no` = `model`.`description_id`)
 WHERE `customer_vehicle`.`company_id` IN (?,?) ORDER BY `customer_vehicle`.`date_created` DESC;";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->workshop_db->last_query());

            log_message("debug", "found customer_vehicles..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting customer_vehicles.');

            return false;
        }
    }

    public function get_single_customer_vehicle($company_id = '0', $customer_vehicle_id)
    {
        if (!empty($customer_vehicle_id)) {

            $select_query =
                "SELECT
`customer_vehicle`.`customer_vehicle_id`
,`customer_vehicle`.`company_id`
,`customer_vehicle`.`customer_id`
,`customer`.`customer_name`
,`customer_vehicle`.`vehicle_id`
,`vehicle`.`vehicle_name`
,`vehicle`.`vehicle_code`
,`customer_vehicle`.`chassis_no`
,`customer_vehicle`.`engine_no`
,`customer_vehicle`.`delivery_date`
,`customer_vehicle`.`user_id`
,`customer_vehicle`.`date_created`
, `make`.`description_name` AS make_name
, `model`.`description_name` AS model_name
FROM customer_vehicle
LEFT JOIN customer AS customer
 ON (`customer`.`customer_id` = `customer_vehicle`.`customer_id`)
LEFT JOIN vehicle_master AS vehicle
 ON (`vehicle`.`vehicle_id` = `customer_vehicle`.`vehicle_id`)
INNER JOIN `workshop`.`parameter_description` AS `make`
ON (`vehicle`.`make_id` = `make`.`description_id`)
 INNER JOIN `workshop`.`parameter_description` AS `model`
        ON (`vehicle`.`model_no` = `model`.`description_id`)
				WHERE `customer_vehicle`.`customer_vehicle_id` = {$customer_vehicle_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->workshop_db->last_query());

                log_message("debug", "found customer_vehicle..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting customer_vehicle.');

                return false;
            }
        } else {
            //The vehicle_id was empty
            return FALSE;
        }
    }

    public function create_customer_vehicle($data)
    {
        log_message("debug", "create_customer_vehicle...data " . json_encode($data));

        if ($this->workshop_db->insert('customer_vehicle', $data)) {

            log_message("debug", "create_customer_vehicle query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('customer_vehicle', array('customer_vehicle_id' => $id));

            log_message("debug", " customer_vehicle created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function update_customer_vehicle($data)
    {

        log_message("debug", "Getting ready to update_customer_vehicle... " . json_encode($data));

        if (empty($data['customer_vehicle_id'])) {

            log_message("debug", " customer_vehicle_id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('customer_vehicle_id', $data['customer_vehicle_id']);

        if ($this->workshop_db->update('customer_vehicle', $data) == FALSE) {

            return FALSE;
        }
        log_message("debug", "update_customer_vehicle " . $this->workshop_db->last_query());
        //All went well
        $new_record = $this->workshop_db->get_where('customer_vehicle', array('customer_vehicle_id' => $data['customer_vehicle_id']));

        log_message("debug", " update_customer_vehicle query " . $this->workshop_db->last_query());

        log_message("debug", "customer_vehicle Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }

    public function chassis_no_exists($chassis_no, $company_id)
    {

        $this->workshop_db->where('chassis_no', $chassis_no);

        $query = $this->workshop_db->get('customer_vehicle');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function engine_no_exists($engine_no, $company_id)
    {
        $this->workshop_db->where('engine_no', $engine_no);

        $query = $this->workshop_db->get('customer_vehicle');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function customer_vehicle_id_exists($customer_vehicle_id)
    {
        $this->workshop_db->where('customer_vehicle_id', $customer_vehicle_id);

        $query = $this->workshop_db->get('customer_vehicle');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function get_vehicles_by_customer($company_id = '0', $customer_id)
    {
        $select_query =
            "SELECT
`customer_vehicle`.`customer_vehicle_id`
,`customer_vehicle`.`company_id`
,`customer_vehicle`.`customer_id`
,`customer`.`customer_name`
,`customer_vehicle`.`vehicle_id`
,`vehicle`.`vehicle_name`
,`vehicle`.`vehicle_code`
,`customer_vehicle`.`chassis_no`
,`customer_vehicle`.`engine_no`
,`customer_vehicle`.`delivery_date`
,`customer_vehicle`.`user_id`
,`customer_vehicle`.`date_created`
, `make`.`description_name` AS make_name
, `model`.`description_name` AS model_name
FROM customer_vehicle
LEFT JOIN customer AS customer
 ON (`customer`.`customer_id` = `customer_vehicle`.`customer_id`)
LEFT JOIN vehicle_master AS vehicle
 ON (`vehicle`.`vehicle_id` = `customer_vehicle`.`vehicle_id`)
INNER JOIN `workshop`.`parameter_description` AS `make`
ON (`vehicle`.`make_id` = `make`.`description_id`)
 INNER JOIN `workshop`.`parameter_description` AS `model`
        ON (`vehicle`.`model_no` = `model`.`description_id`)
 WHERE `customer_vehicle`.`company_id` IN (?,?) AND `customer_vehicle`.`customer_id` = {$customer_id} ORDER BY `customer_vehicle`.`date_created` DESC;";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->workshop_db->last_query());

            log_message("debug", "found customer_vehicles..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting customer_vehicles.');

            return false;
        }
    }
}
	
