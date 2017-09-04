<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Jobcards extends REST_Controller
{
    function __construct()
    {

        parent::__construct();
        $this->load->model('workshop/jobcards_model');
    }

    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->jobcards_model->get_all_jobcards($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => ''
        ], REST_Controller::HTTP_OK);

    }

    public function find_get()
    {
        $job_id = (int)$this->get('job_id');

        log_message("debug", "*********** find_get start group_id {$job_id} ***********");

        $result = $this->jobcards_model->get_single_jobcard("", $job_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => ''
        ], REST_Controller::HTTP_OK);
    }

	public function contracts_get(){
		$job_id = (int)$this->get('job_id');

        log_message("debug", "*********** find_get start group_id {$job_id} ***********");

        $result = $this->jobcards_model->get_contracts($job_id);

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
            'cust_id' => $this->put('cust_id'),
            'job_date' => $this->put('job_date'),
            'reg_no' => $this->put('reg_no'),
            'milage' => $this->put('milage'),
            'arrival_date' => $this->put('arrival_date'),
            'days' => $this->put('days'),
            'promised_date' => $this->put('promised_date'),
            'work_no' => $this->put('work_no'),
            'work_desc' => $this->put('work_desc'),
            'advisor_id' => $this->put('advisor_id'),
            'approval_id' => $this->put('approval_id'),
            'supervisor_id' => $this->put('supervisor_id'),
            'foreman_id' => $this->put('foreman_id'),
            'user_id' => $this->put('user_id'),
            'boq_veh_id' => $this->put('boq_veh_id'),
            'customer_vehicle_id' => $this->put('customer_vehicle_id')
        );

        log_message("debug", "Getting ready to insert jobcard... " . json_encode($data));

        if (empty($data['job_date'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Enter Job date',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['cust_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Select a customer',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['reg_no'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Enter Registration No',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['arrival_date'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Enter an Arrival Date',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['days'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Standard days required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['promised_date'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Enter a Promised Date',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['work_desc'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Enter A Work Description',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['boq_veh_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Attach Bill Of Quantities',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['customer_vehicle_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Select A Customer Vehicle',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->jobcards_model->create_jobcard($data);

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
            'message' => 'Jobcard created!',
            'description' => ''
        ], REST_Controller::HTTP_CREATED);
    }

    public function index_post()
    {
        $data = [
            'job_id' => $this->post('job_id'),
            'cust_id' => $this->post('cust_id'),
            'reg_no' => $this->post('reg_no'),
            'milage' => $this->post('milage'),
            'arrival_date' => $this->post('arrival_date'),
            'days' => $this->post('days'),
            'promised_date' => $this->post('promised_date'),
            'work_no' => $this->post('work_no'),
            'work_desc' => $this->post('work_desc'),
            'advisor_id' => $this->post('advisor_id'),
            'approval_id' => $this->post('approval_id'),
            'supervisor_id' => $this->post('supervisor_id'),
            'foreman_id' => $this->post('foreman_id'),
            'boq_veh_id' => $this->post('boq_veh_id'),
            'customer_vehicle_id' => $this->post('customer_vehicle_id')

        ];

        if (empty($data['job_id'])) {

            log_message("debug", "index_post Empty Details supplied... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Empty Details supplied',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->jobcards_model->job_id_exists($data['job_id']) != TRUE) {

            log_message("debug", "index_POST Record does not exist... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'This jobcard you are trying to update does not exist',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->jobcards_model->update_jobcard($data);

        if ($response == FALSE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => ''
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        log_message("debug", "Jobcard Updated...");

        return $this->response([
            'response' => $response,
            'status' => TRUE,
            'message' => 'Jobcard Updated!',
            'description' => ''
        ], REST_Controller::HTTP_OK);

    }
	
	public function open_get()
    {
        $company_id = (int)$this->get('company_id');
        $from_date = (string)$this->get('from_date');
        $to_date = (string)$this->get('to_date');
		
        $result = $this->jobcards_model->open_jobs_by_date($company_id,$from_date,$to_date);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all open jobs by date count for a period [/workshop/customers/registered/company_id/from_date/to_date].Use the date format yy-mm-dd'
        ], REST_Controller::HTTP_OK);
    }
	
    public function all_count_get()
    {
        $company_id = (int)$this->get('company_id');
        $from_date = (string)$this->get('from_date');
        $to_date = (string)$this->get('to_date');
		
        $result = $this->jobcards_model->all_jobs_by_date($company_id,$from_date,$to_date);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all open jobs by date count for a period [/workshop/customers/registered/company_id/from_date/to_date].Use the date format yy-mm-dd'
        ], REST_Controller::HTTP_OK);
    }
}