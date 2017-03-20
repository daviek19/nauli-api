<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Subparameters extends REST_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->model('workshop/subparameters_model');
    }

    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->subparameters_model->get_all_subparameters($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/subgroups/company_id/] or to get single [/worksop/subgroups/company_id/subgroup_id]'
        ], REST_Controller::HTTP_OK);

    }

    public function find_get()
    {
        $description_id = (int)$this->get('description_id');

        log_message("debug", "*********** find_get start group_id {$description_id} ***********");

        $result = $this->subparameters_model->get_single_subparameters("", $description_id);

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
            'item_id' => $this->put('item_id'),
            'description_name' => $this->put('description_name'),
        );

        log_message("debug", "Getting ready to insert... " . json_encode($data));

        if (empty($data['description_name'])) {

            log_message("debug", "index_put Trying to insert empty description_name... ");

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty description_name',
                'description' => 'create group put/ {company_id,group_id,subgroup_name} name cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['item_id'])) {

            log_message("debug", "index_put Trying to insert empty group_id... ");

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty item_id',
                'description' => 'create group put/ {company_id,group_id,subgroup_name} name cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->subparameters_model->subparameter_exists($data['description_name'], $data['company_id'], $data['item_id']) == TRUE) {

            log_message("debug", "index_put Trying to duplicate a description name... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Trying to duplicate a description name',
                'description' => 'create group put/ {company_id,subgroup_name} name cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->subparameters_model->create_subparameter($data);

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
            'message' => 'subparameters created!',
            'description' => 'To get all [workshop/groups/company_id/] or to get single [workshop/groups/find/group_id]'
        ], REST_Controller::HTTP_CREATED);
    }

    public function index_post()
    {
        $data = [
            'description_id' => $this->post('description_id'),
            'item_id' => $this->post('item_id'),
            'description_name' => $this->post('description_name'),
        ];

        if (empty($data['description_id']) || empty($data['item_id']) || empty($data['description_name'])) {

            log_message("debug", "index_post Empty description_id/item_id/description_name supplied... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Empty description_id/item_id/description_name supplied',
                'description' => 'Update group post/ {subgroup_id/group_id,group_name} name and id cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->subparameters_model->subparameter_id_exists($data['description_id']) != TRUE) {

            log_message("debug", "index_POST Record does not exist... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'This subparameter you are trying to update does not exist',
                'description' => 'create group put/ {company_id,group_name} name cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->subparameters_model->update_subparameter($data);

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
            'message' => 'subparameter Updated!',
            'description' => 'To get all [workshop/groups/company_id/] or to get single [/workshop/groups/find/department_id]'
        ], REST_Controller::HTTP_OK);

    }
	
	public function find_by_item_id_get(){
		 $item_id = (int)$this->get('item_id');

        log_message("debug", "*********** find_get start group_id {$item_id} ***********");

        $result = $this->subparameters_model->get_subparameters_by_item_id($item_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/subgroups/group_id/] or to get single [/workshop/subgroups/find/group_id]'
        ], REST_Controller::HTTP_OK);
	}
}