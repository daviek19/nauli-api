<?php

class Contracts_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_all_contracts($company_id = '0')
    {
        $select_query =
            "SELECT
    `hd_contracts`.`contract_id`
    , `hd_contracts`.`job_id`
    , `hd_contracts`.`company_id`
    , `hd_contracts`.`contract_date`
    , `hd_contracts`.`start_date`
    , `hd_contracts`.`end_date`
    , `hd_contracts`.`amount`
    , `hd_contracts`.`contractor_id`
    , `hd_contracts`.`date_created`
    , `hd_contracts`.`cust_id`
    , `customer_vehicle`.`chassis_no`
    , `customer`.`customer_name`
    , `contractors`.`contractor_name`
    , `job_card`.`job_date`
    , `job_card`.`reg_no`
    , `customer_vehicle`.`engine_no`
    , `process`.`process_name`
    , `process`.`std_days`

FROM
    `workshop`.`hd_contracts`
    INNER JOIN `workshop`.`job_card`
        ON (`hd_contracts`.`job_id` = `job_card`.`job_id`)
    INNER JOIN `workshop`.`customer`
        ON (`hd_contracts`.`cust_id` = `customer`.`customer_id`)
    INNER JOIN `workshop`.`contractors`
        ON (`hd_contracts`.`contractor_id` = `contractors`.`contractor_id`)
    INNER JOIN `workshop`.`process`
        ON (`hd_contracts`.`process_id` = `process`.`process_id`)
    INNER JOIN `workshop`.`customer_vehicle`
        ON (`job_card`.`customer_vehicle_id` = `customer_vehicle`.`customer_vehicle_id`)
          WHERE `hd_contracts`.`company_id` IN (?,?) ORDER BY `hd_contracts`.`date_created` DESC;";
        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->workshop_db->last_query());

            log_message("debug", "found contracts..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting contracts.');

            return false;
        }
    }
}