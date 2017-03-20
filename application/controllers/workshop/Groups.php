<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Groups extends REST_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->model('workshop/groups_model');
    }

    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->groups_model->get_all_groups($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/groups/company_id/] or to get single [/worksop/company_id/group_id]'
        ], REST_Controller::HTTP_OK);

    }

    public function find_get()
    {
        $group_id = (int)$this->get('group_id');

        log_message("debug", "*********** find_get start group_id {$group_id} ***********");

        $result = $this->groups_model->get_single_group("", $group_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/groups/group_id/] or to get single [/workshop/groups/find/group_id]'
        ], REST_Controller::HTTP_OK);
    }

    public function index_put()
    {

        log_message("debug", "*********** index_put start ***********");

        $data = array(
            'company_id' => $this->put('company_id'),
            'group_name' => $this->put('group_name'),
			'description_id' => $this->put('description_id')
        );

        log_message("debug", "Getting ready to insert... " . json_encode($data));

        if (empty($data['group_name'])) {

            log_message("debug", "index_put Trying to insert empty group name... ");

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty group name',
                'description' => 'create group put/ {company_id,group_name} name cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
		
		if (empty($data['description_id'])) {

            log_message("debug", "index_put Trying to insert empty classification... ");

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty classification',
                'description' => 'create group put/ {company_id,group_name} name cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->groups_model->group_exists($data['group_name'], $data['company_id']) == TRUE) {

            log_message("debug", "index_put Trying to duplicate a group name... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Trying to duplicate a group name',
                'description' => 'create group put/ {company_id,group_name} name cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->groups_model->create_group($data);

        if ($response == FALSE) {

            log_message("debug", "index_put Database refused. Try again!... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => 'create group put/ {company_id,group_name} name cannot be null'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        log_message("debug", "index_put Record created!... ");

        return $this->response([
            'response' => $response,
            'status' => true,
            'message' => 'Group created!',
            'description' => 'To get all [workshop/groups/company_id/] or to get single [workshop/groups/find/group_id]'
        ], REST_Controller::HTTP_CREATED);
    }

    public function index_post()
    {
        $data = [
            'group_id' => $this->post('group_id'), // Automatically generated by the model
            'group_name' => $this->post('group_name'),
			'description_id' => $this->post('description_id')
        ];

        if (empty($data['group_id']) || empty($data['group_name']) || empty($data['description_id'])) {

            log_message("debug", "index_post Empty group_id/group_name/classification supplied... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Empty group_id/group_name/classification supplied',
                'description' => 'Update group post/ {group_id,group_name} name and id cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->groups_model->group_id_exists($data['group_id']) != TRUE) {

            log_message("debug", "index_POST Record does not exist... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'This group you are trying to update does not exist',
                'description' => 'create group put/ {company_id,group_name} name cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->groups_model->update_group($data);

        if ($response == FALSE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => 'create groups put/ {company_id,group_name} name cannot be null'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        log_message("debug", "Group Updated...");

        return $this->response([
            'response' => $response,
            'status' => TRUE,
            'message' => 'Group Updated!',
            'description' => 'To get all [workshop/groups/company_id/] or to get single [/workshop/groups/find/department_id]'
        ], REST_Controller::HTTP_OK);

    }
}