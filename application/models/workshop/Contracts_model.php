<?php

class Contracts_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_all_contracts($company_id = '0')
    {
        $select_query =
            "SELECT
    `hd_contracts`.`contract_id`
    , `hd_contracts`.`job_id`
    , `hd_contracts`.`company_id`
    , `hd_contracts`.`contract_date`
    , `hd_contracts`.`start_date`
    , `hd_contracts`.`end_date`
    , `hd_contracts`.`amount`
    , `hd_contracts`.`contractor_id`
    , `hd_contracts`.`date_created`
    , `hd_contracts`.`cust_id`
	, `hd_contracts`.`process_id`
	, `hd_contracts`.`vc_reason`
	, `hd_contracts`.`ch_cancel`
    , `customer_vehicle`.`chassis_no`
    , `customer`.`customer_name`
    , `contractors`.`contractor_name`
    , `job_card`.`job_date`
    , `job_card`.`reg_no`
    , `customer_vehicle`.`engine_no`
    , `process`.`process_name`
    , `process`.`std_days`

FROM
    `workshop`.`hd_contracts`
    INNER JOIN `workshop`.`job_card`
        ON (`hd_contracts`.`job_id` = `job_card`.`job_id`)
    INNER JOIN `workshop`.`customer`
        ON (`hd_contracts`.`cust_id` = `customer`.`customer_id`)
    INNER JOIN `workshop`.`contractors`
        ON (`hd_contracts`.`contractor_id` = `contractors`.`contractor_id`)
    INNER JOIN `workshop`.`process`
        ON (`hd_contracts`.`process_id` = `process`.`process_id`)
    INNER JOIN `workshop`.`customer_vehicle`
        ON (`job_card`.`customer_vehicle_id` = `customer_vehicle`.`customer_vehicle_id`)
          WHERE `hd_contracts`.`company_id` IN (?,?) AND `hd_contracts`.`ch_cancel` != 1 ORDER BY `hd_contracts`.`date_created` DESC;";
        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->workshop_db->last_query());

            log_message("debug", "found contracts..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting contracts.');

            return false;
        }
    }

    public function get_single_contract($company_id = '0', $contract_id)
    {
        if (!empty($contract_id)) {

            $select_query =
                "SELECT
    `hd_contracts`.`contract_id`
    , `hd_contracts`.`job_id`
    , `hd_contracts`.`company_id`
    , `hd_contracts`.`contract_date`
    , `hd_contracts`.`start_date`
    , `hd_contracts`.`end_date`
    , `hd_contracts`.`amount`
    , `hd_contracts`.`contractor_id`
    , `hd_contracts`.`date_created`
    , `hd_contracts`.`cust_id`
	, `hd_contracts`.`process_id`
	, `hd_contracts`.`vc_reason`
	, `hd_contracts`.`ch_cancel`
    , `customer_vehicle`.`chassis_no`
    , `customer`.`customer_name`
    , `contractors`.`contractor_name`
    , `job_card`.`job_date`
    , `job_card`.`reg_no`
    , `customer_vehicle`.`engine_no`
    , `process`.`process_name`
    , `process`.`std_days`

FROM
    `workshop`.`hd_contracts`
    INNER JOIN `workshop`.`job_card`
        ON (`hd_contracts`.`job_id` = `job_card`.`job_id`)
    INNER JOIN `workshop`.`customer`
        ON (`hd_contracts`.`cust_id` = `customer`.`customer_id`)
    INNER JOIN `workshop`.`contractors`
        ON (`hd_contracts`.`contractor_id` = `contractors`.`contractor_id`)
    INNER JOIN `workshop`.`process`
        ON (`hd_contracts`.`process_id` = `process`.`process_id`)
    INNER JOIN `workshop`.`customer_vehicle`
        ON (`job_card`.`customer_vehicle_id` = `customer_vehicle`.`customer_vehicle_id`)
         WHERE `hd_contracts`.`contract_id` = {$contract_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->workshop_db->last_query());

                log_message("debug", "found contract..." . json_encode($query->result()));

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

    public function create_contract($data)
    {
        log_message("debug", "create_contract...data " . json_encode($data));

        if ($this->workshop_db->insert('hd_contracts', $data)) {

            log_message("debug", "contracts query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('hd_contracts', array('contract_id' => $id));

            log_message("debug", " contractor created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    public function update_contract($data)
    {

        log_message("debug", "Getting ready to update_contracts... " . json_encode($data));

        if (empty($data['contract_id'])) {

            log_message("debug", " contract id was empty. Exit");

            return FALSE;
        }

        $this->workshop_db->where('contract_id', $data['contract_id']);

        if ($this->workshop_db->update('hd_contracts', $data) == FALSE) {

            return FALSE;
        }
        log_message("debug", "update_contracts " . $this->workshop_db->last_query());
        //All went well
        $new_record = $this->workshop_db->get_where('hd_contracts', array('contract_id' => $data['contract_id']));

        log_message("debug", " update_contract query " . $this->workshop_db->last_query());

        log_message("debug", "Contract Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }

}