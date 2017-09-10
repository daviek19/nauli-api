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
        $this->load->model('workshop/functions_model');

    }

    public function index() {
        $arr = array('Hello','World!','Beautiful','Day!');
        var_dump(implode(" ",$arr))."<br>";
    }

}
