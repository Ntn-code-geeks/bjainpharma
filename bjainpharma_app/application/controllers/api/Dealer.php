<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/*
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

        if(!(isset( $post['sp_code'])&& !empty( $post['sp_code']))){
            $msg='Sp code is required.';
        }
        else if(!(isset($post['city_id'])&& !empty($post['city_id']))){
            $msg = "City ID is required.";
        }
        else if(!(isset($post['doi'])&& !empty($post['doi']))){
            $msg = "date of Interaction is required.";
        }
        else if(!(isset($post['user_id'])&& !empty($post['user_id']))){
            $msg = "User ID is required.";
        }
        if ($msg == '') 
        {
            $sp_code  = $post['sp_code'];
            $city_id  = $post['city_id'];
            $doi  = $post['doi'];
            $usr_id  = $post['user_id'];
            $dataArr['sp_code']=$sp_code;
            $dataArr['city_id']=$city_id;
            $dataArr['doi']=$doi;
            $dataArr['user_id']=$usr_id;
            $data = $this->dealer->get_dealer_list($dataArr);
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
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'No Dealer',
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

