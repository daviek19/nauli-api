<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Activities extends REST_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->model('workshop/activities_model');
    }

    public function find_by_process_get()
    {
        $process_id = (int)$this->get('process_id');
        $company_id = (int)$this->get('company_id');

        $result = $this->activities_model->get_process_activities($company_id, $process_id);

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
            'process_id' => $this->put('process_id'),
            'model_id' => $this->put('model_id'),
            'activity_name' => $this->put('activity_name'),
            'user_id' => $this->put('user_id'),
        );

        if (empty($data['company_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Company Id is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['process_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'process is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['activity_name'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'activity name is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->activities_model->create_activity($data);

        if ($response == FALSE) {


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
            'message' => 'Activity was created!',
            'description' => ''
        ], REST_Controller::HTTP_CREATED);
    }

    public function find_get()
    {
        $activity_id = (int)$this->get('activity_id');

        log_message("debug", "*********** find_get start group_id {$activity_id} ***********");

        $result = $this->activities_model->get_single_activity("", $activity_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => ''
        ], REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        $data = [
            'activity_id' => $this->post('activity_id'), // Automatically generated by the model
            'process_id' => $this->post('process_id'),
            'activity_name' => $this->post('activity_name'),
            'model_id' => $this->post('model_id'),
        ];

        if (empty($data['activity_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Activity Id is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['process_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'process is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['model_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'model is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['activity_name'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'activity name is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }


        $response = $this->activities_model->update_activity($data);

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
            'message' => 'Activity was updated!',
            'description' => ''
        ], REST_Controller::HTTP_OK);

    }
}