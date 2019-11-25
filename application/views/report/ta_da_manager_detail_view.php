<?php

$designation_id = get_user_deatils(logged_user_data())->user_designation_id;
$tada_data = json_decode($tada_report);
//pr($admin_total_amount); die;
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>

    @media print {
        #printableTable {
            display: block;
        }
    }
</style>

<script type="text/javascript">
    jQuery(document).ready(function() {
        var total = 0;
        $('.other_amt').each(function() {
            var other_amount=$(this).val();
            if(other_amount != ''){
                total += Number($(this).val());
			}

        });
        $('#usr_total').append(parseFloat(total));
        var sum = 0;
        $(".mng_amt").each(function(){
            sum += +$(this).val();
        });
        console.log(sum);
		if(sum > 0){
             $(".total").val(sum);
            var grnd_total=$('#gt_amt').text();
            var overalltot=parseFloat(grnd_total)+parseFloat(total);
            $('#over_amt').val(parseFloat(overalltot));
		}else if(sum == '0'){
            var grnd_total=$('#gt_amt').text();
            var overalltot=parseFloat(grnd_total)+parseFloat(total);
            $('#over_amt').val(parseFloat(overalltot));
		}
		else{
            var grnd_total=$('#gt_amt').text();
            var overalltot=parseFloat(grnd_total)+parseFloat(total);
            $('#over_amt').val(parseFloat(overalltot));
		}


		var sum_gtr=$('#sumgt').text();
		var spc= " + ";
		if(total > 0){
            var finall_sum=sum_gtr +spc+  parseFloat(total);
            $('#consolidate').append(finall_sum);
        }else{
            var finall_sum=sum_gtr;
            $('#consolidate').append(finall_sum);
		}

    });


    $(document).on("change", ".mng_amt", function() {
        var sum = 0;
        $(".mng_amt").each(function(){
            var mg_value=$(this).val();
            if(mg_value != ''){
                sum += +$(this).val();
            }
        });
        $(".total").val(sum);
        var totalval=$(".totval").val();
        var user_imp=$('#usr_total').text();
        if(user_imp != ''){
            var grandtotal= parseFloat(totalval)+parseFloat(user_imp)+parseFloat(sum);
		}else{
            var grandtotal= parseFloat(totalval)+parseFloat(sum);
		}
        $("#over_amt").val(grandtotal);
        // console.log(user_imp);
    });

    $(document).on("click", "#submit_manager", function() {
        var amt_submit=$('#over_amt').val();
        $('#final_total').val(amt_submit);
    });



</script>


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
        <div class="box-body" id="printableTable">
             <span style="text-align: center !important;">

			 <?php
			 $uID=get_user_id($name);
			 $usrID=$uID->user_designation_id;
			 $userDesg=get_designation_name($usrID);
			 ?>
			<p><strong><?=$name.' ('.$userDesg->designation_name.')' ?></strong></p>
			<?php
			$year=explode('-',$month_year);
			$ExDate='1-'.$month_year;
			@$monthReport= date("F", strtotime($ExDate));
			?>
			<p><strong>Report Month: </strong><?= $monthReport.'-'.$year[1];?></p>
		    </span>
          <?php   echo form_open_multipart($action);   ?>
                <table id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Interaction DATE </th>
                    <th>FROM City</th>
                    <th>CITY WORKED </th>
                    <th>KMS </th>
                    <th>T.A.</th>
                    <th>D.A.</th>
                    <th>POSTAGE</th>
                    <th>TOTAL Amount</th>
                    <th>Any other Charge Name</th>
                    <th>Any other Charge Amount</th>
                    <th>Manager Total Amount </th>
<!--                    <th>Admin Total Amount </th>-->
                  </tr>
               </thead>
                <tbody>
                  <?php 
                  
                  $gtrow=0; $gtta=0; $gtda=0; $gtpostage=0;
                  $totalrow=0;
                  $mtData = $month_year;
                  $mtDta = explode('-', $mtData);
                  $month = $mtDta[0];
                  $year = $mtDta[1];

                  $start_date = "01-".$month."-".$year;
                  $start_time = strtotime($start_date);

                  $end_time = strtotime("+1 month", $start_time);

                  for($i=$start_time; $i<$end_time; $i+=86400) {
                      $list = date('Y-m-d', $i);        ///date to go in DB
                      $listshow = date('d-m-Y', $i);    ///date to show
                      $day = date('D', $i);             //Day
                      $listDate = array();
                      foreach ($tada_data as $k_tada=>$val_tada){
                          $listDate[]= $val_tada->ineraction_date;
                          $huy=array_count_values($listDate);
                          $datval=$huy[$val_tada->ineraction_date];
                          if($datval>=2){
                              $totalrow = $val_tada->ta + 0 + 0;
                          }else{
                              $totalrow = $val_tada->ta + $val_tada->da + $val_tada->postage;
                          }

                          if(($val_tada->ineraction_date==$list) && ($day!='Sun')){
                              $gtrow = $gtrow+$val_tada->total_amount;
                              $gtta = $gtta+$val_tada->ta;
                              $gtda = $gtda+$val_tada->da;
                              $gtpostage = $gtpostage+$val_tada->postage;
                          ?>
                          <tr>
                              <td>
                                  <input readonly class="form-control pull-right" value="<?php echo $listshow ;?> " style="width:
                                   100px;">
                                  <input type="hidden" name="tada_detail_id[]" value="<?php echo $val_tada->tada_detail_id;?>">
                              </td>
                              <td>
                                  <input readonly class="form-control pull-right" value="<?php echo
                                  $val_tada->from_city;?>" style="width:
                                           125px; padding: 2px;
                                            ;">

                              </td>
                              <td>
                                  <input readonly class="form-control pull-right" value="<?php echo
                                  $val_tada->city_worked;?>" style="width: 125px; padding: 2px; ">

                              </td>
                              <td>
                                  <input readonly class="form-control pull-right" value="<?php echo
                                  $val_tada->distance;?>" style="width: 52px;     padding: 2px;">
                              </td>
                              <td>
                                  <input readonly class="form-control pull-right" value="<?php echo $val_tada->ta;
                                  ?>" style="width: 52px;     padding: 2px;">
                              </td>

                              <?php if($datval>=2){  ?>
                                  <td colspan="2">
                                      <input readonly class="form-control pull-right" type="text" name="" id="" value="" style="width: 100%;     padding: 2px;">
                                  </td>
                                  <input type="hidden" name="internet_charge[]" id="internet_charge" value="0">
                                  <input type="hidden" name="da[]" id="da" value="0">
                                  <td>
                                      <input readonly class="form-control pull-right" type="text"
                                             name="totalrow[]"
                                             id="totalrow"
                                             value="<?= $totalrow; ?>" style="width: 62px; padding: 2px;">
                                  </td>
                              <?php } else{ ?>
                              <td>
                                  <input readonly class="form-control pull-right" value="<?php echo $val_tada->da;
                                  ?>" style="width: 52px;     padding: 2px;">
                              </td>
                              <td>
                                  <input readonly class="form-control pull-right" value="<?=$val_tada->postage; ?>" style="width: 52px; padding: 2px;">

                              </td>
                              <td>
                                  <input readonly class="form-control pull-right"
                                         value="<?=$val_tada->total_amount; ?>" style="width: 52px;     padding: 2px;">

                              </td>
                              <?php } ?>

                              <td>
                                  <input readonly class="form-control pull-right" value="<?=$val_tada->aoc_name; ?>">
                              </td>
                              <td>
							  <?php
							  if($val_tada->aoc_amount != NULL){ ?>
								  <input readonly class="form-control pull-right other_amt"
										 value="<?=$val_tada->aoc_amount;
										 ?>" style="padding: 2px; text-align: center;">
							  <?php }else{ ?>
								  <input readonly class="form-control pull-right other_amt"
										 value="" style="padding: 2px; text-align: center;">
								  <?php } ?>
                              </td>


                              <td>
								  <?php if($val_tada->manager_remark){  ?>
									  <input readonly class="form-control mng_amt" name="manage_amt[]"
											 value="<?=$val_tada->manager_remark; ?>" style="padding: 2px;  text-align: center;">
								  <?php }else{ ?>
 								  <input type="number" class="form-control mng_amt" name="manage_amt[]"
										 value="" style="padding: 2px;  text-align: center;">
								  <?php } ?>
                              </td>


                          </tr>
                          <?php    }
                      }

                      /*Sunday -- On Leave --  No Interaction*/
                      if (!in_array($list, $listDate)){  ?>
                          <tr>
                              <td>
                                  <input readonly class="form-control pull-right" type="text" name=""
                                         id="doi" value="<?= $listshow ?>" style="width:
                                   100px;">
                              </td>
                              <?php if($day=='Sun'){  ?>
                                  <td colspan="10" style=" opacity: 0.50;">
                                      <input readonly class="form-control pull-right" type="text" name="source_ci" id="source_city" value="Sunday" style="color:red; text-align: center; width:100%; padding: 2px;
                                            ;">
                                  </td>
                              <?php   }
                              else{ ?>
                                  <td colspan="10" style=" opacity: 0.50;">
                                      <input readonly class="form-control pull-right" type="text" name="source_ci"  id="source_city" value="On Leave / No Interaction" style="color: blue; text-align: center;
                                       width:100%;
                                       padding:
                                       2px;
                                            ;">
                                  </td>
                              <?php  }  ?>
                          </tr>
                      <?php }
                      else if((in_array($list, $listDate)) && ($day=='Sun')){ ?>
                          <tr>
                              <td>
                                  <input readonly class="form-control pull-right" type="text" name="" id="doi" value="<?= $listshow ?>" style="width:
                                   100px;">
                              </td>
                              <td colspan="10" style=" opacity: 0.50;">
                                  <input readonly class="form-control pull-right" type="text" name="source_ci" id="source_city" value="Sunday" style="color:red; text-align: center; width:100%; padding: 2px;">
                              </td>
                          </tr>
                      <?php   }

                  }



                 ?>
				  <tr>
					  <td colspan="4"><strong> TOTAL</strong></td>
					  <td><strong><?=$gtta?></strong></td>
					  <td><strong><?=$gtda?></strong></td>
					  <td style="text-align: center;"><strong><?=$gtpostage?></strong></td>
					  <td colspan="2"><strong><?=$gtrow?></strong>
						  <input type="hidden" name="user" value=" <?= logged_user_data()?>">
						  <input type="hidden" name="grant_total" value=" <?=$gtrow; ?>" >
					  </td>
					  <td style="text-align: center;">

						 <strong id="usr_total"></strong>

					  </td>
					  <td>
						  <input type="text" value="" readonly class="total" style="text-align: center; border: 0;
						  font-weight: 700;">
					  </td>


				  </tr>

                  <tr>
				  <?php
				  $metro_Allwnce=$grand_total- $gtrow;
				  $sumBT = $metro_Allwnce + $gtrow; ?>
				  <input type="hidden" class="totval" style="display: none;" value="<?= $sumBT ?>">
				 <?php

				  if($metro_Allwnce == 1000){
				  ?>
				  <td><strong>GRAND TOTAL</strong></td>
				  <td colspan="11">
				  <strong id="sumgt" style="display: none;" ><?=$metro_Allwnce ?> + <?=$gtrow ?></strong>
				  <strong id="consolidate" style="float: right;"></strong>
				  </td>
				  <tr>
				  <td colspan="12">
					  <strong id="gt_amt" style="display: none;"><?=$metro_Allwnce + $gtrow ?></strong>
					  <input type="text" id="over_amt" readonly value="" style="float: right; text-align: right; border: 0px;  font-weight: 700;">
					  <input type="hidden" id="final_total" name="overall_total" value="">
				  </td>
				  </tr>
                  <?php }
                  else{ ?>
                      <td><strong>GRAND TOTAL</strong></td>
					  <strong id="gt_amt" style="display: none;"><?= $gtrow ?></strong>
				  <?php
				  if(isset($manager_total_amount) && !empty($manager_total_amount)){
				  if($manager_total_amount > 0){ 	?>
				  <td colspan="12">
					  <input name="overall_total" type="text" id="over_amt" readonly value="<?=$manager_total_amount; ?>" style="float: right; text-align: right;  border:0px; font-weight: 700;">
				  </td>
				  <?php }else{ ?>
					  <td colspan="12">
						  <input name="overall_total" type="text" id="over_amt" readonly value="" style="float: right;
						  text-align: right;  border:0px; font-weight: 700;">
					  </td>
				 <?php }
				  } ?>
					  <td colspan="12">
						  <input name="overall_total" type="text" id="over_amt" readonly value="" style="float: right;
						  text-align: right;  border:0px; font-weight: 700;">
					  </td>
                  <?php }
                  ?>
                  </tr>
                              
                              
                </tbody>
              </table>
       	  </div>
      		<div class="row">
              <div class="col-md-12">
                  <!--<div class="form-group">-->
                  <div class="box-footer">
                      <?php // if(!isset($admin_total_amount)){ ?>
      	           <button type="submit" id="submit_manager" class="btn btn-info pull-right">Save</button>
                          <?php echo form_close();  ?>
<!--			  <button id="printReport" onclick="printDiv()" class="btn btn-primary hidden-print"><span class="glyphicon-->
<!--	   glyphicon-print" aria-hidden="true"></span> Print</button>-->
                      <?php// } ?>
                  </div>
              </div>
          </div>
          <!-- /.row -->

  </div>
        <!-- /.box-body -->
</div>
      <!-- /.box -->
</section>
    <!-- /.content -->
</div>

<script type='text/javascript'>
      $(document).ready(function() {
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });
    // function printDiv() {
    //     var divToPrint=document.getElementById('printableTable');
    //     var newWin=window.open('','Print-Window','width=1000,height=800,top=100,left=100');
    //     newWin.document.open();
    //     newWin.document.write('<html><head><style>#in {display:none}</style><body '+'onload="window.print()' +
	// 		'">'+divToPrint.innerHTML+'</body></html>');
    //     newWin.document.close();
    //     setTimeout(function(){newWin.close();},10);
    // }

</script>
