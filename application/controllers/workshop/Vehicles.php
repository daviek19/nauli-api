<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Vehicles extends REST_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->model('workshop/vehicles_model');
    }

    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->vehicles_model->get_all_vehicles($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/vehicles/company_id/] or to get single [/workshop/vehicles/company_id/item_id]'
        ], REST_Controller::HTTP_OK);

    }

    public function find_get()
    {
        $vehicle_id = (int)$this->get('vehicle_id');

        $result = $this->vehicles_model->get_single_vehicle("", $vehicle_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/vehicles/company_id/] or to get single [/workshop/vehicles/company_id/item_id]'
        ], REST_Controller::HTTP_OK);
    }

    public function index_put()
    {
        $data = array(
            'company_id' => $this->put('company_id'),
            'vehicle_code' => $this->put('vehicle_code'),
            'vehicle_name' => $this->put('vehicle_name'),
            'group_id' => $this->put('group_id'),
            'description_id' => $this->put('description_id'),
            'item_unit_id' => $this->put('item_unit_id'),
            'selling_price' => $this->put('selling_price'),
            'cost' => $this->put('cost'),
            'make_id' => $this->put('make_id'),
            'model_no' => $this->put('model_no'),
            'body_type' => $this->put('body_type'),
            'make_year' => $this->put('make_year')
        );

        log_message("debug", "Getting ready to insert... " . json_encode($data));

        if (empty($data['vehicle_code'])) {

            log_message("debug", "index_put Trying to insert empty vehicle_code... ");

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty vehicle_code',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['vehicle_name'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty vehicle name',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['group_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty grouping',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['description_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty item classification',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['item_unit_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty item units',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['selling_price'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty selling_price',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['cost'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty cost',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['make_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty make_id',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['model_no'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty model_no',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['body_type'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty body_type',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['make_year'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty make_year',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->vehicles_model->vehicle_exists($data['vehicle_name'], $data['company_id']) == TRUE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Trying to duplicate a vehicle name',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->vehicles_model->create_vehicle($data);

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
            'message' => 'vehicle created!',
            'description' => ''
        ], REST_Controller::HTTP_CREATED);
    }

    public function index_post()
    {
        $data = [
            'vehicle_id' => $this->post('vehicle_id'), // Automatically generated by the model
            'vehicle_code' => $this->post('vehicle_code'),
            'vehicle_name' => $this->post('vehicle_name'),
            'group_id' => $this->post('group_id'),
            'description_id' => $this->post('description_id'),
            'item_unit_id' => $this->post('item_unit_id'),
            'selling_price' => $this->post('selling_price'),
            'cost' => $this->post('cost'),
            'make_id' => $this->post('make_id'),
            'model_no' => $this->post('model_no'),
            'body_type' => $this->post('body_type'),
            'make_year' => $this->post('make_year')
        ];

        if (empty($data['vehicle_id']) ||
            empty($data['vehicle_code']) ||
            empty($data['vehicle_name']) ||
            empty($data['group_id']) ||
            empty($data['description_id']) ||
            empty($data['item_unit_id']) ||
            empty($data['selling_price']) ||
            empty($data['cost']) ||
            empty($data['make_id']) ||
            empty($data['model_no']) ||
            empty($data['body_type']) ||
            empty($data['make_year'])
        ) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Empty details supplied',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->vehicles_model->vehicle_id_exists($data['vehicle_id']) != TRUE) {

            log_message("debug", "index_POST Record does not exist... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'This vehicle you are trying to update does not exist',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->vehicles_model->update_vehicle($data);

        if ($response == FALSE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => ''
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        log_message("debug", "Item Updated...");

        return $this->response([
            'response' => $response,
            'status' => TRUE,
            'message' => 'vehicle Updated!',
            'description' => ''
        ], REST_Controller::HTTP_OK);

    }
}