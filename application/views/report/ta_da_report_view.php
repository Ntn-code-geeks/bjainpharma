<?php
$designation_id = get_user_deatils(logged_user_data())->user_designation_id;
$hq= get_user_deatils(logged_user_data())->headquarters_city;
?>
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

<script>
$(document).on("change", ".qty1", function() {
var sum = 0;
$(".qty1").each(function(){
sum += +$(this).val();
});
$(".total").val(sum);

var totalval=$(".totval").text();
var grandtotal= parseFloat(totalval)+parseFloat(sum);

$(".grandtot").val(grandtotal);
$("#gt_total").val(grandtotal);


});

/*
// Nitin kumar 19-07-2019
// Add Metro City Allowance
*/
jQuery(document).ready(function() {

    var totappnd = $('.totval').text();
    $('.grandtot').val(totappnd);
    $("#gt_total").val(totappnd);

    jQuery('#metroAllow').change(function() {
        if ($(this).prop('checked')) {
            $('#allowvalue').append(1000);
            var totalval=$(".grandtot").val();
            var grandtotal= parseFloat(totalval)+parseFloat(1000);
            $(".grandtot").val(grandtotal);
        }
        else {
            $('#allowvalue').remove();
            var totalval=$(".grandtot").val();
            var grandtotal= parseFloat(totalval)-parseFloat(1000);
            $(".grandtot").val(grandtotal);
        }

    });
});
</script>


<div class="content-wrapper">

<!-- Main content -->
<section class="content">

<?php echo get_flash(); ?>

<!-- Contact Add -->
<div class="box box-default">

<div class="box-header with-border">

<h3 class="box-title">Genrate TA/DA Report</h3>

</div>

<!-- /.box-header -->
<div class="box-body" id="printableTable">
<span style="text-align: center !important;">
<?php
$ursname=get_user_deatils(logged_user_data())->name;
$desgID=logged_user_desig();
$usrDesignationID=get_designation_name($desgID);
$userDesgName=$usrDesignationID->designation_name; ?>
<p><strong><?=$ursname.' ('.$userDesgName.')';  ?></strong></p>
<?php
$year=explode('-',$report_date);
$ExDate='1-'.$report_date;
$tdcount=count($tada_report);
@$monthReport= date("F", strtotime($ExDate));
?>
<p><strong>Report Month: </strong><?= $monthReport.'-'.$year[1];?></p>
</span>
<?php echo form_open_multipart($action);?>
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
<th >Miscellaneous Charge Name </th>
<th >Miscellaneous Charge Amount </th>
</tr>
</thead>

<?php
$totalrow=0;
$totalstprow=0;
$gtrow=0;
$gtkms=0;
$gtta=0;
$gtda=0;
$gtpostage=0; $crtddate ='';  $ft=0 ;
$lastdaydestination=0; $source_city=''; $destination_city=''; $interaction_date=''; $date_same='';
$city_same=0;  $userid = logged_user_data();

$mtData = $report_date;
$mtDta = explode('-', $mtData);
$month = $mtDta[0];
$year = $mtDta[1];

$start_date = "01-".$month."-".$year;
$start_time = strtotime($start_date);

$end_time = strtotime("+1 month", $start_time);

for($i=$start_time; $i<$end_time; $i+=86400){
$list = date('Y-m-d', $i);
$listshow = date('d-m-Y', $i);
$day=date('D', $i);    //Day
$listDate=array();
foreach($tada_report as $k=>$val){
// pr($val); die;
$listDate[]=$val['doi'];

//same day interaction postage charges = 0.
$huy=array_count_values($listDate);
$datval=$huy[$val['doi']];

if ($val['doi'] == $list) {
$lastdaydestination = $val['destination_city'];
if($source_city!=$val['source_city'] || $destination_city!=$val['destination_city'] || $interaction_date!=strtotime($val['doi'])){
    $source_city = $val['source_city'];
    $destination_city   = $val['destination_city'];
    $interaction_date = strtotime($val['doi']);
    //
    if($val['destination_city']!=$val['source_city'] || $val['is_stay'] || $ft==0 || $crdate!=$val['doi']) {
        $crdate = $val['doi'];
        $da = 0;
        $hqdistance = 0;
        $nxtdestination = 0;
        $ft = 1;
        $hqdistance = get_distance_hq($userid, $val['meet_id']);
        $is_metro = is_city_metro($val['destination_city']);
        $tpinfo = get_tp_interaction(logged_user_data(), $val['source_city'], $val['destination_city'], $val['doi']);

        $lenght = count($tada_report) - 1;
        $day = date('D', strtotime($val['doi']));

		/**
		 * NITIN KUMAR 24-09-2019
		 * New DA Concept
		 * */
		$userDA=get_userwise_da($val['user_name']);
		if ($k != 0 && $tada_report[$k - 1]['doi'] == $val['doi']) {
				$da=$userDA->hq;
           //$da = 0;
        }
        else {
            if ($val['is_stay'] == 1 && $val['destination_city'] == $lastdaydestination && $hqdistance > 75) {
				$da = $userDA->out_st;
            }
            elseif ($val['is_stay'] != 1 && get_state_id($val['destination_city']) != get_state_id($hq)) {
				$da=$userDA->ex;
            }
            elseif ($hqdistance > 450 && $tpinfo) {
				$da=$userDA->transit ;
            }
            elseif ($val['is_stay'] == 1 && $day == 'Sat') {
            if ($k == $lenght) {
                if (get_state_id($val['destination_city']) != get_state_id($hq)) {
					$da=$userDA->transit + $userDA->out_st;
                } else {
					$da=$userDA->hq;
                }
            } else {
                if (date('D', strtotime($tada_report[$k + 1]['doi'])) == 'Mon' && $tada_report[$k + 1]['destination_city'] == $val['destination_city']) {
					$da=$userDA->transit + $userDA->out_st;
                } else {
                    $da = $userDA->out_st;
                }
            }
        }
        else {

				$da=$userDA->hq;
        }
    }
		/*DA CONCEPT CLOSE HERE*/


        if (date('Y-m-d', strtotime($crtddate)) == date('Y-m-d', strtotime($val['created_date']))) {
            //$val['internet_charge'] = 0;
        }
        $crtddate = $val['created_date'];

        if ($val['is_stp_approved'] == 1) {
            if($datval>=2){
                //$totalrow = $val['stp_ta'] + $da + 0;
                $totalrow = $val['stp_ta'] + 0 + 0;
                //$totalrow = 0 + 0 + 0;
                $gtrow = $gtrow + $totalrow;
                $gtta = $gtta + 0;
                //$gtta = $gtta + $val['stp_ta'];
                //$gtda = $gtda + $da;
                $gtda = $gtda + 0;
                $gtpostage = $gtpostage + 0;
            }else{
                $totalrow = $val['stp_ta'] + $da + $val['internet_charge'];
                $gtrow = $gtrow + $totalrow;
                $gtta = $gtta + $val['stp_ta'];
                $gtda = $gtda + $da;
                $gtpostage = $gtpostage + $val['internet_charge'];
            }

        } else {
            if($datval>=2){
                //$totalrow = $val['ta'] + $da + 0;
                $totalrow = $val['ta'] + 0 + 0;
                //$totalrow = 0 + 0 + 0;
                $gtrow = $gtrow + $totalrow;
                $gtta = $gtta + 0;
                //$gtta = $gtta + $val['ta'];
                //$gtda = $gtda + $da;
                $gtda = $gtda + 0;
                $gtpostage = $gtpostage + 0;
            }else{
                $totalrow = $val['ta'] + $da + $val['internet_charge'];
                $gtrow = $gtrow + $totalrow;
                $gtta = $gtta + $val['ta'];
                $gtda = $gtda + $da;
                $gtpostage = $gtpostage + $val['internet_charge'];
            }

        }
        ?>
        <tr>

            <td>
                <input readonly class="form-control pull-right" type="text" name=""
                       id="doi" value="<?= $listshow ?>" style="width:
   100px;">
     <input type="hidden" name="doi[]" value="<?=$list ?>">

            </td>

            <td>
                <input readonly class="form-control pull-right" type="text"
                       name="source_city[]" id="source_city"
                       value="<?php echo get_city_name($val['source_city']); ?>" style="width:
           125px; padding: 2px;
            ;">

            </td>
            <td>
                <input readonly class="form-control pull-right" type="text"
                       name="destination_city[]" id="destination_city"
                       value="<?php echo get_city_name($val['destination_city']); ?>"
                       style="width: 125px; padding: 2px; ">


                <input type="hidden" name="create_date[]"
                       value="<?php echo $crtddate; ?>">
                <?php if ($val['up_down']) { ?>
                    <input type="hidden" name="back_ho[]"
                           value="<?php echo 'Back HO YES'; ?>">
                <?php } else { ?>
                    <input type="hidden" name="back_ho[]"
                           value="<?php echo 'Back HO NO'; ?>">
                <?php } ?>

            </td>
            <td>
                <?php if ($val['is_stp_approved'] == 1) { ?>
                    <input readonly class="form-control pull-right" type="text"
                           name="distance[]" id="distance"
                           value="<?= $val['stp_distance']; ?>"
                           style="width: 52px;     padding: 2px;">

                <?php } else { ?>
                    <input readonly class="form-control pull-right" type="text"
                           name="distance[]" id="distance"
                           value="<?= $val['distance']; ?>"
                           style="width: 52px;     padding: 2px;">

                <?php } ?>

            </td>
            <td>
                <?php if ($val['is_stp_approved'] == 1) { ?>
                    <input readonly class="form-control pull-right" type="text"
                           name="ta[]"
                           id="ta"
                           value=" <?= $val['stp_ta']; ?>"
                           style="width: 52px;     padding: 2px;">

                <?php } else {
           // if($datval>=2){
                ?>
<!--                    <input readonly class="form-control pull-right" type="text"-->
<!--                           name="ta[]"-->
<!--                           id="ta"-->
<!--                           value="0"-->
<!--                           style="width: 52px;     padding: 2px;">-->

                <?php// }else{ ?>
            <input readonly class="form-control pull-right" type="text"
                   name="ta[]"
                   id="ta"
                   value="<?= $val['ta']; ?>"
                   style="width: 52px;     padding: 2px;">


               <?php //  }
    } ?>
            </td>


            <?php if($datval>=2){  ?>
                <td colspan="2">
                    <input readonly class="form-control pull-right" type="text" name=""
                           id=""
                           value="" style="width: 100%;     padding: 2px;">
                </td>
                <input type="hidden" name="internet_charge[]" id="internet_charge" value="0">
                <input type="hidden" name="da[]" id="da" value="0">
                <td>
                    <input readonly class="form-control pull-right" type="text"
                           name="totalrow[]"
                           id="totalrow"
                           value="<?= $totalrow; ?>" style="width: 62px; padding: 2px;">

                </td>


            <?php }
            else{ ?>
                <td>
                    <input readonly class="form-control pull-right" type="text" name="da[]"
                           id="da"
                           value="<?= $da; ?>" style="width: 52px;     padding: 2px;">
                </td>
                <td>
                    <input readonly class="form-control pull-right" type="text"
                           name="internet_charge[]" id="internet_charge"
                           value="<?= $val['internet_charge']; ?>"
                           style="width: 52px;     padding: 2px;">

                </td>
                <td>
                    <input readonly class="form-control pull-right" type="text"
                           name="totalrow[]"
                           id="totalrow"
                           value="<?= $totalrow; ?>" style="width: 62px; padding: 2px;">

                </td>
            <?php } ?>

            <td>
                <input class="form-control pull-right" type="text" name="aoc_name[]"
                       value="">
            </td>
            <td>

                <input class="form-control pull-right qty1" type="number" name="aoc_amount[]"
                       value="">
            </td>
        </tr>
    <?php }
}
}   ?>
<?php  }   ?>

<?php
if (!in_array($list, $listDate)){  ?>
<tr>
<td>
   <input readonly class="form-control pull-right" type="text" name="" id="doi" value="<?= $listshow ?>" style="width:
   100px;">
</td>
<?php if($day=='Sun'){    ?>
    <td colspan="9" style=" opacity: 0.50;">
        <input readonly class="form-control pull-right" type="text" name="source_ci"
               id="source_city"
               value="Sunday" style="color:red; text-align: center; width:100%; padding: 2px;
            ;">
    </td>
<?php   }else{

	if(in_array($list,$date_gz_holiday)){
		foreach($gazetted_holidays as $gz){
			$gz_name=explode(';',$gz);
			if($gz_name[0]==$list){ ?>
			<td colspan="9" style=" opacity: 0.50;">
			<input readonly class="form-control pull-right" type="text" name="source_ci"  id="source_city"
				   value="<?=$gz_name[1] ?>" style="color: red; text-align: center; width:100%;  padding: 2px;">
				</td>
		<?php	}
		}
	}else{
		if(!empty($tripDateList)) {
			if (in_array($list, $tripDateList)) { ?>
				<td colspan="9" style=" opacity: 0.50;">
					<input readonly class="form-control pull-right" type="text" name="source_ci" id="source_city"
						   value="<?= $tripName ?>" style="color: red; text-align: center; width:100%;  padding: 2px;">
				</td>
			<?php }else{ ?>
				<td colspan="9" style=" opacity: 0.50;">
					<input readonly class="form-control pull-right" type="text" name="source_ci"  id="source_city"
						   value="On Leave / No Interaction" style="color: blue; text-align: center; width:100%;
       padding: 2px;">
				</td>
		<?php	}
		}else{
			$holiday=get_holiday_details($list);
			if(!empty($holiday)){
				$usersID=explode(',',$holiday->user_ids);
				$hol_user=get_check_active_users($usersID);
				if(in_array(logged_user_data(),$hol_user)){  ?>
				<td colspan="9" style=" opacity: 0.50;">
					<input readonly class="form-control pull-right" type="text" name="source_ci" id="source_city"
						   value="<?= $holiday->remark; ?>" style="color: red; text-align: center; width:100%;
						   padding: 2px;">
				</td>

			<?php	}else{ ?>
				<td colspan="9" style=" opacity: 0.50;">
					<input readonly class="form-control pull-right" type="text" name="source_ci"  id="source_city"
						   value="On Leave / No Interaction" style="color: blue; text-align: center; width:100%;
   padding: 2px;">
				</td>
			<?php	}
			}else{ ?>
				<td colspan="9" style=" opacity: 0.50;">
					<input readonly class="form-control pull-right" type="text" name="source_ci"  id="source_city"
						   value="On Leave / No Interaction" style="color: blue; text-align: center; width:100%;
       padding: 2px;">
				</td>
			<?php }
			} ?>

<?php	}
	}  ?>


</tr>

<?php }

} ?>

<tr>
<td colspan="4"><strong> TOTAL</strong></td>
<td><strong><?=$gtta?></strong></td>
<td><strong><?=$gtda?></strong></td>
<td style="text-align: center; "><strong><?=$gtpostage?></strong></td>
<td style="text-align: -webkit-right;"><strong class="totval"><?=$gtrow?></strong>
<input type="hidden" name="report_date" value=" <?=$report_date?>">
<input type="hidden" name="user" value=" <?= logged_user_data()?>">
<input type="hidden" name="grant_total" id="gt_total" value="">
</td>
<td colspan="2" style="text-align: -webkit-center;"><input readonly type="text" class="total" value="" style="border: 0px;
font-weight: bold; text-align: right;"></td>

</tr>
<br>

    <?php
    $userID=logged_user_data();
    $hq=get_logged_hq($userID);
    $cityID=$hq->hq_city;
    if(is_city_metro($cityID)==1){?>
        <tr>
            <td colspan="2">
                <label>Metro City Allowance: </label>
                <input type="checkbox" name="metroAllow" id="metroAllow" value="1" style="height: 20px; width: 30px;
                position:
                 relative; top: 4px;
"></td>
            <td colspan="8" style="text-align: right; font-weight: bold; padding: 20px;" id="allowvalue"> </td>
        </tr>
    <?php  }
    ?>

<br>
<hr>
<tr>
<td colspan="2"><strong>GRAND TOTAL</strong></td>


<td colspan="8" style="text-align: right;">
	<input readonly type="text" class="grandtot" value="" style="border: 0px;
font-weight: bold; text-align: right;"></td>
</tr>




</tbody>
</table>
<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
</div>
<div class="row">
<div class="col-md-12">
<!--<div class="form-group">-->
<div class="box-footer">
<button type="submit" class="btn btn-info pull-right">Save</button>
<?php echo form_close();  ?>
	<a href="<?=$_SERVER['HTTP_REFERER']?>"><button class="btn btn-danger" style="margin-right: 15px;
			margin-left: 10px;">Back</button></a>
<button id="printReport" onclick="printDiv()" class="btn btn-primary hidden-print"><span class="glyphicon
glyphicon-print" aria-hidden="true"></span> Print</button>
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


<script type="text/javascript">

    $(document).ready(function() {
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });
function printDiv() {
window.frames["print_frame"].document.body.innerHTML = document.getElementById("printableTable").innerHTML;
window.frames["print_frame"].window.focus();
window.frames["print_frame"].window.print();
}

</script>
