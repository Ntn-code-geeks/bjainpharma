<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/*
 * Developer: Niraj Sharma
 * Email: niraj@bjain.com
 * 
 * Dated: 28-08-2018
 * 
 */



class Reports extends REST_Controller {
    function __construct() {
    // Construct the parent class
        parent::__construct();
        $this->load->model('api/report_api_model','rpt');
        $this->load->model('report/report_model','report');
       $this->load->model('user_model','user');
      $this->load->model('dealer/Dealer_model','dealer');
      $this->load->model('permission/Permission_model','permission');
    
    }
    
    
      
    
    /*
     * Developer: Shailesh Saraswat
     * Email: sss.shailesh@gmail.com
     * Dated: 25-04-2019
     * 
     * Genrated  TA/DA List
     * 
     */
    public function generate_tada_get()
    {
        # initialize variables
	$msg = '';
	$get  = $this->get();
        $report_date_get = $get['report_date'];
        $userid  = $get['userid'];
        // print_r($get); die;
        if(isset($report_date_get) && empty($report_date_get))
        {
        	$msg='Month-Year is required.';
        	
        }elseif(isset($userid) && empty($userid)){
            $msg='User Id is required.';
        }
        
        
       	if ($msg == '') 
        {
	     
             if($this->report->first_time_genrate($report_date_get, $userid)){
                  $report_date = explode('-',$report_date_get );
                //  pr($request['report_date']);
                  $follow_month =  trim($report_date[0]); $follow_year =  trim($report_date[1]);
                  $newstartdate =    $follow_month.'/01/'.$follow_year;         
        //          str_replace('/', '-', $followstart_month);

                  $newenddate =  $follow_month.'/20/'.$follow_year;  

        //                  str_replace('/', '-', $followend_date);
                  $start = date('Y-m-d', strtotime($newstartdate))." 00:00:00";
                  $end = date('Y-m-t', strtotime($newenddate))." 23:59:59";
                 
                  $tada_report =$this->report->get_tada_report($userid,$start,$end);
                //   pr($tada_report); die;
                  $report=array(); $count=0;
                  $designation_id = get_user_deatils($userid)->user_designation_id;

                            $totalrow=0;
                             $totalstprow=0;
                             $gtrow=0;
                             $gtkms=0;
                             $gtta=0;
                             $gtda=0; $hq=0;
                             $gtpostage=0; $crtddate ='';  $ft=0 ;
                             $lastdaydestination=0; $source_city=''; $destination_city=''; $interaction_date=''; $date_same='';
                             $city_same=0; 
         //                  pr($tada_report); die;
                         foreach($tada_report as $k=>$val){ 

                           if($source_city!=$val['source_city'] || $destination_city!=$val['destination_city'] || $interaction_date!=strtotime($val['doi'])){  

                                 $source_city = $val['source_city'];
                                    $destination_city   = $val['destination_city'];  
                                    $interaction_date = strtotime($val['doi']);
         //                    
                           if($val['destination_city']!=$val['source_city'] || $val['is_stay'] || $ft==0 || $crdate!=$val['doi']){
                                     $crdate = $val['doi']; 
                                      $da=0;
                              $hqdistance=0;
                              $nxtdestination=0;

                              $ft=1;


                            $is_metro=is_city_metro($val['destination_city']);
                            $tpinfo=get_tp_interaction(logged_user_data(),$val['source_city'],$val['destination_city'],$val['doi']);

                             $lenght= count($tada_report)-1;
                   $day= date('D',strtotime($val['doi']));
                   if($k!=0 && $tada_report[$k-1]['doi']==$val['doi'])
                   {
                     $da=0;
                   }
                   else
                   {
                     if($val['is_stay']==1 && $val['destination_city']==$lastdaydestination && $hqdistance>75)
                     {
                          $da=get_user_da(5,$designation_id,$is_metro);        
                     }
                     elseif($val['is_stay']==1 && $val['destination_city']!=$hq && $hqdistance>200)
                     {
                         $da=get_user_da(3,$designation_id,$is_metro); 
                     }
                     elseif($hqdistance>450 && $tpinfo)
                     {
                         $da=get_user_da(2,$designation_id,$is_metro); 
                     }
                     elseif($val['is_stay']==1 && $day=='Sat')
                     {
                       if($key==$lenght)
                       {
                         if($val['destination_city']!=$hq)
                         {
                           $da=get_user_da(5,$designation_id,$is_metro)+get_user_da(2,$designation_id,$is_metro); 
                         }
                         else
                         {
                           $da=get_user_da(1,$designation_id,$is_metro); 
                         }
                       }
                       else
                       {
                         if(date('D',strtotime($data['tada_report'][$key+1]['doi']))=='Mon' && $data['tada_report'][$key+1]['destination_city']==$val['destination_city'])
                         {
                           $da=get_user_da(5,$designation_id,$is_metro)+get_user_da(2,$designation_id,$is_metro);
                         }
                         else
                         {
                           $da=get_user_da(5,$designation_id,$is_metro); 
                         }
                       }
                     }
                     else
                     {
                       $da=get_user_da(1,$designation_id,$is_metro); 
                     }
                   }
                   if(date('Y-m-d',strtotime($crtddate))==date('Y-m-d',strtotime($val['created_date'])))
                   {
                     $val['internet_charge']=0;
                   }


                       $crtddate=$val['created_date'];

                        if($val['is_stp_approved']==1){ 

                            $totalrow=$val['stp_ta']+$da+$val['internet_charge']; 
                              $gtrow=$gtrow+$totalrow;
                                $gtta=$gtta+$val['stp_ta'];
                             $gtda=$gtda+$da;
                               $gtpostage=$gtpostage+$val['internet_charge'];

                        }else{
                              $totalrow=$val['ta']+$da+$val['internet_charge'];    

                                 $gtrow=$gtrow+$totalrow;
                             $gtta=$gtta+$val['ta'];
                             $gtda=$gtda+$da;
                             $gtpostage=$gtpostage+$val['internet_charge'];
                        }
              
                       $report[0][$count]['doi'] = date('d-m-Y',strtotime($val['doi']));
                       $report[0][$count]['source_city'] = get_city_name($val['source_city']);
                       
                       $report[0][$count]['destination_city'] = get_city_name($val['destination_city']);
                       $report[0][$count]['create_date'] = $crtddate;
                        if($val['up_down']){
                           $report[0][$count]['back_ho'] = 'Back HO YES';
                        }else{
                            $report[0][$count]['back_ho'] = 'Back HO NO';
                        }
                        
                        
                        if($val['is_stp_approved']==1){
                              $report[0][$count]['distance'] = $val['stp_distance'];
                              $report[0][$count]['ta'] = $val['stp_ta'];
                        }else{
                              $report[0][$count]['distance'] = $val['distance'];
                              $report[0][$count]['ta'] = $val['ta'];
                        }
                        
                        $report[0][$count]['da'] = $da;
                        
                        $report[0][$count]['postage'] = $val['internet_charge'];
                        
                        $report[0][$count]['total'] = number_format($totalrow, 2, '.', '');
                        
               $count++;
               
                 } 
                       
                
                        }
                
                        }
                        
                   $report[1][0]['report_date'] = $report_date_get;
                   $report[1][0]['grant_total'] = number_format($gtrow, 2, '.', '');
                  
                //   pr($report); die;
                if($report!='') 
		{ 
		    
	            $result = array(
	                'Data' =>  $report,
			// 'Status' => true,
	                'Message' => 'Successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'No Data',
	                'Code' => 404
	            );
	        }
                  
                 
             }else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'you already Genrated this month TA/DA',
	                'Code' => 404
	            );
	        }
            
            
            
//		if ($data['secondary']!='') 
//		{ 
//		    
//	            $result = array(
//	                'Data' => $data['secondary'],
//			// 'Status' => true,
//	                'Message' => 'Successfully',
//	                'Code' => 200
//	            );
//	        }
//	        else 
//	        {
//	            $result = array(
//	                'Data' => new stdClass(),
//	                'Status' => false,
//	                'Message' => 'No Data',
//	                'Code' => 404
//	            );
//	        }
        }
        else 
        {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 404
            );
        }
        $this->response($result);
    }
            
             
    
    
     
    function doctor_interaction_list_get()
    {
        # initialize variables
		$msg = '';
		$userid  = $this->get('userid');
        if(!(isset($userid)&& !empty($userid)))
        {
        	$msg='User Id is required.';
        }
       	if ($msg == '') 
        {
	        $end = date('Y-m-d', strtotime(savedate()))." 23:59:59";
	        $start = date('Y-m-d', strtotime('-1 month'))." 00:00:00";
	        if($userid!=28 && $userid!=29 &&  $userid!=32)
	        { 
		      $data['doctor_interaction'] = $this->rpt->travel_report_doctor($userid,$start,$end);
		}
  		else
		{
	             $data['doctor_interaction'] = $this->rpt->travel_report_doctor(0,$start,$end); 	   
		}

		if ($data['doctor_interaction']!='') 
		{ 
		    unset($data['doctor_interaction']['team_info']);	
	            $result = array(
	                'Data' => $data['doctor_interaction']['doc_info'],
			// 'Status' => true,
	                'Message' => 'Successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'No Data',
	                'Code' => 404
	            );
	        }
        }
        else 
        {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 404
            );
        }
        $this->response($result);
    }
    
         
    function subdealer_interaction_list_get()
    {
        # initialize variables
	$msg = '';
	$userid  = $this->get('userid');
        if(!(isset($userid)&& !empty($userid)))
        {
        	$msg='User Id is required.';
        }
       	if ($msg == '') 
        {
	        $end = date('Y-m-d', strtotime(savedate()))." 23:59:59";
	        $start = date('Y-m-d', strtotime('-1 month'))." 00:00:00";
	        if($userid!=28 && $userid!=29 &&  $userid!=32)
	        { 
		       $data['pharma_interaction'] =$this->rpt->travel_report_pharmacy($userid,$start,$end);
		}
  		else
		{
	              $data['pharma_interaction'] =$this->rpt->travel_report_pharmacy(0,$start,$end); 	   
		}

		if ($data['pharma_interaction']!='') 
		{ 
		    unset($data['pharma_interaction']['team_info']);	
	            $result = array(
	                'Data' => $data['pharma_interaction']['pharmacy_info'],
			//'Status' => true,
	                'Message' => 'Successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => array(),
	                'Status' => false,
	                'Message' => 'No Data',
	                'Code' => 404
	            );
	        }
        }
        else 
        {
            $result = array(
                'Data' => array(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 404
            );
        }
        $this->response($result);
    }
    
    function dealer_interaction_list_get()
    {
        # initialize variables
	$msg = '';
	$userid  = $this->get('userid');
        if(!(isset($userid)&& !empty($userid)))
        {
        	$msg='User Id is required.';
        }
       	if ($msg == '') 
        {
	        $end = date('Y-m-d', strtotime(savedate()))." 23:59:59";
	        $start = date('Y-m-d', strtotime('-1 month'))." 00:00:00";
	        if($userid!=28 && $userid!=29 &&  $userid!=32)
	        { 
		       $data['dealer_interaction'] =$this->rpt->travel_report_dealer($userid,$start,$end);
		}
  		else
		{
	              $data['dealer_interaction'] =$this->rpt->travel_report_dealer(0,$start,$end); 	   
		}
		if ($data['dealer_interaction']!='') 
		{ 
		    unset($data['dealer_interaction']['team_info']);	
	            $result = array(
	                'Data' => $data['dealer_interaction']['dealer_info'],
			// 'Status' => true,
	                'Message' => 'Successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => array(),
	                'Status' => false,
	                'Message' => 'No Data',
	                'Code' => 404
	            );
	        }
        }
        else 
        {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 404
            );
        }
        $this->response($result);
    }
    
    function secondary_supply_get()
    {
        # initialize variables
	$msg = '';
	$userid  = $this->get('userid');
        if(!(isset($userid)&& !empty($userid)))
        {
        	$msg='User Id is required.';
        }
       	if ($msg == '') 
        {
	     	$data['secondary']['doc_data']=$this->rpt->doctor_interaction_view($userid);  
	     	$data['secondary']['pharma_data']=$this->rpt->pharmacy_interaction_view($userid);
		if ($data['secondary']!='') 
		{ 
		    
	            $result = array(
	                'Data' => $data['secondary'],
			// 'Status' => true,
	                'Message' => 'Successfully',
	                'Code' => 200
	            );
	        }
	        else 
	        {
	            $result = array(
	                'Data' => new stdClass(),
	                'Status' => false,
	                'Message' => 'No Data',
	                'Code' => 404
	            );
	        }
        }
        else 
        {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 404
            );
        }
        $this->response($result);
    }
    
   function tp_list_post() 
   {
	    $post= array_map('trim', $this->input->post());
            $msg ='';
            $item=array();
            if (!isset($post['userid'])) 
            {
	        $msg='User Id is required.';
	    }
            elseif(!isset ($post['startdate']))
            {
                  $msg = 'Please Enter Start Date';
            }
            elseif(!isset ($post['enddate']))
            {
                  $msg = 'Please Enter End Date';
            }

       	    if ($msg == '')
       	    {
       	    	$data=$this->rpt->get_tp_report($post['userid'],$post['startdate'],$post['enddate']);
		if ($data) 
		{ 
		    
	            $result = array(
	                'Data' => $data,
			// 'Status' => true,
	                'Message' => 'Successfully',
	                'Code' => 200
	            );
	        }
	        else
	        {
	        	$result = array(
		        'Data' => array(),
		        'Status' => false,
		        'Message' => 'No data',
		        'Code' => 404
		       );
	        }
       	    
       	    } 
	    else 
	    {
	       $result = array(
	        'Data' => new stdClass(),
	        'Status' => false,
	        'Message' => $msg,
	        'Code' => 404
	       );
	    }
	    $this->response($result);	
     }
     
     
        // sale report
  public function sale_report_post()
  {
	    $post= array_map('trim', $this->input->post());
            $msg ='';
            $item=array();
            if (!isset($post['userid'])) 
            {
	        $msg='User Id is required.';
	    }
            elseif(!isset ($post['startdate']))
            {
                  $msg = 'Please Enter Start Date';
            }
            elseif(!isset ($post['enddate']))
            {
                  $msg = 'Please Enter End Date';
            }

       	    if ($msg == '')
       	    {
       	            $userid=$post['userid'];
       	            $start=date('Y-m-d', strtotime($post['startdate']))." 00:00:00";
		    $end=date('Y-m-d', strtotime($post['enddate']))." 23:59:59";
       	            $this->load->library('excel');
       	    	    $primarySale=0;
		    $secondarySale=0;
		    $duplicateSale=0;
		    $payment=0;
		    $totVisit=0;
		    $docMeet=0;
		    $k_num_int=0;
		    $pharmaMeet=0;
		    $docNo=0;
		    $pharmaNo=0;
		
		    if($this->permission->pharmacy_list_user($userid)!=FALSE)
		    {
		      $pharmaNo = count($this->permission->pharmacy_list_user($userid));
		    }
		    if($this->permission->doctor_list_user($userid)!=FALSE)
		    {
		      $docNo = count($this->permission->doctor_list_user($userid));
		    }
		
		    $this->excel->setActiveSheetIndex(0);
		    //name the worksheet
		    $this->excel->getActiveSheet()->setTitle('Sale Report');
		    //set cell A1 content with some text
		    $this->excel->getActiveSheet()->setCellValue('A1', 'Customer');
		    $this->excel->getActiveSheet()->setCellValue('B1', 'City');
		    $this->excel->getActiveSheet()->setCellValue('C1', 'Type');
		    $this->excel->getActiveSheet()->setCellValue('D1', 'User');
		    $this->excel->getActiveSheet()->setCellValue('E1', 'Total Visits');
		    $this->excel->getActiveSheet()->setCellValue('F1', 'Primary Sale');
		    $this->excel->getActiveSheet()->setCellValue('G1', 'Payment');
		    $this->excel->getActiveSheet()->setCellValue('H1', 'Stock Date');
		    $this->excel->getActiveSheet()->setCellValue('I1', 'Stock');
		    $this->excel->getActiveSheet()->setCellValue('J1', 'Sample');
		    /* $this->excel->getActiveSheet()->setCellValue('K1', 'Met');
		    $this->excel->getActiveSheet()->setCellValue('L1', 'Not Met');*/
		    $this->excel->getActiveSheet()->setCellValue('K1', 'Secondary Sale');
		    $this->excel->getActiveSheet()->setCellValue('L1', 'Duplicate Secondary');
		    $this->excel->getActiveSheet()->setCellValue('M1', 'Duplicate Product');
		    $this->excel->getActiveSheet()->setCellValue('N1', 'Duplicate Secondary Customer');
		    $this->excel->getActiveSheet()->setCellValue('O1', 'Payment Terms');
		    //$this->excel->getActiveSheet()->setCellValue('P1', 'Duplicate Secondary Person Type');
		    $data['sale'] =$this->report->sale_report_doctor($userid,$start,$end); // for doctor
		    //pr($data['sale']);
		    //die;
		    $k_num=2;
		    if(!empty($data['sale']['doc_info'])){
		      foreach ( $data['sale']['doc_info'] as $k=>$row){   // for doctor information with sample
		        $this->excel->getActiveSheet()->setCellValue('A'.$k_num, $row['customer']);
		        $docMeet++;
		        $this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['city']);
		        $this->excel->getActiveSheet()->setCellValue('C'.$k_num, 'Doctor');
		        $this->excel->getActiveSheet()->setCellValue('D'.$k_num, $row['user']);
		        //$this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['total_visits']);
		        $this->excel->getActiveSheet()->setCellValue('J'.$k_num, $row['sample']);
		        $k_num++;
		      }    
		      $k_num_int = 2;
		      foreach ( $data['sale']['doc_interaction'] as $k_doc=>$row_doc){  // for doctor total visit,secondry sale,met,not met
		        $this->excel->getActiveSheet()->setCellValue('E'.$k_num_int, $row_doc['total_visits']);
		        $totVisit=$totVisit+$row_doc['total_visits'];
		        $met=$row_doc['met']==0?'No':'Yes';
		        $notmet=$row_doc['notmet']==0?'No':'Yes';
		       // $this->excel->getActiveSheet()->setCellValue('K'.$k_num_int,  $met);
		       // $this->excel->getActiveSheet()->setCellValue('L'.$k_num_int, $notmet);
		        /*$this->excel->getActiveSheet()->setCellValue('K'.$k_num_int, $row_doc['met']);
		        $this->excel->getActiveSheet()->setCellValue('L'.$k_num_int, $row_doc['notmet']);*/
		        $this->excel->getActiveSheet()->setCellValue('K'.$k_num_int, $row_doc['secondary_sale']);
		        $paymentterm=get_payment_term($row_doc['id'],$row_doc['doc_id']);
		        $this->excel->getActiveSheet()->setCellValue('O'.$k_num_int, $paymentterm);
		        $secondarySale=$secondarySale+$row_doc['secondary_sale'];
		        $k_num_int++;
		      }
		    }
		    $data['sale_dealer'] =$this->report->sale_report_dealer($userid,$start,$end);   // for dealer
		    $k_num= count($data['sale']['doc_info'])+2;
		    if(!empty($data['sale_dealer']['dealer_info'])){   
		      foreach ( $data['sale_dealer']['dealer_info'] as $k=>$row){   // for dealer information with sample
		        $this->excel->getActiveSheet()->setCellValue('A'.$k_num, $row['customer']);
		        $this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['city']);
		        if(empty($row['is_cf'])){
		          $this->excel->getActiveSheet()->setCellValue('C'.$k_num, 'Dealer');
		        }
		        else{
		          $this->excel->getActiveSheet()->setCellValue('C'.$k_num, 'C & F'); 
		        }
		        $this->excel->getActiveSheet()->setCellValue('D'.$k_num, $row['user']);
		        $this->excel->getActiveSheet()->setCellValue('J'.$k_num, $row['sample']);
		        //$this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['total_visits']);
		        $this->excel->getActiveSheet()->setCellValue('F'.$k_num, $row['sale']);
		        $paymentterm=get_payment_term($row['id'],$row['d_id']);
		        $this->excel->getActiveSheet()->setCellValue('O'.$k_num_int, $paymentterm);
		        $primarySale=$primarySale+$row['sale'];
		        $this->excel->getActiveSheet()->setCellValue('G'.$k_num, $row['Payment']);
		        $payment=$payment+$row['Payment'];
		        $k_num++;
		      }    
		      $k_num_int = count($data['sale']['doc_info'])+2;
		      foreach ( $data['sale_dealer']['dealer_interaction'] as $k_doc=>$row_doc){  // for dealer total visit,secondry sale,met,not met
		        if(!empty($row_doc['stock_date'])){  
		          $this->excel->getActiveSheet()->setCellValue('H'.$k_num_int,date('d.m.Y',strtotime($row_doc['stock_date'])) );
		        }
		        $this->excel->getActiveSheet()->setCellValue('I'.$k_num_int, $row_doc['stock']);
		        $this->excel->getActiveSheet()->setCellValue('E'.$k_num_int, $row_doc['total_visits']);
		        $totVisit=$totVisit+$row_doc['total_visits'];
		        $met=$row_doc['met']==0?'No':'Yes';
		        $notmet=$row_doc['notmet']==0?'No':'Yes';
		        //$this->excel->getActiveSheet()->setCellValue('K'.$k_num_int,  $met);
		        //$this->excel->getActiveSheet()->setCellValue('L'.$k_num_int, $notmet);
		        //$this->excel->getActiveSheet()->setCellValue('N'.$k_num_int, $row_doc['duplicate_secondary']);
		        $k_num_int++;
		      }
		    }
		    $data['sale_pharmacy'] =$this->report->sale_report_pharmacy($userid,$start,$end);   // for pharmacy
		    $k_num= count($data['sale_dealer']['dealer_info'])+ count($data['sale']['doc_info'])+2;
		    if(!empty($data['sale_pharmacy']['pharmacy_info'])){
		      foreach ( $data['sale_pharmacy']['pharmacy_info'] as $k=>$row){   // for pharmacy information with sample
		        $this->excel->getActiveSheet()->setCellValue('A'.$k_num, $row['customer']);
		        $pharmaMeet++;
		        $this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['city']);
		        $this->excel->getActiveSheet()->setCellValue('C'.$k_num, 'Sub Dealer');
		        $this->excel->getActiveSheet()->setCellValue('D'.$k_num, $row['user']);
		        $this->excel->getActiveSheet()->setCellValue('J'.$k_num, $row['sample']);
		        $k_num++;
		      }    
		      $k_num_int = count($data['sale_dealer']['dealer_info'])+ count($data['sale']['doc_info'])+2;
		      foreach ( $data['sale_pharmacy']['pharmacy_interaction'] as $k_doc=>$row_doc){  // for pharmacy total visit,secondry sale,met,not met
		        $productDuplicate='';
		        $docDuplicate='';
		        $this->excel->getActiveSheet()->setCellValue('E'.$k_num_int, $row_doc['total_visits']);
		        $totVisit=$totVisit+$row_doc['total_visits'];
		        $met=$row_doc['met']==0?'No':'Yes';
		        $notmet=$row_doc['notmet']==0?'No':'Yes';
		        //echo $row_doc['duplicate_product'];
		        $product=explode(',',$row_doc['duplicate_product']);
		        $proDeatils=array_unique(array_filter($product));
		        foreach($proDeatils as $proid)
		        {
		          $prodetl=get_product_name($proid).'('.get_packsize_name($proid).')';
		          if($productDuplicate=='')
		          {
		            $productDuplicate=$prodetl;
		          }
		          else
		          {
		            $productDuplicate=$productDuplicate.','.$prodetl;
		          }             
		        }
		        $docDetails=explode(',',$row_doc['dup_doctor_id']);
		        $dupdocDetails=array_unique(array_filter($docDetails));
		        foreach($dupdocDetails as $doc)
		        {
		          $docdetl=get_doctor_name($doc);
		          if($docDuplicate=='')
		          {
		            $docDuplicate=$docdetl;
		          }
		          else
		          {
		            $docDuplicate=$docDuplicate.','.$docdetl;
		          }
		        }
		       //$this->excel->getActiveSheet()->setCellValue('K'.$k_num_int,  $met);
		       //$this->excel->getActiveSheet()->setCellValue('L'.$k_num_int, $notmet);
		        /* $this->excel->getActiveSheet()->setCellValue('K'.$k_num_int, $row_doc['met']);
		        $this->excel->getActiveSheet()->setCellValue('L'.$k_num_int, $row_doc['notmet']);*/
		        $this->excel->getActiveSheet()->setCellValue('K'.$k_num_int, $row_doc['secondary_sale']);
		        $paymentterm=get_payment_term($row_doc['id'],$row_doc['pharma_id']);
		        $this->excel->getActiveSheet()->setCellValue('O'.$k_num_int, $paymentterm);
		        $secondarySale=$secondarySale+$row_doc['secondary_sale'];
		        $this->excel->getActiveSheet()->setCellValue('L'.$k_num_int, $row_doc['duplicate_secondary']);
		        $this->excel->getActiveSheet()->setCellValue('M'.$k_num_int, $productDuplicate);
		        $this->excel->getActiveSheet()->setCellValue('N'.$k_num_int, $docDuplicate);
		        $duplicateSale=$duplicateSale+$row_doc['duplicate_secondary']; 
		        $k_num_int++;
		      }
		    }
		    $this->excel->getActiveSheet()->setCellValue('F'.$k_num_int, $primarySale);
		    $this->excel->getActiveSheet()->setCellValue('K'.$k_num_int, $secondarySale);
		    $this->excel->getActiveSheet()->setCellValue('L'.$k_num_int, $duplicateSale);
		    $this->excel->getActiveSheet()->setCellValue('G'.$k_num_int, $payment);
		    $this->excel->getActiveSheet()->setCellValue('E'.$k_num_int, $totVisit);
		    $k_num_int=$k_num_int+3;
		    //$docNo = $this->report->all_user_doctor($userid);
		   // $pharmaNo = $this->report->all_user_pharma($userid);
		    $this->excel->getActiveSheet()->setCellValue('A'.$k_num_int, 'Total Doctor');
		    $this->excel->getActiveSheet()->setCellValue('B'.$k_num_int, $docNo);
		    $this->excel->getActiveSheet()->setCellValue('H'.$k_num_int, 'Total Sub Dealer');
		    $this->excel->getActiveSheet()->setCellValue('I'.$k_num_int, $pharmaNo);
		    $k_num_int++;
		    $this->excel->getActiveSheet()->setCellValue('A'.$k_num_int, 'Met Doctor');
		    $this->excel->getActiveSheet()->setCellValue('B'.$k_num_int, $docMeet);
		    $this->excel->getActiveSheet()->setCellValue('H'.$k_num_int, 'Met Sub Dealer');
		    $this->excel->getActiveSheet()->setCellValue('I'.$k_num_int, $pharmaMeet);
		    $k_num_int++;
		    $docMissed=$docNo-$docMeet;
		    $pharmaMissed=$pharmaNo-$pharmaMeet;
		    $this->excel->getActiveSheet()->setCellValue('A'.$k_num_int, 'Missed Doctor');
		    $this->excel->getActiveSheet()->setCellValue('B'.$k_num_int, $docMissed);
		    $this->excel->getActiveSheet()->setCellValue('H'.$k_num_int, 'Missed Sub Dealer');
		    $this->excel->getActiveSheet()->setCellValue('I'.$k_num_int, $pharmaMissed);
		    // Fill data 
		    // $this->excel->getActiveSheet()->fromArray($customerdata,'A2');
		    $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		    $this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		    $this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		    $filename=time().'_SaleReportUser.xls'; //save our workbook as this file name
		    header('Content-Type: application/vnd.ms-excel'); //mime type
		    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		    header('Cache-Control: max-age=0'); //no cache
		    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		    //if you want to save it as .XLSX Excel 2007 format
		    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		    //force user to download the Excel file without writing it to server's HD
		    //ob_end_clean();
		    //ob_start();
		    $message='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}
		    .content{ width:40%;
		     margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{margin:0px;
		     padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                  <h3>Dear,</h3> <p>Please Find the sales report as attachment</p><p><i>This is an auto generated email.</i></p>
                  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">Bjain Admin,<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
		    $pat='assets/reports/'.$filename;
		    $subject=' Sales Reports';
		    $objWriter->save($pat);
		    $this->load->library('email', email_setting());
			$this->email->from('niraj@bjain.com');
			$this->email->to(get_user_email($userid));
			$this->email->subject($subject); 
			if($filename!='')
			{
				$attachpath=base_url().'assets/reports/'.$filename;
				$this->email->attach($pat);
			}
			$this->email->message($message);
			$result=$this->email->send();
			if($result){
			
				unlink( './assets/reports/'.$filename);
		
				 $result = array(
		                'Data' => new stdClass(),
				'Status' => true,
		                'Message' => 'Successfully',
		                'Code' => 200
		            );
		            $this->response($result);	
		        }
		        else
		        {
		        	unlink( './assets/reports/'.$filename);
		        	$result = array(
			        'Data' => new stdClass(),
			        'Status' => false,
			        'Message' => 'Mail Not sent',
			        'Code' => 404
			       );
			       $this->response($result);	
		        }
	    }
	    else 
	    {
	       $result = array(
	        'Data' => new stdClass(),
	        'Status' => false,
	        'Message' => $msg,
	        'Code' => 404
	       );
	    }
	    $this->response($result);	
  }
  
   public function travel_report_post()
   {
	    $post= array_map('trim', $this->input->post());
            $msg ='';
            $item=array();
            if (!isset($post['userid'])) 
            {
	        $msg='User Id is required.';
	    }
            elseif(!isset ($post['startdate']))
            {
                  $msg = 'Please Enter Start Date';
            }
            elseif(!isset ($post['enddate']))
            {
                  $msg = 'Please Enter End Date';
            }

       	    if ($msg == '')
       	    {
       	            $userid=$post['userid'];
       	            $start=date('Y-m-d', strtotime($post['startdate']))." 00:00:00";
		    $end=date('Y-m-d', strtotime($post['enddate']))." 23:59:59";
       	            $this->load->library('excel');
       	                $this->excel->setActiveSheetIndex(0);
		    //name the worksheet
		    $this->excel->getActiveSheet()->setTitle('Travel Report');
		    //set cell A1 content with some text
		    $this->excel->getActiveSheet()->setCellValue('A1', 'Date');
		    $this->excel->getActiveSheet()->setCellValue('B1', 'Customer');
		    $this->excel->getActiveSheet()->setCellValue('C1', 'City');
		    $this->excel->getActiveSheet()->setCellValue('D1', 'Type');
		    $this->excel->getActiveSheet()->setCellValue('E1', 'User');
		    //$this->excel->getActiveSheet()->setCellValue('E1', 'Total Visits');
		    $this->excel->getActiveSheet()->setCellValue('F1', 'Primary Sale');
		    $this->excel->getActiveSheet()->setCellValue('G1', 'Payment');
		    // $this->excel->getActiveSheet()->setCellValue('H1', 'Stock Date');
		    $this->excel->getActiveSheet()->setCellValue('H1', 'Stock');
		    $this->excel->getActiveSheet()->setCellValue('I1', 'Sample');
		    $this->excel->getActiveSheet()->setCellValue('J1', 'Discussion');
		    $this->excel->getActiveSheet()->setCellValue('K1', 'Not Met');
		    $this->excel->getActiveSheet()->setCellValue('L1', 'Telephonic Order');
		    $this->excel->getActiveSheet()->setCellValue('M1', 'Physical Order');
		    $this->excel->getActiveSheet()->setCellValue('N1', 'Secondary Sale');
		    $this->excel->getActiveSheet()->setCellValue('O1', 'Orignal Supply Value');
		    $this->excel->getActiveSheet()->setCellValue('P1', 'Date of Supply');
		    $this->excel->getActiveSheet()->setCellValue('Q1', 'Remarks');
		    $this->excel->getActiveSheet()->setCellValue('R1', 'Joint Working');
		    $this->excel->getActiveSheet()->setCellValue('S1', 'Dealer/Sub Dealer');
		    $this->excel->getActiveSheet()->setCellValue('T1', 'Payment Term');
		    $data['travel'] =$this->report->travel_report_doctor($userid,$start,$end); // for doctor
		    $k_num=2;
		    if(!empty($data['travel']['doc_info'])){
		      foreach ( $data['travel']['doc_info'] as $k=>$row){   // for doctor information with sample
		               
		        $this->excel->getActiveSheet()->setCellValue('A'.$k_num, date('d.m.Y',strtotime($row['date'])));
		        $this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['customer']);
		        $this->excel->getActiveSheet()->setCellValue('C'.$k_num, $row['city']);
		        $this->excel->getActiveSheet()->setCellValue('D'.$k_num, 'Doctor');
		        $this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['user']);
		        $this->excel->getActiveSheet()->setCellValue('R'.$k_num, get_dealer_pharma_name($row['dealer_id']));
		        $this->excel->getActiveSheet()->setCellValue('I'.$k_num, $row['sample']['sample']);
		
		        if($row['metnotmet']!=NULL  && $row['metnotmet']==1){
		          $this->excel->getActiveSheet()->setCellValue('J'.$k_num, 'Yes');
		        }
		        else
		        {
		          $this->excel->getActiveSheet()->setCellValue('J'.$k_num, 'No');
		        }
		        if($row['metnotmet']!=NULL && $row['metnotmet']==0)
		        {
		          $this->excel->getActiveSheet()->setCellValue('K'.$k_num,'Yes');
		        }
		        else
		        {
		          $this->excel->getActiveSheet()->setCellValue('K'.$k_num,'No');
		        }
		        if($row['oncall']!=NULL && $row['oncall']==1)
		        {
		          $this->excel->getActiveSheet()->setCellValue('L'.$k_num,'Yes');
		        }
		        else
		        {
		          $this->excel->getActiveSheet()->setCellValue('L'.$k_num,'No');
		        }
		        if($row['oncall']==NULL )
		        {
		          if($row['secondary_sale']!=NULL )
		          {
		            $this->excel->getActiveSheet()->setCellValue('M'.$k_num,'Yes');
		          }
		          else
		          {
		            $this->excel->getActiveSheet()->setCellValue('M'.$k_num,'No');
		          }
		        }
		        else
		        {
		          $this->excel->getActiveSheet()->setCellValue('M'.$k_num,'No');
		        }
		        $this->excel->getActiveSheet()->setCellValue('N'.$k_num, $row['secondary_sale']);
		        $paymentterm=get_payment_term($row['id'],$row['doc_id']);
		        $this->excel->getActiveSheet()->setCellValue('T'.$k_num, $paymentterm);
		        $this->excel->getActiveSheet()->setCellValue('O'.$k_num, $row['order_supply']);
		        if($row['date_of_supply'] != NULL){
		          $this->excel->getActiveSheet()->setCellValue('P'.$k_num, date('d.m.Y', strtotime($row['date_of_supply'])));
		        }
		        $this->excel->getActiveSheet()->setCellValue('Q'.$k_num, $row['remark']);
		       // $this->excel->getActiveSheet()->setCellValue('Q'.$k_num, $row['oncall']);
		        $k_num++;
		      }
		    }
		      $k_num_team=2;
		       if(!empty($data['travel']['team_info'])){
		      foreach($data['travel']['team_info'] as $k_team=>$row_team){
		        $this->excel->getActiveSheet()->setCellValue('S'.$k_num_team, $row_team['team_user']);
		        $k_num_team++;
		      }
		       }        
		      $data['travel_dealer'] =$this->report->travel_report_dealer($userid,$start,$end);   // for dealer
		      $k_num= count($data['travel']['doc_info'])+2;
		      if(!empty($data['travel_dealer']['dealer_info'])){
		        foreach ( $data['travel_dealer']['dealer_info'] as $k=>$row){   // for dealer information with sample
		          $this->excel->getActiveSheet()->setCellValue('A'.$k_num, date('d.m.Y',strtotime($row['date'])));
		          $this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['customer']);
		          $this->excel->getActiveSheet()->setCellValue('C'.$k_num, $row['city']);
		          if(empty($row['is_cf'])){
		            $this->excel->getActiveSheet()->setCellValue('D'.$k_num, 'Dealer');
		          }
		          else{
		            $this->excel->getActiveSheet()->setCellValue('D'.$k_num, 'C & F'); 
		          }
		          $this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['user']); 
		          $this->excel->getActiveSheet()->setCellValue('F'.$k_num, $row['sale']);
		          $paymentterm=get_payment_term($row['id'],$row['d_id']);
		          $this->excel->getActiveSheet()->setCellValue('T'.$k_num, $paymentterm);
		
		          $this->excel->getActiveSheet()->setCellValue('G'.$k_num, $row['payment']);
		          $this->excel->getActiveSheet()->setCellValue('H'.$k_num, $row['stock']);
		          $this->excel->getActiveSheet()->setCellValue('I'.$k_num, $row['sample']['sample']);
		          if($row['metnotmet']!=NULL  && $row['metnotmet']==1){
		          $this->excel->getActiveSheet()->setCellValue('J'.$k_num, 'Yes');
		        }
		        else
		        {
		          $this->excel->getActiveSheet()->setCellValue('J'.$k_num, 'No');
		        }
		        if($row['metnotmet']!=NULL && $row['metnotmet']==0)
		        {
		          $this->excel->getActiveSheet()->setCellValue('K'.$k_num,'Yes');
		        }
		        else
		        {
		          $this->excel->getActiveSheet()->setCellValue('K'.$k_num,'No');
		        }
		        if($row['oncall']!=NULL && $row['oncall']==1)
		        {
		          $this->excel->getActiveSheet()->setCellValue('L'.$k_num,'Yes');
		        }
		        else
		        {
		          $this->excel->getActiveSheet()->setCellValue('L'.$k_num,'No');
		        }
		        if($row['oncall']==NULL )
		        {
		          if($row['sale']!=NULL )
		          {
		            $this->excel->getActiveSheet()->setCellValue('M'.$k_num,'Yes');
		          }
		          else
		          {
		            $this->excel->getActiveSheet()->setCellValue('M'.$k_num,'No');
		          }
		          
		        }
		        else
		        {
		          $this->excel->getActiveSheet()->setCellValue('M'.$k_num,'No');
		        }
		          $this->excel->getActiveSheet()->setCellValue('Q'.$k_num, $row['remark']);
		        //  $this->excel->getActiveSheet()->setCellValue('Q'.$k_num, $row['oncall']);
		          $k_num++;         
		        }
		        $k_num_team=count($data['travel']['doc_info'])+2;
		        foreach($data['travel_dealer']['team_info'] as $k_team=>$row_team){
		          $this->excel->getActiveSheet()->setCellValue('S'.$k_num_team, $row_team['team_user']);
		          $k_num_team++;
		        }
		      }  
		      $data['travel_pharmacy'] =$this->report->travel_report_pharmacy($userid,$start,$end);   // for pharmacy
		      $k_num= count($data['travel_dealer']['dealer_info'])+ count($data['travel']['doc_info'])+2;
		      if(!empty($data['travel_pharmacy']['pharmacy_info'])){
		        foreach ( $data['travel_pharmacy']['pharmacy_info'] as $k=>$row){   // for pharmacy information with sample
		          $this->excel->getActiveSheet()->setCellValue('A'.$k_num, date('d.m.Y',strtotime($row['date'])));
		          $this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['customer']);
		          $this->excel->getActiveSheet()->setCellValue('C'.$k_num, $row['city']);
		          $this->excel->getActiveSheet()->setCellValue('D'.$k_num, 'Sub Dealer');
		          $this->excel->getActiveSheet()->setCellValue('R'.$k_num, get_dealer_pharma_name($row['dealer_id']));
		          $this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['user']);
		          $this->excel->getActiveSheet()->setCellValue('I'.$k_num, $row['sample']['sample']);
		          if($row['metnotmet']!=NULL  && $row['metnotmet']==1){
		          $this->excel->getActiveSheet()->setCellValue('J'.$k_num, 'Yes');
		        }
		        else
		        {
		          $this->excel->getActiveSheet()->setCellValue('J'.$k_num, 'No');
		        }
		        if($row['metnotmet']!=NULL && $row['metnotmet']==0)
		        {
		          $this->excel->getActiveSheet()->setCellValue('K'.$k_num,'Yes');
		        }
		        else
		        {
		          $this->excel->getActiveSheet()->setCellValue('K'.$k_num,'No');
		        }
		        if($row['oncall']!=NULL && $row['oncall']==1)
		        {
		          $this->excel->getActiveSheet()->setCellValue('L'.$k_num,'Yes');
		        }
		        else
		        {
		          $this->excel->getActiveSheet()->setCellValue('L'.$k_num,'No');
		        }
		        if($row['oncall']==NULL )
		        {
		          if($row['secondary_sale']!=NULL )
		          {
		            $this->excel->getActiveSheet()->setCellValue('M'.$k_num,'Yes');
		          }
		          else
		          {
		            $this->excel->getActiveSheet()->setCellValue('M'.$k_num,'No');
		          }
		        }
		        else
		        {
		          $this->excel->getActiveSheet()->setCellValue('M'.$k_num,'No');
		        }
		          $this->excel->getActiveSheet()->setCellValue('N'.$k_num, $row['secondary_sale']);
		          $paymentterm=get_payment_term($row['id'],$row['pharma_id']);
		          $this->excel->getActiveSheet()->setCellValue('T'.$k_num, $paymentterm);
		          $this->excel->getActiveSheet()->setCellValue('O'.$k_num, $row['order_supply']);
		          if($row['date_of_supply'] != NULL){
		          $this->excel->getActiveSheet()->setCellValue('P'.$k_num, date('d.m.Y', strtotime($row['date_of_supply'])));
		          }
		          $this->excel->getActiveSheet()->setCellValue('Q'.$k_num, $row['remark']);
		         // $this->excel->getActiveSheet()->setCellValue('Q'.$k_num, $row['oncall']);
		          $k_num++;
		        }   
		        $k_num_team=count($data['travel_dealer']['dealer_info'])+ count($data['travel']['doc_info'])+2;
		        foreach($data['travel_pharmacy']['team_info'] as $k_team=>$row_team){
		          $this->excel->getActiveSheet()->setCellValue('S'.$k_num_team, $row_team['team_user']);
		          $k_num_team++;
		        }
		      }
		      $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		      $this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		      $this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		      $filename=time().'_TravelReportUser.xls'; //save our workbook as this file name
		      header('Content-Type: application/vnd.ms-excel'); //mime type
		      header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		      header('Cache-Control: max-age=0'); //no cache
		      $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		      $message='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}
		    .content{ width:40%;
		     margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{margin:0px;
		     padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                  <h3>Dear,</h3> <p>Please Find the Travel report as attachment</p><p><i>This is an auto generated email.</i></p>
                  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">Bjain Admin,<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
		    $pat='assets/reports/'.$filename;
		    $subject=' Travel Reports';
		    $objWriter->save($pat);
		    $this->load->library('email', email_setting());
			$this->email->from('niraj@bjain.com');
			$this->email->to('niraj@bjain.com');
			//$this->email->to(get_user_email($userid));
			$this->email->subject($subject); 
			if($filename!='')
			{
				$attachpath=base_url().'assets/reports/'.$filename;
				$this->email->attach($pat);
			}
			$this->email->message($message);
			$result=$this->email->send();
			if($result){
			
				unlink( './assets/reports/'.$filename);
		
				 $result = array(
		                'Data' => new stdClass(),
				'Status' => true,
		                'Message' => 'Successfully',
		                'Code' => 200
		            );
		            $this->response($result);	
		        }
		        else
		        {
		        	unlink( './assets/reports/'.$filename);
		        	$result = array(
			        'Data' => new stdClass(),
			        'Status' => false,
			        'Message' => 'Mail Not sent',
			        'Code' => 404
			       );
			       $this->response($result);	
		        }
       	            
 	    }
	    else 
	    {
	       $result = array(
	        'Data' => new stdClass(),
	        'Status' => false,
	        'Message' => $msg,
	        'Code' => 404
	       );
	    }
	    $this->response($result);	
     }
     
       public function dealer_customer_report_post()
   	{
	    $post= array_map('trim', $this->input->post());
            $msg ='';
            $item=array();
            if (!isset($post['userid'])) 
            {
	        $msg='User Id is required.';
	    }
            elseif(!isset ($post['startdate']))
            {
                  $msg = 'Please Enter Start Date';
            }
            elseif(!isset ($post['enddate']))
            {
                  $msg = 'Please Enter End Date';
            }
            elseif (!isset($post['dealer_id'])) 
            {
	        $msg='Dealer Id is required.';
	    }
       	    if ($msg == '')
       	    {
       	    	    $userid=$post['userid'];
       	    	    $dealer_id=$post['dealer_id'];
       	            $start=date('Y-m-d', strtotime($post['startdate']))." 00:00:00";
		    $end=date('Y-m-d', strtotime($post['enddate']))." 23:59:59";
       	            $this->load->library('excel');	
       	    	    $this->excel->setActiveSheetIndex(0);
		    $this->excel->getActiveSheet()->setTitle('Relationship Report');
		    $this->excel->getActiveSheet()->setCellValue('A1', 'Date');
		    $this->excel->getActiveSheet()->setCellValue('B1', 'Customer');
		    $this->excel->getActiveSheet()->setCellValue('C1', 'City');
		    $this->excel->getActiveSheet()->setCellValue('D1', 'Type');
		    $this->excel->getActiveSheet()->setCellValue('E1', 'User');            
		    $this->excel->getActiveSheet()->setCellValue('F1', 'Primary Sale');
		    $this->excel->getActiveSheet()->setCellValue('G1', 'Payment');
		    $this->excel->getActiveSheet()->setCellValue('H1', 'Stock Date');
		    $this->excel->getActiveSheet()->setCellValue('I1', 'Stock');          
		    $this->excel->getActiveSheet()->setCellValue('J1', 'Secondary Sale');
		    $data['rr_dealer'] =$this->report->relationship_report_dealer($dealer_id,$start,$end); // for Dealer
		    $k_num=2;
		    $total_secondary_sale=0;
		    if(!empty($data['rr_dealer']['dealer_info'])){
		      foreach ( $data['rr_dealer']['dealer_info'] as $k=>$row){   // for Dealer information 
		        $this->excel->getActiveSheet()->setCellValue('A'.$k_num, date('d.m.Y', strtotime($row['date'])) );
		        $this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['customer']);
		        $this->excel->getActiveSheet()->setCellValue('C'.$k_num, $row['city']);
		        if(empty($row['is_cf'])){
		          $this->excel->getActiveSheet()->setCellValue('D'.$k_num, 'Dealer');
		        }
		        else{
		          $this->excel->getActiveSheet()->setCellValue('D'.$k_num, 'C & F'); 
		        }
		        $this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['user']);
		        $this->excel->getActiveSheet()->setCellValue('F'.$k_num,$row['sale']);
		        $this->excel->getActiveSheet()->setCellValue('G'.$k_num, $row['payment']);
		        $this->excel->getActiveSheet()->setCellValue('H'.$k_num, date('d.m.Y', strtotime($row['date'])));
		        $this->excel->getActiveSheet()->setCellValue('I'.$k_num, $row['stock']);
		        $this->excel->getActiveSheet()->setCellValue('J'.$k_num, '');
		        $total_secondary_sale += $row['sale'];
		        $k_num++;
		      }
		      $total_positon = count($data['rr_dealer']['dealer_info'])+2;
		      $this->excel->getActiveSheet()->setCellValue('B'.$total_positon, 'TOTAL');
		      $this->excel->getActiveSheet()->setCellValue('F'.$total_positon, 'Rs.'.$total_secondary_sale);
		      $this->excel->getActiveSheet()->getStyle('B'.$total_positon)->getFont()->setBold(true);
		      $this->excel->getActiveSheet()->getStyle('F'.$total_positon)->getFont()->setBold(true);
		    }
		    $k_num_int = count($data['rr_dealer']['dealer_info'])+4;
		    $total_secondary_sale_doc=0;
		    if(!empty($data['rr_dealer']['dealer_doc_relation'])){
		      foreach ( $data['rr_dealer']['dealer_doc_relation'] as $k_doc=>$row_doc){   // for Doctor information 
		        $this->excel->getActiveSheet()->setCellValue('A'.$k_num_int, date('d.m.Y', strtotime($row_doc['date'])) );
		        $this->excel->getActiveSheet()->setCellValue('B'.$k_num_int, $row_doc['customer']);
		        $this->excel->getActiveSheet()->setCellValue('C'.$k_num_int, $row_doc['city']);
		        $this->excel->getActiveSheet()->setCellValue('D'.$k_num_int, 'Doctor');
		        $this->excel->getActiveSheet()->setCellValue('E'.$k_num_int, $row_doc['user']);
		        $this->excel->getActiveSheet()->setCellValue('F'.$k_num_int,'');
		        $this->excel->getActiveSheet()->setCellValue('G'.$k_num_int, '');
		        $this->excel->getActiveSheet()->setCellValue('H'.$k_num_int, '');
		        $this->excel->getActiveSheet()->setCellValue('I'.$k_num_int, '');
		        $this->excel->getActiveSheet()->setCellValue('J'.$k_num_int, $row_doc['secondary_sale']);
		        $total_secondary_sale_doc += $row_doc['secondary_sale'];
		        $k_num_int++;
		      }    
		    }
		    if(!empty($data['rr_dealer']['dealer_pharma_relation'])){
		      foreach ( $data['rr_dealer']['dealer_pharma_relation'] as $k_doc=>$row_doc){   // for dealer pharmacy relation
		        $this->excel->getActiveSheet()->setCellValue('A'.$k_num_int, date('d.m.Y', strtotime($row_doc['date'])) );
		        $this->excel->getActiveSheet()->setCellValue('B'.$k_num_int, $row_doc['customer']);
		        $this->excel->getActiveSheet()->setCellValue('C'.$k_num_int, $row_doc['city']);
		        $this->excel->getActiveSheet()->setCellValue('D'.$k_num_int, 'Sub Dealer');
		        $this->excel->getActiveSheet()->setCellValue('E'.$k_num_int, $row_doc['user']);
		        $this->excel->getActiveSheet()->setCellValue('F'.$k_num_int,'');
		        $this->excel->getActiveSheet()->setCellValue('G'.$k_num_int, '');
		        $this->excel->getActiveSheet()->setCellValue('H'.$k_num_int, '');
		        $this->excel->getActiveSheet()->setCellValue('I'.$k_num_int, '');
		        $this->excel->getActiveSheet()->setCellValue('J'.$k_num_int, $row_doc['secondary_sale']);
		        $total_secondary_sale_doc += $row_doc['secondary_sale'];
		        $k_num_int++;
		      }
		    }
		    $total_positon_doc = count($data['rr_dealer']['dealer_pharma_relation'])+count($data['rr_dealer']['dealer_info'])+count($data['rr_dealer']['dealer_doc_relation'])+6;
		    $this->excel->getActiveSheet()->setCellValue('B'.$total_positon_doc, 'TOTAL');
		    $this->excel->getActiveSheet()->setCellValue('J'.$total_positon_doc, 'Rs.'.$total_secondary_sale_doc);
		    $this->excel->getActiveSheet()->getStyle('B'.$total_positon_doc)->getFont()->setBold(true);
		    $this->excel->getActiveSheet()->getStyle('J'.$total_positon_doc)->getFont()->setBold(true);
		    $relationship_percentage =  $total_positon_doc+2;
		    if($total_secondary_sale!=0){
		      $result_pecentage = ($total_secondary_sale_doc/$total_secondary_sale)*100 ;
		    }
		    else{
		      $result_pecentage=0;  
		    }
		    $this->excel->getActiveSheet()->setCellValue('A'.$relationship_percentage,'B. Jain Contribution' );
		    $this->excel->getActiveSheet()->setCellValue('B'.$relationship_percentage,$result_pecentage.'%' );
		    $this->excel->getActiveSheet()->getStyle('A'.$relationship_percentage)->getFont()->setBold(true);
		    $this->excel->getActiveSheet()->getStyle('B'.$relationship_percentage)->getFont()->setBold(true);
		    $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		    $this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		    $this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		    $filename=time().'_DealerReportCard.xls'; //save our workbook as this file name
		    header('Content-Type: application/vnd.ms-excel'); //mime type
		    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		    header('Cache-Control: max-age=0'); //no cache
		    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		    	      $message='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}
		    .content{ width:40%;
		     margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{margin:0px;
		     padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                  <h3>Dear,</h3> <p>Please Find the Travel report as attachment</p><p><i>This is an auto generated email.</i></p>
                  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">Bjain Admin,<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
		    $pat='assets/reports/'.$filename;
		    $subject=' Dealer Customer Relation Reports';
		    $objWriter->save($pat);
		    $this->load->library('email', email_setting());
			$this->email->from('niraj@bjain.com');
			$this->email->to('niraj@bjain.com');
			//$this->email->to(get_user_email($userid));
			$this->email->subject($subject); 
			if($filename!='')
			{
				$attachpath=base_url().'assets/reports/'.$filename;
				$this->email->attach($pat);
			}
			$this->email->message($message);
			$result=$this->email->send();
			if($result){
			
				unlink( './assets/reports/'.$filename);
		
				 $result = array(
		                'Data' => new stdClass(),
				'Status' => true,
		                'Message' => 'Successfully',
		                'Code' => 200
		            );
		            $this->response($result);	
		        }
		        else
		        {
		        	unlink( './assets/reports/'.$filename);
		        	$result = array(
			        'Data' => new stdClass(),
			        'Status' => false,
			        'Message' => 'Mail Not sent',
			        'Code' => 404
			       );
			       $this->response($result);	
		        }
       	            
       	    }
	    else 
	    {
	       $result = array(
	        'Data' => new stdClass(),
	        'Status' => false,
	        'Message' => $msg,
	        'Code' => 404
	       );
	    }
	    $this->response($result);	
     }
     
     public function pharma_customer_report_post()
   	{
	    $post= array_map('trim', $this->input->post());
            $msg ='';
            $item=array();
            if (!isset($post['userid'])) 
            {
	        $msg='User Id is required.';
	    }
            elseif(!isset ($post['startdate']))
            {
                  $msg = 'Please Enter Start Date';
            }
            elseif(!isset ($post['enddate']))
            {
                  $msg = 'Please Enter End Date';
            }
            elseif (!isset($post['pharma_id'])) 
            {
	        $msg='Pharma Id is required.';
	    }
       	    if ($msg == '')
       	    {
       	            $userid=$post['userid'];
       	    	    $pharma_id=$post['pharma_id'];
       	            $start=date('Y-m-d', strtotime($post['startdate']))." 00:00:00";
		    $end=date('Y-m-d', strtotime($post['enddate']))." 23:59:59";
       	            $this->load->library('excel');
       	    	    $this->excel->setActiveSheetIndex(0);
		    $this->excel->getActiveSheet()->setTitle('Relationship Report');
		    $this->excel->getActiveSheet()->setCellValue('A1', 'Date');
		    $this->excel->getActiveSheet()->setCellValue('B1', 'Customer');
		    $this->excel->getActiveSheet()->setCellValue('C1', 'City');
		    $this->excel->getActiveSheet()->setCellValue('D1', 'Type');
		    $this->excel->getActiveSheet()->setCellValue('E1', 'User');            
		    $this->excel->getActiveSheet()->setCellValue('F1', 'Primary Sale');
		    $this->excel->getActiveSheet()->setCellValue('G1', 'Payment');
		    $this->excel->getActiveSheet()->setCellValue('H1', 'Stock Date');
		    $this->excel->getActiveSheet()->setCellValue('I1', 'Stock');          
		    $this->excel->getActiveSheet()->setCellValue('J1', 'Secondary Sale');
		    $data['rr_pharmacy'] =$this->report->relationship_report_pharmacy($pharma_id,$start,$end); // for Sub Dealer
		    $k_num=2;
		    $total_secondary_sale=0;
		    if(!empty($data['rr_pharmacy']['pharmacy_info'])){
		      foreach ( $data['rr_pharmacy']['pharmacy_info'] as $k=>$row){   // for Sub Dealer information 
		        $this->excel->getActiveSheet()->setCellValue('A'.$k_num, date('d.m.Y', strtotime($row['date'])) );
		        $this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['customer']);
		        $this->excel->getActiveSheet()->setCellValue('C'.$k_num, $row['city']);
		        $this->excel->getActiveSheet()->setCellValue('D'.$k_num, 'Sub Dealer');
		        $this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['user']);
		        $this->excel->getActiveSheet()->setCellValue('F'.$k_num,'');
		        $this->excel->getActiveSheet()->setCellValue('G'.$k_num, '');
		        $this->excel->getActiveSheet()->setCellValue('H'.$k_num, '');
		        $this->excel->getActiveSheet()->setCellValue('I'.$k_num, '');
		        $this->excel->getActiveSheet()->setCellValue('J'.$k_num, $row['secondary_sale']);
		        $total_secondary_sale += $row['secondary_sale'];
		        $k_num++;
		      }    
		      $total_positon = count($data['rr_pharmacy']['pharmacy_info'])+2;
		      $this->excel->getActiveSheet()->setCellValue('B'.$total_positon, 'TOTAL');
		      $this->excel->getActiveSheet()->setCellValue('J'.$total_positon, 'Rs.'.$total_secondary_sale);
		      $this->excel->getActiveSheet()->getStyle('B'.$total_positon)->getFont()->setBold(true);
		      $this->excel->getActiveSheet()->getStyle('J'.$total_positon)->getFont()->setBold(true);
		    }
		    $k_num_int = count($data['rr_pharmacy']['pharmacy_info'])+4;
		    $total_secondary_sale_doc=0;
		    if(!empty($data['rr_pharmacy']['pharma_doc_relation'])){
		      foreach ( $data['rr_pharmacy']['pharma_doc_relation'] as $k_doc=>$row_doc){   // for Doctor information 
		        $this->excel->getActiveSheet()->setCellValue('A'.$k_num_int, date('d.m.Y', strtotime($row_doc['date'])) );
		        $this->excel->getActiveSheet()->setCellValue('B'.$k_num_int, $row_doc['customer']);
		        $this->excel->getActiveSheet()->setCellValue('C'.$k_num_int, $row_doc['city']);
		        $this->excel->getActiveSheet()->setCellValue('D'.$k_num_int, 'Doctor');
		        $this->excel->getActiveSheet()->setCellValue('E'.$k_num_int, $row_doc['user']);
		        $this->excel->getActiveSheet()->setCellValue('F'.$k_num_int,'');
		        $this->excel->getActiveSheet()->setCellValue('G'.$k_num_int, '');
		        $this->excel->getActiveSheet()->setCellValue('H'.$k_num_int, '');
		        $this->excel->getActiveSheet()->setCellValue('I'.$k_num_int, '');
		        $this->excel->getActiveSheet()->setCellValue('J'.$k_num_int, $row_doc['secondary_sale']);
		        $total_secondary_sale_doc += $row_doc['secondary_sale'];
		        $k_num_int++;
		      }
		    }
		    $total_positon_doc = count($data['rr_pharmacy']['pharmacy_info'])+count($data['rr_pharmacy']['pharma_doc_relation'])+6;
		    $this->excel->getActiveSheet()->setCellValue('B'.$total_positon_doc, 'TOTAL');
		    $this->excel->getActiveSheet()->setCellValue('J'.$total_positon_doc, 'Rs.'.$total_secondary_sale_doc);
		    $this->excel->getActiveSheet()->getStyle('B'.$total_positon_doc)->getFont()->setBold(true);
		    $this->excel->getActiveSheet()->getStyle('J'.$total_positon_doc)->getFont()->setBold(true);
		    $relationship_percentage =  $total_positon_doc+2;
		    if($total_secondary_sale !=0){
		      $result_pecentage = ($total_secondary_sale_doc/$total_secondary_sale)*100 ;
		    }
		    else{
		      $result_pecentage=0;
		    }
		    $this->excel->getActiveSheet()->setCellValue('A'.$relationship_percentage,'B. Jain Contribution' );
		    $this->excel->getActiveSheet()->setCellValue('B'.$relationship_percentage,$result_pecentage.'%' );
		    $this->excel->getActiveSheet()->getStyle('A'.$relationship_percentage)->getFont()->setBold(true);
		    $this->excel->getActiveSheet()->getStyle('B'.$relationship_percentage)->getFont()->setBold(true);
		    $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		    $this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		    $this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		    $filename=time().'_PharmacyReportCard.xls'; //save our workbook as this file name
		    header('Content-Type: application/vnd.ms-excel'); //mime type
		    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		    header('Cache-Control: max-age=0'); //no cache
		    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		    	      $message='<html><head><title>BJain Pharmaceuticals</title><style type="text/css">body{padding:0;margin:0;font-family: calibri;}
		    .content{ width:40%;
		     margin:0 auto;}.regards_box{float:left;margin-top:20px;}p.user_name_brand{ margin:0px;}h3.user_name_regards{margin:0px;
		     padding-bottom:10px;}img.email_logo{ margin:15px 0px;}</style></head><body><div class="content"><center><img src="'.base_url().'/design/bjain_pharma/bjain_logo.png" class="email_logo" style="width:250px;" /></center>  
                  <h3>Dear,</h3> <p>Please Find the Travel report as attachment</p><p><i>This is an auto generated email.</i></p>
                  <div class="regards_box"><h3 class="user_name_regards">Regards,</h3><p class="user_name_brand">Bjain Admin,<br>BJain Pharmaceuticals Pvt. Ltd.</p></div></div></body></html>';
		    $pat='assets/reports/'.$filename;
		    $subject=' Dealer Customer Relation Reports';
		    $objWriter->save($pat);
		    $this->load->library('email', email_setting());
			$this->email->from('niraj@bjain.com');
			$this->email->to('niraj@bjain.com');
			//$this->email->to(get_user_email($userid));
			$this->email->subject($subject); 
			if($filename!='')
			{
				$attachpath=base_url().'assets/reports/'.$filename;
				$this->email->attach($pat);
			}
			$this->email->message($message);
			$result=$this->email->send();
			if($result){
			
				unlink( './assets/reports/'.$filename);
		
				 $result = array(
		                'Data' => new stdClass(),
				'Status' => true,
		                'Message' => 'Successfully',
		                'Code' => 200
		            );
		            $this->response($result);	
		        }
		        else
		        {
		        	unlink( './assets/reports/'.$filename);
		        	$result = array(
			        'Data' => new stdClass(),
			        'Status' => false,
			        'Message' => 'Mail Not sent',
			        'Code' => 404
			       );
			       $this->response($result);	
		        }
       	            
       	    }
	    else 
	    {
	       $result = array(
	        'Data' => new stdClass(),
	        'Status' => false,
	        'Message' => $msg,
	        'Code' => 404
	       );
	    }
	    $this->response($result);	
     }
     
        
     /*
      * Developer: Shailesh Saraswat
      * Email: sss.shailesh@gmail.com
      * Dated: 30-April-2019
      * 
      * save genrated report and send them to their manager for approval
      * 
      */
     
     
       function send_for_approval_post()
    {
            # initialize variables
            $msg = '';
            $tpdp_data=json_decode($this->input->raw_input_stream);
              if($this->report->first_time_genrate($tpdp_data->report_date, $tpdp_data->userId)){
            if ($msg == '') 
            {
                    $data = $this->rpt->save_tada_report($tpdp_data);
                    if ($data!=FALSE) 
                    { 
                        $result = array(
                            'Data' => $data,
                            // 'Status' => true,
                            'Message' => 'Save Successfully',
                            'Code' => 200
                        );
                    }
                    else 
                    {
                        $result = array(
                            'Data' => new stdClass(),
                            'Status' => false,
                            'Message' => 'Error in Save info.',
                            'Code' => 404
                        );
                    }
            }
            else 
            {
                $result = array(
                    'Data' => new stdClass(),
                    'Status' => false,
                    'Message' => $msg,
                    'Code' => 404
                );
            }
              }
              else 
             {
                    $result = array(
                        'Data' => new stdClass(),
                        'Status' => false,
                        'Message' => 'this month ta/da is already genrated',
                        'Code' => 404
                    );
                }
            $this->response($result);
    }
     
     
     
     
}

