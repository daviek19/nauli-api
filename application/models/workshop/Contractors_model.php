<?php

class Contractors_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_all_contractors($company_id = '0')
    {
        $select_query =
            "SELECT
    `contractors`.`contractor_id`
    , `contractors`.`company_id`
    , `contractors`.`contractor_name`
    , `contractors`.`id_no`
    , `contractors`.`pin_no`
    , `contractors`.`mobile_no`
    , `contractors`.`section_id`
    , `section`.`description_name` AS section_name
     , `contractors`.`location_id`
    , `location`.`description_name` AS location_name
    , `contractors`.`bank_id`
    , `bank`.`bank_name` AS bank_name
    , `bank`.`branch_name` AS branch_name
    , `contractors`.`account_no`
    , `contractors`.`active`
    , `contractors`.`user_id`
    , `contractors`.`date_created`
FROM
    `workshop`.`contractors`
    LEFT JOIN `workshop`.`parameter_description` AS `section`
        ON (`contractors`.`section_id` = `section`.`description_id`)
    LEFT JOIN `workshop`.`bank_master` AS `bank`
        ON (`contractors`.`bank_id` = `bank`.`bank_id`)
    LEFT JOIN `workshop`.`parameter_description` AS `location`
        ON (`contractors`.`location_id` = `location`.`description_id`)
         WHERE `contractors`.`company_id` IN (?,?) ORDER BY `contractors`.`date_created` DESC;";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->workshop_db->last_query());

            log_message("debug", "found contractors..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting contractors.');

            return false;
        }
    }

    public function get_single_contractor($company_id = '0', $contractor_id)
    {
        if (!empty($contractor_id)) {

            $select_query =
                "SELECT
    `contractors`.`contractor_id`
    , `contractors`.`company_id`
    , `contractors`.`contractor_name`
    , `contractors`.`id_no`
    , `contractors`.`pin_no`
    , `contractors`.`mobile_no`
    , `contractors`.`section_id`
    , `section`.`description_name` AS section_name
     , `contractors`.`location_id`
    , `location`.`description_name` AS location_name
    , `contractors`.`bank_id`
    , `bank`.`bank_name` AS bank_name
    , `bank`.`branch_name` AS branch_name
    , `contractors`.`account_no`
    , `contractors`.`active`
    , `contractors`.`user_id`
    , `contractors`.`date_created`
FROM
    `workshop`.`contractors`
    LEFT JOIN `workshop`.`parameter_description` AS `section`
        ON (`contractors`.`section_id` = `section`.`description_id`)
    LEFT JOIN `workshop`.`bank_master` AS `bank`
        ON (`contractors`.`bank_id` = `bank`.`bank_id`)
    LEFT JOIN `workshop`.`parameter_description` AS `location`
        ON (`contractors`.`location_id` = `location`.`description_id`)
         WHERE `contractors`.`contractor_id` = {$contractor_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->workshop_db->last_query());

                log_message("debug", "found contractor..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting contractor.');

                return false;
            }
        } else {
            //The vehicle_id was empty
            return FALSE;
        }
    }

    public function create_contractor($data)
    {
        log_message("debug", "create_contractor...data " . json_encode($data));

        if ($this->workshop_db->insert('contractors', $data)) {

            log_message("debug", "contractors query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('contractors', array('contractor_id' => $id));

            log_message("debug", " contractor created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function contractor_exists($contractor_name, $company_id)
    {
        $this->workshop_db->where('contractor_name', $contractor_name);

        $this->workshop_db->where('company_id', $company_id);

        $query = $this->workshop_db->get('contractors');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function update_contractor($data)
    {

        log_message("debug", "Getting ready to update_contractor... " . json_encode($data));

        if (empty($data['contractor_id'])) {

            log_message("debug", " contractor_id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('contractor_id', $data['contractor_id']);

        if ($this->workshop_db->update('contractors', $data) == FALSE) {

            return FALSE;
        }
        log_message("debug", "update_contractor " . $this->workshop_db->last_query());
        //All went well
        $new_record = $this->workshop_db->get_where('contractors', array('contractor_id' => $data['contractor_id']));

        log_message("debug", " update_contractor query " . $this->workshop_db->last_query());

        log_message("debug", "Contractor Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }

    public function contractor_id_exists($contractor_id)
    {
        $this->workshop_db->where('contractor_id', $contractor_id);

        $query = $this->workshop_db->get('contractors');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }
}