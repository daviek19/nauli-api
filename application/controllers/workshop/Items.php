<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Items extends REST_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->model('workshop/items_model');
    }

    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->items_model->get_all_items($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/items/company_id/] or to get single [/workshop/items/company_id/item_id]'
        ], REST_Controller::HTTP_OK);

    }

    public function find_get()
    {
        $item_id = (int)$this->get('item_id');

        $result = $this->items_model->get_single_item("", $item_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/items/company_id/] or to get single [/workshop/items/company_id/item_id]'
        ], REST_Controller::HTTP_OK);
    }

    public function index_put()
    {
        $data = array(
            'company_id' => $this->put('company_id'),
            'item_no' => $this->put('item_no'),
            'item_name' => $this->put('item_name'),
            'wh_id' => $this->put('wh_id'),
            'description_id' => $this->put('description_id'),
            'group_id' => $this->put('group_id'),
            'subgroup_id' => $this->put('subgroup_id'),
            'item_unit_id' => $this->put('item_unit_id'),
            'cost' => $this->put('cost'),
            'reorder_qty' => $this->put('reorder_qty'),
            'min_qty' => $this->put('min_qty'),
            'active' => $this->put('active')
        );

        log_message("debug", "Getting ready to insert... " . json_encode($data));

        if (empty($data['item_no'])) {

            log_message("debug", "index_put Trying to insert empty item no ... ");

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty part_no',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['item_name'])) {

            log_message("debug", "index_put Trying to insert item_name... ");

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty location',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['wh_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty warehouse location',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['description_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty item classification',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['group_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty grouping',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['item_unit_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty item units',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['cost'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty cost',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['cost'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty reorder_qty',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['min_qty'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create with empty min_qty',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->items_model->item_exists($data['item_name'], $data['company_id']) == TRUE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Trying to duplicate a item name',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->items_model->create_item($data);

        if ($response == FALSE) {

            log_message("debug", "index_put Database refused. Try again!... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => 'create group put/ {company_id,warehouse_name,wh_loc_id} name cannot be null'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        log_message("debug", "index_put Record created!... ");

        return $this->response([
            'response' => $response,
            'status' => true,
            'message' => 'Item created!',
            'description' => 'create group put/ {company_id,warehouse_name,wh_loc_id} name cannot be null'
        ], REST_Controller::HTTP_CREATED);
    }

    public function index_post()
    {
        $data = [
            'item_id' => $this->post('item_id'), // Automatically generated by the model
            'item_no' => $this->put('item_no'),
            'item_name' => $this->put('item_name'),
            'wh_id' => $this->put('wh_id'),
            'description_id' => $this->put('description_id'),
            'group_id' => $this->put('group_id'),
            'subgroup_id' => $this->put('subgroup_id'),
            'item_unit_id' => $this->put('item_unit_id'),
            'cost' => $this->put('cost'),
            'reorder_qty' => $this->put('reorder_qty'),
            'min_qty' => $this->put('min_qty'),
            'active' => $this->put('active')
        ];

        if (empty($data['item_id']) ||
            empty($data['item_no']) ||
            empty($data['item_name']) ||
            empty($data['wh_id']) ||
            empty($data['description_id']) ||
            empty($data['subgroup_id']) ||
            empty($data['item_unit_id']) ||
            empty($data['cost']) ||
            empty($data['reorder_qty']) ||
            empty($data['min_qty']) ||
            empty($data['active'])
        ) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Empty details supplied',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->warehouse_model->item_id_exists($data['item_id']) != TRUE) {

            log_message("debug", "index_POST Record does not exist... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'This warehouse you are trying to update does not exist',
                'description' => 'Update group post/ {wh_id,wh_name,wh_loc} name and id cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->warehouse_model->update_item($data);

        if ($response == FALSE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => 'Update warehouse post/ {wh_id,wh_name,wh_loc} name and id cannot be null'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        log_message("debug", "Item Updated...");

        return $this->response([
            'response' => $response,
            'status' => TRUE,
            'message' => 'Item Updated!',
            'description' => 'Update warehouse post/ {wh_id,wh_name,wh_loc} name and id cannot be null'
        ], REST_Controller::HTTP_OK);

    }
}