<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Person extends REST_Controller {

    function __construct() {
        parent::__construct();
    }

    public function user_get() {
        $this->response($data = ["status" => "ok", "message" => "we recieved orderx"], REST_Controller::HTTP_OK);
    }
    
    public function user_post() {
       
    }

}
