<?php

/* 
 * Developer:NITIN KUMAR
 * Dated: 16-Aug-2018
 * 
 * For fetch my customer list of a user
 */
//function brandlog($order){ 

 include("php_nav_lib/Navision.php");
 include("php_nav_lib/ntlm.php");

 
if(isset($_GET['skucode'])){
    
  $spcode = $_GET['skucode'];
//echo $spcode; die;
 stream_wrapper_unregister('http');
 // we register the new HTTP wrapper
 stream_wrapper_register('http', 'NTLMStream') or die("Failed to register protocol");
// $page = new NTLMSoapClient('http://192.168.1.81:7047/DynamicsNAV/WS/Codeunit/WebshopRequestManagement');
// $page = new NTLMSoapClient('http://110.172.147.196:9048/bjainlive/WS/B.%20Jain%20Pharma-2017/Page/MyCustomer');
 
 $baseURL = 'http://139.5.19.140:9048/bjainlive/WS/';
 $CompanyName = 'B. Jain Pharma-2017';
 $pageURL = $baseURL.rawurlencode($CompanyName).'/Page/_x0031_mgitemservice';
 //echo "<br>URL of Customer page: $pageURL<br><br>"; 
 // echo "<pre>";
 // print_r($pageURL); die;

try{
  
 $service = new NTLMSoapClient($pageURL);
//print_r($service); die;
 $params = array('filter' =>array( 
  array('Field'=>'_x0031_mgitemservice','Criteria'=>$spcode) ) ,'setSize'=>0);
 $result = $service->ReadMultiple($params);
   
 //$resultSet = $result->ReadMultiple_Result->MyCustomer;
 $customer= $result->ReadMultiple_Result->_x0031_mgitemservice;
 //echo "<pre>";
 //print_r(($customer)); die;
//echo $customer;
$invoice_data =array();
 if(is_array($customer)){
    // echo "<pre>";
     //print_r($result); die;
     foreach($customer as $k=>$rec){
         //echo $rec->Pharma_Target."<br>"; die;
         
        // if(strpos($rec->No, 'SALESPERSON') === false){
         
         $invoice_data[$k]['Key'] = $rec->Key;
         $invoice_data[$k]['No'] = $rec->No;
         $invoice_data[$k]['Description'] = $rec->Description;
         $invoice_data[$k]['Base_Unit_of_Measure'] = $rec->Base_Unit_of_Measure;
         $invoice_data[$k]['Inventory'] = $rec->Inventory;
         
         $invoice_data[$k]['Item_Category_Code'] = $rec->Item_Category_Code;
         
        
         
         $invoice_data[$k]['Product_Group_Code']  = $rec->Product_Group_Code;
         
         if(!empty($rec->Potency)){
            $invoice_data[$k]['Potency']  = $rec->Potency;
         }else{
            $invoice_data[$k]['Potency']  = "";
         }

         $invoice_data[$k]['Pack_Size']  = $rec->Pack_Size;
         $invoice_data[$k]['_x0031_mg_Sku_Code']  = $rec->_x0031_mg_Sku_Code;
         
         
             
        // }
         
         
     }
     //echo "<pre>";
    // print_r($customer_data); die;
     print_r(json_encode($invoice_data));
 }else{
      echo $invoice_data;
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
