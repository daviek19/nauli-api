<?php

class Boqs_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_all_boqs($company_id = '0')
    {
        $select_query =
            "SELECT
      `boq`.`boq_id`
    , `boq`.`company_id`
    , `boq`.`vehicle_id`
	, `boq`.`section_id`
    , `vehicle`.`vehicle_name`
    , `section`.`description_name`
    , `boq`.`item_id`
    , `item`.`item_name`
    , `boq`.`qty`
    , `boq`.`user_id`
    , `boq`.`date_created`
FROM
    `workshop`.`boq`
    LEFT JOIN `workshop`.`vehicle_master` AS `vehicle`
        ON (`boq`.`vehicle_id` = `vehicle`.`vehicle_id`)
    LEFT JOIN `workshop`.`parameter_description` AS `section`
        ON (`boq`.`section_id` = `section`.`description_id`)
    LEFT JOIN `workshop`.`items` AS `item`
        ON (`boq`.`item_id` = `item`.`item_id`) WHERE `boq`.`company_id` IN (?,?) ORDER BY `boq`.`date_created` DESC;";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found boqs..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting boqs.');

            return false;
        }
    }

    public function get_single_boq($company_id = '0', $boq_id)
    {
        if (!empty($boq_id)) {

            $select_query =
                "SELECT
    `boq`.`boq_id`
    , `boq`.`company_id`
    , `boq`.`vehicle_id`
	, `boq`.`section_id`
    , `vehicle`.`vehicle_name`
    , `section`.`description_name`
    , `boq`.`item_id`
    , `item`.`item_name`
    , `boq`.`qty`
    , `boq`.`user_id`
    , `boq`.`date_created`
FROM
    `workshop`.`boq`
    LEFT JOIN `workshop`.`vehicle_master` AS `vehicle`
        ON (`boq`.`vehicle_id` = `vehicle`.`vehicle_id`)
    LEFT JOIN `workshop`.`parameter_description` AS `section`
        ON (`boq`.`section_id` = `section`.`description_id`)
    LEFT JOIN `workshop`.`items` AS `item`
        ON (`boq`.`item_id` = `item`.`item_id`) WHERE `boq`.`boq_id` = {$boq_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->workshop_db->last_query());

                log_message("debug", "found boq..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting boq.');

                return false;
            }
        } else {
            return FALSE;
        }
    }

    public function create_boq($data)
    {
        log_message("debug", "create_boq...data " . json_encode($data));

        if ($this->workshop_db->insert('boq', $data)) {

            log_message("debug", "boq query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('boq', array('boq_id' => $id));

            log_message("debug", " boq created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function boq_exists($vehicle_id,$item_id,$section_id, $company_id)
    {
        $this->workshop_db->where('vehicle_id', $vehicle_id);

        $this->workshop_db->where('item_id', $item_id);

        $this->workshop_db->where('section_id', $section_id);

        $this->workshop_db->where('company_id', $company_id);

        $query = $this->workshop_db->get('boq');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function update_boq($data)
    {
        log_message("debug", "Getting ready to update_boq... " . json_encode($data));

        if (empty($data['boq_id'])) {

            log_message("debug", "boq_id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('boq_id', $data['boq_id']);

        if ($this->workshop_db->update('boq', $data) == FALSE) {

            return FALSE;
        }
        log_message("debug", "update_boq " . $this->workshop_db->last_query());
        //All went well
        $new_record = $this->workshop_db->get_where('boq', array('boq_id' => $data['boq_id']));

        log_message("debug", "update_boq query " . $this->workshop_db->last_query());

        log_message("debug", "boq Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }

    public function boq_id_exists($boq_id)
    {
        $this->workshop_db->where('boq_id', $boq_id);

        $query = $this->workshop_db->get('boq');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }
}