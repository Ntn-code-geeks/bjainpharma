<?php



class Meeting_api_model extends CI_Model {



public function save_tour_plan($data)
    {
    	//pr($data); die;
        $datacount=0;
		foreach($data->tourdata as $key=>$value){
			if(date('D',strtotime($value->tour_date))!='Sun'){
				$result=get_holiday_details_data( $value->user_id,date('Y-m-d', strtotime($value->tour_date)));

				$leave=get_leaves_deatils($value->user_id,date('Y-m-d', strtotime($value->tour_date)));

				//if(isset($value->source_city) && isset($value->dest_city) && $value->source_city!='' && $value->dest_city!='')
				if( isset($value->dest_city) && $value->dest_city!='')
				{

					$tour_date = date('Y-m-d', strtotime($value->tour_date));

					if(isset($value->assign_by) && $value->assign_by!=0){
						$color="#f56954";
					}else{
						$color="#efb30e";
					}
					
					$tour_data = array(
						//'source'=>$value->source_city,
						'destination'=>$value->dest_city,
						'remark'=>$value->remark,
						'dot'=>$tour_date,
						'crm_user_id'=> $value->user_id,
						'assign_by'=> isset($value->assign_by)?$value->assign_by:0,
						'created_date'=>savedate(),
						'updated_date'=>savedate(),                  
						'status'=>1, 
						'color_id'=>$color,
					);
					$this->db->insert('user_stp',$tour_data);
					$datacount++; 
				}
				elseif($result)
				{
					$tour_date = date('Y-m-d', strtotime($value->tour_date));
					$color="#167c2a";
					$tour_data = array(
						//'source'=>$value->source_city,
						'destination'=>$value->dest_city,
						'remark'=>$value->remark,
						'dot'=>$tour_date,
						'crm_user_id'=> $value->user_id,
						'assign_by'=> isset($value->assign_by)?$value->assign_by:0,
						'created_date'=>savedate(),
						'updated_date'=>savedate(),                  
						'status'=>1, 
						'color_id'=>$color,
					);
					$this->db->insert('user_stp',$tour_data);
					$datacount++; 
				}

				else if($leave){
					$tour_date = date('Y-m-d', strtotime($value->tour_date));
					$color="#167c2a";
					$tour_data = array(
						'destination'=>$value->dest_city,
						'remark'=>$value->remark,
						'dot'=>$tour_date,
						'crm_user_id'=> logged_user_data(),
						'assign_by'=> $value->assign_by,
						'created_date'=>savedate(),
						'updated_date'=>savedate(),
						'status'=>1,
						'color_id'=>$color,
					);
					$this->db->insert('user_stp',$tour_data);
					$datacount++;
				}
			}

		}
		return true;
    
    }


    public function add_single_tour_plan($data){
		$tour_date=$data['date'];
		$dest_city=$data['dest_city'];
		$remarks=$data['remarks'];
		$assignby=$data['assignby'];
		$assignto=$data['assignto'];

		if(date('D',strtotime($tour_date))!='Sun'){
			$result=get_holiday_details_data($assignto,date('Y-m-d', strtotime($tour_date)));

			$leave=get_leaves_deatils($assignto,date('Y-m-d', strtotime($tour_date)));

			if($result=='' && $leave=='')
			{
				$tour_date = date('Y-m-d', strtotime($tour_date));
				if(isset($assignby) && $assignby!=0){
					$color="#f56954";
				}else{
					$color="#efb30e";
				}
				$tour_data = array(
					'destination'=>$dest_city,
					'remark'=>$remarks,
					'dot'=>$tour_date,
					'crm_user_id'=> $assignto,
					'assign_by'=> isset($assignby)?$assignby:0,
					'created_date'=>savedate(),
					'updated_date'=>savedate(),
					'status'=>1,
					'color_id'=>$color,
				);
				$this->db->insert('user_stp',$tour_data);
			}
			else if($result)
			{
				$tour_date = date('Y-m-d', strtotime($tour_date));
				$color="#167c2a";
				$tour_data = array(
					'destination'=>$dest_city,
					'remark'=>$remarks,
					'dot'=>$tour_date,
					'crm_user_id'=> $assignto,
					'assign_by'=> isset($assignby)?$assignby:0,
					'created_date'=>savedate(),
					'updated_date'=>savedate(),
					'status'=>1,
					'color_id'=>$color,
				);
				$this->db->insert('user_stp',$tour_data);
			}

			else if($leave){
				$tour_date = date('Y-m-d', strtotime($tour_date));
				$color="#f50505";
				$tour_data = array(
					'destination'=>$dest_city,
					'remark'=>$remarks,
					'dot'=>$tour_date,
					'crm_user_id'=> $assignto,
					'assign_by'=> isset($assignby)?$assignby:0,
					'created_date'=>savedate(),
					'updated_date'=>savedate(),
					'status'=>1,
					'color_id'=>$color,
				);
				$this->db->insert('user_stp',$tour_data);
			}
		}
		return true;

	}


	public function planned_city($data){
    	$col='id, destination, dot, remark, assign_by, is_approved';
		$this->db->select($col);
		$this->db->from('user_stp');
		$this->db->where('crm_user_id',$data['user_id']);
		$this->db->where('dot',$data['doi']);
		$query= $this->db->get();
//echo $ci->db->last_query(); die;
		if($this->db->affected_rows()){
			$city_name=get_city_name($query->row()->destination);
			$dataArr=array(
				'city_id' => $query->row()->destination,
				'city_name' => $city_name
			);
			return $dataArr;
		}
		else{
			return FALSE;
		}

	}

}