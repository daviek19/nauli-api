<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Requisitions extends REST_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->model('workshop/requisitions_model');
    }

    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->requisitions_model->get_all_requisations($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => ''
        ], REST_Controller::HTTP_OK);

    }

}

