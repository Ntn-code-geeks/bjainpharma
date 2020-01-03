<?php

/*
Nitin Kumar
31-Oct-2019
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

          <h3 class="box-title">Add Tour Plan</h3>
          
        </div>

        <!-- /.box-header -->

        <div class="box-body">
          <?php echo form_open_multipart($action);?>
                <table id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr>
					<th>Tour Date </th>
                    <!--<th>Source City</th>-->
                    <th>City </th>
                    <!--<th>Start Time </th>-->
                    <!--<th>End Time </th>-->
                    <th>Remark </th>

                  </tr>
               </thead>
                <tbody>
                     <?php
//					 $query_date = '2019-11-04';
//					 $start_date=date('Y-m-01', strtotime($query_date));
//					 $end_date=date('Y-m-t', strtotime($query_date));

                     $start_date =date('Y-m-d',strtotime('first day of +1 month'));
					 $end_date = date('Y-m-d',strtotime('last day of +1 month'));
					 //echo $start_date.'<br>'.date('Y-m-d',strtotime('last day of +1 month')); die;
                        while (strtotime($start_date) <= strtotime($end_date)){
                         $tdate= date ("Y-m-d", strtotime($start_date));
                         $result=get_holiday_details( date('Y-m-d', strtotime($tdate)));
                            if($result) { ?>
                            <!-- for holiday -->
                               <tr>
								<td>
									   <input readonly class="form-control pull-right" name="tour_date[]" value="<?php echo date ("d-m-Y", strtotime($start_date))?>" id="tour_date" type="text">
									   <input class="form-control pull-right" name="assign_by[]"
											  value="<?=logged_user_data(); ?>" id="tour_date" type="hidden">
								   </td>
								<td>
								  <select name="dest_city[]" id="dest_city"  class="form-control select2" style="width: 100%;">
									<option value="Holiday">--Select City--</option>
								  </select>
								</td>
								<td>
								  <textarea readonly class="form-control" rows="3" name="remark[]" id="remark" placeholder="About the Plan ..."><?php echo $result->remark;?></textarea>
								  <span  style="color:red">Holiday.</span>
								</td>
							   </tr>
                            <?php } else { 
                              $resulttask=get_assign_task( date('Y-m-d', strtotime($tdate)));
                              if($resulttask){   ?>
                               <tr>
								   <td>
									   <input readonly class="form-control pull-right" name="tour_date[]" value="<?php echo date ("d-m-Y", strtotime($start_date))?>" id="tour_date" type="text">
									   <input class="form-control pull-right" name="assign_by[]" value="<?php echo $resulttask->assign_by;?>" id="tour_date" type="hidden">
								   </td>
								   <td>
									  <input readonly type="text" name="dest_city1[]" id="dest_city1" value ="<?=get_city_name($resulttask->destination)?>" class="form-control">
									  <input  type="hidden" name="dest_city[]" id="dest_city" value="<?=$resulttask->destination; ?>" class="form-control">

									</td>
								   <td>
                                  <textarea readonly class="form-control" rows="3" name="remark[]" id="remark" placeholder="About the Plan ..."><?php echo $resulttask->remark;?></textarea>
                                  <span  style="color:red">This task assign by <?php echo get_user_name($resulttask->assign_by)?> Sir.</span>
                                </td>
                               </tr>
						  <?php } else {
							$leaves=get_leaves_deatils( date('Y-m-d', strtotime($tdate)));
							if( $leaves!=''){  ?>
                              <tr>
							  <td>
							  <input readonly class="form-control pull-right" name="tour_date[]" value="<?php echo date ("d-m-Y", strtotime($start_date))?>" id="tour_date" type="text">
							  <input class="form-control pull-right" name="assign_by[]" value="<?=logged_user_data(); ?>" id="tour_date" type="hidden">
							  </td>
							  <td>
							  <select  name="dest_city[]" id="dest_city"  class="form-control select2" style="width: 100%;">
								<option value="Leave">--Select City--</option>
							  </select>
							</td>
                              <td>
                                  <textarea readonly class="form-control" rows="3" name="remark[]" id="remark"
											 placeholder="About the Plan ..."><?php echo $leaves->remark;?></textarea>
                                   <span  style="color:red;">On Leave.</span>
                                </td>
                              </tr>
							<?php } else {
								$followUp=get_followup(date('Y-m-d', strtotime($tdate)));
								if($followUp != ''){
									$foll_data=explode(';',$followUp);
									$doc_city=get_doctor_city($foll_data[1]);
									$follw_remark=$foll_data[0];
									?>
									<tr>
										<td>
											<input readonly class="form-control pull-right" name="tour_date[]" value="<?php echo date ("d-m-Y", strtotime($start_date))?>" id="tour_date" type="text">
											<input class="form-control pull-right" name="assign_by[]" value="<?=logged_user_data(); ?>" id="tour_date" type="hidden">
										</td>
										<td>
										<select  name="dest_city[]" id="dest_city"  class="form-control select2" style="width: 100%;">
										<option value="<?=$doc_city?>" ><?=get_city_name($doc_city);?></option>
										</select>
										</td>
										<td>
										<textarea readonly class="form-control" rows="3" name="remark[]" id="remark"
												  placeholder="About the Plan ..."><?php echo $follw_remark;?></textarea>
										<span  style="color:blue">Pre Planned Follow Up.</span>

										</td>

									</tr>
							<?php }else{  ?>
									<tr>
										<td>
											<input readonly class="form-control pull-right" name="tour_date[]" value="<?php echo date ("d-m-Y", strtotime($start_date))?>" id="tour_date" type="text">

											<input class="form-control pull-right" name="assign_by[]"
												   value="<?=logged_user_data();
											?>"
												   id="tour_date" type="hidden">
										</td>
										<td>
											<select <?php echo date('D',strtotime($start_date))=='Sun'?'':'';?>
												name="dest_city[]" id="dest_city"  class="form-control select2"
												style="width: 100%;">
												<?php if(date('D',strtotime($start_date))!='Sun') { ?>
													<option value="">--Select City--</option>
													<?php foreach($city_data as $city){ ?>
														<option value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option><?php }  ?>
												<?php  }else{ ?>
													<option value="">Sunday</option>
												<?php } ?>
											</select>
										</td>
										<td>
											<textarea <?php echo date('D',strtotime($start_date))=='Sun'?'readonly':'';?> class="form-control" rows="3" name="remark[]" id="remark" placeholder="About the Plan ..."><?php echo date('D',strtotime($start_date))=='Sun'?'Day is Sunday':'';?></textarea>
											<?php echo date('D',strtotime($start_date))=='Sun'?'<span  style="color:red">Sunday.</span>':'';?>

										</td>
									</tr>
							<?php	}
                            }}}?>
                  <?php $start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date))); } ?>
                </tbody>
              </table>
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
         <?php echo form_close();  ?>
  </div>
        <!-- /.box-body -->
</div>
      <!-- /.box -->
</section>
    <!-- /.content -->
</div>

<script src="<?php echo base_url();?>design/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script type='text/javascript'>
  $('#datepickerend').datepicker({
              autoclose: true
    }) ;
    $(function(){
    $('.select2').select2();
    });
</script>
