<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Departments extends REST_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->model('departments_model');
    }

    /**
     * Depatments Documentation
     *  by daviek19@gmail.com
     *
     *  This is a small documentation to guide in using the
     *  department resource.
     *  We shall use the bellow nouns and verbs to indentify the
     *  resourcses.
     *
     * CREATE
     *    index_put() ::@return obj depatments
     *
     * READ
     *    All index_get() ::@return list<obj> depatments
     *    One index_get(@param int $department_id )
     *
     * UPDATE
     *   index_post(@param int $department_id )
     *
     * DELETE
     *  index_delete(@param int $department_id )
     *
     * In all instances when throwing errors
     * @return
     *   string status [true,false]
     *   string message [should be very descriptive]
     *
     */
    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        if (!empty($company_id)) {
            $result = $this->departments_model->get_all_departments($company_id);

            $this->response([
                'response' => $result,
                'status' => TRUE,
                'description' => 'To get all [/departments/company_id/] or to get single [/departments/company_id/department_id]'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'No company_id was suplied',
                'description' => 'To get all [/departments/company_id/] or to get single [/departments/find/department_id]'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function find_get()
    {

        $department_id = (int)$this->get('department_id');

        log_message("debug", "*********** find_get start department_id {$department_id} ***********");

        if (empty($department_id)) {
            return $this->response([
                'status' => FALSE,
                'message' => 'No department_id was suplied',
                'description' => 'To get all [/departments/company_id/] or to get single [/departments/find/department_id]'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

        $result = $this->departments_model->get_single_department("", $department_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/departments/company_id/] or to get single [/departments/find/department_id]'
        ], REST_Controller::HTTP_OK);
    }

    public function index_put()
    {

        log_message("debug", "*********** index_put start ***********");

        $data = array(
            'company_id' => $this->put('company_id'),
            'department_name' => $this->put('department_name'),
        );

        log_message("debug", "Getting ready to insert... " . json_encode($data));

        if (empty($data['department_name'])) {

            log_message("debug", "index_put Trying to insert empty department name... ");

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty department name',
                'description' => 'create departement put/ {company_id,department_name} name cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->departments_model->department_exists($data['department_name'], $data['company_id']) == TRUE) {

            log_message("debug", "index_put Trying to duplicate a department name... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Trying to duplicate a department name',
                'description' => 'create departement put/ {company_id,department_name} name cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->departments_model->create_department($data);

        if ($response == FALSE) {

            log_message("debug", "index_put Database refused. Try again!... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => 'create departement put/ {company_id,department_name} name cannot be null'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        log_message("debug", "index_put Record created!... ");

        return $this->response([
            'response' => $response,
            'status' => true,
            'message' => 'Department created!',
            'description' => 'To get all [/departments/company_id/] or to get single [/departments/company_id/department_id]'
        ], REST_Controller::HTTP_CREATED);
    }

    public function index_post()
    {

        $data = [
            'department_id' => $this->post('department_id'), // Automatically generated by the model
            'department_name' => $this->post('department_name'),
        ];

        if (empty($data['department_id']) || empty($data['department_name'])) {

            log_message("debug", "index_post Empty department_id/department_name supplied... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Empty department_id/department_name supplied',
                'description' => 'Update departement post/ {department_id,department_name} name and id cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($this->departments_model->department_id_exists($data['department_id']) != TRUE) {

            log_message("debug", "index_POST Record does not exist... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'This department you are trying to update does not exist',
                'description' => 'create departement put/ {company_id,department_name} name cannot be null'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->departments_model->update_department($data);

        if ($response == FALSE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => 'create departement put/ {company_id,department_name} name cannot be null'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        log_message("debug", "Department Updated...");

        return $this->response([
            'response' => $response,
            'status' => TRUE,
            'message' => 'Department Updated!',
            'description' => 'To get all [/departments/company_id/] or to get single [/departments/company_id/department_id]'
        ], REST_Controller::HTTP_OK);
    }

    public function index_delete()
    {

    }

}
