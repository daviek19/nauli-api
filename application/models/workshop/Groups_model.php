<?php

class Groups_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_all_groups($company_id = '0')
    {

        log_message("debug", "*********** fetching get_all_groups ***********");

        $select_query = "SELECT * FROM `group_master`
					WHERE `company_id` IN (?,?) ORDER BY `date_created` DESC;";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found departments..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting departments.');

            return false;
        }
    }

    public function get_single_group($company_id = '0', $group_id)
    {
        log_message("debug", "*********** fetching get_single_group ***********");

        if (!empty($group_id)) {

            $select_query = "SELECT * FROM `group_master`
                        WHERE `group_id` = {$group_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->db->last_query());

                log_message("debug", "found group..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting group.');

                return false;
            }
        } else {
            //The department_id was empty
            return FALSE;
        }
    }

    public function create_group($data)
    {
        log_message("debug", "create_group...data " . json_encode($data));

        if ($this->workshop_db->insert('group_master', $data)) {

            log_message("debug", "group create query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('group_master', array('group_id' => $id));

            log_message("debug", " group created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function group_exists($group_name, $company_id)
    {

        $this->workshop_db->where('group_name', $group_name);

        $this->workshop_db->where('company_id', $company_id);

        $query = $this->workshop_db->get('group_master');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    public function update_group($data)
    {

        log_message("debug", "Getting ready to update_group... " . json_encode($data));

        if (empty($data['group_id'])) {

            log_message("debug", " group id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('group_id', $data['group_id']);

        if ($this->workshop_db->update('group_master', $data) == FALSE) {

            return FALSE;
        }

        //All went well
        $new_record = $this->workshop_db->get_where('group_master', array('group_id' => $data['group_id']));

        log_message("debug", " update_group query " . $this->workshop_db->last_query());

        log_message("debug", " Group Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }

    public function group_id_exists($group_id)
    {
        $this->workshop_db->where('group_id', $group_id);

        $query = $this->workshop_db->get('group_master');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

}