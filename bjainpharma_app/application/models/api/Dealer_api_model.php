<?php


/*

 * 
 */

class Dealer_api_model extends CI_Model {

 //    public function get_dealer_list($dataArr)
 //    {
 //    	$sp=0;
	// if($dataArr['sp_code']!='')
	// {
	// 	$sp=str_replace(',','|',$dataArr['sp_code']);
	// }
	
 // 	$arr = "d.dealer_id as id,d.d_email as d_email,d.d_phone as d_ph,d.dealer_name as d_name,d.status,d.blocked,d.city_pincode as city_pincode,d.city_id as city_id,d.state_id,IF(d_alt_phone is not NULL, d_alt_phone, '') as d_alt_phone,d_about,d_address,c.city_name";
 //        $this->db->select($arr);
 //        $this->db->from("dealer d");
 //        $this->db->join('pharma_users pu','pu.id=d.crm_user_id');
 //        $this->db->join("city c","c.city_id=d.city_id");
 //        $this->db->where('CONCAT(",", `d`.`sp_code`, ",") REGEXP ",('.$sp.'),"');
 //        $this->db->where('d.city_id',$dataArr['city_id']);
 //        $query= $this->db->get();
 //        //echo $this->db->last_query(); die;
 //        if($this->db->affected_rows())
 //        {
 //            return $query->result_array();
 //        }
 //        else
 //        {
 //            return FALSE;
 //        }
 //    }
    

    public function get_dealer_list($dataArr)
    {
        $del_id_list=array();
        $ar = "d_id";
        $this->db->select($ar);
        $this->db->from("pharma_interaction_dealer");
        $this->db->where('crm_user_id',$dataArr['user_id']);
        $this->db->like('create_date',$dataArr['doi']);
        $this->db->order_by('id','DESC');
        $query2= $this->db->get();
//      echo $this->db->last_query(); die;
        if($this->db->affected_rows())
        {
            foreach($query2->result_array() as $del_int )
            {
                $del_id_list[]=$del_int['d_id'];
            }
        }
        $inteac_del_arr = array_filter(array_unique($del_id_list));

        $deal_list=array();
        $sp=explode(',',$dataArr['sp_code']);
        foreach($sp as $spcd)
        {
            $arr = "d.dealer_id as id,d.d_email as d_email,d.d_phone as d_ph,d.dealer_name as d_name,d.status,d.blocked,d.city_pincode as city_pincode,d.city_id as city_id,d.state_id,IF(d_alt_phone is not NULL, d_alt_phone, '') as d_alt_phone,d_about,d_address,c.city_name";
            $this->db->select($arr);
            $this->db->from("dealer d");
            $this->db->join('pharma_users pu','pu.id=d.crm_user_id');
            $this->db->join("city c","c.city_id=d.city_id");
            $this->db->where('CONCAT(",", `d`.`sp_code`, ",") REGEXP ",('.$spcd.'),"');
            $this->db->where('d.city_id',$dataArr['city_id']);
            $query= $this->db->get();
            //echo $this->db->last_query(); die;
           if($this->db->affected_rows())
            {
                $del_res=$query->result_array();
                foreach ($del_res as $res_del){
                    if(!in_array($res_del['id'],$inteac_del_arr)){
                        $deal_list[]=$res_del ;
                    }
                }
            }
        }

        

      if(empty($deal_list))
        {
            return False;
        }
        else
        {
            return $deal_list;
        }


    }
   
}

