<?php

/* 
 * Developer:shailesh saraswat
 * Email:sss.shailesh@gmail.com
 * Dated: 16-Aug-2018
 * 
 * For fetch my customer list of a user
 */
//function brandlog($order){ 

 include("php_nav_lib/Navision.php");
 include("php_nav_lib/ntlm.php");

if(isset($_GET['spcode'])){
    
  $spcode = $_GET['spcode'];

 stream_wrapper_unregister('http');
 // we register the new HTTP wrapper
 stream_wrapper_register('http', 'NTLMStream') or die("Failed to register protocol");
// $page = new NTLMSoapClient('http://192.168.1.81:7047/DynamicsNAV/WS/Codeunit/WebshopRequestManagement');
// $page = new NTLMSoapClient('http://110.172.147.196:9048/bjainlive/WS/B.%20Jain%20Pharma-2017/Page/MyCustomer');
 
 $baseURL = 'http://139.5.19.140:9048/bjainlive/WS/';
$CompanyName = 'B. Jain Pharma-2017';
$pageURL = $baseURL.rawurlencode($CompanyName).'/Page/MyCustomer';
// echo "<br>URL of Customer page: $pageURL<br><br>"; 


try{
  //echo $pageURL; die;
 $service = new NTLMSoapClient($pageURL);
// print_r($service); die;
 $params = array('filter' =>array( 
  array('Field'=>'Salesperson_Code','Criteria'=>$spcode) ) ,'setSize'=>0);
 $result = $service->ReadMultiple($params);
   
 //$resultSet = $result->ReadMultiple_Result->MyCustomer;
 $customer= $result->ReadMultiple_Result->MyCustomer;
// echo "<pre>";
// print_r(($customer)); die;
//echo $customer;
$customer_data =array();
 if(is_array($customer)){
    // echo "<pre>";
     //print_r($result); die;
     foreach($customer as $k=>$rec){
         //echo $rec->Pharma_Target."<br>"; die;
         
         if(strpos($rec->No, 'SALESPERSON') === false){
         
         $customer_data[$k]['name'] = $rec->Name;
         $customer_data[$k]['balance'] = $rec->Balance_LCY;
         $customer_data[$k]['target_in'] = $rec->Pharma_Target;
         $customer_data[$k]['personal_ach'] = $rec->Personal_Care_Target;
         $customer_data[$k]['net_overdue'] = $rec->OverDueBalance;
         
         $customer_data[$k]['dealer_code'] = $rec->No;
         
         // if(isset($rec->Address_2) && !isset($rec->Address_3)){
         // $customer_data[$k]['Address'] = $rec->Address.''.$rec->Address_2;
         // }elseif(isset($rec->Address_3)){
         //      $customer_data[$k]['Address'] = $rec->Address.''.$rec->Address_2.''.$rec->Address_3;
         // }else{
         //     $customer_data[$k]['Address'] = $rec->Address;
         // }

/*Nesting if else By: Nitin */

if(!empty($rec->Address) && empty($rec->Address_2) && empty($rec->Address_3) ){
    $customer_data[$k]['Address'] = $rec->Address;
}
else if(empty($rec->Address) && !empty($rec->Address_2) && empty($rec->Address_3) ){
    $customer_data[$k]['Address'] = $rec->Address_2;
}
else if(empty($rec->Address) && empty($rec->Address_2) && !empty($rec->Address_3) ){
    $customer_data[$k]['Address'] = $rec->Address_3;
}
else if(!empty($rec->Address) && !empty($rec->Address_2) && empty($rec->Address_3) ){
    $customer_data[$k]['Address'] = $rec->Address.''.$rec->Address_2;
}
else if(empty($rec->Address) && !empty($rec->Address_2) && !empty($rec->Address_3) ){
    $customer_data[$k]['Address'] = $rec->Address_2.''.$rec->Address_3;
}
else if(!empty($rec->Address) && empty($rec->Address_2) && !empty($rec->Address_3) ){
    $customer_data[$k]['Address'] = $rec->Address.''.$rec->Address_3;
}
else if(!empty($rec->Address) && !empty($rec->Address_2) && !empty($rec->Address_3) ){
    /*all three*/
    $customer_data[$k]['Address'] = $rec->Address.''.$rec->Address_2.''.$rec->Address_3;
}else{
    $customer_data[$k]['Address'] = "";
}


         if(!empty($rec->Post_Code)){
         $customer_data[$k]['city_pincode']  = $rec->Post_Code;
         }
         if(!empty($rec->City)){
         $customer_data[$k]['city_name']  = $rec->City;
         }

         $customer_data[$k]['state_short']  = $rec->State_Code;
         if(!empty($rec->Phone_No)){
            $customer_data[$k]['Phone_No']  = $rec->Phone_No;
         }
         if(!empty($rec->E_Mail)){
            $customer_data[$k]['email']  = $rec->E_Mail;
         }
                  
         $customer_data[$k]['sp_code']  = $rec->Salesperson_Code;
         
         
         
             
         }
         
         
     }
    //  echo "<pre>";
    // print_r($customer_data); die;
     print_r(json_encode($customer_data));
 }else{
      echo $customer_data;
 }
 
}
catch (Exception $e) {
    
 echo "<hr><b>ERROR: SoapException:</b> [".$e."]<hr>";
 echo "<pre>".htmlentities(print_r($service->__getLastRequest(),1))."</pre>";
 
}
 stream_wrapper_restore('http');
}else{
    return FALSE;
}

 ?>
