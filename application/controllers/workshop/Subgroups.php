<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Subgroups extends REST_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->model('workshop/groups_model');
        $this->load->model('workshop/subgroups_model');
    }

    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->subgroups_model->get_all_subgroups($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/subgroups/company_id/] or to get single [/worksop/subgroups/company_id/subgroup_id]'
        ], REST_Controller::HTTP_OK);

    }

    public function find_get()
    {
        $group_id = (int)$this->get('group_id');

        log_message("debug", "*********** find_get start group_id {$group_id} ***********");

        $result = $this->subgroups_model->get_single_subgroup("", $group_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/subgroups/group_id/] or to get single [/workshop/subgroups/find/group_id]'
        ], REST_Controller::HTTP_OK);
    }

    public function index_put()
    {

        log_message("debug", "*********** index_put start ***********");

        $data = array(
            'company_id' => $this->put('company_id'),
            'group_id' => $this->put('group_id'),
            'subgroup_name' => $this->put('subgroup_name'),
        );

        log_message("debug", "Getting ready to insert... " . json_encode($data));

        if (empty($data['subgroup_name'])) {

            log_message("debug", "index_put Trying to insert empty subgroup_name... ");

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty subgroup_name',
                'description' => 'create group put/ {company_id,group_id,subgroup_name} name cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['group_id'])) {

            log_message("debug", "index_put Trying to insert empty group_id... ");

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty group_id',
                'description' => 'create group put/ {company_id,group_id,subgroup_name} name cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->subgroups_model->subgroup_exists($data['subgroup_name'], $data['company_id'], $data['group_id']) == TRUE) {

            log_message("debug", "index_put Trying to duplicate a subgroup name... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Trying to duplicate a subgroup name',
                'description' => 'create group put/ {company_id,subgroup_name} name cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->subgroups_model->create_subgroup($data);

        if ($response == FALSE) {

            log_message("debug", "index_put Database refused. Try again!... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => 'create group put/ {company_id,subgroup_name} name cannot be null'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        log_message("debug", "index_put Record created!... ");

        return $this->response([
            'response' => $response,
            'status' => true,
            'message' => 'subgroup created!',
            'description' => 'To get all [workshop/groups/company_id/] or to get single [workshop/groups/find/group_id]'
        ], REST_Controller::HTTP_CREATED);
    }

    public function index_post()
    {
        $data = [
            'subgroup_id' => $this->post('subgroup_id'),
            'group_id' => $this->post('group_id'),
            'subgroup_name' => $this->post('subgroup_name'),
        ];

        if (empty($data['subgroup_id']) || empty($data['group_id']) || empty($data['subgroup_name'])) {

            log_message("debug", "index_post Empty subgroup_id/group_id/group_name supplied... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Empty subgroup_id/group_id/group_name supplied',
                'description' => 'Update group post/ {subgroup_id/group_id,group_name} name and id cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->subgroups_model->subgroup_id_exists($data['subgroup_id']) != TRUE) {

            log_message("debug", "index_POST Record does not exist... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'This subgroup you are trying to update does not exist',
                'description' => 'create group put/ {company_id,group_name} name cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->subgroups_model->update_subgroup($data);

        if ($response == FALSE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => 'create groups put/ {company_id,group_name} name cannot be null'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        log_message("debug", "subgroup Updated...");

        return $this->response([
            'response' => $response,
            'status' => TRUE,
            'message' => 'Subgroup Updated!',
            'description' => 'To get all [workshop/groups/company_id/] or to get single [/workshop/groups/find/department_id]'
        ], REST_Controller::HTTP_OK);

    }
}