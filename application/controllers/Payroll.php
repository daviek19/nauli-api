<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Payroll extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('payroll_model');
        $this->load->model('people_model');
        $this->load->model('company_model');
    }

    /*     * *
      @param int id (company id)
     * * */

    function summary_get($id)
    {

        log_message("debug", "*********** summary_get start ***********");

        $id = $this->get('id');

        $company_id = (int)$id;

        log_message("debug", "Getting summary for company " . $company_id);

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

    function posting_types_get($id)
    {

        log_message("debug", "*********** posting_types_get start ***********");

        $id = $this->get('id');

        $company_id = (int)$id;

        log_message("debug", "Getting posting_types_get for company " . $company_id);

        if (!empty($company_id) && $company_id > 0) {

            $company = $this->company_model->get_company($company_id);

            $result = $this->payroll_model->posting_types($company_id);

            if (empty($result) || $result == NULL) {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'posting_types_get could not be found'
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
        log_message("debug", "*********** posting_types_get end ***********");
    }

    function posting_types_post($id)
    {
        try {

            log_message("debug", "*********** posting_types_post start ***********");

            $id = (int)$this->get('id');


            if (isset($id) && $id > 0) {
                //edit mode
                log_message("debug", "Edit Mode... where id" . $id);

                $data = array(
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
                );

                $result = $this->company_model->edit_company($data, $id);

                if ($result != FALSE) {
                    $this->set_response($result, REST_Controller::HTTP_OK);
                    log_message("debug", "Company Updated...");
                } else {
                    $this->set_response($data, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    log_message("debug", "Company not Updated...");
                }
            } else {
                //create mode
                log_message("debug", "Create Mode...");

                $data = array(
                    'posting_type_id' => NULL,
                    'posting_type_name' => $this->post('posting_type_name'),
                    'company_id' => $this->post('company_id'),
                    'date_created' => ''
                );

                $result = $this->payroll_model->create_posting_type($data);

                if ($result != FALSE) {

                    $this->set_response($result, REST_Controller::HTTP_CREATED);

                    log_message("debug", "posting_type Created...");
                } else {
                    $this->set_response($data, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

                    log_message("debug", "posting_type not Created...");
                }
            }
            log_message("debug", "*********** posting_type End ***********");
        } catch (Exception $exc) {

            log_message("error", "oops an error occured " . $exc->getTraceAsString());

            $this->set_response($data, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get a companies all deduction codes.
     *
     * @Param $id. This is the company id
     */
    function earning_deduction_codes_get($id)
    {

        log_message("debug", "*********** earning_deduction_codes_get start ***********");

        $id = $this->get('id');

        $company_id = (int)$id;

        log_message("debug", "Getting earning_deduction_codes_get for company " . $company_id);

        if (!empty($company_id) && $company_id > 0) {

            // $company = $this->company_model->get_company($company_id);

            $result = $this->payroll_model->earning_deduction_codes($company_id);

            if (empty($result) || $result == NULL) {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'earning_deduction_codes_get could not be found'
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
        log_message("debug", "*********** earning_deduction_codes_get end ***********");
    }

    /**
     * Get a Single Earning deduction code.
     *
     * @Param $id. This is the earning_deduction_code_id [Key]
     */
    function earning_deduction_code_get($id)
    {
        log_message("debug", "*********** earning_deduction_code_get start ***********");

        $id = $this->get('id');

        $earning_deduction_code = (int)$id;

        log_message("debug", "Getting an earning_deduction_code " . $id);

        if (!empty($earning_deduction_code) && $earning_deduction_code > 0) {

            $result = $this->payroll_model->get_earning_deduction_code($earning_deduction_code);

            if (empty($result) || $result == NULL) {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'earning_deduction_code could not be found'
                ], REST_Controller::HTTP_NOT_FOUND);
            } else {
                $this->response($result, REST_Controller::HTTP_OK);
            }
        } else {

            $this->response([
                'status' => FALSE,
                'message' => 'Provide a valid earning decution code id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        log_message("debug", "*********** earning_deduction_code_get end ***********");
    }

    /**
     * Create and edit a deduction code
     */
    function earning_deduction_code_post()
    {
        try {

            log_message("debug", "*********** earning_deduction_codes_post start ***********");

            $id = (int)$this->get('id');

            if (isset($id) && $id > 0) {
                //edit mode
                log_message("debug", "Edit Mode... where compnay_id" . $id);

                $data = array(
                    'earning_deduction_id' => $id,
                    'company_id' => $this->post('company_id'),
                    'posting_type_id' => $this->post('posting_type_id'),
                    'earning_deduction_name' => $this->post('earning_deduction_name'),
                    'recurrent' => $this->post('recurrent'),
                    'taxable' => $this->post('taxable')
                );

                $result = $this->payroll_model->update_earning_deduction_codes($data);

                if ($result != FALSE) {

                    $this->set_response($result, REST_Controller::HTTP_OK);

                    log_message("debug", "earning_deduction_codes updated...");
                } else {
                    $this->set_response(array_merge($data, array('status' => 'Failed', 'message' => 'ID was empty')), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

                    log_message("debug", "earning_deduction_codes not updated...");
                }
            } else {
                //create mode
                log_message("debug", "Create Mode...");

                $data = array(
                    'earning_deduction_id' => $this->post('company_name'),
                    'company_id' => $this->post('company_id'),
                    'posting_type_id' => $this->post('posting_type_id'),
                    'earning_deduction_name' => $this->post('earning_deduction_name'),
                    'recurrent' => $this->post('recurrent'),
                    'taxable' => $this->post('taxable')
                );

                $result = $this->payroll_model->create_earning_deduction_codes($data);

                if ($result != FALSE) {

                    $this->set_response($result, REST_Controller::HTTP_CREATED);

                    log_message("debug", "earning_deduction_codes created...");
                } else {
                    $this->set_response($data, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

                    log_message("debug", "earning_deduction_codes not created...");
                }
            }
            log_message("debug", "*********** earning_deduction_codes End ***********");
        } catch (Exception $exc) {

            log_message("error", "oops an error occured on earning_deduction_codes" . $exc->getTraceAsString());

            $this->set_response($data, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get an employee Postings.
     */
    function employee_postings_get($id)
    {

        log_message("debug", "***********employee_postings_get start ***********");

        $id = $this->get('id');

        $employee_id = (int)$id;

        log_message("debug", "Getting payroll postings for employee " . $employee_id);

        if (!empty($employee_id) && $employee_id > 0) {

            $employee_details = $this->people_model->get_person($employee_id);

            if ($employee_details != NULL) {

                $company = $this->company_model->get_company($employee_details->company_id);

                $postings_summary = $this->payroll_model->employee_postings_summary($employee_details->id, $company->current_payroll_month);

                $missing_earnings_deductions = $this->payroll_model->employee_missing_earnings_deductions($employee_details->id, $company->current_payroll_month);

                $payroll_postings = $this->payroll_model->employee_payroll_postings($employee_details->id, $company->current_payroll_month);


                $employee_payroll_postings_details = array('postings_summary' => $postings_summary,
                    'missing_earnings_deductions' => $missing_earnings_deductions,
                    'payroll_postings' => $payroll_postings);

                if (empty($employee_payroll_postings_details) || $employee_payroll_postings_details == NULL) {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => 'Error, Employee postings could not be found'
                    ], REST_Controller::HTTP_NOT_FOUND);
                } else {
                    $this->response($employee_payroll_postings_details, REST_Controller::HTTP_OK);
                }
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Error, Employee  could not be found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {

            $this->response([
                'status' => FALSE,
                'message' => 'Provide a employee id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        log_message("debug", "*********** employee_postings_get end ***********");
    }

    function generate_payroll_number_get()
    {
        $company_id = (int)$this->get('company_id');

        $payroll_number = $this->payroll_model->generate_payroll_number($company_id);

        $this->response([
            'response' => $payroll_number,
            'status' => TRUE,
            'description' => 'To get payroll number [/payroll/company_id/]'
        ], REST_Controller::HTTP_OK);
    }
}
