<?php
/*
* Niraj Kumar
* Dated: 30-oct-2017
*
* Show Report Details
*
*/

//  $user_list = json_decode($users);
 

 // $pharmacy_list =json_decode($pharma_list);
//pr($dealer_list); die;

?>
<!--<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<div class="content-wrapper">
  
  <!-- Main content -->
  <section class="content">
    <?php echo get_flash(); ?>
    
    
          <div class="box box-success">
            <!--<div class="box box-primary">-->
            
            <div class="box-header">
              <h3 class="box-title">Genrate TA DA Report</h3>
            </div>
            <?php
            echo form_open($action);
            ?>
            <div class="box-body">
              <div class="row">
               <div class="col-md-6">
              <!-- Date range -->
             <div class="form-group">

						<label>Select Month </label>

						<div class="input-group date">

						  <div class="input-group-addon">

							<i class="fa fa-calendar"></i>

						  </div>

						 <input value="<?php echo set_value('report_date')?>" readonly class="form-control" name="report_date" id="doi" type="text">

						</div>

						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('report_date'); ?></span>

					</div>
              <!-- /.form group -->
              <!-- Date and time range -->
<!--               <div class="form-group">
                <label>Users *:</label>
                <div class="input-group">
                <select name="user_id" id="user_id"  class="form-control select3" style="width: 100%;">
                  <option value="">--Please Choose User--</option>
                   <option value="0">ALL User</option> 
                  <?php
//                          if($user_id==''){
//                  foreach($user_list as $k => $val){
                  ?>
                  <option value="<?=$val->userid ?>" <?php if(isset($_POST['user_id'])){echo set_select('user_id',  $val->userid);} ?>  ><?=$val->username;?></option>
                  <?php // } }?>
                  
                </select>
                <span class="control-label" for="inputError" style="color: red"><?php echo form_error('user_id'); ?></span>
                 /.input group 
              </div>-->
              <!-- Date and time range -->
              <div class="form-group">
                <!--                <label></label>-->
                <div class="input-group">
                  <button type="submit" class="btn btn-default pull-right">
                  Submit
                  </button>
                </div>
              </div>
              <!-- /.form group -->
            </div>
            <!-- /.box-body -->
            <?php echo form_close(); ?>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col (left) -->
      </div>
      
    <!--            </div>
    /.box
  </div>
  /.col
</div>-->
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<script src="<?php echo base_url();?>design/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>


<script type="text/javascript">
    $('#doi').datepicker({
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months",
            autoclose:true

       })  ; 
    
$(function(){

  $('.select3').select2();

  $('.select4').select2({selectOnClose: true}).on("select2:select", function(e) {
    var dealerId= $(this).val();
    if(dealerId)
    {
      $('.select5').prop('disabled', true);
    }
    else
    {
      $('.select5').prop('disabled', false);
    }
  });
  $('.select5').select2({selectOnClose: true}).on("select2:select", function(e) {
      var pharmaId= $(this).val();
      if(pharmaId)
      {
        $('.select4').prop('disabled', true);
      }
      else
      {
        $('.select4').prop('disabled', false);
      }
    
  });
});
</script>

