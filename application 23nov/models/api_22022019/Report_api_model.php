<?php


/*
 * Developer: Niraj Sharma
 * Email: niraj@bjain.com
 * 
 * Dated: 28-08-2018
 * 
 */

class Report_api_model extends CI_Model {

    
    public function travel_report_pharmacy($userid='',$start='',$end='',$page_limit='',$page_start=''){

        $arr = "pip.pharma_id,pip.telephonic as oncall,pip.id, pip.remark,pip.orignal_sale as order_supply,pip.date_of_supply,`pip`.`pharma_id`, `pl`.`company_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user`,`pip`.`meeting_sale` as `secondary_sale`, `pip`.`meet_or_not_meet` as `metnotmet`,pip.create_date as date,pip.dealer_id ";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");
        $this->db->join("pharmacy_list pl","pl.pharma_id=pip.pharma_id");
        $this->db->join("pharma_users pu" , "pu.id=pip.crm_user_id","Left");
        //$this->db->join("pharmacy_interaction_sample_relation  pisr" , "pisr.pipharma_id=pip.id","Left");
        //$this->db->join("meeting_sample_master  msm" , "msm.id=pisr.sample_id","Left");
        $this->db->join("pharmacy_interaction_with_team  team" , "team.pipharma_id=pip.id","Left");
        $this->db->join("pharma_users pus" , "pus.id=team.team_id","Left");
        $this->db->join("city c" , "c.city_id=pl.city_id");
        $this->db->join("state st" , "st.state_id=pl.state_id");
        $this->db->where('pip.status',1);
        if($userid > 0){
            $this->db->where('(team.team_id='.$userid.' OR pip.crm_user_id='.$userid.') ');
        }
        $this->db->where('pip.create_date >=', $start);
        $this->db->where('pip.create_date <=', $end);
        /*  if($page_limit!=''){
        $this->db->limit($page_limit, decode($page_start));
        } */
        $this->db->group_by('pip.id');

        

         $query = $this->db->get();

        

        $pharmacy_travel_info = $query->result_array();

         if($this->db->affected_rows()){

            
               $team_interaction = array();

             foreach ($pharmacy_travel_info as $k=>$val){

                 

                  $arr = "GROUP_CONCAT(msm.sample_name SEPARATOR ',') as `sample`";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_pharmacy pip");

          $this->db->join("pharmacy_interaction_sample_relation  pisr" , "pisr.pipharma_id=pip.id","Left");

         $this->db->join("meeting_sample_master  msm" , "msm.id=pisr.sample_id","Left");

        

        

        $this->db->where('pisr.pipharma_id',$val['id']);

        

        $this->db->group_by('pip.id'); 

        

       

        $query = $this->db->get();


        $pharmacy_travel_info[$k]['sample'] = $query->row_array();


        $arr = "pip.pharma_id,GROUP_CONCAT(`pus`.`name` SEPARATOR ',') as `team_user`";

        

        $this->db->select($arr);

        

        $this->db->from("pharma_interaction_pharmacy pip");

        

         $this->db->join("pharmacy_interaction_with_team  team" , "team.pipharma_id=pip.id");

         $this->db->join("pharma_users pus" , "pus.id=team.team_id");

        

        $this->db->where('team.pipharma_id',$val['id']);


         $this->db->where('pip.create_date >=', $start);

         $this->db->where('pip.create_date <=', $end);

        

        $this->db->group_by('team.pipharma_id'); 

        

        $query = $this->db->get();

        $team_interaction[] = $query->row_array();

                 

             }

             

             

           $result = array('pharmacy_info'=>$pharmacy_travel_info,'team_info'=>$team_interaction);  

            return $result;

        }

        else{
            $result = array('pharmacy_info'=>array(),'team_info'=>array());  
                              return $result;
        } 
    }
    
    
    
    
     public function travel_report_dealer($userid='',$start='',$end='',$page_limit='',$page_start=''){

        

        $arr = "pi.telephonic as oncall,pi.id,pi.remark,dl.gd_id as is_cf,pi.create_date as date,`pi`.`d_id`, `dl`.`dealer_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user`,pi.meeting_sale as sale,pi.meeting_payment as payment,pi.meeting_stock as stock,pi.meet_or_not_meet as metnotmet,pi.d_id ";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_dealer pi");

        $this->db->join("dealer dl" , "dl.dealer_id=pi.d_id");

        

        $this->db->join("pharma_users pu" , "pu.id=pi.crm_user_id","left");

         

        $this->db->join("dealer_interaction_with_team  team" , "team.pidealer_id=pi.id","left");

        $this->db->join("pharma_users pus" , "pus.id=team.team_id","left");
        

        $this->db->join("city c" , "c.city_id=dl.city_id");

        $this->db->join("state st" , "st.state_id=dl.state_id");

        

        $this->db->where('pi.status',1);

        if($userid > 0){
            $this->db->where('(team.team_id='.$userid.' OR pi.crm_user_id='.$userid.') ');
        }

         $this->db->where('pi.create_date >=', $start);

         $this->db->where('pi.create_date <=', $end);


        $this->db->group_by('pi.id');

         $this->db->order_by('dl.dealer_name','ASC'); 

         

        $query = $this->db->get();

        

        $dealer_travel_info = $query->result_array();

        

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

//             pr($dealer_travel_info); die;   

              $team_interaction = array();

             foreach ($dealer_travel_info as $k=>$val){

                 

                        $arr = "GROUP_CONCAT(msm.sample_name SEPARATOR ',') as `sample`";

                        $this->db->select($arr);

                        $this->db->from("pharma_interaction_dealer pi");

                          $this->db->join("dealer_interaction_sample_relation  disr" , "disr.pidealer_id=pi.id","Left");

                         $this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");


                        $this->db->where('disr.pidealer_id',$val['id']);



                        $this->db->group_by('pi.id'); 


                        $query = $this->db->get();


                        $dealer_travel_info[$k]['sample'] = $query->row_array();



                        $arr = "pi.d_id,GROUP_CONCAT(`pus`.`name` SEPARATOR ',') as `team_user`";



                        $this->db->select($arr);



                        $this->db->from("pharma_interaction_dealer pi");



                        $this->db->join("dealer_interaction_with_team  team" , "team.pidealer_id=pi.id");

                        $this->db->join("pharma_users pus" , "pus.id=team.team_id");



                        $this->db->where('team.pidealer_id',$val['id']);


                         $this->db->where('pi.create_date >=', $start);

                         $this->db->where('pi.create_date <=', $end);



                        $this->db->group_by('team.pidealer_id'); 


                        $query = $this->db->get();


                        $team_interaction[] = $query->row_array();

                             }


                           $result = array('dealer_info'=>$dealer_travel_info,'team_info'=>$team_interaction);  


                            return $result;

                        }
                        else{
                              $result = array('dealer_info'=>array(),'team_info'=>array());  
                              return $result;
                        } 

    }  
    
    public function travel_report_doctor($userid='',$start='',$end='',$page_limit='',$page_start=''){
        $arr = "pid.telephonic as oncall,pid.id,pid.remark,pid.orignal_sale as order_supply,pid.date_of_supply,`pid`.`meeting_sale` as `secondary_sale`, `pid`.`meet_or_not_meet` as `metnotmet`,pid.create_date as date,pid.doc_id,doc.doc_name as customer,c.city_name as city,pu.name as user,pid.dealer_id";
        $this->db->select($arr);
        $this->db->from("pharma_interaction_doctor pid");
        $this->db->join("doctor_list doc" , "doc.doctor_id=pid.doc_id");
        $this->db->join("pharma_users pu" , "pu.id=pid.crm_user_id","Left");
        // $this->db->join("doctor_interaction_sample_relation  disr" , "disr.pidoc_id=pid.id","Left");
        // $this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");
        $this->db->join("doctor_interaction_with_team  team" , "team.pidoc_id=pid.id","Left");
        $this->db->join("pharma_users pus" , "pus.id=team.team_id","Left");
        $this->db->join("city c" , "c.city_id=doc.city_id");
        $this->db->join("state st" , "st.state_id=doc.state_id");
        $this->db->where('pid.status',1);
        if($userid > 0){
            //$this->db->where('team.team_id',$userid);
            //(`team`.`team_id` = '92' OR `pid`.`crm_user_id` = '92')
            $this->db->where('(team.team_id='.$userid.' OR pid.crm_user_id='.$userid.') ');
            //$this->db->or_where('pid.crm_user_id',$userid);
        }
        $this->db->where('pid.create_date >=', $start);
        $this->db->where('pid.create_date <=', $end);
        /* if($page_limit!=''){
         $this->db->limit($page_limit, decode($page_start));
        } */
        $this->db->group_by('pid.id');
        $this->db->order_by('pid.doc_id','ASC'); 
        $query = $this->db->get();
        $doc_travel_info = $query->result_array();
       
        

//         echo $this->db->last_query(); die;

         if($this->db->affected_rows()){

             

//             pr($doc_travel_info); die;

              $team_interaction = array();

             foreach ($doc_travel_info as $k=>$val){

              

                 $arr = "GROUP_CONCAT(msm.sample_name SEPARATOR ',') as `sample`";

        $this->db->select($arr);

        $this->db->from("pharma_interaction_doctor pid");

          $this->db->join("doctor_interaction_sample_relation  disr" , "disr.pidoc_id=pid.id","Left");

         $this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");

        

        

        $this->db->where('disr.pidoc_id',$val['id']);

        

        $this->db->group_by('pid.doc_id'); 

        

       

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $doc_travel_info[$k]['sample'] = $query->row_array();

                 

                 

                 

        $arr = "pid.doc_id,GROUP_CONCAT(`pus`.`name` SEPARATOR ',') as `team_user`,team.team_id,team.crm_user_id,pid.crm_user_id as userid";

        

        $this->db->select($arr);

        

        $this->db->from("pharma_interaction_doctor pid");

        

        $this->db->join("doctor_interaction_with_team  team" , "team.pidoc_id=pid.id");

        $this->db->join("pharma_users pus" , "pus.id=team.team_id");

        

        $this->db->where('team.pidoc_id',$val['id']);

        

//        if($userid > 0){

//        $this->db->where('team.team_id',$userid);

//         }

        

        $this->db->where('pid.create_date >=', $start);

        $this->db->where('pid.create_date <=', $end);

        

        $this->db->group_by('team.pidoc_id'); 

        

//        $this->db->having('total_visits >=1 ');

        

        $query = $this->db->get();

//               echo $this->db->last_query(); die;

        $team_interaction[] = $query->row_array();

                 

             }

//             pr($team_interaction); die;

             

             

           $result = array('doc_info'=>$doc_travel_info,'team_info'=>$team_interaction);  

//             pr($result); die;

             

            return $result;

        }

        else{

            
            $result = array('doc_info'=>array(),'team_info'=>array());  
            return $result;

        } 

        

    }
    
    public function doctor_interaction_view($userid)
    {
	//echo $limit; die;  
     	$arr = " dl.doc_name as doctorname,pid.orignal_sale as actualsale,pid.id,`pid`.`meeting_sale` secondarysale, `pid`.`create_date` as `date_of_interaction`,d.dealer_name ,pl.company_name as pharmaname,pid.close_status";
        $this->db->select($arr);
        $this->db->from("pharma_interaction_doctor pid");
	$this->db->join("doctor_list dl","dl.doctor_id=pid.doc_id");
        $this->db->join("dealer d","d.dealer_id=pid.dealer_id","left");
        $this->db->join("pharmacy_list pl","pl.pharma_id=pid.dealer_id","left");
        $this->db->join("doctor_interaction_with_team team","team.pidoc_id=pid.id","left");
      	$this->db->where("pid.meeting_sale !=","");
      	$this->db->where("pid.status =",1);
	//$this->db->where("pid.dealer_id IS NOT NULL",NULL, FALSE);
        if($userid!=28 && $userid!=29 &&  $userid!=32)
        {
	        $this->db->where("(pid.crm_user_id=".$userid." or team.team_id=".$userid.")");
	}
        $query = $this->db->get();
	 // echo $this->db->last_query(); die;
        if($this->db->affected_rows())
        {
          return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    }
    
    public function pharmacy_interaction_view($userid)
    {
        $arr = " pl.company_name as pharmaname,pip.orignal_sale as actualsale,pip.id,`pip`.`meeting_sale` as secondarysale, `pip`.`create_date` as `date_of_interaction`,d.dealer_name,pip.close_status";
        $this->db->select($arr);
        $this->db->from("pharma_interaction_pharmacy pip");
        $this->db->join("pharmacy_list pl","pl.pharma_id=pip.pharma_id");
        $this->db->join("dealer d","d.dealer_id=pip.dealer_id","left");
        $this->db->join("pharmacy_interaction_with_team team","team.pipharma_id=pip.id","left");
        $this->db->where("pip.meeting_sale !=","");
        $this->db->where("pip.status =",1);
        if($userid!=28 && $userid!=29 &&  $userid!=32)
        {
          $this->db->where("(pip.crm_user_id=".$userid." or team.team_id=".$userid.")");
        }
        $query = $this->db->get();
    	// echo $this->db->last_query(); die;
        if($this->db->affected_rows())
        {
           return $query->result_array();
        }
        else
        {
          return FALSE;
        }
    }
    
    public function get_tp_report($userid='',$start='',$end='')
    {
	/* Geting Pharma Interaction */
	$start=date('Y-m-d', strtotime($start));
	$end=date('Y-m-d', strtotime($end));
	$arr = "stp.source,stp.destination,stp.dot,stp.remark,stp.assign_by,c.city_name as destination_city,c1.city_name as source_city,u.name,tst as strtime,tet as endtime";
        $this->db->select($arr);        
        $this->db->from("user_stp stp");
        $this->db->join("pharma_users u","u.id=stp.assign_by",'left');
        $this->db->join("city c","c.city_id=stp.destination",'left');
        $this->db->join("city c1","c1.city_id=stp.source",'left');
        $this->db->where('stp.crm_user_id',$userid);
        $this->db->where('stp.dot  >=', $start);
	$this->db->where('stp.dot  <=', $end);
        $queryIntearction = $this->db->get();
        if($this->db->affected_rows())
        {
		return $queryIntearction->result_array();
        }
        else
        {
        	return False;
        }
    }
   
}

