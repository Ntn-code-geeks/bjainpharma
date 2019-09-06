<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Niraj Kumar
 * Dated: 20-Nov-2017
 * This Controller is for Show Last 30 Days Interaction for the user
 */



class Interaction extends Parent_admin_controller {
	
    function __construct() 
    {
        parent::__construct();
		$loggedData=logged_user_data();
		if(empty($loggedData)){
			redirect('user'); 
		}
		$this->load->model('doctor/Doctor_model','doctor');
		$this->load->model('dealer/Dealer_model','dealer');
		$this->load->model('permission/permission_model','permission');       
		$this->load->model('pharmacy/pharmacy_model','pharmacy');
		$this->load->model('report/report_model','report');
        $this->load->model('user_model','user');
//        $this->load->model('data_report_analysis','analysis');
    }

    

	public function index(){
            
		$data['title'] = "Add Interaction";
        $data['page_name'] = "Add Interaction";
		/*$cityList=array();
		$cities_are = logged_user_cities();
		$city_id=explode(',', $cities_are);
		foreach($city_id as $key=>$val)
		{
			$cityList[]=array('city_id'=>$val,'city_name'=>get_city_name($val));
		}*/

		$data['city_list']=get_all_city($this->session->userdata('sp_code'));
                
                 if(is_admin() || logged_user_child()){
                     
                     $data['child_user_list'] = $this->permission->user_child_team();
                 
//                     pr($data['child_user_list']); die;
                 }
                
                
//                pr($data['city_list']); die;
		$data['action'] = "interaction/add_direct_inteaction";
        $this->load->get_view('interaction_list/add_interactoin_view',$data); 
        
    }

	public function add_direct_inteaction($date='',$city=''){
		$data['title'] = "Add Interaction";
		$data['page_name'] = "Add Interaction";
		if($date=='' || $city==''){
			$post_data = $this->input->post();
            @$sourcecity=get_city_id($post_data['planedcity']); ///City ID
			$this->load->library('form_validation');
			$this->form_validation->set_rules('doi', 'Inteaction Date', "required");
			$this->form_validation->set_rules('interaction_city', 'Interaction City', "required");

			if($this->form_validation->run() == TRUE ){

                            if(check_serialize_date($post_data['doi'], logged_user_data(),$post_data['interaction_city'])){
                               // pr($post_data); die;
				$datablank='';
				$page='';
				$per_page='';
                $data['date_interact'] = $post_data['doi'];
                $data['interaction_city'] = $post_data['interaction_city'];
                $data['planned_city'] = $sourcecity;


     $data['joint_working'] = isset($post_data['working_user_id'])?$post_data['working_user_id']:'';
                                
				$data['dealer_data'] = $this->dealer->dealermaster_info($per_page, $page,$datablank,$post_data['interaction_city']);
				$data['doctor_data'] = $this->doctor->doctormaster_info($per_page, $page,$datablank,$post_data['interaction_city']);
				$data['pharma_data'] = $this->pharmacy->pharmacymaster_info($per_page, $page,$datablank,$post_data['interaction_city']);
				
                                if(empty( $data['joint_working'])){
//                                    echo 'if'; die;
                                    $this->load->get_view('interaction_list/list_all_person_view',$data); 
                                }else{
                                    $data['action'] = "interaction/save_asm_interaction_report";
                                    $this->load->get_view('interaction_list/joint_working_asm_form_view',$data);
                                    
                                }
                            }
                            else{
                                 set_flash('<div class="alert alert-danger alert-dismissible">

                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>

                                   You already filled the interaction on Same date and City.

                                  </div>');


                                  redirect('interaction/index/');  
//				  $this->index();
			       }
                            
			}
			else if($_POST['date_interact'] || $_POST['an_interaction_city']){

                    $data['date_interact'] = $_POST['date_interact'];
                    $data['interaction_city'] = $_POST['an_interaction_city'];
                    $data['planned_city'] = $sourcecity;
                    $datablank='';
                    $page='';
                    $per_page='';

                    $data['dealer_data'] = $this->dealer->dealermaster_info($per_page, $page,$datablank,$_POST['an_interaction_city']);
                    $data['doctor_data'] = $this->doctor->doctormaster_info($per_page, $page,$datablank,$_POST['an_interaction_city']);
                    $data['pharma_data'] = $this->pharmacy->pharmacymaster_info($per_page, $page,$datablank,$_POST['an_interaction_city']);

                    $this->load->get_view('interaction_list/list_all_person_view',$data);




            }
			else{
                                 set_flash('<div class="alert alert-danger alert-dismissible">

                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>

                                   Interaction Date & City are Mandatory.

                                  </div>');


                                  redirect('interaction/index/');
//				  $this->index();
			}
		}
		else
		{
			$city1=urisafedecode($city);
			$date1= urisafedecode($date);
			$datablank='';
			$page='';
			$per_page='';
			$data['date_interact'] = $date1;
			$data['interaction_city'] =$city1;
			$data['dealer_data'] = $this->dealer->dealermaster_info($per_page, $page,$datablank,$city1);
			$data['doctor_data'] = $this->doctor->doctormaster_info($per_page, $page,$datablank,$city1);
			$data['pharma_data'] = $this->pharmacy->pharmacymaster_info($per_page, $page,$datablank,$city1);
			$this->load->get_view('interaction_list/list_all_person_view',$data); 
		}
	}


        
        /*
         * Asm interaction save
         * 
         */
	public function save_asm_interaction_report()
        {
            $interaction_data = $this->input->post();

            $summaryArr=array(
				'summry1'=>'THE PRIMARY / SECONDARY ORDER RATIO : '.$interaction_data['remark'][0],
				'summry2'=>'THE CURRENT RATION OF TARGET TO ACHIEVEMENT : '.$interaction_data['remark'][1],
				'summry3'=>'THE DAILY CALL AVERAGE : '.$interaction_data['remark'][2],
				'summry4'=>'DOCTORS VISITED MORE THAN 3 TIMES BUT NO ORDER : '.$interaction_data['remark'][3],
				'summry5'=>'SECONDARY PAYMENT OVERDUE IN MARKET : '.$interaction_data['remark'][4]
			);

         	if($interaction_data['stay'] || $interaction_data['up']){
                $success = $this->dealer->save_asm_dsr($interaction_data);

				if ($success = 1) {
                	/*Mail to Boss(Manager), Ajay rana & Nishant */
					$joint_with=$interaction_data['joint_workwith'];
					$joint_with_name=get_user_name($joint_with);
					$boss_userID=logged_user_boss();
					$boss_mail=get_boss_email_user($boss_userID);
					$date_Time= date("d-M-Y/D");
					$user_ID=logged_user_data();
					$user_name=get_user_name($user_ID);
					$user_email=get_boss_email_user($user_ID);

					$mailArr=array(
						'boss'=> $boss_mail,
						'nishant'=> 'nishant@bjain.com',
						'ajay'=> 'pharmamarketing@bjain.com',
						'user' => $user_email,
						'nitin'=> 'php@bjaintech.com'
					);

					foreach ($mailArr as $mailID){
						$dealeremailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center><h3>Dear,</h3> <p>Here\'s the summary of Joint Interaction '.$user_name.' with '.$joint_with_name.' on '.$date_Time.'. 	</p> <ul>';

					$body2=array();
					foreach($summaryArr as $anwsers)
					{	$body2[] = "<li>". $anwsers. "</li>";	}
					$dealeremailbody2=implode(' ',$body2);

					$dealeremailbody3='</ul> <p style="font-size: 11px; text-align: center;"><i>(This is an auto-generated email.)</i></p><div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';

					$message= $dealeremailbody.$dealeremailbody2.$dealeremailbody3;
					$subject="Joint Interaction of ".$user_name. "with ".$joint_with_name." Summary Report on "
						.$date_Time;

/*Open on Server for mailing */
//					$mail_Send = send_email($mailID, 'pharma.reports@bjain.com',$subject, $message);

					}

					set_flash('<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-check"></i> Success!</h4>
					Interaction are being saved for this.</div>');
					redirect('interaction/index/');
                }
                else {
					set_flash('<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-ban"></i> Alert!</h4>
					Interaction was not saved please try later..</div>');
					redirect('interaction/index/');
                }
            }else{
					set_flash('<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-ban"></i> Alert!</h4>
					Stay / Not Stay - Features Not Used..</div>');
					redirect('interaction/index/');
            }



                }




	public function doctor_interaction(){
		$data['title'] = "Doctor Interaction View";
		$data['page_name']="List of Doctor Interaction";

		$this->load->get_view('interaction_list/interaction_doc_details_view',$data);
	}

    

    

    // edit doctor interaction

    

    public function edit_doc_interaction($id=''){

        

          $data['title'] = "Edit Doctor Interaction";

          $data['page_name']="Edit Doctor Interaction";

          

          $doc_id = urisafedecode($id);

          $data['users_team'] = $this->permission->user_team(); // show child and boss users

          $data['dealer_list']= $this->dealer->dealer_list(); 

           $data['pharma_list']= $this->permission->pharmacy_list(logged_user_cities()); 

           $data['meeting_sample'] = $this->doctor->meeting_sample_master();

            $data['doc_interaction']  = $this->report->edit_doc_interaction($doc_id);

          

//           pr($data['doc_interaction']); die;

          $this->load->get_view('interaction_list/edit_doc_interaction_view',$data);

        

    }

    

    // update doc interaction

    public function update_doc_interaction($id){

        

        $interaction_data = $this->input->post();


	$interactionDate=$interaction_data['doi_doc'];

		

        $this->load->library('form_validation');

        

         $this->form_validation->set_rules('doi_doc', 'Date of Interaction', "required");

        

        if(isset($interaction_data['meet_or_not'])){



         $this->form_validation->set_rules('remark', 'Remark', "required");

        }

//        else{

            $this->form_validation->set_rules('dealer_view_id', '', "required"); 

//        }

        if(isset($interaction_data['doc_id']) && !empty($interaction_data['m_sale'])){

            

           $this->form_validation->set_rules('dealer_id', 'Dealer or Sub Dealer', "required"); 

        }

//        if(isset($interaction_data['pharma_id']) && !empty($interaction_data['m_sale'])){

//            

//           $this->form_validation->set_rules('dealer_id', 'Dealer or Sub Dealer', "required"); 

//        }

        

        if($this->form_validation->run() == TRUE){

        

        

       if(!empty($interaction_data['m_sale']) || !empty($interaction_data['m_payment']) ||  !empty($interaction_data['m_stock']) || !empty($interaction_data['m_sample']) || (isset($interaction_data['meet_or_not']) || !empty($interaction_data['meet_or_not']) )){

              

             

           

         $success=$this->dealer->update_doc_interaction($interaction_data,$id);

      

         

         if($success=1){

            

                

            set_flash('<div class="alert alert-success alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-check"></i> Success!</h4>

               interaction are being saved for this

              </div>'); 

//           redirect($_SERVER['HTTP_REFERER']);

//          if(empty($interaction_data['gs_id']) && !isset($interaction_data['gs_id'])){

//           redirect('dealer/dealer_add/view_dealer_for_doctor/'.$id);

//            }

//            else{

                redirect('interaction/doctor_interaction'); 

//            }

           

        }

        else{

            set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               interaction are not saved please try latter..

              </div>');

            redirect('interaction/doctor_interaction'); 

//             if(empty($interaction_data['gs_id']) && !isset($interaction_data['gs_id'])){

//           redirect('dealer/dealer_add/view_dealer_for_doctor/'.$id);

//            }

//            else{

//                redirect('dealer/dealer_add/view_group_dealer_for_doctor/'.$id); 

//            }

            

        }

       }

       else{

            set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               Please Select Any One Type of Meeting...

              </div>');

            redirect($_SERVER['HTTP_REFERER']);

       }

        }

        else{

            if(empty($interaction_data['dealer_id'])){

                set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               Please Select Dealer/Sub Dealer for the sale...

              </div>'); 

            }

            else if(empty($interaction_data['doi_doc'])){

                set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               Please Select Date Of Interaction...

              </div>'); 

            }

            else{

            set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               Remark Is Mandatory for meeting!!

              </div>');

            }

            redirect($_SERVER['HTTP_REFERER']);

        }

        

    }





    public function dealer_interaction(){
        $data['title'] = "Dealer Interaction View";
        $data['page_name']="List of Dealer Interaction";
        $this->load->get_view('interaction_list/interaction_dealer_details_view',$data);
    }

    

    // edit dealer interaction

    public function edit_dealer_interaction($id=''){

        

          $data['title'] = "Edit Dealer Interaction";

          $data['page_name']="Edit Dealer Interaction";

          

          $deal_id = urisafedecode($id);

          $data['users_team'] = $this->permission->user_team(); // show child and boss users

           

          $data['meeting_sample'] = $this->doctor->meeting_sample_master();

          $data['dealer_interaction']  = $this->report->edit_dealer_interaction($deal_id);

//          pr($data['dealer_interaction']); die;

          $this->load->get_view('interaction_list/edit_dealer_interaction_view',$data);

    }

    

    // update dealer interaction

    public function update_dealer_interaction($id){

        

       $interaction_data = $this->input->post();

		$interactionDate=$interaction_data['doi_doc'];

		 /* $result=$this->dealer->checkleave($interactionDate);

		  if(!$result)

		  {

			  set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               You have taken leave on that day please change date!!

              </div>');

              redirect($_SERVER['HTTP_REFERER']);

		  }*/

       $this->load->library('form_validation');

        

         $this->form_validation->set_rules('doi_doc', 'Date of Interaction', "required");

        

        if(isset($interaction_data['meet_or_not'])){



         $this->form_validation->set_rules('remark', 'Remark', "required");

        }



        $this->form_validation->set_rules('dealer_view_id', '', "required"); 



        

        if($this->form_validation->run() == TRUE){

        

        

       if(!empty($interaction_data['m_sale']) || !empty($interaction_data['m_payment']) ||  !empty($interaction_data['m_stock']) || !empty($interaction_data['m_sample']) || (isset($interaction_data['meet_or_not']) || !empty($interaction_data['meet_or_not']) )){

              

             

           

         $success=$this->dealer->update_dealer_interaction($interaction_data,$id);

      

         

         if($success=1){

            

                

            set_flash('<div class="alert alert-success alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-check"></i> Success!</h4>

               interaction are being saved for this

              </div>'); 

//           redirect($_SERVER['HTTP_REFERER']);

//          if(empty($interaction_data['gs_id']) && !isset($interaction_data['gs_id'])){

//           redirect('dealer/dealer_add/view_dealer_for_doctor/'.$id);

//            }

//            else{

                redirect('interaction/dealer_interaction'); 

//            }

           

        }

        else{

            set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               interaction are not saved please try latter..

              </div>');

            redirect('interaction/dealer_interaction'); 

//             if(empty($interaction_data['gs_id']) && !isset($interaction_data['gs_id'])){

//           redirect('dealer/dealer_add/view_dealer_for_doctor/'.$id);

//            }

//            else{

//                redirect('dealer/dealer_add/view_group_dealer_for_doctor/'.$id); 

//            }

            

        }

       }

       else{

            set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               Please Select Any One Type of Meeting...

              </div>');

            redirect($_SERVER['HTTP_REFERER']);

       }

        }

        else{

            if(empty($interaction_data['dealer_id'])){

                set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               Please Select Dealer/Sub Dealer for the sale...

              </div>'); 

            }

            else if(empty($interaction_data['doi_doc'])){

                set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               Please Select Date Of Interaction...

              </div>'); 

            }

            else{

            set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               Remark Is Mandatory for meeting!!

              </div>');

            }

            redirect($_SERVER['HTTP_REFERER']);

        } 

        

    }





    public function pharmacy_interaction(){
      $data['title'] = "Sub Dealer Interaction View";
      $data['page_name']="List of Sub Dealer Interaction";
      $this->load->get_view('interaction_list/interaction_pharma_details_view',$data);
    }

    

    // edit pharma interaction

    public function edit_pharma_interaction($id=''){
      $data['title'] = "Edit Sub Dealer Interaction";
      $data['page_name']="Edit Sub Dealer Interaction";
      $ph_id = urisafedecode($id);
      $data['users_team'] = $this->permission->user_team(); // show child and boss users
      $data['dealer_list']= $this->dealer->dealer_list(); 
      $data['meeting_sample'] = $this->doctor->meeting_sample_master();
      $data['pharma_interaction']  = $this->report->edit_pharma_interaction($ph_id);
      // pr($data['pharma_interaction']); die;
      $this->load->get_view('interaction_list/edit_pharma_interaction_view',$data);
    }

    

    // update pharma interaction

    public function update_pharma_interaction($id){
      $interaction_data = $this->input->post();
		  $interactionDate=$interaction_data['doi_doc'];
      /*
		  $result=$this->dealer->checkleave($interactionDate);
		  if(!$result)
		  {
        set_flash('<div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        You have taken leave on that day please change date!!
        </div>');
        redirect($_SERVER['HTTP_REFERER']);
		  }
      */
      // pr($interaction_data); die;
      $this->load->library('form_validation');
      $this->form_validation->set_rules('doi_doc', 'Date of Interaction', "required");
      if(isset($interaction_data['meet_or_not'])){
       $this->form_validation->set_rules('remark', 'Remark', "required");
      }

      // else{
      $this->form_validation->set_rules('dealer_view_id', '', "required"); 

//        }
//        if(isset($interaction_data['doc_id']) && !empty($interaction_data['m_sale'])){
//            
//           $this->form_validation->set_rules('dealer_id', 'Dealer or Sub Dealer', "required"); 
//        }

        if(isset($interaction_data['pharma_id']) && !empty($interaction_data['m_sale'])){
          $this->form_validation->set_rules('dealer_id', 'Dealer or Sub Dealer', "required"); 
        }
        if($this->form_validation->run() == TRUE){
        if(!empty($interaction_data['m_sale']) || !empty($interaction_data['m_payment']) ||  !empty($interaction_data['m_stock']) || !empty($interaction_data['m_sample']) || (isset($interaction_data['meet_or_not']) || !empty($interaction_data['meet_or_not']) )){
           $success=$this->dealer->update_pharma_interaction($interaction_data,$id);
           if($success=1){
            set_flash('<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            interaction are being saved for this
            </div>'); 
//           redirect($_SERVER['HTTP_REFERER']);
//          if(empty($interaction_data['gs_id']) && !isset($interaction_data['gs_id'])){
//           redirect('dealer/dealer_add/view_dealer_for_doctor/'.$id);
//            }
//            else{
              redirect('interaction/pharmacy_interaction'); 
//            }
            }

        else{

            set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               interaction are not saved please try latter..

              </div>');

            redirect('interaction/pharmacy_interaction'); 

//             if(empty($interaction_data['gs_id']) && !isset($interaction_data['gs_id'])){

//           redirect('dealer/dealer_add/view_dealer_for_doctor/'.$id);

//            }

//            else{

//                redirect('dealer/dealer_add/view_group_dealer_for_doctor/'.$id); 

//            }

            

        }

       }

        else{
          set_flash('<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-ban"></i> Alert!</h4>
          Please Select Any One Type of Meeting...
          </div>');
          redirect($_SERVER['HTTP_REFERER']);
        }

        }

        else{

            if(empty($interaction_data['dealer_id'])){
                set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
               Please Select Dealer/Sub Dealer for the sale...
              </div>'); 
            }

            else if(empty($interaction_data['doi_doc'])){

                set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               Please Select Date Of Interaction...

              </div>'); 

            }

            else{

            set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               Remark Is Mandatory for meeting!!

              </div>');

            }

            redirect($_SERVER['HTTP_REFERER']);

        }

         

        

    }

  public function customer_list()
  {
    $data['title'] = "Customer List";
    $data['page_name']="Customer List";
    // pr($data['pharma_interaction']); die;
    $this->load->get_view('dashboard/customer_list_view',$data);
  }


  public  function summary_report(){
      $data['title'] = "Secondary Report";
      $data['page_name']="Secondary Report";
      if(is_admin() || logged_user_child()){
         $data['child_user_list'] = $this->permission->user_child_team();
        }
      $data['action'] ="interaction/generate_summary";
      $this->load->get_view('report/summary_report',$data);
  }

  public  function generate_summary(){
      $data['title'] = "Secondary Summary Report";
      $data['page_name']="Secondary Summary Report";

      $data['userdata']=$this->user->users_report();
      $data['total_doctors']=$this->doctor->total_doctors();

      $request = $this->input->post();
      @$first_btn=$request['send1'];
      if($first_btn){
          if($request['working_user_id']){
              $data['w_user_id']= $request['working_user_id'];
              $data['period']=$request['period'];
              $this->load->get_view('report/summary_report_view',$data);
          }else{
                set_flash('<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                User\'s Name Field is Mandatory..</div>');
                redirect('interaction/summary_report/');
          }

      }else{
          $data['w_user_id']= '';
          $data['period']=$request['period'];
          $this->load->get_view('report/summary_report_view',$data);
      }



  }



  public function  checkmail(){
//      $dealerSms="Dear Received SMS Working";
//      $dealerNumber='8130775272';
//     $smsSend= send_msg($dealerSms,$dealerNumber);
//     if($smsSend){
//         pr($smsSend);
//     }else{
//         echo "err";
//     }


	  $dealeremailbody = '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="' . base_url() . '/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center><h3>Dear,</h3> <p>NTITIN kumar</p> Email Body data Comes Here.<p><i>This is an auto generated email.</i></p><div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">' . get_user_name(logged_user_data()) . '<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';

      $dealerEmail="php@bjaintech.com";
      $senderemail="php@bjaintech.com";
      $subject="New mail helo";
      $success =send_email($dealerEmail, $senderemail, $subject, $dealeremailbody);
      pr($success);
  }

}





?>
