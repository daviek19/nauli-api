<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Person extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('people_model');
    }

    function person_get() {
        log_message("debug", "*********** person_get start ***********");

        $id = $this->get('id');

        $id = (int) $id;

        if (!empty($id) && $id > 0) {
            //A valid id was supplied
            //Fetch the user from the db
            $result = $this->people_model->get_person($id);

            if (empty($result) || $result == NULL) {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Person could not be found'
                        ], REST_Controller::HTTP_NOT_FOUND);
            } else {
                $this->response($result, REST_Controller::HTTP_OK);
            }
        } else {

            $this->response([
                'status' => FALSE,
                'message' => 'Provide a valid person id'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        log_message("debug", "*********** person_get end ***********");
    }

    function people_get() {        
    }
    
    function person_post() {
        log_message("debug", "*********** person_post start ***********");
        $data = array(
            'id' => NULL,
            'company_id' => $this->post('company_id'),
            'user_id' => $this->post('user_id'),
            'first_name' => $this->post('first_name'),
            'middle_name' => $this->post('middle_name'),
            'last_name' => $this->post('last_name'),
            'phone' => $this->post('phone'),
            'email' => $this->post('email')
        );

        $result = $this->people_model->create_person($data);

        if ($result != FALSE) {
            $this->set_response($result, REST_Controller::HTTP_CREATED);
            log_message("debug", "Person Created...");
        } else {
            $this->set_response($data, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            log_message("debug", "Person not Created...");
        }
        log_message("debug", "*********** person_post End ***********");
    }

    function user_get() {
        log_message("debug", "*********** user_get start ***********");

        $id = $this->get('id');

        $id = (int) $id;

        log_message("debug", "getting user_id " . $id);

        if (!empty($id) && $id > 0) {
            //A valid id was supplied
            //Fetch the user from the db
            $result = $this->people_model->get_user($id);

            if (empty($result) || $result == NULL) {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'User could not be found'
                        ], REST_Controller::HTTP_NOT_FOUND);
            } else {
                $this->response($result, REST_Controller::HTTP_OK);
            }
        } else {

            $this->response([
                'status' => FALSE,
                'message' => 'Provide a valid user id'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        log_message("debug", "*********** person_get end ***********");
    }
  

}
