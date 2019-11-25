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



class Dealer extends REST_Controller {
    function __construct() {
    // Construct the parent class
        parent::__construct();
        $this->load->model('api/dealer_api_model','dealer');
       
    }

    function dealer_list_post() {

	$msg = '';
	$post = array_map('trim', $this->input->post());
	$msg = '';
	$sp_code  = $post['sp_code'];;
        if(!(isset($sp_code)))
        {
        	$msg='Sp code is required.';
        }
       	if ($msg == '') 
        {
	        $data = $this->dealer->get_dealer_list($sp_code);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => array(),
	                'Status' => True,
	                'Message' => 'No Dealer Found',
	                'Code' => 200
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
    
    /*
     * Developer : Shailesh Saraswat
     * Email: sss.shailesh@gmail.com
     * Dated: 04-JAN-2019
     * 
     * get dealer list data based on the city pincode
     * 
     */
    function dealer_list_v2_post() {

	$msg = '';
	$post = array_map('trim', $this->input->post());
	$msg = '';
	$pin_code  = $post['pincode'];
         $sp_code  = $post['sp_code'];
        if(!(isset($sp_code)))
        {
        	$msg='Sp code is required.';
        }
        if(!(isset($pin_code)))
        {
        	$msg='Pin Code is required.';
        }
       	if ($msg == '') 
        {
	        $data = $this->dealer->get_dealer_list($sp_code,$pin_code);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => array(),
	                'Status' => True,
	                'Message' => 'No Dealer Found',
	                'Code' => 200
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
    
    
    
    function add_dealer_post()
    {
        # initialize variables
	$msg = '';
	$dealer_data=json_decode($this->input->raw_input_stream);
        if (!isset($dealer_data->dealer_name) || empty($dealer_data->dealer_name))
        {
	   $msg = 'Please Enter Dealer name.';
	}
	elseif(check_dealer_number($dealer_data->dealer_num))
	{
		$msg = 'Dealer number already exist in our database. Please use different one.';
	}
	elseif(!isset ($dealer_data->city_pin) || empty($dealer_data->city_pin))
	{
	   $msg = 'Please Enter City Pincode';
	}
	elseif(!isset ($dealer_data->dealer_state) || empty($dealer_data->dealer_state))
	{
		$msg = 'Please Enter State.';
	}
	elseif(!isset ($dealer_data->dealer_city) ||  empty($dealer_data->dealer_city))
	{
	  $msg = 'Please Enter City.';
	}
	elseif(!isset ($dealer_data->user_id) || empty($dealer_data->user_id))
	{
	   $msg = 'Please Enter User Id';
	}
	//die;
       	if ($msg == '') 
        {
	        $data = $this->dealer->add_dealer($dealer_data);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Dealer added successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'Error in Save Dealer info.',
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
    
    function edit_dealer_post()
    {
        # initialize variables
	$msg = '';
	$dealer_data=json_decode($this->input->raw_input_stream);
        if (!isset($dealer_data->dealer_name) || empty($dealer_data->dealer_name))
        {
	   $msg = 'Please Enter Dealer name.';
	}
	elseif(!isset ($dealer_data->dealer_id) || empty($dealer_data->dealer_id))
	{
	   $msg = 'Please Enter Dealer Id';
	}
	elseif(check_dealer_number($dealer_data->dealer_num,$dealer_data->dealer_id))
	{
		$msg = 'Dealer number already exist in our database. Please use different one.';
	}
	elseif(!isset ($dealer_data->city_pin) || empty($dealer_data->city_pin))
	{
	   $msg = 'Please Enter City Pincode';
	}
	elseif(!isset ($dealer_data->dealer_state) || empty($dealer_data->dealer_state))
	{
		$msg = 'Please Enter State.';
	}
	elseif(!isset ($dealer_data->dealer_city) ||  empty($dealer_data->dealer_city))
	{
	  $msg = 'Please Enter City.';
	}
	elseif(!isset ($dealer_data->user_id) || empty($dealer_data->user_id))
	{
	   $msg = 'Please Enter User Id';
	}

	//die;
       	if ($msg == '') 
        {
	        $data = $this->dealer->edit_dealer($dealer_data);
		if ($data!=FALSE) 
		{ 
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Dealer edited successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'Error in edit Dealer info.',
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

