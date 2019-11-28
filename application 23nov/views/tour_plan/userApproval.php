<?php
 // pr($cities);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!--<script src="--><?php //echo base_url();?><!--design/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>-->
<div class="content-wrapper">
<div id="myDiv"></div>
    <!-- Main content -->
    <section class="content">
    <?php echo get_flash(); ?>
      <!-- Contact Add -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Tour Approval Details</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo form_open_multipart($action);?>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Tour Date </label>
						<div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						 <input value="<?= $userdata[0]['dot'];?>" readonly class="form-control" name="doi" id="doi" type="text">
						</div>

					</div>

				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Interaction City* : </label>
						<select name="dest_city" id="dest_city"  class="form-control select2" style="width: 100%;">
                        <option value="<?=$userdata[0]['destination'] ?>"><?=get_city_name
                            ($userdata[0]['destination']) ?> </option>
                        <?php  foreach($cities as $city){ $cityData=explode(',',$city);
                          ?>   
                        <option value="<?=$cityData[0]?>" > <?=$cityData[1].' ('.$cityData[2].')'?>
                        	 </option>
                        <?php }  ?>
                      </select>
					</div>
				</div>


			</div>

			<div class="row">
			<div class="col-md-6">
					<div class="form-group">
						<label>Remarks</label>
						<textarea class="form-control" rows="3" name="remarks" id="remarks"><?=$userdata[0]['remark'] ?></textarea>
					</div>
				</div>
		    </div>
		<input type="hidden" name="id" id="id" value="<?=$userdata[0]['id'] ?>">

		<div class="row">
            <div class="col-md-12">
                <div class="box-footer">
					<button type="submit" id="submit" class="btn btn-success pull-right">Approve</button>
                </div>
            </div>
        </div>


        </div>
          <?php  echo form_close();  ?>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
</div>



<script type='text/javascript'>
    $(function(){
        $('.select2').select2();
        $('.select3').select2();
    });

</script>