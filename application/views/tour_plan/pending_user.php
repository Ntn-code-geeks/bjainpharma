<?php

$city_data=get_all_city();

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

    <?php echo get_flash(); ?>

      <!-- Contact Add -->
      <div class="box box-default">

        <div class="box-header with-border">

          <h3 class="box-title">View Tour Plan</h3>
          
        </div>

        <!-- /.box-header -->

        <div class="box-body">
          <?php //echo form_open_multipart();?>
                <table id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>City </th>
                    <th>Tour Date </th>
                    <th>Remark </th>
                    <th>Action </th>
                  </tr>
               </thead>
                <tbody>
                  <?php
                    foreach($pendingUser as $val){
                    
                  ?>
                            <tr>
                                <td>
                                  <input readonly name="dest_city" id="dest_city"  class="form-control"
                                          value="<?=get_city_name($val['destination']) ?>">
                                  </select>
                                </td>
                                <td>
                                   <input readonly class="form-control pull-right" name="" value="<?= $val['dot'] ?>" id="tour_date" type="text">    
                                </td>
                                 <td>
                                  <textarea readonly class="form-control" rows="2" name="remark[]" id="remark"
                                            placeholder="About the Plan ..."><?=$val['remark'];?></textarea>
                                </td>
                                <td>
                               <a href="<?=base_url(). "tour_plan/tour_plan/setapproval/".urisafeencode($val['id']); ?> ">
                               <button type="submit" class="btn btn-info pull-right form-control">Approve
                               </button></a>
                                </td>
                          </tr>
<?php }  ?>

                </tbody>
              </table>
          </div>
          <div class="row">
             
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
    // $(function(){
    // $('.select2').select2();
    // });
</script>