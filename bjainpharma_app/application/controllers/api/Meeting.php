<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/*
 * Developer: Nitin Kumar
 * 
 */



class Meeting extends REST_Controller {
    function __construct() {
    // Construct the parent class
        parent::__construct();
        $this->load->model('api/meeting_api_model','meet');
    
    }
  
    
    
    
    function monthly_tp_post()
    {
        # initialize variables

		$post= array_map('trim', $this->input->post());
		$msg ='';
		$item=array();
		if (!isset($post['month'])) {
			$msg = 'Please enter month';
		}
		elseif(!isset ($post['year'])){
			$msg = 'Please enter year';
		}
		elseif(!isset ($post['user_id'])){
			$msg = 'Please Enter User Id';
		}



       	if ($msg == '') 
        {
        	$year=$post['year'];
        	$month=$post['month'];
        	$userid=$post['user_id'];
        	$lastday = date("t", strtotime($month));
        	$start_date =$year.'-'.$month.'-01';
			$end_date = $year.'-'.$month.'-'.$lastday;
	        $data['holiday'] = get_holiday_data($userid,$start_date,$end_date);
   	        $data['assign_task']  = get_assign_task_by($userid,$start_date,$end_date);
	        $data['follow_data']  = get_followup_data($userid,$start_date,$end_date);
	         $data['leave_data']  = get_leaves_inmonth($userid,$start_date,$end_date);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'No Leave',
	                'Code' => 404
	            );
	        }
        }
        else 
        {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 404
            );
        }
        $this->response($result);
    }
    
  
    
    function add_tp_post()
    {
        # initialize variables
	$msg = '';
	$tp_data=json_decode($this->input->raw_input_stream);
	   	if($msg == ''){
	        $data = $this->meet->save_tour_plan($tp_data);
		if($data!=FALSE){
	            $result = array(
	                'Data' => $data,
				 // 'Status' => true,
	                'Message' => 'Tour Plan successfully',
	                'Code' => 200
	            );
	        }
	    else{
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'Error in Save Tour Plan.',
	                'Code' => 404
	            );
	        }
        }
        else{
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 404
            );
        }
        $this->response($result);
    }
    


     function tp_list_monthly_post(){
		$post= array_map('trim', $this->input->post());
		$msg ='';
		$item=array();
		if (!isset($post['user_id'])) {
			$msg = 'Please enter User ID';
		}
		else if(!isset ($post['year_month'])){
			$msg = 'Please enter Year-Month';
		}
		if ($msg == '')
		{
			$year_month=$post['year_month'];
			$userid=$post['user_id'];
			$data['Monthly_TP']  = get_tour_info($userid,$year_month);
			
			if ($data!=FALSE && (!empty($data['Monthly_TP'])) )
			{
				$result = array(
					'Data' => $data,
					// 'Status' => true,
					'Message' => 'Successfully',
					'Code' => 200
				);
			}
			else
			{
				$result = array(
					'Data' => new stdClass(),
					'Status' => false,
					'Message' => 'No Data Found For this Parameters.',
					'Code' => 404
				);
			}
		}
		else
		{
			$result = array(
				'Data' => new stdClass(),
				'Status' => false,
				'Message' => $msg,
				'Code' => 404
			);
		}
		$this->response($result);

	}




	function single_tour_plan_post(){
		# initialize variables
		$post= array_map('trim', $this->input->post());
		$msg ='';
		$data=array();
		if (!isset($post['date'])) {    /*Date : DD-MM-YYYY*/
			$msg = 'Please enter Tour Date';
		}
		elseif(!isset ($post['city'])){
			$msg = 'Please enter Tour City';
		}
		elseif(!isset ($post['remarks'])){
			$msg = 'Please Enter Remarks';
		}
		elseif(!isset ($post['assignby'])){
			$msg = 'Please Enter Assigned By';
		}
		elseif(!isset ($post['assignto'])){
			$msg = 'Please Enter Assigned To';
		}

		/*In this case Assigned to & Assigned by  Have same userID because the person who's TP was opened was self assigning him or Updating TP. */

		if($msg == ''){
			$data['date']=$post['date'];
			$data['dest_city']=$post['city'];
			$data['remarks']=$post['remarks'];
			$data['assignby']=$post['assignby'];
			$data['assignto']=$post['assignto'];
			$data = $this->meet->add_single_tour_plan($data);
			if($data!=FALSE){
				$result = array(
					'Data' => $data,
					// 'Status' => true,
					'Message' => 'Tour Plan Saved successfully',
					'Code' => 200
				);
			}
			else{
				$result = array(
					'Data' => new stdClass(),
					'Status' => false,
					'Message' => 'Error in Save Tour Plan.',
					'Code' => 404
				);
			}
		}
		else{
			$result = array(
				'Data' => new stdClass(),
				'Status' => false,
				'Message' => $msg,
				'Code' => 404
			);
		}
		$this->response($result);
	}
   


function month_dates_get(){
		$start_date =date('Y-m-d',strtotime('first day of +1 month'));
		$end_date = date('Y-m-d',strtotime('last day of +1 month'));
		$tdate=array();
		while (strtotime($start_date) <= strtotime($end_date)){
			if(date('D',strtotime($start_date))!='Sun'){
				$tdate[]= date ("Y-m-d", strtotime($start_date));
			}else{
				$tdate[]= date ("Y-m-d", strtotime($start_date)).'-'.date('D',strtotime($start_date));
			}
			$start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));
		}

		if (!empty($tdate)){
			$result = array(
				'Data' => $tdate,
				// 'Status' => true,
				'Message' => 'Successfully',
				'Code' => 200
			);
		}
		else
		{
			$result = array(
				'Data' => new stdClass(),
				'Status' => false,
				'Message' => 'No Dates Found',
				'Code' => 404
			);
		}
		$this->response($result);
	}


	function assign_tp_post(){
		# initialize variables
		$post= array_map('trim', $this->input->post());
		$msg ='';
		$data=array();
		if (!isset($post['date'])) {    /*Date : DD-MM-YYYY*/
			$msg = 'Please enter Tour Date';
		}
		elseif(!isset ($post['city'])){
			$msg = 'Please enter Tour City';
		}
		elseif(!isset ($post['remarks'])){
			$msg = 'Please Enter Remarks';
		}
		elseif(!isset ($post['assignby'])){
			$msg = 'Please Enter Assigned By - UserID';
		}
		elseif(!isset ($post['assignto'])){
			$msg = 'Please Enter Assigned To - UserID';
		}

		/*In this case Assigned to & Assigned by  Has to be different userID because the person assigning him was his managers. */

		if($msg == ''){
			$data['date']=$post['date'];
			$data['dest_city']=$post['city'];
			$data['remarks']=$post['remarks'];
			$data['assignby']=$post['assignby'];
			$data['assignto']=$post['assignto'];
			$data = $this->meet->add_single_tour_plan($data);
			if($data!=FALSE){
				$result = array(
					'Data' => $data,
					// 'Status' => true,
					'Message' => 'Tour Plan Assigned successfully',
					'Code' => 200
				);
			}
			else{
				$result = array(
					'Data' => new stdClass(),
					'Status' => false,
					'Message' => 'Error in Save Tour Plan.',
					'Code' => 404
				);
			}
		}
		else{
			$result = array(
				'Data' => new stdClass(),
				'Status' => false,
				'Message' => $msg,
				'Code' => 404
			);
		}
		$this->response($result);
	}


function planned_city_post(){
		# initialize variables
		$post= array_map('trim', $this->input->post());
		$msg ='';
		$data=array();
		if (!isset($post['doi'])) {    /*Date : DD-MM-YYYY*/
			$msg = 'Please enter Date of Interaction';
		}
		elseif(!isset ($post['user_id'])){
			$msg = 'Please enter UserID';
		}

		if($msg == ''){
			$data['doi']=$post['doi'];   /* date format: yyyy-mm-dd */
			$data['user_id']=$post['user_id'];
			$data = $this->meet->planned_city($data);
			if($data!=FALSE){
				$result = array(
					'Data' => $data,
					// 'Status' => true,
					'Message' => 'This Date was Planned for above City ID.',
					'Code' => 200
				);
			}
			else{
				$result = array(
					'Data' => new stdClass(),
					'Status' => false,
					'Message' => 'No Tour Plan Found for this date.',
					'Code' => 404
				);
			}
		}
		else{
			$result = array(
				'Data' => new stdClass(),
				'Status' => false,
				'Message' => $msg,
				'Code' => 404
			);
		}
		$this->response($result);
	}

}

