<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

?>
<meta http-equiv="Cache-control" content="no-cache">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<div class="content-wrapper">


	<!-- Main content -->

	<section class="content">

		<?php echo get_flash(); ?>

		<!-- Contact Add -->

		<div class="box box-default">

			<div class="box-header with-border" style="text-align: center;">

				<h3 class="box-title" style="font-weight: 700;">SE Monthly Report</h3>

			</div>

			<!-- /.box-header -->

			<div class="box-body">
				<br>
				<?php echo form_open_multipart($action);?>
				<div class="row">
				<div class="col-md-6">
				<div class="form-group">
					<label>Select Date* </label>
					<div class="input-group date">
					<div class="input-group-addon">
						<i class="fa fa-calendar"></i></div>
					<input name="start_date" class="form-control pull-right" id="reservation2" type="text" value="<?php echo date('d/m/Y').' - '. date('d/m/Y'); ?>">
					</div>
					<span class="control-label" for="inputError" style="color: red"><?php echo form_error('start_date'); ?></span>
				</div>
					</div>
				<div class="col-md-6" style="margin-top: 22px !important;">

					<div class="form-group" style="">
					<label>Sales Executives List : </label>
					<select name="working_user_id" id="working_user_id"  class="form-control select3" style="width: 45%;">
					<option value="">--Select Employee--</option>
					<?php foreach($child_user_list as $k_cul=>$val_cul){ echo $val_cul['username']; ?>
					<option value="<?=$val_cul['userid']?>" ><?=$val_cul['username'];?></option>
					<?php }  ?>
					</select>
					<span class="control-label" for="inputError" style="color: red"><?php echo form_error('working_user_id'); ?></span>

						<button type="submit" class="btn btn-info pull-right" style="">Save</button>

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

<script type='text/javascript'>
    // var dateToday = new Date();

    $('#datepickerend').datepicker({
        autoclose: true
    }) ;


    $(function(){
        $('.select2').select2();
        $('.select3').select2();
    });



</script>





