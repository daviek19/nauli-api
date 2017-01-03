<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Payroll extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('payroll_model');
        $this->load->model('people_model');
        $this->load->model('company_model');
    }

    /***
      @param int id (company id)
    ***/

     function summary_get($id){        

		log_message("debug", "*********** summary_get start ***********");

        $id = $this->get('id');

        $company_id = (int) $id;
        
        log_message("debug", "Getting summary for company ".$company_id);

        if (!empty($company_id) && $company_id > 0) {

            $company = $this->company_model->get_company($company_id);

            $result = $this->payroll_model->postings_summary($company_id, $company->current_payroll_month);

            if (empty($result) || $result == NULL) {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'postings summary could not be found'
                        ], REST_Controller::HTTP_NOT_FOUND);
            } else {
                $this->response($result, REST_Controller::HTTP_OK);
            }
        } else {

            $this->response([
                'status' => FALSE,
                'message' => 'Provide a valid business id'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
        log_message("debug", "*********** summary_get end ***********");
    }

     function employee_postings_get($id){

            log_message("debug", "***********employee_postings_get start ***********");

             $id = $this->get('id');

             $employee_id = (int) $id;

             log_message("debug", "Getting payroll postings for employee ".$employee_id);

            if (!empty($employee_id) && $employee_id > 0) {

                $employee_details =  $this->people_model->get_person($employee_id);

                if($employee_details != NULL){

                    $company = $this->company_model->get_company($employee_details->company_id);

                    $postings_summary = $this->payroll_model->employee_postings_summary($employee_details->id,$company->current_payroll_month);

                    $missing_earnings_deductions = $this->payroll_model->employee_missing_earnings_deductions($employee_details->id,$company->current_payroll_month);

                    $payroll_postings = $this->payroll_model->employee_payroll_postings($employee_details->id,$company->current_payroll_month);



                    $employee_payroll_postings_details = array('postings_summary' => $postings_summary,
                                                                'missing_earnings_deductions'=>$missing_earnings_deductions,
                                                                'payroll_postings'=>$payroll_postings);

                       if (empty($employee_payroll_postings_details) || $employee_payroll_postings_details == NULL) {
                        $this->set_response([
                            'status' => FALSE,
                            'message' => 'Error, Employee postings could not be found'
                                ], REST_Controller::HTTP_NOT_FOUND);
                    } else {
                        $this->response($employee_payroll_postings_details, REST_Controller::HTTP_OK);
                    }

                } else{
                   $this->set_response([
                            'status' => FALSE,
                            'message' => 'Error, Employee  could not be found'
                                ], REST_Controller::HTTP_NOT_FOUND); 
                }

            } else{

         $this->response([
                        'status' => FALSE,
                        'message' => 'Provide a employee id'
                            ], REST_Controller::HTTP_BAD_REQUEST);
            }

            log_message("debug", "*********** employee_postings_get end ***********");

     }
}

