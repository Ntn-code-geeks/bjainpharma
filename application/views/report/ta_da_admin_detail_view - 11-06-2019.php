<?php

/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */


$designation_id = get_user_deatils(logged_user_data())->user_designation_id;
$tada_data = json_decode($tada_report);
//pr($admin_total_amount); die;
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>





<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

    <?php echo get_flash(); ?>

      <!-- Contact Add -->
      <div class="box box-default">

        <div class="box-header with-border">

          <h3 class="box-title"> TA/DA Report</h3>
          
        </div>

        <!-- /.box-header -->
        <div class="box-body">
          <?php 
         
          echo form_open_multipart($action);
          
          ?>
                <table id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr>

                    <th>Interaction DATE </th>
                    <th>FROM City</th>
                    <th>CITY WORKED </th>
                    <!--<th>TO </th>-->
                    <th>KMS </th>
                    <th>T.A.</th>
                    <th>D.A.</th>

                    <th>POSTAGE</th>
                     <!--<th>Internet Charge</th>-->

                    <th>TOTAL Amount</th>

                     <th>Any other Charge Name</th>
                    <th>Any other Charge Amount</th>


                    <th>Manager Total Amount </th>
                   <th>Admin Total Amount </th>

                  </tr>
               </thead>
                <tbody>
                  <?php 
                  
                  $gtrow=0; $gtta=0; $gtda=0; $gtpostage=0;
                  foreach ($tada_data as $k_tada=>$val_tada){   

//              $totalrow=$val_tada->ta+$val_tada->da+$val_tada->postage;

                $gtrow = $gtrow+$val_tada->total_amount;
                $gtta = $gtta+$val_tada->ta;
                $gtda = $gtda+$val_tada->da;
                $gtpostage = $gtpostage+$val_tada->postage;
//                  if(isset($approved) && $approved==='approved_tada'){
//                      if($val_tada->manager_remark!=0){
//                          $manager_total = $gtrow+$val_tada->manager_remark;
//                      }else{
//                          $manager_total = $gtrow+$val_tada->total_amount;
//                      }
//                      
//                  }
//                $crtddate=$val['created_date'];
                  ?>
                            <tr>
                                <td>
                                      <p class="form-control" > <?php echo date('d-m-Y',$val_tada->ineraction_date);?> </p>
                                      <input type="hidden" name="tada_detail_id[]" value="<?php echo $val_tada->tada_detail_id;?>">
                                </td>
                                <td>
                                  <p class="form-control" > <?php echo $val_tada->from_city;?> </p>
                                  <!--<input type="hidden" name="source_city[]" value="<?php echo get_city_name($val['source_city']);?>">-->
                                </td>
                                <td>
                                  <p class="form-control" > <?php echo $val_tada->city_worked;?> </p>
                                   <!--<input type="hidden" name="destination_city[]" value="<?php echo get_city_name($val['destination_city']);?>">-->
                                </td>
                               

                                 <td>
                                  <p class="form-control" > <?php echo $val_tada->distance;?> </p>
                                  <!--<input type="hidden" name="distance[]" value="<?=$val['distance']; ?>">-->

                                 </td>
                                 <td>
                                  <p class="form-control" > <?php echo $val_tada->ta;?> </p>
                                  <!--<input type="hidden" name="ta[]" value="<?=$val['ta']; ?>">-->
                                 </td>
                                 <td>
                                  <p class="form-control" > <?php echo $val_tada->da;?> </p>
                                   <!--<input type="hidden" name="da[]" value="<?=$da; ?>">-->
                                 </td>
                                 
                                 <td>
                                  <p class="form-control" > <?=$val_tada->postage; ?> </p>
                                  <!--<input type="hidden" name="internet_charge[]" value=" <?=$val['internet_charge']; ?>">-->
                                 </td>
                                 
                                 <td>
                                  <p class="form-control" > <?=$val_tada->total_amount; ?> </p>
                                    <!--<input type="hidden" name="totalrow[]" value=" <?=$totalrow; ?>">-->
                                 </td>
                                 
                                 <td>
                                  <p class="form-control" > <?=$val_tada->aoc_name; ?> </p>
                                 </td>
                                 
                                 <td>
                                  <p class="form-control" > <?=$val_tada->aoc_amount; ?> </p>
                                 </td>
                                 
                                 
                                 <td>
                                  <!--<p class="form-control" > <?=$val_tada->total_amount; ?> </p>-->
                                         <p class="form-control" > <?=$val_tada->manager_remark; ?> </p>
                                   
                                 
                                 </td>
                                 
                                 <td>
                                  <!--<p class="form-control" > <?=$val_tada->total_amount; ?> </p>-->
                                     <?php if(isset($admin_total_amount) && !empty($admin_total_amount)){ ?>
                                         <p class="form-control" > <?=$val_tada->admin_remark; ?> </p>
                                   <?php  }else{ ?>
                                     <input type="number" name="admin_remark[]" value="">
                                     <?php } ?>
                                 
                                 </td>
                                 
                                
                               
                              </tr>
                              
                  <?php 
                  
          } ?>
                              <tr>
                                  <td colspan="4"><strong>GRANT TOTAL</strong></td>
                                  <td><strong><?=$gtta?></strong></td>
                                  <td><strong><?=$gtda?></strong></td>
                                  <td><strong><?=$gtpostage?></strong></td>
                                  <td colspan="3"><strong><?=$gtrow?></strong>
                                      <!--<input type="hidden" name="report_date" value=" <?=$report_date?>">-->
                                      <input type="hidden" name="user" value=" <?= logged_user_data()?>">
                                      <input type="hidden" name="grant_total" value=" <?=$gtrow; ?>">
                                  </td>
                                  <td> <?php if(isset($manager_total_amount) && !empty($manager_total_amount)){ ?>
                                             <strong><?=$manager_total_amount; ?> </strong>
                                            <?php  }else{ ?>
                                      <input type="number" name="manager_grant_total" value="" required="">
                                            <?php } ?>
                                  </td>
                                   <td> <?php if(isset($admin_total_amount) && !empty($admin_total_amount)){ ?>
                                             <strong><?=$admin_total_amount; ?> </strong>
                                            <?php  }else{ ?>
                                      <input type="number" name="admin_grant_total" value="" required="">
                                            <?php } ?>
                                  </td>
                                  
                              </tr>
                              
                              
                </tbody>
              </table>
       	  </div>
      		<div class="row">
              <div class="col-md-12">
                  <!--<div class="form-group">-->
                  <div class="box-footer">
                      <?php  if(!isset($admin_total_amount)){ ?>
      	           <button type="submit" class="btn btn-info pull-right">Save</button>
                      <?php } ?>
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