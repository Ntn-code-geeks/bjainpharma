<?php


/*
 * Developer: Niraj Sharma
 * Email: niraj@bjain.com
 * 
 * Dated: 28-08-2018
 * 
 */

class Product_api_model extends CI_Model {

    public function get_product_list()
    {
    	$category_list=array();
    	$product_list=array();
    	$catarr = "category_name,category_id";
	$this->db->select($catarr);
	$this->db->from("pharma_category");
	$this->db->where('status',1);
	$query= $this->db->get();

	if($this->db->affected_rows())
        {
            	$category_list[]=$query->result_array();
        }
        else
        {
        	return false;
        }
  	$catindx=0;
  	$proindx=0;
    	foreach($category_list[0] as $cat)
    	{
	 	$arr = "prod.product_id,prod.product_name,prod.product_price,pot.potency_id  "
                                                . "as potency_id,pot.potency_value "
                                                . "as potency_value,
	  pck.packsize_id as packsize_id "
                      
                        . ",pck.packsize_value";
	        $this->db->select($arr);
	        $this->db->from("pharma_product prod");
	        $this->db->join("pharma_potency pot","pot.potency_id=prod.product_potency",'left');
	        $this->db->join("pharma_packsize pck","pck.packsize_id=prod.product_packsize",'left');
	        $this->db->where('prod.product_category',$cat['category_id']);
	        $this->db->where('prod.status',1);
	        $query= $this->db->get();
	        if($this->db->affected_rows())
	        {
        	    $product_list[$catindx]['category_id']=$cat['category_id'];
            	    $product_list[$catindx]['category_name']=$cat['category_name'];
	            foreach($query->result_array() as $phdata)
    		    {
    		    	
	            	$product_list[$catindx]['product'][$proindx]=$phdata;
	            	$proindx=$proindx+1;
	            }
	            $proindx=0;
	            $catindx = $catindx+1;
	        }
	       
	        
        }
        if(empty($product_list))
        {
        	return False;
        }
        else
        {
        	return $product_list;
        }
    }
    
    public function get_sample_list()
    {
     	$catarr = "id,sample_name";
	$this->db->select($catarr);
	$this->db->from("meeting_sample_master");
	$query= $this->db->get();
	if($this->db->affected_rows())
        {
            	return $query->result_array();
        }
        else
        {
        	return false;
        }
    }
      
       
}

