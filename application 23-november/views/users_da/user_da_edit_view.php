<?php
/*
 * Nitin kumar
 * date : 24-09-2019
 * show list of users DA
 */
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<?php echo get_flash(); ?>
		<!-- Contact Add -->
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Edit User's DA</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<?php echo form_open_multipart($action);?>

				<?php
				$dg_name=get_designation_name($user_da->designation);
				$desg_name=$dg_name->designation_name;
				?>
				<div class="row" style="padding: 15px !important; margin-right: 0px !important;  margin-left: 0px
				!important;">
					<div class="col-md-6">
						<div class="form-group">
							<label>User's Name : </label>
							<input class="form-control pull-right" type="text" readonly name="user_name" value="<?=
							get_user_name($user_da->user_id);?>">
							<input type="hidden" name="user_id" id="user_id" value="<?=$user_da->user_id ?>">
							<span class="control-label" for="inputError" style="color: red"><?php echo form_error('parent_category'); ?></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>User's Designation :</label>
							<input class="form-control pull-right" name="desg_name" readonly value="<?= $desg_name?>"
							id="desg_name" type="text">
							<input type="hidden" name="user_desg" id="user_desg" value="<?=$user_da->designation ?>">
							<span class="control-label" for="inputError" style="color: red"></span>
						</div>
					</div>
				</div>

				<div class="row" style="padding: 15px !important; margin-right: 0px !important;  margin-left: 0px !important;">
					<div class="col-md-3">
						<div class="form-group">
							<label>HeadQuarter : &nbsp;&nbsp;</label>
							<input class="form-control pull-right" name="hq_rates" value="<?= $user_da->hq;?>"
								   id="hq_rates" type="text">
							<span class="control-label" for="inputError" style="color: red"></span>&nbsp;
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label>Ex-HeadQuarter : &nbsp;&nbsp;</label>
							<input class="form-control pull-right" name="ex_hq_rates" value="<?= $user_da->ex;?>"
								   id="ex_hq_rates"	type="text">
							<span class="control-label" for="inputError" style="color: red"></span>&nbsp;
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label>Out Station : &nbsp;&nbsp;</label>
							<input class="form-control pull-right" name="out_st_rates" value="<?=$user_da->out_st; ?>"
								   id="out_st_rates" type="text">
							<span class="control-label" for="inputError" style="color: red"></span>&nbsp;
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label>Transit : &nbsp;&nbsp;</label>
							<input class="form-control pull-right" name="trans_rate" value="<?=$user_da->transit; ?>"
								   id="trans_rate"	type="text">
							<span class="control-label" for="inputError" style="color: red"></span>&nbsp;
						</div>
					</div>


				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<!--<div class="form-group">-->
					<div class="box-footer">
						<button type="submit" class="btn btn-info pull-right">Save</button>
					</div>
				</div>
			</div>
			<!-- /.row -->
			<?php
			echo form_close();
			?>
		</div>
		<!-- /.box-body -->
</div>
<!-- /.box -->
</section>
<!-- /.content -->
</div>
<script src="<?php echo base_url();?>design/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
