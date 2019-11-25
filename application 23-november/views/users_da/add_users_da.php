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
				<h3 class="box-title">Add User's DA</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<?php echo form_open_multipart($action);?>
				<div class="row" style="padding: 15px !important; margin-right: 0px !important;  margin-left: 0px
				!important;">
					<div class="col-md-6">
						<div class="form-group">
							<label>User Name* : </label>
							<select name="user_name" id="user_name" class="form-control select2" style="width:
							100%;">
								<option value="">--Select User--</option>
								<?php foreach($users as $usr){ ?>
									<option value="<?=$usr['id']?>" ><?=$usr['name'] ?></option>
								<?php }  ?>
							</select>
							<span class="control-label" for="inputError" style="color: red"><?php echo form_error('interaction_city'); ?></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>User's Designation :</label>
							<input class="form-control pull-right" name="desg_name" readonly value=""								   id="desg_name" type="text">
							<input type="hidden" name="user_desg" id="user_desg" value="">
							<span class="control-label" for="inputError" style="color: red"></span>
						</div>
					</div>
				</div>

				<div class="row" style="padding: 15px !important; margin-right: 0px !important;  margin-left: 0px !important;">
					<div class="col-md-3">
						<div class="form-group">
							<label>HeadQuarter : &nbsp;&nbsp;</label>
							<input class="form-control pull-right" name="hq_rates" value=""
								   id="hq_rates" type="text">
							<span class="control-label" for="inputError" style="color: red"></span>&nbsp;
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label>Ex-HeadQuarter : &nbsp;&nbsp;</label>
							<input class="form-control pull-right" name="ex_hq_rates" value=""
								   id="ex_hq_rates"	type="text">
							<span class="control-label" for="inputError" style="color: red"></span>&nbsp;
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label>Out Station : &nbsp;&nbsp;</label>
							<input class="form-control pull-right" name="out_st_rates" value=""
								   id="out_st_rates" type="text">
							<span class="control-label" for="inputError" style="color: red"></span>&nbsp;
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label>Transit : &nbsp;&nbsp;</label>
							<input class="form-control pull-right" name="trans_rate" value=""
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
<script>
    $(function(){
        $('.select2').select2();
        $('.select3').select2();
    });

    $('.select2').on('change', function() {
        var userID= this.value;
        $.ajax({
            type:"POST",
            url:"<?= base_url();?>reports/reports/get_designation_name",
            data : 'desg_id='+userID,
            success:function(res){
                if(res){
                    var str = res.split("-");
                    $('#desg_name').val(str[0]);
                    $('#user_desg').val(str[1]);
                }
            }
        });

    });

</script>
