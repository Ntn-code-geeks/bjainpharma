<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
          <h3 class="box-title">Add Meeting Plan</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo form_open_multipart($action);?>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Type Of Meeting* : </label>
						<select name="meeting_type" id="meeting_type"  class="form-control select2" style="width: 100%;">
							<option value="">-- Select Meeting Type --</option>
							<?php foreach($meeting_master as $meeting){ ?>
								<option value="<?=$meeting['meeting_id']?>"><?=$meeting['meeting_value']?></option>
							<?php } ?>
						</select>
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('meeting_type'); ?></span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Place Of Meeting* : </label>
						<select name="meeting_city" id="meeting_city"  class="form-control select2" style="width: 100%;">
						  <option value="">-- Select Meeting City --</option>
							<?php foreach($city_list as $city){ ?>   
								<option value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option>
							<?php }  ?>
						</select>
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('meeting_city'); ?></span>
					</div>
					
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
                    <div class="form-group">
                        <label>Date Of Meeting* </label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input class="form-control pull-right" readonly name="meeting_date" value="<?php echo set_value('meeting_date') ?>" id="meeting_date" type="text">
                        </div>
                        <span class="control-label" for="inputError" style="color: red"><?php echo form_error('meeting_date'); ?></span>
                    </div>
                </div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Remark</label>
						<textarea class="form-control" rows="3" name="remark" id="remark" placeholder="Remark ..."><?php echo set_value('remark') ?></textarea>
					</div>
				</div>

                <div class="col-md-12" style="padding: 10px 20px;">
                    <label>Stay &nbsp; : &nbsp;&nbsp;</label>
                    <br>
                    <input  type="radio" class="form-check-input stay" checked <?php echo set_checkbox('stay',0); ?> name="stay" id="stay" value="0">
                    &nbsp;Not Stay &nbsp;
                    <input type="radio" <?php echo set_checkbox('stay',1); ?> class="form-check-input ts stay" name="stay" id="stay1" value="1">
                    &nbsp;  Stay &nbsp;
                    <span class="control-label" for="inputError" style="color: red"><?php echo form_error('stay'); ?></span>
                </div>
                <div class="col-md-12" style="padding: 10px 20px;">
                    <label>Back HO &nbsp; : &nbsp;&nbsp;</label>
                    <br>
                    <input  type="radio" class="form-check-input houp"  <?php echo set_checkbox('up',0); ?> name="up" id="houp" value="0">
                    &nbsp;No &nbsp;
                    <input type="radio" <?php echo set_checkbox('up',1); ?> checked class="form-check-input ts houp"
                           name="up" id="houp1" value="1">
                    &nbsp;  Yes &nbsp;
                    <span class="control-label" for="inputError" style="color: red"><?php echo form_error('up'); ?></span>
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
<script type='text/javascript'>
  $('#meeting_date').datepicker({
      startDate: '-27d',
      endDate: '+0d' ,
      daysOfWeekDisabled: [0],   //Disable sunday
      autoclose: true
    }) ;
    $(function(){

    $('.select2').select2();
     
    });

  $('.stay').change(function() {
      if($('.stay:checked').val()==1)
      {
          $( "#houp" ).prop( "checked", true );
      }
      if($('.stay:checked').val()==0){
          $( "#houp1" ).prop( "checked", true );
      }
  });
  $('.houp').change(function() {
      if($('#stay1').is(":checked"))
      {
          $( "#houp" ).prop( "checked", true );
      }
      if($('#stay').is(":checked"))
      {
          $( "#houp1" ).prop( "checked", true );
      }

  });
   
</script>
