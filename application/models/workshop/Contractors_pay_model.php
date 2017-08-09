<?php

class Contractors_pay_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }
	
	public function get_all_payments($company_id = '0')
    {
        $select_query =
            "SELECT
    `contractor_pay`.*
    , `contractors`.`contractor_name`
    , `process`.`process_name`
	, `hd_contracts`.`chassis_no`

FROM
    `workshop`.`contractor_pay`
    INNER JOIN `workshop`.`contractors` 
        ON (`contractor_pay`.`contractor_id` = `contractors`.`contractor_id`)
    INNER JOIN `workshop`.`hd_contracts` 
        ON (`contractor_pay`.`contract_id` = `hd_contracts`.`contract_id`)
    INNER JOIN `workshop`.`process` 
        ON (`contractor_pay`.`process_id` = `process`.`process_id`)   
        WHERE `contractor_pay`.`company_id` IN (?,?);";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found departments..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting departments.');

            return false;
        }
    }
	
	public function get_single_payment($company_id = '0', $pay_id)
    {
        if (!empty($pay_id)) {
            $select_query =
                   "SELECT
    `contractor_pay`.*
    , `contractors`.`contractor_name`
    , `process`.`process_name`
	, `hd_contracts`.`chassis_no`

FROM
    `workshop`.`contractor_pay`
    INNER JOIN `workshop`.`contractors` 
        ON (`contractor_pay`.`contractor_id` = `contractors`.`contractor_id`)
    INNER JOIN `workshop`.`hd_contracts` 
        ON (`contractor_pay`.`contract_id` = `hd_contracts`.`contract_id`)
    INNER JOIN `workshop`.`process` 
        ON (`contractor_pay`.`process_id` = `process`.`process_id`)
        WHERE `contractor_pay`.`pay_id` = {$pay_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->workshop_db->last_query());

                log_message("debug", "found payments..." . json_encode($query->result()));

                return $query->result();
            } else {

                log_message("error", 'Error getting payments.');

                return false;
            }
        } else {
            //The vehicle_id was empty
            return FALSE;
        }
    }
	
	public function create_payment($data)
    {
        log_message("debug", "create_payment...data " . json_encode($data));

        if ($this->workshop_db->insert('contractor_pay', $data)) {

            log_message("debug", "contractor_pay query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('contractor_pay', array('pay_id' => $id));

            log_message("debug", " payment created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }
	
	
	public function update_payment($data)
    {
        log_message("debug", "Getting ready to update_payment... " . json_encode($data));

        $this->workshop_db->where('pay_id', $data['pay_id']);

        if ($this->workshop_db->update('contractor_pay', $data) == FALSE) {

            return FALSE;
        }
		
        //All went well
        $new_record = $this->workshop_db->get_where('contractor_pay', array('pay_id' => $data['pay_id']));

        log_message("debug", " update_customer_vehicle query " . $this->workshop_db->last_query());

        log_message("debug", "contractor_pay Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }
}