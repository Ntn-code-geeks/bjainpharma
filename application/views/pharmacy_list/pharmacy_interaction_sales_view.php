<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


 
$edit_pharmacy=json_decode($edit_pharmacy_list);
 $dealer_data = json_decode($dealer_list);   // for all active dealers 

 //$pharma_info = json_decode($pharma_data);
 $ms = json_decode($meeting_sample);
 
$team_list=json_decode($users_team);
?>
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

			<div class="row">
				<div class="col-md-12">
				 
			</div>
		</div>
		<div class="row">
            <div class="col-md-12">
                <!--<div class="form-group">-->
				<?php echo form_open_multipart($action);?>
				<input type="hidden" name="path_info" <?php if($old_data!=''){?>  value="<?=$old_data->path_info;?>"<?php }else{?> value="<?=$path_info;?>"<?php }?>>	
				<input type="hidden" name="city"  <?php if($old_data!=''){?> value="<?=$old_data->city_code;?>"<?php }else{?> value="<?=$city;?>"<?php }?> >
				
				  <div class="form-group" >
                 <label>Sub Dealer name</label>
                 <input class="form-control" name="com_name" placeholder="Sub Dealer Name..." type="text" value="<?=$edit_pharmacy->com_name;?>" readonly="">               
                 <input class="dealer_view_id"  name="dealer_view_id" type="hidden" value="<?=$edit_pharmacy->id;?>"> 
                <input class="gd_id"  name="pharma_id" type="hidden" value="<?=$edit_pharmacy->id;?>">                  
            <!--<span class="control-label" for="inputError" style="color: red"></span>-->
                 </div>

                 
                 
                 <div class="form-group" id="jw_<?=$edit_pharmacy->id ?>" style="display: block">
                     <label>Joint Working</label>
                     <select name="team_member[]" multiple="multiple" class="form-control select2" style="width: 100%;">
                            <!--<option value="">---Sample Name---</option>-->
                      <?php 
                      foreach($team_list as $k_tl => $val_tl){
                          
                      ?>   
                        <option value="<?=$val_tl->userid?>" <?php if($old_data!=''){ $jointarr=explode(',',$old_data->joint_working); echo in_array($val_tl->userid,$jointarr)?'selected':''; }  ?> <?php if(isset($_POST['team_member'])){echo set_select('team_member',  $val_tl->userid);} ?>><?=$val_tl->username;?></option>
                        <?php }  ?>
                       <!--<option value="none" id="none" >NONE</option>-->

                    </select>
                 </div>

            <?php if($date_interact==''){?>
            <div class="form-group" >
            <label>Date of Interaction<span style="color: red;font-size: 20px">*</span></label>
            <input required class="form-control" name="doi_doc" value="<?php if($old_data!=''){ echo $old_data->interaction_date;}?>" id="datepicker_doi<?=$edit_pharmacy->id ?>" type="text">
            </div>

          <?php }else{?>
              <input class="form-control" name="doi_doc" value="<?php echo date('d-m-Y',strtotime($date_interact));?>" id="datepicker_doi<?=$edit_pharmacy->id ?>" type="hidden">
          <?php }?>
       
<!--                 </div>
                  <div class="col-md-6">-->
                  <div class="form-group" >
                      <!--<label>Meeting Types *</label>-->
                      
                <table class="table table-bordered" style="background: #00c0ef;">
                <tbody><tr>
                  
                  <th>Meeting</th>
                  <th>Value</th>
                 
                </tr>
				<tr >
					<td>Interaction Type<span style="color: red;font-size: 20px">*</span></td>
					<td><div class="radio">
					<label id="meet<?=$edit_pharmacy->id ?>" style="display: block">
					<input name="meet_or_not" id="optionsRadios1" value="1" type="radio">Only Discussion</label>
						<label id="notmmeet<?=$edit_pharmacy->id ?>" style="display: block">
							<input name="meet_or_not" id="not_meet<?=$edit_pharmacy->id ?>" value="0" type="radio">Not Met</label>

							<label id="meet_sec_pob<?=$edit_pharmacy->id ?>" style="display: block">
								<input name="telephonic" id="rec_per<?=$edit_pharmacy->id ?>" value="0" <?php if($order_amount!='' && $old_data->telephonic=='0'){ echo 'checked'; }?> type="radio">
								Order Received POB-In Person
							</label>

							<div style="display: inline-flex;">
								<label id="meet_sec_tele<?=$edit_pharmacy->id ?>" style="display: block">
									<input name="telephonic" id="rec_pob<?=$edit_pharmacy->id ?>" value="1" <?php if($order_amount!='' && $old_data->telephonic=='1'){ echo 'checked'; }?> type="radio">
									Order Received POB-Telephonic
								</label>

								<?php if($order_amount!=''){ ?>
					<td style="padding: 40px; width: 20%;"> Secondary Sales:
						<input class="form-control" readonly id="sale_dealer<?=$edit_pharmacy->id;?>"
							   name="m_sale" value='<?=$order_amount?>' type="text" > </td>
					<?php }else{ ?>
						<td style="padding: 40px; width: 20%;">
							<button type="submit" value="secondary_product" id="save_sample" name="save" class="btn
						btn-info" style="display: none;">Add Secondary Product</button> </td>
					<?php }?>
				  </div>
			</div>

						</div>
					</td>

				</tr>

                <tr >
                  <td>Sample</td>
                  <td id="sample<?=$edit_pharmacy->id ?>" style="display: block">
				  <select name="m_sample[]" multiple="multiple" class="form-control select2" style="width: 100%;">
					  <option value="">---Sample Name---</option>
                <?php
                foreach($ms as $k_ms => $val_ms){

                ?>
                  <option value="<?=$val_ms->id?>" <?php if($old_data!=''){ $jointarr=explode(',',$old_data->sample); echo in_array($val_ms->id,$jointarr)?'selected':''; }  ?><?php if(isset($_POST['m_sample'])){echo set_select('m_sample',  $val_ms->id);} ?>><?=$val_ms->sample_name;?></option>
                  <?php }  ?>
              <!--<option value="none" id="none" >NONE</option>-->

                </select> </td>
                 
                </tr>


               
              </tbody></table>
                      

                  </div>  

				  <div class="form-group" id="d_list<?=$edit_pharmacy->id ?>" style="display: none">
								   <label>Dealer List<span style="color: red;font-size: 20px">*</span></label>
								   
							<select id="pharmacy_dealers<?=$edit_pharmacy->id ?>" name="dealer_id" class="form-control select2" style="width: 100%;">
					   <?php
			   if(!empty($edit_pharmacy->dealers_id)){
			   ?>
					<?php
					foreach($dealer_data as $k_s => $val_s){
											
										/*for dealers id who belogs to this doctor*/
										if(!empty(($edit_pharmacy->dealers_id))){
											$dealers_are = explode(',', $edit_pharmacy->dealers_id);
										}
										else{
											$dealers_are=array();
										}
										/*end of dealers id who belogs to this doctor */

											 if(in_array($val_s->dealer_id,$dealers_are)){
											 if($val_s->blocked==0){
										?>   
										  <option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?>><?=$val_s->dealer_name.','.$val_s->city_name;?></option>
								    <?php } } } ?>

                  <?php
                foreach($pharma_list as $k_pl => $val_pl){



                    /*for dealers id who belogs to this doctor*/

                                if(!empty(($edit_pharmacy->dealers_id))){

                                    $dealers_are = explode(',', $edit_pharmacy->dealers_id);

                                }

                                else{

                                    $dealers_are=array();

                                }

                    /*end of dealers id who belogs to this doctor */



                     if(in_array($val_pl['id'],$dealers_are)){

                     if($val_pl['blocked']==0){

                ?>   

                  <option value="<?=$val_pl['id']?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_pl['id']);} ?>><?=$val_pl['com_name'].', (Sub Dealer)';?></option>

                <?php } } } ?>
                <!--<option value="none" id="none" >NONE</option>-->
                <?php }else{ ?>
               <!--   <button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal_add_dealer<?=$edit_doctor->doctor_id ?>">Add Dealer/Sub Dealer  </button>
              <a href="<?= base_url()?>doctors/doctor/edit_doctor/<?php echo urisafeencode($edit_doctor->doctor_id); ?>" style="color: #fff"><button type="button" class="btn btn-warning">Add Dealer/Sub Dealer  </button></a> -->
              <?php } ?>
									  <!--<option value="none" id="none" >NONE</option>-->
						 </select><br/>
								  <button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal_add_dealer<?=$edit_pharmacy->id ?>">Add Dealer/Sub Dealer</button>	

                <div class="form-group">
                    <label id="doc_rel_label" >Duplicate Secondary &nbsp;: &nbsp;
                     <input name="doc_rel" id="doc_rel" value="1" type="checkbox"> 
                    </label>
                   
                </div>	   
							
				</div>
            <div class="form-group" id="rel_doc_box" style="display: none">
              <label>Dealer List</label>                   
              <select  name="rel_doc_id" class="form-control select2" style="width: 100%;">
                     <?php
                   if(!empty($doc_rel_pharma)){
                   ?>    
                    <?php 
                    foreach($doc_rel_pharma as $docInfo){ ?>   
                      <option value="<?=$docInfo['doctor_id']?>"><?=$docInfo['doc_name'];?></option>
                    <?php } ?>
                <!--<option value="none" id="none" >NONE</option>-->
                <?php }?>

                    <!--<option value="none" id="none" >NONE</option>-->
             </select>   
              
            </div>

            <div class="form-group">
              <label>Remark</label>
              <textarea class="form-control" rows="3" name="remark" placeholder="About the Meeting ..."><?php if($old_data!=''){ echo $old_data->remark; }?></textarea>
            </div>
                
            <div class="form-group" >
							<label>Followup Action</label>
							<input class="form-control" name="fup_a" value="<?php if($old_data!=''){ echo $old_data->followup_date;}?>" id="datepicker_fup<?=$edit_pharmacy->id ?>" type="text">
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
              <input type="radio" <?php echo set_checkbox('up',1); ?>  class="form-check-input ts houp" name="up"
                     id="houp1" value="1">
              &nbsp;  Yes &nbsp;
              <span class="control-label" for="inputError" style="color: red"><?php echo form_error('up'); ?></span>

               <span id="alt" style="margin-left: 50px; color: red;display:none;"> Please Add Next Interaction with
                    Another City.</span>
            </div>
                         <div class="form-group">
            <label>Send Mail to Dealer &nbsp; : &nbsp;&nbsp;</label>
            <br>
            <input  type="radio" class="form-check-input" checked name="dealer_mail" id="" value="1">
            &nbsp;Yes &nbsp;
            <input type="radio" class="form-check-input" name="dealer_mail" id="" value="0">
            &nbsp;  No &nbsp;
            </div>

		              			
                <div class="box-footer">
					<button type="submit" value="save_data" name="save" class="btn btn-info pull-right">Save</button>
					<?php  echo form_close();  ?>
				</div>
		  <button style="margin-top: -73px; margin-left: 10px;" class="btn btn-danger cancel_inter"> Cancel</button>

            </div>
        </div>
          <!-- /.row -->
          

        </div>
        <!-- /.box-body -->
         <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  
<script type="text/javascript">   // for multipile model open
        $("#modal_add_dealer<?=$edit_pharmacy->id ?>").on('hidden.bs.modal', function (event) {
            if ($('.modal:visible').length) //check if any modal is open
            {
              $('body').addClass('modal-open');//add class to body
            }
          });
        </script> 
          
       <script type="text/javascript">

           /*Cancel Interaction*/
           $('.cancel_inter').on("click",function(){
               if (confirm('Are you sure you want to Cancel this Interaction.?')) {
                   window.location.replace('<?= base_url(); ?>interaction/index/');
               }
           });

           $("#save_sample").click(function(e) {
               var selectval= $('[name="stay"]:checked').val();
               if(typeof  selectval=="undefined"){
                   alert("Please Select Stay / Not Stay.!");
                   e.preventDefault();
               }
           });

           $('#sale_dealer<?=$edit_pharmacy->id ?>').on("change", function(){
             var sale_value = $(this).val();
             if(sale_value === ''){
               $("#d_list<?=$edit_pharmacy->id ?>").css("display","none");
                  }
                  else{
                      $("#d_list<?=$edit_pharmacy->id ?>").css("display","block");
                  }
           });
           
           $('#sale<?=$edit_pharmacy->id ?>').on("change", function(){
//               alert('mee');
               var sale_value = $(this).val();
               
             if(sale_value === ''){
               $("#meet<?=$edit_pharmacy->id ?>").css("display","none");
               $("#notmmeet<?=$edit_pharmacy->id ?>").css("display","none");
                  }
                  else{
                      $("#meet<?=$edit_pharmacy->id ?>").css("display","block");
                       $("#notmmeet<?=$edit_pharmacy->id ?>").css("display","block");
                  }
            
           });
    
       	   $('#meet<?=$edit_pharmacy->id ?>').on("click", function(){
//               alert('mee');
               var sale_value = $(this).val();
           $('#rec_per<?=$edit_pharmacy->id ?>').prop('checked', false);
           $('#rec_pob<?=$edit_pharmacy->id ?>').prop('checked', false);
           $("#save_sample").hide();
               
             if(sale_value === ''){
               $("#sale<?=$edit_pharmacy->id ?>").css("display","none");
               $("#sample<?=$edit_pharmacy->id ?>").css("display","none");
               $("#jw_<?=$edit_pharmacy->id ?>").css("display","none");
                  }
                  else{
                      $("#sale<?=$edit_pharmacy->id ?>").css("display","block");
                       $("#sample<?=$edit_pharmacy->id ?>").css("display","block");
                        $("#jw_<?=$edit_pharmacy->id ?>").css("display","block");
                  }
            
           });
           
           $('#notmmeet<?=$edit_pharmacy->id ?>').on("click", function(){
//               alert('mee');
               var sale_value = $(this).val();
               $('#rec_per<?=$edit_pharmacy->id ?>').prop('checked', false);
               $('#rec_pob<?=$edit_pharmacy->id ?>').prop('checked', false);
               $("#save_sample").hide();

             if(sale_value === ''){
               $("#sale<?=$edit_pharmacy->id ?>").css("display","none");
               $("#sample<?=$edit_pharmacy->id ?>").css("display","none");
                $("#jw_<?=$edit_pharmacy->id ?>").css("display","none");
                  }
                  else{
                      $("#sale<?=$edit_pharmacy->id ?>").css("display","block");
                       $("#sample<?=$edit_pharmacy->id ?>").css("display","block");
                       $("#jw_<?=$edit_pharmacy->id ?>").css("display","block");
                  }
            
           });

           $('#rec_per<?=$edit_pharmacy->id ?>').on("click", function(){
              $("#save_sample").show();
               $('#rec_pob<?=$edit_pharmacy->id ?>').prop('checked', false);
               $('#not_meet<?=$edit_pharmacy->id ?>').prop('checked', false);
               $('#optionsRadios1').prop('checked', false);
               $("#sample<?=$edit_pharmacy->id ?>").css("display","block");
           });

           $('#rec_pob<?=$edit_pharmacy->id ?>').on("click", function(){
               $("#save_sample").show();
               $('#rec_per<?=$edit_pharmacy->id ?>').prop('checked', false);
               $('#not_meet<?=$edit_pharmacy->id ?>').prop('checked', false);
               $('#optionsRadios1').prop('checked', false);
               $("#sample<?=$edit_pharmacy->id ?>").css("display","block");
           });


      $(function(){
      var $eventSelect3= $('.select2').select2();
          $eventSelect3.on("change",function(e){
         var sample_value = $(this).val();
		 if(sample_value != ''){
		   $("#meet<?=$edit_pharmacy->id ?>").css("display","none");
		   $("#notmmeet<?=$edit_pharmacy->id ?>").css("display","none");
		  }
		  else{
		   $("#meet<?=$edit_pharmacy->id ?>").css("display","block");
		   $("#notmmeet<?=$edit_pharmacy->id ?>").css("display","block");
		  }

    });
         
         
 $('#datepicker_contact<?=$edit_pharmacy->id ?>').datepicker({
              format:'dd-mm-yyyy',
              autoclose: true
    }) ; 
      $('#datepicker_doa<?=$edit_pharmacy->id;?>').datepicker({
                            format:'dd-mm-yyyy',
                            autoclose:true
                      });
       $('#datepicker_dob<?=$edit_pharmacy->id;?>').datepicker({
           format:'dd-mm-yyyy',
           autoclose:true
       })  ;
       $('#datepicker_fup<?=$edit_pharmacy->id;?>').datepicker({
           format:'dd-mm-yyyy',
           autoclose:true
       })  ;
        $('#datepicker_doi<?=$edit_pharmacy->id;?>').datepicker({
            format:'dd-mm-yyyy',
            startDate: '-24d',
            endDate: '+0d' ,
            autoclose:true
       })  ;


    });
          </script>
	
	<script>
	$(document).ready(function(){

	/* var saledealer_value = $('#sale_dealer<?=$edit_doctor->doctor_id ?>').val();
	//alert(saledealer_value);
	if(saledealer_value != '' && typeof  saledealer_value != 'undefined'){

	  $("#d_list<?=$edit_doctor->doctor_id ?>").css("display","block");
	  $("#meet<?=$edit_doctor->doctor_id ?>").css("display","none");
      $("#notmmeet<?=$edit_doctor->doctor_id ?>").css("display","none");

	} */



	});

	</script>

	<!--Add dealer modal-->
	<div class="modal modal-info fade" id="modal_add_dealer<?=$edit_pharmacy->id ?>">
          <form id="<?=$edit_pharmacy->id ?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Dealer</h4>
              </div>
              <div class="modal-body">
                  
                  
       <div class="form-group" id="d_list<?=$edit_pharmacy->id ?>">
           <label>Dealer List</label>
           <?php
//           if(!empty($edit_pharmacy->dealers_id)){
           ?>
           <select multiple="" id="dealer_id<?=$edit_pharmacy->id ?>" name="dealer_id[]" class="form-control select5" style="width: 100%;">
                  
                <?php 
                foreach($dealer_data as $k_s => $val_s){
                    
                    /*for dealers id who belogs to this doctor*/
                                if(!empty(($edit_pharmacy->dealers_id))){   
                                    $dealers_are = explode(',', $edit_pharmacy->dealers_id);
                                }
                                else{
                                    $dealers_are=array();
                                }  
                    /*end of dealers id who belogs to this doctor */

                     if(in_array($val_s->dealer_id,$dealers_are)){
//                    if($val_s->blocked==0){
                ?>   
               <option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?> selected=""><?=$val_s->dealer_name.','.$val_s->city_name;?></option>
                <?php  } else{
                if($val_s->status==1){     ?>
                
                   <option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?> ><?=$val_s->dealer_name.','.$val_s->city_name;?></option>
   
               <?php     
                } } } ?>
              
                  <?php 

                foreach($pharma_list as $k_pl => $val_pl){

                    

                    /*for dealers id who belogs to this doctor*/

                                if(!empty(($edit_doctor->dealers_id))){   

                                    $dealers_are = explode(',', $edit_doctor->dealers_id);

                                }

                                else{

                                    $dealers_are=array();

                                }  

                    /*end of dealers id who belogs to this doctor */



                     if(in_array($val_pl['id'],$dealers_are)){

//                     if($val_pl['blocked']==0){

                ?>   

               <option value="<?=$val_pl['id']?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_pl['id']);} ?> selected=""><?=$val_pl['com_name'].', (Sub Dealer)';?></option>

                <?php }

                

                elseif($val_pl['status']==1){

                    

                 ?>

             <option value="<?=$val_pl['id']?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_pl['id']);} ?> ><?=$val_pl['com_name'].', (Sub Dealer)';?></option>



               <?php

                }

                

                

               } ?>

                  
              <!--<option value="none" id="none" >NONE</option>-->

    </select> <br/>
                    <!--<button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal_add_dealer<?=$edit_pharmacy->id ?>">Add Dealer/Sub Dealer  </button>-->

                    
                      
           <?php // } ?>
<span class="control-label" id="dealer_id_help<?=$edit_pharmacy->id ?>" for="inputError" style="color: red"><?php echo form_error('dealer_id'); ?></span>

</div>

                      
                  </div>
              
              
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button id="submit" type="submit" class="btn btn-outline submit" >Save changes</button>
              </div>
            </div>
          </form>
          <?php // echo form_close(); ?>
            <!-- /.modal-content -->
          </div> 


<script type="text/javascript">
    $(document).ready(function(){
     var dp;
         var $eventSelect5= $('.select5').select2();

          $eventSelect5.on("change",function(e){

        var  dealer_pharma = $(this).val();
                    dp =  dealer_pharma;
         //alert(dealer_pharma);

    });
        
$(".submit").click(function(){

        var newdealer_pharma =  dp;
   var formid = $(this).closest("form").attr('id'); 




//    alert(formid);

//var email = $("#email").val();
//var password = $("#password").val();
//var contact = $("#contact").val();
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'dealers='+ newdealer_pharma+'&pharma_id='+formid;
if(newdealer_pharma=='' || formid=='')
{
alert("Please Fill All Fields");
}
else
{
	var urlData1=<?php echo "'".base_url()."pharmacy/pharmacy/add_dealer_pharma/"."'";?>;
	var urlData=<?php echo "'".base_url()."pharmacy/pharmacy/pharmacy_dealer_list/"."'";?>;
// AJAX Code To Submit Form.
$.ajax({
type: "POST",
url: urlData1,
data: dataString,
cache: false,
success: function(result){
        alert(result);
		$('#modal_add_dealer<?=$edit_pharmacy->id;?>').modal('toggle');
        $.ajax({
        type: "POST",
        url: urlData+formid,
        cache: false,
        success: function(result){
//            alert(result);
        $("#pharmacy_dealers"+formid).html(result);
        //$("#dealer_id"+formid).append(result);

        }
        });
}
});


}
return false;
});
});
    
    
    
    </script>	

	<script>
	$(document).ready(function(){
             
	var saledealer_value = $('#sale_dealer<?=$edit_pharmacy->id ?>').val();
	//alert(saledealer_value);
	if(saledealer_value != '' && typeof  saledealer_value != 'undefined'){

	  $("#d_list<?=$edit_pharmacy->id ?>").css("display","block");
	  $("#meet<?=$edit_pharmacy->id ?>").css("display","none");
      $("#notmmeet<?=$edit_pharmacy->id ?>").css("display","none");

	}



	});
	
  </script> 
  <script> 
  $("#doc_rel").click(function(){
   $("#rel_doc_box").toggle(this.checked);
   
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
