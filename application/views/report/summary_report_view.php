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
                                <th>City Name</th>
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
                      $timeline = $period;
                       if($timeline==''){
						   $data = file_get_contents ("ReportJSON/weekly.json");
						   $json = json_decode($data, true);
						   foreach($json as $weekly_data){ ?>
							   <tr>
								   <td><?= $weekly_data['username'] ?></td>
								   <td><?=$weekly_data['bossname'] ?></td>
								   <td><?=$weekly_data['city_name'] ?></td>
								   <td><?=$weekly_data['designation_name'] ?></td>
								   <td><?=$weekly_data['total_doctors'] ?></td>
								   <td><?=$weekly_data['total_doc_interaction'] ?></td>
								   <td><?=$weekly_data['team_members'] ?></td>
								   <?php if(!empty($weekly_data['total_secondary'])){ ?>
									   <td><?=$weekly_data['total_secondary'];?></td>
								   <?php }else{ ?>
									   <td>0</td>
								   <?php } ?>
								   <?php if(!empty($weekly_data['total_productive_call'])){ ?>
									   <td><?=$weekly_data['total_productive_call'];?></td>
								   <?php }else{ ?>
									   <td>0</td>
								   <?php } ?>
								   <?php if(!empty($weekly_data['total_orders'])){ ?>
									   <td><?=$weekly_data['total_orders'];?></td>
								   <?php }else{ ?>
									   <td>0</td>
								   <?php } ?>
								   <?php if(!empty($weekly_data['total_orders_not_met'])){ ?>
									   <td><?=$weekly_data['total_orders_not_met'];?></td>
								   <?php }else{ ?>
									   <td>0</td>
								   <?php } ?>
							   </tr>
						   <?php }
					   }
                       if($timeline=='month'){
						   $data = file_get_contents ("ReportJSON/monthly.json");
						   $json = json_decode($data, true);
						   foreach($json as $weekly_data){	 ?>
							   <tr>
								   <td><?= $weekly_data['username'] ?></td>
								   <td><?=$weekly_data['bossname'] ?></td>
								   <td><?=$weekly_data['city_name'] ?></td>
								   <td><?=$weekly_data['designation_name'] ?></td>
								   <td><?=$weekly_data['total_doctors'] ?></td>
								   <td><?=$weekly_data['total_doc_interaction'] ?></td>
								   <td><?=$weekly_data['team_members'] ?></td>
								   <?php if(!empty($weekly_data['total_secondary'])){ ?>
									   <td><?=$weekly_data['total_secondary'];?></td>
								   <?php }else{ ?>
									   <td>0</td>
								   <?php } ?>
								   <?php if(!empty($weekly_data['total_productive_call'])){ ?>
									   <td><?=$weekly_data['total_productive_call'];?></td>
								   <?php }else{ ?>
									   <td>0</td>
								   <?php } ?>
								   <?php if(!empty($weekly_data['total_orders'])){ ?>
									   <td><?=$weekly_data['total_orders'];?></td>
								   <?php }else{ ?>
									   <td>0</td>
								   <?php } ?>
								   <?php if(!empty($weekly_data['total_orders_not_met'])){ ?>
									   <td><?=$weekly_data['total_orders_not_met'];?></td>
								   <?php }else{ ?>
									   <td>0</td>
								   <?php } ?>
							   </tr>
						   <?php }
					   }
                       if($timeline=='quarter'){
						   $data = file_get_contents ("ReportJSON/quarterly.json");
						   $json = json_decode($data, true);
						   foreach($json as $weekly_data){	 ?>
							   <tr>
								   <td><?= $weekly_data['username'] ?></td>
								   <td><?=$weekly_data['bossname'] ?></td>
								   <td><?=$weekly_data['city_name'] ?></td>
								   <td><?=$weekly_data['designation_name'] ?></td>
								   <td><?=$weekly_data['total_doctors'] ?></td>
								   <td><?=$weekly_data['total_doc_interaction'] ?></td>
								   <td><?=$weekly_data['team_members'] ?></td>
								   <?php if(!empty($weekly_data['total_secondary'])){ ?>
									   <td><?=$weekly_data['total_secondary'];?></td>
								   <?php }else{ ?>
									   <td>0</td>
								   <?php } ?>
								   <?php if(!empty($weekly_data['total_productive_call'])){ ?>
									   <td><?=$weekly_data['total_productive_call'];?></td>
								   <?php }else{ ?>
									   <td>0</td>
								   <?php } ?>
								   <?php if(!empty($weekly_data['total_orders'])){ ?>
									   <td><?=$weekly_data['total_orders'];?></td>
								   <?php }else{ ?>
									   <td>0</td>
								   <?php } ?>
								   <?php if(!empty($weekly_data['total_orders_not_met'])){ ?>
									   <td><?=$weekly_data['total_orders_not_met'];?></td>
								   <?php }else{ ?>
									   <td>0</td>
								   <?php } ?>
							   </tr>
						   <?php }
					   }
                       if($timeline=='year'){
						   $data = file_get_contents ("ReportJSON/yearly.json");
						   $json = json_decode($data, true);
						   foreach($json as $weekly_data){	 ?>
							   <tr>
								   <td><?= $weekly_data['username'] ?></td>
								   <td><?=$weekly_data['bossname'] ?></td>
								   <td><?=$weekly_data['city_name'] ?></td>
								   <td><?=$weekly_data['designation_name'] ?></td>
								   <td><?=$weekly_data['total_doctors'] ?></td>
								   <td><?=$weekly_data['total_doc_interaction'] ?></td>
								   <td><?=$weekly_data['team_members'] ?></td>
								   <?php if(!empty($weekly_data['total_secondary'])){ ?>
									   <td><?=$weekly_data['total_secondary'];?></td>
								   <?php }else{ ?>
									   <td>0</td>
								   <?php } ?>
								   <?php if(!empty($weekly_data['total_productive_call'])){ ?>
									   <td><?=$weekly_data['total_productive_call'];?></td>
								   <?php }else{ ?>
									   <td>0</td>
								   <?php } ?>
								   <?php if(!empty($weekly_data['total_orders'])){ ?>
									   <td><?=$weekly_data['total_orders'];?></td>
								   <?php }else{ ?>
									   <td>0</td>
								   <?php } ?>
								   <?php if(!empty($weekly_data['total_orders_not_met'])){ ?>
									   <td><?=$weekly_data['total_orders_not_met'];?></td>
								   <?php }else{ ?>
									   <td>0</td>
								   <?php } ?>
							   </tr>
						   <?php }
					   }

                    }
                    else{
					/*User-wise Report*/
					$weekly=$period;

					if($weekly==''){
						$data = file_get_contents ("ReportJSON/weekly.json");
						$json = json_decode($data, true);
						foreach($json as $user){
							if($user['user_id']==$w_user_id){  ?>
								<!--For the Month-->
								<tr>
									<td><?=$user['username'] ?></td>
									<td><?=$user['bossname'] ?></td>
									<td><?=$user['city_name'] ?></td>
									<td><?=$user['designation_name'] ?></td>
									<td><?=$user['total_doctors'] ?></td>
									<td><?=$user['total_doc_interaction'] ?></td>
									<td><?=$user['team_members'] ?></td>
									<?php  if(!empty($user['total_secondary'])){ ?>
										<td><?=$user['total_secondary'];?></td>
									<?php }else{ ?>
										<td>0</td>
									<?php } ?>
									<?php if(!empty($user['total_productive_call'])){ ?>
										<td><?=$user['total_productive_call'];?></td>
									<?php }else{ ?>
										<td>0</td>
									<?php } ?>
									<?php if(!empty($user['total_orders'])){ ?>
										<td><?=$user['total_orders'];?></td>
									<?php } else{ ?>
										<td>0</td>
									<?php } ?>
									<?php if(!empty($user['total_orders_not_met'])){ ?>
										<td><?=$user['total_orders_not_met'];?></td>
									<?php } else{ ?>
										<td>0</td>
									<?php } ?>
								</tr>
								<!--./ For the Month-->
						<?php }
						  }

					}
					if($weekly=='month'){
						$data = file_get_contents ("ReportJSON/monthly.json");
						$json = json_decode($data, true);
						foreach($json as $user){
							if($user['user_id']==$w_user_id){  ?>
								<!--For the Month-->
								<tr>
									<td><?=$user['username'] ?></td>
									<td><?=$user['bossname'] ?></td>
									<td><?=$user['city_name'] ?></td>
									<td><?=$user['designation_name'] ?></td>
									<td><?=$user['total_doctors'] ?></td>
									<td><?=$user['total_doc_interaction'] ?></td>
									<td><?=$user['team_members'] ?></td>
									<?php  if(!empty($user['total_secondary'])){ ?>
										<td><?=$user['total_secondary'];?></td>
									<?php }else{ ?>
										<td>0</td>
									<?php } ?>
									<?php if(!empty($user['total_productive_call'])){ ?>
										<td><?=$user['total_productive_call'];?></td>
									<?php }else{ ?>
										<td>0</td>
									<?php } ?>
									<?php if(!empty($user['total_orders'])){ ?>
										<td><?=$user['total_orders'];?></td>
									<?php } else{ ?>
										<td>0</td>
									<?php } ?>
									<?php if(!empty($user['total_orders_not_met'])){ ?>
										<td><?=$user['total_orders_not_met'];?></td>
									<?php } else{ ?>
										<td>0</td>
									<?php } ?>
								</tr>
								<!--./ For the Month-->
							<?php }
						}

					}
					if($weekly=='quarter'){
						$data = file_get_contents ("ReportJSON/quarterly.json");
						$json = json_decode($data, true);
						foreach($json as $user){
							if($user['user_id']==$w_user_id){  ?>
								<!--For the Month-->
								<tr>
									<td><?=$user['username'] ?></td>
									<td><?=$user['bossname'] ?></td>
									<td><?=$user['city_name'] ?></td>
									<td><?=$user['designation_name'] ?></td>
									<td><?=$user['total_doctors'] ?></td>
									<td><?=$user['total_doc_interaction'] ?></td>
									<td><?=$user['team_members'] ?></td>
									<?php  if(!empty($user['total_secondary'])){ ?>
										<td><?=$user['total_secondary'];?></td>
									<?php }else{ ?>
										<td>0</td>
									<?php } ?>
									<?php if(!empty($user['total_productive_call'])){ ?>
										<td><?=$user['total_productive_call'];?></td>
									<?php }else{ ?>
										<td>0</td>
									<?php } ?>
									<?php if(!empty($user['total_orders'])){ ?>
										<td><?=$user['total_orders'];?></td>
									<?php } else{ ?>
										<td>0</td>
									<?php } ?>
									<?php if(!empty($user['total_orders_not_met'])){ ?>
										<td><?=$user['total_orders_not_met'];?></td>
									<?php } else{ ?>
										<td>0</td>
									<?php } ?>
								</tr>
								<!--./ For the Month-->
							<?php }
						}

					}
					if($weekly=='year'){
						$data = file_get_contents ("ReportJSON/yearly.json");
						$json = json_decode($data, true);
							foreach($json as $user){
								if($user['user_id']==$w_user_id){  ?>
									<!--For the Month-->
									<tr>
										<td><?=$user['username'] ?></td>
										<td><?=$user['bossname'] ?></td>
										<td><?=$user['city_name'] ?></td>
										<td><?=$user['designation_name'] ?></td>
										<td><?=$user['total_doctors'] ?></td>
										<td><?=$user['total_doc_interaction'] ?></td>
										<td><?=$user['team_members'] ?></td>
										<?php  if(!empty($user['total_secondary'])){ ?>
											<td><?=$user['total_secondary'];?></td>
										<?php }else{ ?>
											<td>0</td>
										<?php } ?>
										<?php if(!empty($user['total_productive_call'])){ ?>
											<td><?=$user['total_productive_call'];?></td>
										<?php }else{ ?>
											<td>0</td>
										<?php } ?>
										<?php if(!empty($user['total_orders'])){ ?>
											<td><?=$user['total_orders'];?></td>
										<?php } else{ ?>
											<td>0</td>
										<?php } ?>
										<?php if(!empty($user['total_orders_not_met'])){ ?>
											<td><?=$user['total_orders_not_met'];?></td>
										<?php } else{ ?>
											<td>0</td>
										<?php } ?>
									</tr>
									<!--./ For the Month-->
								<?php }
							}

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
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ],
            buttons: [
                'pageLength',
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
