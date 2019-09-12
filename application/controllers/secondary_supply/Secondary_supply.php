<?php



/* 

 * Developed By: Niraj Kumar

 * Dated: 04-nov-2017

 * Email: sss.shailesh@gmail.com

 * 

 * for adding actual secondary supply value.

 */





class Secondary_supply extends Parent_admin_controller {



   function __construct() 

    {

        parent::__construct();

            $loggedData=logged_user_data();

            

            if(empty($loggedData)){

                redirect('user'); 

            }



//         $this->load->model('permission/permission_model','permission'); 

//         $this->load->model('appointment/appointment_model','appoint');

//         $this->load->model('dealer/dealer_model','dealer');

//         $this->load->model('doctor/doctor_model','doctor');

//         $this->load->model('pharmacy/pharmacy_model','pharmacy');

         

         $this->load->model('secondary_supply/secondary_model','secondary');

    }

    

    public function index(){

        $data['title'] = "Secondary Supply List";
         $data['page_name'] = "Secondary Supply";
		$userID=logged_user_data();
        if(!is_admin()){
			$uid=array($userID);
			$childs=get_child_user($uid);
			$data['allchilds']=array_merge($uid,$childs);		//Including user itself with childs
		} else{
			$data['allchilds']=$userID;
		}
        $this->load->get_view('secondary_supply/secondary_supply_details_view',$data);

    }


    public function doctor_interaction($id=''){

        

        if($id!=''){

            $post_data = $this->input->post();

            

                $interaction_id = urisafedecode($id);

//            pr($interaction_id); die;

            $status = $this->secondary->save_doctor_orignal_sale($post_data,$interaction_id);

          

                if($status === TRUE){

           

            set_flash('<div class="alert alert-success alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-check"></i> Success!</h4>

               Saved Successfully.

              </div>'); 

           

            redirect($_SERVER['HTTP_REFERER']);

           

       }

       else{

           set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               Does not Saved.

              </div>');

             redirect($_SERVER['HTTP_REFERER']);

       }

        }

    }

    public function pharmacy_interaction($id=''){

        

         if($id!=''){

            $post_data = $this->input->post();

            

                $interaction_id = urisafedecode($id);

//            pr($post_data); die;

            $status = $this->secondary->save_pharmacy_orignal_sale($post_data,$interaction_id);

          

                if($status === TRUE){

           

            set_flash('<div class="alert alert-success alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-check"></i> Success!</h4>

               Saved Successfully.

              </div>'); 

           

            redirect($_SERVER['HTTP_REFERER']);

           

       }

       else{

           set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               Does not Saved.

              </div>');

             redirect($_SERVER['HTTP_REFERER']);

       }

       

        }

        

    }


    // close secondary for doctor
    public function close_secondary($id=''){

        

        if($id != ''){

             $interaction_id = urisafedecode($id);

            $status = $this->secondary->doctor_interaction_close($interaction_id);

          

                if($status === TRUE){

           

            set_flash('<div class="alert alert-success alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-check"></i> Success!</h4>

               Closed Successfully.

              </div>'); 

           

            redirect($_SERVER['HTTP_REFERER']);

           

       }

       else{

           set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               Does not Closed.

              </div>');

             redirect($_SERVER['HTTP_REFERER']);

       }

            

        }

        

        

    }

    // close secondary for pharmacy
     public function close_secondary_pharmacy($id=''){

        

        if($id != ''){

             $interaction_id = urisafedecode($id);

            $status = $this->secondary->pharmacy_interaction_close($interaction_id);
            if($status === TRUE){

           

            set_flash('<div class="alert alert-success alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-check"></i> Success!</h4>

               Closed Successfully.

              </div>'); 
            redirect($_SERVER['HTTP_REFERER']);
      }

      else{
           set_flash('<div class="alert alert-danger alert-dismissible">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <h4><i class="icon fa fa-ban"></i> Alert!</h4>

               Does not Closed.

              </div>');

             redirect($_SERVER['HTTP_REFERER']);

       }

            

        }

        

        

    }


  public function test(){
    echo '<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}
.content{ width:40%; margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{
  margin:0px;padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
    <h3>Dear,</h3> <p>It was a pleasure meeting with you on (date).<br> Thank you for your valuable order. I will processed it as soon as possible.</p> <h2>Your Order Details</h2> <table cellspacing="0" cellpadding="5" border="1" style="width:100%; border-color:#222;" ><thead><tr><th>Product</th><th>MRP</th><th>Qty.</th><th>Discount</th><th>Amount</th> </tr></thead> 
        <tbody>
        <tr>
          <td>Mobile</td>
          <td>23,566</td>
          <td>1</td>
          <td>15%</td>
          <td>20,322</td>
        </tr>
        
        <tr>
          <td>Mobile</td>
          <td>23,566</td>
          <td>1</td>
          <td>15%</td>
          <td>20,322</td>
        </tr>
        
        <tr>
          <td>Mobile</td>
          <td>23,566</td>
          <td>1</td>
          <td>15%</td>
          <td>20,322</td>
        </tr>

      </tbody><tfoot><tr><th colspan="4" style="text-align:right; border-right:none !important;">Total</th> <th colspan="4" style="text-align:right; border-left:none;">20,522</th><tr></tfoot></table>   
    
    <p><i>This is an auto generated email.</i></p>
    
    <div class="regards_box">
      <h3 class="user_name_regards">Regards,</h3>
      <p class="user_name_brand">Niraj Sharma <br>BJain Pharmaceuticals Pvt. Ltd.</p>
    </div>
    
  </div>

</body>
</html>
';
  }
}
