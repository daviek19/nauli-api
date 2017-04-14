<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Banks extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('workshop/banks_model');
    }

    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->banks_model->get_all_banks($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/banks/company_id/] or to get single [/workshop/banks/company_id/item_id]'
        ], REST_Controller::HTTP_OK);

    }

    public function find_get()
    {
        $bank_id = (int)$this->get('bank_id');

        $result = $this->banks_model->get_single_bank("", $bank_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/banks/company_id/] or to get single [/workshop/banks/company_id/bank_id]'
        ], REST_Controller::HTTP_OK);
    }

    public function index_put()
    {
        $data = array(
            'company_id' => $this->put('company_id'),
            'bank_name' => $this->put('bank_name'),
            'branch_code' => $this->put('branch_code'),
            'branch_name' => $this->put('branch_name'),
        );

        log_message("debug", "Getting ready to insert... " . json_encode($data));

        if (empty($data['company_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty company id',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['bank_name'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty bank name',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['branch_code'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty bank code',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['branch_name'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty branch name',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->banks_model->bank_exists($data['bank_name'], $data['branch_code'], $data['company_id']) == TRUE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Trying to duplicate a Bank',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->banks_model->create_bank($data);

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
            'message' => 'Bank created!',
            'description' => ''
        ], REST_Controller::HTTP_CREATED);
    }

    public function index_post()
    {
        $data = [
            'bank_id' => $this->post('bank_id'),
            'bank_name' => $this->post('bank_name'),
            'branch_code' => $this->post('branch_code'),
            'branch_name' => $this->post('branch_name'),
        ];

        if (empty($data['bank_id']) ||
            empty($data['bank_name']) ||
            empty($data['branch_code']) ||
            empty($data['branch_name'])
        ) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Empty details supplied',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->banks_model->bank_id_exists($data['bank_id']) != TRUE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'This Bank you are trying to update does not exist',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->banks_model->update_bank($data);

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
            'message' => 'Bank Updated!',
            'description' => ''
        ], REST_Controller::HTTP_OK);
    }

}
