<?php



/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */



class Meeting_model extends CI_Model {



	public function save_meeting($data){

		$meeting_date = date('Y-m-d', strtotime($data['meeting_date']));
		$meeting_data = array(
			'meeting_place'=>$data['meeting_city'],
			'meeting_type'=>$data['meeting_type'],
			'remark'=>$data['remark'],
			'meeting_date'=>$meeting_date,
			'crm_user_id'=> logged_user_data(),
			'created_date'=>savedate(),
			'updated_date'=>savedate(),
			'status'=>1,
		);
		$this->db->insert('user_meeting',$meeting_data); 

		/* Created By: Nitin kumar
		 * Created On: 27-06-2019
		 * Meeting In TA/DA Report*/
		if($this->db->affected_rows() == 1){

            $user_id=logged_user_data();
            $designation_id=get_user_deatils($user_id)->user_designation_id;
            $userHQ=get_logged_hq($user_id)->hq_city;   ///logged user cityID
            $stp_distance=1;
            $is_stp_approved=0;

            $Destination_city_info=get_city_info($data['meeting_city']);
            $destination_city=$Destination_city_info->pool_pincode;
            $dest_city_id=$Destination_city_info->city_id;

            $source_city_info=get_city_info($userHQ);//one date before from interaction
            $source_city=$source_city_info->pool_pincode;//one date before from interaction
            $source_city_id=$userHQ;//one date before from interaction



            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$source_city
                ."&destinations=".$destination_city.'&key=AIzaSyBW4XD3HI9gZfK-J36dRizXrw6ynJ_ztJI';

            if($source_city_id==get_user_deatils(logged_user_data())->headquarters_city)
            {
                $stp_distance=1;
            }
            else
            {
                $cityData=$this->check_city_path($source_city_id,$dest_city_id);
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
//echo $distance; die;
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
                if($data['up'])
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
            if($data['up'])
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
                if($data['up'])
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
            if($data['up'])
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
                'is_stay'=>$data['stay'],
                'up_down'=>$data['up'],
                'ta'=>$ta,
                'stp_ta'=>$stp_ta,
                'stp_distance'=>$stp_distance,
                'is_stp_approved'=> $is_stp_approved,
                'meet_id'=>'MEETING',
                'doi'=>$meeting_date,
                'created_date'=>savedate(),
                'updated_date'=>savedate(),
                'status'=>1,
            );
            //pr($tour_data); die;
            $this->db->insert('ta_da_report',$tour_data);
            return ($this->db->affected_rows() != 1) ? false : true;
        }

    else{
            return false;
        }
		///return ($this->db->affected_rows() == 1) ? true : false;

    }



	public function get_meeting_list(){

		$arr = "meeting_id,crm_user_id,meeting_date,meeting_place,remark ,meeting_type,status";

        $this->db->select($arr);

        $this->db->from("user_meeting");

        $this->db->where('status',1);
 		// if(!is_admin()){
	  //       $this->db->where('crm_user_id',logged_user_data());
	  //   }

        $query = $this->db->get();

        if($this->db->affected_rows()){

			return $query->result_array();

		}

        else{

            return FALSE;

        }

	}
	
	public function get_meeting_master(){
		$arr = "meeting_id,meeting_value";
		$this->db->select($arr);
		$this->db->from("user_meeting_master");
		$this->db->where('status',1);
		$query = $this->db->get();
		if($this->db->affected_rows()){
			return $query->result_array();
		}
		else{
			return FALSE;
		}
	}

	

	public function get_meeting_data($id){

		$col='meeting_id,crm_user_id,meeting_date,meeting_place,remark ,meeting_type,status';

		$this->db->select($col); 

		$this->db->from('user_meeting'); 

		$this->db->where('meeting_id',$id); 

		$query= $this->db->get(); 

		if($this->db->affected_rows()){

			return $query->result_array(); 

		}	

		else{

            return FALSE;

        }

    }

	

	public function update_meeting($data){

		$meeting_date = date('Y-m-d', strtotime($data['meeting_date']));

		$meeting_data = array(

			'meeting_place'=>$data['meeting_city'],

			'meeting_type'=>$data['meeting_type'],

			'remark'=>$data['remark'],

			'meeting_date'=>$meeting_date,

			'updated_date'=>savedate(),                  

		);

		$this->db->set($meeting_data);

		$this->db->where('meeting_id',$data['meeting_id']); 

		$this->db->update('user_meeting'); 

		return ($this->db->affected_rows() == 1) ? true : false; 

    }

	

	



}





?>