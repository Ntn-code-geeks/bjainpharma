<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/*
 * Developer: Niraj Sharma
 * Email: niraj@bjain.com
 * 
 * Dated: 28-08-2018
 * 
 */



class Meeting extends REST_Controller {
    function __construct() {
    // Construct the parent class
        parent::__construct();
        $this->load->model('api/meeting_api_model','meet');
    
    }
     
    function meeting_master_get()
    {
        # initialize variables
	$msg = '';
       	if ($msg == '') 
        {
	        $data = $this->meet->get_meeting_list();
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
	                'Message' => 'No Product',
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
    
    function meeting_list_get()
    {
        # initialize variables
	$msg = '';
	$userid  = $this->get('userid');
        if(!(isset($userid)&& !empty($userid)))
        {
        	$msg='User Id is required.';
        }
       	if ($msg == '') 
        {
	        $data = $this->meet->get_meeting_details($userid);
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
	                'Message' => 'No Meeting',
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
  
    
    
    function add_meeting_post()
    {
        # initialize variables
	$msg = '';
	$meeting_data=json_decode($this->input->raw_input_stream);
        if (!isset($meeting_data->meeting_type) || empty($meeting_data->meeting_type))
        {
	   $msg = 'Please enter meeting type';
	}
	elseif(!isset ($meeting_data->meeting_date) || empty($meeting_data->meeting_date))
	{
		$msg = 'Please Enter Meeting date.';
	}
	elseif(!check_leave($meeting_data->meeting_date,$meeting_data->user_id))
	{
		$msg = 'You have taken leave  or holiday on that day please change date!!';
	}
	elseif(!isset ($meeting_data->meeting_place) || empty($meeting_data->meeting_place))
	{
	   $msg = 'Please Enter Meeting Place';
	}

	elseif(!isset ($meeting_data->user_id) || empty($meeting_data->user_id))
	{
	   $msg = 'Please Enter User Id';
	}
	//die;
       	if ($msg == '') 
        {
	        $data = $this->meet->save_meeting($meeting_data);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Meeting save successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'Error in Save Meeting info.',
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
    
    function sync_meeting_post()
    {
        # initialize variables
	
	$meeting=json_decode($this->input->raw_input_stream);
	foreach($meeting->data as $meeting_data)
	{
	        if (!isset($meeting_data->meeting_type) || empty($meeting_data->meeting_type))
	        {
		   $msg = 'Please enter meeting type';
		}

		elseif(!isset ($meeting_data->meeting_place) || empty($meeting_data->meeting_place))
		{
		   $msg = 'Please Enter Meeting Place';
		}
		elseif(!isset ($meeting_data->meeting_date) || empty($meeting_data->meeting_date))
		{
			$msg = 'Please Enter Meeting date.';
		}
		elseif(!check_leave($meeting_data->meeting_date,$meeting_data->user_id))
		{
			$msg = 'You have taken leave  or holiday on that day please change date!!';
		}
		elseif(!isset ($meeting_data->user_id) || empty($meeting_data->user_id))
		{
		   $msg = 'Please Enter User Id';
		}
		//die;

	       	if ($msg == '') 
	        {
		        $data = $this->meet->save_meeting($meeting_data);
	        }
        }
        $result = array(
	        'Data' => $data,
		// 'Status' => true,
	        'Message' => 'Meeting save successfully',
	        'Code' => 200
	    );
        $this->response($result);
    }
    
    function add_leave_post()
    {
        # initialize variables
	$msg = '';
	$leave_data=json_decode($this->input->raw_input_stream);
        if (!isset($leave_data->from_date) || empty($leave_data->from_date))
        {
	   $msg = 'Please enter from date';
	}
	elseif(!check_inteaction($leave_data->from_date,$leave_data->from_date,$leave_data->user_id))
	{
		$msg = 'You filled interaction on this day';
	}
	elseif(!isset ($leave_data->to_date) || empty($leave_data->to_date))
	{
	   $msg = 'Please enter to date';
	}
	elseif(!isset ($leave_data->user_id) || empty($leave_data->user_id))
	{
	   $msg = 'Please Enter User Id';
	}
	//die;
       	if ($msg == '') 
        {
	        $data = $this->meet->save_leave($leave_data);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Leave save successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'Error in save leave info.',
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
    
    function sync_leave_post()
    {
        # initialize variables
	
	$leave=json_decode($this->input->raw_input_stream);
	foreach($leave->data as $leave_data)
	{
	        if (!isset($leave_data->from_date) || empty($leave_data->from_date))
	        {
		   $msg = 'Please enter from date';
		}
		elseif(!check_inteaction($leave_data->from_date,$leave_data->from_date,$leave_data->user_id))
		{
			$msg = 'You filled interaction on this day';
		}
		elseif(!isset ($leave_data->to_date) || empty($leave_data->to_date))
		{
		   $msg = 'Please enter to date';
		}
		elseif(!isset ($leave_data->user_id) || empty($leave_data->user_id))
		{
		   $msg = 'Please Enter User Id';
		}

	       	if ($msg == '') 
	        {
		        $data = $this->meet->save_leave($leave_data);
	        }
        }
        $result = array(
	        'Data' => $data,
		// 'Status' => true,
	        'Message' => 'Leave save successfully',
	        'Code' => 200
	    );
        $this->response($result);
    }
    
    function monthly_assign_tasks_post()
    {
        # initialize variables
	$msg = '';
	$tour_data=json_decode($this->input->raw_input_stream);
        if (!isset($tour_data->month) || empty($tour_data->month))
        {
	   $msg = 'Please enter month';
	}
	elseif(!isset($tour_data->year) || empty($tour_data->year))
	{
		$msg = 'Please enter year';
	}
	elseif(!isset ($tour_data->user_id) || empty($tour_data->user_id))
	{
		$msg = 'Please Enter User Id';
	}
       	if ($msg == '') 
        {
        	$year=$tour_data->year;
        	$month=$tour_data->month;
        	$userid=$tour_data->user_id;
        	$lastday = date("t", strtotime($month));
        	$start_date =$year.'-'.$month.'-01';
		$end_date = $year.'-'.$month.'-'.$lastday;
	        $data['holiiday'] = get_holiday_data($userid,$start_date,$end_date);
   	        $data['assign_task']  = get_assign_task_by($userid,$start_date,$end_date);
	        $data['follow_data']  = get_followup_data($userid,$start_date,$end_date);
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
    
    function monthly_tp_post()
    {
        # initialize variables
	$msg = '';
	$tour_data=json_decode($this->input->raw_input_stream);
        if (!isset($tour_data->month) || empty($tour_data->month))
        {
	   $msg = 'Please enter month';
	}
	elseif(!isset($tour_data->year) || empty($tour_data->year))
	{
		$msg = 'Please enter year';
	}
	elseif(!isset ($tour_data->user_id) || empty($tour_data->user_id))
	{
		$msg = 'Please Enter User Id';
	}
       	if ($msg == '') 
        {
        	$year=$tour_data->year;
        	$month=$tour_data->month;
        	$userid=$tour_data->user_id;
        	$lastday = date("t", strtotime($month));
        	$start_date =$year.'-'.$month.'-01';
		$end_date = $year.'-'.$month.'-'.$lastday;
	        $data['holiiday'] = get_holiday_data($userid,$start_date,$end_date);
   	        $data['assign_task']  = get_assign_task_by($userid,$start_date,$end_date);
	        $data['follow_data']  = get_followup_data($userid,$start_date,$end_date);
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
    
    function leave_list_get()
    {
        # initialize variables
	$msg = '';
	$userid  = $this->get('userid');
        if(!(isset($userid)&& !empty($userid)))
        {
        	$msg='User Id is required.';
        }
       	if ($msg == '') 
        {
	        $data = $this->meet->get_leave_list($userid);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Successfully',
	                'Code' => 200
	            );
	        }
              elseif ($data==FALSE) 
		{ 
	            $result = array(
	                'Data' => array(),
			// 'Status' => true,
	                'Message' => 'Successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => array(),
	                'Status' => false,
	                'Message' => 'No Leave',
	                'Code' => 404
	            );
	        }
        }
        else 
        {
            $result = array(
                'Data' => array(),
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
       	if ($msg == '') 
        {
	        $data = $this->meet->save_tour_plan($tp_data);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Tour Plan successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'Error in Save Meeting info.',
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
    
   
}

