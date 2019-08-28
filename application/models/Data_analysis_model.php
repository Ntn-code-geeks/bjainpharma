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
     * Developer: Shailesh Saraswat
     * Email: sss.shailesh@gmail.com
     * Dated: 28-12-2018 
     * 
     *  for the secondary highest and lowest report
     */ 
    public function secondary_analysis($data=''){
        
         if($data!=''){

             $start = date('Y-m-d', strtotime($data));

            }
            else{

             $start = date('Y-m-d', strtotime('-7 days'));

            }
          $end = date('Y-m-d')." 23:59:59";
        
        
        $arr = 'pu.name as empname,pid.meeting_sale';
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
         
        $this->db->order_by('pid.meeting_sale','DESC');
        $this->db->limit(1,0);
        
         $query = $this->db->get();

//               echo $this->db->last_query(); die;

        if($this->db->affected_rows()){
                       $heighest = $query->row();
                        $arr = 'pu.name as empname,pid.meeting_sale';
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
                                $this->db->order_by('pid.meeting_sale','asc');
                                $this->db->limit(1,0);

                                 $query2 = $this->db->get();
                                    if($this->db->affected_rows()){
                                        $lowest = $query2->row();
                                    }else{
                                        $lowest = array();
                                    }
                    $secondry_sale = array(
                                            'highest'=>$heighest,
                                            'lowest'=>$lowest,    
                                          );
                                    
                                          return json_encode($secondry_sale);           
                  
              }else{
                  
                     return FALSE;
                     
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
