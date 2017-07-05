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
            'user_id' => $this->put('user_id')
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
        $materials = $this->requisitions_model->get_requisition_materials($result[0]->req_id);
        $missing_materials = $this->requisitions_model->boq_drop_down($result[0]->vehicle_id, $result[0]->section_id, $result[0]->req_id);

        $this->response([
            'response' => $result,
            'materials' => $materials,
            'missing_materials' => $missing_materials,
            'status' => TRUE,
            'description' => 'To get all [/workshop/vehicles/company_id/] or to get single [/workshop/vehicles/company_id/item_id]'
        ], REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        $data = [
            'req_id' => $this->post('req_id'),
            'req_date' => $this->post('req_date'),
            'job_no' => $this->post('job_no'),
            'job_date' => $this->post('job_date'),
            'requested_by' => $this->post('requested_by'),
            'section_id' => $this->post('section_id'),
            'chassis_no' => $this->post('chassis_no'),
            'status' => $this->post('status'),
            'cancel' => $this->post('cancel'),
        ];
        if (empty($data['req_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Select a valid requisition',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

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


        $response = $this->requisitions_model->update_requisition($data);

        if ($response == FALSE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => ''
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        log_message("debug", "Requisition Updated...");

        return $this->response([
            'response' => $response,
            'status' => TRUE,
            'message' => 'Requisition Updated!',
            'description' => ''
        ], REST_Controller::HTTP_OK);
    }

    public function materials_get()
    {
        //Get params
        $requisition_id = (int)$this->get('requisition_id');

        $result = $this->requisitions_model->get_requisition_materials($requisition_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => ''
        ], REST_Controller::HTTP_OK);
    }

    public function missing_materials_get()
    {
        //Get params
        $requisition_id = (int)$this->get('requisition_id');
        $section_id = (int)$this->get('section_id');
        $boq_vehicle_id = (int)$this->get('boq_vehicle_id');

        $result = $this->requisitions_model->boq_drop_down($boq_vehicle_id, $section_id, $requisition_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'boq_vehicle_id/section_id/requisition_id'
        ], REST_Controller::HTTP_OK);
    }

    public function add_material_put()
    {
        $data = [
            'qty_issued' => $this->put('qty_issued'),
            'qty_required' => $this->put('qty_required'),
            'part_no' => $this->put('part_no'),
            'req_id' => $this->put('req_id'),
            'company_id' => $this->put('company_id')
        ];
        if (empty($data['req_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'a valid requisition id is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['qty_required'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'qty required is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['part_no'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'The part number is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['qty_issued'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'The qty issued is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if (empty($data['company_id'])) {
            return $this->response([
                'status' => FALSE,
                'message' => 'The company id is required',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->requisitions_model->add_material($data);

        if ($response == FALSE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => ''
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        log_message("debug", "added material ...");

        return $this->response([
            'response' => $response,
            'status' => TRUE,
            'message' => 'Requisition material added!',
            'description' => ''
        ], REST_Controller::HTTP_OK);
    }
}
