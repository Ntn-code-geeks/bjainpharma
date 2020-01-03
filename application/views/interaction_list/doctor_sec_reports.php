<?php
/*
New Module Developed by:
* NITIN KUMAR
* Created On: 10-October-2019
 */

$secondary_sum=0;

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
	@page { margin-top: 0px;  margin-bottom: 0px;   margin-left: 20px;  }
	@media
	only screen and (max-width: 789px),
	(min-device-width: 768px) and (max-device-width: 1024px)  {
		td {	padding-left: 40% !important;		}
		/*		Label the data		*/
		td:nth-of-type(1):before { content: "Date"; }
		td:nth-of-type(2):before { content: "Doctor/Sub Dealer Name"; }
		td:nth-of-type(3):before { content: "City"; }
		td:nth-of-type(4):before { content: "Supply by Dealer/pharmacy"; }
		td:nth-of-type(5):before { content: "Secondary Sale "; }
		td:nth-of-type(6):before { content: "Grand Total  "; }
	}
	@media print {
		html, body {
			border: 1px solid white;
			height: 99%;
			page-break-after: avoid;
			page-break-before: avoid;
		}
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
				<input type="hidden" id="uname" value="<?=$doc_name; ?>">
				<input type="hidden" id="duratn" value="Report of: <?=date("F jS, Y", strtotime
				($month_date[0])); ?> - <?=date("F jS, Y",strtotime(end($month_date))); ?>">

				<div class="table-responsive">
					<table id="example2" class="table table-bordered table-striped">
						<thead>
						<tr style="text-align: center; font-size: 20px;">
							<td colspan="5"><?=$doc_name?></td>
						</tr>
						<tr style="text-align: center;">
							<td colspan="5" style="font-weight: 700;">Report of: <?=date("F jS, Y", strtotime
								($month_date[0])); ?> - <?=date("F jS, Y",strtotime(end($month_date))); ?>
							</td>
						</tr>

						<?php
						$total_data=count_overall_visits($month_date,$doc_id);
						?>

						<tr style="text-align: center;">
						<td colspan="5" style="font-weight: 700;">
						<span style="">Total Interactions: <?=$total_data['total_interct']; ?></span>
						</td>
						</tr>

						<tr style="text-align: center;">
						<td colspan="5" style="font-weight: 700;">
						<span style="">Total Orders: <?=$total_data['total_orders']; ?></span>
						</td>
						</tr>

						<tr style="text-align: center;">
						<td colspan="5" style="font-weight: 700;">
						<span style="">Total Visits: <?=$total_data['total_visits']; ?></span>
						</td>
						</tr>


						<tr><td><br></td></tr>
						<tr>
							<th>Date</th>
							<th>Secondary Received</th>
							<th>Secondary Supplied</th>
<!--							<th>Total visits</th>-->
<!--							<th>Total Interaction</th>-->
<!--							<th>Total Orders</th>-->
						</tr>
						</thead>
						<tbody>
						<?php
						if(!empty($doc_secondary_list)){
							//pr($doc_secondary_list); die;
							foreach($doc_secondary_list as $k_c=>$vac){
								foreach($vac as $val_c) {
									if ($val_c['doc_id'] == $doc_id) {
										if (in_array($val_c['date'], $month_date)) {
	//													if ($val_c['secondary_sale'] != '') {
										?>
										<tr>
											<td><?= date('Y/m/d', strtotime($val_c['date'])); ?></td>
											<td><?= $val_c['user']; ?></td>
											<td><?= $val_c['secondary_sale']; ?></td>
<!--											<td>--><?//= count_overall_visits($month_date,$doc_id); ?><!-- </td>-->
<!--											<td>--><?//= "total interactions"; ?><!--</td>-->
<!--											<td>--><?//= "total orders"; ?><!--</td>-->
											<?php $secondary_sum = $secondary_sum + $val_c['secondary_sale'] ?>
										</tr>
									<?php // }
										}
									}
								}
							}
						}?>
						</tbody>
						<?php if($secondary_sum!=0){ ?>
							<tfooter><tr>
									<td rowspan="2" colspan="2" style=""><strong>Grand Total</strong></td>
									<td rowspan="" colspan="" style=""><strong><?=number_format($secondary_sum,2);?></strong>
									</td>
								</tr></tfooter>
						<?php }?>
					</table>

					<p><?php /* echo $links; */ ?></p>
				</div>
				<a href="<?=base_url() ?>interaction/doctor_report"><button class="btn btn-danger"> Back</button></a>
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
    var printTitle = "<div id='titl' style='font-size: 14px; text-align: center;'>"+mytitle+"</div>";
    $(function () {
        $('#example2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    title: printTitle,
                    customize: function(win) {
                        $(win.document.body)
                            .css('font-size', '10pt');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },


                },
            ],
            'responsive' : true,
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
        })

    })
</script>

