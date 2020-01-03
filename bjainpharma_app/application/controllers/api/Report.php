<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/*
 * 
 */



class Report extends REST_Controller {
    function __construct() {
    // Construct the parent class        
        parent::__construct();
        
        $this->load->model('api/Report_model','report');
    }


    
    function interaction_summary_report_post()
    {
         $root_dir = $_SERVER['DOCUMENT_ROOT'].'/bjainpharma/'; 
        # initialize variables
        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        
        if(empty($post['working_user_id']))
        {
        	$msg='Please enter user id.';
        }
                
       	if ($msg == '') 
        {

            $blockArr=array('23','28','205','209','29','32','190');
            
            if(((isset($post['overall_secondary_report'])) && ($post['overall_secondary_report'] == 1)) ){
                //die('overall_secondary_report');
                $data = array(); 
                $child = isset($post['child']) ? $post['child'] : null;
                //Child of grish
                //93, 94, 95, 172, 30, 191, 104;
                
                $child_user_list = $this->report->user_child_team($child);
                $childs_users=array();
                foreach ($child_user_list as $childs){
                      $childs_users[]=$childs['userid'];
                }
                //dump($childs_users);die;
                           
                $timeline = $post['period'];
                if($timeline==''){                    
                    $jsonData = file_get_contents ($root_dir."ReportJSON/weekly.json");
                    $json = json_decode($jsonData, true);
                    foreach($json as $user) {
                        //if not admin user
                          
                        if (in_array($user['user_id'], $childs_users)) { 
                            
                            if($user['total_doc_interaction'] > 0){
                                $user['total_doc_interaction'] = $user['total_doc_interaction'] - $user['total_orders_not_met'];
                            } else {
                               $user['total_doc_interaction'] = 0; 
                            }

                            if(!empty($user['total_secondary'])){
                                //
                            } else {
                                $user['total_secondary'] = 0;
                            }

                            if(!empty($user['total_productive_call'])){

                            } else {
                                $user['total_productive_call'] = 0;
                            }

                            if(!empty($user['total_orders_not_met'])){

                            } else {
                                $user['total_orders_not_met'] = 0;
                            }

                            if(!empty($user['total_doc_interaction']) && !empty($user['total_orders_not_met'])){
                                $user['average_interaction'] = number_format(($user['total_doc_interaction'] - $user['total_orders_not_met'])/ 7 , 2, '.', '');
                            } else {
                                $user['average_interaction'] =0.00;
                            }

                            $tot_interact=$user['total_doc_interaction'] - $user['total_orders_not_met'];
                            $tot_sec=str_replace( ',', '', $user['total_secondary']);
                            if (!empty($user['total_secondary']) && !empty($tot_sec) && !empty($tot_interact) && !empty($user['total_doc_interaction'])) {
                              $avg_sec=($tot_sec/$tot_interact);  
                                $user['average_secondary'] = number_format($avg_sec,2,'.','');
                            }else {
                                $user['average_secondary'] = 0.00;
                            }

                            $user['total_dealers'] = get_dealers_count($user['user_id']);

                            $user['total_sub_dealers'] = get_pharma_count($user['user_id']);

                            $data[] = $user;
                            //dump($user);die;  
                        }
                    }
                } else if($timeline=='monthly'){
                    $jsonData = file_get_contents ($root_dir."ReportJSON/monthly.json");
                    $json = json_decode($jsonData, true);
                    foreach($json as $user) {
                        if (in_array($user['user_id'], $childs_users)) {
                            if($user['total_doc_interaction'] > 0){
                                $user['total_doc_interaction'] = $user['total_doc_interaction'] - $user['total_orders_not_met'];
                            } else {
                               $user['total_doc_interaction'] = 0; 
                            }

                            if(!empty($user['total_secondary'])){
                                //
                            } else {
                                $user['total_secondary'] = 0;
                            }

                            if(!empty($user['total_productive_call'])){

                            } else {
                                $user['total_productive_call'] = 0;
                            }

                            if(!empty($user['total_orders_not_met'])){

                            } else {
                                $user['total_orders_not_met'] = 0;
                            }

                            if(!empty($user['total_doc_interaction']) && !empty($user['total_orders_not_met'])){ 
                                $user['average_interaction'] = number_format(($user['total_doc_interaction'] - $user['total_orders_not_met'])/ 30 , 2, '.', '');                      
                            }else{ 
                                $user['average_interaction'] = 0.00;
                            }

                            $tot_interact=$user['total_doc_interaction'] - $user['total_orders_not_met'];
                            $tot_sec=str_replace( ',', '', $user['total_secondary']);
                            if (!empty($user['total_secondary']) && !empty($tot_sec) && !empty($tot_interact) && !empty($user['total_doc_interaction'])) {
                                $avg_sec=($tot_sec/$tot_interact);                          
                                $user['average_secondary'] = number_format($avg_sec,2,'.','');
                            }else { 
                              $user['average_secondary'] = 0.00;
                            } 

                            $user['total_dealers'] = get_dealers_count($user['user_id']);

                            $user['total_sub_dealers'] = get_pharma_count($user['user_id']);

                            $data[] = $user;
                        }
                    }
                } else if($timeline=='quarterly'){
                    
                    $jsonData = file_get_contents ($root_dir."ReportJSON/quarterly.json");
                    $json = json_decode($jsonData, true);
                    foreach($json as $user) {
                        if (in_array($user['user_id'], $childs_users)) {
                            if($user['total_doc_interaction'] > 0){
                                $user['total_doc_interaction'] = $user['total_doc_interaction'] - $user['total_orders_not_met'];
                            } else {
                               $user['total_doc_interaction'] = 0; 
                            }

                            if(!empty($user['total_secondary'])){
                                //
                            } else {
                                $user['total_secondary'] = 0;
                            }

                            if(!empty($user['total_productive_call'])){

                            } else {
                                $user['total_productive_call'] = 0;
                            }

                            if(!empty($user['total_orders_not_met'])){

                            } else {
                                $user['total_orders_not_met'] = 0;
                            }
                            
                            if(!empty($user['total_doc_interaction']) && !empty($user['total_orders_not_met'])){
                                $user['average_interaction'] = number_format(($user['total_doc_interaction'] - $user['total_orders_not_met'])/ 90 , 2, '.', '');                                  
                            }else{
                                $user['average_interaction'] = 0.00;
                            }
                            
                            $tot_interact=$user['total_doc_interaction'] - $user['total_orders_not_met'];
                            $tot_sec=str_replace( ',', '', $user['total_secondary']);
                            if (!empty($user['total_secondary']) && !empty($tot_sec) && !empty($tot_interact)) {
                                $avg_sec=($tot_sec/$tot_interact); 
                                $user['average_secondary'] = number_format($avg_sec,2,'.','');
                            }else { 
                                $user['average_secondary'] = 0.00;
                            }
                            
                            $user['total_dealers'] = get_dealers_count($user['user_id']);

                            $user['total_sub_dealers'] = get_pharma_count($user['user_id']);

                            $data[] = $user;
                        }
                    }
                } else if($timeline=='yearly'){
                    $jsonData = file_get_contents ($root_dir."ReportJSON/yearly.json");
                    $json = json_decode($jsonData, true);
                    foreach($json as $user) {
                        if (in_array($user['user_id'], $childs_users)) {
                            if($user['total_doc_interaction'] > 0){
                                $user['total_doc_interaction'] = $user['total_doc_interaction'] - $user['total_orders_not_met'];
                            } else {
                               $user['total_doc_interaction'] = 0; 
                            }

                            if(!empty($user['total_secondary'])){
                                //
                            } else {
                                $user['total_secondary'] = 0;
                            }

                            if(!empty($user['total_productive_call'])){

                            } else {
                                $user['total_productive_call'] = 0;
                            }

                            if(!empty($user['total_orders_not_met'])){

                            } else {
                                $user['total_orders_not_met'] = 0;
                            }

                            if(!empty($user['total_doc_interaction']) && !empty($user['total_orders_not_met'])){
                                $user['average_interaction'] = number_format(($user['total_doc_interaction'] - $user['total_orders_not_met'])/ 365 , 2, '.', '');                        
                            }else{
                                $user['average_interaction'] = 0.00;                            
                            }

                            $tot_interact=$user['total_doc_interaction'] - $user['total_orders_not_met'];
                            $tot_sec=str_replace( ',', '', $user['total_secondary']);
                            if (!empty($user['total_secondary']) && !empty($tot_sec) && !empty($tot_interact)) {
                                $avg_sec=($tot_sec/$tot_interact);                          
                                $user['average_secondary'] = number_format($avg_sec,2,'.','');
                            }else {
                                $user['average_secondary'] = 0.00;
                            }

                            $user['total_dealers'] = get_dealers_count($user['user_id']);

                            $user['total_sub_dealers'] = get_pharma_count($user['user_id']);

                            $data[] = $user;

                        }
                    }
                }
                
            } else {
                if($post['period']==''){
                    $data = file_get_contents ($root_dir."ReportJSON/weekly.json");
                    $json = json_decode($data, true);
                    foreach($json as $user){
                        if($user['user_id']==$post['working_user_id']){ 
                            if($user['total_doc_interaction'] > 0){
                                $user['total_doc_interaction'] = $user['total_doc_interaction'] - $user['total_orders_not_met'];
                            } else {
                               $user['total_doc_interaction'] = 0; 
                            }

                            if(!empty($user['total_secondary'])){
                                //
                            } else {
                                $user['total_secondary'] = 0;
                            }

                            if(!empty($user['total_productive_call'])){

                            } else {
                                $user['total_productive_call'] = 0;
                            }

                            if(!empty($user['total_orders_not_met'])){

                            } else {
                                $user['total_orders_not_met'] = 0;
                            }

                            if(!empty($user['total_doc_interaction']) && !empty($user['total_orders_not_met'])){
                                $user['average_interaction'] = number_format(($user['total_doc_interaction'] - $user['total_orders_not_met'])/ 7 , 2, '.', '');
                            } else {
                                $user['average_interaction'] =0.00;
                            }

                            $tot_interact=$user['total_doc_interaction'] - $user['total_orders_not_met'];
                            $tot_sec=str_replace( ',', '', $user['total_secondary']);
                            if (!empty($user['total_secondary']) && !empty($tot_sec) && !empty($tot_interact) && !empty($user['total_doc_interaction'])) {
                              $avg_sec=($tot_sec/$tot_interact);  
                                $user['average_secondary'] = number_format($avg_sec,2,'.','');
                            }else {
                                $user['average_secondary'] = 0.00;
                            }

                            $user['total_dealers'] = get_dealers_count($user['user_id']);

                            $user['total_sub_dealers'] = get_pharma_count($user['user_id']);

                            $data = $user;
                            //dump($user);die;                    
                        }
                    }
                } else if($post['period']=='monthly'){
                    $data = file_get_contents ($root_dir."ReportJSON/monthly.json");
                    $json = json_decode($data, true);
                    foreach($json as $user){
                      if($user['user_id']==$post['working_user_id']){ 
                            if($user['total_doc_interaction'] > 0){
                                $user['total_doc_interaction'] = $user['total_doc_interaction'] - $user['total_orders_not_met'];
                            } else {
                               $user['total_doc_interaction'] = 0; 
                            }

                            if(!empty($user['total_secondary'])){
                                //
                            } else {
                                $user['total_secondary'] = 0;
                            }

                            if(!empty($user['total_productive_call'])){

                            } else {
                                $user['total_productive_call'] = 0;
                            }

                            if(!empty($user['total_orders_not_met'])){

                            } else {
                                $user['total_orders_not_met'] = 0;
                            }

                            if(!empty($user['total_doc_interaction']) && !empty($user['total_orders_not_met'])){ 
                                $user['average_interaction'] = number_format(($user['total_doc_interaction'] - $user['total_orders_not_met'])/ 30 , 2, '.', '');                      
                            }else{ 
                                $user['average_interaction'] = 0.00;
                            }

                            $tot_interact=$user['total_doc_interaction'] - $user['total_orders_not_met'];
                            $tot_sec=str_replace( ',', '', $user['total_secondary']);
                            if (!empty($user['total_secondary']) && !empty($tot_sec) && !empty($tot_interact) && !empty($user['total_doc_interaction'])) {
                                $avg_sec=($tot_sec/$tot_interact);                          
                                $user['average_secondary'] = number_format($avg_sec,2,'.','');
                            }else { 
                              $user['average_secondary'] = 0.00;
                            } 

                            $user['total_dealers'] = get_dealers_count($user['user_id']);

                            $user['total_sub_dealers'] = get_pharma_count($user['user_id']);

                            $data = $user;

                            //dump($user);

                      }
                    }
                } if($post['period']=='quarterly'){
                    $data = file_get_contents ($root_dir."ReportJSON/quarterly.json");
                    $json = json_decode($data, true);
                    foreach($json as $user){
                        if($user['user_id']==$post['working_user_id']){ 
                            if($user['total_doc_interaction'] > 0){
                                $user['total_doc_interaction'] = $user['total_doc_interaction'] - $user['total_orders_not_met'];
                            } else {
                               $user['total_doc_interaction'] = 0; 
                            }

                            if(!empty($user['total_secondary'])){
                                //
                            } else {
                                $user['total_secondary'] = 0;
                            }

                            if(!empty($user['total_productive_call'])){

                            } else {
                                $user['total_productive_call'] = 0;
                            }

                            if(!empty($user['total_orders_not_met'])){

                            } else {
                                $user['total_orders_not_met'] = 0;
                            }
                            
                            if(!empty($user['total_doc_interaction']) && !empty($user['total_orders_not_met'])){
                                $user['average_interaction'] = number_format(($user['total_doc_interaction'] - $user['total_orders_not_met'])/ 90 , 2, '.', '');                                  
                            }else{
                                $user['average_interaction'] = 0.00;
                            }
                            
                            $tot_interact=$user['total_doc_interaction'] - $user['total_orders_not_met'];
                            $tot_sec=str_replace( ',', '', $user['total_secondary']);
                            if (!empty($user['total_secondary']) && !empty($tot_sec) && !empty($tot_interact)) {
                                $avg_sec=($tot_sec/$tot_interact); 
                                $user['average_secondary'] = number_format($avg_sec,2,'.','');
                            }else { 
                                $user['average_secondary'] = 0.00;
                            }
                            
                            $user['total_dealers'] = get_dealers_count($user['user_id']);

                            $user['total_sub_dealers'] = get_pharma_count($user['user_id']);

                            $data = $user;
                            
                            //dump($user);die;
                        }
                    }
                    
                
                } else if($post['period'] == 'yearly'){ 

                    $data = file_get_contents ($root_dir."ReportJSON/yearly.json");
                    $json = json_decode($data, true);
                    foreach($json as $user){
                        if($user['user_id']==$post['working_user_id']){ 
                            if($user['total_doc_interaction'] > 0){
                                $user['total_doc_interaction'] = $user['total_doc_interaction'] - $user['total_orders_not_met'];
                            } else {
                               $user['total_doc_interaction'] = 0; 
                            }

                            if(!empty($user['total_secondary'])){
                                //
                            } else {
                                $user['total_secondary'] = 0;
                            }

                            if(!empty($user['total_productive_call'])){

                            } else {
                                $user['total_productive_call'] = 0;
                            }

                            if(!empty($user['total_orders_not_met'])){

                            } else {
                                $user['total_orders_not_met'] = 0;
                            }

                            if(!empty($user['total_doc_interaction']) && !empty($user['total_orders_not_met'])){
                                $user['average_interaction'] = number_format(($user['total_doc_interaction'] - $user['total_orders_not_met'])/ 365 , 2, '.', '');                        
                            }else{
                                $user['average_interaction'] = 0.00;                            
                            }

                            $tot_interact=$user['total_doc_interaction'] - $user['total_orders_not_met'];
                            $tot_sec=str_replace( ',', '', $user['total_secondary']);
                            if (!empty($user['total_secondary']) && !empty($tot_sec) && !empty($tot_interact)) {
                                $avg_sec=($tot_sec/$tot_interact);                          
                                $user['average_secondary'] = number_format($avg_sec,2,'.','');
                            }else {
                                $user['average_secondary'] = 0.00;
                            }

                            $user['total_dealers'] = get_dealers_count($user['user_id']);

                            $user['total_sub_dealers'] = get_pharma_count($user['user_id']);

                            $data = $user;

                            //dump($user);
                            //echo 'yearly';die;
                        }
                    }
                }
            }
            
            
            if ($data!=FALSE) 
            { 
                $result = array(
                    'Data' => $data,
                    // 'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
            }
            else 
            {
                $result = array(
                    'Data' => new stdClass(),
                    'Status' => false,
                    'Message' => 'No Record found',
                    'Code' => 404
                );
            }
        } else 
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
    
    public function employee_list_post(){
        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        
        if(empty($post['child']))
        {
        	$msg='Please enter child list.';
        }
                
       	if ($msg == '') 
        {
            $data = $this->report->user_child_team($post['child']);
            if ($data!=FALSE) 
            { 
                $result = array(
                    'Data' => $data,
                    // 'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
            }
            else 
            {
                $result = array(
                    'Data' => new stdClass(),
                    'Status' => false,
                    'Message' => 'No Record found',
                    'Code' => 404
                );
            }
            
        } else 
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
    
    
    public function secondary_report_post(){
        $root_dir = $_SERVER['DOCUMENT_ROOT'].'/bjainpharma/'; 

        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        
        if(empty($post['working_user_id']))
        {
            $msg='Please enter user id.';
        } else if(empty($post['start_date'])){
            $msg='Please enter start date.';
        } else if(empty($post['end_date'])){
            $msg='Please enter end date.';
        }
                
       	if ($msg == '') 
        {
            $month_date = getDatesFromRange($post['start_date'], $post['end_date']);
            //dump($month_date);die;
            
            $doc_secondary_list = json_decode(file_get_contents ($root_dir."ReportJSON/doc_secondary_supply.json"),true);
            $pharma_secondary_list = json_decode(file_get_contents ($root_dir."ReportJSON/phar_secondary_supply.json"),true);

            //dump($doc_secondary_list);die;
            
            $secondary_sum=0;
            
            $doc_secondary = array();
            $pharma_secondary = array();
            
            if(!empty($doc_secondary_list)){

                foreach($doc_secondary_list as $k_c=>$val_c){
                    if($val_c['user_id']==$post['working_user_id']){
                        if(in_array($val_c['date_of_interaction'],$month_date)){
                            if($val_c['secondarysale']!=''){
                                //dump($val_c);die;
                                $val_c['date_of_interaction'] = date('Y/m/d', strtotime($val_c['date_of_interaction']));
                                $var=$val_c['doctorname'];
                                if (stripos($var, 'dr') === 0) {
                                    $val_c['doctorname'] = preg_replace('/dr/', 'Dr. ', strtoupper($var), 1);	}
                                else{
                                    $val_c['doctorname'] = 'Dr. '.strtoupper($var);
                                }
                                
                                $val_c['city_name'] = get_city_name($val_c['city_id']);
                                $secondary_sum=$secondary_sum+$val_c['secondarysale'];
                                $doc_secondary[] = $val_c;
                            }
                        }
                    }
                }
            }
            
            //die('kumar');
            //dump($doc_secondary);die;
            
            if(!empty($pharma_secondary_list)){
                foreach($pharma_secondary_list as $k_c=>$val_c) {
//										pr($val_c); die;
                    if ($val_c['user_id'] == $post['working_user_id']) {
                            if (in_array($val_c['date_of_interaction'], $month_date)) {
                                    if ($val_c['secondarysale'] != '') {
                                        $val_c['date_of_interaction'] = date('Y/m/d', strtotime($val_c['date_of_interaction']));
                                        $val_c['pharmaname'] = strtoupper($val_c['pharmaname']);
                                        $val_c['doctorname'] = get_doctor_name($val_c['city_id']);
                                        $secondary_sum=$secondary_sum+$val_c['secondarysale'];

                                        //$pharma_secondary[] = $val_c;
                                        $doc_secondary[] = $val_c;

                                    }
                            }
                    }
                }
            }
            
            //die('kumar1');
            //dump($pharma_secondary);die;
            //dump($doc_secondary);die;
            //echo $secondary_sum;die;
            
            if ($doc_secondary!=FALSE) 
            { 
                $result = array(
                    'Data' => $doc_secondary,
                    'grand_total' => $secondary_sum,
                    // 'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
            }
            else 
            {
                $result = array(
                    'Data' => new stdClass(),
                    'Status' => false,
                    'Message' => 'No Record found',
                    'Code' => 404
                );
            }
            
        } else 
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
    
    public function salesExecutiveManagerWise_post(){
        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        
        if(empty($post['child']))
        {
        	$msg='Please enter child list.';
        }
                
       	if ($msg == '') 
        {
            $user_list = $this->report->user_child_team($post['child']);
            if ($user_list!=FALSE) 
            { 
                $users=array();
                foreach ($user_list as $list){
                      $details=get_user_deatils($list['userid']);
                      $desgID=$details->user_designation_id;
                      if($desgID=='3' || $desgID=='4' || $desgID=='5' || $desgID=='6'){
                              $users[]=$list;			///All SE list / MR
                      }
                }
                
                if ($users!=FALSE) 
                {
                    $result = array(
                        'Data' => $users,
                        // 'Status' => true,
                        'Message' => 'successfully',
                        'Code' => 200
                    );
                } else 
                {
                    $result = array(
                        'Data' => new stdClass(),
                        'Status' => false,
                        'Message' => 'No Record found',
                        'Code' => 404
                    );
                }
            }
            else 
            {
                $result = array(
                    'Data' => new stdClass(),
                    'Status' => false,
                    'Message' => 'No Record found',
                    'Code' => 404
                );
            }
            
        } else 
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
    
    
    public function dearlist_post(){
        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        
        if(!isset($post['userCity']))
        {
        	$msg='Please enter user city.';
        }
        
        if(empty($post['child']))
        {
        	$msg='Please enter user child.';
        }
        
        if(empty($post['userDesig']))
        {
        	$msg='Please enter user designation.';
        }
        
        if(empty($post['userId']))
        {
        	$msg='Please enter user id.';
        }
                
        if(empty($post['sp_code']))
        {
        	$msg='Please enter user sp code.';
        }
                
       	if ($msg == '') 
        {
            $finalData = array();
            $dealer_list = $this->report->dealermaster_info('','', '','','');
            $dealer_list = json_decode($dealer_list);
            //dump($dealer_list);die('here');
            $pharma_list = $this->report->pharmacy_list(logged_user_cities($post['userCity']));
            //dump($pharma_list);die;
            
            $usr_sp_codes = $this->report->userSpCode(logged_user_cities($post['userCity']));
            //dump($usr_sp_codes);die;
            
            foreach($dealer_list as $k_cul=>$val_cul){
                
                if(in_array($val_cul->sp_code,$usr_sp_codes)){
                    $finalData[] = $val_cul;
                }
            }
            //dump($finalData);die;
           
            foreach ($pharma_list as $k_ph => $va_phr) {
                if (in_array($va_phr['sp_code'], $usr_sp_codes)) {
                    $finalData[] = $va_phr;
                }
            }
           
            //dump($finalData);die;
            
            if ($finalData!=FALSE) 
            { 
                $result = array(
                    'Data' => $finalData,
                    // 'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
            }
            else 
            {
                $result = array(
                    'Data' => new stdClass(),
                    'Status' => false,
                    'Message' => 'No Record found',
                    'Code' => 404
                );
            }
            
        } else 
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
    
    
    public function dealer_subdealer_report_post(){
        $root_dir = $_SERVER['DOCUMENT_ROOT'].'/bjainpharma/'; 
        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        
        if(empty($post['dealer_user_id']))
        {
            $msg='Please enter dealer id.';
        } else if(empty($post['start_date'])){
            $msg='Please enter start date.';
        } else if(empty($post['end_date'])){
            $msg='Please enter end date.';
        }
                
       	if ($msg == '') 
        {
            $month_date = getDatesFromRange($post['start_date'], $post['end_date']);
            //dump($month_date);die;
            
            $dealerID = $post['dealer_user_id'];
            $dealer_name=get_dealer_name($dealerID);
            if($dealer_name==' '){
              $dealer_name = get_pharmacy_name($dealerID);
            }else{
              //$dealer_name = $dealer_name;
            }
            //echo $dealer_name;die;
            $doc_secondary_list = json_decode(file_get_contents ($root_dir."ReportJSON/doc_secondary_supply.json"),true);
            $pharma_secondary_list = json_decode(file_get_contents ($root_dir."ReportJSON/phar_secondary_supply.json"),true);

            //dump($doc_secondary_list);die;
            
            $secondary_sum=0;
            
            $doc_secondary = array();
            $pharma_secondary = array();
            
            if(!empty($doc_secondary_list)){

                foreach($doc_secondary_list as $k_c=>$val_c){
                    if( $val_c['dealer_name']==$dealer_name  ){
                        if(in_array($val_c['date_of_interaction'],$month_date)){
                            if($val_c['secondarysale']!=''){                                
                                $val_c['date_of_interaction'] = date('Y/m/d', strtotime($val_c['date_of_interaction']));
                                $val_c['doctorname'] = $val_c['doctorname'];
                                $val_c['city_name'] = get_city_name($val_c['city_id']);
                                $val_c['suppliedto'] = get_user_name($val_c['user_id']);
                                
                                $secondary_sum=$secondary_sum+$val_c['secondarysale'];
                                //dump($val_c);die;
                                //$pharma_secondary[] = $val_c;
                                $doc_secondary[] = $val_c;
                            }
                        }
                    }
                }
            }
            
            //die('kumar');
            //dump($doc_secondary);die;
            
            if(!empty($pharma_secondary_list)){
                foreach($pharma_secondary_list as $k_c=>$val_c) {
//										pr($val_c); die;
                    if ($val_c['pharmaname'] == $dealer_name) {
                            if (in_array($val_c['date_of_interaction'], $month_date)) {
                                    if ($val_c['secondarysale'] != '') {
                                        $val_c['date_of_interaction'] = date('Y/m/d', strtotime($val_c['date_of_interaction']));
                                        $val_c['doctorname'] = $val_c['pharmaname'];
                                        $val_c['city_name'] = get_doctor_name($val_c['city_id']);
                                        $val_c['suppliedto'] = get_user_name($val_c['user_id']);
                                        //dump($val_c);die;
                                        $secondary_sum=$secondary_sum+$val_c['secondarysale'];

                                        //$pharma_secondary[] = $val_c;
                                        $doc_secondary[] = $val_c;

                                    }
                            }
                    }
                }
            }
            
            //die('kumar1');
            //dump($pharma_secondary);die;
            //dump($doc_secondary);die;
            //echo $secondary_sum;die;
            
            if ($doc_secondary!=FALSE) 
            { 
                $result = array(
                    'Data' => $doc_secondary,
                    'grand_total' => $secondary_sum,
                    // 'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
            }
            else 
            {
                $result = array(
                    'Data' => new stdClass(),
                    'Status' => false,
                    'Message' => 'No Record found',
                    'Code' => 404
                );
            }
            
        } else 
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
    
    public function secondary_supply_report_post(){
        $root_dir = $_SERVER['DOCUMENT_ROOT'].'/bjainpharma/'; 
        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        
        if(empty($post['user_id']))
        {
            $msg='Please enter user id.';
        } 
                
       	if ($msg == '') 
        {
            
            
            /*
            $dealerID = $post['dealer_user_id'];
            $dealer_name=get_dealer_name($dealerID);
            if($dealer_name==' '){
              $dealer_name = get_pharmacy_name($dealerID);
            }else{
              //$dealer_name = $dealer_name;
            }
             * /
             */
            
            //echo $dealer_name;die;            
            $doc_secondary_list = json_decode(file_get_contents ($root_dir."ReportJSON/doc_secondary_supply.json"),true);
            $pharma_secondary_list = json_decode(file_get_contents ($root_dir."ReportJSON/phar_secondary_supply.json"),true);

            //dump($doc_secondary_list);die;
            
            $secondary_sum=0;
            
            $doc_secondary = array();
            $pharma_secondary = array();
            
            $userID=$post['user_id'];
            $childs=get_child_user($userID);
            if(empty($childs)){
                    $allchilds = $userID;
            }else{
                    $uid=array($userID);
                    $allchilds = array_merge($uid,$childs);		//Including user itself with childs
            }
            //dump($allchilds);die;
            $chCount=count($allchilds);
            
            if(!empty($doc_secondary_list)){

                foreach($doc_secondary_list as $k_c=>$val_c){
                    if($chCount > 1){
                        if(in_array($val_c['user_id'], $allchilds)){
                            if($val_c['secondarysale']!=''){
                                
                                if((!empty($post['start_date'])) && (!empty($post['end_date']))){
                                    $month_date = getDatesFromRange($post['start_date'], $post['end_date']);
                                    //dump($month_date);die;   
                                    if (in_array($val_c['date_of_interaction'], $month_date)) {
                                        $val_c['date_of_interaction'] = date('Y/m/d', strtotime($val_c['date_of_interaction']));
                                        $val_c['name_of_mr_se'] = get_user_name($val_c['user_id']);
                                        $val_c['doctorname'] = $val_c['doctorname'];

                                        if($val_c['close_status']==0){
                                            $val_c['action'] = 'Supply';
                                        } else {
                                            $val_c['action'] = 'Closed';
                                        }

                                        $secondary_sum=$secondary_sum+$val_c['secondarysale'];
                                        //dump($val_c);die;
                                        //$pharma_secondary[] = $val_c;
                                        $doc_secondary[] = $val_c;
                                    }
                                } else if(!empty($post['doctor_name'])){
                                    if ($val_c['doctorname'] == $post['doctor_name']) {
                                        $val_c['date_of_interaction'] = date('Y/m/d', strtotime($val_c['date_of_interaction']));
                                        $val_c['name_of_mr_se'] = get_user_name($val_c['user_id']);
                                        $val_c['doctorname'] = $val_c['doctorname'];

                                        if($val_c['close_status']==0){
                                            $val_c['action'] = 'Supply';
                                        } else {
                                            $val_c['action'] = 'Closed';
                                        }

                                        $secondary_sum=$secondary_sum+$val_c['secondarysale'];
                                        //dump($val_c);die;
                                        //$pharma_secondary[] = $val_c;
                                        $doc_secondary[] = $val_c;
                                    }
                                
                                } else if(!empty($post['dealer_name'])){
                                    if ($val_c['dealer_name'] == $post['dealer_name']) {
                                        $val_c['date_of_interaction'] = date('Y/m/d', strtotime($val_c['date_of_interaction']));
                                        $val_c['name_of_mr_se'] = get_user_name($val_c['user_id']);
                                        $val_c['doctorname'] = $val_c['doctorname'];

                                        if($val_c['close_status']==0){
                                            $val_c['action'] = 'Supply';
                                        } else {
                                            $val_c['action'] = 'Closed';
                                        }

                                        $secondary_sum=$secondary_sum+$val_c['secondarysale'];
                                        //dump($val_c);die;
                                        //$pharma_secondary[] = $val_c;
                                        $doc_secondary[] = $val_c;
                                    }
                                } else {
                                    $val_c['date_of_interaction'] = date('Y/m/d', strtotime($val_c['date_of_interaction']));
                                    $val_c['name_of_mr_se'] = get_user_name($val_c['user_id']);
                                    $val_c['doctorname'] = $val_c['doctorname'];

                                    if($val_c['close_status']==0){
                                        $val_c['action'] = 'Supply';
                                    } else {
                                        $val_c['action'] = 'Closed';
                                    }

                                    $secondary_sum=$secondary_sum+$val_c['secondarysale'];
                                    //dump($val_c);die;
                                    //$pharma_secondary[] = $val_c;
                                    $doc_secondary[] = $val_c;
                                }
                            }
                        }
                    }
                }
            }
            
            //die('kumar');
            //dump($doc_secondary);die;
            
            if(!empty($pharma_secondary_list)){
                foreach($pharma_secondary_list as $k_c=>$val_c) {
                    if($chCount > 1){
                        if(in_array($val_c['user_id'], $allchilds)){								
                            //pr($val_c); die;
                            if($val_c['secondarysale']!=''){
                                if((!empty($post['start_date'])) && (!empty($post['end_date']))){
                                    $month_date = getDatesFromRange($post['start_date'], $post['end_date']);
                                    //dump($month_date);die;   
                                    if (in_array($val_c['date_of_interaction'], $month_date)) {
                                        $val_c['date_of_interaction'] = date('Y/m/d', strtotime($val_c['date_of_interaction']));
                                        $val_c['name_of_mr_se'] = get_user_name($val_c['user_id']);
                                        $val_c['doctorname'] = $val_c['pharmaname'];

                                        if($val_c['close_status']==0){
                                            $val_c['action'] = 'Supply';
                                        } else {
                                            $val_c['action'] = 'Closed';
                                        }

                                        //dump($val_c);die;
                                        $secondary_sum=$secondary_sum+$val_c['secondarysale'];

                                        //$pharma_secondary[] = $val_c;
                                        $doc_secondary[] = $val_c;
                                    }
                                } else if(!empty($post['doctor_name'])){
                                    //dump($val_c['pharmaname']);
                                    
                                    if ($val_c['pharmaname'] == $post['doctor_name']) { 
                                        $val_c['date_of_interaction'] = date('Y/m/d', strtotime($val_c['date_of_interaction']));
                                        $val_c['name_of_mr_se'] = get_user_name($val_c['user_id']);
                                        $val_c['doctorname'] = $val_c['pharmaname'];

                                        if($val_c['close_status']==0){
                                            $val_c['action'] = 'Supply';
                                        } else {
                                            $val_c['action'] = 'Closed';
                                        }

                                        
                                        $secondary_sum=$secondary_sum+$val_c['secondarysale'];

                                        //$pharma_secondary[] = $val_c;
                                        $doc_secondary[] = $val_c;
                                    }
                                    
                                } else if(!empty($post['dealer_name'])){
                                    if ($val_c['dealer_name'] == $post['dealer_name']) {
                                        $val_c['date_of_interaction'] = date('Y/m/d', strtotime($val_c['date_of_interaction']));
                                        $val_c['name_of_mr_se'] = get_user_name($val_c['user_id']);
                                        $val_c['doctorname'] = $val_c['pharmaname'];

                                        if($val_c['close_status']==0){
                                            $val_c['action'] = 'Supply';
                                        } else {
                                            $val_c['action'] = 'Closed';
                                        }

                                        //dump($val_c);
                                        $secondary_sum=$secondary_sum+$val_c['secondarysale'];

                                        //$pharma_secondary[] = $val_c;
                                        $doc_secondary[] = $val_c;
                                    }
                                } else {
                                    $val_c['date_of_interaction'] = date('Y/m/d', strtotime($val_c['date_of_interaction']));
                                    $val_c['name_of_mr_se'] = get_user_name($val_c['user_id']);
                                    $val_c['doctorname'] = $val_c['pharmaname'];

                                    if($val_c['close_status']==0){
                                        $val_c['action'] = 'Supply';
                                    } else {
                                        $val_c['action'] = 'Closed';
                                    }

                                    //dump($val_c);
                                    $secondary_sum=$secondary_sum+$val_c['secondarysale'];

                                    //$pharma_secondary[] = $val_c;
                                    $doc_secondary[] = $val_c;
                                }
                            }
                        }
                    }
                }
            }
            
            //die('kumar1');
            //dump($pharma_secondary);die;
            //dump($doc_secondary);die;
            //echo $secondary_sum;die;
            
            if ($doc_secondary!=FALSE) 
            { 
                $result = array(
                    'Data' => $doc_secondary,
                    'grand_total' => $secondary_sum,
                    // 'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
            }
            else 
            {
                $result = array(
                    'Data' => new stdClass(),
                    'Status' => false,
                    'Message' => 'No Record found',
                    'Code' => 404
                );
            }
            
        } else 
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
    
    public function check_leaves_post(){
        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        
        if(empty($post['date']))
        {
        	$msg='Please enter date.';
        }
        
        if(empty($post['userId']))
        {
        	$msg='Please enter user id.';
        }
        
       	if ($msg == '') 
        {
            $data = get_leaves_deatils($post['userId'],$post['date']);
            if($data!=FALSE)
            { 
                $result = array(
                    'Data' => $data,
                    'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
            }
            else 
            {
                $result = array(
                    'Data' => new stdClass(),
                    'Status' => false,
                //    'Message' => 'You already filled the interaction on Same date and City.',
                    'Code' => 404
                );
            }
            
        } else 
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
   
    public function check_holidays_post(){
        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        
        if(empty($post['date']))
        {
        	$msg='Please enter date.';
        }
        
        if(empty($post['userId']))
        {
        	$msg='Please enter user id.';
        }
        
       	if ($msg == '') 
        {
            $data = get_holiday_details($post['userId'],$post['date']);
            if($data!=FALSE)
            { 
                $result = array(
                    'Data' => $data,
                    'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
            }
            else 
            {
                $result = array(
                    'Data' => new stdClass(),
                    'Status' => false,
                //    'Message' => 'You already filled the interaction on Same date and City.',
                    'Code' => 404
                );
            }
            
        } else 
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
    
    public function list_of_doctor_post(){
        $post = array_map('trim', $this->input->post());
        
        $date='';$city='';
        
        $msg = '';
        $data = false;
        
        if(empty($post['date']))
        {
        	$msg='Please enter date of intruction.';
        }
        
        if(empty($post['userId']))
        {
        	$msg='Please enter user id.';
        }
        
        if(empty($post['interaction_city']))
        {
        	$msg='Please enter interaction city.';
        }
        
       	if ($msg == '') 
        {
            if($date=='' || $city=='')	{
                if(check_serialize_date($post['date'], logged_user_data($post['userId']),$post['interaction_city'])){
                    $datablank='';
                    $page='';
                    $per_page='';
                    $result = $this->report->doctormaster_info($per_page, $page,$datablank,$post['interaction_city'],$post['userDesig'], $post['userId'], $post['userCity']);
                    $result = json_decode($result);
                    foreach($result as $val_c){
                        $val_c->city_name = get_city_name($val_c->city_id);
                        $data[] = $val_c;
                    }
                } else {
                    $msg = "You already filled the interaction on Same date and City.";
                }
            }else{
                
            }
            
            if($data!=FALSE)
            { 
                $result = array(
                    'Data' => $data,
                    'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
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
            
        } else 
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
    
    public function list_of_tp_post(){
        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        $data = false;
        
        if(empty($post['userId']))
        {
        	$msg='Please enter user id.';
        }
        
        
       	if ($msg == '') 
        {
           
            $data = $this->report->tour_info($post['userId']);
            
            if($data!=FALSE)
            { 
                $result = array(
                    'Data' => $data,
                    'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
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
            
        } else 
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
    
    public function assign_city_list_post(){
        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        $data = false;
        
        if(empty($post['userId']))
        {
        	$msg='Please enter user id.';
        }
        
        if(empty($post['sp_code']))
        {
        	$msg='Please enter sp code.';
        }
        
       	if ($msg == '') 
        {
            $data =  get_all_city($post['sp_code']);
			$temp = array();
            $array = array('city_name' => 'Select city name');
			$temp[] =  $array;
			//pr($temp);die;
			$d = NULL;
						
			IF((!empty($temp)) && (!empty($data))){
				$d = array_merge($temp,$data);
			}
			
			//pr($d);die;
            //$data[0] = $array;
            
            //dump($data);die;
            if($d!=FALSE)
            { 
                $result = array(
                    'Data' => $d,
                    'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
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
            
        } else 
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
    
    public  function sample_list_post(){
        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        $data = false;
        
        if(empty($post['userDesig']))
        {
        	$msg='Please enter user designation.';
        }
        
        
       	if ($msg == '') 
        {
         
            $data =  $this->report->sample_list(null, $post['userDesig']);
            //dump($data);die;
            if($data!=FALSE)
            { 
                $result = array(
                    'Data' => $data,
                    'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
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
            
        } else 
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
    
    public function passcode_status_post(){
        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        $data = false;
        
        if(empty($post['userId']))
        {
        	$msg='Please enter user id.';
        }
        
        
       	if ($msg == '') 
        {
         
            $data =  $this->report->validate_passcode_status($post['userId']);
            //dump($data);die;
            if($data!=FALSE)
            { 
                $result = array(
                    'Data' => $data,
                    'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
            }
            else 
            {
                $result = array(
                    'Data' => new stdClass(),
                    'Status' => false,
                    'Message' => $msg,
                    'Code' => 202
                );
            }
            
        } else 
        {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 202
            );
        }
        
        $this->response($result);
    }
    
    public function save_passcode_post(){
        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        $data = false;
        
        if(empty($post['userId']))
        {
        	$msg='Please enter user id.';
        }
        
        if(empty($post['passcode']))
        {
        	$msg='Please enter passcode.';
        } else {
            if(strlen($post['passcode']) != 4){
                $msg='Passcode length should 4 digit.';
            }
        }
        
        
       	if ($msg == '') 
        {
         
            $data =  $this->report->save_passcode($post['userId'], $post['passcode']);
            //dump($data);die;
            if($data!=FALSE)
            { 
                $result = array(
                    'Data' => $data,
                    'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
            }
            else 
            {
                $result = array(
                    'Data' => new stdClass(),
                    'Status' => false,
                    'Message' => $msg,
                    'Code' => 202
                );
            }
            
        } else 
        {
            $result = array(
                'Data' => new stdClass(),
                'Status' => false,
                'Message' => $msg,
                'Code' => 202
            );
        }
        
        $this->response($result);
    }
    
    public function get_google_distance_post(){
        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        $data = false;
        
        if(empty($post['userId']))
        {
        	$msg='Please enter user id.';
        }
        
        if(empty($post['from']))
        {
        	$msg='Please enter source pin.';
        }
        
        if(empty($post['to']))
        {
        	$msg='Please enter destination pin.';
        }
                
       	if ($msg == '') 
        {
            $from = $post['from'];
            $to = $post['to'];
            
            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=$from&destinations=$to&key=AIzaSyBW4XD3HI9gZfK-J36dRizXrw6ynJ_ztJI";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);

            $response_a = json_decode($response);
            $status = $response_a->status;
            //die;
            if ($status == 'OK' && $response_a->rows[0]->elements[0]->status == 'OK')
            {
               //dump($response_a);die;
               //return $data=explode(' ',$response_a->rows[0]->elements[0]->distance->text)[0];
                $data=$response_a;
            }
            else
            {
                $data=0;
            }
            //$data =  get_distance_hq($post['userId'], 100);
            //dump($data);die;
            if($data!=FALSE)
            { 
                $result = array(
                    'Data' => $data,
                    'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
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
            
        } else 
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
    
    public function get_user_headquater_post(){
        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        $data = false;
        
        if(empty($post['userId']))
        {
        	$msg='Please enter user id.';
        }
                
       	if ($msg == '') 
        {
            
            $data =  get_user_headquater($post['userId']);
            //dump($data);die;
            if($data!=FALSE)
            { 
                $result = array(
                    'Data' => $data,
                    'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
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
            
        } else 
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
    
    public function get_potency_post(){
        $post = array_map('trim', $this->input->post());
        
        $msg = '';
        $data = false;
        
        if(empty($post['userId']))
        {
        	$msg='Please enter user id.';
        }
                
       	if ($msg == '') 
        {
            
            $data =  get_user_headquater($post['userId']);
            //dump($data);die;
            if($data!=FALSE)
            { 
                $result = array(
                    'Data' => $data,
                    'Status' => true,
                    'Message' => 'successfully',
                    'Code' => 200
                );
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
            
        } else 
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
    
    
}

