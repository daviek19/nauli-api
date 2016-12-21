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
    }

    public function index() {
           
        print "<pre>";
        $abc = $this->company_model->get_company(2);
        var_dump($abc->current_payroll_month);
        
        print "</pre>";
//        $data = array(
//            'employee_id' => '2',
//            'payroll_month' => $this->company_model->get_company(2)->current_payroll_month
//        );
//
//        $this->payroll_model->create_posting($data);
    }

}
