<?php
/*
 * Nitin kumar
 * date : 24-09-2019
 * show list of users DA
 */
?>
<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<?php echo get_flash(); ?>
				<div class="box">
					<div class="box-header">
						<a href="<?= base_url();?>reports/reports/add_user_da"> <h3 class="box-title"><button
									type="button" class="btn btn-block btn-success">Add User's DA</button></h3></a>
					</div>

					<!-- /.box-header -->
					<div class="box-body">
						<table id="example2" class="table table-bordered table-striped">
							<thead>
							<tr>
								<th>User Name</th>
								<th>Designation</th>
								<th>HeadQuarter</th>
								<th>Ex-HeadQuarter </th>
								<th>Out Station</th>
								<th>Transit</th>
								<th>Status </th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php


							if(!empty($users_da)){
								foreach($users_da as $da){
									$desg=get_designation_name($da['designation']);
									?>
								<tr>
									<td><?= get_user_name($da['user_id'])?></td>
									<td><?= $desg->designation_name?></td>
									<td><?= $da['hq']?></td>
									<td><?= $da['ex']?></td>
									<td><?= $da['out_st']?></td>
									<td><?= $da['transit']?></td>
									<td><?= ($da['status']==1)?'Enable':'Disable'?></td>
									<td>
										<a href="<?php echo base_url()."reports/reports/edit_user_da/".
											urisafeencode($da['user_id']);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
									</td>
								</tr>
							<?php }  } ?>
							</tbody>
						</table>
					</div>
					<!-- /.box -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
	</section>
	<!-- /.content -->
</div>

<script src="<?= base_url()?>design/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>design/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $(function () {
        $('#example2').DataTable({
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
