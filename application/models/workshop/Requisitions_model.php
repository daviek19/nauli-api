<?php

class Requisitions_model extends CI_Model {

    private $workshop_db;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_all_requisations($company_id = '0') {

        $select_query = "SELECT
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
    , `process`.`process_id`
    , `process`.`process_name`
    , `contractors`.`contractor_id`
    , `contractors`.`contractor_name`
    , `customer`.`customer_id`
    , `customer`.`customer_name`
    , `customer_vehicle`.`chassis_no`
    , `customer_vehicle`.`engine_no`
    , `job_card`.`job_id`
    , `model`.`description_name` AS `vehicle_model`
    , `vehicle_make`.`description_name` AS `vehicle_make`
FROM
    `workshop`.`requisition`
    INNER JOIN `workshop`.`job_card`
        ON (`requisition`.`job_no` = `job_card`.`job_id`)
    INNER JOIN `workshop`.`contractors`
        ON (`requisition`.`requested_by` = `contractors`.`contractor_id`)
    INNER JOIN `workshop`.`process`
        ON (`requisition`.`section_id` = `process`.`process_id`)
    INNER JOIN `workshop`.`customer_vehicle`
        ON (`job_card`.`customer_vehicle_id` = `customer_vehicle`.`customer_vehicle_id`)
    INNER JOIN `workshop`.`customer`
        ON (`customer_vehicle`.`customer_id` = `customer`.`customer_id`)
        
    INNER JOIN `workshop`.`vehicle_master`
        ON (`job_card`.`boq_veh_id` = `vehicle_master`.`vehicle_id`)
    INNER JOIN `workshop`.`parameter_description` AS `vehicle_make`
        ON (`vehicle_master`.`make_id` = `vehicle_make`.`description_id`)
    INNER JOIN `workshop`.`parameter_description` AS `model`
        ON (`vehicle_master`.`model_no` = `model`.`description_id`)        
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

    public function create_requisation($data) {

        log_message("debug", "create_requisation...data " . json_encode($data));

        if ($this->workshop_db->insert('requisition', $data)) {

            log_message("debug", "requisition query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('requisition', array('req_id' => $id));

            log_message("debug", " requisition created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function get_single_requisations($company_id = '0', $requisition_id) {
        if (!empty($requisition_id)) {

            $select_query = "SELECT
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
    , `process`.`process_id`
    , `process`.`process_name`
    , `contractors`.`contractor_id`
    , `contractors`.`contractor_name`
    , `customer`.`customer_id`
    , `customer`.`customer_name`
    , `customer_vehicle`.`chassis_no`
    , `customer_vehicle`.`engine_no`
    , `job_card`.`job_id`
    , `model`.`description_name` AS `vehicle_model`
    , `vehicle_make`.`description_name` AS `vehicle_make`
     ,`customer_vehicle`.`vehicle_id`
FROM
    `workshop`.`requisition`
    INNER JOIN `workshop`.`job_card`
        ON (`requisition`.`job_no` = `job_card`.`job_id`)
    INNER JOIN `workshop`.`contractors`
        ON (`requisition`.`requested_by` = `contractors`.`contractor_id`)
    INNER JOIN `workshop`.`process`
        ON (`requisition`.`section_id` = `process`.`process_id`)
    INNER JOIN `workshop`.`customer_vehicle`
        ON (`job_card`.`customer_vehicle_id` = `customer_vehicle`.`customer_vehicle_id`)
    INNER JOIN `workshop`.`customer`
        ON (`customer_vehicle`.`customer_id` = `customer`.`customer_id`)
        
    INNER JOIN `workshop`.`vehicle_master`
        ON (`job_card`.`boq_veh_id` = `vehicle_master`.`vehicle_id`)
    INNER JOIN `workshop`.`parameter_description` AS `vehicle_make`
        ON (`vehicle_master`.`make_id` = `vehicle_make`.`description_id`)
    INNER JOIN `workshop`.`parameter_description` AS `model`
        ON (`vehicle_master`.`model_no` = `model`.`description_id`)
WHERE `requisition`.`req_id` = {$requisition_id};";


            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->workshop_db->last_query());

                log_message("debug", "found requisition..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting contract.');

                return false;
            }
        } else {
            //The vehicle_id was empty
            return FALSE;
        }
    }

    public function update_requisition($data) {
        if (empty($data['req_id'])) {

            log_message("debug", " req_id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('req_id', $data['req_id']);

        if ($this->workshop_db->update('requisition', $data) == FALSE) {

            return FALSE;
        }

        log_message("debug", "update_requisition " . $this->workshop_db->last_query());
        //All went well
        $new_record = $this->workshop_db->get_where('requisition', array('req_id' => $data['req_id']));

        log_message("debug", " update_requisition query " . $this->workshop_db->last_query());

        log_message("debug", " Requisition Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }

    public function boq_drop_down($vehicle_id, $section_id, $requisition_id) {
        if (!empty($requisition_id) && !empty($section_id) && !empty($vehicle_id)) {

            $select_query = "SELECT
                `boq`.`item_id`
                , `boq`.`qty`
                , `boq`.`section_id`
                , `boq`.`vehicle_id`
                , `items`.`item_name`
                , `items`.`item_id`
                , `parameter_description`.`description_name`
            FROM
                `workshop`.`boq`
                INNER JOIN `workshop`.`items`
                    ON (`boq`.`item_id` = `items`.`item_id`)
                INNER JOIN `workshop`.`parameter_description`
                    ON (`items`.`description_id` = `parameter_description`.`description_id`)
             WHERE `boq`.`vehicle_id` = {$vehicle_id} AND `boq`.`section_id` = {$section_id}
             AND `items`.`item_id` NOT IN(SELECT `dt_requisition`.`part_no`
                     FROM `workshop`.`dt_requisition`
                     WHERE `dt_requisition`.`req_id` = {$requisition_id});";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->workshop_db->last_query());

                log_message("debug", "found boq_drop_down materials..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting boq_drop_down materials.');

                return false;
            }
        } else {
            //The vehicle_id was empty
            return FALSE;
        }
    }

    public function get_requisition_materials($requisition_id) {
        if (!empty($requisition_id)) {

            $select_query = "SELECT
            `dt_requisition`.`company_id`
            , `dt_requisition`.`req_id`
            , `dt_requisition`.`req_date`
            , `dt_requisition`.`part_no`
            , `dt_requisition`.`qty_required`
            , `dt_requisition`.`qty_issued`
             , `dt_requisition`.`id`
            , `items`.`item_no`
            , `items`.`item_name`
            , `parameter_description`.`description_name`
        FROM
            `workshop`.`dt_requisition`
            INNER JOIN `workshop`.`items`
                ON (`dt_requisition`.`part_no` = `items`.`item_id`)
            INNER JOIN `workshop`.`parameter_description`
                ON (`items`.`description_id` = `parameter_description`.`description_id`)
        WHERE `dt_requisition`.`req_id` = {$requisition_id};";


            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->workshop_db->last_query());

                log_message("debug", "found requisition materials..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting requisition materials.');

                return false;
            }
        } else {
            //The vehicle_id was empty
            return FALSE;
        }
    }

    public function add_material($data) {
        log_message("debug", "add_material...data " . json_encode($data));

        if ($this->workshop_db->insert('dt_requisition', $data)) {

            log_message("debug", "add_material query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('dt_requisition', array('id' => $id));

            log_message("debug", " requisition created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function update_material($data) {
        if (empty($data['id'])) {

            log_message("debug", " id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('id', $data['id']);

        if ($this->workshop_db->update('dt_requisition', $data) == FALSE) {

            return FALSE;
        }

        log_message("debug", "update_requisition material " . $this->workshop_db->last_query());
        //All went well
        $new_record = $this->workshop_db->get_where('dt_requisition', array('id' => $data['id']));

        log_message("debug", " update_requisition material query " . $this->workshop_db->last_query());

        log_message("debug", " Requisition material Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }

     public function requisition_exists($job_id, $section_id) {

        $this->workshop_db->where('job_no', $job_id);

        $this->workshop_db->where('section_id', $section_id);

        $query = $this->workshop_db->get('requisition');

        log_message("debug", "requisition exists " . $this->workshop_db->last_query());

        if ($query->num_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }
}
