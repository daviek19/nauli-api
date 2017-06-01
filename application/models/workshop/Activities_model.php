<?php

class Activities_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_process_activities($company_id = '0', $process_id)
    {

        $select_query = "SELECT * FROM activities WHERE process_id = '$process_id' AND company_id='$company_id';";

        if ($query = $this->workshop_db->query($select_query)) {

            log_message("debug", $this->workshop_db->last_query());

            log_message("debug", "found activities..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting activities.');

            return false;
        }
    }

    public function create_activity($data)
    {

        if ($this->workshop_db->insert('activities', $data)) {

            log_message("debug", "create_activity query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('activities', array('activity_id' => $id));

            log_message("debug", " activity created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function update_activity($data)
    {

        if (empty($data['activity_id'])) {

            log_message("debug", " activity_id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('activity_id', $data['activity_id']);

        if ($this->workshop_db->update('activities', $data) == FALSE) {

            return FALSE;
        }
        log_message("debug", "update_activity " . $this->workshop_db->last_query());
        //All went well
        $new_record = $this->workshop_db->get_where('activities', array('activity_id' => $data['activity_id']));

        return $new_record->row();
    }

    public function get_single_activity($company_id = '0', $activity_id)
    {

        if (!empty($activity_id)) {

            $select_query = "SELECT * FROM `activities`
                        WHERE `activity_id` = {$activity_id};";


            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->db->last_query());

                log_message("debug", "found activity..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting activity.');

                return false;
            }
        } else {
            //The department_id was empty
            return FALSE;
        }
    }

}