<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Person extends REST_Controller {

    function __construct() {
// Construct the parent class
        parent::__construct();
        $this->load->model('people_model');
        $this->load->model('payroll_model');
        $this->load->model('company_model');
    }

    function person_get() {
        log_message("debug", "*********** person_get start ***********");

        $id = $this->get('id');

        $id = (int) $id;

        if (!empty($id) && $id > 0) {        
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

    function people_get() {}

    function person_post() {
        try {
            $id = (int) $this->get('id');

            if (isset($id) && $id > 0) {
                ### Edit mode
                log_message("debug", "person_post() Edit Mode... where person id" . $id);

                $data = array(
                    'id' => $this->post('id'),
                    'gender' => $this->post('gender'),
                    'company_id' => $this->post('company_id'),
                    'first_name' => $this->post('first_name'),
                    'middle_name' => $this->post('middle_name'),
                    'last_name' => $this->post('last_name'),
                    'phone' => $this->post('phone'),
                    'email' => $this->post('email'),
                    'pin_no' => $this->post('pin_no'),
                    'id_no' => $this->post('id_no'),
                    'nssf_no' => $this->post('nssf_no'),
                    'nhif_no' => $this->post('nhif_no'),
                    'is_active' => $this->post('is_active')
                );

                $result = $this->people_model->update_person($data, $id);

                if ($result != FALSE) {
                    $this->set_response($result, REST_Controller::HTTP_OK);
                    log_message("debug", "person Updated...");
                } else {
                    $this->set_response($data, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    log_message("debug", "person not Updated...");
                }
            } else {
                log_message("debug", "*********** person create start ***********");
                $data = array(
                    'id' => NULL,
                    'company_id' => $this->post('company_id'),
                    'user_id' => $this->post('user_id'),
                    'first_name' => $this->post('first_name'),
                    'middle_name' => $this->post('middle_name'),
                    'last_name' => $this->post('last_name'),
                    'phone' => $this->post('phone'),
                    'email' => $this->post('email'),
                    'pin_no' => $this->post('pin_no'),
                    'id_no' => $this->post('id_no'),
                    'nssf_no' => $this->post('nssf_no'),
                    'nhif_no' => $this->post('nhif_no'),
                    'is_employee' => $this->post('is_employee'),
                    'is_active' => $this->post('is_active')
                );

                $result = $this->people_model->create_person($data);

                if ($result != FALSE) {
                    $this->set_response(array_merge($result, array('message' => 'Updated person')), REST_Controller::HTTP_CREATED);
                    log_message("debug", "Person Created...");
                } else {
                    $this->set_response(array_merge($data, array('message' => 'person not created')), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    log_message("debug", "Person not Created...");
                }
                log_message("debug", "*********** person_post End ***********");
            }
        } catch (Exception $exc) {
            log_message("error", "oops an error occured " . $exc->getTraceAsString());
            $this->set_response(array_merge($data, array('message' => 'person not created')), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
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

    function employee_post() {
        log_message("debug", "**************** Employee Posting ****************");
        try {
            $id = (int) $this->get('id');

            if (isset($id) && $id > 0) {
                //edit mode               
                log_message("debug", "*********** Employee Edit start ***********");

                $data = array(
                    'id' => $this->post('id'),
                    'gender' => $this->post('gender'),
                    'company_id' => $this->post('company_id'),
                    'first_name' => $this->post('first_name'),
                    'middle_name' => $this->post('middle_name'),
                    'last_name' => $this->post('last_name'),
                    'phone' => $this->post('phone'),
                    'email' => $this->post('email'),
                    'pin_no' => $this->post('pin_no'),
                    'id_no' => $this->post('id_no'),
                    'nssf_no' => $this->post('nssf_no'),
                    'nhif_no' => $this->post('nhif_no'),
                    'is_active' => $this->post('is_active'),
                    'pays_kra' => $this->post('pays_kra'),
                    'pays_nssf' => $this->post('pays_nssf'),
                    'pays_nhif' => $this->post('pays_nhif'),
                    'basic_pay' => $this->post('basic_pay'),
                    'is_employee' => 1
                );

                log_message("debug", "Edit Mode... where employee " . $id . " for data " . json_encode($data));

                $result = $this->people_model->update_person($data, $id);

                if ($result != FALSE) {
                    //Create a new payroll posting for the new employee 
                    $company = $this->company_model->get_company($result->company_id);

                    $payroll_posting_data = array(
                        'employee_id' => $result->id,
                        'payroll_month' => $company->current_payroll_month,
                        'gross_salary' => $result->basic_pay,
                        'payee' => '100000',
                        'nhif' => '100000'
                    );

                    $payrollResult = $this->payroll_model->update_posting($payroll_posting_data);

                    if ($payrollResult != FALSE) {
                        $this->set_response($result, REST_Controller::HTTP_CREATED);

                        log_message("debug", "Employee Updated and payroll posted...");
                    } else {
                        $this->set_response(array_merge($payroll_posting_data, array('message' => 'payroll not posted')), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                        log_message("debug", "Payroll not updated...");
                    }
                } else {
                    $this->set_response($data, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    log_message("debug", "Employee not Updated...");
                }
            } else {
                log_message("debug", "*********** Employee create start ***********");
                $data = array(
                    'id' => NULL,
                    'company_id' => $this->post('company_id'),
                    'gender' => $this->post('gender'),
                    'user_id' => $this->post('user_id'),
                    'first_name' => $this->post('first_name'),
                    'middle_name' => $this->post('middle_name'),
                    'last_name' => $this->post('last_name'),
                    'phone' => $this->post('phone'),
                    'email' => $this->post('email'),
                    'pin_no' => $this->post('pin_no'),
                    'id_no' => $this->post('id_no'),
                    'nssf_no' => $this->post('nssf_no'),
                    'nhif_no' => $this->post('nhif_no'),
                    'is_employee' => 1,
                    'is_active' => $this->post('is_active'),
                    'pays_kra' => $this->post('pays_kra'),
                    'pays_nssf' => $this->post('pays_nssf'),
                    'pays_nhif' => $this->post('pays_nhif'),
                    'basic_pay' => $this->post('basic_pay')
                );

                $result = $this->people_model->create_person($data);

                if ($result != FALSE) {
                    //Create a new payroll posting for the new employee 
                    $company = $this->company_model->get_company($result->company_id);

                    $payroll_posting_data = array(
                        'employee_id' => $result->id,
                        'payroll_month' => $company->current_payroll_month,
                        'gross_salary' => $result->basic_pay,
                        'payee' => '100000',
                        'nhif' => '100000'
                    );

                    $payrollResult = $this->payroll_model->create_posting($payroll_posting_data);

                    if ($payrollResult != FALSE) {
                        $this->set_response($result, REST_Controller::HTTP_CREATED);

                        log_message("debug", "Employee Created and payroll posted...");
                    } else {
                        $this->set_response(array_merge($payroll_posting_data, array('message' => 'payroll not posted')), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                        log_message("debug", "Payroll not posted...");
                    }
                } else {
                    $this->set_response(array_merge($data, array('message' => 'Employee not created')), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    log_message("debug", "Employee not Created...");
                }
                log_message("debug", "*********** Employee_post End ***********");
            }
        } catch (Exception $exc) {
            log_message("error", "oops an error occured " . $exc->getTraceAsString());
            $this->set_response(array_merge($data, array('message' => 'person not created')), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
