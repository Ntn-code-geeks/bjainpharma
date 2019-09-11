<?php



/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

class User_model extends CI_Model {


    public function check_user($mail){

        $arr ="pu.admin, pu.sp_code,pu.switchStatus,pu.id,pu.email_id,pu.password,pu.name,pu.is_first_time,"
                . "pu.user_city_id as city_id,pu.user_designation_id as desig_id,"
                . "(SELECT GROUP_CONCAT(`pharma_id` separator ', ') as pharma_id FROM `user_pharmacy_relation` `upr` WHERE `pu`.`id`=`upr`.`user_id`) as pharma_id,"
                . "(SELECT GROUP_CONCAT(ubr.`boss_id` separator ', ') as boss_id FROM `user_bossuser_relation` `ubr` WHERE `pu`.`id`=`ubr`.`user_id`) as boss_ids ,"
                . "(SELECT GROUP_CONCAT(udr.`doc_id` separator ', ') as doctor_id FROM `user_doctor_relation` `udr` WHERE `pu`.`id`=`udr`.`user_id`) as doctor_id ,"
                . "(SELECT GROUP_CONCAT(ubr.`user_id` separator ', ') as boss_id FROM `user_bossuser_relation` `ubr` WHERE `pu`.`id`=`ubr`.`boss_id`) as child_ids ";

        $this->db->select($arr);

        $this->db->from('pharma_users pu');

        $this->db->where('pu.email_id',$mail);

        $this->db->where('pu.user_status',1);

        $query = $this->db->get();

//        echo $this->db->last_query(); die;

        if($this->db->affected_rows()){

            return $query->row();

        }
        else{

            return FALSE;

        }

    
        

    }

    // users list

    public function users_report(){

        

        $arr ="pu.id as userid,pu.name as username";

        $this->db->select($arr);

        $this->db->from('pharma_users pu');

        $this->db->where('pu.user_status',1);

        

        $query= $this->db->get();

//        echo $this->db->last_query(); die;

        if($this->db->affected_rows()){

            

           return json_encode($query->result_array());

        }

        else{

            

            return FALSE;

        }

        

       

        

        

    }


    // switch the users accounts

    public function user_switch($uid){

		

        

        $arr ="pu.admin,pu.sp_code,pu.id,pu.email_id,pu.password,pu.name,pu.user_city_id as city_id,pu.user_designation_id as desig_id,(SELECT GROUP_CONCAT(`pharma_id` separator ', ') as pharma_id FROM `user_pharmacy_relation` `upr` WHERE `pu`.`id`=`upr`.`user_id`) as pharma_id,(SELECT GROUP_CONCAT(ubr.`boss_id` separator ', ') as boss_id FROM `user_bossuser_relation` `ubr` WHERE `pu`.`id`=`ubr`.`user_id`) as boss_ids ,(SELECT GROUP_CONCAT(udr.`doc_id` separator ', ') as doctor_id FROM `user_doctor_relation` `udr` WHERE `pu`.`id`=`udr`.`user_id`) as doctor_id ,"

                . "(SELECT GROUP_CONCAT(ubr.`user_id` separator ', ') as boss_id FROM `user_bossuser_relation` `ubr` WHERE `pu`.`id`=`ubr`.`boss_id`) as child_ids ";

        $this->db->select($arr);

        $this->db->from('pharma_users pu');

        $this->db->where('pu.id',$uid);

        

        $query= $this->db->get();

			if ( $this->db->affected_rows() ){

				$resultSet = $query->row();

				

                                $newdata = array(

					'userName'=>$resultSet->name,

						'userId'=>$resultSet->id,

						'userEmail'=>$resultSet->email_id,

                                                'userCity'=>$resultSet->city_id,

                                                'userDesig'=>$resultSet->desig_id,

                                                'pharmaAre'=>$resultSet->pharma_id,

                                                'doctorAre'=>$resultSet->doctor_id,

                                                'userBoss' => $resultSet->boss_ids,

                                                'userChild'=>$resultSet->child_ids,
                                                 'sp_code'=>$resultSet->sp_code,
                                                 'admin'=>$resultSet->admin,

				);

				$this->session->set_userdata($newdata);

				$status = true;

                return $status;

			}

		

	}

    public function change_user_password($data)
    {
       $pass_data = array(
                'password'=>md5($data['password']),
                 'is_first_time'=>0,
                'last_update'=> savedate(),
                'crm_user_id' =>logged_user_data(),
            );
        $this->db->where('id',$data['user_id']);
        $this->db->update('pharma_users',$pass_data);
        //echo $this->db->last_query(); die;      
        if ($this->db->affected_rows())
        {
          return true;
        }
        else
        {
          return false;
        }   
    }


    /*Generating JSON for Secondary Reports*/
    public function weeklyReportData($data){
		$userList=json_decode($data['userdata']);
		$total_doc=$data['total_doctors'];
		//$weekly_dataArray=array();
		/*Weekly Report*/
		foreach($userList as $k => $val){
			$user_SP=getuserSPcode($val->userid);
			$userSP = $user_SP->sp_code;
			$user_name=get_user_name($val->userid);
			$userid=$val->userid;
			$weekly='';
			$get_boss=get_user_boss($val->userid);
			$get_boss_name=get_user_name($get_boss[0]['boss_id']);
			$bossid=$get_boss[0]['boss_id'];
			$get_uid=get_user_id($user_name);
			if($get_uid->user_designation_id == '1'){
				$total_doctors = $total_doc;  //Total No. of doctors
			}else{
				if($userid=='190'){
					$total_doctors = $total_doc;
				}else{
					$total_doctors = total_doctor_data($userSP);  //Total No. of doctors
				}
			}
			$get_designation=get_designation_name($get_uid->user_designation_id);
			$child_users=count(get_child_user($userid));  //Get Team total team members
			$user_child=get_child_user($userid);

			for ($iDay = 6; $iDay >= 0; $iDay--) {
				@$aDays[7 - $iDay] = date('Y-m-d 00:00:00', strtotime("-" . $iDay . " day"));
			}

			if($child_users > 1){
				$secondary_val=array();
				$total_doc_int=array();
				$productive_calls=array();
				$num_order=array();
				$no_order_met=array();
				foreach($user_child as $childs){
					$k_secry=total_secondary_analysis($weekly,$childs);
					@$secondary_val[]=$k_secry->total_secondry;
					@$doc_interaction = total_doctor_interaction($childs); //Total Doctor
					@$total_doc_int[]=count(array_intersect($doc_interaction,$aDays));
					@$productive_calls[]=total_productive_analysis($weekly,$childs);
					@$num_order[]=total_noorder_met_analysis($weekly,$childs);
					@$no_order_met[]=total_not_met_analysis($weekly,$childs);
				}

				$week_secondary=array_sum($secondary_val);
				$total_doc_interaction=array_sum($total_doc_int);
				$weekproductive_report = array_sum($productive_calls);
				$weeknoroder_report=array_sum($num_order);
				$weeknotmet_report=array_sum($no_order_met);

			}else{
				$week_secondary=total_secondary_analysis($weekly,$userid);
				$doc_interaction = total_doctor_interaction($userid); //Total Doctor
				@$total_doc_interaction= count(array_intersect($doc_interaction,$aDays));
				$weekproductive_report =total_productive_analysis($weekly,$userid);
				$weeknoroder_report=total_noorder_met_analysis($weekly,$userid);
				$weeknotmet_report=total_not_met_analysis($weekly,$userid);
			}

			/*For this week*/
			if($child_users > 1){
				$weeksecondary_report = $week_secondary;
			}else {
				$weeksecondary_report = $week_secondary->total_secondry;  //for secondary
			}

			$weekly_dataArray[$userid]=array(
					'user_id'=> $userid,
					'username'=> $user_name,
					'bossname'=> $get_boss_name,
					'designation_name'=> $get_designation->designation_name,
					'total_doctors'=> $total_doctors,
					'total_doc_interaction'=> $total_doc_interaction,
					'team_members'=> $child_users,
					'total_secondary'=> number_format($weeksecondary_report,2),
					'total_productive_call'=> $weekproductive_report,
					'total_orders'=> $weeknoroder_report,
					'total_orders_not_met'=> $weeknotmet_report,
					);

		}

		$fp = fopen('ReportJSON/weekly.json', 'w');
		fwrite($fp, json_encode($weekly_dataArray));
		fclose($fp);

	}
	public function monthlyReportData($data){
		$userList=json_decode($data['userdata']);
		$total_doc=$data['total_doctors'];
		$monthly_dataArray=array();
		/*Monthly Report*/
		foreach($userList as $k => $val){
			$user_SP=getuserSPcode($val->userid);
			$userSP = $user_SP->sp_code;
			$user_name=get_user_name($val->userid);
			$userid=$val->userid;
			$weekly='month';
			$get_boss=get_user_boss($val->userid);
			$get_boss_name=get_user_name($get_boss[0]['boss_id']);
			$bossid=$get_boss[0]['boss_id'];
			$get_uid=get_user_id($user_name);
			if($get_uid->user_designation_id == '1'){
				$total_doctors = $total_doc;  //Total No. of doctors
			}else{
				if($userid=='190'){
					$total_doctors = $total_doc;
				}else{
					$total_doctors = total_doctor_data($userSP);  //Total No. of doctors
				}
			}
			$get_designation=get_designation_name($get_uid->user_designation_id);
			$child_users=count(get_child_user($userid));  //Get Team total team members
			$user_child=get_child_user($userid);

			for ($iDay = 30; $iDay >= 0; $iDay--) {
				@$aDays[31 - $iDay] = date('Y-m-d 00:00:00', strtotime("-" . $iDay . " day"));
			}

			if($child_users > 1){
				$secondary_val=array();
				$total_doc_int=array();
				$productive_calls=array();
				$num_order=array();
				$no_order_met=array();
				foreach($user_child as $childs){
					$k_secry=total_secondary_analysis($weekly,$childs);
					@$secondary_val[]=$k_secry->total_secondry;
					@$doc_interaction = total_doctor_interaction($childs); //Total Doctor
					@$total_doc_int[]=count(array_intersect($doc_interaction,$aDays));
					@$productive_calls[]=total_productive_analysis($weekly,$childs);
					@$num_order[]=total_noorder_met_analysis($weekly,$childs);
					@$no_order_met[]=total_not_met_analysis($weekly,$childs);
				}
				$secondary_month=array_sum($secondary_val);
				@$total_doc_interaction= array_sum($total_doc_int);
				$prodcutive_month = array_sum($productive_calls);
				$no_order_month_report = array_sum($num_order);
				$not_met_month_report= array_sum($no_order_met);
			}
			else{
				$secondary_month=total_secondary_analysis($weekly,$userid);
				$doc_interaction = total_doctor_interaction($userid); //Total Doctor
				@$total_doc_interaction= count(array_intersect($doc_interaction,$aDays));
				$prodcutive_month =total_productive_analysis($weekly,$userid);
				$no_order_month_report =total_noorder_met_analysis($weekly,$userid);
				$not_met_month_report=total_not_met_analysis($weekly,$userid);
			}

			/*For this Month*/
			if($child_users > 1){
				$secondary_month_report = $secondary_month;
			}else {
				$secondary_month_report = $secondary_month->total_secondry;  //for secondary
			}

			$monthly_dataArray[$userid]=array(
				'user_id'=> $userid,
				'username'=> $user_name,
				'bossname'=> $get_boss_name,
				'designation_name'=> $get_designation->designation_name,
				'total_doctors'=> $total_doctors,
				'total_doc_interaction'=> $total_doc_interaction,
				'team_members'=> $child_users,
				'total_secondary'=> number_format($secondary_month_report,2),
				'total_productive_call'=> $prodcutive_month,
				'total_orders'=> $no_order_month_report,
				'total_orders_not_met'=> $not_met_month_report,
			);

		}

		$fp1 = fopen('ReportJSON/monthly.json', 'w');
		fwrite($fp1, json_encode($monthly_dataArray));
		fclose($fp1);
	}
	public function quarterlyReportData($data){
		$userList=json_decode($data['userdata']);
		$total_doc=$data['total_doctors'];
		$quart_dataArray=array();
		/*Quarterly Report*/
		foreach($userList as $k => $val){
			$user_SP=getuserSPcode($val->userid);
			$userSP = $user_SP->sp_code;
			$user_name=get_user_name($val->userid);
			$userid=$val->userid;
			$weekly='quarter';
			$get_boss=get_user_boss($val->userid);
			$get_boss_name=get_user_name($get_boss[0]['boss_id']);
			$bossid=$get_boss[0]['boss_id'];
			$get_uid=get_user_id($user_name);
			if($get_uid->user_designation_id == '1'){
				$total_doctors = $total_doc;  //Total No. of doctors
			}else{
				if($userid=='190'){
					$total_doctors = $total_doc;
				}else{
					$total_doctors = total_doctor_data($userSP);  //Total No. of doctors
				}
			}
			$get_designation=get_designation_name($get_uid->user_designation_id);
			$child_users=count(get_child_user($userid));  //Get Team total team members
			$user_child=get_child_user($userid);

			for ($iDay = 91; $iDay >= 0; $iDay--) {
				@$aDays[92 - $iDay] = date('Y-m-d 00:00:00', strtotime("-" . $iDay . " day"));
			}

			if($child_users > 1){
				$secondary_val=array();
				$total_doc_int=array();
				$productive_calls=array();
				$num_order=array();
				$no_order_met=array();
				foreach($user_child as $childs){
					$k_secry=total_secondary_analysis($weekly,$childs);
					@$secondary_val[]=$k_secry->total_secondry;
					@$doc_interaction = total_doctor_interaction($childs); //Total Doctor
					@$total_doc_int[]= count(array_intersect($doc_interaction,$aDays));
					@$productive_calls[]=total_productive_analysis($weekly,$childs);
					@$num_order[]=total_noorder_met_analysis($weekly,$childs);
					@$no_order_met[]=total_not_met_analysis($weekly,$childs);
				}
				$secondary_quarter=array_sum($secondary_val);
				@$total_doc_interaction= array_sum($total_doc_int);
				$productive_quarter_report =array_sum($productive_calls);
				$no_order_quarter_report=array_sum($num_order);
				$not_met_quarter_report=array_sum($no_order_met);
			}else{
				$secondary_quarter=total_secondary_analysis($weekly,$userid);
				$doc_interaction = total_doctor_interaction($userid); //Total Doctor
				@$total_doc_interaction= count(array_intersect($doc_interaction,$aDays));
				$productive_quarter_report =total_productive_analysis($weekly,$userid);
				$no_order_quarter_report=total_noorder_met_analysis($weekly,$userid);
				$not_met_quarter_report=total_not_met_analysis($weekly,$userid);
			}

			/*For this Quarter*/
			if($child_users > 1){
				$secondary_quarter_report = $secondary_quarter;
			}else {
				$secondary_quarter_report = $secondary_quarter->total_secondry;  //for secondary
			}


			$quart_dataArray[$userid]=array(
				'user_id'=> $userid,
				'username'=> $user_name,
				'bossname'=> $get_boss_name,
				'designation_name'=> $get_designation->designation_name,
				'total_doctors'=> $total_doctors,
				'total_doc_interaction'=> $total_doc_interaction,
				'team_members'=> $child_users,
				'total_secondary'=> number_format($secondary_quarter_report,2),
				'total_productive_call'=> $productive_quarter_report,
				'total_orders'=> $no_order_quarter_report,
				'total_orders_not_met'=> $not_met_quarter_report,
			);

		}

		$fp2 = fopen('ReportJSON/quarterly.json', 'w');
		fwrite($fp2, json_encode($quart_dataArray));
		fclose($fp2);
	}
	public function yearlyReportData($data){
		$userList=json_decode($data['userdata']);
		$total_doc=$data['total_doctors'];
		$yearly_dataArray=array();
		/*Yearly Report*/
		foreach($userList as $k => $val){
			$user_SP=getuserSPcode($val->userid);
			$userSP = $user_SP->sp_code;
			$user_name=get_user_name($val->userid);
			$userid=$val->userid;
			$weekly='year';
			$get_boss=get_user_boss($val->userid);
			$get_boss_name=get_user_name($get_boss[0]['boss_id']);
			$bossid=$get_boss[0]['boss_id'];
			$get_uid=get_user_id($user_name);
			if($get_uid->user_designation_id == '1'){
				$total_doctors = $total_doc;  //Total No. of doctors
			}else{
				if($userid=='190'){
					$total_doctors = $total_doc;
				}else{
					$total_doctors = total_doctor_data($userSP);  //Total No. of doctors
				}
			}
			$get_designation=get_designation_name($get_uid->user_designation_id);
			$child_users=count(get_child_user($userid));  //Get Team total team members
			$user_child=get_child_user($userid);

			for ($iDay = 364; $iDay >= 0; $iDay--) {
				@$aDays[365 - $iDay] = date('Y-m-d 00:00:00', strtotime("-" . $iDay . " day"));
			}

			if($child_users > 1){
				$secondary_val=array();
				$total_doc_int=array();
				$productive_calls=array();
				$num_order=array();
				$no_order_met=array();
				foreach($user_child as $childs){
					$k_secry=total_secondary_analysis($weekly,$childs);
					$secondary_val[]=$k_secry->total_secondry;
					@$doc_interaction = total_doctor_interaction($childs); //Total Doctor
					@$total_doc_int[]= count(array_intersect($doc_interaction,$aDays));
					@$productive_calls[]=total_productive_analysis($weekly,$childs);
					@$num_order[]=total_noorder_met_analysis($weekly,$childs);
					@$no_order_met[]=total_not_met_analysis($weekly,$childs);
				}
				$secondary_year=array_sum($secondary_val);
				@$total_doc_interaction=array_sum($total_doc_int);
				$productive_year_report=array_sum($productive_calls);
				$no_order_year_report=array_sum($num_order);
				$not_met_year_report=array_sum($no_order_met);
			}else{
				$secondary_year=total_secondary_analysis($weekly,$userid);
				$doc_interaction = total_doctor_interaction($userid); //Total Doctor
				@$total_doc_interaction= count(array_intersect($doc_interaction,$aDays));
				$productive_year_report =total_productive_analysis($weekly,$userid);
				$no_order_year_report =total_noorder_met_analysis($weekly,$userid);
				$not_met_year_report=total_not_met_analysis($weekly,$userid);
			}

			/*For this Year*/
			if($child_users > 1){
				$secondary_year_report = $secondary_year;
			}else {
				$secondary_year_report = $secondary_year->total_secondry;  // for see Doctor
			}

			$yearly_dataArray[$userid]=array(
				'user_id'=> $userid,
				'username'=> $user_name,
				'bossname'=> $get_boss_name,
				'designation_name'=> $get_designation->designation_name,
				'total_doctors'=> $total_doctors,
				'total_doc_interaction'=> $total_doc_interaction,
				'team_members'=> $child_users,
				'total_secondary'=> number_format($secondary_year_report,2),
				'total_productive_call'=> $productive_year_report,
				'total_orders'=> $no_order_year_report,
				'total_orders_not_met'=> $not_met_year_report,
			);

		}

		$fp3 = fopen('ReportJSON/yearly.json', 'w');
		fwrite($fp3, json_encode($yearly_dataArray));
		fclose($fp3);
	}

	/*Generating JSON for Secondary Supply*/
	public function secondary_supply($data){
    	$doctor_data=json_decode($data['doc_data']);
    	$pharma_data=json_decode($data['pharma_data']);
    	$doc=array();
		foreach($doctor_data as $doc_data){
			$doc[]=array(
				'user_id' => $doc_data->user_id,
				'city_id' => $doc_data->city_id,
				'doctorname' => $doc_data->doctorname,
				'actualsale' => $doc_data->actualsale,
				'id' => $doc_data->id,
				'secondarysale' => $doc_data->secondarysale,
				'date_of_interaction' => $doc_data->date_of_interaction,
				'dealer_name' => $doc_data->dealer_name,
				'pharmaname' => $doc_data->pharmaname,
				'close_status' => $doc_data->close_status,
			);

		}
		$fp1 = fopen('ReportJSON/doc_secondary_supply.json', 'w');
		fwrite($fp1, json_encode($doc));
		fclose($fp1);


		$phar=array();
		foreach($pharma_data as $phr_data){
			$phar[]=array(
				'user_id' => $phr_data->user_id,
				'city_id' => $phr_data->city_id,
				'pharmaname' => $phr_data->pharmaname,
				'actualsale' => $phr_data->actualsale,
				'id' => $phr_data->id,
				'secondarysale' => $phr_data->secondarysale,
				'date_of_interaction' => $phr_data->date_of_interaction,
				'dealer_name' => $phr_data->dealer_name,
				'close_status' => $phr_data->close_status,
			);
		}
		$fp2 = fopen('ReportJSON/phar_secondary_supply.json', 'w');
		fwrite($fp2, json_encode($phar));
		fclose($fp2);

    }


    /*Generating JSON for Interaction Summary*/
	public function interaction_doctor_report($start='',$end=''){
		$arr = "pu.id as user_id,pid.telephonic as oncall,pid.id,pid.remark,pid.orignal_sale as order_supply,pid.date_of_supply,`pid`.`meeting_sale` as `secondary_sale`, `pid`.`meet_or_not_meet` as `metnotmet`,pid.create_date as date,pid.doc_id,doc.doc_name as customer,c.city_name as city,pu.name as user,pid.dealer_id";
		$this->db->select($arr);
		$this->db->from("pharma_interaction_doctor pid");
		$this->db->join("doctor_list doc" , "doc.doctor_id=pid.doc_id");
		$this->db->join("pharma_users pu" , "pu.id=pid.crm_user_id","Left");
		$this->db->join("doctor_interaction_with_team  team" , "team.pidoc_id=pid.id","Left");
		$this->db->join("pharma_users pus" , "pus.id=team.team_id","Left");
		$this->db->join("city c" , "c.city_id=doc.city_id");
		$this->db->join("state st" , "st.state_id=doc.state_id");
		$this->db->where('pid.status',1);
		$this->db->group_by('pid.id');
		$this->db->order_by('pid.doc_id','ASC');
		$query = $this->db->get();
		$doc_travel_info = $query->result_array();

		if($this->db->affected_rows()){
			$team_interaction = array();
			foreach ($doc_travel_info as $k=>$val){
				$arr = "GROUP_CONCAT(msm.sample_name SEPARATOR ',') as `sample`";
				$this->db->select($arr);
				$this->db->from("pharma_interaction_doctor pid");
				$this->db->join("doctor_interaction_sample_relation  disr" , "disr.pidoc_id=pid.id","Left");
				$this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");
				$this->db->where('disr.pidoc_id',$val['id']);
				$this->db->group_by('pid.doc_id');
				$query = $this->db->get();
				$doc_travel_info[$k]['sample'] = $query->row_array();
				$arr = "pid.doc_id,GROUP_CONCAT(`pus`.`name` SEPARATOR ',') as `team_user`,team.team_id,team.crm_user_id,pid.crm_user_id as userid";
				$this->db->select($arr);
				$this->db->from("pharma_interaction_doctor pid");
				$this->db->join("doctor_interaction_with_team  team" , "team.pidoc_id=pid.id");
				$this->db->join("pharma_users pus" , "pus.id=team.team_id");
				$this->db->where('team.pidoc_id',$val['id']);
				$this->db->where('pid.create_date >=', $start);
				$this->db->where('pid.create_date <=', $end);
				$this->db->group_by('team.pidoc_id');
				$query = $this->db->get();
				$team_interaction[] = $query->row_array();
			}
			$result = array('doc_info'=>$doc_travel_info,'team_info'=>$team_interaction);

			$fp = fopen('ReportJSON/IntrctionDocSumry.json', 'w');
			fwrite($fp, json_encode($result));
			fclose($fp);

		}else{
			return FALSE;
		}
	}

	public function interaction_pharmacy_report(){
		$arr = "pu.id as user_id,pip.pharma_id,pip.telephonic as oncall,pip.id, pip.remark,pip.orignal_sale as order_supply,pip.date_of_supply,`pip`.`pharma_id`, `pl`.`company_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user`,`pip`.`meeting_sale` as `secondary_sale`, `pip`.`meet_or_not_meet` as `metnotmet`,pip.create_date as date,pip.dealer_id ";
		$this->db->select($arr);
		$this->db->from("pharma_interaction_pharmacy pip");
		$this->db->join("pharmacy_list pl","pl.pharma_id=pip.pharma_id");
		$this->db->join("pharma_users pu" , "pu.id=pip.crm_user_id","Left");
		$this->db->join("pharmacy_interaction_with_team  team" , "team.pipharma_id=pip.id","Left");
		$this->db->join("pharma_users pus" , "pus.id=team.team_id","Left");
		$this->db->join("city c" , "c.city_id=pl.city_id");
		$this->db->join("state st" , "st.state_id=pl.state_id");
		$this->db->where('pip.status',1);
		$this->db->group_by('pip.id');
		$query = $this->db->get();
		$pharmacy_travel_info = $query->result_array();

		if($this->db->affected_rows()){
			$team_interaction = array();
			foreach ($pharmacy_travel_info as $k=>$val){
				$arr = "GROUP_CONCAT(msm.sample_name SEPARATOR ',') as `sample`";
				$this->db->select($arr);
				$this->db->from("pharma_interaction_pharmacy pip");
				$this->db->join("pharmacy_interaction_sample_relation  pisr" , "pisr.pipharma_id=pip.id","Left");
				$this->db->join("meeting_sample_master  msm" , "msm.id=pisr.sample_id","Left");
				$this->db->where('pisr.pipharma_id',$val['id']);
				$this->db->group_by('pip.id');
				$query = $this->db->get();
//               echo $this->db->last_query(); die;
				$pharmacy_travel_info[$k]['sample'] = $query->row_array();
				$arr = "pip.pharma_id,GROUP_CONCAT(`pus`.`name` SEPARATOR ',') as `team_user`";
				$this->db->select($arr);
				$this->db->from("pharma_interaction_pharmacy pip");
				$this->db->join("pharmacy_interaction_with_team  team" , "team.pipharma_id=pip.id");
				$this->db->join("pharma_users pus" , "pus.id=team.team_id");
				$this->db->where('team.pipharma_id',$val['id']);
				$this->db->group_by('team.pipharma_id');
				$query = $this->db->get();
				$team_interaction[] = $query->row_array();
			}
			$result = array('pharmacy_info'=>$pharmacy_travel_info,'team_info'=>$team_interaction);
			$fp = fopen('ReportJSON/IntrctionPharmaSumry.json', 'w');
			fwrite($fp, json_encode($result));
			fclose($fp);
		}
		else{
			return FALSE;
		}
	}

	public function interaction_dealer_report(){

		$arr = "pu.id as user_id,pi.telephonic as oncall,pi.id,pi.remark,dl.gd_id as is_cf,pi.create_date as date,`pi`.`d_id`, `dl`.`dealer_name` as `customer`, `c`.`city_name` as `city`, `pu`.`name` as `user`,pi.meeting_sale as sale,pi.meeting_payment as payment,pi.meeting_stock as stock,pi.meet_or_not_meet as metnotmet,pi.d_id ";
		$this->db->select($arr);
		$this->db->from("pharma_interaction_dealer pi");
		$this->db->join("dealer dl" , "dl.dealer_id=pi.d_id");
		$this->db->join("pharma_users pu" , "pu.id=pi.crm_user_id","left");
		$this->db->join("dealer_interaction_with_team  team" , "team.pidealer_id=pi.id","left");
		$this->db->join("pharma_users pus" , "pus.id=team.team_id","left");
		$this->db->join("city c" , "c.city_id=dl.city_id");
		$this->db->join("state st" , "st.state_id=dl.state_id");
		$this->db->where('pi.status',1);
		$this->db->group_by('pi.id');
		$this->db->order_by('dl.dealer_name','ASC');
		$query = $this->db->get();
		$dealer_travel_info = $query->result_array();
		if($this->db->affected_rows()){
			$team_interaction = array();
			foreach ($dealer_travel_info as $k=>$val){
				$arr = "GROUP_CONCAT(msm.sample_name SEPARATOR ',') as `sample`";
				$this->db->select($arr);
				$this->db->from("pharma_interaction_dealer pi");
				$this->db->join("dealer_interaction_sample_relation  disr" , "disr.pidealer_id=pi.id","Left");
				$this->db->join("meeting_sample_master  msm" , "msm.id=disr.sample_id","Left");
				$this->db->where('disr.pidealer_id',$val['id']);
				$this->db->group_by('pi.id');
				$query = $this->db->get();
//               echo $this->db->last_query(); die;
				$dealer_travel_info[$k]['sample'] = $query->row_array();
				$arr = "pi.d_id,GROUP_CONCAT(`pus`.`name` SEPARATOR ',') as `team_user`";
				$this->db->select($arr);
				$this->db->from("pharma_interaction_dealer pi");
				$this->db->join("dealer_interaction_with_team  team" , "team.pidealer_id=pi.id");
				$this->db->join("pharma_users pus" , "pus.id=team.team_id");
				$this->db->where('team.pidealer_id',$val['id']);
				$this->db->group_by('team.pidealer_id');
				$query = $this->db->get();
//               echo $this->db->last_query(); die;
				$team_interaction[] = $query->row_array();
			}
			$result = array('dealer_info'=>$dealer_travel_info,'team_info'=>$team_interaction);
			$fp = fopen('ReportJSON/IntrctionDealerSumry.json', 'w');
			fwrite($fp, json_encode($result));
			fclose($fp);
		}else{
			return FALSE;
		}

	}


}

