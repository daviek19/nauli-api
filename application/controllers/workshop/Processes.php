<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Processes extends REST_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->model('workshop/processes_model');
    }

    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->processes_model->get_all_processes($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => ''
        ], REST_Controller::HTTP_OK);

    }

    public function find_get()
    {
        $process_id = (int)$this->get('process_id');

        log_message("debug", "*********** find_get start group_id {$process_id} ***********");

        $result = $this->processes_model->get_single_process("", $process_id);

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
            'sequence' => $this->put('sequence'),
            'process_name' => $this->put('process_name'),
			'vehicle_make' => $this->put('vehicle_make'),
			'vehicle_model' => $this->put('vehicle_model'),
			'std_days' => $this->put('std_days'),
			'amount' => $this->put('amount'),
			'critical_path' => $this->put('critical_path')
        );

        log_message("debug", "Getting ready to insert processes... " . json_encode($data));

        if (empty($data['process_name'])) {

            log_message("debug", "index_put Trying to insert empty process name... ");

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty process name',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['sequence'])) {

            log_message("debug", "index_put Trying to insert empty sequence ... ");

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty sequence',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

		if (empty($data['vehicle_make'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty Vehicle Make',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

		if (empty($data['vehicle_model'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty Vehicle Model',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

	    if (empty($data['std_days'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty Standard days',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

	    if (empty($data['amount'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty Amount',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->processes_model->process_name_exists($data['process_name'], $data['vehicle_make'],$data['vehicle_model'],$data['company_id']) == TRUE) {

            log_message("debug", "index_put Trying to duplicate a process name... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Trying to duplicate a Process Name',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->processes_model->process_sequence_exists($data['sequence'],$data['vehicle_make'],$data['vehicle_model'], $data['company_id']) == TRUE) {

            log_message("debug", "index_put Trying to duplicate a sequence... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Trying to duplicate a sequence',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->processes_model->create_processes($data);

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
            'message' => 'Process created!',
            'description' => ''
        ], REST_Controller::HTTP_CREATED);
    }

    public function index_post()
    {
        $data = [
            'process_id' => $this->post('process_id'), // Automatically generated by the model
            'process_name' => $this->post('process_name'),
            'sequence' => $this->post('sequence'),
			'vehicle_make' => $this->post('vehicle_make'),
			'vehicle_model' => $this->post('vehicle_model'),
			'std_days' => $this->post('std_days'),
			'amount' => $this->post('amount'),
			'critical_path' => $this->post('critical_path')
        ];

        if (empty($data['process_id']) ||
		empty($data['process_name']) ||
		empty($data['sequence']) ||
		empty($data['vehicle_make']) ||
		empty($data['vehicle_model']) ||
		empty($data['std_days'])) {

            log_message("debug", "index_post Empty Details supplied... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Empty Details supplied',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->processes_model->process_id_exists($data['process_id']) != TRUE) {

            log_message("debug", "index_POST Record does not exist... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'This process you are trying to update does not exist',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->processes_model->update_process($data);

        if ($response == FALSE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => ''
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        log_message("debug", "processes Updated...");

        return $this->response([
            'response' => $response,
            'status' => TRUE,
            'message' => 'Processes Updated!',
            'description' => ''
        ], REST_Controller::HTTP_OK);

    }
}