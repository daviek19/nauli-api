<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Contractors extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('workshop/contractors_model');
    }

    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->contractors_model->get_all_contractors($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/Contractors/company_id/] or to get single [/workshop/Contractors/company_id/item_id]'
        ], REST_Controller::HTTP_OK);

    }

    public function find_get()
    {
        $contractor_id = (int)$this->get('contractor_id');

        $result = $this->contractors_model->get_single_contractor("", $contractor_id);

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
            'contractor_name' => $this->put('contractor_name'),
            'id_no' => $this->put('id_no'),
            'pin_no' => $this->put('pin_no'),
            'mobile_no' => $this->put('mobile_no'),
            'section_id' => $this->put('section_id'),
            'location_id' => $this->put('location_id'),
            'bank_id' => $this->put('bank_id'),
            'branch_code' => $this->put('branch_code'),
            'account_no' => $this->put('account_no'),
            'active' => $this->put('active'),
            'user_id' => $this->put('user_id')
        );

        log_message("debug", "Getting ready to insert... " . json_encode($data));

        if (empty($data['company_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty company id',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['contractor_name'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty contractor name',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['id_no'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty Id no',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['mobile_no'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty Mobile No',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['section_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty section',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['location_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty location',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['bank_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty bank details',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->contractors_model->contractor_exists($data['contractor_name'], $data['company_id']) == TRUE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Trying to duplicate a Contractor ',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->contractors_model->create_contractor($data);

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
            'message' => 'Contractor created!',
            'description' => ''
        ], REST_Controller::HTTP_CREATED);
    }

    public function index_post()
    {
        $data = [
            'contractor_id' => $this->post('contractor_id'),
            'contractor_name' => $this->post('contractor_name'),
            'id_no' => $this->post('id_no'),
            'pin_no' => $this->post('pin_no'),
            'mobile_no' => $this->post('mobile_no'),
            'section_id' => $this->post('section_id'),
            'location_id' => $this->post('location_id'),
            'bank_id' => $this->post('bank_id'),
            'branch_code' => $this->post('branch_code'),
            'account_no' => $this->post('account_no'),
            'active' => $this->post('active'),
            'user_id' => $this->post('user_id')
        ];

        if (empty($data['contractor_id']) ||
            empty($data['contractor_name']) ||
            empty($data['id_no']) ||
            empty($data['mobile_no']) ||
            empty($data['location_id']) ||
            empty($data['bank_id']) ||
            empty($data['section_id'])
        ) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Contractor Name,id,mobile,location, bank and section are required.',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->contractors_model->contractor_id_exists($data['contractor_id']) != TRUE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'This Bank you are trying to update does not exist',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->contractors_model->update_contractor($data);

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
            'message' => 'Contractor Updated!',
            'description' => ''
        ], REST_Controller::HTTP_OK);
    }

}
