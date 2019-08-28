<?php



$edit_appoint = json_decode($edit_doctor_list);

$dealer_data=json_decode($dealer_list);

$ms = json_decode($meeting_sample);

//$ap_personid=$edit_appoint->d_id;

//pr($edit_appoint); die;



?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



<div class="content-wrapper">





    <!-- Main content -->

    <section class="content">

         <?= get_flash();?>

      <!-- SELECT2 EXAMPLE -->

      <div class="box box-default">

        <div class="box-header with-border">

          <h3 class="box-title">Add</h3>



<!--          <div class="box-tools pull-right">

            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>

          </div>-->

        </div>

        <!-- /.box-header -->

        <div class="box-body">

          

            <?php

            echo form_open_multipart($action);

            ?>

            <div class="row">

            <div class="col-md-6">

                

                <div class="form-group" >

                 <label>Doctor name</label>

                 <input class="form-control" name="doc_name" placeholder="Dealer Name..." type="text" value="<?=$edit_appoint->c_name;?>" readonly="">               

                 <input class="dealer_view_id"  name="dealer_view_id" type="hidden" value="<?=$edit_appoint->d_id;?>"> 

                <input class="gd_id"  name="doc_id" type="hidden" value="<?=$edit_appoint->d_id;?>">                  

            <!--<span class="control-label" for="inputError" style="color: red"></span>-->

                 </div>             

             

             

               <div class="form-group" >

                      <!--<label>Meeting Types *</label>-->

                      

                <table class="table table-bordered" style="background: #00c0ef;">

                <tbody><tr>

                  

                  <th>Meeting</th>

                  <th>Value</th>

                 

                </tr>

                

                <tr>

                  <td>Sale</td>

                  <td id="sale" style="display: block"><input class="form-control" id="sale_dealer" name="m_sale" placeholder="Sales info..." type="text" ></td>

                  

                </tr>

                <tr>

                  <td>Sample</td>

                  <td id="sample" style="display: block"><select name="m_sample" multiple="multiple" class="form-control select2" style="width: 100%;">

                          <option value="">---Sample Name---</option>

                <?php 

                foreach($ms as $k_ms => $val_ms){

                    

                ?>   

                  <option value="<?=$val_ms->id?>" <?php if(isset($_POST['m_sample'])){echo set_select('m_sample',  $val_ms->id);} ?>><?=$val_ms->sample_name;?></option>

                  <?php }  ?>

              <!--<option value="none" id="none" >NONE</option>-->



                </select> </td>

                 

                </tr>

                <tr>

                  <td>Meet or Not Meet</td>

                  <td><div class="radio">

                    <label id="meet" style="display: block">

                      <input name="meet_or_not" id="optionsRadios1" value="1" type="radio">

                      Meet

                    </label>

                  </div>

                  <div class="radio">

                    <label id="notmmeet" style="display: block">

                      <input name="meet_or_not" id="not_meet" value="0" type="radio">

                      Not Meet

                    </label>

                  </div></td>

                  

                </tr>

               

              </tbody></table>

                      



                  </div>  

              

                

            </div>

            <!-- /.col -->

            <div class="col-md-6">

                

                  <div class="form-group" id="d_list" style="display: none">

           <label>Dealer List</label>

    <select name="dealer_id" class="form-control select2" style="width: 100%;">
              <?php 

                foreach($dealer_data as $k_s => $val_s){

                    

                    /*for dealers id who belogs to this doctor*/

                                if(!empty(($edit_appoint->dealers_id))){   

                                    $dealers_are = explode(',', $edit_appoint->dealers_id);

                                }

                                else{

                                    $dealers_are=array();

                                }  

                    /*end of dealers id who belogs to this doctor */



                     if(in_array($val_s->dealer_id,$dealers_are)){

                    

                ?>   

                  <option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?>><?=$val_s->dealer_name.','.$val_s->city_name;?></option>

                  <?php } } ?>

              <!--<option value="none" id="none" >NONE</option>-->



                </select>

    

</div>

                

                      <div class="form-group">

                            <label>Remark</label>

               

                     <textarea class="form-control" rows="3" name="remark" placeholder="About the Meeting ..."></textarea>



                        </div>

                

                                

            

              <!-- /.form-group -->

            </div>

            <!-- /.col -->

            <div class="col-md-6">

                <div class="form-group" >

                          <label>Followup Action</label>

                   <input class="form-control" name="fup_a" id="datepicker" type="text">

                      </div>

            </div>

                      

            <div class="col-md-12">

                <!--<div class="form-group">-->

                    <div class="box-footer">

                <!--<button type="submit" class="btn btn-default">Cancel</button>-->

                <button type="submit" class="btn btn-info pull-right">Submit</button>

              <!--</div>-->

              <!--</div>-->

                    

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

  </div>

<script src="<?= base_url()?>design/bower_components/select2/dist/js/select2.full.min.js"></script>



<script type="text/javascript">

    

    $('#sale_dealer').on("change", function(){

               

               var sale_value = $(this).val();

               

             if(sale_value === ''){

               $("#d_list").css("display","none");

                  }

                  else{

                      $("#d_list").css("display","block");

                  }

            

           });

           

            $('#sale_dealer').on("change", function(){

//               alert('mee');

               var sale_value = $(this).val();

//               alert(sale_value);

             if(sale_value != ''){

               $("#meet").css("display","none");

               $("#notmmeet").css("display","none");

                  }

                  else{

                      $("#meet").css("display","block");

                       $("#notmmeet").css("display","block");

                  }

            

           });

    

       $('#meet').on("click", function(){

//               alert('mee');

               var sale_value = $(this).val();

               

             if(sale_value === ''){

               $("#sale").css("display","none");

               $("#sample").css("display","none");

                  }

                  else{

                      $("#sale").css("display","block");

                       $("#sample").css("display","block");

                  }

            

           });

           

           $('#notmmeet').on("click", function(){

//               alert('mee');

               var sale_value = $(this).val();

               

             if(sale_value === ''){

               $("#sale").css("display","none");

               $("#sample").css("display","none");

                  }

                  else{

                      $("#sale").css("display","block");

                       $("#sample").css("display","block");

                  }

            

           });

    

     $('#sale_dealer').on("change", function(){

               

               var sale_value = $(this).val();

               

             if(sale_value === ''){

               $("#d_list").css("display","none");

                  }

                  else{

                      $("#d_list").css("display","block");

                  }

            

           });

           

           

            $(function(){

      var $eventSelect3= $('.select2').select2();

      

           $eventSelect3.on("change",function(e){

             

         var sample_value = $(this).val();

            

             if(sample_value != ''){

                   

               $("#meet").css("display","none");

               $("#notmmeet").css("display","none");

                  }

                  else{

                        

                     $("#meet").css("display","block");

                       $("#notmmeet").css("display","block");

                  } 



    });

             

 $('#datepicker_contact').datepicker({

              autoclose: true

    }) ; 

      $('#datepicker_doa').datepicker({

                            autoclose:true

                      });

       $('#datepicker_dob').datepicker({

           autoclose:true

       })  ; 

       $('#datepicker').datepicker({

           autoclose:true

       })  ; 

       

   

    });

    </script>