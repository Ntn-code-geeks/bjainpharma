<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/** 
 * Developer: Nitin Kumar
 * Dated: 28-Dec-2018
 */

class Leave extends Parent_admin_controller {


  function __construct() 
    {
        parent::__construct();
        $this->load->model('category/category_model','category');
        $this->load->model('pharma_nav/customer_nav_model','cust_nav');
    }


    /*Leave Balance Page */
    /*Index function*/


   public function leave_api_connect(){

    $curl_handle=curl_init();
    curl_setopt($curl_handle, CURLOPT_URL,'https://bjainpharmacrm.com/nav_con/my_leaves.php?spcode=');
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Navision');
    $query = curl_exec($curl_handle);
    curl_close($curl_handle);


/*For Testing JSON*/
pr(json_decode($query)); die;

         pr($query);  die;


        // $sucess =  $this->cust_nav->add_update_dealer($my_customers);

        // if($sucess==1)
        // {
        //     set_flash('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        //             <h4><i class="icon fa fa-check"></i> Success!</h4> Dealer Sync Successfully. </div>');
        //     redirect($_SERVER['HTTP_REFERER']);
        //     // return TRUE;
        // }
        // else
        // {
        //     set_flash('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        //             <h4><i class="icon fa fa-ban"></i> Alert!</h4>Something went wrong!! </div>');
        //     redirect($_SERVER['HTTP_REFERER']);
        //     //   return FALSE;
        // }

    } 




}


?>