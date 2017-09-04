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
            'credit_limit' => str_replace(',', '', $this->put('credit_limit')),
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
        if (empty($data['mobile_no'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty mobile number',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        if (empty($data['customer_category_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty Customer Category',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->customers_model->customer_exists($data['customer_name'], $data['company_id']) == TRUE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Trying to duplicate a customer ',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->customers_model->create_customer($data);

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
            'message' => 'Customer created!',
            'description' => ''
        ], REST_Controller::HTTP_CREATED);
    }

    public function index_post()
    {
        $data = [
            'customer_id' => $this->post('customer_id'),
            'customer_name' => $this->post('customer_name'),
            'bill_address' => $this->post('bill_address'),
            'region_id' => $this->post('region_id'),
            'city_id' => $this->post('city_id'),
            'country_id' => $this->post('country_id'),
            'currency_id' => $this->post('currency_id'),
            'pin_no' => $this->post('pin_no'),
            'contact_person' => $this->post('contact_person'),
            'contact_no' => $this->post('contact_no'),
            'customer_type_id' => $this->post('customer_type_id'),
            'credit_limit' => str_replace(',', '', $this->post('credit_limit')),
            'email' => $this->post('email'),
            'mobile_no' => $this->post('mobile_no'),
            'customer_category_id' => $this->post('customer_category_id')
        ];

        if (empty($data['customer_id']) ||
            empty($data['customer_name']) ||
            empty($data['region_id']) ||
            empty($data['city_id']) ||
            empty($data['currency_id']) ||
            empty($data['customer_type_id']) ||
            empty($data['customer_category_id']) ||
            empty($data['pin_no'])
        ) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Customer Name,region,city,currency, type,category and pin are required.',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->customers_model->customer_id_exists($data['customer_id']) != TRUE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'This Customer you are trying to update does not exist',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->customers_model->update_customer($data);

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
            'message' => 'Customer Updated!',
            'description' => ''
        ], REST_Controller::HTTP_OK);
    }
	
	public function registered_get()
    {
        $company_id = (int)$this->get('company_id');
        $from_date = (string)$this->get('from_date');
        $to_date = (string)$this->get('to_date');
		
        $result = $this->customers_model->get_customers_rigistered_by_date($company_id,$from_date,$to_date);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all customer count for a period [/workshop/customers/registered/company_id/from_date/to_date].Use the date format yy-mm-dd'
        ], REST_Controller::HTTP_OK);
    }
}