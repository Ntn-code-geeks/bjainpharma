<?php

defined('BASEPATH') OR exit('No direct script access allowed');

 date_default_timezone_set('Asia/Kolkata');

  /*
        * Developer: Shailesh Saraswat
        * Email: sss.shailesh@gmail.com
        * Date: 16-JAN-2019
        * 
        * A link to change the tour plan directly
        */ 

class Direct_tour_plan extends Parent_admin_controller {



   function __construct() 

    {

        parent::__construct();


        $this->load->model('tour_plan/tour_plan_model','tour');


    }

  
        
       /*
        * Developer: Shailesh Saraswat
        * Email: sss.shailesh@gmail.com
        * Date: 16-JAN-2019
        * 
        * A link to change the tour plan directly
        */ 
       public function joint_working_tour_plan($requestid){
          
           $request_id = urisafedecode($requestid);
         
//           echo $request_id.'<br>';
//           die;
           
               $sucess = $this->tour->change_tour_plan($request_id);
                  
           if($sucess==1){
               
                                set_flash('<div class="alert alert-success alert-dismissible">

						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

						<h4><i class="icon fa fa-check"></i> Success!</h4>

					  Tour Plan Changed Successfully.

					  </div>'); 

				redirect('https://www.bjaincorp.com/bjainpharma/');
               
           }else{
               
                                set_flash('<div class="alert alert-danger alert-dismissible">

						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

						<h4><i class="icon fa fa-ban"></i> Alert!</h4>

						Tour Data Does not Changed.

					  </div>');

				redirect('https://www.bjaincorp.com/bjainpharma/');

           }
           
           
           
           
       }

        



}



?>