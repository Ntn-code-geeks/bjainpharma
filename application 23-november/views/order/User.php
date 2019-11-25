<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/* 

 * Niraj Kumar

 * Dated: 04/10/2017

 * Project Name: Bjain Pharma Dashboard

 * 

 * 

 * This Controller is for User Login/Logout feature

 */



class User extends Parent_admin_controller {

    

    function __construct()
    {

        parent::__construct();

         

        $this->load->model('User_model','user');

        $this->load->model('doctor/Doctor_model','doctor');
        $this->load->model('pharma_nav/customer_nav_model','cust_nav');
        

        $this->load->model('data_analysis_model','analysis');

		$this->load->model('secondary_supply/secondary_model','secondarys');
        

    }

  

    public function index(){

        

        $loggedData=logged_user_data();
   $switchStatus= $this->session->userdata('switchStatus') ? $this->session->userdata('switchStatus'):0;
            if($loggedData==TRUE && $this->session->userdata('SiteUrl_id')== base_url() && is_first($this->session->userdata('userId'))!=1){


                redirect('user/dashboard');

            }elseif(is_first($this->session->userdata('userId'))==1 && $switchStatus==1){
                 redirect('user/dashboard');
                 //redirect('user/user_change_password/'.$this->session->userdata('userId'));
            }
            else{

    //              echo "i call"; die;

                    $data['title'] = "Bjain Pharma ";

                    $data['action'] = "user/check_login";



                    $this->load->get_view('login_view',$data);

            }

    }

    

    public function check_login(){

        

        $log_data = $this->input->post();


        if(!empty($log_data)){

         $password = md5($log_data['password']);

          $email = $log_data['email'];

          $user_info =  $this->user->check_user($email);

        }
        if(!empty($user_info)){
         

            $stored_pass= $user_info->password;
//echo $password.'<br>'.$stored_pass; die;
           

                if ($password===$stored_pass)

                    {



                           $sesUser = array(

                                                'userName'=>$user_info->name,

					                        	'userId'=>$user_info->id,

						                        'userEmail'=>$user_info->email_id,

                                                'userCity'=>$user_info->city_id,

                                                'userDesig'=>$user_info->desig_id,

                                                'pharmaAre'=>$user_info->pharma_id,

                                                'doctorAre'=>$user_info->doctor_id,

                                                'userBoss' => $user_info->boss_ids,

                                                'userChild'=>$user_info->child_ids,

                        			'switchStatus'=>$user_info->switchStatus,
                                                'admin'=>$user_info->admin,
                        			'sp_code'=>$user_info->sp_code,
                                                
                                                'is_first'=>$user_info->is_first_time,
                                                'SiteUrl_id'=> base_url(),

						

					   );
                           //pr($sesUser); die;
			$this->session->set_userdata($sesUser);
			
		    // $this->nav_cust_connect(); 
                if($user_info->is_first_time!=1){
                   // echo 'ifififif'; die;
                redirect($this->dashboard());   
                }elseif($user_info->is_first_time==1){
                    //echo 'aaaa'; die;
                    redirect($this->user_change_password($user_info->id)); 
                }	
                    

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

    
    /*
     * Developer: Shailesh Saraswat
     * Email: sss.shailesh@gmail.com
     * Dated: 08-JAN-2018
     * 
     * function for change the password for the user who logined by a default password(1234)
     */
    
    public function user_change_password($userid){

//               $loggedData=logged_user_data();
            if($this->session->userdata('SiteUrl_id')== base_url()){
               
                $data['title'] = "Change Passowrd";
                $data['action'] = "user/change_password";
                $data['userid'] = $userid;
                $this->load->view('change_password_view',$data);
                
                
            }else{
               
                $this->index();

            }

        
        
    }

    




    public function dashboard(){
        
         $loggedData=logged_user_data();
            $switchStatus= $this->session->userdata('switchStatus') ? $this->session->userdata('switchStatus'):0;

            if($loggedData==TRUE && $this->session->userdata('SiteUrl_id')== base_url() && (is_first($this->session->userdata('userId'))!=1 || $switchStatus==1) ){
                
//           echo   $this->session->userdata('siteurl');    die;
              $data['title'] = "Dashboard";  
              
            

//              $data['sales'] = $this->analysis->top_sales_cust();  // show top 5 sales dealer
//              $data['payment'] = $this->analysis->top_payment_cust();  // show top 5 payment dealer
//              $data['secondary'] = $this->analysis->top_secondary_cust();  // show top 5 secondary of doctor/pharmacy
//              $data['interaction'] = $this->analysis->top_interaction_cust(); // show top 5 interaction customer (doctor/pharmacy/dealer)
//              $data['most_meet'] = $this->analysis->top_most_met_cust(); // show top 5 meet customer (doctor/pharmacy/dealer)
//              $data['never_meet'] = $this->analysis->top_never_met_cust(); // show top 5 never meet customer (doctor/pharmacy/dealer)
              
              if(is_admin() || logged_user_child()){
                   /*model call for this week*/ 
                  $data['week_secondary'] = $this->analysis->secondary_analysis(); //for doctor secondary highest and lowest
                  $data['week_prodcutive'] = $this->analysis->productive_analysis(); //for doctor Productive call highest and lowest
                  $data['week_no_order'] = $this->analysis->noorder_met_analysis();  // for doctor No order but met highest and lowest
                  $data['week_not_met'] = $this->analysis->not_met_analysis();  // for doctor Not met highest and lowest
                     /*end model for this week*/
                   /*model call for this Month*/ 
              $data['secondary_month'] = $this->analysis->secondary_analysis('-1 month'); //for doctor secondary highest and lowest

              $data['prodcutive_month'] = $this->analysis->productive_analysis('-1 month');  //for doctor Productive call highest and lowest

              $data['no_order_month'] = $this->analysis->noorder_met_analysis('-1 month');// for doctor No order but met highest and lowest
              $data['not_met_month'] = $this->analysis->not_met_analysis('-1 month');  // for doctor Not met highest and lowest

              /*end model for this Month*/
              
               /*model call for this Quarter*/ 
              $data['secondary_quarter'] = $this->analysis->secondary_analysis('-3 month'); //for doctor secondary highest and lowest
              $data['prodcutive_quarter'] = $this->analysis->productive_analysis('-3 month');  //for doctor Productive call highest and lowest
              $data['no_order_quarter'] = $this->analysis->noorder_met_analysis('-3 month');// for doctor No order but met highest and lowest
              $data['not_met_quarter'] = $this->analysis->not_met_analysis('-3 month');  // for doctor Not met highest and lowest
              /*end model for this Quarter*/
              
               /*model call for this Year*/ 
              $data['secondary_year'] = $this->analysis->secondary_analysis('-1 year'); //for doctor secondary highest and lowest
              $data['prodcutive_year'] = $this->analysis->productive_analysis('-1 year');  //for doctor Productive call highest and lowest
              $data['no_order_year'] = $this->analysis->noorder_met_analysis('-1 year');// for doctor No order but met highest and lowest
              $data['not_met_year'] = $this->analysis->not_met_analysis('-1 year');  // for doctor Not met highest and lowest
              /*end model for this Year*/
              
              
               $this->load->get_view('dashboard/admin_home_view',$data);
                  
                  
              }else{
                  
                   /*model call for this week*/ 
              $data['weekdoctor'] = $this->analysis->doc_analysis();  // doctor's prodcutive call,total met,total not met in this week
              $data['weekdealer'] = $this->analysis->dealer_analysis();
              $data['weekpharma'] = $this->analysis->pharma_analysis();

              /*end model for this week*/

              

              /*model call for this Month*/ 
              $data['doctor_month'] = $this->analysis->doc_analysis('-1 month');  // show Doctor

              $data['dealer_month'] = $this->analysis->dealer_analysis('-1 month');  // show dealer

              $data['pharma_month'] = $this->analysis->pharma_analysis('-1 month');  // show pharmacy
              /*end model for this Month*/

              

              /*model call for this Quarter*/ 
              $data['doctor_quarter'] = $this->analysis->doc_analysis('-3 month');  // show Doctor

              $data['dealer_quarter'] = $this->analysis->dealer_analysis('-3 month');  // show dealer

              $data['pharma_quarter'] = $this->analysis->pharma_analysis('-3 month');  // show pharmacy
              /*end model for this Quarter*/

              

              

              /*model call for this Year*/ 
              $data['doctor_year'] = $this->analysis->doc_analysis('-1 year');  // show Doctor

              $data['dealer_year'] = $this->analysis->dealer_analysis('-1 year');  // show dealer

              $data['pharma_year'] = $this->analysis->pharma_analysis('-1 year');  // show pharmacy
              /*end model for this Year*/
              
              $this->load->get_view('dashboard/home_view',$data);
              
              }

            }

            else{

//                echo "not"; die;

                $this->index();

            }

        

    }

    

    // used for switch the users account

    public function switch_account(){

        $userId = $this->input->post('userId') ? $this->input->post('userId') : 0;

//                 echo $userId; die;   

		$status = false;



		if($userId > 0){



			$status = $this->user->user_switch($userId);



		}

               

		echo $status; die;

    }



    



    public function logout(){

        

        

       $this->session->unset_userdata('userId');

       $this->session->unset_userdata('userEmail');

       

       $this->index();

    }
    
    public function email_regarding_tour(){
    	$this->load->model('tour_plan/tour_plan_model','tour');
		$lastday = date('t',strtotime('today'));//last day of month
		$time=strtotime(savedate());
		$message='';
		$sms='';
		$subject="STP Reminder Mail";
		$nextMonth = date('m', strtotime('+1 month'));//next month from current date
		//$month=date("m",$time);
		$day=date("d",$time);//current date
		if($day==$lastday-4 ||$day==$lastday-2|| $day==$lastday)
		{
			if($day==$lastday-4 || $day==$lastday-2)//send mail user 4 day and 2 day of last day of month
			{
				$result = $this->tour->get_user_tour($nextMonth);
				if($result){
					foreach($result as $userData)
					{
						try{
							$sms='Upload your Tour Plan on Bjain crop Software on urgent basis';
							$message='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  <h3>Dear,</h3> <p>'.$sms.'</p><p><i>This is an auto generated email.</i></p><div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name(28).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
							//echo $userData['email_id'].'<------>'.$userData['name'];
							$success =send_email($userData['email_id'], 'pharma.reports@bjain.com',$subject, $message);
						}
						catch(Exception $e)
						{
							// var_dump($e->getMessage());
						}
					}
				}
			}
			elseif($day==$lastday)//send mail user and boss last day of month
			{
				$result = $this->tour->get_user_tour($nextMonth);
				if($result){
					foreach($result as $userData)
					{
						try{
							//echo $userData['email_id'].'<------>'.$userData['name'];
							$sms='Upload your Tour Plan on Bjain Corp Software on Today Positively';
							$message='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  <h3>Dear,</h3> <p>'.$sms.'</p><p><i>This is an auto generated email.</i></p><div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">'.get_user_name(28).'<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
							$success =send_email($userData['email_id'],'pharma.reports@bjain.com', $subject, $message);
							$result = $this->tour->send_email_boss($userData['name']);//will send email to boss only
							$result = $this->tour->send_email_admin($userData['name']);//will send email to admin
						}
						catch(Exception $e)
						{
							//var_dump($e->getMessage());
						}
					}
				}
			}
		}
	}
	
	public function interaction_mismatch(){
    $this->load->model('dealer/Dealer_model','dealer');
    $interaction_data = $this->dealer->interact_details();
  }

  public function change_password()
  {
    $loggedData=logged_user_data();
    if($loggedData==TRUE && $this->session->userdata('SiteUrl_id')== base_url())
    {
      $data=$this->input->post();
      $success =  $this->user->change_user_password($data);
      if($success)
      {
        set_flash('<div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>Password changed successfully.</div>'); 
         $this->index();
//        redirect($_SERVER['HTTP_REFERER']);
      }
      else
      {
        set_flash('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>Some Issue in password change.Please Try Again.
          </div>');
         $this->index();
//        redirect($_SERVER['HTTP_REFERER']);
      }
    }
    else
    {
      $data['title'] = "Bjain Pharma ";
      $data['action'] = "user/check_login";
      $this->load->get_view('login_view',$data);
    }
  }
  
   /*
     * Developer: Shailesh Saraswat
     * Email: sss.shailesh@gmail.com
     * Dated: 24-SEP-2018
     * 
     * For auto update the information of customer into the navigon
     */
    
    public function nav_cust_connect(){
        
         $spcode = $this->session->userdata('sp_code');
        
        // if(!empty($spcode)){
         $mycustomer_API   = "https://www.bjaincorp.com/bjainpharma/nav_con/my_customer.php?spcode=".$spcode;
        // }else{
            // $mycustomer_API   = "https://www.bjaincorp.com/bjainpharma/nav_con/my_customer.php?spcode=";
        // }
       // echo $mycustomer_API;
         $my_customers = file_get_contents($mycustomer_API);
       // pr($my_customers); die;
       
                $sucess =  $this->cust_nav->add_update_dealer($my_customers);
         
                if($sucess==1){
                    // echo 'true';
                    return TRUE;
                }else{
                    // echo 'false';
                  return FALSE;
                }
                
    }
  


    public function ReportsJSON(){
    $data['userdata']=$this->user->users_report();
    $data['total_doctors']=$this->doctor->total_doctors();
    $this->user->weeklyReportData($data);
    $this->user->monthlyReportData($data);
    $this->user->quarterlyReportData($data);
    $this->user->yearlyReportData($data);
  }


  public function Secondary_supply_report(){
		$data['doc_data']=doctor_interaction_list();
		$data['pharma_data']=pharmacy_interaction_list();
		$this->user->secondary_supply($data);
	}
  
  
  
}

