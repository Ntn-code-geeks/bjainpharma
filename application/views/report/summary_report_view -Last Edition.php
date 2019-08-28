<?php
/*
 * Developed By:
** Nitin kumar
 * Created on: 31-07-2019
*/
?>
<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<script src="<?= base_url()?>design/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>design/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>

<style>
    @media  only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
        /*
        Label the data
        */
        td:nth-of-type(1):before { content: "Name"; }
        td:nth-of-type(2):before { content: "Reporting Manager"; }
        td:nth-of-type(3):before { content: "Designation"; }
        td:nth-of-type(4):before { content: "Total No. of Doctors"; }
        td:nth-of-type(5):before { content: "Secondary Sale"; }
        td:nth-of-type(6):before { content: "Total Productive Call"; }
        td:nth-of-type(7):before { content: "Total Number of Order"; }
        td:nth-of-type(8):before { content: "Total Not Met"; }
    }
</style>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Reporting Manager</th>
                                <th>Designation</th>
                                <th>Total No. of Doctors</th>
                                <th>Total No. of Doctors Interaction</th>
                                <th>Total No. of Team Members</th>
                                <th>Total Secondary Sale </th>
                                <th>Total Productive Call </th>
                                <th>Total Number of Order </th>
                                <th>Total Not Met </th>
                            </tr>
                            </thead>

                 <tbody>
					<?php
					$userList=json_decode($userdata);

                    if($w_user_id==''){
                        /*Overall Report*/
                        foreach($userList as $k => $val){
                            $user_SP=getuserSPcode($val->userid);
                            $userSP = $user_SP->sp_code;
                            $user_name=get_user_name($val->userid);
                            $userid=$val->userid;
                            $weekly=$period;
                            $get_boss=get_user_boss($val->userid);
                            $get_boss_name=get_user_name($get_boss[0]['boss_id']);
                            $bossid=$get_boss[0]['boss_id'];
                            $get_uid=get_user_id($user_name);
                            if($get_uid->user_designation_id == '1'){
								$total_doctors = $total_doctors;  //Total No. of doctors
							}else{
								$total_doctors = total_doctor_data($userSP);  //Total No. of doctors
							}
                            $get_designation=get_designation_name($get_uid->user_designation_id);
                            $child_users=count(get_child_user($userid));  //Get Team total team members
							$user_child=get_child_user($userid);

                            if($weekly==''){
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

                                if($period==''){
                                    ?><tr>
                                    <td><?=$user_name ?></td>
                                    <td><?=$get_boss_name ?></td>
                                    <td><?=$get_designation->designation_name ?></td>
                                    <td><?=$total_doctors ?></td>
                                    <td><?=$total_doc_interaction ?></td>
                                    <td><?=$child_users ?></td>
                                    <?php if(!empty($weeksecondary_report)){ ?>
                                        <td><?=number_format($weeksecondary_report,2);?></td>
                                    <?php }else{ ?>
                                        <td>0</td>
                                    <?php } ?>
                                    <?php if(!empty($weekproductive_report)){ ?>
                                        <td><?=$weekproductive_report;?></td>
                                    <?php }else{ ?>
                                        <td>0</td>
                                    <?php } ?>
                                    <?php if(!empty($weeknoroder_report)){ ?>
                                        <td><?=$weeknoroder_report;?></td>
                                    <?php }else{ ?>
                                        <td>0</td>
                                    <?php } ?>

                                    <?php if(!empty($weeknotmet_report)){ ?>
                                        <td><?=$weeknotmet_report;?></td>
                                    <?php }else{ ?>
                                        <td>0</td>
                                    <?php } ?>
                                    </tr>
                                <?php }
                            }
                            if($weekly=='month'){

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
								}else{
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


                                if($period=='month'){  ?>
                                    <!--For the Month-->
                                    <tr>
                                        <td><?=$user_name ?></td>
                                        <td><?=$get_boss_name ?></td>
                                        <td><?=$get_designation->designation_name ?></td>
                                        <td><?=$total_doctors ?></td>
                                        <td><?=$total_doc_interaction ?></td>
										<td><?=$child_users ?></td>
                                        <?php  if(!empty($secondary_month_report)){ ?>
                                            <td><?=number_format($secondary_month_report);?></td>
                                        <?php }else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                        <?php if(!empty($prodcutive_month)){ ?>
                                            <td><?=$prodcutive_month;?></td>
                                        <?php }else{ ?>
                                            <td>0</td>
                                        <?php } ?>

                                        <?php if(!empty($no_order_month_report)){ ?>
                                            <td><?=$no_order_month_report;?></td>
                                        <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>

                                        <?php if(!empty($not_met_month_report)){ ?>
                                            <td><?=$not_met_month_report;?></td>
                                        <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                    </tr>
                                    <!--./ For the Month-->
                                <?php }
                            }
                            if($weekly=='quarter'){
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

                                if($period=='quarter'){ ?>
                                    <tr>
                                        <td><?=$user_name ?></td>
                                        <td><?=$get_boss_name ?></td>
                                        <td><?=$get_designation->designation_name ?></td>
                                        <td><?=$total_doctors ?></td>
                                        <td><?=$total_doc_interaction ?></td>
										<td><?=$child_users ?></td>
                                        <?php if(!empty($secondary_quarter_report)){ ?>
                                            <td><?=number_format($secondary_quarter_report,2)?></td>
                                        <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                        <?php if(!empty($productive_quarter_report)){ ?>
                                            <td><?=$productive_quarter_report;?></td>                         <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                        <?php if(!empty($no_order_quarter_report)){ ?>
                                            <td><?=$no_order_quarter_report;?></td>
                                        <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                        <?php if(!empty($not_met_quarter_report)){ ?>
                                            <td><?=$not_met_quarter_report;?></td>                            <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                    </tr>
                                <?php }
                            }
                            if($weekly=='year'){

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

                                if($period=='year'){ ?>
                                    <tr>
                                        <td><?=$user_name ?></td>
                                        <td><?=$get_boss_name ?></td>
                                        <td><?=$get_designation->designation_name ?></td>
                                        <td><?=$total_doctors ?></td>
                                        <td><?=$total_doc_interaction ?></td>
										<td><?=$child_users ?></td>
                                        <?php if(!empty($secondary_year_report)){ ?>
                                            <td><?=number_format($secondary_year_report,2);?></td>
                                        <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                        <?php if(!empty($productive_year_report)){ ?>
                                            <td><?=$productive_year_report;?></td>
                                        <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                        <!-- /.top payment customer -->

                                        <?php if(!empty($no_order_year_report)){ ?>
                                            <td><?=$no_order_year_report;?></td>
                                        <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>

                                        <?php if(!empty($not_met_year_report)){ ?>
                                            <td><?=$not_met_year_report;?></td>
                                        <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                        <!-- /.Top Secondary Customer -->
                                    </tr>
                                <?php }
                            }
                        }
                    }
                    else{
                            /*User-wise Report*/
                            $user_SP=getuserSPcode($w_user_id);
                            $userSP = $user_SP->sp_code;
                            $user_name=get_user_name($w_user_id);
                            $userid=$w_user_id;
                            $weekly=$period;     //for weekly data
                            $get_boss=get_user_boss($w_user_id);
                            $get_boss_name=get_user_name($get_boss[0]['boss_id']);
                            $bossid=$get_boss[0]['boss_id'];
                            $get_uid=get_user_id($user_name);
                            $get_designation=get_designation_name($get_uid->user_designation_id);
							if($get_uid->user_designation_id == '1'){
								$total_doctors = $total_doctors;  //Total No. of doctors
							}else{
								$total_doctors = total_doctor_data($userSP);  //Total No. of doctors
							}
                        // interaction
							$child_users=count(get_child_user($userid));  //Get Team total team members
						    $user_child=get_child_user($userid);

                            if($weekly==''){

                            for ($iDay = 6; $iDay >= 0; $iDay--) {
                                $aDays[7 - $iDay] = date('Y-m-d 00:00:00', strtotime("-" . $iDay . " day"));
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
									$total_doc_interaction= count(array_intersect($doc_interaction,$aDays));
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

                                if($period==''){
                                    ?><tr>
                                    <td><?=$user_name ?></td>
                                    <td><?=$get_boss_name ?></td>
                                    <td><?=$get_designation->designation_name ?></td>
                                    <td><?=$total_doctors ?></td>
                                    <td><?=$total_doc_interaction ?></td>
                                    <td><?=$child_users ?></td>
                                    <?php if(!empty($weeksecondary_report)){ ?>
                                        <td><?=number_format($weeksecondary_report,2); ?></td>
                                    <?php }else{ ?>
                                        <td>0</td>
                                    <?php } ?>
                                    <?php if(!empty($weekproductive_report)){ ?>
                                        <td><?=$weekproductive_report;?></td>
                                    <?php }else{ ?>
                                        <td>0</td>
                                    <?php } ?>
                                    <?php if(!empty($weeknoroder_report)){ ?>
                                        <td><?=$weeknoroder_report;?></td>
                                    <?php }else{ ?>
                                        <td>0</td>
                                    <?php } ?>

                                    <?php if(!empty($weeknotmet_report)){ ?>
                                        <td><?=$weeknotmet_report;?></td>
                                    <?php }else{ ?>
                                        <td>0</td>
                                    <?php } ?>
                                    </tr>
                                <?php }
                            }
                            if($weekly=='month'){

                            for ($iDay = 30; $iDay >= 0; $iDay--) {
                                $aDays[31 - $iDay] = date('Y-m-d 00:00:00', strtotime("-" . $iDay . " day"));
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
									$total_doc_interaction= array_sum($total_doc_int);
									$prodcutive_month = array_sum($productive_calls);
									$no_order_month_report = array_sum($num_order);
									$not_met_month_report= array_sum($no_order_met);
								}else{
									$secondary_month=total_secondary_analysis($weekly,$userid);
									$doc_interaction = total_doctor_interaction($userid); //Total Doctor
									$total_doc_interaction= count(array_intersect($doc_interaction,$aDays));
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

                                if($period=='month'){  ?>
                                    <!--For the Month-->
                                    <tr>
                                        <td><?=$user_name ?></td>
                                        <td><?=$get_boss_name ?></td>
                                        <td><?=$get_designation->designation_name ?></td>
                                        <td><?=$total_doctors ?></td>
                                        <td><?=$total_doc_interaction ?></td>
										<td><?=$child_users ?></td>
                                        <?php  if(!empty($secondary_month_report)){ ?>
                                            <td><?=number_format($secondary_month_report,2);?></td>
                                        <?php }else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                        <?php if(!empty($prodcutive_month)){ ?>
                                            <td><?=$prodcutive_month;?></td>
                                        <?php }else{ ?>
                                            <td>0</td>
                                        <?php } ?>

                                        <?php if(!empty($no_order_month_report)){ ?>
                                            <td><?=$no_order_month_report;?></td>
                                        <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>

                                        <?php if(!empty($not_met_month_report)){ ?>
                                            <td><?=$not_met_month_report;?></td>
                                        <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                    </tr>
                                    <!--./ For the Month-->
                                <?php }
                            }
                            if($weekly=='quarter'){

                            for ($iDay = 91; $iDay >= 0; $iDay--) {
                                $aDays[92 - $iDay] = date('Y-m-d 00:00:00', strtotime("-" . $iDay . " day"));
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
									$total_doc_interaction= array_sum($total_doc_int);
									$productive_quarter_report =array_sum($productive_calls);
									$no_order_quarter_report=array_sum($num_order);
									$not_met_quarter_report=array_sum($no_order_met);
								}else{
									$secondary_quarter=total_secondary_analysis($weekly,$userid);
									$doc_interaction = total_doctor_interaction($userid); //Total Doctor
									$total_doc_interaction= count(array_intersect($doc_interaction,$aDays));
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

                                if($period=='quarter'){ ?>
                                    <tr>
                                        <td><?=$user_name ?></td>
                                        <td><?=$get_boss_name ?></td>
                                        <td><?=$get_designation->designation_name ?></td>
                                        <td><?=$total_doctors ?></td>
                                        <td><?=$total_doc_interaction ?></td>
										<td><?=$child_users ?></td>
                                        <?php if(!empty($secondary_quarter_report)){ ?>
                                            <td><?=number_format($secondary_quarter_report, 2);?></td>
                                        <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                        <?php if(!empty($productive_quarter_report)){ ?>
                                            <td><?=$productive_quarter_report;?></td>                         <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                        <?php if(!empty($no_order_quarter_report)){ ?>
                                            <td><?=$no_order_quarter_report;?></td>
                                        <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                        <?php if(!empty($not_met_quarter_report)){ ?>
                                            <td><?=$not_met_quarter_report;?></td>                            <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                    </tr>
                                <?php }
                            }
                            if($weekly=='year'){

                            for ($iDay = 364; $iDay >= 0; $iDay--) {
                                $aDays[365 - $iDay] = date('Y-m-d 00:00:00', strtotime("-" . $iDay . " day"));
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
									$total_doc_interaction=array_sum($total_doc_int);
									$productive_year_report=array_sum($productive_calls);
									$no_order_year_report=array_sum($num_order);
									$not_met_year_report=array_sum($no_order_met);
								}else{
									$secondary_year=total_secondary_analysis($weekly,$userid);
									$doc_interaction = total_doctor_interaction($userid); //Total Doctor
									$total_doc_interaction= count(array_intersect($doc_interaction,$aDays));
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

                                if($period=='year'){ ?>
                                    <tr>
                                        <td><?=$user_name ?></td>
                                        <td><?=$get_boss_name ?></td>
                                        <td><?=$get_designation->designation_name ?></td>
                                        <td><?=$total_doctors ?></td>
                                        <td><?=$total_doc_interaction ?></td>
										<td><?=$child_users ?></td>
                                        <?php if(!empty($secondary_year_report)){ ?>
                                            <td><?=number_format($secondary_year_report,2);?></td>
                                        <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                        <?php if(!empty($productive_year_report)){ ?>
                                            <td><?=$productive_year_report;?></td>
                                        <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                        <!-- /.top payment customer -->

                                        <?php if(!empty($no_order_year_report)){ ?>
                                            <td><?=$no_order_year_report;?></td>
                                        <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>

                                        <?php if(!empty($not_met_year_report)){ ?>
                                            <td><?=$not_met_year_report;?></td>
                                        <?php } else{ ?>
                                            <td>0</td>
                                        <?php } ?>
                                        <!-- /.Top Secondary Customer -->
                                    </tr>
                                <?php }
                            }

                    }

    				?>


                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div></div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<script>
    $(function () {
        $('#example2').DataTable({
            dom: 'Bfrtip',
            buttons: [
               'csv', 'print',
            ],
            'responsive' : true,
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
        });
    });
</script>
