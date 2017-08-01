<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Certificates extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('workshop/certificates_model');
        $this->load->model('workshop/activities_model');
    }

    public function index_get()
    {
        //Get params
        $company_id = (int)$this->get('company_id');

        log_message("debug", "*********** index_get start company_id {$company_id} ***********");

        $result = $this->certificates_model->get_all_certificates($company_id);

        $this->response([
            'response' => $result,
            'status' => TRUE,
            'description' => 'To get all [/workshop/Certificates/company_id/] or to get single [/workshop/Certificates/company_id/item_id]'
        ], REST_Controller::HTTP_OK);

    }

    public function find_get()
    {
        $certificate_id = (int)$this->get('certificate_id');

        $result = $this->certificates_model->get_single_certificate("", $certificate_id);
        $all_activities= $this->activities_model->get_process_activities($result[0]->company_id, $result[0]->process_id);
        $completed_activities = $this->certificates_model->get_completed_activities_id($certificate_id);
        $this->response([
            'response' => $result,
            'all_activities'=>$all_activities,
            'completed_activities'=>$completed_activities,
            'status' => TRUE,
            'description' => 'To get all [/workshop/contractors/company_id/] or to get single [/workshop/contractors/company_id/bank_id]'
        ], REST_Controller::HTTP_OK);
    }
	
	public function index_put()
    {
        $data = array(		
			'company_id' => $this->put('company_id'),
            'completed_date' =>  $this->put('completed_date'),
            'contract_id' =>  $this->put('contract_id'),
            'contract_date' =>  $this->put('contract_date'),
			'job_id' =>  $this->put('job_id'),
            'job_date' =>  $this->put('job_date'),
            'chassis_no' =>  $this->put('chassis_no'),
            'contractor_id' =>  $this->put('contractor_id'),
			'start_date' =>  $this->put('start_date'),
            'end_date' =>  $this->put('end_date'),
            'days' =>  $this->put('days'),
			'amount' =>  $this->put('amount'),
            'deductions' =>  $this->put('deductions'),
            'reason' =>  $this->put('reason'),
			'date_created' =>  $this->put('date_created'),
			's_supervisor' =>  $this->put('s_supervisor'),
			'q_control' =>  $this->put('q_control'),
			'p_manager' =>  $this->put('p_manager'),
			'w_manager' =>  $this->put('w_manager'),
			'user_id' => $this->put('user_id')
        );

        log_message("debug", "Inserting Certificate... " . json_encode($data));

        if (empty($data['company_id'])) {

            return $this->response([
                'status' => FALSE,
                'message' => 'Trying to create empty company id',
                'description' => ''
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $response = $this->certificates_model->create_certificate($data);
		$complted_jobs  = $this->post('completed');
				
		$work_done = array();
		if(!empty($complted_jobs)){
		    foreach($complted_jobs as $job_id){	
		
				$work_done[] = array(
					'activity_id ' => $job_id,
					'company_id' => $this->put('company_id'),
					'certificate_id' => $response->certificate_id,
					'completion_date' => $this->put('completed_date'),			
					'contract_id' => $this->put('contract_id'),			           
					'chassis_no' => $this->put('chassis_no'),			           
					'date_created' => $this->put('date_created'),					
					'user_id' => $this->put('user_id'),
					'status' => 1,
					'model_id' =>'',
					'process_id' =>'',					
					);
			};
		}
		
		$dt_response = $this->certificates_model->create_work_done($response->certificate_id,$work_done);

        if ($response == FALSE) {

            log_message("debug", "index_put Database refused. Try again!... ");

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => 'create group put/ {company_id,warehouse_name,wh_loc_id} name cannot be null'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response([
            'response' => $response,
            'status' => true,
            'message' => 'Certificate created!',
            'description' => ''
        ], REST_Controller::HTTP_CREATED);
    }
	
	public function index_post()
    {
        $data = [		
            'certificate_id' =>  $this->post('certificate_id'),	
            'completed_date' =>  $this->post('completed_date'),
            'contract_id' =>  $this->post('contract_id'),
            'contract_date' =>  $this->post('contract_date'),
			'job_id' =>  $this->post('job_id'),
            'job_date' =>  $this->post('job_date'),
            'chassis_no' =>  $this->post('chassis_no'),
            'contractor_id' =>  $this->post('contractor_id'),
			'start_date' =>  $this->post('start_date'),
            'end_date' =>  $this->post('end_date'),
            'days' =>  $this->post('days'),
			'amount' =>  $this->post('amount'),
            'deductions' =>  $this->post('deductions'),
            'reason' =>  $this->post('reason'),
			'date_created' =>  $this->post('date_created'),
			's_supervisor' =>  $this->post('s_supervisor'),
			'q_control' =>  $this->post('q_control'),
			'p_manager' =>  $this->post('p_manager'),
			'w_manager' =>  $this->post('w_manager'),
			'user_id' => $this->post('user_id')
        ];       

		        log_message("debug", "updating Certificate... " . json_encode($data));

        $response = $this->certificates_model->update_certificate($data);
		
		$work_done = array();
		
		if(!empty($complted_jobs)){
		    foreach($complted_jobs as $job_id){	
		
				$work_done[] = array(
					'activity_id ' => $job_id,
					'company_id' => $this->post('company_id'),
					'certificate_id' => $response->certificate_id,
					'completion_date' => $this->post('completed_date'),			
					'contract_id' => $this->post('contract_id'),			           
					'chassis_no' => $this->post('chassis_no'),			           
					'date_created' => $this->post('date_created'),					
					'user_id' => $this->post('user_id'),
					'status' => 1,
					'model_id' =>'',
					'process_id' =>'',
					
					);
			};
		}
		
		$dt_response = $this->certificates_model->create_work_done($this->post('certificate_id'),$work_done);


        if ($response == FALSE) {

            return $this->response([
                'response' => $data,
                'status' => FALSE,
                'message' => 'Database refused. Try again!',
                'description' => ''
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->response([
            'response' => $response,
            'status' => TRUE,
            'message' => 'Certificate Updated!',
            'description' => ''
        ], REST_Controller::HTTP_OK);
    }
}