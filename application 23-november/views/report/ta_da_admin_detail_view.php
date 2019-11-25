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
<script>
    jQuery(document).ready(function() {
        var total = 0;
        /*User's change*/
        $('.other_amt').each(function() {
            var other_amount=$(this).val();
            if(other_amount != ''){
                total += Number($(this).val());
            }
        });

        var ttal = 0;
        /* manager's change*/
        $('.mgr_amot').each(function() {
            var othr_amount=$(this).val();
            if(othr_amount != ''){
                ttal += Number($(this).val());
            }
        });

        var af_total = 0;
        /*Admin's change*/
        $('.af_mg_amt').each(function() {
            var oth_amount=$(this).val();
            if(oth_amount != ''){
                af_total += Number($(this).val());
            }
        });

        var mng_commited= $('#over_amt').val();
        var totamot = $('#mg_tot').text();
        // console.log(total+' '+ttal+ ' ' +af_total );

        if(total != '' && ttal == '' && af_total > 0){
            var mg_total=parseFloat(totamot) + parseFloat(total) + parseFloat(af_total);
            var dif_commit= mng_commited - mg_total + parseFloat(af_total);
            if(dif_commit == 1000 ){
                $('#tot_amot').text('1000 + '+mg_total);
			}else{
                $('#tot_amot').text(mg_total);
			}
		}
        if(total == '' && ttal != '' && af_total > 0){
            var mg_total=parseFloat(totamot) + parseFloat(ttal) + parseFloat(af_total);
            var dif_commit= mng_commited - mg_total + parseFloat(af_total);
            if(dif_commit == 1000 ){
                $('#tot_amot').text('1000 + '+mg_total);
            }else{
                $('#tot_amot').text(mg_total);
            }
        }
        if(total != '' && ttal != '' && af_total > 0){
            var mg_total=parseFloat(totamot) + parseFloat(total) + parseFloat(ttal) + parseFloat(af_total);
            var dif_commit= mng_commited - mg_total + parseFloat(af_total);
            if(dif_commit == 1000 ){
                $('#tot_amot').text('1000 + '+mg_total);
            }else{
                $('#tot_amot').text(mg_total);
            }
		}

        if(total != '' && ttal =='' && af_total =='' ){
            var mg_total=parseFloat(totamot) + parseFloat(total) ;
            var dif_commit= mng_commited - mg_total;
            if(dif_commit == 1000 ){
                $('#tot_amot').text('1000 + '+mg_total);
            }else{
                $('#tot_amot').text(mg_total);
            }
        }


        $('#aft_submit_adm').text(af_total);
		$('#usr_amt').val(parseFloat(total));
        $('#mngr_amt').val(parseFloat(ttal));
    });


    $(document).on("change", ".mng_amt", function() {
        var sum = 0;
        $(".mng_amt").each(function(){
            sum += +$(this).val();
            var user_imp=$('#over_amt').val();
            var grandtotal= parseFloat(user_imp)+parseFloat(sum);
            $("#tot_amot").text(grandtotal);
        });
        $(".total").val(sum);
    });

    $(document).on("click", "#save_final", function() {
		var final_amt = $('#tot_amot').text();
		$('#over_amt').val(final_amt);
    });

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
    @media print {
        * {
            display: none;
        }
        #printableTable {
            display: block;
        }
    }
</style>


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
                        <th>Admin Total Amount </th>
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
                                        <input readonly class="form-control pull-right other_amt"
											   value="<?=$val_tada->aoc_amount;
                                        ?>" style=" padding: 2px;">
                                    </td>


                                    <td>
                                        <input readonly class="form-control pull-right mgr_amot" name="manager_remark[]"
                                                value="<?=$val_tada->manager_remark; ?>" style="padding: 2px;">
                                    </td>

                                    <td>
                                     <?php if(isset($admin_total_amount) && !empty($admin_total_amount)){ ?>
                                        <input readonly name="admin_remark[]" class="form-control pull-right af_mg_amt"
                                                   value="<?=$val_tada->admin_remark; ?>" style="padding: 2px;">
                                        <?php  }else{ ?>
                                        <input type="number" class="form-control pull-right mng_amt" name="admin_remark[]" value=""  style="padding:2px;">
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
                                    <td colspan="11" style=" opacity: 0.50;">
                                        <input readonly class="form-control pull-right" type="text" name="source_ci" id="source_city" value="Sunday" style="color:red; text-align: center; width:100%; padding: 2px;
                                            ;">
                                    </td>
                                <?php   }else{ ?>
                                    <td colspan="11" style=" opacity: 0.50;">
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
                                <td colspan="11" style=" opacity: 0.50;">
                                    <input readonly class="form-control pull-right" type="text" name="source_ci" id="source_city" value="Sunday" style="color:red; text-align: center; width:100%; padding: 2px;">
                                </td>
                            </tr>
                        <?php   }

                    }



                    ?>
                    <tr>
                        <td colspan="4"><strong> TOTAL</strong></td>
                        <td><strong><?php //echo $gtta?></strong></td>
                        <td><strong><?php //echo $gtda?></strong></td>
                        <td style="text-align: center;"><strong><?php //echo $gtpostage?></strong></td>
                        <td colspan="2"><strong id="mg_tot"><?=$gtrow?></strong>
                            <input type="hidden" name="user" value=" <?= logged_user_data()?>">
                            <input type="hidden" name="grant_total" value=" <?=$gtrow; ?>" >
                        </td>
						<td><input type="text" class="form-control pull-right" id="usr_amt" value="" style="border:
						0; font-weight: 600;"></td>
                        <td> <?php if(isset($manager_total_amount) && !empty($manager_total_amount) && !empty($gtrow)){
                                ?>
<!--                                <strong>--><?//=$manager_total_amount; ?><!-- </strong>-->
								<input type="text" class="form-control pull-right" id="mngr_amt" value="" style="border:
						0; font-weight: 600;">
                            <?php }else{ ?>
                                <input type="text" class="form-control pull-right" name="manager_grant_total" value="" style="border:	0; font-weight: 600;">
                            <?php } ?>
                        </td>
                        <td> <?php if(isset($admin_total_amount) && !empty($admin_total_amount) && !empty($gtrow)){ ?>
<!--                                <strong id="aft_submit_adm">--><?//=$admin_total_amount; ?><!-- </strong>-->
								<strong id="aft_submit_adm"></strong>
                            <?php  }else{ ?>
                                <input type="text" class="form-control pull-right total" name="admin_grant_total"
									   value="" style="border:0; padding:2px; text-align: center; font-weight: 600;">
                            <?php } ?>
                        </td>

                    </tr>


					<tr>
						<?php if($manager_total_amount){ ?>
						<td><strong>GRAND TOTAL</strong></td>
						<td colspan="11"><strong id="tot_amot" style="float: right;"><?=$manager_total_amount ?></strong></td>
						<input type="hidden" name="overall_amt" id="over_amt" value="<?=$manager_total_amount ?>">
						<?php }else{ ?>
						<td><strong>GRAND TOTAL</strong></td>
						<td colspan="11"><strong id="tot_amot" style="float: right;"><?=$grand_total; ?></strong></td>
						<input type="hidden" name="overall_amt" id="over_amt" value="<?=$grand_total; ?>">
						<?php } ?>
					</tr>


                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!--<div class="form-group">-->
                    <div class="box-footer">
                        <?php  if(!isset($admin_total_amount)){ ?>
                            <button type="submit" id="save_final" class="btn btn-info pull-right">Save</button>
                            <?php echo form_close();  ?>
                            <button id="printReport" onclick="printDiv()" class="btn btn-primary hidden-print"><span class="glyphicon
                   glyphicon-print" aria-hidden="true"></span> Print</button>
                        <?php } ?>
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

    function printDiv() {
        var divToPrint=document.getElementById('printableTable');
        var newWin=window.open('','Print-Window','width=900,height=500,top=100,left=100');
        newWin.document.open();
        newWin.document.write('<html><head><style>#in {display:none}</style><body   onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
        newWin.document.close();
        setTimeout(function(){newWin.close();},10);
    }
</script>
