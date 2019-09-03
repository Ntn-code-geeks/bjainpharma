<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

$edit_doctor=json_decode($edit_doctor_list);
$dealer_data = json_decode($dealer_list);   // for all active dealers 
$ms = json_decode($meeting_sample);
$team_list=json_decode($users_team);

?>
<meta http-equiv="Cache-control" content="no-cache">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
    <?php echo get_flash(); ?>
      <!-- Contact Add -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Add Interaction</h3>
                 <br>
          <span style="color: red;font-size: 20px">*</span> are required Fields.
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo form_open_multipart($action);
            if(!empty($order_amount)){  ?>
			<input type="hidden" name="dealer_id" id="dealer_id" value="<?=$order_amount->provider; ?>"
				   style="display: none;">
			<input type="hidden" name="dealer_mail" id="dealer_mail" value="<?=$order_amount->mail_provider ?>" style="display: none;">
			<?php } ?>
			<div class="row">
				<div class="col-md-12">
				 <div class="form-group" >
					<input type="hidden" name="path_info" <?php if($old_data!=''){?>  value="<?=$old_data->path_info;?>"<?php }else{?> value="<?=$path_info;?>"<?php }?>>	
					<input type="hidden" name="city"  <?php if($old_data!=''){?> value="<?=$old_data->city_code;?>"<?php }else{?> value="<?=$city;?>"<?php }?> >
                 <label>Doctor name</label>
                 <input class="form-control" name="doc_name" placeholder="Dealer Name..." type="text" value="<?=$edit_doctor->d_name;?>" readonly="">               
                 <input class="dealer_view_id"  name="dealer_view_id" type="hidden" value="<?=$edit_doctor->doctor_id;?>"> 
                 <input class="gd_id"  name="doc_id" type="hidden" value="<?=$edit_doctor->doctor_id;?>">                  
            <!--<span class="control-label" for="inputError" style="color: red"></span>-->
                 </div>

                 <div class="form-group" id="jw_<?=$edit_doctor->doctor_id ?>" style="display: block">
                     <label>Joint Working</label>
                     <select name="team_member[]" multiple="multiple" class="form-control select2" style="width: 100%;">
                          <!--<option value="">---Sample Name---</option>-->
                <?php foreach($team_list as $k_tl => $val_tl){ ?>   
                  <option value="<?=$val_tl->userid?>"  <?php if($old_data!=''){ $jointarr=explode(',',$old_data->joint_working); echo in_array($val_tl->userid,$jointarr)?'selected':''; }  ?><?php if(isset($_POST['team_member'])){echo set_select('team_member',  $val_tl->userid);} ?>><?=$val_tl->username;?></option>
                  <?php }  ?>
              <!--<option value="none" id="none" >NONE</option>-->
                </select>
                 </div>

          <?php if($date_interact==''){?>
                     <div class="form-group" >

                          <label>Date of Interaction<span style="color: red;font-size: 20px">*</span></label>

              <input required class="form-control" value="<?php if($old_data!=''){ echo $old_data->interaction_date;}?>" name="doi_doc" id="datepicker_doi<?=$edit_doctor->doctor_id ?>" type="text">

                      </div>

          <?php }else{?>
              <input class="form-control" name="doi_doc" value="<?php echo date('d-m-Y',strtotime($date_interact));?>" id="datepicker_doi<?=$edit_doctor->doctor_id ?>" type="hidden">
          <?php }?>
       <!--</div>
                  <div class="col-md-6">-->
                  <div class="form-group" >
                      <!--<label>Meeting Types *</label>-->
                <table class="table table-bordered" style="background: #00c0ef;">
                <tbody><tr>
                  <th>Meeting</th>
                  <th>Value</th>
                </tr>


                <tr>
                  <td>Interaction Type<span style="color: red;font-size: 20px">*</span></td>
                  <td><div class="radio">
                    <label id="meet<?=$edit_doctor->doctor_id ?>" style="display: block">
                      <input name="meet_or_not" id="optionsRadios1" value="1" type="radio">
                      Only Discussion
                    </label>

                    <label id="notmmeet<?=$edit_doctor->doctor_id ?>" style="display: block">
                      <input name="meet_or_not" id="not_meet<?=$edit_doctor->doctor_id ?>" value="0" type="radio">    Not Met
                    </label>


				  <label id="meet_sec_pob<?=$edit_doctor->doctor_id ?>" style="display: block">
					  <input name="telephonic" id="rec_per<?=$edit_doctor->doctor_id ?>" value="0" <?php if
					  ($order_amount!='' && $old_data->telephonic=='0'){ echo 'checked'; }?> type="radio">
					  Order Received POB-In Person
				  </label>

				 <div style="display: inline-flex;">
				  <label id="meet_sec_tele<?=$edit_doctor->doctor_id ?>" style="display: block">
					  <input name="telephonic" id="rec_pob<?=$edit_doctor->doctor_id ?>" value="1" <?php if
					  ($order_amount!='' && $old_data->telephonic=='1'){ echo 'checked'; }?> type="radio">
					  Order Received POB-Telephonic
				  </label>

				<?php if($order_amount!=''){ ?>
					<td style="padding: 40px; width: 20%;"> Secondary Sales:
						<input class="form-control" readonly id="sale_dealer<?=$edit_doctor->doctor_id;?>"
							   name="m_sale" value='<?=$order_amount->order_amount?>' type="text" > </td>
					<?php }else{ ?>
					<td style="padding: 40px; width: 20%;">
						<button type="submit" value="secondary_product" id="save_sample" name="save" class="btn
						btn-info" style="display: none;">Add Secondary Product</button> </td>
					<?php }?>
					</div>
					</div>
					</tr>
					<!--Secondary Sales Row here Previously-->
					<tr>
						<td>Sample</td>
						<td id="sample<?=$edit_doctor->doctor_id ?>" style="display: block"><select name="m_sample[]" multiple="multiple" class="form-control select2" style="width: 100%;">
						<option value="">---Sample Name---</option>
						<?php
						foreach($ms as $k_ms => $val_ms){     ?>
							<option value="<?=$val_ms->id?>" <?php if($old_data!=''){ $jointarr=explode(',',$old_data->sample); echo in_array($val_ms->id,$jointarr)?'selected':''; }  ?> <?php if(isset($_POST['m_sample'])){echo set_select('m_sample',  $val_ms->id);} ?>><?=$val_ms->sample_name;?></option>
						<?php }  ?>
						<!--<option value="none" id="none" >NONE</option>-->
					</select> </td>
					</tr>
                   </div>
                  </td>
                </tr>
              </tbody></table>
                  </div>  




                        <div class="form-group">

                            <label>Remark</label>

               

						<textarea class="form-control" rows="3" name="remark"  placeholder="About the Meeting ..."><?php if($old_data!=''){ echo $old_data->remark; }?></textarea>

						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('remark'); ?></span>

                        </div>

                      <div class="form-group" >

                          <label>Followup Action</label>

						<input class="form-control" name="fup_a" value="<?php if($old_data!=''){ echo $old_data->followup_date;}?>" id="datepicker_fup<?=$edit_doctor->doctor_id ?>" type="text">

                      </div>
					 <div class="form-group">
						<label>Stay &nbsp; : &nbsp;&nbsp;</label>
						<br>
						<input  type="radio" class="form-check-input stay"  <?php echo set_checkbox('stay',0); ?> name="stay" id="stay" value="0">
						&nbsp;Not Stay &nbsp;
						<input type="radio" <?php echo set_checkbox('stay',1); ?>   class="form-check-input ts
						 stay"
                               name="stay" id="stay1" value="1">
						&nbsp;  Stay &nbsp;
						<span class="control-label" for="inputError" style="color: red"><?php echo form_error('stay'); ?></span>
					  </div>

            <div class="form-group">
              <label>Back HQ &nbsp; : &nbsp;&nbsp;</label>
              <br>
              <input  type="radio" class="form-check-input houp"  <?php echo set_checkbox('up',0); ?> name="up" id="houp" value="0">
              &nbsp;No &nbsp;
              <input type="radio" <?php echo set_checkbox('up',1); ?>  class="form-check-input ts houp" name="up"
                     id="houp1" value="1">
              &nbsp;  Yes &nbsp;
              <span class="control-label" for="inputError" style="color: red"><?php echo form_error('up'); ?></span>
                <span id="alt" style="margin-left: 50px; color: red;display:none;"> Please Add Next Interaction with
                    Another City.</span>
            </div>





				</div>
			</div>
		</div>
		<div class="row">
            <div class="col-md-12">
                <!--<div class="form-group">-->
                <div class="box-footer">
					<button type="submit" value="save_data" name="save" class="btn btn-info pull-right">Save</button>
					<?php  echo form_close();  ?>
					<button id="cancel_inter" class="btn btn-danger"> Cancel</button>
                </div>
            </div>
        </div>
          <!-- /.row -->
          

        </div>
        <!-- /.box-body -->
         <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  

		  
<script src="<?php echo base_url();?>design/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

       <script type="text/javascript">

		   /*Cancel Interaction*/
		   $('#cancel_inter').on("click",function(){
               if (confirm('Are you sure you want to Cancel this Interaction.?')) {
                   window.location.href='<?=base_url() ?>interaction/index/';
               }
		   });

		$("#save_sample").click(function(e) {
		   var selectval= $('[name="stay"]:checked').val();
		   if(typeof  selectval=="undefined"){
			   alert("Please Select Stay / Not Stay.!");
			   e.preventDefault();
		   }
		});

		$('#sale_dealer<?=$edit_doctor->doctor_id ?>').on("change", function(){
		   var saledealer_value = $(this).val();
		 if(saledealer_value === ''){
		   $("#d_list<?=$edit_doctor->doctor_id ?>").css("display","none");
			  }
			  else{
				  $("#d_list<?=$edit_doctor->doctor_id ?>").css("display","block");
			  }
		});

		$('#sale<?=$edit_doctor->doctor_id ?>').on("change", function(){

		//               alert('mee');

		   var sale_value = $(this).val();

		//               alert(sale_value);

		 if(sale_value === ''){
		   $("#meet<?=$edit_doctor->doctor_id ?>").css("display","none");
		   $("#notmmeet<?=$edit_doctor->doctor_id ?>").css("display","none");
			  }
			  else{
				  $("#meet<?=$edit_doctor->doctor_id ?>").css("display","block");
				  $("#notmmeet<?=$edit_doctor->doctor_id ?>").css("display","block");
			  }



		});

		$('#meet<?=$edit_doctor->doctor_id ?>').on("click", function(){

		//               alert('mee');

		   var meet_value = $(this).val();
		$('#rec_per<?=$edit_doctor->doctor_id ?>').prop('checked', false);
		$('#rec_pob<?=$edit_doctor->doctor_id ?>').prop('checked', false);
		$("#save_sample").hide();

		 if(meet_value === ''){

		   $("#sale<?=$edit_doctor->doctor_id ?>").css("display","none");

		   $("#sample<?=$edit_doctor->doctor_id ?>").css("display","none");

		   $("#jw_<?=$edit_doctor->doctor_id ?>").css("display","none");

			  }

			  else{

				  $("#sale<?=$edit_doctor->doctor_id ?>").css("display","block");

				   $("#sample<?=$edit_doctor->doctor_id ?>").css("display","block");

				   $("#jw_<?=$edit_doctor->doctor_id ?>").css("display","block");

			  }



		});

		$('#notmmeet<?=$edit_doctor->doctor_id ?>').on("click", function(){

		//               alert('mee');
		 var notmeet_value = $(this).val();
		$('#rec_per<?=$edit_doctor->doctor_id ?>').prop('checked', false);
		$('#rec_pob<?=$edit_doctor->doctor_id ?>').prop('checked', false);

		$("#save_sample").hide();

		 if(notmeet_value === ''){
		   $("#sale<?=$edit_doctor->doctor_id ?>").css("display","none");
		   $("#sample<?=$edit_doctor->doctor_id ?>").css("display","none");
		   $("#jw_<?=$edit_doctor->doctor_id ?>").css("display","none");
		  }
		  else{
			  $("#sale<?=$edit_doctor->doctor_id ?>").css("display","block");
			  $("#sample<?=$edit_doctor->doctor_id ?>").css("display","block");
			  $("#jw_<?=$edit_doctor->doctor_id ?>").css("display","block");
		  }

		});

		$('#rec_per<?=$edit_doctor->doctor_id ?>').on("click", function(){
		   $("#save_sample").show();
		   $('#rec_pob<?=$edit_doctor->doctor_id ?>').prop('checked', false);
		   $('#not_meet<?=$edit_doctor->doctor_id ?>').prop('checked', false);
		   $('#optionsRadios1').prop('checked', false);
		   $("#sample<?=$edit_doctor->doctor_id ?>").css("display","block");
		});

		$('#rec_pob<?=$edit_doctor->doctor_id ?>').on("click", function(){
               $("#save_sample").show();
               $('#rec_per<?=$edit_doctor->doctor_id ?>').prop('checked', false);
               $('#not_meet<?=$edit_doctor->doctor_id ?>').prop('checked', false);
               $('#optionsRadios1').prop('checked', false);
               $("#sample<?=$edit_doctor->doctor_id ?>").css("display","block");
		   });


      $(function(){
      $('.select3').select2();
      var $eventSelect3= $('.select2').select2();

      $eventSelect3.on("change",function(e){
         var sample_value = $(this).val();

		 if(sample_value != ''){
		   $("#meet<?=$edit_doctor->doctor_id ?>").css("display","none");
		   $("#notmmeet<?=$edit_doctor->doctor_id ?>").css("display","none");
		 }else{
			 $("#meet<?=$edit_doctor->doctor_id ?>").css("display","block");
			 $("#notmmeet<?=$edit_doctor->doctor_id ?>").css("display","block");
		  }
    });

         

         

$('#datepicker_contact<?=$edit_doctor->doctor_id ?>').datepicker({

              format:'dd-mm-yyyy',

              autoclose: true

    }) ; 

$('#datepicker_doa<?=$edit_doctor->doctor_id;?>').datepicker({

					format:'dd-mm-yyyy',

					autoclose:true

			  });

$('#datepicker_dob<?=$edit_doctor->doctor_id;?>').datepicker({

   format:'dd-mm-yyyy',

   autoclose:true

})  ;

$('#datepicker_fup<?=$edit_doctor->doctor_id;?>').datepicker({

   format:'dd-mm-yyyy',

   autoclose:true

})  ;

$('#datepicker_doi<?=$edit_doctor->doctor_id;?>').datepicker({

            format:'dd-mm-yyyy',

            startDate: '-24d',

            endDate: '+0d' ,

            autoclose:true

       })  ; 

    });
</script>


<script>
	$(document).ready(function(){
  	var saledealer_value = $('#sale_dealer<?=$edit_doctor->doctor_id ?>').val();
  	//alert(saledealer_value);
  	if(saledealer_value != '' && typeof  saledealer_value != 'undefined'){
  	  $("#d_list<?=$edit_doctor->doctor_id ?>").css("display","block");
  	  $("#meet<?=$edit_doctor->doctor_id ?>").css("display","none");
          $("#notmmeet<?=$edit_doctor->doctor_id ?>").css("display","none");
  	}
  });
</script>

<script>
    $('.stay').change(function() {
     if($('.stay:checked').val()==1)
     {
        $('#alt').show();
        $( "#houp" ).prop( "checked", true );
     }
    if($('.stay:checked').val()==0){
        $('#alt').hide();
        $( "#houp1" ).prop( "checked", true );
    }
    });
    $('.houp').change(function() {
        if($('#houp').is(":checked")){
            $('#alt').show();
        }
        if($('#houp1').is(":checked")){
            $('#alt').hide();
        }

       if($('#stay1').is(":checked"))
       {
          $('#alt').hide();
          $( "#houp" ).prop( "checked", true );

       }
        if($('#stay').is(":checked"))
        {
           // $( "#houp1" ).prop( "checked", true );
        }
    });
</script>
