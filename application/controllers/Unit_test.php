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
        var_dump($this->contracts_model->contract_exists($job_id=1, $process_id=14,$company_id=2));
        //$result2 = $this->items_model->get_all_items(2);
        //$result = $this->items_model->get_single_item("", 1);
        print "<pre>";
        //print_r($result2);
        //print_r($result);
    }

}
