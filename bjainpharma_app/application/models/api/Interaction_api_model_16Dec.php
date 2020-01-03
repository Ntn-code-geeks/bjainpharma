<?php


class Interaction_api_model extends CI_Model {
   
    



    /*Nitin kumar
    	!!.Code starts here.!!
    */

    public function interaction_log_details($data){

		$this->db->where('crm_user_id',$data->user_id);
		$this->db->where('person_id',$data->dealer_view_id);
		$this->db->delete('log_interaction_data');
		$col='order_id';
		$this->db->select($col);
		$this->db->from('interaction_order');
		$this->db->where('interaction_id',0);
		$this->db->where('crm_user_id',$data->user_id);
		$this->db->where('interaction_person_id',$data->dealer_view_id);
		$query= $this->db->get();
		if($this->db->affected_rows()){
			$id= $query->row()->order_id;
			$this->db->where('order_id', $id);
			$this->db->delete('order_details');
			$this->db->where('interaction_id',0);
			$this->db->where('crm_user_id',$data->user_id);
			$this->db->where('interaction_person_id',$data->dealer_view_id);
			$this->db->delete('interaction_order');
		}

		$telephonic=0;
		$team_member='';
		$m_sample='';
		if(isset($data->telephonic)){
			$telephonic=$data->telephonic;
		}
		if(isset($data->team_member)){
//			$team_member=implode($data['team_member'],',');
			$team_member=$data->team_member;
		}
		if(isset($data->m_sample) && (!empty($data->m_sample))){
			$m_sam=implode($data->m_sample,',');
			$m_sample=$m_sam;
		}

		$log_data = array(
			'person_id'=>$data->dealer_view_id,
			'followup_date'=>$data->fup_a,
			'interaction_date'=>date('d-m-Y',strtotime($data->doi_doc)),
			'stay'=>$data->stay,
			'telephonic'=>$telephonic,
			'joint_working '=>$team_member,
//			'path_info '=>$data->path_info,
			'path_info '=>1,
			'city_code '=>$data->city,
			'sample '=>$m_sample,
			'remark'=>$data->remark,
			'crm_user_id'=> $data->user_id,
		);
		$this->db->insert('log_interaction_data',$log_data);
		return ($this->db->affected_rows() == 1) ? true : false;
	}



	public function get_log__doctor_data($data){
		$doi = date('d-m-Y',strtotime($data['int_date']));
		$this->db->select('*');
		$this->db->from('log_interaction_data');
		$this->db->where('person_id',$data['doc_id']);
		$this->db->where('crm_user_id',$data['user_id']);
		$this->db->where('interaction_date',$doi);
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return  $query->row();
		}else{
			return False;
		}
	}

	public function get_orderamount($data){
    	$arr = "order_amount,provider,mail_provider";
		$this->db->select($arr);
		$this->db->from("interaction_order");
		$this->db->where("interaction_id",0);
		$this->db->where("crm_user_id",$data['user_id']);
		$this->db->where("interaction_person_id",$data['doc_id']);
		$query = $this->db->get();
		if($this->db->affected_rows()){
			return $result=$query->row();
		}
		else{
			return FALSE;
		}
	}



public function get_dealer_sub_list($spcode)
	{
		$dealers=array();
		$pharma_list=array();
		$sp = explode(',', $spcode);
		foreach($sp as $spcd)
		{
			$arr = "d.dealer_id as id,d.d_email as d_email,d.d_phone as d_ph,d.dealer_name as d_name,d.status,d.blocked,d.city_pincode as city_pincode,d.city_id as city_id,d.state_id,IF(d_alt_phone is not NULL, d_alt_phone, '') as d_alt_phone,d_about,d_address,c.city_name";
			$this->db->select($arr);
			$this->db->from("dealer d");
			$this->db->join('pharma_users pu','pu.id=d.crm_user_id');
			$this->db->join("city c","c.city_id=d.city_id");
			$this->db->where('CONCAT(",", `d`.`sp_code`, ",") REGEXP ",('.$spcd.'),"');
			$query= $this->db->get();
			if($this->db->affected_rows())
			{
				foreach($query->result_array() as $Dedata){
					$dealers[]=$Dedata;
				}
			}


			/*Sub Dealer Query Starts*/
			$arr = "pharma.sp_code,pharma.pharma_id as id,pharma.d_id as dealers_id,pharma.company_name as com_name,pharma.company_email as com_email,pharma.company_phone as com_ph,pharma.pharmacy_status as status,pharma.blocked,pharma.city_pincode as city_pincode,pharma.city_id as city_id,owner_name,owner_email,owner_phone,IF(owner_dob is not NULL, owner_dob, '') as owner_dob,company_address,pharma.state_id,c.city_name";
			$this->db->select($arr);
			$this->db->from("pharmacy_list pharma");
			$this->db->join("city c","c.city_id=pharma.city_id");
			$this->db->where('pharma.sp_code',$spcd);
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


		$merger=array_merge($dealers,$pharma_list);

		$newArr=array();
		foreach ($merger as $mrg){
			if (strpos($mrg['id'], '_')) {
				$newArr[]=array(
					'supplier_id' => $mrg['id'],
					'supplier_name' => $mrg['com_name'],
				);
			}else{
				$newArr[]=array(
					'supplier_id' => $mrg['id'],
					'supplier_name' => $mrg['d_name'],
				);
			}
		}

//		pr($newArr);
		return $newArr;


	}

	
}

