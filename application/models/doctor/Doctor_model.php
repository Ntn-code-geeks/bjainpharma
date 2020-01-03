<?php

/* 
 * Niraj Kumar
 * Dated: 04-oct-2017
 * 
 * model for doctor details 
 */

class Doctor_model extends CI_Model {

public function __construct()
        {
                parent::__construct();
        }
    
    public function update_dealer_pharma($data=''){
        
        $doctor_dealer_pharma = 
                array(
                                  
                    'd_id'=>$data['dealerpharma'],
                   
                    'crm_user_id'=> logged_user_data(),
                    'last_update'=>savedate(),
                    'doc_status'=>1, 
                    
                );
        
        $this->db->where('doctor_id',$data['doctor_id']);
        $this->db->update('doctor_list',$doctor_dealer_pharma);
      //echo $this->db->last_query(); die;
         return ($this->db->affected_rows() != 1) ? false : true; 
        
    }

        public function add_doctormaster($data,$doc_id=''){
      
//        pr($data);
////        echo "i".$doc_id;
//        die;
    
            
//           $spcode_list = user_sp_code();
//           pr($spcode_list); die;
        if(!empty($data['dob'])){
       $dob = date('Y-m-d', strtotime($data['dob']));
        }
        else{
            $dob=NULL;
        }
        
        if(isset($data['dealer_id']) && !empty($data['dealer_id'])){
            $dealers_id=implode(',',$data['dealer_id']);
        }
        
         $doctor_data = 
                array(
                    'doc_name'=>$data['doctor_name'],
                    'doc_email'=>$data['doctor_email'],
                    'doc_phone'=>$data['doctor_num'],
                    'doc_address'=>$data['address'],
                    'doc_gender'=>$data['gender'],
                    'city_pincode'=>$data['city_pin'],
                    'doc_married_status'=>$data['married'],
                    'doc_spouse_name'=>$data['sp_name'],
                    'doc_spouse_email'=>$data['sp_email'],
                    'state_id'=>$data['doctor_state'],
                    'city_id'=>$data['doctor_city'],
                    'sp_code'=>$data['sp_code'],
                    'doc_dob'=>$dob,                 
                    'd_id'=>$dealers_id,
                    'doc_about'=>$data['about'],
                    'crm_user_id'=> logged_user_data(),
                    'last_update'=>savedate(),
                    'doc_status'=>1, 
                    
                    'doc_navigate_id'=>$data['doc_navigon'],
                    'doctor_status_id'=>$data['doc_status'],
                );
         
         if($doc_id !=''){
            
            $this->db->where('doctor_id',$doc_id);
           $this->db->update('doctor_list',$doctor_data);
         
                    if ($this->db->trans_status() === TRUE)
                           {
                              return true;

                           }
                           else{

                               return false;

                           }   

        }else{
         
//         echo $dealers_id; die;
         
          $this->db->insert('doctor_list',$doctor_data); 
          
           
          $ap_id=$this->db->insert_id();
          $newid = "doc_".$ap_id;
          
          $doctor_data = 
                array(
                    'doctor_id'=>$newid,
                    'doc_name'=>$data['doctor_name'],
                    'doc_email'=>$data['doctor_email'],
                    'doc_phone'=>$data['doctor_num'],
                    'doc_address'=>$data['address'],
                    'doc_gender'=>$data['gender'],
                    'doc_married_status'=>$data['married'],
                    'doc_spouse_name'=>$data['sp_name'],
                    'doc_spouse_email'=>$data['sp_email'],
                    'doc_dob'=>$dob,
                    'sp_code'=>$data['sp_code'],
                    'state_id'=>$data['doctor_state'],
                    'city_id'=>$data['doctor_city'],
                    'd_id'=>$dealers_id,
                    'doc_about'=>$data['about'],
                    'crm_user_id'=> logged_user_data(),
                    'last_update'=>savedate(),
                    'doc_status'=>1, 
                    
                    'doc_navigate_id'=>$data['doc_navigon'],
                    'doctor_status_id'=>$data['doc_status'],
                
                    
                );
         
//          pr($doctor_data); die;
           $this->db->where('id',$ap_id);
           $this->db->update('doctor_list',$doctor_data);
          
//          echo $this->db->last_query(); die;
            
            return ($this->db->affected_rows() != 1) ? false : true; 
        }
 
    }
    
    public function totaldata($city_search=''){
        
        $desig_id=logged_user_desig();
		$log_userid = logged_user_data();
        
		$cities_are = logged_user_cities();
		$city_id=array();
		if($city_search=='')
		{
			$city_id=explode(',', $cities_are);
		}
		else
		{
			$city_id[]=$city_search;
		}
        
        $boss_are = logged_user_boss();
        $boss_id=explode(',', $boss_are);
        
        $doc_are = logged_user_doc();
        $doc_id=explode(',', $doc_are);
         
        
        $arr = "doc.doctor_id as id";
        $this->db->select($arr);
        $this->db->from("doctor_list doc");
		$this->db->join("city c" , "c.city_id=doc.city_id");
        $this->db->join("state st" , "st.state_id=doc.state_id");
        
		if($city_search!='')
		{

			if(is_admin()){ 
				$this->db->where('doc.city_id',$city_search);
			}
		}
		
        if(!is_admin()){
     
        $where_b ='( '; 
//         $this->db->or_where('pharma.crm_user_id', logged_user_data());
          $where_b .=" doc.crm_user_id = ".logged_user_data(). " AND ( " ;
         if(!empty($boss_are)){
             $k=0;    
            foreach($boss_id as $value){
//          $this->db->or_where('pharma.city_id',$value);
                
                 if($k > 0 && count($boss_id)!=$k){
                   $where_b .= " OR ";
               }
                
                
                $where_b  .= " doc.crm_user_id  != $value ";
               
               
                
                $k++;
            }
            
           
           }
         $where_b .=' ) ) ';
		 
		if($city_search=='')
		{
			$this->db->or_where($where_b); 
		}
        
        if(!empty($cities_are)){
             $where='( '; 
                $k=0;    
            foreach($city_id as $value){
//          $this->db->or_where('pharma.city_id',$value);
                $where  .= " doc.city_id = $value ";
                 $k++;
               if($k > 0 && count($city_id)!=$k){
                   $where .= " OR ";
               }
               
            }
             $where .=' )';
             $this->db->or_where($where); // changes from where to or beacuase other city doctor added by user is not shown
        }
        
        
          if(!empty($doc_are)){
             $where='( '; 
                $k=0;    
            foreach($doc_id as $value){
//          $this->db->or_where('pharma.city_id',$value);
                $where  .= " doc.doctor_id = '$value'";
                 $k++;
                
               if($k > 0 && count($doc_id)!=$k){
                   $where .= " OR ";
               }
               
            }
             $where .=' )';
             $this->db->or_where($where);
        }

        
    }
        
        $query = $this->db->get();
		
//         echo $this->db->last_query(); die;
        if ($query->num_rows() > 0) {

          $data=$query->num_rows();
 
            return $data;
        }
        else
            {
               return false;
         }
        
    }
 
    public function doctormaster_info($limit='',$start='',$data='',$city_search=''){
        
       $desig_id=logged_user_desig();
       $log_userid = logged_user_data();
        
        $cities_are = logged_user_cities();
		$city_id=array();
		if($city_search=='')
		{
			$city_id=explode(',', $cities_are);
		}
		else
		{
			$city_id[]=$city_search;
		}
//        echo $city_search; die;
           $boss_are = logged_user_boss();
          $boss_id=explode(',', $boss_are);
        
           $doc_are = logged_user_doc();
          $doc_id=explode(',', $doc_are);
          
          
         $arr = "doc.sp_code,doc.doctor_id as id,doc.d_id as dealers_id,doc.doc_name as d_name,doc.doc_email as d_email,doc.doc_phone as d_ph,doc.doc_status as status,doc.blocked,doc.city_pincode as city_pincode,doc.city_id as city_id";
        $this->db->select($arr);
        $this->db->from("doctor_list doc");
//        $this->db->join("srm_school_master sm" , "cl.s_id=sm.id");
//        $this->db->join("dealer d" , "d.dealer_id=doc.d_id");
       // $this->db->join("city c" , "c.city_id=doc.city_id");
       // $this->db->join("state st" , "st.state_id=doc.state_id");

        if(!empty($data)){

         $this->db->like('doc.doc_name',$data);
//       $this->db->or_like('cl.c_email',$data);
//       $this->db->or_like('s.s_phone',$data);
         $this->db->or_like('c.city_name',$data);
         $this->db->or_like('st.state_name',$data);
//     }
        }
        
		
		if($city_search!='')
		{

//			if(is_admin()){ 
				$this->db->where('doc.city_id',$city_search);
//			}
                        
		}
        if(!is_admin()){
        
        $where_b ='( '; 
//         $this->db->or_where('pharma.crm_user_id', logged_user_data());
          $where_b .=" doc.crm_user_id = ".logged_user_data() ;
         if(!empty($boss_are)){
             $where_b .=" AND ( ";
             $k=0;    
            foreach($boss_id as $value){
//          $this->db->or_where('pharma.city_id',$value);
                
                 if($k > 0 && count($boss_id)!=$k){
                   $where_b .= " OR ";
               }
                
                
                $where_b  .= " doc.crm_user_id  != $value ";
               
               
                
                $k++;
            }
            
            $where_b .=' ) ';
           }
         $where_b .=' ) ';
		 if($city_search=='')
		{
			//$this->db->or_where($where_b); 
		}
          
        
        if(!empty($cities_are) && !empty($city_search)){
             $where='( '; 
                $k=0;    
            foreach($city_id as $value){
//          $this->db->or_where('pharma.city_id',$value);
                $where  .= " doc.city_id = $value ";
                 $k++;
               if($k > 0 && count($city_id)!=$k){
                   $where .= " OR ";
               }
               
            }
             $where .=' )';
             $this->db->or_where($where); // changes from where to or beacuase other city doctor added by user is not shown
        }
        
        
          if(!empty($doc_are)){
             $where='( '; 
                $k=0;    
            foreach($doc_id as $value){
//          $this->db->or_where('pharma.city_id',$value);
                $where  .= " doc.doctor_id = '$value'";
                 $k++;
                
               if($k > 0 && count($doc_id)!=$k){
                   $where .= " OR ";
               }
               
            }
             $where .=' )';
             $this->db->or_where($where);
        }

        
    }

        
        $query = $this->db->get();
//echo $this->db->last_query(); die;
         if($this->db->affected_rows()){
            
            return json_encode($query->result_array());
        }
        else{
            
            return FALSE;
        }
        
    }
    
     public function doctormaster($filter){
        
        $spcode = explode(',',$this->session->userdata('sp_code'));
          
         $desig_id=logged_user_desig();
        $log_userid = logged_user_data();
        
               
           $boss_are = logged_user_boss();
          $boss_id=explode(',', $boss_are);
        
           $doc_are = logged_user_doc();
          $doc_id=explode(',', $doc_are);
        
          $limit = isset($filter['limit']) ? $filter['limit'] : 0;

          $start = isset($filter['start']) ? $filter['start'] : 0;
                       
          $searchIn = isset($filter['searchin']) ? $filter['searchin'] : 1;
          
        
        $arr = "doc.sp_code,doc.doctor_id as id,doc.d_id as dealers_id,doc.doc_name as d_name,"
                . "doc.doc_email as d_email,doc.doc_phone as d_ph,c.city_name,"
                . "doc.doc_status as status,doc.blocked,doc.city_pincode as city_pincode,doc.city_id as city_id";
        $this->db->select($arr);
        $this->db->from("doctor_list doc");
       $this->db->join("city c" , "c.city_id=doc.city_id");
        if($searchIn!=1){

//         $this->db->like('doc.doc_name',$searchIn);
//         $this->db->or_like('doc.doc_phone',$searchIn);
//         $this->db->or_like('doc.city_pincode',$searchIn);
//         $this->db->or_like('doc.doc_email',$searchIn);
//         $this->db->or_like('c.city_name',$searchIn);
            
           $like_cond = " (`doc`.`doc_name` LIKE '%$searchIn%' "
                        . " OR `doc`.`doc_phone` LIKE '%$searchIn%' "
                        . " OR `doc`.`city_pincode` LIKE '%$searchIn%'"
                        . " OR `doc`.`doc_email` LIKE '%$searchIn%' "
                        . "OR `c`.`city_name` LIKE '%$searchIn%' ) "; 
           $this->db->where($like_cond); 
            
        
        }
        
	
        if(!is_admin()){
            
             $this->db->where_in('doc.sp_code',$spcode); // changes from where to or beacuase other city doctor added by user is not shown
       
        
        $where_b ='( '; 
//         $this->db->or_where('pharma.crm_user_id', logged_user_data());
          $where_b .=" doc.crm_user_id = ".logged_user_data() ;
         if(!empty($boss_are)){
             $where_b .=" AND ( ";
             $k=0;    
            foreach($boss_id as $value){
//          $this->db->or_where('pharma.city_id',$value);
                
                 if($k > 0 && count($boss_id)!=$k){
                   $where_b .= " OR ";
               }
                
                
                $where_b  .= " doc.crm_user_id  != $value ";
               
               
                
                $k++;
            }
            
            $where_b .=' ) ';
           }
         $where_b .=' ) ';
		
          
        
        
        
          if(!empty($doc_are)){
             $where='( '; 
                $k=0;    
            foreach($doc_id as $value){
//          $this->db->or_where('pharma.city_id',$value);
                $where  .= " doc.doctor_id = '$value'";
                 $k++;
                
               if($k > 0 && count($doc_id)!=$k){
                   $where .= " OR ";
               }
               
            }
             $where .=' )';
             $this->db->or_where($where);
        }

        
    }
    $this->db->limit($limit,$start);
    $this->db->order_by($filter['order'], $filter['dir']);
                            
        
        $query = $this->db->get();
//echo $this->db->last_query(); die;
         if($this->db->affected_rows()){
            
            return $query->result_array();
        }
        else{
            
            return FALSE;
        }
        
    }
    
//    
    public function doctormaster_totaldata($filter){
        
        $spcode = explode(',',$this->session->userdata('sp_code'));
          
        $desig_id=logged_user_desig();
        $log_userid = logged_user_data();
        
               
           $boss_are = logged_user_boss();
          $boss_id=explode(',', $boss_are);
        
           $doc_are = logged_user_doc();
          $doc_id=explode(',', $doc_are);
        
          $limit = isset($filter['limit']) ? $filter['limit'] : 0;

          $start = isset($filter['start']) ? $filter['start'] : 0;
                       
          $searchIn = isset($filter['searchin']) ? $filter['searchin'] : 1;
          
        
        $arr = "doc.sp_code,doc.doctor_id as id,doc.d_id as dealers_id,doc.doc_name as d_name,"
                . "doc.doc_email as d_email,doc.doc_phone as d_ph,c.city_name,"
                . "doc.doc_status as status,doc.blocked,doc.city_pincode as city_pincode,doc.city_id as city_id";
        $this->db->select($arr);
        $this->db->from("doctor_list doc");
        $this->db->join("city c" , "c.city_id=doc.city_id");
//        if(!empty($data)){
//
//         $this->db->like('doc.doc_name',$searchIn);
//         $this->db->or_like('doc.doc_phone',$searchIn);
//         $this->db->or_like('doc.city_pincode',$searchIn);
//         $this->db->or_like('doc.doc_email',$searchIn);
//         $this->db->or_like('c.city_name',$searchIn);
//         $this->db->or_like('st.state_name',$searchIn);
//        }
        
	
        if(!is_admin()){
            
             $this->db->where_in('doc.sp_code',$spcode); // changes from where to or beacuase other city doctor added by user is not shown
       
        
        $where_b ='( '; 
//         $this->db->or_where('pharma.crm_user_id', logged_user_data());
          $where_b .=" doc.crm_user_id = ".logged_user_data() ;
         if(!empty($boss_are)){
             $where_b .=" AND ( ";
             $k=0;    
            foreach($boss_id as $value){
//          $this->db->or_where('pharma.city_id',$value);
                
                 if($k > 0 && count($boss_id)!=$k){
                   $where_b .= " OR ";
               }
                
                
                $where_b  .= " doc.crm_user_id  != $value ";
               
               
                
                $k++;
            }
            
            $where_b .=' ) ';
           }
         $where_b .=' ) ';
		
          
        
        
        
          if(!empty($doc_are)){
             $where='( '; 
                $k=0;    
            foreach($doc_id as $value){
//          $this->db->or_where('pharma.city_id',$value);
                $where  .= " doc.doctor_id = '$value'";
                 $k++;
                
               if($k > 0 && count($doc_id)!=$k){
                   $where .= " OR ";
               }
               
            }
             $where .=' )';
             $this->db->or_where($where);
        }

        
    }
//    $this->db->limit($limit,$start);
    $this->db->order_by($filter['order'], $filter['dir']);
                            
        
        $query = $this->db->get();
//echo $this->db->last_query(); die;
         if($this->db->affected_rows()){
            
            return count($query->result_array());
        }
        else{
            
            return FALSE;
        }
        
    }
    
    
     public function doctormaster_filter_totaldata($filter){
        
        $spcode = explode(',',$this->session->userdata('sp_code'));
          
         $desig_id=logged_user_desig();
        $log_userid = logged_user_data();
        
               
           $boss_are = logged_user_boss();
          $boss_id=explode(',', $boss_are);
        
           $doc_are = logged_user_doc();
          $doc_id=explode(',', $doc_are);
        
          $limit = isset($filter['limit']) ? $filter['limit'] : 0;

          $start = isset($filter['start']) ? $filter['start'] : 0;
                       
          $searchIn = isset($filter['searchin']) ? $filter['searchin'] : 1;
          
        
        $arr = "doc.sp_code,doc.doctor_id as id,doc.d_id as dealers_id,doc.doc_name as d_name,"
                . "doc.doc_email as d_email,doc.doc_phone as d_ph,c.city_name,"
                . "doc.doc_status as status,doc.blocked,doc.city_pincode as city_pincode,doc.city_id as city_id";
        $this->db->select($arr);
        $this->db->from("doctor_list doc");
        $this->db->join("city c" , "c.city_id=doc.city_id");
       if($searchIn!=1){
            $where_like = "(`doc`.`doc_name` LIKE '%$searchIn%' OR `doc`.`doc_phone` LIKE '%$searchIn%'"
                            . " OR `doc`.`city_pincode` LIKE '%$searchIn%'"
                            . " OR `doc`.`doc_email` LIKE '%$searchIn%' "
                            . "OR `c`.`city_name` LIKE '%$searchIn%' )";
            
            $this->db->where($where_like);

         
        }
        
	
        if(!is_admin()){
            
             $this->db->where_in('doc.sp_code',$spcode); // changes from where to or beacuase other city doctor added by user is not shown
       
        
            $where_b ='( '; 
//         $this->db->or_where('pharma.crm_user_id', logged_user_data());
          $where_b .=" doc.crm_user_id = ".logged_user_data() ;
         if(!empty($boss_are)){
             $where_b .=" AND ( ";
             $k=0;    
            foreach($boss_id as $value){
//          $this->db->or_where('pharma.city_id',$value);
                
                 if($k > 0 && count($boss_id)!=$k){
                   $where_b .= " OR ";
               }
                
                
                $where_b  .= " doc.crm_user_id  != $value ";
               
               
                
                $k++;
            }
            
            $where_b .=' ) ';
           }
         $where_b .=' ) ';
		
          
        
        
        
          if(!empty($doc_are)){
             $where='( '; 
                $k=0;    
            foreach($doc_id as $value){
//          $this->db->or_where('pharma.city_id',$value);
                $where  .= " doc.doctor_id = '$value'";
                 $k++;
                
               if($k > 0 && count($doc_id)!=$k){
                   $where .= " OR ";
               }
               
            }
             $where .=' )';
             $this->db->or_where($where);
        }

        
    }
    $this->db->order_by($filter['order'], $filter['dir']);
                            
        
        $query = $this->db->get();
//echo $this->db->last_query(); die;
         if($this->db->affected_rows()){
            
            return count($query->result_array());
        }
        else{
            
            return FALSE;
        }
        
    }
    
    public function edit_doctor($cm_id){

        $arr = "doc.sp_code,doc.doctor_status_id as doc_status_id,"
                . "doc.city_pincode as city_pincode,doc.doc_navigate_id as doc_navigon,"
                . "doc.doctor_id,doc.id as id,doc.d_id as dealers_id,doc.doc_name as d_name,"
                . "doc.doc_email as d_email,doc.doc_phone as d_ph,doc.d_id as d_id,"
                . "doc.doc_address as address,doc.doc_gender as gender,"
                . "doc.doc_married_status as married_status,doc.doc_spouse_name as spouse_name,"
                . "doc.doc_spouse_email as spouse_email,doc.doc_dob as dob,doc.doc_about as about,"
                . "doc.state_id,doc.city_id,c.city_name,st.state_name";
        $this->db->select($arr);
        $this->db->from("doctor_list doc");
//        $this->db->join("srm_school_master sm" , "cl.s_id=sm.id");
//        $this->db->join("school s" , "s.school_id=cl.s_id");
         $this->db->join("city c" , "c.city_id=doc.city_id");
        $this->db->join("state st" , "st.state_id=doc.state_id");
        $this->db->where("doc.doctor_id",$cm_id);
        
        
          $query = $this->db->get();
//         echo $this->db->last_query(); die;
         if($this->db->affected_rows()){
            
            return json_encode($query->row());
        }
        else{
            
            return FALSE;
        }
    }
    
// doctor interaction info
    public function doctor_interaction_view($id=''){
        
          if($id!=''){
        $arr = "pl.company_name as pharma_name,d.dealer_name as deal_name,pid.id,pu.name as interactionBy,pid.meeting_sale,pid.meet_or_not_meet,pid.remark,pid.follow_up_action,pid.create_date as date_of_interaction ";
        $this->db->select($arr);
        $this->db->from("pharma_interaction_doctor pid");
        $this->db->join("dealer d","d.dealer_id=pid.dealer_id","left");
        $this->db->join("pharmacy_list pl","pl.pharma_id=pid.dealer_id","left");
//        $this->db->join("meeting_sample_master msm","msm.id=doc_sample.sample_id","left");
//        
        $this->db->join("pharma_users pu","pu.id=pid.crm_user_id","left");
        
        
        $this->db->where("pid.doc_id",$id);
        $this->db->where("pid.status",1);
        
        $query = $this->db->get();
//       echo $this->db->last_query(); die;
      
        if($this->db->affected_rows()){
                 $doc_info=$query->result_array();
//                 pr($doc_info);
//                 $doc_samples_info = array();
             foreach($doc_info as $k=>$val){    
             $arr = " GROUP_CONCAT(`msm`.`sample_name` SEPARATOR ',') AS samples ";
        $this->db->select($arr);
        $this->db->from("pharma_interaction_doctor pid");
        $this->db->join("doctor_interaction_sample_relation doc_sample","doc_sample.pidoc_id=pid.id");
        $this->db->join("meeting_sample_master msm","msm.id=doc_sample.sample_id");
        
        
        $this->db->where("pid.id",$val['id']);
          $query = $this->db->get();
          $doc_info[$k]['samples'] = $query->row();
             }
             
//             pr($doc_info); die;
             
            return json_encode($doc_info);
        }
        else{
            
            return FALSE;
        }
        
        
        }
    }




    public function meeting_sample_master(){
        $arr="id,sample_name";
        $this->db->select($arr);
        $this->db->from('meeting_sample_master');
        $query= $this->db->get();
        
        if($this->db->affected_rows()){
            
            return json_encode($query->result_array());
        }
        else{
            
            return FALSE;
        }
        
    }
    
     
    public function doctor_totaldata($data=''){
        
        $arr = "dl.doctor_id as id";
        $this->db->select($arr);
        $this->db->from("doctor_list dl");
        $this->db->join("city c" , "c.city_id=dl.city_id");
        $this->db->join("state st" , "st.state_id=dl.state_id");
        
        if(!empty($data)){

         
         $this->db->like('dl.doc_name',$data);
         $this->db->or_like('dl.doc_email',$data);
         $this->db->or_like('dl.doc_phone',$data);
         $this->db->or_like('c.city_name',$data);
         $this->db->or_like('st.state_name',$data);
     }

    
        
        $query = $this->db->get();
//         echo $this->db->last_query(); die;
        if ($query->num_rows() > 0) {

          $data=$query->num_rows();
 
            return $data;
        }
        else
            {
               return false;
         }
        
    }
    
    
    // doctor id of logged user's child user 
    public function childs_doctor_data($loggeduser_id){
        
        $arr=" GROUP_CONCAT(ubr.user_id SEPARATOR ',') as childuserid, 
GROUP_CONCAT(ubr2.user_id SEPARATOR ',') as childuserid2, GROUP_CONCAT(ubr3.user_id SEPARATOR ',') as childuserid3 ,GROUP_CONCAT(ubr4.user_id SEPARATOR ',') as childuserid4,GROUP_CONCAT(ubr5.user_id SEPARATOR ',') as childuserid5, GROUP_CONCAT(udr.doc_id SEPARATOR ',') as childdocid,GROUP_CONCAT(udr2.doc_id SEPARATOR ',') as childdocid2, GROUP_CONCAT(udr3.doc_id SEPARATOR ',') as childdocid3,GROUP_CONCAT(udr4.doc_id SEPARATOR ',') as childdocid4,GROUP_CONCAT(udr5.doc_id SEPARATOR ',') as childdocid5
 ";
       
        $this->db->select($arr);
        $this->db->from('user_bossuser_relation ubr ');
        $this->db->join('user_bossuser_relation ubr2 ','ubr.user_id=ubr2.boss_id','left');
        $this->db->join("user_bossuser_relation ubr3" , "ubr2.user_id=ubr3.boss_id",'left');
        $this->db->join("user_bossuser_relation ubr4" , "ubr3.user_id=ubr4.boss_id",'left');
        $this->db->join("user_bossuser_relation ubr5" , "ubr4.user_id=ubr5.boss_id",'left');
        
        $this->db->join("user_doctor_relation udr" , "udr.user_id=ubr.user_id",'left');
        $this->db->join("user_doctor_relation udr2" , "udr2.user_id=ubr2.user_id",'left');
        $this->db->join("user_doctor_relation udr3" , "udr3.user_id=ubr3.user_id",'left');
        $this->db->join("user_doctor_relation udr4" , "udr4.user_id=ubr4.user_id",'left');
        $this->db->join("user_doctor_relation udr5" , "udr5.user_id=ubr5.user_id",'left');
  
        $this->db->where('ubr.boss_id',$loggeduser_id);
        
        
        
        $query= $this->db->get();
//        echo $this->db->last_query(); die;
        if($this->db->affected_rows()){
            
            return json_encode($query->row());
        }
        else{
            
            return FALSE;
        }
        
        
        
    }
    
    
    // doctor data of childs doctor
    public function childs_doctor($limit,$start,$childuserid,$childdocid){
        $user_id = array_unique(explode(',', $childuserid),SORT_NATURAL);
        $doc_id = array_unique(explode(',', $childdocid),SORT_NATURAL);
        $arr = "doc.doctor_id as id,doc.sp_code,doc.d_id as dealers_id,doc.doc_name as d_name,doc.doc_email as d_email,doc.doc_phone as d_ph,doc.doc_status as status,doc.blocked,doc.city_pincode as city_pincode,doc.city_id as city_id";
        $this->db->select($arr);
        $this->db->from("doctor_list doc");
       /* $this->db->join("city c" , "c.city_id=doc.city_id");
        $this->db->join("state st" , "st.state_id=doc.state_id");*/
        if(isset($doc_id)){
            foreach($doc_id as $k_doc=>$val_doc){
            $this->db->or_where('doc.doctor_id',trim($val_doc));
            }
        }
        if(isset($user_id)){
            foreach($user_id as $k_u=>$val_u){
            $this->db->or_where('doc.crm_user_id',$val_u);
            }
        }
        $this->db->limit($limit, decode($start));
        $query = $this->db->get();
        //echo $this->db->last_query()."<br><br>"; 
        if($this->db->affected_rows()){
            return json_encode($query->result_array());
        }
        else{
            
            return FALSE;
        }
        
        
        
    }
    
    
    // total child record
    public function total_child_data($childuserid,$childdocid){
       
        
        $user_id = array_unique(explode(',', $childuserid),SORT_NATURAL);
        
        $doc_id = array_unique(explode(',', $childdocid),SORT_NATURAL);
        
        
         $arr = "doc.doctor_id as id";
        $this->db->select($arr);
        $this->db->from("doctor_list doc");

        $this->db->join("city c" , "c.city_id=doc.city_id");
        $this->db->join("state st" , "st.state_id=doc.state_id");
      
        if(isset($doc_id)){
            foreach($doc_id as $k_doc=>$val_doc){
            $this->db->or_where('doc.doctor_id',trim($val_doc));
            }
        }
        
        if(isset($user_id)){
            foreach($user_id as $k_u=>$val_u){
            $this->db->or_where('doc.crm_user_id',$val_u);
            }
        }
   
        $query = $this->db->get();
//         echo $this->db->last_query(); die;
        if ($query->num_rows() > 0) {

          $data=$query->num_rows();
 
            return $data;
        }
        else
            {
               return false;
         }
        
    }
    
    
    
    
     // inactive doctor
    public function inactive_doctormaster($id=''){
        
         $doctor_data= array(
             'crm_user_id'=> logged_user_data(),
             'last_update'=>savedate(),
             'doc_status'=>0, 
        );
        
         $this->db->where('doctor_id',$id);
           $this->db->update('doctor_list',$doctor_data);
           
            if ($this->db->trans_status() === TRUE)
                           {
                              return true;

                           }
                           else{

                               return false;

                           }  
        
    }
    
    
     // active doctor
    public function active_doctormaster($id=''){
        
         $doctor_data= array(
             'crm_user_id'=> logged_user_data(),
             'last_update'=>savedate(),
             'doc_status'=>1, 
        );
        
        $this->db->where('doctor_id',$id);
        $this->db->update('doctor_list',$doctor_data);
          
            if ($this->db->trans_status() === TRUE)
                           {
                              return true;

                           }
                           else{

                               return false;

                           }  
        
    }
    
    
      // Blocked doctor
    public function blocked_doctormaster($id=''){
        
         $doctor_data= array(
             'crm_user_id'=> logged_user_data(),
             'last_update'=>savedate(),
             'blocked'=>1, 
        );
        
        $this->db->where('doctor_id',$id);
        $this->db->update('doctor_list',$doctor_data);
         
            if ($this->db->trans_status() === TRUE)
                           {
                              return true;

                           }
                           else{

                               return false;

                           }  
        
    }
   
    
    
       // Remain doctor
    public function remain_doctormaster($id=''){
        
         $doctor_data= array(
             'crm_user_id'=> logged_user_data(),
             'last_update'=>savedate(),
             'blocked'=>0, 
        );
        
        $this->db->where('doctor_id',$id);
        $this->db->update('doctor_list',$doctor_data);
         
            if ($this->db->trans_status() === TRUE)
                           {
                              return true;

                           }
                           else{

                               return false;

                           }  
        
    }
    
    
    // show doctor status
    public function doc_status(){
        
        $arr = "doc_s.status_id,doc_s.status_name as doc_status_name";
        $this->db->select($arr);
        $this->db->from('doctor_status doc_s');
        
        $query = $this->db->get();
        
        if($this->db->affected_rows()){
            
            return json_encode($query->result_array());
        }
        else{
            
            return FALSE;
        }
        
        
    }
	
	public function doc_last_id(){
        $this->db->select_max('id');
		$query = $this->db->get('doctor_list');
		$row = $query->row_array();
		return $row['id'];
    }
	
	// public function doc_import_save($data){
	// 	$this->db->select('*');
	// 	$this->db->from('doctor_list');
	// 	$this->db->where('doc_phone',$data['doc_phone']);
	// 	$query = $this->db->get();
	// 	if ($query->num_rows() == 0) {
	// 	    $this->db->insert('doctor_list', $data);
	// 		return TRUE;
	// 	}
	// 	else
	// 	{
	// 		return False;
	// 	}
 //    }

    public function doc_import_save($data){
		$this->db->select('*');
		$this->db->from('doctor_list');
		$this->db->where('doc_phone',$data['doc_phone']);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			$this->db->insert('doctor_list', $data);
			return TRUE;
		}
		if($query->num_rows() == 1){
			$get_data=$query->row();
		if(!empty($data['doc_name'])){$doc_name=$data['doc_name'];}else{ $doc_name=$get_data->doc_name; }
		if(!empty($data['doc_email'])){$doc_email=$data['doc_email'];}else{ $doc_email=$get_data->doc_email; }
		if(!empty($data['doc_address'])){$doc_adr=$data['doc_address'];}else{ $doc_adr=$get_data->doc_address; }
		if(!empty($data['city_id'])){$doc_ctyid=$data['city_id'];}else{ $doc_ctyid=$get_data->city_id; }
		if(!empty($data['state_id'])){$doc_stid=$data['state_id'];}else{ $doc_stid=$get_data->state_id; }
		if(!empty($data['doc_gender'])){$doc_gend=$data['doc_gender'];}else{ $doc_gend=$get_data->doc_gender; }
		if(!empty($data['sp_code'])){$doc_spcode=$data['sp_code'];}else{ $doc_spcode=$get_data->sp_code; }
		if(!empty($data['city_pincode'])){$doc_pin=$data['city_pincode'];}else{ $doc_pin=$get_data->city_pincode; }
		if(!empty($data['crm_user_id'])){$doc_crm=$data['crm_user_id'];}else{ $doc_crm=$get_data->crm_user_id; }

		$dataArr=array(
			'doc_name' => $doc_name,
			'doc_email' => $doc_email,
			'doc_address' => $doc_adr,
			'city_id' => $doc_ctyid,
			'state_id' => $doc_stid,
			'doc_gender' => $doc_gend,
			'city_pincode' => $doc_pin,
			'sp_code' => $doc_spcode,
			'crm_user_id' => $doc_crm,
			);
			// $dataArr=array(
			// 	'doc_name' => $data['doc_name'],
			// 	'doc_email' => $data['doc_email'],
			// 	'doc_address' => $data['doc_address'],
			// 	'city_id' => $data['city_id'],
			// 	'state_id' => $data['state_id'],
			// 	'doc_gender' => $data['doc_gender'],
			// 	'city_pincode' => $data['city_pincode'],
			// 	'sp_code' => $data['sp_code'],
			// 	'crm_user_id' => $data['crm_user_id'],
			// 	'doc_status' => $data['doc_status']
			// );
			$this->db->where('doc_phone',$data['doc_phone']);
			$this->db->update('doctor_list',$dataArr);
			return TRUE;
		}else{
			return False;
		}
	}
    
	public function get_doctor_data($id=''){
		$this->db->select('doc_phone,doc_email,doc_name');
		$this->db->from('doctor_list');
		$this->db->where('doctor_id',$id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return  $query->row();
		}
		else
		{
			return False;
		}
    }
	
	public function get_log__doctor_data($id){
		$this->db->select('*');
		$this->db->from('log_interaction_data');
		$this->db->where('person_id',$id);
		$this->db->where('crm_user_id',logged_user_data());		
                $this->db->order_by('id','desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return  $query->row();
		}
		else
		{
			return False;
		}
    }
	
	public function get_orderamount($id){
        $arr = "order_amount,provider,mail_provider";
        $this->db->select($arr);
        $this->db->from("interaction_order");
        $this->db->where("interaction_id",0);
        $this->db->where("crm_user_id",logged_user_data());
        $this->db->where("interaction_person_id",$id);
        $query = $this->db->get();
        if($this->db->affected_rows()){
			// return $result=$query->row()->order_amount;
          return $result=$query->row();
		}
        else{
            return FALSE;
        }
    }



    public function total_doctor_data($sp_code){
        $spcode = explode(',',$sp_code);
        $var1=array();
        foreach ($spcode as  $val){
            $arr = "*";
            $this->db->select($arr);
            $this->db->from("doctor_list");
            $this->db->where("sp_code" , $val);
            $query = $this->db->get();
            if($this->db->affected_rows()){
                $var1[$val]=count($query->result_array());
            }
        }
        return array_sum($var1);

    }


    public function total_doctors(){
		$var1=array();
		$arr = "*";
		$this->db->select($arr);
		$this->db->from("doctor_list");
		$query = $this->db->get();
		if($this->db->affected_rows()){
			$var1[]=count($query->result_array());
		}
		return array_sum($var1);
	}
    
}