<?php

class Requisitions_model extends CI_Model
{
    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_all_requisations($company_id = '0')
    {

        $select_query =
            "SELECT
    `requisition`.`company_id`
    ,`requisition`.`req_id`
    ,`requisition`.`req_date`
    ,`requisition`.`job_no`
    ,`requisition`.`job_date`
    ,`requisition`.`requested_by`
    ,`requisition`.`section_id`
    ,`requisition`.`chassis_no`
    ,`requisition`.`status`
    ,`requisition`.`cancel`
     ,`requisition`.`date_created`
    , `parameter_description`.`description_id`
    , `parameter_description`.`description_name`
    , `contractors`.`contractor_id`
    , `contractors`.`contractor_name`
    , `customer`.`customer_id`
    , `customer`.`customer_name`
    , `customer_vehicle`.`chassis_no`
    , `customer_vehicle`.`engine_no`
    , `job_card`.`job_id`
FROM
    `workshop`.`requisition`
    INNER JOIN `workshop`.`job_card`
        ON (`requisition`.`job_no` = `job_card`.`job_id`)
    INNER JOIN `workshop`.`contractors`
        ON (`requisition`.`requested_by` = `contractors`.`contractor_id`)
    INNER JOIN `workshop`.`parameter_description`
        ON (`requisition`.`section_id` = `parameter_description`.`description_id`)
    INNER JOIN `workshop`.`customer_vehicle`
        ON (`job_card`.`customer_vehicle_id` = `customer_vehicle`.`customer_vehicle_id`)
    INNER JOIN `workshop`.`customer`
        ON (`customer_vehicle`.`customer_id` = `customer`.`customer_id`)
							WHERE `requisition`.`company_id` IN (?,?) ORDER BY `requisition`.`date_created` DESC;";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found requisations..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting requisations.');

            return false;
        }
    }

}
