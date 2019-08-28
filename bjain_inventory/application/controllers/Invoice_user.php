<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/* 
 * Shailesh Saraswat
 * Dated: 12-Nov-2018
 * Project Name: This project is used for fatch products
 * 
 * This Controller is for User Login/Logout feature
 */



class Invoice_user extends Parent_admin_controller {


     function __construct()
    {

        parent::__construct();

        $this->load->model('invoice_admin/User_model','user');

    }
    public function index(){

        $loggedData=logged_user_data();

            if($loggedData==TRUE && $this->session->userdata('SiteUrl_id')== base_url()){

//                echo "mee"; die;

                redirect('invoice_user/dashboard');

            }
            else{

//                echo "i call"; die;

        $data['title'] = "Bjain Pharma Prodcut details";

        $data['action'] = "invoice_user/check_login";


        $this->load->invoiceView('invoice_admin/login_view',$data);

            }

    }
    

    public function check_login(){

        
        $log_data = $this->input->post();

        if(!empty($log_data)){

         $password = md5($log_data['password']);

          $email = $log_data['email'];

          $user_info =  $this->user->check_invoice_user($email);

        }
        if(!empty($user_info)){
         
            $stored_pass = $user_info->password;

            //echo $stored_pass; die;

                if ($password===$stored_pass)
                    {

                           $sesUser = array(
                                                'userId'=>$user_info->userId,
                                                'userName'=>$user_info->name,
						'userEmail'=>$user_info->email_id,
                                                'SiteUrl_id'=> base_url(),
					   );
			$this->session->set_userdata($sesUser);
			
		        // $this->nav_cust_connect(); 
			
                           redirect($this->dashboard());    

                    }
                    else
                    {

                        $msg = "<div class='alert alert-danger alert-dismissible'>

                             <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>

                             <h4><i class='icon fa fa-ban'></i> Alert!</h4>

                             Invalid Username and Password!

                              </div>";

                        set_flash($msg);

                        $this->index();    

                    }   

            }
            else{

                $msg = "<div class='alert alert-danger alert-dismissible'>

                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>

                <h4><i class='icon fa fa-ban'></i> Alert!</h4>

                Invalid Username and Password!

                 </div>";

                set_flash($msg);

                $this->index();

            }

    }

    public function dashboard(){
        
         $loggedData=logged_user_data();
        // echo $loggedData; die;
            if($loggedData==TRUE && $this->session->userdata('SiteUrl_id')== base_url()){
//           echo   $this->session->userdata('siteurl');    die;
               $data['title'] = "Dashboard"; 
               try{
                $invoice_API   = "https://www.bjaincorp.com/bjainpharma/nav_con/invoice.php?skucode=''";
            //   $invoice_API = "http://###.##.##.##/mp/get?mpsrc=http://mybucket.s3.amazonaws.com/11111.mpg&mpaction=convert format=flv";
          
                $data['nav_invoice'] = @file_get_contents($invoice_API);
               }catch(Exception $e){

                   $data['nav_invoice'] = '';
                    
                    }
                if($data['nav_invoice']===FALSE){
                    $data['nav_invoice'] = '';
                }
//                    pr($data['nav_invoice']);
//                    die;
               
               $this->load->invoiceView('invoice_view',$data);

            }
            else{

//                echo "not"; die;
                $this->index();

            }

    }

    public function logout(){
 
     // echo 'logout'; die;
       $this->session->unset_userdata('userName');
       $this->session->unset_userdata('SiteUrl_id');
       $this->session->unset_userdata('userEmail');

       

       $this->index();

    }
  
  
  
}

?>