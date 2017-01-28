<?php

class Paygrades_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // --------------------------------------------------------------------

    /**
     * Create a single paygrade
     *  
     * @param	array	$data
     * @return	array
     */
    public function create_paygrade($data) {

        log_message("debug", "create_paygrade...data " . json_encode($data));

        if ($this->db->insert('pay_grades', $data)) {

            log_message("debug", "paygrades create query " . $this->db->last_query());

            $id = $this->db->insert_id();

            $new_record = $this->db->get_where('pay_grades', array('pay_grade_id' => $id));

            log_message("debug", " paygrades created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Get a single paygrades
     *  
     * @param	string	$company_id default company id which is 0
     * @return	array
     */
    public function get_all_paygrades($company_id = '0') {

        log_message("debug", "*********** fetching get_all_paygrades ***********");

        $select_query = "SELECT * FROM `pay_grades` WHERE `company_id` IN (?,?) ORDER BY `date_created` DESC;";

        if ($query = $this->db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found paygrades..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting paygrades.');

            return false;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Get a single department
     *
     * @param	string	$$paygrade_id
     * @param	string	$company_id default company id which is 0
     * @return	bool
     */
    public function get_single_paygrade($company_id = '0', $paygrade_id) {

        log_message("debug", "*********** fetching get_single_paygrade ***********");

        if (!empty($paygrade_id)) {

            $select_query = "SELECT * FROM `pay_grades` 
                        WHERE `pay_grade_id` = {$paygrade_id};";

            if ($query = $this->db->query($select_query)) {

                log_message("debug", $this->db->last_query());

                log_message("debug", "found pay_grades..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting pay_grades.');

                return false;
            }
        } else {
            //The department_id was empty
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Check if a paygrade exists in the db
     *
     * @param	string	$paygrade_name
     * @return	bool
     */
    public function paygrade_exists($paygrade_name, $company_id) {

        $this->db->where('pay_grade_name', $paygrade_name);

        $this->db->where('company_id', $company_id);

        $query = $this->db->get('pay_grades');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Check if a paygrade_id exists in the db
     * This is important when updating.
     *
     * @param	string	$paygrade_id
     * @return	bool
     */
    public function paygrade_id_exists($paygrade_id) {

        $this->db->where('pay_grade_id', $paygrade_id);

        $query = $this->db->get('pay_grades');

        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    // --------------------------------------------------------------------

    /**
     *
     * @param array $data
     * @return	bool
     */
    public function update_paygrade($data) {

        log_message("debug", "Getting ready to update_paygrade... " . json_encode($data));

        if (empty($data['pay_grade_id'])) {

            log_message("debug", " pay_grade_id was empty. Exit");

            return FALSE;
        }

        $this->db->where('pay_grade_id', $data['pay_grade_id']);

        if ($this->db->update('pay_grades', $data) == FALSE) {

            return FALSE;
        }

        //All went well
        $new_record = $this->db->get_where('pay_grades', array('pay_grade_id' => $data['pay_grade_id']));

        log_message("debug", " update_paygrade query " . $this->db->last_query());

        log_message("debug", " Paygrade Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }

    // --------------------------------------------------------------------
}
