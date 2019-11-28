<?php

/* 
 * Developer: Shailesh Saraswat
 * Email: sss.shailesh@gmail.com
 * Dated: 04-Jan-2019
 * 
 * ASM Tour planing
 */

/*$url="https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=201301&destinations=201307&mode=transit&key=AIzaSyCR0sPg9k9PZJ7mBOSJiHxsUkPY96MJCtg";
$url="https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=201301&destinations=201307&key=AIzaSyCR0sPg9k9PZJ7mBOSJiHxsUkPY96MJCtg";
$api = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=201301&destinations=201307&mode=bicycling&key=AIzaSyCR0sPg9k9PZJ7mBOSJiHxsUkPY96MJCtg");
            $data = json_decode($api);
            pr($data);
            die;
$api = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=201301&destinations=201307&key=AIzaSyCR0sPg9k9PZJ7mBOSJiHxsUkPY96MJCtg");
            $data = json_decode($api);
            pr($data);
            die;
*/

$child_parent_data = json_decode($child_parent_list);

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
                    <th>Destination City </th>
                    <th>Joint Working</th>
                    <th id="is_joint_work" style="display: none" >Person for joint Working
                     
                            <input class="form-control pull-right newval" name="newval[]" type="hidden">

                    </th>
                  

                     <th>Remark </th>
                     
                     
                  </tr>
               </thead>
                <tbody>
                     <?php 

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
                                   <input class="form-control pull-right" name="assign_by[]" value="0" id="tour_date" type="hidden">
                                </td>
                                <td>
                                  <select name="dest_city[]" id="dest_city"  class="form-control select21" style="width: 100%;">
                                    <option value="">--Select City--</option>
                                    <?php foreach($city_data as $city){ ?>   
                                    <option value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option><?php }  ?>
                                  </select>
                                </td>
                                <td>
                                    <select name="joint_work[]" id="joint_work"  class="form-control select22" style="width: 100%;">
                                       <option value="">--Select working --</option>  
                                       <option value="1" >Yes</option>
                                       <option value="0" >No</option>
                                    </select>
                                    
                                     
                                </td>
                                <td class="par_child" style="display: none">
                                    <select multiple="" name="parent_child[][]" id="parent_child"  class="form-control select2" style="width: 100%;">
                                        <option value="">--Select employee --</option>
                                        <?php foreach($child_parent_data as $ku=>$val_u){ ?>   
                                       <option value="<?=$val_u->userid;?>" ><?=$val_u->name;?></option><?php }  ?>
                                    </select>
                                </td>
                                <td class="auto_work" style="display: none"></td>

                                

                                
                                <td>
                                  <input class="form-control pull-right mytext" name="mytext[]" type="hidden">

                                  <textarea readonly class="form-control" rows="3" name="remark[]" id="remark" placeholder="About the Plan ..."><?php echo $result->remark;?></textarea>
                                  <span  style="color:green">Holiday.</span>
                                </td>
                              </tr>



                            <?php } else { 
                              $resulttask=get_assign_task( date('Y-m-d', strtotime($tdate)));
                              if($resulttask){

                              ?>
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

                                    <select name="joint_work[]" id="joint_work"  class="form-control select22" style="width: 100%;">
                                        <option value="">--Select working --</option>
                                         
                                       <option value="1" >Yes</option>
                                       <option value="0" >No</option>
                                    </select>
                                
                                </td>
                                <td class="par_child" style="display: none">
                                    <select multiple="" name="parent_child[]" id="parent_child"  class="form-control select21" style="width: 100%;">
                                        <option value="">--Select employee --</option>
                                        <?php foreach($child_parent_data as $ku=>$val_u){ ?>   
                                       <option value="<?=$val_u->userid;?>" ><?=$val_u->name;?></option><?php }  ?>
                                    </select>
                                </td>
                                <td class="auto_work" style="display: none"></td>

                                
 
                                <td>
                                 <input class="form-control pull-right mytext" name="mytext[]" type="hidden">   
                                  <textarea readonly class="form-control" rows="3" name="remark[]" id="remark" placeholder="About the Plan ..."><?php echo $resulttask->remark;?></textarea>
                                  <span  style="color:red">This task assign by <?php echo get_user_name($resulttask->assign_by)?> Sir.</span>
                                </td>
                                
                                
                              </tr>


                             
                              <?php } else { 
                                $remark=get_followup( date('Y-m-d', strtotime($tdate)));
                                if( $remark!='')
                                {
                                ?>

                                 <tr>
                                
                                
                                
                                <td>
                                   
                                   <input readonly class="form-control pull-right" name="tour_date[]" value="<?php echo date ("d-m-Y", strtotime($start_date))?>" id="tour_date" type="text">
                                   <input class="form-control pull-right" name="assign_by[]" value="0" id="tour_date" type="hidden">
                                </td>
                                
                                <td>
                                  <select  name="dest_city[]" id="dest_city"  class="form-control select21" style="width: 100%;">
                                    <option value="">--Select City--</option>
                                    <?php foreach($city_data as $city){ ?>   
                                    <option value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option><?php }  ?>
                                  </select>
                                </td>
                                
                                <td>
                              
                                   <select name="joint_work[]" id="joint_work"  class="form-control select22" style="width: 100%;">
                                        <option value="">--Select working --</option>
                                         
                                       <option value="1" >Yes</option>
                                       <option value="0" >No</option>
                                    </select>  
                                
                                
                                </td>
                                <td class="par_child" style="display: none">
                                    <select multiple="" name="parent_child[]" id="parent_child"  class="form-control select2" style="width: 100%;">
                                        <option value="">--Select employee --</option>
                                        <?php foreach($child_parent_data as $ku=>$val_u){ ?>   
                                       <option value="<?=$val_u->userid;?>" ><?=$val_u->name;?></option><?php }  ?>
                                    </select>
                                </td>
                                <td class="auto_work" style="display: none"></td>

                               

                                <td>
                                    <input class="form-control pull-right mytext" name="mytext[]" type="hidden">
                                  <textarea  class="form-control" rows="3" name="remark[]" id="remark" placeholder="About the Plan ..."><?php echo $remark;?></textarea>
                                   <span  style="color:blue">Pre Planned Follow Up.</span>
                                
                                </td>
                                
                              </tr>


                                <?php } else { 
                                 ?>
                                <tr>
                                
                                
                             
                                <td>
                                      
                                   <input readonly class="form-control pull-right" name="tour_date[]" value="<?php echo date ("d-m-Y", strtotime($start_date))?>" id="tour_date" type="text">

                                   <input class="form-control pull-right" name="assign_by[]" value="0" id="tour_date" type="hidden">
                                </td>
                                
                                <td>
                                  <select name="dest_city[]" id="dest_city"  class="form-control select21" style="width: 100%;">
                                    <option value="">--Select City--</option>
                                    <?php foreach($city_data as $city){ ?>   
                                    <option value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option><?php }  ?>
                                  </select>
                                </td>
                                
                                <td>

                                    <select name="joint_work[]" id="joint_work"  class="form-control select22" style="width: 100%;">
                                        <option value="">--Select working --</option>
                                         
                                       <option value="1" >Yes</option>
                                       <option value="0" >No</option>
                                    </select>
                                     
                                
                                </td>
                                <td class="par_child"  style="display: none">
                                     <select multiple="" name="parent_child[]" id="parent_child"  class="form-control select2" style="width: 100%;">
                                        <option value="">--Select employee --</option>
                                        <?php foreach($child_parent_data as $ku=>$val_u){ ?>   
                                       <option value="<?=$val_u->userid;?>" ><?=$val_u->name;?></option><?php }  ?>
                                     </select>
                                </td>
                                <td class="auto_work" style="display: none"></td>

                                <td>
                                  <input class="form-control pull-right mytext" name="mytext[]" type="hidden">
                                  <textarea <?php echo date('D',strtotime($start_date))=='Sun'?'readonly':'';?> class="form-control" rows="3" name="remark[]" id="remark" placeholder="About the Plan ..."><?php echo date('D',strtotime($start_date))=='Sun'?'Day is Sunday':'';?></textarea>
                                  <?php echo date('D',strtotime($start_date))=='Sun'?'<span  style="color:red">Sunday.</span>':'';?>
                                   
                                </td>
                                
                                
                              </tr>
                            <?php }}} ?>
                  <?php $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date))); } ?>
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script type='text/javascript'>
        $('#datepickerend').datepicker({
                    autoclose: true
          }) ;
    
        $(function(){
              
              var $elementselect2  = $('.select2').select2({ tags: true }); 
              var $elementselect21  =   $('.select21').select2();
              var $elementselect22  = $('.select22').select2(); 
            
              $elementselect2.on("select2:select", function (evt) {
                            var element = evt.params.data.element;
                            var $element = $(element);

                            $element.detach();
                            $(this).append($element);
                            $(this).trigger("change");
                });
                
              $elementselect2.on('change',function(e){
               
                  var person = $(this).val();
                  var last_added_person = $(this).find(':selected:last').val();
                  $(this).closest('tr').find('.mytext').val(person);
                  var city =  $(this).closest('tr').find('#dest_city').val();
                  var plan_date =  $(this).closest('tr').find('#tour_date').val();
                  
                  var  lastOpt = $(this).index();
                  if(city!=''){ 
                     $.ajax({
                        type:"POST",


                        url:"<?=base_url();?>tour_plan/tour_plan/get_parent_child_user",


                        data : 'userid='+last_added_person+'&plandate='+plan_date,
                        
                        
                         success:function(res){ 
                           
                                if(res){
                                        $.confirm({
                                            title: 'Confirm!',
                                            content: 'Before changing your Boss Tour Plan you need to send a message!  <br> Confirm If YES ',
                                            buttons: {
                                                
                                                confirm: {
                                                    text: 'Confirm',
                                                    btnClass: 'btn-green',
                                                    keys: ['enter', 'shift'],
                                                        action: function(){
                                                            
                                                             $.ajax({
                                                                        type:"POST",


                                                                        url:"<?=base_url();?>tour_plan/tour_plan/send_change_tp_request_toboss",


                                                                        data : 'userid='+last_added_person+'&plandate='+plan_date+'&city='+city,
                                                                        success:function(res){ 
                                                                                  $.alert('Confirmed!');
                                                                          } 
                                                                });              
                                                         
                                                        }
                                                },
                                                cancel: {
                                                    text: 'Cancel',
                                                    btnClass: 'btn-red',
                                                    keys: ['enter', 'shift'],
                                                        action: function(){
                                                         $('.select2 option[value='+last_added_person+']').remove();
                                                                        $.alert('Canceled!');
                                                           
                                                        }
                                                }
                                              
                                                
                                              
                                            }
                                        });
                                     }

                       }
                        
                        
                    });
                    }else{
                           alert('Please Choose City First');
                    }
                   
                   
                   
              });
              
              $elementselect22.on('change',function(e){ 
                    var joint_work=$(this).val(); 
                if(joint_work==1){
                    $('#is_joint_work').css("display", "block");
                    $('.auto_work').css("display", "block");
                    $(this).closest('td').next('td.par_child').css("display", "block");

                }
                else{
        //              $('#is_joint_work').css("display", "none");
        //             $(this).closest('td').next('td.auto_work').css("display", "block");
                     $(this).closest('td').next('td.par_child').css("display", "none");
                }

             });
          
             
             

        });
    
    
    
    
   
</script>