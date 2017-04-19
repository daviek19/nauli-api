<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Customers extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('workshop/customers_model');
    }
	
	public function index_get()
    {
		
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->customers_model->get_all_customers($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/customers/company_id/] or to get single [/workshop/customers/company_id/item_id]'
        ], REST_Controller::HTTP_OK);

    }
	
	public function find_get()
    {
        $customer_id = (int)$this->get('customer_id');

        $result = $this->customers_model->get_single_customer("", $customer_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/customers/company_id/] or to get single [/workshop/customers/company_id/bank_id]'
        ], REST_Controller::HTTP_OK);
    }
	
	    public function index_put()
    {
        $data = array(
            'company_id' => $this->put('company_id'),
            'customer_name' => $this->put('customer_name'),
            'bill_address' => $this->put('bill_address'),
            'region_id' => $this->put('region_id'),
            'city_id' => $this->put('city_id'),
            'country_id' => $this->put('country_id'),
            'currency_id' => $this->put('currency_id'),
            'pin_no' => $this->put('pin_no'),
            'contact_person' => $this->put('contact_person'),
            'contact_no' => $this->put('contact_no'),
            'customer_type_id' => $this->put('customer_type_id'),
            'credit_limit' => $this->put('credit_limit'),
			'email' => $this->put('email'),
            'mobile_no' => $this->put('mobile_no'),
            'customer_category_id' => $this->put('customer_category_id'),
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
        if (empty($data['customer_name'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty customer name',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['region_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty Region',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['city_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty City',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['country_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty country',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['currency_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty currency',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['pin_no'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty Pin details',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['customer_type_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with no customer type',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }       
		if (empty($data['pin_no'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty Pin details',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }        if (empty($data['pin_no'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty Pin details',
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
}