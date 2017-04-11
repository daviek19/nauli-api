<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Boqs extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('workshop/boqs_model');
    }

    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->boqs_model->get_all_boqs($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/boqs/company_id/] or to get single [/workshop/boqs/company_id/item_id]'
        ], REST_Controller::HTTP_OK);

    }

    public function find_get()
    {
        $boq_id = (int)$this->get('boq_id');

        $result = $this->boqs_model->get_single_boq("", $boq_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/boqs/company_id/] or to get single [/workshop/boqs/company_id/boq_id]'
        ], REST_Controller::HTTP_OK);
    }

    public function index_put()
    {
        $data = array(
            'company_id' => $this->put('company_id'),
            'vehicle_id' => $this->put('vehicle_id'),
            'section_id' => $this->put('section_id'),
            'item_id' => $this->put('item_id'),
            'qty' => $this->put('qty'),
            'user_id' => $this->put('user_id'),
        );

        log_message("debug", "Getting ready to insert... " . json_encode($data));

        if (empty($data['company_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty company id',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['vehicle_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty vehicle id',
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

        if (empty($data['item_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty item',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['qty'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty qty',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }


        if ($this->boqs_model->boq_exists($data['vehicle_id'], $data['item_id'], $data['section_id'], $data['company_id']) == TRUE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Trying to duplicate a Bill of Quantity',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->boqs_model->create_boq($data);

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
            'message' => 'Bill of Quantity created!',
            'description' => ''
        ], REST_Controller::HTTP_CREATED);
    }

    public function index_post()
    {
        $data = [
            'boq_id' => $this->post('boq_id'),
            'vehicle_id' => $this->post('vehicle_id'),
            'section_id' => $this->post('section_id'),
            'item_id' => $this->post('item_id'),
            'qty' => $this->post('qty'),
        ];

        if (empty($data['vehicle_id']) ||
            empty($data['section_id']) ||
            empty($data['item_id']) ||
            empty($data['qty']) ||
            empty($data['boq_id'])
        ) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Empty details supplied',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->boqs_model->boq_id_exists($data['boq_id']) != TRUE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'This Bill of Quantity you are trying to update does not exist',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->boqs_model->update_boq($data);

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
            'message' => 'Bill of Quantity Updated!',
            'description' => ''
        ], REST_Controller::HTTP_OK);

    }

}
