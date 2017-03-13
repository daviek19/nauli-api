<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Groups extends REST_Controller {
	
	    function __construct() {

        parent::__construct();
        $this->load->model('workshop/groups_model');
    }
	
public function index_get() {		
	//Get params
	$company_id = (int) $this->get('company_id');

	log_message("debug", "*********** index_get start company_id {$company_id} ***********");

	$result = $this->departments_model->get_all_departments($company_id);

	$this->response([
		'response' => $result,
		'status' => TRUE,
		'description' => 'To get all [/departments/company_id/] or to get single [/departments/company_id/department_id]'
			], REST_Controller::HTTP_OK);        

}

public function find_get() {}

public function index_put() {}

public function index_post() {}