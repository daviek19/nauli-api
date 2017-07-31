<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Unit_test extends CI_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('company_model');
        $this->load->model('payroll_model');
        $this->load->model('departments_model');
		$this->load->model('workshop/groups_model');
        $this->load->model('workshop/items_model');
        $this->load->model('workshop/contracts_model');

    }

    public function index() {
        log_message("error", 'Unit testing...');
        $test =  ["2","6","1"];
				
		$work_done = array();
		 foreach($test as $item){				
				$work_done[] = array(
					'activity_id ' => $item,
					'company_id' => 1,
					'certificate_id' =>  1,
					'completed_date' =>  1,			
					'contract_id' => 1,			           
					'chassis_no' =>  1,			           
					'start_date' => 1,          
					'date_created' =>  1,					
					'user_id' => 1
					);
				};
		
		var_dump($work_done);
    }

}
