<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/** 
 * Developer: Shailesh Saraswat
 * Email: sss.shailesh@gmail.com
 * Dated: 16-AUG-2018
 * 
 * For Navigon - Pharma software conectivlty data
 * 
 */




class Customer extends Parent_admin_controller {



   function __construct() 

    {

           parent::__construct();

           

        $this->load->model('category/category_model','category');
        $this->load->model('pharma_nav/customer_nav_model','cust_nav');

    }

    

    public function index(){  
        
        


		$data['title'] = "My Customer List";

                $data['page_name'] = "My Customer List";

                 $allspcode = $this->session->userdata('sp_code');
                 $spcode_array = explode(',',$allspcode);
                 $spcode = implode('|',$spcode_array);
                 // echo $spcode;
                 // die;
                if(!empty($spcode)){ 
                  // $mycustomer_API   = "https://www.bjaincorp.com/bjainpharma/nav_con/my_customer.php?spcode=".$spcode;
                  //$mycustomer_API   = "https://bjainpharmacrm.com/nav_con/my_customer.php?spcode=".$spcode;

                  /*
*Created On: 27-Dec-2019
*Created By: Nitin kumar
*SOAP API Navision Data Get
*/
$curl_handle=curl_init();
curl_setopt($curl_handle, CURLOPT_URL,'https://bjainpharmacrm.com/nav_con/my_customer.php?spcode='.$spcode);
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Navi');
$query = curl_exec($curl_handle);
curl_close($curl_handle);
          
                    $data['my_customer'] = $query;
                    // $data['my_customer'] = file_get_contents($mycustomer_API);
                }else{
                     $data['my_customer'] = '';
                }

            $this->load->get_view('pharma_nav/mycustomer_list_view',$data);
        

    }
    
    
    /*
     * Developer: Shailesh Saraswat
     * Email: sss.shailesh@gmail.com
     * Dated: 24-SEP-2018
     * 
     * For auto update the information of customer into the navigon
     */
    
    public function nav_cust_connect(){
         //$spcode = $this->session->userdata('sp_code');
        
        // if(!empty($spcode)){
         // $mycustomer_API   = "https://www.bjaincorp.com/bjainpharma/nav_con/my_customer.php?spcode=";
        // $mycustomer_API   = "https://bjainpharmacrm.com/nav_con/my_customer.php?spcode=";
        // }else{
            // $mycustomer_API   = "https://www.bjaincorp.com/bjainpharma/nav_con/my_customer.php?spcode=";
        // }
       // echo $mycustomer_API; die;
        //  $my_customers = file_get_contents($mycustomer_API);
      	 // pr($my_customers); die;
        

/*
*Created On: 27-Dec-2019
*Created By: Nitin kumar
*SOAP API Navision Data Get
*/
$curl_handle=curl_init();
curl_setopt($curl_handle, CURLOPT_URL,'https://bjainpharmacrm.com/nav_con/my_customer.php?spcode=');
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Navi');
$query = curl_exec($curl_handle);
curl_close($curl_handle);


                // $sucess =  $this->cust_nav->add_update_dealer($my_customers);
                $sucess =  $this->cust_nav->add_update_dealer($query);
       
                if($sucess==1)
                {
                    set_flash('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4> Dealer Sync Successfully. </div>'); 
                    redirect($_SERVER['HTTP_REFERER']);
                    // return TRUE;
                }
                else
                {
                    set_flash('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>Something went wrong!! </div>');
                    redirect($_SERVER['HTTP_REFERER']);
                //   return FALSE;
                }
                
    }
    
    
   




    



}



?>