<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Statutory extends REST_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('nhif_model');
        $this->load->model('paye_model');
    }

    public function nhif_get() {
        log_message("debug", "*********** nhif_get start  ***********");

        $result = $this->nhif_model->get_nhif_rates();

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get PAYE rates  [GET /statutory/payee]'
                ], REST_Controller::HTTP_OK);
    }

    public function paye_get() {
        log_message("debug", "*********** nhif_get start  ***********");

        $result = $this->paye_model->get_paye_rates();

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get NHIF rates  [GET /statutory/nhif]'
                ], REST_Controller::HTTP_OK);
    }

}
