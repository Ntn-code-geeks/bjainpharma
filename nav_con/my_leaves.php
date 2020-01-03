<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("php_nav_lib/Navision.php");
include("php_nav_lib/ntlm.php");


if(isset($_GET['spcode'])){

	$spcode = $_GET['spcode'];

	stream_wrapper_unregister('http');
	stream_wrapper_register('http', 'NTLMStream') or die("Failed to register protocol");

	$baseURL = 'http://139.5.19.140:9048/bjainlive/WS/';
	$CompanyName = 'B. Jain Pharma-2017';
	$pageURL = $baseURL.rawurlencode($CompanyName).'/Page/LeaveDetails';

// print_r($pageURL); die;
	try{
		$service = new NTLMSoapClient($pageURL);
		$params = array('filter' =>array(
		array('Field'=>'Salesperson_Code','Criteria'=>$spcode) ) ,'setSize'=>0);
		$result = $service->ReadMultiple($params);

		$customer= $result->ReadMultiple_Result->LeaveDetails;
		
 // echo "<pre>";
 // print_r($customer); die;
//echo $customer;
		$leave_data =array();
		if(is_array($customer)){
			foreach($customer as $k=>$rec){
					
				//if(strpos($rec->No, 'SALESPERSON') === false){

					$leave_data[$k]['name'] = $rec->Employee_Name;
					$leave_data[$k]['Casual_Leave_Earned'] = $rec->Casual_Leave_Earned;
					$leave_data[$k]['Casual_Leave_Used'] = $rec->Casual_Leave_Used;
					$leave_data[$k]['Balance_Casual_Leave'] = $rec->Balance_Casual_Leave;
					$leave_data[$k]['Employee_No'] = $rec->Employee_No;

				//}

			}
			//echo "<pre>";
			// print_r($customer_data); die;
			print_r(json_encode($leave_data));
		}else{
			echo $$leave_data;
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
