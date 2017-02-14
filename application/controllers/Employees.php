<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Employees extends REST_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('employee_model');
    }

    public function types_get() {
        log_message("debug", "*********** nhif_get start  ***********");

        $result = $this->employee_model->get_employee_types();

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'NAN'
                ], REST_Controller::HTTP_OK);
    }

}
