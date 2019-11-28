<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

?>
<meta http-equiv="Cache-control" content="no-cache">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!--<script	src="https://code.jquery.com/ui/1.12.0/jquery-ui.js" ></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->

<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>-->






<input type="hidden" id="user_IDD" name="user_IDD" value="<?=logged_user_data() ?>" style="display: none;">
<div class="content-wrapper">



    <!-- Main content -->

    <section class="content">

    <?php echo get_flash(); ?>

      <!-- Contact Add -->

      <div class="box box-default">

        <div class="box-header with-border">

          <h3 class="box-title">Add Interaction</h3>

        </div>

        <!-- /.box-header -->

        <div class="box-body">

            <?php echo form_open_multipart($action);?>

			<div class="row">

				<div class="col-md-6">

					<div class="form-group">

						<label>Select Interaction Date* </label>

						<div class="input-group date">

						  <div class="input-group-addon">

							<i class="fa fa-calendar"></i>

						  </div>

						 <input value="<?php echo set_value('doi')?>" readonly class="form-control" name="doi" id="doi" type="text">

						</div>

						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('doi'); ?></span>

					</div>

				</div>

				<div class="col-md-6">

					<div class="form-group">

						<label>Planed City</label>

						<input class="form-control" type="text" readonly name="planedcity" value="<?php echo set_value('planedcity')?>" id="planedcity" >

					</div>

				</div>



			</div>



			<div class="row">

				<div class="col-md-6">

					<div class="form-group">

						<label>Interaction City* : </label>

						<select name="interaction_city" id="interaction_city"  class="form-control select2" style="width: 100%;">

						  <option value="">--Select City--</option>

							<?php foreach($city_list as $city){ ?>   

								<option value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option>

							<?php }  ?>

						</select>

						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('interaction_city'); ?></span>

					</div>

				</div>

                     <?php
                       if((is_admin() || logged_user_child()) && isset($child_user_list) ){  ?>
                           
                           <div class="col-md-6">

				        <div class="form-group">
                                            
						<label>Joint Working : </label>

                                                <select name="working_user_id" id="working_user_id"  class="form-control select3" style="width: 100%;">

						  <option value="">--Select Employee--</option>

							<?php foreach($child_user_list as $k_cul=>$val_cul){ echo $val_cul['username']; ?>   

								<option value="<?=$val_cul['userid']?>" ><?=$val_cul['username'];?></option>

							<?php }  ?>

						</select>

						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('working_user_id'); ?></span>

					</div>

				</div>
                           
                      <?php }
                     
                     ?>       
                            
                            
			<!--	<div class="col-md-6">

				   <div class="form-group">

					<label>Interaction With* &nbsp; : &nbsp;&nbsp;</label>

					<br>

					<input  type="radio" class="form-check-input" checked <?php echo set_checkbox('interact_with',1); ?> name="interact_with" id="interact_with" value="1">

					&nbsp; Doctor &nbsp;

					<input type="radio" <?php echo set_checkbox('interact_with',2); ?> class="form-check-input ts" name="interact_with" id="interact_with" value="2">

					&nbsp; Dealer &nbsp;

					<input type="radio" <?php echo set_checkbox('interact_with',3); ?> class="form-check-input ts" name="interact_with" id="interact_with" value="3">

					&nbsp; Sub Dealer &nbsp;

					<span class="control-label" for="inputError" style="color: red"><?php echo form_error('navigate_id'); ?></span>

				  </div>

				</div>

			</div>-->

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
	<?php
	/*Gazetted Holidays Dynamic DB*/
	$currnt_year=date('Y');
	$gazzete_list=array();
	foreach ($yearly_holidays as $yr_data){
		$gazzete_list[]="'".$yr_data->date_holiday."-".$currnt_year."'";
	}
		$date_list=implode(',',$gazzete_list);
	?>
<input type="hidden" id="yearly_holidays" value="<?=$date_list?>">
  </div>

<script src="<?php echo base_url();?>design/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script type='text/javascript'>
    // var dateToday = new Date();
    var usID=$('#user_IDD').val();

    // var datearray = ["09-14-2019","09-15-2019","09-16-2019"];    ///Dates to be disabled in calendar
    var datearray = $('#yearly_holidays').val();

    if(usID==39 || usID==155 || usID==81 || usID==79 || usID==164 || usID==182 || usID==42 || usID==43 ||
		usID==169 || usID==203 || usID==46 || usID==52|| usID==193 || usID==211 || usID==80 || usID==55 || usID==44 ||
		usID==46 || usID==114 || usID==161 || usID==57|| usID==48 || usID==157 || usID==185 || usID==49 || usID==68 ||
		usID==163 || usID==165 || usID==106 || usID==77 || usID==173 || usID==103 || usID==149 || usID==206||
		usID==202||	usID==66 || usID==76 || usID==101 || usID==31){

		var dat_str=datearray.split(",");
		var poped_val= dat_str.pop();
		var new_dates=dat_str.join(',');

        $('#doi').datepicker({
            format: 'mm/dd/yyyy',
            // startDate: '-2d',
            // endDate: '+0d' ,   ////future dates
            datesDisabled: new_dates,     ////Gazetted Holidays
            daysOfWeekDisabled: [0],   //Disable sunday
            autoclose:true,
            todayHighlight: true,
        })  ;
	}else{
        $('#doi').datepicker({
            format: 'mm/dd/yyyy',
            // startDate: '-2d',
            // endDate: '+0d' ,   ////future dates
            datesDisabled: datearray,     ////Gazetted Holidays
            daysOfWeekDisabled: [0],   //Disable sunday
            autoclose:true,
            todayHighlight: true,
        })  ;
	}






    $(function(){
    $('.select2').select2();
    $('.select3').select2();
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





