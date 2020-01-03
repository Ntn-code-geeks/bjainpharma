<?php



/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

class Report_model extends CI_Model {

    public function user_child_team($child){

         //$child = logged_user_child();
         $child_id = explode(',', $child);
 //         pr($child); die;
         $arr="pu.id as userid,pu.name as username";
         $this->db->select($arr);
         $this->db->from('pharma_users pu ');

           $this->db->where('user_status',1);

         if(!empty($child)){
             $where = "("; $total_child = count($child_id);
           foreach($child_id as $kc=>$valc){

               $where .="pu.id = '$valc'";

               if($total_child>$kc+1){
                   $where .= " OR ";
               }
             // $this->db->or_where('pu.id',$valc);

           }

           $where .= " ) ";
           $this->db->where($where);
         }
         $query = $this->db->get();
         // echo $this->db->last_query(); die;
         if($this->db->affected_rows()){
           return $query->result_array();
         }
         else{
           return FALSE;
         }
    }
    
    public function dealermaster_info($limit='',$start='',$data='',$city_search=''){
        $post = array_map('trim', $this->input->post());
        
        $cities_are = logged_user_cities($post['userCity']);
        
        $city_id=array();

        if($city_search=='')

        {

            $city_id=explode(',', $cities_are);

        }

        else

        {

            // $city_id[]=$city_search;
             $city_id=get_state_id($city_search);

        }
        
       $desig_id=logged_user_desig($post['userDesig']);
       $log_userid = logged_user_data($post['userId']);
        $arr = "d.sp_code,d.dealer_id as id,d.d_email as d_email,d.d_phone as d_ph,d.dealer_name as d_name,d.dealer_are,d.gd_id,d.status,d.blocked,d.city_pincode as city_pincode,,d.city_id as city_id";
        $this->db->select($arr);
        $this->db->from("dealer d");
//      $this->db->join("dealer s" , "s.dealer_id=sm.s_id");
        //$this->db->join("city c" , "c.city_id=d.city_id");
        //$this->db->join("state st" , "st.state_id=d.state_id");
        $this->db->join('pharma_users pu','pu.id=d.crm_user_id');
         if(!empty($data)){
         $this->db->like('d.dealer_name',$data);
         $this->db->or_like('d.d_email',$data);
         $this->db->or_like('d.d_phone',$data);
         $this->db->or_like('c.city_name',$data);
         $this->db->or_like('st.state_name',$data);
         $this->db->group_by('`d`.`dealer_id`');
//     }

        }
        $this->db->where('d.gd_id IS NULL',null,true);
        if($city_search!='')
        {
//            if(is_admin()){ 
                // $this->db->where('d.city_id',$city_search);
                $this->db->where('d.state_id',$city_id);
//            }
        }
         
        if($city_search=='')
        {
             $where='( 1=1';
            // $where  .= "  pu.user_designation_id >= $desig_id ";
             //$where  .= " AND d.crm_user_id = $log_userid ";

         }
         else
         {
            $where='( 1=2 ';
         }

           if(!empty($cities_are) && !empty($city_search)){
             $k=0;    
             foreach($city_id as $value){
                 $where  .= " OR d.city_id = $value ";
                 $k++;
         }
         }    
        $where  .= " ) ";
        $this->db->where($where);

       // $this->db->limit($limit, decode($start));

        

        $this->db->order_by("d.dealer_name","ASC");

        

        $query = $this->db->get();

    //echo $this->db->last_query(); die;

        

         if($this->db->affected_rows()){
            return json_encode($query->result_array());
        }

        else{

            

            return FALSE;

        }

        

    }
    
    public function pharmacy_list($id){
      $cityid = explode(',',$id );
      $arr = "pl.sp_code as sp_code,pl.pharma_id as id,pl.company_name as com_name,c.city_name,pl.pharmacy_status as status,pl.blocked";
      $this->db->select($arr);
      $this->db->from("pharmacy_list pl");
      $this->db->join("city c","c.city_id=pl.city_id");
      if(1==2 && !is_admin()){
        if(!empty($id)){
          foreach($cityid as $value){
           $this->db->or_where("pl.city_id",$value);  
          }
        }
        $this->db->or_where("pl.crm_user_id", logged_user_data());    // for show  logged user data pharmacy list too
      }
      $query = $this->db->get();
      //echo $this->db->last_query(); die;
      if($this->db->affected_rows())
      {
        return $query->result_array();
      }
      else{
        return FALSE;
      }
    }
    
    function userSpCode(){
        $post = array_map('trim', $this->input->post());
        $uiD=logged_user_data($post['userId']);
        $user_id=array($uiD);
        $usr_sp_codes = null;
        if(logged_user_child($post['child'])){
                $childur=logged_user_child($post['child']);
                $childEx=explode(', ',$childur);
                $allMember=array_merge($user_id,$childEx);
                $all_Sp_codes=array();
                $rest=[];
                foreach($allMember as $item){
                        $spcode=getuserSPcode($item);
                        $all_Sp_codes=explode(',',$spcode->sp_code);
                        $rest=array_merge($rest,$all_Sp_codes);
                }
                $usr_sp_codes=array_unique($rest);
        }else{
                $spcode=getuserSPcode($uiD);
                $usr_sp_codes=explode(',',$spcode->sp_code);
        }
        //dump($usr_sp_codes);die;
        return $usr_sp_codes;
    }


    public function doctormaster_info($limit='',$start='',$data='',$city_search='', $userDesig, $userId, $userCity){
        
       $desig_id=logged_user_desig($userDesig);
       $log_userid = logged_user_data($userId);
        
        $cities_are = logged_user_cities($userCity);
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
          $where_b .=" doc.crm_user_id = ".logged_user_data($userId) ;
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
    
    public function tour_info($userId){
            
        $result = array();
        $arr = "*";
        $this->db->select($arr);
        $this->db->from("user_stp");
        $this->db->where('crm_user_id',logged_user_data($userId));
        $query = $this->db->get();
        if($this->db->affected_rows()){
			$data=$query->result_array();
			foreach($data as $val){
				$title='';
				if($val['destination']==0)
				{
					$title='Holiday';
				}
				else
				{
					$title=$this->get_city_name($val['destination']);
				}
				if($val['assign_by']!=0)
				{
					$assign_by=get_user_name($val['assign_by']).' Sir';
				}
				else
				{
					$assign_by='';
				}
				$result[] = array(
                                                'title'=>$title,
                                                'start'=>$val['dot'].' '.$val['tst'],
                                                'end'=>$val['dot'].' '.$val['tet'],
                                                'backgroundColor'=>$val['color_id'],
                                                'description'=>$val['remark'],
                                                'time' =>date('h:i A', strtotime($val['tst'])),
                                                'endtime' =>date('h:i A', strtotime($val['tet'])),
                                                'visited'=>$val['visited'],
                                                'tour_id'=>$val['id'],
                                                'tour_now_date'=>date('d-m-Y',strtotime($val['dot'])),
                                                'assign_by'=>$assign_by,
                                                'source_city'=>$this->get_city_name($val['source']),
                                                'destination'=>$this->get_city_name($val['destination'])
				            );	
			}
        }
        $arrtour = "*";
        $con='find_in_set('.logged_user_data($userId).',user_ids)<>0';
        $this->db->select($arr);
        $this->db->from("assign_tour");
        $this->db->where($con);
        $query = $this->db->get();
       // echo $this->db->last_query();
       // die;
        if($this->db->affected_rows()){
			$data=$query->result_array();
			foreach($data as $val){
				$title='';
				$title=$this->get_city_name($val['destination']);
				$assign_by=get_user_name($val['assign_by']).' Sir';
				$result[] = array(
					'title'=>$title,
					'start'=>$val['tour_date'].' 00:00:00',
					'end'=>$val['tour_date'].' 23:59:59',
					'backgroundColor'=>'#f56954',
					'description'=>$val['remark'],
					'time' =>'',
					'endtime' =>'',
					'visited'=>'',
					'tour_id'=>'tour_date',
					'tour_now_date'=>date('d-m-Y',strtotime($val['tour_date'])),
					'assign_by'=>$assign_by,
					'source_city'=>'',
					'destination'=>$this->get_city_name($val['destination'])
				);	
			}
        }
        //return json_encode($result); 
        return $result;
        
    }

    public function get_city_name($id){

		$arr = "city_name";

        $this->db->select($arr);

        $this->db->from("city");

        $this->db->where('city_id',$id);

        $query = $this->db->get();

        if($this->db->affected_rows()){

			return $query->row()->city_name;

		}

        else{

            return ' ';

        }

    }
    
    public function sample_list($id='',$designationId){

        $arr = "sm.id,sm.sample_name,pu.name as sampleaddedby";

        $this->db->select($arr);

        $this->db->from("meeting_sample_master sm");



        $this->db->join("pharma_users pu" , "pu.id=sm.crm_user_id");

        

        if($designationId == 1){
         
            if($id!=''){

                $sm_id= urisafedecode($id);

                $this->db->where('sm.id',$sm_id);

            }

            $this->db->where('sm.sample_status',1);

//        $this->db->limit($limit, decode($start));

        }

        $query = $this->db->get();

//         echo $this->db->last_query(); die;

        if($this->db->affected_rows()){

            

            //return json_encode($query->result_array());
            return $query->result_array();

        }

        else{

            return FALSE;

        }

    }
    
    function validate_passcode_status($userId){
        $this->db->where('id', $userId);
        $query = $this->db->select('passcode');
        $query = $this->db->get('pharma_users');
        //echo $this->db->last_query();die;
        $result = $query->row();
        //dump($result);die;
        return $result;
    }
    
    function save_passcode($userId, $passcode){
        $this->db->where('id', $userId);        
        
        if($this->db->update('pharma_users', array('passcode' => $passcode))){
            return true;
        } else {
            return false;
        }  
        //echo $this->db->last_query();die;
    }
    
}

