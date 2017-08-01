<?php

class Certificates_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }

    public function get_all_certificates($company_id = '0')
    {
        $select_query =
            "SELECT
    `hd_completion`.*
    , DATEDIFF(`hd_completion`.`completed_date`, `hd_completion`.`contract_date`) AS days_elapsed
    , `contractors`.`contractor_id`
    , `contractors`.`contractor_name`
    , `process`.`process_id`
    , `process`.`process_name`
    , `process`.`std_days`
    , `job_card`.`reg_no`
    , `job_card`.`work_desc`
    , `customer_vehicle`.`chassis_no`
    , (DATEDIFF(`hd_completion`.`completed_date`, `hd_completion`.`contract_date`) - `process`.`std_days`) AS days_overdue
FROM
    `workshop`.`hd_completion`
    INNER JOIN `workshop`.`job_card`
        ON (`hd_completion`.`job_id` = `job_card`.`job_id`)
    INNER JOIN `workshop`.`hd_contracts`
        ON (`hd_completion`.`contract_id` = `hd_contracts`.`contract_id`)
    INNER JOIN `workshop`.`contractors`
        ON (`hd_completion`.`contractor_id` = `contractors`.`contractor_id`)
    INNER JOIN `workshop`.`vehicle_master`
        ON (`job_card`.`boq_veh_id` = `vehicle_master`.`vehicle_id`)
    INNER JOIN `workshop`.`customer_vehicle`
        ON (`job_card`.`customer_vehicle_id` = `customer_vehicle`.`customer_vehicle_id`)
    INNER JOIN `workshop`.`customer`
        ON (`hd_contracts`.`cust_id` = `customer`.`customer_id`)
    INNER JOIN `workshop`.`process`
        ON (`hd_contracts`.`process_id` = `process`.`process_id`)
         WHERE `hd_completion`.`company_id` IN (?,?) ORDER BY `hd_completion`.`date_created` DESC;";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->workshop_db->last_query());

            log_message("debug", "found certificates..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting certificates.');

            return false;
        }
    }

    public function get_single_certificate($company_id = '0', $certificate_id)
    {
        if (!empty($certificate_id)) {

            $select_query =
                "SELECT
    `hd_completion`.*
    , DATEDIFF(`hd_completion`.`completed_date`, `hd_completion`.`contract_date`) AS days_elapsed
    , `contractors`.`contractor_id`
    , `contractors`.`contractor_name`
    , `process`.`process_id`
    , `process`.`process_name`
    , `process`.`std_days`
    , `job_card`.`reg_no`
    , `job_card`.`work_desc`
    , `customer_vehicle`.`chassis_no`
    , (DATEDIFF(`hd_completion`.`completed_date`, `hd_completion`.`contract_date`) - `process`.`std_days`) AS days_overdue
FROM
    `workshop`.`hd_completion`
    INNER JOIN `workshop`.`job_card`
        ON (`hd_completion`.`job_id` = `job_card`.`job_id`)
    INNER JOIN `workshop`.`hd_contracts`
        ON (`hd_completion`.`contract_id` = `hd_contracts`.`contract_id`)
    INNER JOIN `workshop`.`contractors`
        ON (`hd_completion`.`contractor_id` = `contractors`.`contractor_id`)
    INNER JOIN `workshop`.`vehicle_master`
        ON (`job_card`.`boq_veh_id` = `vehicle_master`.`vehicle_id`)
    INNER JOIN `workshop`.`customer_vehicle`
        ON (`job_card`.`customer_vehicle_id` = `customer_vehicle`.`customer_vehicle_id`)
    INNER JOIN `workshop`.`customer`
        ON (`hd_contracts`.`cust_id` = `customer`.`customer_id`)
    INNER JOIN `workshop`.`process`
        ON (`hd_contracts`.`process_id` = `process`.`process_id`)
         WHERE `hd_completion`.`certificate_id` = {$certificate_id};";

            if ($query = $this->workshop_db->query($select_query)) {

                log_message("debug", $this->workshop_db->last_query());

                log_message("debug", "found certificate..." . json_encode($query->result()));

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

    public function get_completed_activities_id($certificate_id)
    {
        $select_query =
            "SELECT
            `activities`.`activity_name`
            , `dt_completion`.`activity_id`
            , `dt_completion`.`date_created`
        FROM
            `workshop`.`dt_completion`
            INNER JOIN `workshop`.`activities`
                ON (`dt_completion`.`activity_id` = `activities`.`activity_id`)
           WHERE certificate_id ={$certificate_id}";

        if ($query = $this->workshop_db->query($select_query)) {

            log_message("debug", $this->workshop_db->last_query());

            log_message("debug", "found completed_activities..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting certificates.');

            return false;
        }
    }
	
	public function create_certificate($data)
    {
        log_message("debug", "create_certificate...data " . json_encode($data));

        if ($this->workshop_db->insert('hd_completion', $data)) {

            log_message("debug", "certificate query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();

            $new_record = $this->workshop_db->get_where('hd_completion', array('certificate_id' => $id));

            log_message("debug", " certificate created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }
	
	public function update_certificate($data)
    {               
        $this->workshop_db->where('certificate_id', $data['certificate_id']);

        if ($this->workshop_db->update('hd_completion', $data) == FALSE) {

            return FALSE;
        }
		
        log_message("debug", "update_contracts " . $this->workshop_db->last_query());
        //All went well
        $new_record = $this->workshop_db->get_where('hd_completion', array('certificate_id' => $data['certificate_id']));

        log_message("debug", " update_contract query " . $this->workshop_db->last_query());

        log_message("debug", "Contract Updated " . json_encode($new_record->row()));

        return $new_record->row();
    }
	
	public function create_work_done($certificate_id,$work_done){
		log_message("debug", "work done" . json_encode($work_done));

		if(!empty($work_done)){
			$this->workshop_db->delete('dt_completion', array('certificate_id ' => $certificate_id)); 		
			$this->workshop_db->insert_batch('dt_completion', $work_done); 
			log_message("debug", "create_work_done" . $this->workshop_db->last_query());
		}		
	}
}
