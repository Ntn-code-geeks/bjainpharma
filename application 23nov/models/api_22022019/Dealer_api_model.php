<?php


/*
 * Developer: Niraj Sharma
 * Email: niraj@bjain.com
 * 
 * Dated: 28-08-2018
 * 
 */

class Dealer_api_model extends CI_Model {

    public function get_dealer_list($sp_code='',$pin_code='')
    {
    	$sp=0;
       if(!empty($sp_code) && empty($pin_code)){
	if($sp_code!='')
	{
		$sp=str_replace(',','|',$sp_code);
	}
	
 	$arr = "d.dealer_id as id,IF(d.d_email is not NULL, d.d_email, '') as d_email,d.d_phone as d_ph,"
                . "d.dealer_name as d_name,"
                . "d.status,d.blocked,d.city_pincode as city_pincode,d.city_id as city_id,d.state_id,"
                . "IF(d_alt_phone is not NULL, d_alt_phone, '') as d_alt_phone,"
                . "IF(d_about is not NULL, d_about, '') as d_about,d_address,c.city_name";
        $this->db->select($arr);
        $this->db->from("dealer d");
        $this->db->join('pharma_users pu','pu.id=d.crm_user_id');
        $this->db->join("city c","c.city_id=d.city_id");
        $this->db->where('CONCAT(",", `d`.`sp_code`, ",") REGEXP ",('.$sp.'),"');
        //$this->db->where('d.crm_user_id',$id);
        $query= $this->db->get();
        //echo $this->db->last_query(); die;
        if($this->db->affected_rows())
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
        
       }
       elseif(!empty ($pin_code)){
           if($sp_code!='')
	{
		$sp=str_replace(',','|',$sp_code);
        }
                  $arr = "d.dealer_id as id,IF(d.d_email is not NULL, d.d_email, '') as d_email,d.d_phone as d_ph,"
                          . "d.dealer_name as d_name,d.status,d.blocked,d.city_pincode as city_pincode,"
                          . "d.city_id as city_id,d.state_id,IF(d_alt_phone is not NULL, d_alt_phone, '') as d_alt_phone,"
                          . "IF(d_about is not NULL, d_about, '') as d_about,d_address,c.city_name";
                  $this->db->select($arr);
                  $this->db->from("dealer d");
                  $this->db->join('pharma_users pu','pu.id=d.crm_user_id');
                  $this->db->join("city c","c.city_id=d.city_id");
                  $this->db->where('CONCAT(",", `d`.`sp_code`, ",") REGEXP ",('.$sp.'),"');
                  $this->db->where('d.city_pincode',$pin_code);
                  //$this->db->where('d.crm_user_id',$id);
                  $query= $this->db->get();
                  //echo $this->db->last_query(); die;
                  if($this->db->affected_rows())
                  {
                      return $query->result_array();
                  }
                  else
                  {
                      return FALSE;
                  } 
       }
       else{
            
 	$arr = "d.dealer_id as id,IF(d.d_email is not NULL, d.d_email, '') as d_email,d.d_phone as d_ph,"
                . "d.dealer_name as d_name,d.status,"
                . "d.blocked,d.city_pincode as city_pincode,d.city_id as city_id,d.state_id,"
                . "IF(d_alt_phone is not NULL, d_alt_phone, '') as d_alt_phone,"
                . "IF(d_about is not NULL, d_about, '') as d_about,d_address,c.city_name";
        $this->db->select($arr);
        $this->db->from("dealer d");
        $this->db->join('pharma_users pu','pu.id=d.crm_user_id');
        $this->db->join("city c","c.city_id=d.city_id");
       // $this->db->where('CONCAT(",", `d`.`sp_code`, ",") REGEXP ",('.$sp.'),"');
        //$this->db->where('d.crm_user_id',$id);
        $query= $this->db->get();
        //echo $this->db->last_query(); die;
        if($this->db->affected_rows())
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
          }
    }
    
    public function add_dealer($data)
    {
    	 $dealer_data = 
                array(
                    'dealer_name'=>$data->dealer_name,
                    'city_id'=>$data->dealer_city,
                    'state_id'=>$data->dealer_state,
                    'd_email'=>$data->dealer_email,
                    'd_phone'=>$data->dealer_num,
                    'd_alt_phone'=>$data->dealer_alt_num,
                    'd_about'=>$data->about_d,
                    'd_address'=>$data->d_address,
                    'city_pincode'=>$data->city_pin,
                    'status'=>1,
                    'added_date'=> savedate(),
                    'last_update'=> savedate(),
                    'crm_user_id' =>$data->user_id,
                    'doc_navigate_id'=>'',
                );
            $this->db->insert('dealer',$dealer_data); 
            return ($this->db->affected_rows() != 1) ? false : true; 
    }
    
    public function edit_dealer($data)
    {
    	 $dealer_data = 
                array(
                    'dealer_name'=>$data->dealer_name,
                    'city_id'=>$data->dealer_city,
                    'state_id'=>$data->dealer_state,
                    'd_email'=>$data->dealer_email,
                    'd_phone'=>$data->dealer_num,
                    'd_alt_phone'=>$data->dealer_alt_num,
                    'd_about'=>$data->about_d,
                    'd_address'=>$data->d_address,
                    'city_pincode'=>$data->city_pin,
                    'last_update'=> savedate(),
                    'crm_user_id' =>$data->user_id,
                    'doc_navigate_id'=>'',
                );
           $this->db->where('dealer_id',$data->dealer_id);
           $this->db->update('dealer',$dealer_data);
           return ($this->db->affected_rows() != 1) ? false : true; 
    }
}

