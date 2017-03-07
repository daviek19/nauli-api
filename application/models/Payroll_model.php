<?php

class Payroll_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('company_model');
    }

    public function create_posting($employee_id, $posting_type, $posting_description, $posting_amount, $company_settings)
    {

        log_message("debug", "create_posting...data " . json_encode($employee_id . " " . $posting_type . " " . $posting_description . " " . $posting_amount));

        if (!empty($employee_id) && !empty($posting_description)) {
            $query = "INSERT INTO `payroll_postings`(`posting_id`,`employee_id`,`posting_type`, `posting_description`, `posting_amount`, `payroll_month`) 
                     VALUES ('','$employee_id','$posting_type','$posting_description','$posting_amount','$company_settings->current_payroll_month');";

            if ($this->db->query($query)) {
                log_message("debug", "create_posting query " . $this->db->last_query());
                $id = $this->db->insert_id();
                $new_record = $this->db->get_where('payroll_postings', array('posting_id' => $id));
                log_message("debug", " Posting created " . json_encode($new_record->row()));
                return $new_record->row();
            } else {
                return FALSE;
            }
        } else {
            log_message("debug", " employee_id and posting descriptions were empty when creating posting.Exit");
            return FALSE;
        }
    }

    public function postings_summary($company_id, $payroll_month)
    {
        /**
         * This will get the posting summary for the company employees
         * Param (int) company id
         * Return object of (basic_salary,earnings,deductions,net_payable)
         * */
        $summary_query = "SELECT employee_id,
                                 CONCAT(first_name, middle_name, last_name) as full_name,
                                 SUM(case when posting_description = 'Basic Salary' THEN posting_amount ELSE 0 end) basic_salary,
                                 SUM(case when  posting_type  = '1' THEN posting_amount ELSE 0 end) as earnings, 
                                 SUM(case when  posting_type  = '2' THEN posting_amount ELSE 0 end) as deductions,
                                 (SUM(case when  posting_type  = '1' THEN posting_amount ELSE 0 end) - SUM(case when  posting_type  = '2' THEN posting_amount ELSE 0 end)) as net_payable
                                FROM payroll_postings 
                                JOIN people on payroll_postings.employee_id  = people.id
                                WHERE payroll_month =  '$payroll_month'  AND people.company_id = '$company_id' group by employee_id";

        if ($query = $this->db->query($summary_query)) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found postings summary..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting postings_summary.');

            return false;
        }
    }

    public function employee_postings_summary($employee_id, $payrollmonth)
    {
        /**
         * This will get the posting summary for a companyies single employee
         * Param (int) company id
         * Return object of (basic_salary,earnings,deductions,net_payable)
         * */
        $summary_query = "SELECT employee_id,
                                 CONCAT(first_name, middle_name, last_name) as full_name,
                                 SUM(case when posting_description = 'Basic Salary' THEN posting_amount ELSE 0 end) basic_salary,
                                 SUM(case when  posting_type  = '1' THEN posting_amount ELSE 0 end) as earnings, 
                                 SUM(case when  posting_type  = '2' THEN posting_amount ELSE 0 end) as deductions,
                                 (SUM(case when  posting_type  = '1' THEN posting_amount ELSE 0 end) - SUM(case when  posting_type  = '2' THEN posting_amount ELSE 0 end)) as net_payable
                                FROM payroll_postings 
                                JOIN people on payroll_postings.employee_id  = people.id
                                WHERE payroll_month =  ? AND payroll_postings.employee_id = ? group by employee_id";


        if ($query = $this->db->query($summary_query, array($payrollmonth, $employee_id))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found employee_postings_summary..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", "Error selecting employee_postings_summary");

            return false;
        }
    }

    public function employee_missing_earnings_deductions($employee_id, $payrollmonth)
    {

        $select_query = "SELECT * FROM  `earning_deduction_codes` WHERE `code_name` NOT IN 
                          (SELECT `posting_description` FROM `payroll_postings` 
                          WHERE `employee_id` = ? AND `payroll_month`= ? )";

        if ($query = $this->db->query($select_query, array($employee_id, $payrollmonth))) {

            log_message("debug", "Selected employee_missing_earnings_deductions query " . $this->db->last_query());

            log_message("debug", "found employee_missing_earnings_deductions ..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", "Error selecting employee_missing_earnings_deductions");

            return FALSE;
        }
    }

    public function employee_payroll_postings($employee_id, $payrollmonth)
    {

        $select_query = "SELECT * FROM `payroll_postings` WHERE `employee_id` = ? AND `payroll_month`= ? ;";

        if ($query = $this->db->query($select_query, array($employee_id, $payrollmonth))) {

            log_message("debug", "Selected employee_payroll_postings query " . $this->db->last_query());

            log_message("debug", "found employee_payroll_postings ..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", "Error selecting employee_payroll_postings");

            return FALSE;
        }
    }

    public function create_initial_posting($result)
    {
        /*         * *
          When an employee is first created we want to directly insert
          the postings based on the employees basic salary
          Most of these are statutory requirements.
         * * */
        $return_result = array();

        $company_settings = $this->company_model->get_company($result->company_id);

        $return_result[] = $this->create_posting($result->employee_id, '1', 'Basic Salary', $result->basic_pay, $company_settings);

        if ($result->pays_kra == '1') {
            //Get current ammount
            $kra = '0.00';
            $kra_amount = $this->_calculate_statutory_amount($result->basic_pay, 'PAYEE');
            $return_result[] = $this->create_posting($result->employee_id, '2', 'PAYEE', $kra_amount, $company_settings);
        }

        if ($result->pays_nssf == '1') {
            //Get current ammount
            $nssf = '0.00';
            $nssf_amount = $this->_calculate_statutory_amount($result->basic_pay, 'NSSF');
            $return_result[] = $this->create_posting($result->employee_id, '2', 'NSSF', $nssf_amount, $company_settings);
        }

        if ($result->pays_nhif == '1') {
            //Get current ammount
            $nhif = '0.00';
            $nhif_amount = $this->_calculate_statutory_amount($result->basic_pay, 'NHIF');
            $return_result[] = $this->create_posting($result->employee_id, '2', 'NHIF', $nhif_amount, $company_settings);
        }

        return $return_result;
    }

    public function update_initial_posting($result)
    {
        /*         * *
          Update posting when an employee details are updated.
          This will involve Updating the basic salary.
          Based on the updated salary, remove old postings and create afresh
         * * */

        if (!empty($result->employee_id)) {

            $company_settings = $this->company_model->get_company($result->company_id);

            $this->db->where('employee_id', $result->employee_id);
            $this->db->where('payroll_month', $company_settings->current_payroll_month);
            $this->db->where('posting_description', 'Basic Salary');

            if ($this->db->update('payroll_postings', array('posting_amount' => $result->basic_pay))) {

                log_message("debug", "update_posting query " . $this->db->last_query());

                //Delete Original Statutory postings        
                $delete_query = "DELETE FROM `payroll_postings` WHERE 
                                 `posting_description` IN(?,?,?) AND 
                                 `employee_id` = ?";

                if ($this->db->query($delete_query, array('PAYEE', 'NSSF', 'NHIF', $result->employee_id))) {

                    log_message("debug", "deleted posting query " . $this->db->last_query());

                    $return_result[] = array();

                    //Insert fresh statutory postings
                    if ($result->pays_kra == '1') {
                        //Get current ammount
                        $kra = '0.00';
                        $kra_amount = $this->_calculate_statutory_amount($result->basic_pay, 'PAYEE');
                        $return_result[] = $this->create_posting($result->employee_id, '2', 'PAYEE', $kra_amount, $company_settings);
                    }

                    if ($result->pays_nssf == '1') {
                        //Get current ammount
                        $nssf = '0.00';
                        $nssf_amount = $this->_calculate_statutory_amount($result->basic_pay, 'NSSF');
                        $return_result[] = $this->create_posting($result->employee_id, '2', 'NSSF', $nssf_amount, $company_settings);
                    }

                    if ($result->pays_nhif == '1') {
                        //Get current ammount
                        $nhif = '0.00';
                        $nhif_amount = $this->_calculate_statutory_amount($result->basic_pay, 'NHIF');
                        $return_result[] = $this->create_posting($result->employee_id, '2', 'NHIF', $nhif_amount, $company_settings);
                    }
                    return $return_result;
                } else {
                    log_message("error", "Error deleting statutory postings");
                    return FALSE;
                }
            } else {
                log_message("error", " Error with db, check query");
                return FALSE;
            }
        } else {
            log_message("debug", " employee_id was empty when creating posting.Exit");
            return FALSE;
        }
    }

    public function posting_types($company_id)
    {
        /*
         * 0 in this case is the default
         */

        $summary_query = "SELECT * FROM payroll_posting_types WHERE company_id IN (?,?);";

        if ($query = $this->db->query($summary_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found posting_types..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting posting_types.');

            return false;
        }
    }

    public function create_posting_type($data)
    {

        log_message("debug", "Getting ready to insert... " . json_encode($data));

        if (!empty($data['posting_type_name'])) {

            if ($this->db->insert('payroll_posting_types', $data)) {

                $id = $this->db->insert_id();

                $new_record = $this->db->get_where('payroll_posting_types', array('company_id' => $id));

                log_message("debug", "create_posting_type query " . $this->db->last_query());

                log_message("debug", " payroll_posting_types " . json_encode($new_record->row()));

                return $new_record->row();
            } else {

                return FALSE;
            }
        } else {
            log_message("debug", " Posting name was empty.Exit");

            return FALSE;
        }
    }

    public function earning_deduction_codes($company_id)
    {
        /*
         * 0 in this case is the default
         */

        $summary_query = "SELECT 
                        payroll_earning_deduction_codes.earning_deduction_id,
                        payroll_earning_deduction_codes.company_id,
                        payroll_earning_deduction_codes.posting_type_id,
                        payroll_earning_deduction_codes.earning_deduction_name,
                        payroll_earning_deduction_codes.recurrent,
                        payroll_earning_deduction_codes.taxable,
                        payroll_earning_deduction_codes.date_created,
                        payroll_posting_types.posting_type_name                       
                        FROM payroll_earning_deduction_codes
                        LEFT JOIN payroll_posting_types ON payroll_earning_deduction_codes.posting_type_id = payroll_posting_types.posting_type_id
                        WHERE payroll_earning_deduction_codes.company_id IN (?,?) ORDER BY `date_created` DESC;";

        if ($query = $this->db->query($summary_query, array($company_id, '0'))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found earning_deduction_codes..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting earning_deduction_codes.');

            return false;
        }
    }

    public function get_earning_deduction_code($code_id)
    {
        $summary_query = "SELECT 
                        payroll_earning_deduction_codes.earning_deduction_id,
                        payroll_earning_deduction_codes.company_id,
                        payroll_earning_deduction_codes.posting_type_id,
                        payroll_earning_deduction_codes.earning_deduction_name,
                        payroll_earning_deduction_codes.recurrent,
                        payroll_earning_deduction_codes.taxable,
                        payroll_earning_deduction_codes.date_created,
                        payroll_posting_types.posting_type_name                       
                        FROM payroll_earning_deduction_codes
                        LEFT JOIN payroll_posting_types ON payroll_earning_deduction_codes.posting_type_id = payroll_posting_types.posting_type_id
                        WHERE payroll_earning_deduction_codes.earning_deduction_id = (?);";

        if ($query = $this->db->query($summary_query, array($code_id))) {

            log_message("debug", $this->db->last_query());

            log_message("debug", "found earning_deduction_code..." . json_encode($query->result()));

            return $query->result();
        } else {

            log_message("error", 'Error getting earning_deduction_code.');

            return false;
        }
    }

    public function update_earning_deduction_codes($data)
    {
        $data['recurrent'] = $data['recurrent'] == null ? "0" : "1";
        $data['taxable'] = $data['taxable'] == null ? "0" : "1";

        log_message("debug", "Getting ready to edit update_earning_deduction_codes... " . json_encode($data));

        if (!empty($data['earning_deduction_id']) && $data['earning_deduction_id'] != NULL) {

            $this->db->where('earning_deduction_id', $data['earning_deduction_id']);

            if ($this->db->update('payroll_earning_deduction_codes', $data)) {

                log_message("debug", "update_earning_deduction_codes query " . $this->db->last_query());
                //Get the record
                $new_record = $this->db->get_where('payroll_earning_deduction_codes', array('earning_deduction_id' => $data['earning_deduction_id']));

                log_message("debug", " update_earning_deduction_codes Updated... " . json_encode($new_record->row()));

                return $new_record->row();
            } else {
                log_message("debug", " Error with db, check query");

                return FALSE;
            }
        } else {
            log_message("debug", " earning_deduction_id was empty when creating posting.Exit");

            return FALSE;
        }
    }

    public function create_earning_deduction_codes($data)
    {
        $data['recurrent'] = $data['recurrent'] == null ? "0" : "1";
        $data['taxable'] = $data['taxable'] == null ? "0" : "1";

        log_message("debug", "create_earning_deduction_codes...data " . json_encode($data));

        if ($this->db->insert('payroll_earning_deduction_codes', $data)) {

            log_message("debug", "create_earning_deduction_codes create query " . $this->db->last_query());

            $id = $this->db->insert_id();

            $new_record = $this->db->get_where('payroll_earning_deduction_codes', array('earning_deduction_id' => $id));

            log_message("debug", " payroll_earning_deduction_codes created " . json_encode($new_record->row()));

            return $new_record->row();
        } else {
            return FALSE;
        }
    }

    private function _calculate_statutory_amount($basic_pay, $statutory_type)
    {

        $amount = '0.00';

        switch ($statutory_type) {
            case 'PAYEE':
                return $amount = '1000';
                break;
            case 'NSSF':
                return $amount = '2000';
                break;
            case 'NHIF':
                return $amount = '3000';
                break;
            default:
                return $amount;
        }
    }

    public function update_posting_legacy($data)
    {
        log_message("debug", "Getting ready to edit... " . json_encode($data));

        if (!empty($data['employee_id'])) {
            $this->db->where('employee_id', $data['employee_id']);
            $this->db->where('payroll_month', $data['payroll_month']);
            if ($this->db->update('payroll_postings', $data)) {
                log_message("debug", "update_posting query " . $this->db->last_query());
                //Get the record
                $new_record = $this->db->get_where('payroll_postings', array('employee_id' => $data['employee_id'], 'payroll_month' => $data['payroll_month']));
                log_message("debug", " Psoting Updated... " . json_encode($new_record->row()));
                return $new_record->row();
            } else {
                log_message("debug", " Error with db, check query");
                return FALSE;
            }
        } else {
            log_message("debug", " employee_id was empty when creating posting.Exit");
            return FALSE;
        }
    }

    public function company_postings_legacy($company_id)
    {
        $query = $this->db->query("SELECT * FROM `payroll_postings` JOIN `people` ON payroll_postings.employee_id = people.id
                 WHERE people.company_id = '{$company_id}';");
        log_message("debug", $this->db->last_query());
        log_message("debug", "found..." . json_encode($query->result()));
        return $query->result();
    }

    public function create_posting_legacy($user)
    {
        log_message("debug", "create_posting...data " . json_encode($data));

        if (!empty($data['employee_id'])) {
            if ($this->db->insert('payroll_postings', $data)) {
                log_message("debug", "create_posting query " . $this->db->last_query());
                $id = $this->db->insert_id();
                $new_record = $this->db->get_where('payroll_postings', array('posting_id' => $id));
                log_message("debug", " Posting created " . json_encode($new_record->row()));
                return $new_record->row();
            } else {
                return FALSE;
            }
        } else {
            log_message("debug", " employee_id was empty when creating posting.Exit");
            return FALSE;
        }
    }

    public function generate_payroll_number($company_id = 0)
    {
        //do an insert and get the new id
        if ($company_id == 0) {
            $prefix = "X";
        } else {
            $prefix = $company_id;
        }

        if ($this->db->insert('payroll_number_tracker', array('company_id' => $company_id))) {
            $new_row_id = $this->db->insert_id();
            $padded = str_pad($new_row_id, 4, '0', STR_PAD_LEFT);
            $result = array('payroll_number' => $prefix . $padded);
            return $result;
        } else {
            //If something goes wrong with db
            $result = array('payroll_number' => "F" . rand(0, 1000));
            return $result;
        }
    }

}
