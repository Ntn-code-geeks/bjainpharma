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



	public function get_dealer_data($id=''){

		$this->db->select('d_phone,d_email,dealer_name');

		$this->db->from('dealer');

		$this->db->where('dealer_id',$id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {

			return  $query->row();

		}

		else

		{

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

	public function get_pharmacy_data($id=''){

		$this->db->select('company_phone,company_email,company_name');

		$this->db->from('pharmacy_list');

		$this->db->where('pharma_id',$id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {

			return  $query->row();

		}

		else{

			return False;

		}

	}

	public function get_orderdeatils_user($data)
	{
//		pr($data); die;
		$this->db->select('id');
		$this->db->where('interaction_id',0);
		if(isset($data->doc_id))
		{
			$this->db->where('interaction_person_id',$data->doc_id);
		}
		else if(isset($data->d_id))
		{
			$this->db->where('interaction_person_id',$data->d_id);
		}
		else if(isset($data->pharma_id))
		{
			$this->db->where('interaction_person_id',$data->pharma_id);
		}

		$this->db->where('crm_user_id',$data->user_id);

		$this->db->from('interaction_order');

		$query1 = $this->db->get();
//echo $this->db->last_query(); die;
		if($this->db->affected_rows())

		{

			$orderId=$query1->row()->id;

			$arr = "id,product_id,actual_value,discount,net_amount,quantity";

			$this->db->select($arr);

			$this->db->from("order_details");

			$this->db->where("order_id",$orderId);

			$query = $this->db->get();

			if($this->db->affected_rows()){

				return $result=$query->result_array();

			}

			else{

				return false;

			}

		}

		return false;

	}

	public function checkleave($idate,$user_id){
		$this->db->select('from_date,to_date');
		$this->db->from('user_leave');
		$this->db->where('user_id',$user_id);
		$this->db->where('leave_status',1);
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		if ($query->num_rows() > 0) {
			$dateData=$query->result_array();
			foreach($dateData as $dates)
			{
				$this->db->select('leave_id');
				$this->db->from('user_leave');
				$this->db->where("'".date('Y-m-d',strtotime($idate))."' >= '".$dates['from_date']."' AND '".date('Y-m-d',strtotime($idate))."'<='".$dates['to_date']."'");
				$this->db->where('user_id',$user_id);
				$this->db->where('leave_status',1);
				$query1 = $this->db->get();
				if ($query1->num_rows() > 0) {
					return FALSE;
				}
			}
			$con='find_in_set('.$user_id.',user_ids)<>0';
			$this->db->select('from_date,to_date');
			$this->db->from('user_holiday');
			$this->db->where($con);
			// $this->db->where('leave_status',1);
			$query = $this->db->get();
			//echo $this->db->last_query();die;
			if ($query->num_rows() > 0) {
				$dateData=$query->result_array();
				foreach($dateData as $dates)
				{
					$this->db->select('holiday_id');
					$this->db->from('user_holiday');
					$this->db->where("'".date('Y-m-d',strtotime($idate))."' >= '".$dates['from_date']."' AND '".date('Y-m-d',strtotime($idate))."'<='".$dates['to_date']."'");
					$this->db->where($con);
					//  $this->db->where('leave_status',1);
					$query1 = $this->db->get();
					if ($query1->num_rows() > 0) {
						return FALSE;
					}
				}
				return TRUE;
			}
			else{
				return TRUE;
			}
			return TRUE;
		}
		else{
			$con='find_in_set('.$user_id.',user_ids)<>0';
			$this->db->select('from_date,to_date');
			$this->db->from('user_holiday');
			$this->db->where($con);
			// $this->db->where('leave_status',1);
			$query = $this->db->get();
			//echo $this->db->last_query();die;
			if ($query->num_rows() > 0) {
				$dateData=$query->result_array();
				foreach($dateData as $dates)
				{
					$this->db->select('holiday_id');
					$this->db->from('user_holiday');
					$this->db->where("'".date('Y-m-d',strtotime($idate))."' >= '".$dates['from_date']."' AND '".date('Y-m-d',strtotime($idate))."'<='".$dates['to_date']."'");
					$this->db->where($con);
					//  $this->db->where('leave_status',1);
					$query1 = $this->db->get();
					if ($query1->num_rows() > 0) {
						return FALSE;
					}
				}
				return TRUE;
			}
			else{
				return TRUE;
			}
			return TRUE;
		}

	}

	public function save_interaction($data){
		/*pr($data);
		die;*/
		$duplicate_product=0;
		if(isset($data->meet_or_not)){
			$meet_or_not = $data->meet_or_not;
		}elseif(!empty ($data->m_sale)){
			$meet_or_not=1;
		}elseif(!empty ($data->m_sample)){
			$meet_or_not=1;
		}

		if(isset($data->doc_id)){   // for Doctor interaction
			if(!empty($data->m_sample)){  // for multipile sample data
				if(!empty($data->m_sale)){
					$interaction_info = array(
						'doc_id'=>$data->doc_id,
						'dealer_id'=>isset($dat->dealer_id)?$data->dealer_id:NULL,
						'meeting_sale'=>$data->m_sale,
						'meet_or_not_meet'=>$meet_or_not,
						'remark'=>$data->remark,
						'follow_up_action'=>$data->fup_a!='' ? date('Y-m-d', strtotime($data->fup_a)): NULL,
						'status'=>1,
						'crm_user_id'=> $data->user_id,
						'create_date'=> $data->doi_doc!='' ? date('Y-m-d', strtotime($data->doi_doc)):savedate(),
						'last_update' => savedate(),
					);
				}
				else{
					$interaction_info = array(
						'doc_id'=>$data->doc_id,
						'meet_or_not_meet'=>$meet_or_not,
						'remark'=>$data->remark,
						'follow_up_action'=>$data->fup_a!='' ? date('Y-m-d', strtotime($data->fup_a)): NULL,
						'status'=>1,
						'crm_user_id'=> $data->user_id,
						'create_date'=> $data->doi_doc!='' ? date('Y-m-d', strtotime($data->doi_doc)):savedate(),
						'last_update' => savedate(),
					);

				}
				$insert = $this->db->insert('pharma_interaction_doctor',$interaction_info);

//                 echo $this->db->last_query(); die;
//                echo $insert; die;
				$pi_doc = $this->db->insert_id();
				$replica_data = array(
					'interaction_with'=>$data->dealer_view_id,
					'crm_user_id'=> $data->user_id,
				);
				$insert = $this->db->insert('intearction_replica',$replica_data);
				if(isset($pi_doc)){

					$order_data = array(
						'interaction_id'=> $pi_doc,
						'interaction_with_id'=>isset($data->dealer_id)?$data->dealer_id:NULL,
						'updated_date'=>savedate(),
					);
					$this->db->set($order_data);
					$this->db->where('interaction_id',0);
					$this->db->where('interaction_person_id',$data->doc_id);
					$this->db->where('crm_user_id',$data->user_id);
					$this->db->update('interaction_order');
					$this->db->where('crm_user_id',$data->user_id);
					$this->db->where('person_id',$data->doc_id);
					$this->db->delete('log_interaction_data');
				}

				if(isset($pi_doc)){
					foreach($data->m_sample as $kms=>$val_ms){
						$sample_doc_interraction_rel = array(
							'pidoc_id'=>$pi_doc,
							'sample_id'=>$val_ms,
							'crm_user_id'=> $data->user_id,
							'last_update'=> savedate(),
						);

						$status = $this->db->insert('doctor_interaction_sample_relation',$sample_doc_interraction_rel);
					}

				}

				if(isset($pi_doc) && isset($data->team_member)){
					foreach($data->team_member as $k_tm=>$val_tm){
						$team_doc_interraction_rel = array(
							'pidoc_id'=>$pi_doc,
							'team_id'=>$val_tm,
							'crm_user_id'=> $data->user_id,
							'last_update'=> savedate(),
							'doc_id'=>$data->doc_id,
							'interaction_date'=>  date('Y-m-d', strtotime($data->doi_doc)),
						);
						$team_status = $this->db->insert('doctor_interaction_with_team',$team_doc_interraction_rel);
					}
				}

				if(!empty($data->m_sample) && isset($data->team_member)){
					if ($insert == TRUE && $status == 1 && $team_status==1){
						return true;
					}else{
						return false;
					}
				}
				elseif(!empty($data->m_sample) && !isset($data->team_member)){
					if ($insert== TRUE && $status == 1){
						return true;
					}else{
						return false;
					}
				}
			}
			else{
				if(!empty($data->m_sale)){
					$interaction_info = array(
						'doc_id'=>$data->doc_id,
						'dealer_id'=>isset($data->dealer_id)?$data->dealer_id:NULL,
						'meeting_sale'=>$data->m_sale,
						'telephonic' => isset($data->telephonic)? $data->telephonic:NULL,
						'meet_or_not_meet'=>$meet_or_not,
						'remark'=>$data->remark,
						'follow_up_action'=>$data->fup_a!='' ? date('Y-m-d', strtotime($data->fup_a)):NULL,
						'status'=>1,
						'crm_user_id'=> $data->user_id,
						'create_date'=> $data->doi_doc!='' ? date('Y-m-d', strtotime($data->doi_doc)):savedate(),
						'last_update' => savedate(),
					);
				}
				else{
					$interaction_info = array(
						'doc_id'=>$data->doc_id,
						'telephonic' => isset($data->telephonic)? $data->telephonic:NULL,
						'meet_or_not_meet'=>$meet_or_not,
						'remark'=>$data->remark,
						'follow_up_action'=>$data->fup_a!='' ? date('Y-m-d', strtotime($data->fup_a)):NULL,
						'status'=>1,
						'crm_user_id'=> $data->user_id,
						'create_date'=> $data->doi_doc!='' ? date('Y-m-d', strtotime($data->doi_doc)):savedate(),
						'last_update' => savedate(),
					);

				}
				$insert =  $this->db->insert('pharma_interaction_doctor',$interaction_info);
//           echo $this->db->last_query(); die;
				$pi_doc = $this->db->insert_id();
				$replica_data = array(
					'interaction_with'=>$data->dealer_view_id,
					'crm_user_id'=> $data->user_id,
				);
				$insert = $this->db->insert('intearction_replica',$replica_data);

				if(isset($pi_doc)){
					$order_data = array(
						'interaction_id'=> $pi_doc,
						'interaction_with_id'=>isset($data->dealer_id)?$data->dealer_id:NULL,
						'updated_date'=>savedate(),
					);

					$this->db->set($order_data);
					$this->db->where('interaction_id',0);
					$this->db->where('interaction_person_id',$data->dealer_view_id);
					$this->db->where('crm_user_id',$data->user_id);
					$this->db->update('interaction_order');
					$this->db->where('crm_user_id',$data->user_id);
					$this->db->where('person_id',$data->dealer_view_id);
					$this->db->delete('log_interaction_data');
				}
				if(isset($pi_doc) && isset($data->team_member)){
					foreach($data->team_member as $k_tm=>$val_tm){
						$team_doc_interraction_rel = array(
							'pidoc_id'=>$pi_doc,
							'team_id'=>$val_tm,
							'crm_user_id'=> $data->user_id,
							'last_update'=> savedate(),
							'doc_id'=>$data->doc_id,
							'interaction_date'=>  date('Y-m-d', strtotime($data->doi_doc)),
						);
						$team_status = $this->db->insert('doctor_interaction_with_team',$team_doc_interraction_rel);
					}

				}

				if(isset($data['team_member'])){
					if ($insert == TRUE && $team_status==1)
					{
						return true;
					}
					else{
						return false;
					}
				}
				else{
					if ($insert == TRUE)
					{
						return true;
					}
					else{
						return false;
					}
				}
			}
		}
		else if(isset($data->d_id)){   // for dealer interaction
			if(!empty($data->m_sample)){  // for multipile sample data
				$interaction_info = array(
					'd_id'=>$data->d_id,
					'meeting_sale'=>isset($data->m_sale)? $data->m_sale:NULL,
					'meeting_payment'=>$data->m_payment,
					'meeting_stock'=>$data->m_stock,
					'meet_or_not_meet'=>$meet_or_not,
					'remark'=>$data->remark,
					'follow_up_action'=>$data->fup_a!='' ? date('Y-m-d', strtotime($data->fup_a)):NULL,
					'status'=>1,
					'crm_user_id'=> $data->user_id,
					'create_date'=> $data->doi_doc!='' ? date('Y-m-d', strtotime($data->doi_doc)):savedate(),
					'last_update' => savedate(),
				);
				$insert = $this->db->insert('pharma_interaction_dealer',$interaction_info);
				$pi_dealer = $this->db->insert_id();
				$replica_data = array(
					'interaction_with'=>$data->dealer_view_id,
					'crm_user_id'=> $data->user_id,
				);
				$insert = $this->db->insert('intearction_replica',$replica_data);
				if(isset($pi_dealer)){
					$order_data = array(
						'interaction_id'=> $pi_dealer,
						//'interaction_with_id'=> $data['dealer_id'],
						'updated_date'=>savedate(),
					);
					$this->db->set($order_data);
					$this->db->where('interaction_id',0);
					$this->db->where('interaction_person_id',$data->dealer_view_id);
					$this->db->where('crm_user_id',$data->user_id);
					$this->db->update('interaction_order');
					$this->db->where('crm_user_id',$data->user_id);
					$this->db->where('person_id',$data->dealer_view_id);
					$this->db->delete('log_interaction_data');
				}

				if(isset($pi_dealer)){
					foreach($data->m_sample as $kms=>$val_ms){
						$sample_dealer_interaction_rel = array(
							'pidealer_id'=>$pi_dealer,
							'sample_id'=>$val_ms,
							'crm_user_id'=> $data->user_id,
							'last_update'=> savedate(),
						);

						$status= $this->db->insert('dealer_interaction_sample_relation',$sample_dealer_interaction_rel);
					}

				}

				if(isset($pi_dealer) && isset($data->team_member)){
					foreach($data->team_member as $k_tm=>$val_tm){
						$team_dealer_interraction_rel = array(
							'pidealer_id'=>$pi_dealer,
							'team_id'=>$val_tm,
							'crm_user_id'=> $data->user_id,
							'last_update'=> savedate(),
							'dealer_id'=>$data->d_id,
							'interaction_date'=>  date('Y-m-d', strtotime($data->doi_doc)),
						);

						$team_status = $this->db->insert('dealer_interaction_with_team',$team_dealer_interraction_rel);
					}
				}

				if(!empty($data->m_sample) && isset($data->team_member)){
					if ($insert == TRUE && $status == 1 && $team_status==1)
					{
						return true;
					}else{
						return false;
					}
				}
				elseif(!empty($data->m_sample) && !isset($data->team_member)){
					if ( $insert == TRUE && $status == 1)
					{
						return true;
					}else{
						return false;
					}
				}
			}
			else{  // for non sample data
				$interaction_info = array(
					'd_id'=>$data->d_id,
					'telephonic' => isset($data->telephonic)? $data->telephonic:NULL,
					'meeting_sale'=>isset($data->m_sale)? $data->m_sale:NULL,
					'meeting_payment'=>$data->m_payment,
					'meeting_stock'=>$data->m_stock,
					'meet_or_not_meet'=>$meet_or_not,
					'remark'=>$data->remark,
					'follow_up_action'=>$data->fup_a!='' ? date('Y-m-d', strtotime($data->fup_a)):NULL,
					'status'=>1,
					'crm_user_id'=>$data->user_id,
					'create_date'=> $data->doi_doc!='' ? date('Y-m-d', strtotime($data->doi_doc)):savedate(),
					'last_update' => savedate(),
				);
				$insert = $this->db->insert('pharma_interaction_dealer',$interaction_info);
				$pi_doc = $this->db->insert_id();
				$replica_data = array(
					'interaction_with'=>$data->dealer_view_id,
					'crm_user_id'=> $data->user_id,
				);
				$insert = $this->db->insert('intearction_replica',$replica_data);
				if(isset($pi_doc)){
					$order_data = array(
						'interaction_id'=> $pi_doc,
						'updated_date'=>savedate(),
					);
					$this->db->set($order_data);
					$this->db->where('interaction_id',0);
					$this->db->where('interaction_person_id',$data->dealer_view_id);
					$this->db->where('crm_user_id',$data->user_id);
					$this->db->update('interaction_order');
					$this->db->where('crm_user_id',$data->user_id);
					$this->db->where('person_id',$data->dealer_view_id);
					$this->db->delete('log_interaction_data');
				}

				if(isset($pi_doc) && isset($data->team_member)){
					foreach($data->team_member as $k_tm=>$val_tm){
						$team_dealer_interraction_rel = array(
							'pidealer_id'=>$pi_doc,
							'team_id'=>$val_tm,
							'crm_user_id'=> $data->user_id,
							'last_update'=> savedate(),
							'dealer_id'=>$data->d_id,
							'interaction_date'=>  date('Y-m-d', strtotime($data->doi_doc)),
						);
						$team_status = $this->db->insert('dealer_interaction_with_team',$team_dealer_interraction_rel);
					}
				}

				if(isset($data->team_member)){
					if ($insert == TRUE && $team_status==1)
					{
						return true;
					}else{
						return false;
					}
				}else{
					if ($insert == TRUE)
					{
						return true;
					}else{
						return false;
					}
				}
			}
		}

		elseif(isset($data->pharma_id)){   // for pharmacy interaction
			$dup_count=0;
			$dup_product='';
			if(isset($data->rel_doc_id))
			{
				$duplicate_product=$this->check_duplicate_value($data);
				$dup_count=$duplicate_product['dp_count'];
				$dup_product=$duplicate_product['dp_value'];
			}
			if(!empty($data->m_sample)){  // for multipile sample data
				if(!empty($data->m_sale)){
					$interaction_info = array(
						'pharma_id'=>$data->pharma_id,
						'dealer_id'=>isset($data->dealer_id)?$data->dealer_id:NULL,
						'doctor_id'=>isset($data->rel_doc_id)?$data->rel_doc_id:NULL,
						'duplicate_secondary'=>$dup_count,
						'duplicate_product'=>$dup_product,
						'meeting_sale'=>$data->m_sale,
						'meet_or_not_meet'=>$meet_or_not,
						'remark'=>$data->remark,
						'follow_up_action'=>$data->fup_a!='' ? date('Y-m-d', strtotime($data->fup_a)):NULL,
						'status'=>1,
						'crm_user_id'=> $data->user_id,
						'create_date'=> $data->doi_doc!='' ? date('Y-m-d', strtotime($data->doi_doc)):savedate(),
						'last_update' => savedate(),
					);
				}
				else{
					$interaction_info = array(
						'pharma_id'=>$data->pharma_id,
						'doctor_id'=>isset($data->rel_doc_id)?$data->rel_doc_id:NULL,
						'duplicate_secondary'=>$dup_count,
						'duplicate_product'=>$dup_product,
						'meet_or_not_meet'=>$meet_or_not,
						'remark'=>$data->remark,
						'follow_up_action'=>$data->fup_a!='' ? date('Y-m-d', strtotime($data->fup_a)):NULL,
						'status'=>1,
						'crm_user_id'=> $data->user_id,
						'create_date'=> $data->doi_doc!='' ? date('Y-m-d', strtotime($data->doi_doc)):savedate(),
						'last_update' => savedate(),
					);
				}
				$insert = $this->db->insert('pharma_interaction_pharmacy',$interaction_info);

				$replica_data = array(
					'interaction_with'=>$data->dealer_view_id,
					'crm_user_id'=>$data->user_id,
				);
				$insert = $this->db->insert('intearction_replica',$replica_data);
				$pi_doc = $this->db->insert_id();
				if(isset($pi_doc)){
					$order_data = array(
						'interaction_id'=> $pi_doc,
						'interaction_with_id'=>isset($data->dealer_id)?$data->dealer_id:NULL,
						'updated_date'=>savedate(),
					);
					$this->db->set($order_data);
					$this->db->where('interaction_id',0);
					$this->db->where('interaction_person_id',$data->dealer_view_id);
					$this->db->where('crm_user_id',$data->user_id);
					$this->db->update('interaction_order');
					$this->db->where('crm_user_id',$data->user_id);
					$this->db->where('person_id',$data->dealer_view_id);
					$this->db->delete('log_interaction_data');
					if(isset($data->rel_doc_id))
					{
						$order_data = array(
							'duplicate_status'=> 1,
							'updated_date'=>savedate(),
						);
						$this->db->set($order_data);
						$this->db->where('crm_user_id',$data->user_id);
						$this->db->where('duplicate_status',0);
						$this->db->where('interaction_with_id',$data->dealer_view_id);
						$this->db->where('interaction_person_id',$data->rel_doc_id);
						$this->db->update('interaction_order');
					}

				}

				if(isset($pi_doc)){
					foreach($data->m_sample as $kms=>$val_ms){
						$sample_doc_interraction_rel = array(
							'pipharma_id'=>$pi_doc,
							'sample_id'=>$val_ms,
							'crm_user_id'=> $data->user_id,
							'last_update'=> savedate(),
						);
						$status= $this->db->insert('pharmacy_interaction_sample_relation',$sample_doc_interraction_rel);
					}
				}
				if(isset($pi_doc) && isset($data->team_member)){
					foreach($data->team_member as $k_tm=>$val_tm){
						$team_interraction_rel = array(
							'pipharma_id'=>$pi_doc,
							'team_id'=>$val_tm,
							'crm_user_id'=> $data->user_id,
							'last_update'=> savedate(),
							'pharma_id'=>$data->pharma_id,
							'interaction_date'=>  date('Y-m-d', strtotime($data->doi_doc)),
						);
						$team_status = $this->db->insert('pharmacy_interaction_with_team',$team_interraction_rel);
					}

				}

				if(!empty($data->m_sample) && isset($data->team_member)){
					if ($insert == TRUE && $status == 1 && $team_status==1)
					{
						return true;
					}else{
						return false;
					}
				}
				elseif(!empty($data->m_sample) && !isset($data->team_member)){
					if ($insert == TRUE && $status == 1){
						return true;
					}else{
						return false;
					}
				}
			}
			else{
				if(!empty($data->m_sale)){
					$interaction_info = array(
						'pharma_id'=>$data->pharma_id,
						'dealer_id'=>isset($data->dealer_id)?$data->dealer_id:NULL,
						'meeting_sale'=>$data->m_sale,
						'telephonic' => isset($data->telephonic)? $data->telephonic:NULL,
						'doctor_id'=>isset($data->rel_doc_id)?$data->rel_doc_id:NULL,
						'duplicate_secondary'=>$dup_count,
						'duplicate_product'=>$dup_product,
						'meet_or_not_meet'=>$meet_or_not,
						'remark'=>$data->remark,
						'follow_up_action'=>$data->fup_a!='' ? date('Y-m-d', strtotime($data->fup_a)):NULL,
						'status'=>1,
						'crm_user_id'=> $data->user_id,
						'create_date'=> $data->doi_doc!='' ? date('Y-m-d', strtotime($data->doi_doc)):savedate(),
						'last_update' => savedate(),
					);
				}
				else{
					$interaction_info = array(
						'pharma_id'=>$data->pharma_id,
						'telephonic' => isset($data->telephonic)? $data->telephonic:NULL,
						'meet_or_not_meet'=>$meet_or_not,
						'doctor_id'=>isset($data->rel_doc_id)?$data->rel_doc_id:NULL,
						'duplicate_secondary'=>$dup_count,
						'duplicate_product'=>$dup_product,
						'remark'=>$data->remark,
						'follow_up_action'=>$data->fup_a!='' ? date('Y-m-d', strtotime($data->fup_a)):NULL,
						'status'=>1,
						'crm_user_id'=> $data->user_id,
						'create_date'=> $data->doi_doc!='' ? date('Y-m-d', strtotime($data->doi_doc)):savedate(),
						'last_update' => savedate(),
					);

				}

				$insert = $this->db->insert('pharma_interaction_pharmacy',$interaction_info);
				$pi_doc = $this->db->insert_id();

				$replica_data = array(
					'interaction_with'=>$data->dealer_view_id,
					'crm_user_id'=>$data->user_id,
				);
				$insert = $this->db->insert('intearction_replica',$replica_data);

				if(isset($pi_doc)){
					$order_data = array(
						'interaction_id'=> $pi_doc,
						'interaction_with_id'=>isset($data->dealer_id)?$data->dealer_id:NULL,
						'updated_date'=>savedate(),
					);

					$this->db->set($order_data);
					$this->db->where('interaction_id',0);
					$this->db->where('interaction_person_id',$data->pharma_id);
					$this->db->where('crm_user_id',$data->user_id);
					$this->db->update('interaction_order');
					$this->db->where('crm_user_id',$data->user_id);
					$this->db->where('person_id',$data->pharma_id);
					$this->db->delete('log_interaction_data');
					if(isset($data->rel_doc_id))
					{
						$order_data = array(
							'duplicate_status'=> 1,
							'updated_date'=>savedate(),
						);
						$this->db->set($order_data);
						$this->db->where('crm_user_id',$data->user_id);
						$this->db->where('duplicate_status',0);
						$this->db->where('interaction_with_id',$data->dealer_view_id);
						$this->db->where('interaction_person_id',$data->rel_doc_id);
						$this->db->update('interaction_order');
					}

				}

				if(isset($pi_doc) && isset($data->team_member)){
					foreach($data->team_member as $k_tm=>$val_tm){
						$team_interraction_rel = array(
							'pipharma_id'=>$pi_doc,
							'team_id'=>$val_tm,
							'crm_user_id'=> $data->user_id,
							'last_update'=> savedate(),
							'pharma_id'=>$data->pharma_id,
							'interaction_date'=>  date('Y-m-d', strtotime($data->doi_doc)),
						);

						$team_status = $this->db->insert('pharmacy_interaction_with_team',$team_interraction_rel);
					}
				}

				if(isset($data->team_member)){
					if ($insert == TRUE && $team_status==1)
					{
						return true;
					}
					else{
						return false;
					}
				}
				else{
					if ($insert == TRUE)
					{
						return true;
					}
					else{
						return false;
					}
				}

			}

		}
	}

		public function insert_ta_da($data){
		//pr($data); die;
		//SELECT * FROM `pharma_interaction_doctor` WHERE create_date='2018-05-22' and crm_user_id=92 order by last_update DESC
		$previous=date('Y-m-d', strtotime('-1 day', strtotime($data->doi_doc)));
		$interaction_day=date('D', strtotime($data->doi_doc));
		$user_id=$data->user_id;
		$designation_id=get_user_deatils($user_id)->user_designation_id;
		$location_type=0;
		$internet_charge=10;
		$distance=0;
		$stp_distance=0; $is_stp_approved=0;
		$source_city=get_interaction_source($user_id);//one date before from interaction
		$source_city_id=get_interaction_source_id($user_id);//one date before from interaction
		$destination_city=0;
		$destination_city_id=0;
		$ta=0;
		$stp_ta=0;
		$da=0;
		$rs_per_km=0;//get using distance
		$meet_id=$data->dealer_view_id;
		if(!is_numeric($data->dealer_view_id))
		{
			if(substr($data->dealer_view_id,0,3)=='doc'){
				//doctor
				$destination_city=get_destination_interaction('doctor_list',$data->dealer_view_id,1);
				$destination_city_id=get_destination_interaction_id('doctor_list',$data->dealer_view_id,1);
			}
			else{
				//pharma
				$destination_city=get_destination_interaction('pharmacy_list',$data->dealer_view_id,2);
				$destination_city_id=get_destination_interaction_id('pharmacy_list',$data->dealer_view_id,2);
			}
		}
		else{
			//dealer
			$destination_city=get_destination_interaction('dealer',$data->dealer_view_id,3);
			$destination_city_id=get_destination_interaction_id('dealer',$data->dealer_view_id,3);
		}
//		pr($destination_city_id); die;
		if($data->up && $destination_city==$source_city && $destination_city!=get_user_deatils($user_id)
				->headquarters_city)
		{

			$url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$source_city."&destinations=".get_user_deatils($user_id)->hq_city_pincode.'&key=AIzaSyBW4XD3HI9gZfK-J36dRizXrw6ynJ_ztJI';
			if($source_city_id==get_user_deatils($user_id)->headquarters_city)
			{
				$stp_distance=0;
			}
			else
			{
				$cityData=$this->check_city_path($source_city_id,get_user_deatils($user_id)->headquarters_city,$user_id);
				if($cityData)
				{

					$stp_distance=$cityData->distance;
					$is_stp_approved = $cityData->is_approved;
				}
			}
		}
		else
		{
			$url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$source_city."&destinations=".$destination_city.'&key=AIzaSyBW4XD3HI9gZfK-J36dRizXrw6ynJ_ztJI';
//         echo $url;
			if($source_city_id==$destination_city_id)
			{
				$stp_distance=0;
			}
			else
			{
				$cityData=$this->check_city_path($source_city_id,$destination_city_id,$user_id);
				if($cityData)
				{
					$stp_distance=$cityData->distance;
					$is_stp_approved = $cityData->is_approved;
				}
			}

		}
		/* echo $url;
		 die;*/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		curl_close($ch);
		$response_a = json_decode($response);
		$status = $response_a->status;
//         pr($response_a); die;
		if ($status == 'OK' && $response_a->rows[0]->elements[0]->status == 'OK')
		{
			$dist=explode(' ',$response_a->rows[0]->elements[0]->distance->text)[0];
			$maindistance=str_replace("," , "" , $dist);
		}
		else
		{
			// $distance=1;
			// $distance=0;
			$maindistance=0;
		}

		if($maindistance == '1'){
			$distance=0;
		}elseif ($maindistance == '0'){
			$distance=0;
		}
		else{
//			 $distance=$maindistance;

			$user_city_ID=get_user_deatils($user_id)->headquarters_city;
			if(	(is_city_metro($destination_city_id)== is_city_metro($user_city_ID)) &&
				(get_state_id($user_city_ID) == get_state_id($destination_city_id)) &&
				($maindistance <= 75)  && (get_user_deatils($user_id)->headquarters_city == $destination_city_id)
			){
				$distance = 0;
			}else{
				if($maindistance <= 20 ){
					 $distance = 0;
				}else{
					$distance=$maindistance;
				}
			}
		}
//echo $distance; die;
		if($distance>=0 && $distance<=100)
		{
			if($designation_id==5 || $designation_id==6)
			{
				$rs_per_km=get_km_expanse(5);
			}
			else
			{
				$rs_per_km=get_km_expanse(1);
			}
		}
		elseif($distance>=101 && $distance<=300)
		{
			if($designation_id==5 || $designation_id==6)
			{
				$rs_per_km=get_km_expanse(6);
			}
			else
			{
				$rs_per_km=get_km_expanse(2);
			}
		}
		elseif($distance>=301 && $distance<=500)
		{
			if($designation_id==5 || $designation_id==6)
			{
				$rs_per_km=get_km_expanse(7);
			}
			else
			{
				$rs_per_km=get_km_expanse(3);
			}
		}
		else
		{
			$rs_per_km=get_km_expanse(4);
		}
		if( $rs_per_km==0)
		{
			$ta=0;
		}
		else
		{
			if($data->up)
			{
				if($destination_city==$source_city && $destination_city!=get_user_deatils($user_id)->headquarters_city)
				{
					$ta=$rs_per_km*$distance;
				}
				else
				{
					$ta=$rs_per_km*$distance*2;
				}
			}
			else
			{
				$ta=$rs_per_km*$distance;
			}
		}
		if($data->up)
		{
			if($destination_city==$source_city && $destination_city!=get_user_deatils($user_id)->headquarters_city)
			{
				$distance=$distance;
			}
			else
			{
				$distance=$distance*2;
			}
		}

		if($stp_distance>=0 && $stp_distance<=100)
		{
			if($designation_id==5 || $designation_id==6)
			{
				$rs_per_km=get_km_expanse(5);
			}
			else
			{
				$rs_per_km=get_km_expanse(1);
			}
		}
		elseif($stp_distance>=101 && $stp_distance<=300)
		{
			if($designation_id==5 || $designation_id==6)
			{
				$rs_per_km=get_km_expanse(6);
			}
			else
			{
				$rs_per_km=get_km_expanse(2);
			}
		}
		elseif($stp_distance>=301 && $stp_distance<=500)
		{
			if($designation_id==5 || $designation_id==6)
			{
				$rs_per_km=get_km_expanse(7);
			}
			else
			{
				$rs_per_km=get_km_expanse(3);
			}
		}
		else
		{
			$rs_per_km=get_km_expanse(4);
		}
		if( $rs_per_km==0)
		{
			$stp_ta=0;
		}
		else
		{
			if($data->up)
			{
				if($destination_city==$source_city && $destination_city!=get_user_deatils($user_id)->headquarters_city)
				{
					$stp_ta=$rs_per_km*$stp_distance;
				}
				else
				{
					$stp_ta=$rs_per_km*$stp_distance*2;
				}
			}
			else
			{
				$stp_ta=$rs_per_km*$stp_distance;
			}
		}
		if($data->up)
		{
			if($destination_city==$source_city && $destination_city!=get_user_deatils($user_id)->headquarters_city)
			{
				$stp_distance=$stp_distance;
			}
			else
			{
				$stp_distance=$stp_distance*2;
			}
		}



		$tour_date = date('Y-m-d', strtotime($data->doi_doc));
		$tour_data = array(
			'user_id'=>$user_id,
			'designation_id'=>$designation_id,
			'internet_charge'=>10,
			'distance'=>$distance,
			'source_city'=>$source_city_id,
			'destination_city'=>$destination_city_id,
			'source_city_pin'=>$source_city,
			'destination_city_pin'=>$destination_city,
			'rs_per_km'=>$rs_per_km,
			'is_stay'=>$data->stay,
			'up_down'=>$data->up,
			'ta'=>$ta,
			'stp_ta'=>$stp_ta,
			'stp_distance'=>$stp_distance,
			'is_stp_approved'=> $is_stp_approved,

			'meet_id'=>$meet_id,
			'doi'=>$tour_date,
			'created_date'=>savedate(),
			'updated_date'=>savedate(),
			'status'=>1,
		);
		//pr($tour_data); die;
		$this->db->insert('ta_da_report',$tour_data);
	}

	public function edit_dealer($d_id)
	{
		$arr = "d.sp_code,d.doc_navigate_id as doc_navigon,d.city_pincode as city_pincode,d.city_pincode as city_pincode,d.dealer_id as d_id,d.d_alt_phone as alt_phone,d.d_address,d.dealer_name,d.d_email as d_email,d.d_phone as d_ph,d.d_about,d.dealer_are,d.gd_id,d.state_id,d.city_id,c.city_name";
		$this->db->select($arr);
		$this->db->from("dealer d");
		$this->db->join("city c" , "d.city_id=c.city_id");
		$this->db->where("d.dealer_id",$d_id);
		$query = $this->db->get();
		//  echo $this->db->last_query(); die;
		if($this->db->affected_rows())
		{
			return json_encode($query->row());
		}
		else
		{
			return FALSE;
		}
	}

// save sam reporting
	public function save_asm_dsr($data){
//pr($data); die;
		$user_id=$data->user_id;
		$designation_id=get_user_deatils($user_id)->user_designation_id;
		$userHQ=get_logged_hq($user_id)->hq_city;   ///logged user cityID
		$stp_distance=0;
		$is_stp_approved=0;
		$dateD=date('d/m/Y',strtotime($data->doi));
		$check_date_doi=$dateD;
		// $dateD=explode("/",$data->doi);
		// $check_date_doi=$dateD[1].'/'.$dateD[0].'/'.$dateD[2];
		$check_last_source=get_check_lastSource($check_date_doi,$user_id);//If stay in last interaction

		if($check_last_source){
			$source_city=get_pool_pincode($check_last_source);//one date before from interaction
			$source_city_id=$check_last_source;
		}else{
			if($data->planned_city_id == " "){
				$source_city_info=get_city_info($userHQ);//one date before from interaction
				$source_city=$source_city_info->pool_pincode;//one date before from interaction
				$source_city_id=$userHQ;//one date before from interaction
			}else{
				$source_city_info=get_city_info($data->planned_city_id);
				$source_city=$source_city_info->pool_pincode;//one date before from interaction
				$source_city_id=$data->planned_city_id;
			}
		}

		$Destination_city_info=get_city_info($data->interaction_city_id);
		$destination_city=$Destination_city_info->pool_pincode;
		$dest_city_id=$Destination_city_info->city_id;

		$url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$source_city."&destinations=".$destination_city.'&key=AIzaSyBW4XD3HI9gZfK-J36dRizXrw6ynJ_ztJI';

		if($source_city_id==get_user_deatils($user_id)->headquarters_city)
		{
			$stp_distance=0;
		}
		else
		{
			$cityData=$this->check_city_path($source_city_id,$dest_city_id,$user_id);
			if($cityData)
			{
				$stp_distance=$cityData->distance;
				$is_stp_approved = $cityData->is_approved;
			}
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		curl_close($ch);
		$response_a = json_decode($response);
		$status = $response_a->status;
		//pr($response_a); die;
		if ($status == 'OK' && $response_a->rows[0]->elements[0]->status == 'OK')
		{
			$dist=explode(' ',$response_a->rows[0]->elements[0]->distance->text)[0];
			$maindistance=str_replace("," , "" , $dist);
		}
		else
		{
        	$maindistance=0;
		}
		if($maindistance == '1'){
			$distance=0;
		}elseif ($maindistance == '0'){
			$distance=0;
		}
		else{
			$distance=$maindistance;
		}

		if($distance>=1 && $distance<=100)
		{
			if($designation_id==5 || $designation_id==6)
			{
				$rs_per_km=get_km_expanse(5);
			}
			else
			{
				$rs_per_km=get_km_expanse(1);
			}
		}
		elseif($distance>=101 && $distance<=300)
		{
			if($designation_id==5 || $designation_id==6)
			{
				$rs_per_km=get_km_expanse(6);
			}
			else
			{
				$rs_per_km=get_km_expanse(2);
			}
		}
		elseif($distance>=301 && $distance<=500)
		{
			if($designation_id==5 || $designation_id==6)
			{
				$rs_per_km=get_km_expanse(7);
			}
			else
			{
				$rs_per_km=get_km_expanse(3);
			}
		}
		else
		{
			$rs_per_km=get_km_expanse(4);
		}

		// echo $rs_per_km; die;
		if( $rs_per_km==0)
		{
			$ta=0;
		}
		else
		{
			if($data->up)
			{
				if($destination_city==$source_city && $destination_city!=get_user_deatils(logged_user_data())->headquarters_city)
				{
					$ta=$rs_per_km*$distance;
				}
				else
				{
					$ta=$rs_per_km*$distance*2;
				}
			}
			else
			{
				$ta=$rs_per_km*$distance;
			}
		}
		if($data->up)
		{
			if($destination_city==$source_city && $destination_city!=get_user_deatils(logged_user_data())->headquarters_city)
			{
				$distance=$distance;
			}
			else
			{
				$distance=$distance*2;
				// $distance=$distance;
			}
		}

		if($stp_distance>=0 && $stp_distance<=100)
		{
			if($designation_id==5 || $designation_id==6)
			{
				$rs_per_km=get_km_expanse(5);
			}
			else
			{
				$rs_per_km=get_km_expanse(1);
			}
		}
		elseif($stp_distance>=101 && $stp_distance<=300)
		{
			if($designation_id==5 || $designation_id==6)
			{
				$rs_per_km=get_km_expanse(6);
			}
			else
			{
				$rs_per_km=get_km_expanse(2);
			}
		}
		elseif($stp_distance>=301 && $stp_distance<=500)
		{
			if($designation_id==5 || $designation_id==6)
			{
				$rs_per_km=get_km_expanse(7);
			}
			else
			{
				$rs_per_km=get_km_expanse(3);
			}
		}
		else
		{
			$rs_per_km=get_km_expanse(4);
		}
		if( $rs_per_km==0)
		{
			$stp_ta=0;
		}
		else
		{
			if($data->up)
			{
				if($destination_city==$source_city && $destination_city!=get_user_deatils(logged_user_data())->headquarters_city)
				{
					$stp_ta=$rs_per_km*$stp_distance;
				}
				else
				{
					$stp_ta=$rs_per_km*$stp_distance*2;
				}
			}
			else
			{
				$stp_ta=$rs_per_km*$stp_distance;
			}
		}
		if($data->up)
		{
			if($destination_city==$source_city && $destination_city!=get_user_deatils(logged_user_data())->headquarters_city)
			{
				$stp_distance=$stp_distance;
			}
			else
			{
				$stp_distance=$stp_distance*2;
			}
		}

		$tour_date = date('Y-m-d', strtotime($data->doi));
		$tour_data = array(
			'user_id'=>$user_id,
			'designation_id'=>$designation_id,
			'internet_charge'=>10,
			'distance'=>$distance,
			'source_city'=>$source_city_id,
			'destination_city'=>$dest_city_id,
			'source_city_pin'=>$source_city,
			'destination_city_pin'=>$destination_city,
			'rs_per_km'=>$rs_per_km,
			'is_stay'=>$data->stay,
			'up_down'=>$data->up,
			'ta'=>$ta,
			'stp_ta'=>$stp_ta,
			'stp_distance'=>$stp_distance,
			'is_stp_approved'=> $is_stp_approved,
			'meet_id'=>'',
			'doi'=>$tour_date,
			'created_date'=>savedate(),
			'updated_date'=>savedate(),
			'status'=>1,
		);
		//pr($tour_data); die;
		$this->db->insert('ta_da_report',$tour_data);


		$interaction_id =get_asm_interaction_code();
		foreach ($data->remark as $key => $value) {
			$asm_report_data =
				array(
					'interaction_id'=>$interaction_id,
					'question_num'=>$key+1,
					'answer'=>$value,
					'interaction_date'=>strtotime($data->doi),
					'doi'=>$tour_date,
					'interaction_city'=>$data->interaction_city_id,
					'joint_work_with'=>$data->joint_workwith,
					'crm_user_id'=> $user_id,
					'create_date'=>savedate(),
				);
			// pr($asm_report_data); die;
			$this->db->insert('asm_interaction',$asm_report_data);
		}


		return ($this->db->affected_rows() != 1) ? false : true;

	}


		public function check_city_path($source_city,$dest_city,$user_id){
		//SELECT * FROM `master_tour_data` WHERE  (source_city=11 or dist_city=11) AND (source_city=46 or dist_city=46) AND pharma_user_id=28
		$con='(source_city='.$source_city.' or dist_city='.$source_city.') AND (source_city='.$dest_city.' or dist_city='.$dest_city.') AND status=1 AND pharma_user_id='.$user_id;
		$arr = "source_city ,dist_city, fare ,distance,is_approved";
		$this->db->distinct();
		$this->db->select($arr);
		$this->db->from("master_tour_data");
//        $this->db->where('is_approved',1);
//        $this->db->where('status',1);
		$this->db->where($con);
		$query = $this->db->get();
		if($this->db->affected_rows()){
			return $query->row();
		}
		else{
			return FALSE;
		}
	}


	
}

