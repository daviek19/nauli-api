<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Contractors_pay extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('workshop/contractors_pay_model');
    }

    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->contractors_pay_model->get_all_payments($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/customer_vehicles/company_id/] or to get single [/workshop/customer_vehicles/company_id/item_id]'
        ], REST_Controller::HTTP_OK);
    }
	
	 public function find_get()
    {
        $pay_id = (int)$this->get('pay_id');

        $result = $this->contractors_pay_model->get_single_payment("", $pay_id);

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
            'pay_date' => $this->put('pay_date'),
            'ref_no' => $this->put('ref_no'),
            'ref_date' => $this->put('ref_date'),
            'contractor_id' => $this->put('contractor_id'),
			'contract_id' => $this->put('contract_id'),
            'process_id' => $this->put('process_id'),
            'gross_amt' => $this->put('gross_amt'),
            'deductions' => $this->put('deductions'),
            'net_amount' => $this->put('net_amount'),
            'remarks' => $this->put('remarks'),
            'description' => $this->put('description'),
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

        $response = $this->contractors_pay_model->create_payment($data);

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
            'message' => 'Contractor payment created!',
            'description' => ''
        ], REST_Controller::HTTP_CREATED);
    }
	
	public function index_post()
    {
        $data = [           
			'gross_amt' => $this->post('gross_amt'),
            'deductions' => $this->post('deductions'),
            'net_amount' => $this->post('net_amount'),
            'remarks' => $this->post('remarks'),
            'description' => $this->post('description'),
            'pay_id' => $this->post('pay_id')
        ];
			
        if (empty($data['pay_id'])) {
            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'select a valid payment',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->contractors_pay_model->update_payment($data);

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
            'message' => 'Payment Updated!',
            'description' => ''
        ], REST_Controller::HTTP_OK);
    }
	
}
