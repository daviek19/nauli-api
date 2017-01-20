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
    }

    public function index() {
        parse_str(file_get_contents("php://input"), $put_vars);
        var_dump($put_vars);
        
        print "<pre>";

        $abc = $this->departments_model->get_single_department(1, 1);
        $cde = $this->departments_model->get_all_departments(2);

        //$abc = $this->company_model->get_company(2);
        var_dump($abc);

        print "</hr>";
        var_dump($cde);

        print "</pre>";
    }

}
