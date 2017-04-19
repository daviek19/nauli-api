<?php

class Customers_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }
	
	public function get_all_customers($company_id = '0')
    {
        $select_query =
		 "SELECT 
			`customer`.`customer_id`
			,`customer`.`company_id`
			,`customer`.`customer_name`
			,`customer`.`bill_address`
			,`customer`.`region_id`
			,`region`.`description_name` AS region_name
			,`customer`.`city_id`
			,`city`.`description_name` AS city_name
			,`customer`.`country_id`
			,`country`.`description_name` AS country_name
			,`customer`.`currency_id`
			,`currency`.`description_name` AS currency_name
			,`customer`.`pin_no`
			,`customer`.`contact_person`
			,`customer`.`contact_no`
			,`customer`.`customer_type_id`
			,`customertype`.`description_name` AS customer_type_name
			,`customer`.`credit_limit`
			,`customer`.`email`
			,`customer`.`mobile_no`
			,`customer`.`customer_category_id`
			,`customercategory`.`description_name` AS customer_category_name
			,`customer`.`user_id`
			,`customer`.`date_created`
			FROM `workshop`.`customer` 
			LEFT JOIN `workshop`.`parameter_description` AS `region`
				ON (`customer`.`region_id` = `region`.`description_id`)
			LEFT JOIN `workshop`.`parameter_description` AS `city`
			   ON (`customer`.`city_id` = `city`.`description_id`)
			LEFT JOIN `workshop`.`parameter_description` AS `country`
			   ON (`customer`.`country_id` = `country`.`description_id`)   
			LEFT JOIN `workshop`.`parameter_description` AS `currency`
			   ON (`customer`.`currency_id` = `currency`.`description_id`)
			LEFT JOIN `workshop`.`parameter_description` AS `customertype`
			   ON (`customer`.`customer_type_id` = `customertype`.`description_id`)
			LEFT JOIN `workshop`.`parameter_description` AS `customercategory`
			   ON (`customer`.`customer_category_id` = `customercategory`.`description_id`)
			   WHERE `customer`.`company_id` IN (?,?) ORDER BY `customer`.`date_created` DESC;";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->workshop_db->last_query());

            log_message("debug", "found customers..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting customers.');

            return false;
        }
    }
	
	 public function get_single_customer($company_id = '0', $customer_id)
    {
        if (!empty($customer_id)) {

            $select_query =
                "SELECT 
			`customer`.`customer_id`
			,`customer`.`company_id`
			,`customer`.`customer_name`
			,`customer`.`bill_address`
			,`customer`.`region_id`
			,`region`.`description_name` AS region_name
			,`customer`.`city_id`
			,`city`.`description_name` AS city_name
			,`customer`.`country_id`
			,`country`.`description_name` AS country_name
			,`customer`.`currency_id`
			,`currency`.`description_name` AS currency_name
			,`customer`.`pin_no`
			,`customer`.`contact_person`
			,`customer`.`contact_no`
			,`customer`.`customer_type_id`
			,`customertype`.`description_name` AS customer_type_name
			,`customer`.`credit_limit`
			,`customer`.`email`
			,`customer`.`mobile_no`
			,`customer`.`customer_category_id`
			,`customercategory`.`description_name` AS customer_category_name
			,`customer`.`user_id`
			,`customer`.`date_created`
			FROM `workshop`.`customer` 
			LEFT JOIN `workshop`.`parameter_description` AS `region`
				ON (`customer`.`region_id` = `region`.`description_id`)
			LEFT JOIN `workshop`.`parameter_description` AS `city`
			   ON (`customer`.`city_id` = `city`.`description_id`)
			LEFT JOIN `workshop`.`parameter_description` AS `country`
			   ON (`customer`.`country_id` = `country`.`description_id`)   
			LEFT JOIN `workshop`.`parameter_description` AS `currency`
			   ON (`customer`.`currency_id` = `currency`.`description_id`)
			LEFT JOIN `workshop`.`parameter_description` AS `customertype`
			   ON (`customer`.`customer_type_id` = `customertype`.`description_id`)
			LEFT JOIN `workshop`.`parameter_description` AS `customercategory`
			   ON (`customer`.`customer_category_id` = `customercategory`.`description_id`)
         WHERE `customer`.`customer_id` = {$customer_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->workshop_db->last_query());

                log_message("debug", "found customer..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting customer.');

                return false;
            }
        } else {
            //The vehicle_id was empty
            return FALSE;
        }
    }

	public function create_customer($data)
    {
        log_message("debug", "create_customer...data " . json_encode($data));

        if ($this->workshop_db->insert('customer', $data)) {

            log_message("debug", "customer query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('customer', array('customer_id' => $id));

            log_message("debug", " customer created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }
	
	public function customer_exists($customer_name, $company_id)
    {
        $this->workshop_db->where('customer_name', $customer_name);

        $this->workshop_db->where('company_id', $company_id);

        $query = $this->workshop_db->get('customer');

        if ($query->num_rows() > 0) {
            return true;
        } else {

            return false;
        }
    }
	
	 public function update_customer($data)
    {

        log_message("debug", "Getting ready to update_customer... " . json_encode($data));

        if (empty($data['customer_id'])) {

            log_message("debug", " customer_id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('customer_id', $data['customer_id']);

        if ($this->workshop_db->update('customer', $data) == FALSE) {

            return FALSE;
        }
        log_message("debug", "update_customer " . $this->workshop_db->last_query());
        //All went well
        $new_record = $this->workshop_db->get_where('customer', array('customer_id' => $data['customer_id']));

        log_message("debug", " update_customer query " . $this->workshop_db->last_query());

        log_message("debug", "Customer Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }
	
	public function contractor_id_exists($customer_id)
    {
        $this->workshop_db->where('customer_id', $customer_id);

        $query = $this->workshop_db->get('customer');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }
}