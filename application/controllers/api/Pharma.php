<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/*
 * 
 */



class Pharma extends REST_Controller {
    function __construct() {
    // Construct the parent class
        parent::__construct();
        $this->load->model('api/pharma_api_model','pharma');
       
    }

    function pharma_list_post()
    {
        # initialize variables
        $post = array_map('trim', $this->input->post());
        $msg = '';

        if(!(isset( $post['sp_code'])&& !empty( $post['sp_code']))){
            $msg='Sp code is required.';
        }
        else if(!(isset($post['city_id'])&& !empty($post['city_id']))){
            $msg = "City ID is required.";
        }
        if ($msg == '')
        {
            $sp_code  = $post['sp_code'];
            $city_id  = $post['city_id'];
            $dataArr['sp_code']=$sp_code;
            $dataArr['city_id']=$city_id;
            $data = $this->pharma->get_pharma_list($dataArr);
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
	                'Message' => 'No Pharma',
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

