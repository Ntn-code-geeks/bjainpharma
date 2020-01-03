<?php


/*

 * 
 */

class Pharma_api_model extends CI_Model {

    public function get_pharma_list($dataArr)
    {
    	$pharma_list=array();
    	$sp=explode(',',$dataArr['sp_code']);
    	foreach($sp as $spcd)
    	{
	 	$arr = "pharma.sp_code,pharma.pharma_id as id,pharma.d_id as dealers_id,pharma.company_name as com_name,pharma.company_email as com_email,pharma.company_phone as com_ph,pharma.pharmacy_status as status,pharma.blocked,pharma.city_pincode as city_pincode,pharma.city_id as city_id,owner_name,owner_email,owner_phone,IF(owner_dob is not NULL, owner_dob, '') as owner_dob,company_address,pharma.state_id,c.city_name";
	        $this->db->select($arr);
	        $this->db->from("pharmacy_list pharma");
	        $this->db->join("city c","c.city_id=pharma.city_id");
	        $this->db->where('pharma.sp_code',$spcd);
            $this->db->where('pharma.city_id',$dataArr['city_id']);
	        $query= $this->db->get();
	        //echo $this->db->last_query(); die;
	        if($this->db->affected_rows())
	        {
	            foreach($query->result_array() as $phdata)
    		    {
	            	$pharma_list[]=$phdata ;
	            }
	        }
        }
        if(empty($pharma_list))
        {
        	return False;
        }
        else
        {
        	return $pharma_list;
        }
    }
    
   
       
}

