<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Certificates extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('workshop/certificates_model');
        $this->load->model('workshop/activities_model');
    }

    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->certificates_model->get_all_certificates($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/Certificates/company_id/] or to get single [/workshop/Certificates/company_id/item_id]'
        ], REST_Controller::HTTP_OK);

    }

    public function find_get()
    {
        $certificate_id = (int)$this->get('certificate_id');

        $result = $this->certificates_model->get_single_certificate("", $certificate_id);
        $all_activities= $this->activities_model->get_process_activities($result[0]->company_id, $result[0]->process_id);
        $completed_activities = $this->certificates_model->get_completed_activities_id($certificate_id);
        $this->response([
            'response' => $result,
            'all_activities'=>$all_activities,
            'completed_activities'=>$completed_activities,
            'status' => TRUE,
            'description' => 'To get all [/workshop/contractors/company_id/] or to get single [/workshop/contractors/company_id/bank_id]'
        ], REST_Controller::HTTP_OK);
    }
}