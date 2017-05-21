<?php

class Jobcards_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_all_jobcards($company_id = '0')
    {
        $select_query =
            "SELECT
    `job_card`.`job_id`
    , `job_card`.`job_date`
    , `job_card`.`company_id`
    , `job_card`.`cust_id`
    , `customer`.`customer_name`
    , `customer`.`bill_address`
    , `customer`.`mobile_no`
    , `job_card`.`reg_no`
    , `job_card`.`milage`
    , `job_card`.`arrival_date`
    , `job_card`.`days`
    , `job_card`.`promised_date`
    , `job_card`.`work_no`
    , `job_card`.`boq_veh_id`
    , `job_card`.`work_desc`
    , `vehicle_master`.`model_no`
    , `vehicle_master`.`vehicle_code`
    , `model`.`description_name` AS `vehicle_model`
    , `vehicle_make`.`description_name` AS `vehicle_make`
    , `user`.`first_name`
    , `user`.`last_name`

FROM
    `workshop`.`job_card`
    INNER JOIN `workshop`.`customer`
        ON (`job_card`.`cust_id` = `customer`.`customer_id`)
    INNER JOIN `workshop`.`vehicle_master`
        ON (`job_card`.`boq_veh_id` = `vehicle_master`.`vehicle_id`)
    INNER JOIN `workshop`.`parameter_description` AS `vehicle_make`
        ON (`vehicle_master`.`make_id` = `vehicle_make`.`description_id`)
    INNER JOIN `workshop`.`parameter_description` AS `model`
        ON (`vehicle_master`.`model_no` = `model`.`description_id`)
        INNER JOIN `rest_api`.`people` AS `user`
        ON (`job_card`.`user_id` = `user`.`id`)
 WHERE `job_card`.`company_id` IN (?,?) ORDER BY `job_card`.`date_created` DESC;";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found jobcards..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting processes.');

            return false;
        }
    }

    public function get_single_jobcard($company_id = '0', $jobcard_id)
    {

        if (!empty($jobcard_id)) {
            $select_query = "
            SELECT
    `job_card`.`job_id`
    , `job_card`.`job_date`
    , `job_card`.`cust_id`
    , `job_card`.`company_id`
    , `customer`.`customer_name`
    , `customer`.`bill_address`
    , `customer`.`mobile_no`
    , `job_card`.`reg_no`
    , `job_card`.`milage`
    , `job_card`.`arrival_date`
    , `job_card`.`days`
    , `job_card`.`promised_date`
    , `job_card`.`work_no`
    , `job_card`.`boq_veh_id`
    , `job_card`.`work_desc`
    , `vehicle_master`.`model_no`
    , `vehicle_master`.`vehicle_code`
    , `model`.`description_name` AS `vehicle_model`
    , `vehicle_make`.`description_name` AS `vehicle_make`
    , `user`.`first_name`
    , `user`.`last_name`

FROM
    `workshop`.`job_card`
    INNER JOIN `workshop`.`customer`
        ON (`job_card`.`cust_id` = `customer`.`customer_id`)
    INNER JOIN `workshop`.`vehicle_master`
        ON (`job_card`.`boq_veh_id` = `vehicle_master`.`vehicle_id`)
    INNER JOIN `workshop`.`parameter_description` AS `vehicle_make`
        ON (`vehicle_master`.`make_id` = `vehicle_make`.`description_id`)
    INNER JOIN `workshop`.`parameter_description` AS `model`
        ON (`vehicle_master`.`model_no` = `model`.`description_id`)
        INNER JOIN `rest_api`.`people` AS `user`
        ON (`job_card`.`user_id` = `user`.`id`)
							WHERE `job_card`.`job_id` = {$jobcard_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->db->last_query());

                log_message("debug", "found jobcard..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting jobcards.');

                return false;
            }
        } else {
            //The department_id was empty
            return FALSE;
        }
    }

    public function create_jobcard($data)
    {
        if ($this->workshop_db->insert('job_card', $data)) {

            log_message("debug", "create_jobcard query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('job_card', array('job_id' => $id));

            log_message("debug", " create_jobcard created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function update_jobcard($data)
    {

        if (empty($data['job_id'])) {

            log_message("debug", " job_id was empty. Exit");

            return FALSE;
        }
        $this->workshop_db->where('job_id', $data['job_id']);

        if ($this->workshop_db->update('job_card', $data) == FALSE) {

            return FALSE;
        }
        log_message("debug", "update_jobcard " . $this->workshop_db->last_query());
        //All went well
        $new_record = $this->workshop_db->get_where('job_card', array('job_id' => $data['job_id']));

        log_message("debug", " update_jobcard query " . $this->workshop_db->last_query());

        log_message("debug", " jobcard Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }

    public function job_id_exists($job_id)
    {
        $this->workshop_db->where('job_id', $job_id);

        $query = $this->workshop_db->get('job_card');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }
}