<?php
/*
New Module Developed by:
* NITIN KUMAR
* Created On: 11-September-2019
 */
$doc_secondary_list = json_decode(file_get_contents ("ReportJSON/doc_secondary_supply.json"),true);
$pharma_secondary_list = json_decode(file_get_contents ("ReportJSON/phar_secondary_supply.json"),true);
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
	@media
	only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px)  {
		td {	padding-left: 60% !important;		}
		/*		Label the data		*/
		td:nth-of-type(1):before { content: "Date"; }
		td:nth-of-type(2):before { content: "Doctor/Sub Dealer Name"; }
		td:nth-of-type(3):before { content: "City"; }
		td:nth-of-type(4):before { content: " Supply by Dealer/pharmacy"; }
		td:nth-of-type(5):before { content: "Secondary Sale "; }

	}
</style>

<div class="content-wrapper">

	<!-- Main content -->

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<?php echo get_flash(); ?>
				<div class="box">
					<!-- /.box-header -->
					<div class="box-body">
						<input type="hidden" id="uname" value="<?=get_user_name($userID); ?>">
						<input type="hidden" id="duratn" value="Report of: <?=date("F jS, Y", strtotime($month_date[0])); ?> - <?=date("F jS, Y",strtotime($month_date[30])); ?>">

						<div class="table-responsive">
							<table id="example2" class="table table-bordered table-striped">
								<thead>
								<tr style="text-align: center; font-size: 20px;">
									<td colspan="5"><?=get_user_name($userID); ?></td>
								</tr>
								<tr style="text-align: center;">
									<td colspan="5" style="font-weight: 700;">Report of: <?=date("F jS, Y", strtotime($month_date[0])); ?> - <?=date("F jS, Y",strtotime($month_date[30])); ?></td>
								</tr>


								<tr>
									<th>Date</th>
									<th>Doctor/Sub Dealer Name</th>
									<th>City</th>
									<th>Supply by Dealer/pharmacy</th>
									<th>Interaction Secondary</th>
								</tr>
								</thead>
								<tbody>
								<?php
								if(!empty($doc_secondary_list)){

								foreach($doc_secondary_list as $k_c=>$val_c){
								if($val_c['user_id']==$userID){
									if(in_array($val_c['date_of_interaction'],$month_date)){
										if($val_c['secondarysale']!=''){
											?>
											<tr>
												<td><?=date('Y/m/d', strtotime($val_c['date_of_interaction']));?></td>
												<td><?=$val_c['doctorname'];?></td>
												<td><?= get_city_name($val_c['city_id']);?> </td>
												<td><?=$val_c['dealer_name'];?></td>
												<td><?=$val_c['secondarysale'];?></td>
											</tr>
										<?php  }
									}
									}
								}
								}?>
								<?php // for pharma interaction list
								if(!empty($pharma_secondary_list)){
									foreach($pharma_secondary_list as $k_c=>$val_c) {
//										pr($val_c); die;
										if ($val_c['user_id'] == $userID) {
											if (in_array($val_c['date_of_interaction'], $month_date)) {
												if ($val_c['secondarysale'] != '') {
													?>
													<tr>
														<td><?= date('Y/m/d', strtotime($val_c['date_of_interaction'])); ?></td>
														<td><?= $val_c['pharmaname']; ?></td>
														<td><?= get_doctor_name($val_c['city_id']); ?></td>
														<td><?= $val_c['dealer_name']; ?></td>
														<td><?= $val_c['secondarysale']; ?></td>
													</tr>
												<?php }
											}
										}
									}
								}?>

								</tbody>
							</table>

							<p><?php /* echo $links; */ ?></p>
						</div>
						<!-- /.box-body -->
					</div></div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>

<script>
var urs_name=$('#uname').val();
var duration=$('#duratn').val();
var mytitle = urs_name + '<br>' + duration;

    $(function () {
        $('#example2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    title: function() {
                        return "<div style='font-size: 14px; text-align: center;'>"+mytitle+"</div>";
                    }
                },
            ],
            'responsive' : true,
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
        })

    })
</script>

