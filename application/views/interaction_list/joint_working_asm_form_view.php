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

          <h3 class="box-title">Interaction From</h3>

        </div>

        <!-- /.box-header -->

        <div class="box-body">

            <?php echo form_open_multipart($action);?>

            <input type="hidden" name="doi" value="<?=$date_interact?>">
            <input type="hidden" name="interaction_city_id" value="<?=$interaction_city?>">
            <input type="hidden" name="joint_workwith" value="<?=$joint_working?>">
            <input type="hidden" name="planned_city_id" value="<?=$planned_city?>">

			   <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>1.) WHAT IS THE PRIMARY / SECONDARY ORDER RATIO </label>

                                                   <br>ANS:
                                                   <textarea class="form-control" rows="3" name="remark[]" id="remark" placeholder="GOOD / BAD ..."></textarea>

					</div>
				</div>

			</div>
			   <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>2.) WHAT IS THE CURRENT RATION OF TARGET TO ACHIEVEMENT </label>
                                                       <br>ANS:
                                                   <textarea class="form-control" rows="3" name="remark[]" id="remark" placeholder="Action ..."></textarea>

					</div>
				</div>
               </div>
               <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>3.) WHAT IS THE DAILY CALL AVERAGE </label>
                                                       <br>ANS:
                                                   <textarea class="form-control" rows="3" name="remark[]" id="remark" placeholder="GOOD/BAD  ..."></textarea>

					</div>
				</div>
             </div>
               <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>4.)HOW MANY DOCTORS VISITED MORE THAN 3 TIMES BUT NO ORDER </label> <br>ANS:
                       <textarea class="form-control" rows="3" name="remark[]" id="remark" placeholder="Action ..."></textarea>

					</div>
				</div>
               </div>
               <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>5.) SECONDARY PAYMENT OVERDUE IN MARKET</label> <br>ANS:
                    <textarea class="form-control" rows="3" name="remark[]" id="remark" placeholder="Action ..."></textarea>
					</div>
				</div>
                </div>

            <div class="form-group">
                <label>Stay &nbsp; : &nbsp;&nbsp;</label>
                <br>
                <input  type="radio" class="form-check-input stay"  <?php echo set_checkbox('stay',0); ?> name="stay" id="stay" value="0">
                &nbsp;Not Stay &nbsp;
                <input type="radio" <?php echo set_checkbox('stay',1); ?> class="form-check-input ts stay" name="stay" id="stay1" value="1">
                &nbsp;  Stay &nbsp;
                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('stay'); ?></span>
            </div>

            <div class="form-group">
                <label>Back HQ &nbsp; : &nbsp;&nbsp;</label>
                <br>
                <input  type="radio" class="form-check-input houp"  <?php echo set_checkbox('up',0); ?> name="up" id="houp" value="0">
                &nbsp;No &nbsp;
                <input type="radio" <?php echo set_checkbox('up',1); ?>  class="form-check-input ts houp" name="up" id="houp1" value="1">
                &nbsp;  Yes &nbsp;
                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('up'); ?></span>
            </div>

		</div>
		<div class="row">

            <div class="col-md-12">


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
     $('#doi').datepicker({
            //format:'dd-mm-yyyy',
            startDate: '-7d',
            endDate: '+0d' ,
            autoclose:true
       })  ; 

    $(function(){
    $('.select2').select2();
    $('.select3').select2();
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

	

   $("#doi").change(function(){
		var doi=$('#doi').val();
		$.ajax({
		   type:"POST",
		   url:"<?= base_url();?>tour_plan/tour_plan/get_tour_destination",
		   data : 'doi='+doi,

		   success:function(res){
				if(res){
					$('#planedcity').val(res);
				}
			}
		});
	});

</script>