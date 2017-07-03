<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Requisitions extends REST_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->model('workshop/requisitions_model');
    }

    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->requisitions_model->get_all_requisations($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => ''
        ], REST_Controller::HTTP_OK);

    }
	
	public function index_put()
    {
		 $data = array(           
            'company_id' => $this->put('company_id'),
			'req_date' => $this->put('req_date'),
            'job_no' => $this->put('job_no'),
            'job_date' => $this->put('job_date'),
            'requested_by' => $this->put('requested_by'),
            'section_id' => $this->put('section_id'),
            'chassis_no' => $this->put('chassis_no'),
			'status' => $this->put('status'),
			'cancel' => $this->put('cancel'),			
            'user_id' =>  $this->put('user_id')
        );
		
        log_message("debug", "Getting ready to insert... " . json_encode($data));

        if (empty($data['req_date'])) {
          
            return $this->response([
                'status' => FALSE,
                'message' => 'the requisition date is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
		
        if (empty($data['job_no'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'The job number is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
     
    	if (empty($data['job_date'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'The job data is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
       
   	    if (empty($data['requested_by'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Requested by field by is required.',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
		
        if (empty($data['section_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Select a valid section',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
		
        if (empty($data['chassis_no'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'chassis no is required.',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
		       
        $response = $this->requisitions_model->create_requisation($data);

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
            'message' => 'requisition created!',
            'description' => ''
        ], REST_Controller::HTTP_CREATED);
    }

	 public function find_get()
    {
        $requisition_id = (int)$this->get('requisition_id');

        $result = $this->requisitions_model->get_single_requisations("", $requisition_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/vehicles/company_id/] or to get single [/workshop/vehicles/company_id/item_id]'
        ], REST_Controller::HTTP_OK);
    }

}

