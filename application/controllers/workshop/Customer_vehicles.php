<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Customer_vehicles extends REST_Controller
{
	
    function __construct()
    {
        parent::__construct();
        $this->load->model('workshop/customer_vehicles_model');
    }
	
	public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->customer_vehicles_model->get_all_customer_vehicles($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/customer_vehicles/company_id/] or to get single [/workshop/customer_vehicles/company_id/item_id]'
        ], REST_Controller::HTTP_OK);
    }
	
	public function find_get()
    {
        $customer_vehicle_id = (int)$this->get('customer_vehicle_id');

        $result = $this->customer_vehicles_model->get_single_customer_vehicle("", $customer_vehicle_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/customer_vehicles/company_id/] or to get single [/workshop/customer_vehicles/company_id/bank_id]'
        ], REST_Controller::HTTP_OK);
    }
	
	public function index_put()
    {
        $data = array(
            'company_id' => $this->put('company_id'),
            'customer_id' => $this->put('customer_id'),
            'vehicle_id' => $this->put('vehicle_id'),
            'chassis_no' => $this->put('chassis_no'),
            'engine_no' => $this->put('engine_no'),
            'delivery_date' => $this->put('delivery_date'),    
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
        if (empty($data['customer_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty customer details',
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
        if (empty($data['chassis_no'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty Chassis No',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['engine_no'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty engine_no',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['delivery_date'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty delivery Date',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
		 if ($this->customer_vehicles_model->chassis_no_exists($data['chassis_no'], $data['company_id']) == TRUE) {
				
					return $this->response([
						'response' => $data,
						'status' => FALSE,
						'message' => 'This Chassis Number is already registed to another vehicle',
						'description' => 'create group put/ {company_id,group_name} name cannot be null'
					], REST_Controller::HTTP_BAD_REQUEST);
				}	

		 if ($this->customer_vehicles_model->engine_no_exists($data['engine_no'], $data['company_id']) == TRUE) {
				
					return $this->response([
						'response' => $data,
						'status' => FALSE,
						'message' => 'This Engine Number is already registed to another vehicle',
						'description' => 'create group put/ {company_id,group_name} name cannot be null'
					], REST_Controller::HTTP_BAD_REQUEST);
				}					


        $response = $this->customer_vehicles_model->create_customer_vehicle($data);

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
            'message' => 'Customer Vehicle created!',
            'description' => ''
        ], REST_Controller::HTTP_CREATED);
    }
	
	 public function index_post()
    {
        $data = [
		   'customer_vehicle_id' => $this->post('customer_vehicle_id'),
            'customer_id' => $this->post('customer_id'),
            'vehicle_id' => $this->post('vehicle_id'),
            'chassis_no' => $this->post('chassis_no'),
            'engine_no' => $this->post('engine_no'),
            'delivery_date' => $this->post('delivery_date'), 
        ];

		if (empty($data['customer_vehicle_id'])) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'customer vehicle id required.',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['customer_id'])) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Customer required.',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
		if (empty($data['vehicle_id'])) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Vehicle required.',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
		if (empty($data['chassis_no'])) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'chassis_no required.',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
		if (empty($data['engine_no'])) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'engine_no required.',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
		if (empty($data['delivery_date'])) {
            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'delivery_date required.',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
      
	  if ($this->customer_vehicles_model->customer_vehicle_id_exists($data['customer_vehicle_id']) != TRUE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Chassis required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->customer_vehicles_model->update_customer_vehicle($data);

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
            'message' => 'Customer Vehicle Updated!',
            'description' => ''
        ], REST_Controller::HTTP_OK);
    }

}