<?php

class Departments_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function create_department($data)
    {

        log_message("debug", "create_department...data " . json_encode($data));

        if ($this->db->insert('departments', $data)) {

            log_message("debug", "department create query " . $this->db->last_query());

            $id = $this->db->insert_id();

            $new_record = $this->db->get_where('departments', array('department_id' => $id));

            log_message("debug", " department created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Get a single department
     *
     * @param    string $department_id
     * @param    string $company_id default company id which is 0
     * @return    bool
     */
    public function get_single_department($company_id = '0', $department_id)
    {

        log_message("debug", "*********** fetching get_single_department ***********");

        if (!empty($department_id)) {

            $select_query = "SELECT * FROM `departments` 
                        WHERE `department_id` = {$department_id};";

            if ($query = $this->db->query($select_query)) {

                log_message("debug", $this->db->last_query());

                log_message("debug", "found department..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting department.');

                return false;
            }
        } else {
            //The department_id was empty
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Get a single department
     *
     * @param    string $department_id
     * @param    string $company_id default company id which is 0
     * @return    bool
     */
    public function get_all_departments($company_id = '0')
    {

        log_message("debug", "*********** fetching get_all_departments ***********");

        $select_query = "SELECT * FROM `departments` 
                        WHERE `company_id` IN (?,?) ORDER BY `date_created` DESC;";

        if ($query = $this->db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found departments..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting departments.');

            return false;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Check if a Valid id
     *
     * @param    string $department_name
     * @return    bool
     */
    public function update_department($data)
    {

        log_message("debug", "Getting ready to update_department... " . json_encode($data));

        if (empty($data['department_id'])) {

            log_message("debug", " Company name was empty. Exit");

            return FALSE;
        }

        $this->db->where('department_id', $data['department_id']);

        if ($this->db->update('departments', $data) == FALSE) {

            return FALSE;
        }

        //All went well
        $new_record = $this->db->get_where('departments', array('department_id' => $data['department_id']));

        log_message("debug", " update_department query " . $this->db->last_query());

        log_message("debug", " Department Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }

    // --------------------------------------------------------------------

    /**
     * Check if a departemnt exists in the db
     *
     * @param    string $department_name
     * @return    bool
     */
    public function department_exists($department_name, $company_id)
    {

        $this->db->where('department_name', $department_name);

        $this->db->where('company_id', $company_id);

        $query = $this->db->get('departments');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Check if a departemnt_id exists in the db
     *
     * @param    string $department_id
     * @return    bool
     */
    public function department_id_exists($department_id)
    {
        $this->db->where('department_id', $department_id);

        $query = $this->db->get('departments');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

}
