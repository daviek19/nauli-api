<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Company extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('company_model');
    }

    function company_post() {

        try {
            log_message("debug", "*********** company_post start ***********");

            $data = array(
                'company_id' => NULL,
                'company_name' => $this->post('company_name'),
                'company_type_id' => $this->post('company_type_id'),
                'company_size_id' => $this->post('company_size_id'),
                'company_phone' => $this->post('company_phone'),
                'company_email' => $this->post('company_email'),
                'company_kra_pin' => $this->post('company_kra_pin'),
                'company_taxrate_id' => $this->post('company_taxrate_id'),
                'company_currency_id' => $this->post('company_currency_id'),
                'company_logo_location' => $this->post('company_logo_location'),
                'company_print_recepit' => $this->post('company_print_recepit'),
                'company_currency_right' => $this->post('company_currency_right'),
                'company_created_by' => $this->post('company_created_by'),
                'date_created' => ''
            );

            $result = $this->company_model->create_company($data);

            if ($result != FALSE) {
                $this->set_response($result, REST_Controller::HTTP_CREATED);
                log_message("debug", "Company Created...");
            } else {
                $this->set_response($data, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                log_message("debug", "Company not Created...");
            }
            log_message("debug", "*********** Company_post End ***********");
        } catch (Exception $exc) {
            log_message("error", "oops an error occured " . $exc->getTraceAsString());
            $this->set_response($data, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function company_get($id) {
        try {
            log_message("debug", "*********** company_get start ***********");

            $id = $this->get('id');

            $id = (int) $id;

            log_message("debug", "getting company " . $id);

            if (!empty($id) && $id > 0) {
                //A valid id was supplied
                //Fetch the user from the db
                $result = $this->company_model->get_company($id);

                if (empty($result) || $result == NULL) {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => 'Company could not be found'
                            ], REST_Controller::HTTP_NOT_FOUND);
                } else {
                    $this->response($result, REST_Controller::HTTP_OK);
                }
            } else {

                $this->response([
                    'status' => FALSE,
                    'message' => 'Provide a valid company id'
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
            log_message("debug", "*********** person_get end ***********");
        } catch (Exception $exc) {
            log_message("error", $exc->getTraceAsString());
        }
    }

    function companies_get() {
        
    }

}
