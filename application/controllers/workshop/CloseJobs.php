<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class CloseJobs extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('workshop/close_jobs_model');
    }

    public function index_get()
    {        
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->close_jobs_model->get_all_closed_jobs($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/Certificates/company_id/] or to get single [/workshop/Certificates/company_id/item_id]'
        ], REST_Controller::HTTP_OK);
    }
	
	public function index_put()
    {
        $data = array(
            'company_id' => $this->put('company_id'),
			'job_no' => $this->put('job_no'),        
            'cust_id' => $this->put('cust_id'),
            'job_date' => $this->put('job_date'),        
            'closed_by ' => $this->put('closed_by'),      
			'chassis_no' => $this->put('chassis_no'),
        );
			
        log_message("debug", "Getting ready to close jobcard... " . json_encode($data));

        if (empty($data['job_no'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Enter Job',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }    

        $response = $this->close_jobs_model->close_jobcard($data);

        if ($response == FALSE) {

            log_message("debug", "index_put Database refused. Try again!... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => ''
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        log_message("debug", "index_put Record created!... ");

        return $this->response([
            'response' => $response,
            'status' => true,
            'message' => 'Jobcard closed!',
            'description' => ''
        ], REST_Controller::HTTP_CREATED);
    }

	
	
}
