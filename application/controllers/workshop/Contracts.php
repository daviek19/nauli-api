<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Contracts extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('workshop/contracts_model');
    }

    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->contracts_model->get_all_contracts($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/Contractors/company_id/] or to get single [/workshop/Contractors/company_id/item_id]'
        ], REST_Controller::HTTP_OK);

    }

    public function find_get()
    {
        $contract_id = (int)$this->get('contract_id');

        $result = $this->contracts_model->get_single_contract("", $contract_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/contractors/company_id/] or to get single [/workshop/contractors/company_id/bank_id]'
        ], REST_Controller::HTTP_OK);
    }

    public function index_put()
    {
        $data = array(
            'company_id' => $this->put('company_id'),
            'contract_date' => $this->put('contract_date'),
            'job_id' => $this->put('job_id'),
            'job_date' => $this->put('job_date'),
            'chassis_no' => $this->put('chassis_no'),
            'cust_id' => $this->put('cust_id'),
            'contractor_id' => $this->put('contractor_id'),
            'process_id' => $this->put('process_id'),
            'start_date' => $this->put('start_date'),
            'end_date' => $this->put('end_date'),
            'days' => $this->put('days'),
            'amount' => $this->put('amount'),
            'model_id' => $this->put('model_id'),
            'ch_cancel' => $this->put('ch_cancel'),
            'vc_reason' => $this->put('vc_reason'),
            'user_id' => $this->put('user_id')
        );

        log_message("debug", "Getting ready to insert... " . json_encode($data));

        if (empty($data['company_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Company Id is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['contract_date'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'The contract date is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['job_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Select a job card',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['cust_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Select a customer',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['contractor_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Select a contractor',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['process_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Select the process',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['start_date'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Enter the contract start date',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['end_date'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Enter the contract End date',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }


        $response = $this->contracts_model->create_contract($data);

        if ($response == FALSE) {

            log_message("debug", "index_put Database refused. Try again!... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => 'create group put/ {company_id,warehouse_name,wh_loc_id} name cannot be null'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response([
            'response' => $response,
            'status' => true,
            'message' => 'contract created!',
            'description' => ''
        ], REST_Controller::HTTP_CREATED);
    }

     public function index_post()
    {
        $data = [       
            'contract_id' => $this->post('contract_id'),	
            'contract_date' => $this->post('contract_date'),
            'job_id' => $this->post('job_id'),
            'job_date' => $this->post('job_date'),
            'chassis_no' => $this->post('chassis_no'),
            'cust_id' => $this->post('cust_id'),
            'contractor_id' => $this->post('contractor_id'),
            'process_id' => $this->post('process_id'),
            'start_date' => $this->post('start_date'),
            'end_date' => $this->post('end_date'),
            'days' => $this->post('days'),
            'amount' => $this->post('amount'),
            'model_id' => $this->post('model_id'),
            'ch_cancel' => $this->post('ch_cancel'),
            'vc_reason' => $this->post('vc_reason'),
            'user_id' => $this->post('user_id')
        ];

        if (empty($data['contract_date'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'The contract date is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['job_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Select a job card',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['cust_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Select a customer',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['contractor_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Select a contractor',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['process_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Select the process',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['start_date'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Enter the contract start date',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['end_date'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Enter the contract End date',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->contracts_model->update_contract($data);

        if ($response == FALSE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => ''
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response([
            'response' => $response,
            'status' => TRUE,
            'message' => 'Contract Updated!',
            'description' => ''
        ], REST_Controller::HTTP_OK);
    }

   
}