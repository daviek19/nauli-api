<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Payments extends REST_Controller {
	
    function __construct()
    {
        parent::__construct();
	    $this->load->model('payment_model');
    }

    public function index_get(){
		
	    $trip_id = $this->get('trip_id');
		
		$payments = $this->payment_model->get_payments($trip_id);
	
		$this->response($payments);		
    }
}
