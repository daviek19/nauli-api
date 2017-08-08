<?php

class Close_jobs_model extends CI_Model
{

    private $workshop_db;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->workshop_db = $this->load->database('workshop', true);
    }
	
	 public function get_all_closed_jobs($company_id = '0')
    {
        $select_query =
            "SELECT
      `close_job`.*
    , `job_card`.`job_id`
    , `job_card`.`reg_no`
    , `job_card`.`work_desc`
    , `customer`.`customer_id`
    , `customer`.`customer_name`
   FROM
    `workshop`.`close_job`
    INNER JOIN `workshop`.`customer` 
        ON (`close_job`.`cust_id` = `customer`.`customer_id`)
    INNER JOIN `workshop`.`job_card` 
        ON (`close_job`.`job_no` = `job_card`.`job_id`)
       WHERE `close_job`.`company_id` IN (?,?) ORDER BY `close_job`.`date_created` DESC;";

        if ($query = $this->workshop_db->query($select_query, array($company_id, '0'))) {

            log_message("debug", $this->workshop_db->last_query());

            log_message("debug", "found closed_jobs..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting closed_jobs.');

            return false;
        }
    }	
		
    public function close_jobcard($data)
    {
        if ($this->workshop_db->insert('close_job', $data)) {

            log_message("debug", "close_jobcard query " . $this->workshop_db->last_query());

            $id = $this->workshop_db->insert_id();
			
			$this->jobcard_flag_closed($data['job_no'],$id);

            $new_record = $this->workshop_db->get_where('close_job', array('close_no' => $id));

            log_message("debug", " close_jobcard closed " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }
	
	public function jobcard_flag_closed($job_id,$close_id){	
		$data = array(
				'job_id' => $job_id,
				'job_closed_id' => $close_id,						
			);	
				
		$this->workshop_db->where('job_id', $data['job_id']);
        $this->workshop_db->update('job_card', $data); 
	}
}
