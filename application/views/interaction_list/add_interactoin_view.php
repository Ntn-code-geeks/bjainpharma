<?php



/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */





?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>




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

     // $('#doi').datepicker({
     //        //format:'dd-mm-yyyy',
     //         startDate: '-7d',
     //        endDate: '+0d' ,
     //        daysOfWeekDisabled: [0],   //Disable sunday
     //        autoclose:true
     //   })  ; 

  var usID=$('#user_IDD').val();

   var datearray = $('#yearly_holidays').val();

     // if(usID==150 || usID==67 || usID==121     || usID==173 || usID==195 || usID==200 || usID==175 || usID==128    || usID==127 || usID==97 || usID==171){
   // if(usID){
  if(usID==39 || usID==155 || usID==81 || usID==79 || usID==164 || usID==182 || usID==42 || usID==43 ||
		usID==169 || usID==203 || usID==46 || usID==52|| usID==193 || usID==211 || usID==80 || usID==55 || usID==44 ||
		usID==46 || usID==114 || usID==161 || usID==57|| usID==48 || usID==157 || usID==185 || usID==49 || usID==68 ||
		usID==163 || usID==165 || usID==106 || usID==77 || usID==173 || usID==103 || usID==149 || usID==206||
		usID==202||	usID==66 || usID==76 || usID==101 || usID==23){

		var dat_str=datearray.split(",");
		var poped_val= dat_str.pop();
		var new_dates=dat_str.join(',');


		if(usID==161){
 		
	 		$('#doi').datepicker({
	            startDate: '-20d',
	            endDate: '+0d',   ////future dates
	             datesDisabled: datearray,     ////Gazetted Holidays
	            daysOfWeekDisabled: [0],   //Disable sunday
	            autoclose: true
	        });
    	}else{
    		$('#doi').datepicker({
            startDate: '-8d',
            endDate: '+0d' ,   ////future dates
             datesDisabled: new_dates,     ////Gazetted Holidays
            daysOfWeekDisabled: [0],   //Disable sunday
            autoclose:true
        })  ;
    	}
		
        
    }else {
    	if(usID==88  || usID==210 || usID==208 || usID==153){    	
 		
	 		$('#doi').datepicker({
	            startDate: '-18d',
	            endDate: '+0d',   ////future dates
	             datesDisabled: datearray,     ////Gazetted Holidays
	            daysOfWeekDisabled: [0],   //Disable sunday
	            autoclose: true
	        });
    	}else{
    		 $('#doi').datepicker({
            startDate: '-8d',
            endDate: '+0d',   ////future dates
             datesDisabled: datearray,     ////Gazetted Holidays
            daysOfWeekDisabled: [0],   //Disable sunday
            autoclose: true
        });
       }
       
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





