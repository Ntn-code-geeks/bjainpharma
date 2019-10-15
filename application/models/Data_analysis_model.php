<?php



/* 

 * Niraj Kumar

 * Dated: 11-nov-2017

 * 

 * model for data analysis for customer,team 

 */



class Data_analysis_model extends CI_Model {
    
    
      /*
     * Developer: Shailesh Saraswat
     * Email: sss.shailesh@gmail.com
     * Dated: 28-12-2018 
     * 
     *  for the NoT MET highest and lowest report
     */ 
    public function not_met_analysis($data=''){
        
         if($data!=''){

             $start = date('Y-m-d', strtotime($data));

            }
            else{

             $start = date('Y-m-d', strtotime('-7 days'));

            }
          $end = date('Y-m-d')." 23:59:59";
        
        
        $arr = 'DISTINCT(count(pid.id)) as produtive_call,pu.name as empname';
        $this->db->select($arr);
        $this->db->from('pharma_interaction_doctor pid');
        $this->db->join('pharma_users pu','pid.crm_user_id=pu.id');
        $this->db->where('pid.meeting_sale',NULL,true);
        
              
        $this->db->where('pid.meet_or_not_meet',0);
        
         $this->db->where('pid.create_date >=', $start);

         $this->db->where('pid.create_date <=', $end);
        
         if(logged_user_child()){
             $child_emp = explode(',', logged_user_child());
             $this->db->where_in('pid.crm_user_id', $child_emp);
         }
       
        $this->db->group_by('pid.crm_user_id'); 
        $this->db->order_by('count(pid.id)','DESC');
//        $this->db->limit(1,0);
        
         $query = $this->db->get();

//               echo $this->db->last_query(); die;

        if($this->db->affected_rows()){
                       $doctor_result = $query->result_array();
                       
                       $heighest = $doctor_result[0];
                       
                       $lowest =  $doctor_result[count($doctor_result)-1];
                      
                    $not_met = array(
                                            'highest'=>$heighest,
                                            'lowest'=>$lowest,    
                                          );
                                    
                  return json_encode($not_met);           
                  
              }else{
                  
                     return FALSE;
                     
              }
        
        
        
    }
    
    
    
      /*
     * Developer: Shailesh Saraswat
     * Email: sss.shailesh@gmail.com
     * Dated: 28-12-2018 
     * 
     *  for the No Order But MET highest and lowest report
     */ 
    public function noorder_met_analysis($data=''){
        
         if($data!=''){

             $start = date('Y-m-d', strtotime($data));

            }
            else{

             $start = date('Y-m-d', strtotime('-7 days'));

            }
          $end = date('Y-m-d')." 23:59:59";
        
        
        $arr = 'DISTINCT(count(pid.id)) as produtive_call,pu.name as empname';
        $this->db->select($arr);
        $this->db->from('pharma_interaction_doctor pid');
        $this->db->join('pharma_users pu','pid.crm_user_id=pu.id');
        $this->db->where('pid.meeting_sale',NULL,true);
        $extra_where =' ( pid.meet_or_not_meet IS NULL OR pid.meet_or_not_meet=1 )';
              
        $this->db->where($extra_where);
        
         $this->db->where('pid.create_date >=', $start);

         $this->db->where('pid.create_date <=', $end);
        
         if(logged_user_child()){
             $child_emp = explode(',', logged_user_child());
             $this->db->where_in('pid.crm_user_id', $child_emp);
         }
       
        $this->db->group_by('pid.crm_user_id'); 
        $this->db->order_by('count(pid.id)','DESC');
//        $this->db->limit(1,0);
        
         $query = $this->db->get();

//               echo $this->db->last_query(); die;

        if($this->db->affected_rows()){
                       $doctor_result = $query->result_array();
                       
                       $heighest = $doctor_result[0];
                       
                       $lowest =  $doctor_result[count($doctor_result)-1];
                      
                    $noorder_met = array(
                                            'highest'=>$heighest,
                                            'lowest'=>$lowest,    
                                          );
                                    
                  return json_encode($noorder_met);           
                  
              }else{
                  
                     return FALSE;
                     
              }
        
        
        
    }
    
    
     /*
     * Developer: Shailesh Saraswat
     * Email: sss.shailesh@gmail.com
     * Dated: 28-12-2018 
     * 
     *  for the Productive call highest and lowest report
     */ 
    public function productive_analysis($data=''){
        
         if($data!=''){

             $start = date('Y-m-d', strtotime($data));

            }
            else{

             $start = date('Y-m-d', strtotime('-7 days'));

            }
          $end = date('Y-m-d')." 23:59:59";
        
        
        $arr = 'DISTINCT(count(pid.id)) as produtive_call,pu.name as empname';
        $this->db->select($arr);
        $this->db->from('pharma_interaction_doctor pid');
        $this->db->join('pharma_users pu','pid.crm_user_id=pu.id');
        $this->db->where('pid.meeting_sale IS NOT NULL',NULL,false);
         $this->db->where('pid.create_date >=', $start);

         $this->db->where('pid.create_date <=', $end);
        
         if(logged_user_child()){
             $child_emp = explode(',', logged_user_child());
             $this->db->where_in('pid.crm_user_id', $child_emp);
         }
       
        $this->db->group_by('pid.crm_user_id'); 
        $this->db->order_by('count(pid.id)','DESC');
//        $this->db->limit(1,0);
        
         $query = $this->db->get();

//               echo $this->db->last_query(); die;

        if($this->db->affected_rows()){
                       $doctor_result = $query->result_array();
                       
                       $heighest = $doctor_result[0];
                       
                       $lowest =  $doctor_result[count($doctor_result)-1];
                      
                    $prodcutive_call = array(
                                            'highest'=>$heighest,
                                            'lowest'=>$lowest,    
                                          );
                                    
                  return json_encode($prodcutive_call);           
                  
              }else{
                  
                     return FALSE;
                     
              }
        
        
        
    }
    
    
     /*
     * Developer: Nitin kumar
     * Dated: 09-10-2019
     * 
     *  for the secondary highest and lowest report
     */ 
//    public function secondary_analysis($data=''){
//
//         if($data!=''){
//             $start = date('Y-m-d', strtotime($data));
//            }
//            else{
//             $start = date('Y-m-d', strtotime('-7 days'));
//            }
//          $end = date('Y-m-d')." 23:59:59";
//
//        $arr = 'pid.crm_user_id as usr_id,pu.name as empname,pid.meeting_sale';
//        $this->db->select($arr);
//		$this->db->from('pharma_interaction_doctor pid');
//        $this->db->join('pharma_users pu','pid.crm_user_id=pu.id');
//        $this->db->where('pid.meeting_sale IS NOT NULL',NULL,false);
//		 $this->db->where('pid.create_date >=', $start);
//
//         $this->db->where('pid.create_date <=', $end);
//
//         if(logged_user_child()){
//             $child_emp = explode(',', logged_user_child());
//             $this->db->where_in('pid.crm_user_id', $child_emp);
//         }
////		$this->db->group_by("pid.crm_user_id");
////		$this->db->limit(3,0);
//		$this->db->order_by('pid.meeting_sale','DESC');
//
//         $query = $this->db->get();
////               echo $this->db->last_query(); echo "<br><br>";
//        if($this->db->affected_rows()){
//                       $heighest = $query->result_array();
//                        $arr = 'pid.crm_user_id as usr_id,pu.name as empname,pid.meeting_sale';
//						$this->db->select($arr);
//						$this->db->from('pharma_interaction_doctor pid');
//						$this->db->join('pharma_users pu','pid.crm_user_id=pu.id');
//						$this->db->where('pid.meeting_sale IS NOT NULL',NULL,false);
//						$this->db->where('pid.meeting_sale != ',0,FALSE);
//						 $this->db->where('pid.create_date >=', $start);
//
//						 $this->db->where('pid.create_date <=', $end);
//						  if(logged_user_child()){
//									$child_emp = explode(',', logged_user_child());
//									$this->db->where_in('pid.crm_user_id', $child_emp);
//								}
//								$this->db->group_by("pid.create_date");
////								$this->db->limit(3,0);
//						$this->db->order_by('pid.meeting_sale','asc');
//
////                                 $query2 = $this->db->get();
//						 $query2 = $this->db->get();
//							if($this->db->affected_rows()){
//								$lowest = $query2->result_array();
//							}else{
//								$lowest = array();
//							}
//
//
//
//                    	 $secondry_sale = array(
//							'highest'=>$heighest,
//							'lowest'=>$lowest,
//						  );
//
//                                          return json_encode($secondry_sale);
//
//              }else{
//
//                     return FALSE;
//
//              }
//
//
//
//    }
    public function secondary_analysis($data=''){
    		/*Monthly*/
			$data_monthly = json_decode(file_get_contents ("ReportJSON/monthly.json"));
			foreach ($data_monthly  as $monthly){
				if(logged_user_child()){
					$child_emp = explode(',', logged_user_child());
					if(in_array($monthly->user_id,$child_emp)){
						$data_arr[]=array(
							'user_id'  =>	$monthly->user_id,
							'username' =>   $monthly->username,
							'secondary' =>  $monthly->total_secondary,
						);
					}
				}else{
//					$child_emp = logged_user_data();
					if(is_admin()){
						$data_arr[]=array(
							'user_id'  =>	$monthly->user_id,
							'username' =>   $monthly->username,
							'secondary' =>  $monthly->total_secondary,
						);
					}



				}
			}
			$dates=array();
			foreach ($data_arr as $key => $row) {
				$dates[$key]  = str_replace(',','',$row['secondary']);
			}
			array_multisort($dates, SORT_DESC, $data_arr);
			$month=$data_arr;

			array_multisort($dates, SORT_ASC, $data_arr);
			$month_lowest=$data_arr;

			$amount_list_mt=array();
			foreach($month_lowest as $key => $list ) {
				if($list['secondary'] > 0){
					$amount_list_mt[$key] = $list;
				}
			}
			$re_amount_mt=array_values($amount_list_mt);
			$month_low = $re_amount_mt;


			/*Quarterly*/
			$data_quarterly = json_decode(file_get_contents ("ReportJSON/quarterly.json"));
			foreach ($data_quarterly  as $quater){
				if(logged_user_child()) {
					$child_emp = explode(',', logged_user_child());
					if(in_array($quater->user_id,$child_emp)){
						$data_arr1[]=array(
							'user_id'  =>	$quater->user_id,
							'username' =>   $quater->username,
							'secondary' =>  $quater->total_secondary,
						);
					}
				}else{
					if(is_admin()){
						$data_arr1[]=array(
							'user_id'  =>	$quater->user_id,
							'username' =>   $quater->username,
							'secondary' =>  $quater->total_secondary,
						);
					}
				}
			}
			$dates1=array();
			foreach ($data_arr1 as $key => $row) {
				$dates1[$key]  = str_replace(',','',$row['secondary']);
			}
			array_multisort($dates1, SORT_DESC, $data_arr1);
			$quart=$data_arr1;

			array_multisort($dates1, SORT_ASC, $data_arr1);
			$quarter_lowest=$data_arr1;

			$amount_list_qut=array();
			foreach($quarter_lowest as $key => $list ) {
				if($list['secondary'] > 0){
					$amount_list_qut[$key] = $list;
				}
			}
			$re_amount_quat=array_values($amount_list_qut);
			$quart_low = $re_amount_quat;



		/*Yearly*/
			$data_yearly = json_decode(file_get_contents ("ReportJSON/yearly.json"));
			foreach ($data_yearly  as $yearly){
				if(logged_user_child()) {
					$child_emp = explode(',', logged_user_child());
					if(in_array($yearly->user_id,$child_emp)){
						$data_arr2[]=array(
							'user_id'  =>	$yearly->user_id,
							'username' =>   $yearly->username,
							'secondary' =>  $yearly->total_secondary,
						);
					}
				}else{
					if(is_admin()){
						$data_arr2[]=array(
							'user_id'  =>	$yearly->user_id,
							'username' =>   $yearly->username,
							'secondary' =>  $yearly->total_secondary,
						);
					}
				}
			}
			$dates2=array();
			foreach ($data_arr2 as $key => $row) {
				$dates2[$key]  = str_replace(',','',$row['secondary']);
			}
			array_multisort($dates2, SORT_DESC, $data_arr2);
			$year=$data_arr2;

			array_multisort($dates2, SORT_ASC, $data_arr2);
			$yearly_lowest=$data_arr2;

			$amount_list_yr=array();
			foreach($yearly_lowest as $key => $list ) {
				if($list['secondary'] > 0){
					$amount_list_yr[$key] = $list;
				}
			}
			$re_amount_year=array_values($amount_list_yr);
			$year_low = $re_amount_year;

		    /*Weekly*/
			$data_weekly = json_decode(file_get_contents ("ReportJSON/weekly.json"));
			foreach ($data_weekly  as $weekly){
				if(logged_user_child()) {
					$child_emp = explode(',', logged_user_child());
					if(in_array($weekly->user_id,$child_emp)){
						$data_arr3[]=array(
							'user_id'  =>	$weekly->user_id,
							'username' =>   $weekly->username,
							'secondary' =>  $weekly->total_secondary,
						);
					}
				}else{
					//$child_emp = logged_user_data();
					if(is_admin()){
						$data_arr3[]=array(
							'user_id'  =>	$weekly->user_id,
							'username' =>   $weekly->username,
							'secondary' =>  $weekly->total_secondary,
						);
					}
				}
			}
			$dates3=array();
			foreach ($data_arr3 as $key => $row) {
				$dates3[$key]  = str_replace(',','',$row['secondary']);
			}
			array_multisort($dates3, SORT_DESC, $data_arr3);
			$week=$data_arr3;

			array_multisort($dates3, SORT_ASC, $data_arr3);
			$weekly_lowest=$data_arr3;

			$amount_list_d=array();
			foreach($weekly_lowest as $key => $list ) {
				if($list['secondary'] > 0){
					$amount_list_d[$key] = $list;
				}
			}
			$re_amount_ind=array_values($amount_list_d);
			$week_low=$re_amount_ind;

		$dataArray=array(
			'weekly' => (array_slice($week, 0, 3)),
			'monthly' => (array_slice($month, 0, 3)),
			'quarter' => (array_slice($quart, 0, 3)),
			'yearly' => (array_slice($year, 0, 3)),

			'low_week' => (array_slice($week_low, 0, 3)),
			'low_month' => (array_slice($month_low, 0, 3)),
			'low_quart' => (array_slice($quart_low, 0, 3)),
			'low_year' => (array_slice($year_low, 0, 3)),
		);

		return json_encode($dataArray);

	}

    public function dealer_secondary($data=''){
    	if($data!=''){
			$start = date('Y-m-d', strtotime($data));
		}else{
			$start = date('Y-m-d', strtotime('-7 days'));
		}
		$end = date('Y-m-d')." 23:59:59";

		$doc_secondary_list=json_decode(file_get_contents("ReportJSON/doc_secondary_supply.json"),true);
		$dealer_list=array();
		$pharma_list=array();
		$top3=array();
		$child_usr=get_check_active_users(explode(', ',logged_user_child()));
		foreach ($doc_secondary_list as $doc_sec){


			if(is_admin()){
					$patDate=date('Y-m-d', strtotime($doc_sec['date_of_interaction']));
					if (($patDate >= $start) && ($patDate <= $end)){
						if($doc_sec['pharmaname']){
							$pharma_list[]=array(
								'dealer_name' => $doc_sec['pharmaname'],
								'secondary_amt' => $doc_sec['secondarysale']
							);
						}else{
							$dealer_list[]=array(
								'dealer_name' => $doc_sec['dealer_name'],
								'secondary_amt' => $doc_sec['secondarysale']
							);
						}
					}
			}
			else if(!empty($child_usr)){
				if(in_array($doc_sec['user_id'],$child_usr)){
					$patDate=date('Y-m-d', strtotime($doc_sec['date_of_interaction']));
					if (($patDate >= $start) && ($patDate <= $end)){
						if($doc_sec['pharmaname']){
							$pharma_list[]=array(
								'dealer_name' => $doc_sec['pharmaname'],
								'secondary_amt' => $doc_sec['secondarysale']
							);
						}else{
							$dealer_list[]=array(
								'dealer_name' => $doc_sec['dealer_name'],
								'secondary_amt' => $doc_sec['secondarysale']
							);
						}

					}
				}
			}
			else{
				if($doc_sec['user_id']==logged_user_data()){
					$patDate=date('Y-m-d', strtotime($doc_sec['date_of_interaction']));
					if (($patDate >= $start) && ($patDate <= $end)){
						if($doc_sec['pharmaname']){
							$pharma_list[]=array(
								'dealer_name' => $doc_sec['pharmaname'],
								'secondary_amt' => $doc_sec['secondarysale']
							);
						}else{
							$dealer_list[]=array(
								'dealer_name' => $doc_sec['dealer_name'],
								'secondary_amt' => $doc_sec['secondarysale']
							);
						}

					}
				}
			}
		}

		$deal_list=array_merge($dealer_list,$pharma_list);

		$result_d=array();
		foreach ($deal_list as $value_d){
			if(isset($result_d[$value_d["dealer_name"]])){
				$result_d[$value_d["dealer_name"]]["secondary_amt"]+=$value_d["secondary_amt"];
			}else{
				$result_d[$value_d["dealer_name"]]=$value_d;
			}
		}
		$dealer_select=array_values($result_d);
		$amount_list_d=array();
		foreach($dealer_select as $key => $list ) {
			$amount_list_d[$key] = $list['secondary_amt'];
		}
		array_multisort($amount_list_d, SORT_DESC, $dealer_select);
		$top3 = (array_slice($dealer_select, 0, 3));

		array_multisort($amount_list_d, SORT_ASC, $dealer_select);
		$least3 = (array_slice($dealer_select, 0, 3));

		$dealers_final_list=array(
			'top' =>	$top3,
			'least' =>   $least3
		);

//		pr($dealers_final_list);
		return json_encode($dealers_final_list);
	}

	public function overall_visits($data=''){
		if($data!=''){
			$start = date('Y-m-d', strtotime($data));
		}else{
			$start = date('Y-m-d', strtotime('-7 days'));
		}
		$end = date('Y-m-d')." 23:59:59";

		$doc_interc_list=json_decode(file_get_contents("ReportJSON/IntrctionDocSumry.json"),true);

		$doc_interc=array();
		$child_usr=get_check_active_users(explode(', ',logged_user_child()));
		$allSP_code=explode(',',all_user_sp_code());

		$doctr_list=array();
		foreach ($allSP_code as $sp_cod){
			$doctr_list[]=get_doc_details($sp_cod);
		}
		@$overall_doc_list=array_merge(...array_filter($doctr_list));
		//pr($overall_doc_list); die;

		foreach ($doc_interc_list as $doc_sec){
			foreach ($doc_sec as $doct_list){
				$patDate=date('Y-m-d', strtotime($doct_list['date']));
				if (($patDate >= $start) && ($patDate <= $end)) {
					if(is_admin()){
						if(!empty($overall_doc_list)) {
							foreach ($overall_doc_list as $doc_lst) {
								//if ($doc_lst['doctor_id'] == $doct_list['doc_id']) {
									$doc_interc[] = $doct_list['doc_id'];
								//}
							}
						}
					}
					else if(!empty($child_usr)){
						if(in_array($doct_list['user_id'], $child_usr)) {
							if(!empty($overall_doc_list)) {
								foreach ($overall_doc_list as $doc_lst) {
									if ($doc_lst['doctor_id'] == $doct_list['doc_id']) {
										$doc_interc[] = $doct_list['doc_id'];
									}
								}
							}
						}
					}
					else{
						if($doct_list['user_id']==logged_user_data()) {
							if(!empty($overall_doc_list)) {
								foreach ($overall_doc_list as $doc_lst) {
									if ($doc_lst['doctor_id'] == $doct_list['doc_id']) {
										$doc_interc[] = $doct_list['doc_id'];
									}
								}
							}
						}
					}

				}
			}
		}

		@$max=max(array_count_values($doc_interc));
		@$min=min(array_count_values($doc_interc));
		if($max > 0){
			$max_visit= $max;
			@$doc_name_max=(array_search($max_visit, array_count_values($doc_interc)));
		}
		if($min > 0){
			$min_visit = $min;
			@$doc_name_min= (array_search($min_visit, array_count_values($doc_interc)));
		}

		if(($max > 0) && ($min > 0)){
			$dataArr=array(
				'max_visit' => $max_visit,
				'doc_max' => $doc_name_max,
				'min_visit' => $min_visit,
				'doc_min' => $doc_name_min,
			);

			return json_encode($dataArr);
		}

	}

    /*
     * Developer: Shailesh Saraswat
     * Email: sss.shailesh@gmail.com
     * Dated: 26-12-2018 
     * 
     *  for the user Pharma report
     */ 
    public function pharma_analysis($data=''){
       
            if($data!=''){

             $start = date('Y-m-d', strtotime($data));

            }
            else{

             $start = date('Y-m-d', strtotime('-7 days'));

            }
          $end = date('Y-m-d')." 23:59:59";
          
          $spcode =  explode(',' ,$this->session->userdata('sp_code'));
          $pharma_analysis = array();
          $total_pharma = 0; $total_productive_call=0; $total_met_no_order=0;$total_not_met=0;
//            pr($spcode); die;
                  /*total Pharma met */
                     $arr = 'count(distinct(pip.pharma_id)) as totalpharma';
                     $this->db->select($arr);
                     $this->db->from('pharma_interaction_pharmacy pip');
                     $this->db->join("pharmacy_list pl" , "pl.pharma_id=pip.pharma_id");

                    if(!is_admin())
                    {
                      
                        $this->db->where_in('pl.sp_code',$spcode);
                    
                    }

                    $this->db->where('pip.create_date >=', $start);

                    $this->db->where('pip.create_date <=', $end);
                    
                    $query = $this->db->get();

//               echo $this->db->last_query(); die;

                 if($this->db->affected_rows()){
                     $total_pharma = $query->row()->totalpharma;
                     
                      /*total Pharma  productive call */
                     $arr = 'count(distinct(pip.pharma_id)) as productive_call';
                     $this->db->select($arr);
                     $this->db->from('pharma_interaction_pharmacy pip');
                     $this->db->join("pharmacy_list pl" ,"pl.pharma_id=pip.pharma_id");

                    if(!is_admin())
                    {
                      
                      $this->db->where_in('pl.sp_code',$spcode);
                    
                    }

                    $this->db->where('pip.create_date >=', $start);

                    $this->db->where('pip.create_date <=', $end);
                    $this->db->where("pip.meeting_sale !="," ");
                    $query2 = $this->db->get();
                     if($this->db->affected_rows()){
                              $total_productive_call = $query2->row()->productive_call;
                     }else{
                         $total_productive_call =0;
                     }
                     /*END total Pharma  productive call */
                     
                       /*total Pharma  met but no order */ 
                     $arr = 'count(distinct(pip.pharma_id)) as met_no_order';
                     $this->db->select($arr);
                     $this->db->from('pharma_interaction_pharmacy pip');
                     $this->db->join("pharmacy_list pl" , "pl.pharma_id=pip.pharma_id");

                    if(!is_admin())
                    {
                      
                            $this->db->where_in('pl.sp_code',$spcode);
                    
                    }

                    $this->db->where('pip.create_date >=', $start);

                    $this->db->where('pip.create_date <=', $end);
                    $this->db->where("pip.meeting_sale ",NULL,TRUE);
                    $extra_where = "pip.meet_or_not_meet !=0 OR pip.meet_or_not_meet IS NULL";
                    $this->db->where($extra_where);
                   
                   
                    $query3 = $this->db->get();
//                      echo $this->db->last_query(); die;
                     if($this->db->affected_rows()){
                         $total_met_no_order = $query3->row()->met_no_order;
                     }else{
                         $total_met_no_order =0;
                     }
                      /*END total Pharma  met but no order */ 
                     
                     
                       /* total Pharma not met */ 
                     $arr = 'count(distinct(pip.pharma_id)) as not_met';
                     $this->db->select($arr);
                     $this->db->from('pharma_interaction_pharmacy pip');
                   $this->db->join("pharmacy_list pl" , "pl.pharma_id=pip.pharma_id");

                    if(!is_admin())
                    {
                      
                            $this->db->where_in('pl.sp_code',$spcode);
                    
                    }

                    $this->db->where('pip.create_date >=', $start);

                    $this->db->where('pip.create_date <=', $end);
                    $this->db->where("pip.meet_or_not_meet",0);
                   
                    $query4 = $this->db->get();
//                      echo $this->db->last_query(); die;
                     if($this->db->affected_rows()){
                              $total_not_met = $query4->row()->not_met;
                     }else{
                              $total_not_met = 0;
                     }
                      /*END total Pharma not met */ 
                     $pharma_analysis = array(
                                           'totalpharma'=>$total_pharma,
                                           'productive_call' =>$total_productive_call,
                                           'met_no_order'=>$total_met_no_order,
                                           'not_met'=>$total_not_met
                                            );
                     
                     
                     return json_encode($pharma_analysis);
                }

                else{



                    return FALSE;

                }
    }

    
    
    
      /*
     * Developer: Shailesh Saraswat
     * Email: sss.shailesh@gmail.com
     * Dated: 26-12-2018 
     * 
     *  for the user week dealer report
     */ 
    public function dealer_analysis($data=''){
       
        if($data!=''){

         $start = date('Y-m-d', strtotime($data));

        }
        else{

         $start = date('Y-m-d', strtotime('-7 days'));

        }
          $end = date('Y-m-d')." 23:59:59";
          
          $spcode =  explode(',' ,$this->session->userdata('sp_code'));
          $dealer_analysis = array();
          $total_dealer = 0; $total_productive_call=0; $total_met_no_order=0;$total_not_met=0;
//            pr($spcode); die;
                  /*total Dealer met */
                     $arr = 'count(distinct(pid.d_id)) as totaldealer';
                     $this->db->select($arr);
                     $this->db->from('pharma_interaction_dealer pid');
                     $this->db->join("dealer dl" , "dl.dealer_id=pid.d_id");

                    if(!is_admin())
                    {
                      
                        $this->db->where_in('dl.sp_code',$spcode);
                    
                    }

                    $this->db->where('pid.create_date >=', $start);

                    $this->db->where('pid.create_date <=', $end);
                    
                    $query = $this->db->get();

//               echo $this->db->last_query(); die;

                 if($this->db->affected_rows()){
                     $total_dealer = $query->row()->totaldealer;
                     
                      /*total dealer  productive call */
                     $arr = 'count(distinct(pid.d_id)) as productive_call';
                     $this->db->select($arr);
                     $this->db->from('pharma_interaction_dealer pid');
                     $this->db->join("dealer dl" ,"dl.dealer_id=pid.d_id");

                    if(!is_admin())
                    {
                      
                      $this->db->where_in('dl.sp_code',$spcode);
                    
                    }

                    $this->db->where('pid.create_date >=', $start);

                    $this->db->where('pid.create_date <=', $end);
                    $this->db->where("pid.meeting_sale !="," ");
                    $query2 = $this->db->get();
                     if($this->db->affected_rows()){
                              $total_productive_call = $query2->row()->productive_call;
                     }else{
                         $total_productive_call =0;
                     }
                     /*END total dealer  productive call */
                     
                       /*total dealer  met but no order */ 
                     $arr = 'count(distinct(pid.d_id)) as met_no_order';
                     $this->db->select($arr);
                     $this->db->from('pharma_interaction_dealer pid');
                     $this->db->join("dealer dl" , "dl.dealer_id=pid.d_id");

                    if(!is_admin())
                    {
                      
                            $this->db->where_in('dl.sp_code',$spcode);
                    
                    }

                    $this->db->where('pid.create_date >=', $start);

                    $this->db->where('pid.create_date <=', $end);
                    $this->db->where("pid.meeting_sale ",NULL,TRUE);
                    $extra_where = "pid.meet_or_not_meet !=0 OR pid.meet_or_not_meet IS NULL";
                    $this->db->where($extra_where);
                   
                   
                    $query3 = $this->db->get();
//                      echo $this->db->last_query(); die;
                     if($this->db->affected_rows()){
                              $total_met_no_order = $query3->row()->met_no_order;
                     }else{
                         $total_met_no_order =0;
                     }
                      /*END total dealer  met but no order */ 
                     
                     
                       /* total dealer not met */ 
                     $arr = 'count(distinct(pid.d_id)) as not_met';
                     $this->db->select($arr);
                     $this->db->from('pharma_interaction_dealer pid');
                     $this->db->join("dealer dl" , "dl.dealer_id=pid.d_id");

                    if(!is_admin())
                    {
                      
                            $this->db->where_in('dl.sp_code',$spcode);
                    
                    }

                    $this->db->where('pid.create_date >=', $start);

                    $this->db->where('pid.create_date <=', $end);
                    $this->db->where("pid.meet_or_not_meet",0);
                   
                    $query4 = $this->db->get();
//                      echo $this->db->last_query(); die;
                     if($this->db->affected_rows()){
                              $total_not_met = $query4->row()->not_met;
                     }else{
                              $total_not_met = 0;
                     }
                      /*END total dealer not met */ 
                     $dealer_analysis = array(
                                           'totaldealer'=>$total_dealer,
                                           'productive_call' =>$total_productive_call,
                                           'met_no_order'=>$total_met_no_order,
                                           'not_met'=>$total_not_met
                                            );
                     
                     
                     return json_encode($dealer_analysis);
                }

                else{



                    return FALSE;

                }
    }




    /*
     * Developer: Shailesh Saraswat
     * Email: sss.shailesh@gmail.com
     * Dated: 26-12-2018 
     * 
     *  for the user week doctor report
     */ 
    public function doc_analysis($data=''){
        
          if($data!=''){

        $start = date('Y-m-d', strtotime($data));

        }

        else{

            $start = date('Y-m-d', strtotime('-7 days'));

        }
          $end = date('Y-m-d')." 23:59:59";
          
          $spcode =  explode(',' ,$this->session->userdata('sp_code'));
          $doc_analysis = array();
          $total_doctor = 0; $total_productive_call=0; $total_met_no_order=0;$total_not_met=0;
//            pr($spcode); die;
                  /*total doctor met */
                     $arr = 'count(distinct(pid.doc_id)) as totaldoctor';
                     $this->db->select($arr);
                     $this->db->from('pharma_interaction_doctor pid');
                     $this->db->join("doctor_list dl" , "dl.doctor_id=pid.doc_id");

                    if(!is_admin())
                    {
                      
                        $this->db->where_in('dl.sp_code',$spcode);
                    
                    }

                    $this->db->where('pid.create_date >=', $start);

                    $this->db->where('pid.create_date <=', $end);
                    
                    $query = $this->db->get();

//               echo $this->db->last_query(); die;

                 if($this->db->affected_rows()){
                     $total_doctor = $query->row()->totaldoctor;
                     
                      /*total doctor  productive call */
                     $arr = 'count(distinct(pid.doc_id)) as productive_call';
                     $this->db->select($arr);
                     $this->db->from('pharma_interaction_doctor pid');
                     $this->db->join("doctor_list dl" , "dl.doctor_id=pid.doc_id");

                    if(!is_admin())
                    {
                      
                      $this->db->where_in('dl.sp_code',$spcode);
                    
                    }

                    $this->db->where('pid.create_date >=', $start);

                    $this->db->where('pid.create_date <=', $end);
                    $this->db->where("pid.meeting_sale !="," ");
                    $query2 = $this->db->get();
//                       echo $this->db->last_query(); die;
                     if($this->db->affected_rows()){
                              $total_productive_call = $query2->row()->productive_call;
                     }else{
                         $total_productive_call =0;
                     }
                     /*END total doctor  productive call */
                     
                       /*total doctor  met but no order */ 
                     $arr = 'count(distinct(pid.doc_id)) as met_no_order';
                     $this->db->select($arr);
                     $this->db->from('pharma_interaction_doctor pid');
                     $this->db->join("doctor_list dl" , "dl.doctor_id=pid.doc_id");

                    if(!is_admin())
                    {
                      
                            $this->db->where_in('dl.sp_code',$spcode);
                    
                    }

                    $this->db->where('pid.create_date >=', $start);

                    $this->db->where('pid.create_date <=', $end);
                    $this->db->where("pid.meeting_sale ",NULL,TRUE);
                    $this->db->where("pid.meet_or_not_meet !=",0);
                   
                    $query3 = $this->db->get();
//                      echo $this->db->last_query(); die;
                     if($this->db->affected_rows()){
                              $total_met_no_order = $query3->row()->met_no_order;
                     }else{
                         $total_met_no_order =0;
                     }
                      /*END total doctor  met but no order */ 
                     
                     
                       /* total doctor not met */ 
                     $arr = 'count(distinct(pid.doc_id)) as not_met';
                     $this->db->select($arr);
                     $this->db->from('pharma_interaction_doctor pid');
                     $this->db->join("doctor_list dl" , "dl.doctor_id=pid.doc_id");

                    if(!is_admin())
                    {
                      
                            $this->db->where_in('dl.sp_code',$spcode);
                    
                    }

                    $this->db->where('pid.create_date >=', $start);

                    $this->db->where('pid.create_date <=', $end);
                    $this->db->where("pid.meet_or_not_meet",0);
                   
                    $query4 = $this->db->get();
//                      echo $this->db->last_query(); die;
                     if($this->db->affected_rows()){
                              $total_not_met = $query4->row()->not_met;
                     }else{
                         $total_not_met =0;
                     }
                      /*END total doctor not met */ 
                     $doc_analysis = array(
                                           'totaldoctor'=>$total_doctor,
                                           'productive_call' =>$total_productive_call,
                                           'met_no_order'=>$total_met_no_order,
                                           'not_met'=>$total_not_met
                                            );
                     
                     
                     return json_encode($doc_analysis);
                }

                else{



                    return FALSE;

                }
    }





    public function top_sales_cust($data=''){

//        $desig_id=logged_user_desig();

//        $log_userid = logged_user_data();

//        

//        $cities_are = logged_user_cities();

//         $city_id=explode(',', $cities_are);

//        

//           $boss_are = logged_user_boss();

//          $boss_id=explode(',', $boss_are);

//        

//           $doc_are = logged_user_doc();

//          $doc_id=explode(',', $doc_are);

        

        if($data!=''){

        $start = date('Y-m-d', strtotime($data));

        }

        else{

            $start = date('Y-m-d', strtotime('-7 days'));

        }
        

        $end = date('Y-m-d')." 23:59:59";

        

        $arr = "d.dealer_id,SUM(pid.meeting_sale) as sale,d.dealer_name as customername";
        $this->db->select($arr);
        $this->db->from("pharma_interaction_dealer pid");
        $this->db->join("dealer d" , "d.dealer_id=pid.d_id");
        $this->db->where('pid.create_date >=', $start);
        $this->db->where('pid.create_date <=', $end);
        $this->db->where("pid.meeting_sale !="," ");

        /*if(logged_user_data()!=28 && logged_user_data()!=29 &&  logged_user_data()!=32 )
        {
            $this->db->where("d.sp_code in (".all_user_sp_code().")");
        }*/

        if(!is_admin())
        {
            $spc=$this->session->userdata('sp_code');
            $sp=0;
            if($spc!='')
            {
                $sp=str_replace(',','|',$this->session->userdata('sp_code'));
            }
            $this->db->where('CONCAT(",", `d`.`sp_code`, ",") REGEXP ",('.$sp.'),"');
        }
        $this->db->group_by("pid.d_id");
        $this->db->limit(6, 0);
        $this->db->order_by("SUM(pid.meeting_sale)","DESC");
        $query = $this->db->get();

       //echo $this->db->last_query(); die;

         if($this->db->affected_rows()){
            return json_encode($query->result_array());
        }

        else{

            

            return FALSE;

        }

    }

    

    // top payment customers 

    public function top_payment_cust($data=''){

        

         if($data!=''){

        $start = date('Y-m-d', strtotime($data));

        }

        else{

            $start = date('Y-m-d', strtotime('-7 days'));

        }

        

        $end = date('Y-m-d')." 23:59:59";

        

        $arr = "d.dealer_id,SUM(pid.meeting_payment) as payment,d.dealer_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_dealer pid");

        $this->db->join("dealer d" , "d.dealer_id=pid.d_id");



        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        if(!is_admin())
        {
            $spc=$this->session->userdata('sp_code');
            $sp=0;
            if($spc!='')
            {
                $sp=str_replace(',','|',$this->session->userdata('sp_code'));
            }
            $this->db->where('CONCAT(",", `d`.`sp_code`, ",") REGEXP ",('.$sp.'),"');
        }

        $this->db->where("pid.meeting_payment !="," ");

        

        

        $this->db->group_by("pid.d_id");

        

          $this->db->limit(6, 0);

        

        $this->db->order_by("SUM(pid.meeting_payment)","DESC");

        

        

        $query = $this->db->get();

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

            

            return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

        

    }

    

    

    // top secondary sale customer (doctor or pharmacy)

    public function top_secondary_cust($data=''){
//all_user_sp_code();
        

        if($data!=''){

        $start = date('Y-m-d', strtotime($data));

        }

        else{

            $start = date('Y-m-d', strtotime('-7 days'));

        }

         $end = date('Y-m-d')." 23:59:59";

        

        $arr = "dl.doctor_id as docid,SUM(pid.meeting_sale) as sale,dl.doc_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

        $this->db->join("doctor_list dl" , "dl.doctor_id=pid.doc_id");

        if(!is_admin())
        {
            $sp=$this->session->userdata('sp_code');
            if($sp!=''){
                $this->db->where("`dl`.`sp_code` in (".$sp.")");
            }
            else
            {
                $sp=0;
                $this->db->where("`dl`.`sp_code` in (".$sp.")");
            }
            
        }

        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        

        $this->db->where("pid.meeting_sale !="," ");

        

        

        $this->db->group_by("pid.doc_id");

          $this->db->limit(6, 0);

        $this->db->order_by("SUM(`pid`.`meeting_sale`)","DESC");

        

        $query = $this->db->get();

        

         $doc_sale_info = $query->result_array();  // for doctor sale list

//        pr($doc_sale_info);
//echo all_user_sp_code();
   // echo $this->db->last_query(); die;

         if($this->db->affected_rows() || 1==1){

            

           // for pharmacy sale list  

        $arr = "pl.pharma_id as pharma_id,SUM(pip.meeting_sale) as sale,pl.company_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

       $this->db->join("pharmacy_list pl" , "pl.pharma_id=pip.pharma_id");

        if(!is_admin())
        {
            $sp=$this->session->userdata('sp_code');
            
            if($sp!=''){
               $this->db->where("sp_code in (".$sp.")");
            }
            else
            {
                $sp=0;
                $this->db->where("sp_code in (".$sp.")");
            }
        }
        $this->db->where('pip.create_date >=', $start);

        $this->db->where('pip.create_date <=', $end);

        

        $this->db->where("pip.meeting_sale !="," ");

        

        

        $this->db->group_by("pip.pharma_id");

          $this->db->limit(6, 0);

        $this->db->order_by("SUM(pip.meeting_sale)","DESC");

        

        $query = $this->db->get();

        

        $pharma_sale_info = $query->result_array();  // for pharmacy sale list 

//           echo "pharma"."<br>";

//        pr($pharma_sale_info);

           

        $res = array_merge($doc_sale_info, $pharma_sale_info); 

        

       $result = msort($res, array('sale'));   // $res is an array,   Second is key name which is being sort by value

         

//       pr($result); die;

        

            return json_encode($result);

        }

        else{

            

            return FALSE;

        }

        

        

        

    }

 

    

    // top interaction customer (doctor or pharmacy or dealer)

    

    public function top_interaction_cust($data=''){

        

    

          if($data!=''){

        $start = date('Y-m-d', strtotime($data));

        }

        else{

            $start = date('Y-m-d', strtotime('-7 days'));

        }

         

         $end = date('Y-m-d')." 23:59:59";

        

        // for Doctor interaction list 

        $arr = "dl.doctor_id,count(pid.doc_id) as interaction,dl.doc_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

        $this->db->join("doctor_list dl" , "dl.doctor_id=pid.doc_id");

        if(!is_admin())
        {
            $sp=$this->session->userdata('sp_code');
            if($sp!=''){
               $this->db->where("sp_code in (".$sp.")");
            }
            else
            {
                $sp=0;
                $this->db->where("sp_code in (".$sp.")");
            }
        }

        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);
       

        $this->db->group_by("pid.doc_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(`pid`.`doc_id`)","DESC");

        

        $query = $this->db->get();

        

         $doc_interaction_info = $query->result_array();    // for Doctor interaction list 

//        pr($doc_sale_info);

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows() || 1==1){

            

             // for Sub Dealer interaction list 

        $arr = "pl.pharma_id,count(pip.pharma_id) as interaction,pl.company_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

       $this->db->join("pharmacy_list pl" , "pl.pharma_id=pip.pharma_id");

        if(!is_admin())
        {
            $sp=$this->session->userdata('sp_code');
            if($sp!=''){
               $this->db->where("sp_code in (".$sp.")");
            }
            else
            {
                $sp=0;
                $this->db->where("sp_code in (".$sp.")");
            }
        }

        $this->db->where('pip.create_date >=', $start);

        $this->db->where('pip.create_date <=', $end);

        

               

        

        $this->db->group_by("pip.pharma_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(pip.pharma_id)","DESC");

        

        $query = $this->db->get();

         

        $pharma_interaction_info = $query->result_array();  // for Sub Dealer interaction list 

//           echo "pharma"."<br>";

//        pr($pharma_sale_info);

             

           

        $res = array_merge($doc_interaction_info, $pharma_interaction_info);  // merge doctor and pharmacy interaction

   

         //$result if for show sorted value of interaction of doctor , pharmacy and Dealer

       

       $result = msort($res, array('interaction'));   // $res is an array,   Second is key name which is being sort by value

       

      

          

        // for dealer interaction list 

        $arr = "d.gd_id,d.dealer_id,count(pid.d_id) as interaction,d.dealer_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_dealer pid");

        $this->db->join("dealer d" , "d.dealer_id=pid.d_id");



        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        
        if(!is_admin())
        {
            $spc=$this->session->userdata('sp_code');
            $sp=0;
            if($spc!='')
            {
                $sp=str_replace(',','|',$this->session->userdata('sp_code'));
            }
            $this->db->where('CONCAT(",", `d`.`sp_code`, ",") REGEXP ",('.$sp.'),"');
        }
        

        $this->db->group_by("pid.d_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(pid.d_id)","DESC");

        

        $query = $this->db->get();

         

        $dealer_interaction_info = $query->result_array();  // for Dealer interaction list 

       

       

         $res_d = array_merge($result, $dealer_interaction_info);  // merge doctor and pharmacy interaction

   

         

         //$result if for show sorted value of interaction of doctor , pharmacy and Dealer

       

        $result_d = msort($res_d, array('interaction'));   // $res is an array,   Second is key name which is being sort by value

        // $result_d is a sorted value of all the reord of doctor/dealer and pharmacy interaction

       

//          pr($result_d); die;

        

            return json_encode($result_d);

        }

        else{

            

            return FALSE;

        }

        

        

        

    }

    

    //top most met customer

     public function top_most_met_cust($data=''){

        

       

          if($data!=''){

        $start = date('Y-m-d', strtotime($data));

        }

        else{

            $start = date('Y-m-d', strtotime('-7 days'));

        }

         

         $end = date('Y-m-d')." 23:59:59";

        

        // for Doctor Meet list 

        $arr = "dl.doctor_id,count(pid.meet_or_not_meet) as meet,dl.doc_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

        $this->db->join("doctor_list dl" , "dl.doctor_id=pid.doc_id");

                if(!is_admin())
        {
            $sp=$this->session->userdata('sp_code');
            if($sp!=''){
               $this->db->where("sp_code in (".$sp.")");
            }
            else
            {
                $sp=0;
                $this->db->where("sp_code in (".$sp.")");
            }
        }

        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        $this->db->where('pid.meet_or_not_meet',1);

        

        $this->db->group_by("pid.doc_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(`pid`.`doc_id`)","DESC");

        

        $query = $this->db->get();

        

         $doc_met_info = $query->result_array();    // for Doctor Meet list 

//        pr($doc_met_info);

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows() || 1==1){

            

             // for Sub Dealer Meet list 

        $arr = "pl.pharma_id,count(pip.meet_or_not_meet) as meet,pl.company_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

       $this->db->join("pharmacy_list pl" , "pl.pharma_id=pip.pharma_id");

        if(!is_admin())
        {
            $sp=$this->session->userdata('sp_code');
            if($sp!=''){
               $this->db->where("sp_code in (".$sp.")");
            }
            else
            {
                $sp=0;
                $this->db->where("sp_code in (".$sp.")");
            }
        }

        $this->db->where('pip.create_date >=', $start);

        $this->db->where('pip.create_date <=', $end);

        $this->db->where('pip.meet_or_not_meet',1);

               

        

        $this->db->group_by("pip.pharma_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(pip.pharma_id)","DESC");

        

        $query = $this->db->get();

         

        $pharma_met_info = $query->result_array();  // for Sub Dealer Meet list 

//           echo "pharma"."<br>";

//        pr($pharma_met_info);

             

           

        $res = array_merge($doc_met_info, $pharma_met_info);  // merge doctor and pharmacy meet

   

         //$result if for show sorted value of meet of doctor , pharmacy and Dealer

       

       $result = msort($res, array('meet'));   // $res is an array,   Second is key name which is being sort by value

       

      

          

        // for dealer Meet list 

        $arr = "d.gd_id,d.dealer_id,count(pid.meet_or_not_meet) as meet,d.dealer_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_dealer pid");

        $this->db->join("dealer d" , "d.dealer_id=pid.d_id");



        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        $this->db->where('pid.meet_or_not_meet',1);
                if(!is_admin())
        {
            $spc=$this->session->userdata('sp_code');
            $sp=0;
            if($spc!='')
            {
                $sp=str_replace(',','|',$this->session->userdata('sp_code'));
            }
            $this->db->where('CONCAT(",", `d`.`sp_code`, ",") REGEXP ",('.$sp.'),"');
        }
        

        $this->db->group_by("pid.d_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(pid.d_id)","DESC");

        

        $query = $this->db->get();

         

        $dealer_met_info = $query->result_array();  // for Dealer Meet list 

       

       

         $res_d = array_merge($result, $dealer_met_info);  // merge doctor and pharmacy meet

   

         

         //$result if for show sorted value of meet of doctor , pharmacy and Dealer

       

        $result_d = msort($res_d, array('meet'));   // $res is an array,   Second is key name which is being sort by value

        // $result_d is a sorted value of all the reord of doctor/dealer and pharmacy meet

       

//          pr($result_d); die;

        

            return json_encode($result_d);

        }

        else{

            

            return FALSE;

        }

        

        

        

    }

    

    // top most not met customer

     public function top_never_met_cust($data=''){
        if($data!=''){
        $start = date('Y-m-d', strtotime($data));
        }
        else{
            $start = date('Y-m-d', strtotime('-7 days'));
        }
        $end = date('Y-m-d')." 23:59:59";
               // for Doctor never Meet list 

        $arr = "dl.doctor_id,count(pid.meet_or_not_meet) as nevermeet,dl.doc_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

        $this->db->join("doctor_list dl" , "dl.doctor_id=pid.doc_id");

                if(!is_admin())
        {
            $sp=$this->session->userdata('sp_code');
            if($sp!=''){
               $this->db->where("sp_code in (".$sp.")");
            }
            else
            {
                $sp=0;
                $this->db->where("sp_code in (".$sp.")");
            }
        }

        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        $this->db->where('pid.meet_or_not_meet',0);

        

        $this->db->group_by("pid.doc_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(`pid`.`doc_id`)","DESC");

        

        $query1 = $this->db->get();

        

         $doc_met_info = $query1->result_array();    // for Doctor never Meet list 

//        pr($doc_met_info);

//         echo $this->db->last_query(); die;

//         if($this->db->affected_rows()){

            

             // for Sub Dealer never Meet list 

        $arr = "pl.pharma_id,count(pip.meet_or_not_meet) as nevermeet,pl.company_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

       $this->db->join("pharmacy_list pl" , "pl.pharma_id=pip.pharma_id");

        if(!is_admin())
        {
            $sp=$this->session->userdata('sp_code');
                        if($sp!=''){
               $this->db->where("sp_code in (".$sp.")");
            }
            else
            {
                $sp=0;
                $this->db->where("sp_code in (".$sp.")");
            }
        }

        $this->db->where('pip.create_date >=', $start);

        $this->db->where('pip.create_date <=', $end);

        $this->db->where('pip.meet_or_not_meet',0);

               

        

        $this->db->group_by("pip.pharma_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(pip.pharma_id)","DESC");

        

        $query2 = $this->db->get();

         

        $pharma_met_info = $query2->result_array();  // for Sub Dealer never Meet list 

//           echo "pharma"."<br>";

//        pr($pharma_met_info);

             

           

        $res = array_merge($doc_met_info, $pharma_met_info);  // merge doctor and pharmacy meet

   

         //$result if for show sorted value of meet of doctor , pharmacy and Dealer

       

       $result = msort($res, array('nevermeet'));   // $res is an array,   Second is key name which is being sort by value

       

      

          

        // for dealer Meet list 

        $arr = "d.gd_id,d.dealer_id,count(pid.meet_or_not_meet) as nevermeet,d.dealer_name as customername";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_dealer pid");

        $this->db->join("dealer d" , "d.dealer_id=pid.d_id");



        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        $this->db->where('pid.meet_or_not_meet',0);

                if(!is_admin())
        {
            $spc=$this->session->userdata('sp_code');
            $sp=0;
            if($spc!='')
            {
                $sp=str_replace(',','|',$this->session->userdata('sp_code'));
            }
            $this->db->where('CONCAT(",", `d`.`sp_code`, ",") REGEXP ",('.$sp.'),"');
        }

        $this->db->group_by("pid.d_id");

          $this->db->limit(6, 0);

        $this->db->order_by("count(pid.d_id)","DESC");

        

        $query3 = $this->db->get();

         

        $dealer_met_info = $query3->result_array();  // for Dealer never Meet list 

       

       

         $res_d = array_merge($result, $dealer_met_info);  // merge doctor and pharmacy never  meet

   

         

         //$result if for show sorted value of never meet of doctor , pharmacy and Dealer

       

        $result_d = msort($res_d, array('nevermeet'));   // $res is an array,   Second is key name which is being sort by value

        // $result_d is a sorted value of all the reord of doctor/dealer and pharmacy meet

       

//          pr($result_d); die;

//         if($query1->affected_rows() >0 || $query2->affected_rows() || $query3->affected_rows()){
           return json_encode($result_d);

            

//            }
//        else{
//            
//            return FALSE;
//        }
    }

    

}
