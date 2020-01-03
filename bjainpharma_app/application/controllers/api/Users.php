<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';


/*
Developer: Nitin Kumar
 */



class Users extends REST_Controller {
    function __construct() {
    // Construct the parent class
        parent::__construct();
        $this->load->model('api/users_api_model','user');
    }

    function login_user_post() {
        # initialize variables
        $post = array_map('trim', $this->input->post());
        $msg = '';
        $data = array();
        $email = $post['email'];
        $pass = md5($post['password']);
        # Set message if fields is blank
        if (empty($post['email'])) {
            $msg = 'Please Enter your Email.';
        } 
        elseif (empty($post['password'])) 
        {
            $msg = 'Please Enter Password.';
        }  
        elseif (filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false) {
            $msg = 'Invalid EMAIL ID';

        } 
 
        if ($msg == '') 
        {
          $data = $this->user->check_user_api($email);
          if($data!=FALSE)
          {
	  	//   pr($data);     die;
	    $stored_pass= $data->password;
	    if ($pass ===$stored_pass)
	    {    
	    	$dataUser = array(
                      'userName'=>$data->name,
                      'userId'=>$data->id,
                      'userEmail'=>$data->email_id,
                      'userCity'=>$data->city_id,
                      'userDesig'=>$data->desig_id,
                      'pharmaAre'=>$data->pharma_id,
                      'doctorAre'=>$data->doctor_id,
                      'userBoss' => $data->boss_ids,
                      'userChild'=>$data->child_ids,
                      'sp_code'=>$data->sp_code,
                    );
            	$result = array(
	                'Data' => $dataUser,
	                'Status' => true,
	                'Message' => 'successfully',
	                'Code' => 200
	            );
            }
            else 
            {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'Invalid Username and Password!',
	                'Code' => 404
	            );
            }
          }
          else 
          {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => 'Invalid Username and Password!',
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

 
     //get all state	
   function all_state_get()
     {
        $data = $this->user->get_all_state();
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
                'Message' => 'No State',
                'Code' => 404
            );
        }
        $this->response($result);
    }
    
   
   //get all city
   function all_city_get()
   {
        $data = $this->user->get_all_city();
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
                'Message' => 'No City',
                'Code' => 404
            );
        }
        $this->response($result);
   }
    
   function users_boss_get()
   {
   	$msg = '';
	$userid  = $this->get('userid');
        if(!(isset($userid)&& !empty($userid)))
        {
        	$msg='User Id is required.';
        }
       	if ($msg == '') 
        {
	        $data = $this->user->get_users_boss($userid);
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
	                'Message' => 'No Boss',
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
   
  
  function email_ho_post() 
   {
	    $post= array_map('trim', $this->input->post());
            $msg ='';
            $item=array();
            if (!isset($post['email'])) {
	        $msg = 'Please Enter Email';
	    }
            elseif(!isset ($post['subject'])){
                  $msg = 'Please Enter Subject';
            }
            elseif(!isset ($post['body'])){
                  $msg = 'Please Enter Mail Body';
            }
            elseif(!isset ($post['user_id'])){
                  $msg = 'Please Enter user id';
            }
       	    if ($msg == '')
       	    {
		$sender_email=get_user_deatils($post['user_id'])->email_id;
		$failedmail=array();
		$vendoremail=array();
		$new_name='';
		$recipient=$post['email'];
		$message=$post['body'];
		$subject=$post['subject'];

			$dir_r=__DIR__;
			$dir_ar=array_slice(array_reverse(array_filter(explode('/',$dir_r))), 4);
			$base_dir='/'.(implode('/',array_reverse($dir_ar))).'/bjainpharma/';


		if (!empty($_FILES['file1']['name']))
  		 {        		
			$mimes = array('image/jpeg','image/png','image/jpg','image/JPG');
			if(in_array($_FILES['file1']['type'],$mimes))
			{
				$new_name =time().'_'.$_FILES['file1']['name'];
				/*Name of file should be single string & not contains _ and blank space*/
				// $config['file_name'] = $new_name;
				// $config['upload_path']  = './assets/proof/';
				// $config['allowed_types']= 'jpg|jpeg|png';

				

				$config = array( 'file_name'  => $new_name,
				 				  'upload_path' => $base_dir.'assets/proof',
                     			  'allowed_types' => "jpg|jpeg|png",
                     			  'overwrite' => TRUE, );

				get_instance()->load->library('upload', $this->config); 
				$this->upload->initialize($config);
				// $this->load->library('upload', $config);
				$fnm='file1';
				if ($this->upload->do_upload($fnm))
				{
					echo $this->upload->display_errors();	  		  		
				}
				else{

					$result = array(
				            'Data' => new stdClass(),
				            //'Status' => false,
				            'Message' => "Something Went wrong. Try again !!",
				            'Code' => 200
				        );
				        $this->response($result);
				}
			}
			else
			{
				$result = array(
			            'Data' => new stdClass(),
			            //'Status' => false,
			            'Message' => "File type allowed only jpeg,jpg and png.",
			            'Code' => 200
			        );
			        $this->response($result);
			}
		}

		$pharma_url=$_SERVER['REDIRECT_SSL_TLS_SNI'].'/bjainpharma/'; 
		$this->load->library('email', email_setting());
		$this->email->to($recipient);
		$this->email->from($sender_email);
		$this->email->subject($subject); 
		if($new_name!='')
		{
			$attachpath=$base_dir.'assets/proof/'.$new_name;
			$this->email->attach( $attachpath);
			// echo $attachpath;
			// die;
		}
		$this->email->message($message);
		$result=$this->email->send();
		if($result)
		{
			chmod($base_dir.'assets/proof/', 0777);
			unlink( $base_dir.'assets/proof/'.$new_name);
			$result = array(
		            'Data' => new stdClass(),
		            'Message' => "Email Sent Successfully.",
		            'Code' => 200
		        );
		}
		else
		{
			chmod($base_dir.'assets/proof/', 0777);
			unlink( $base_dir.'assets/proof/'.$new_name);
			$result = array(
		            'Data' => new stdClass(),
		            'Message' => "Email can't Sent Now.",
		            'Code' => 404
		        );
		}
		//die;
	 } 
	 else
	 {
	        $result = array(
	            'Data' => new stdClass(),
	            //'Status' => false,
	            'Message' => $msg,
	            'Code' => 404
	        );
	  }
	$this->response($result);	
    }


function user_childs_get(){
	   $msg = '';
	   $userid  = $this->get('userid');
	   if(!(isset($userid)&& !empty($userid)))
	   {
		   $msg='User Id is required.';
	   }
	   if ($msg == '')
	   {
//		   $data = get_check_active_users(get_user_child($userid));
		   $userID = array_values(get_check_active_users(get_user_child($userid)));
		   $usrData=array();
		   foreach ($userID as $uid){
		   		$name=get_user_name($uid);
		   		$usrData[]=array('user_id' => $uid, 'username' => $name);
		   }
		   $data=$usrData;

		   if ($data!=FALSE)
		   {
		   	   $blank[]=array('username' => 'Select Employee');
			   $result = array(
				   'Data' => array_merge($blank,$data),
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
				   'Message' => 'No Child',
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

