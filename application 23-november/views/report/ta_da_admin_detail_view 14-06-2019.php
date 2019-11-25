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
                  foreach ($tada_data as $k_tada=>$val_tada){   

                $gtrow = $gtrow+$val_tada->total_amount;
                $gtta = $gtta+$val_tada->ta;
                $gtda = $gtda+$val_tada->da;
                $gtpostage = $gtpostage+$val_tada->postage;
                  ?>
                            <tr>
                                <td>
                                      <input readonly class="form-control pull-right" value="<?php echo date('d-m-Y',
                                          $val_tada->ineraction_date);?> " style="width:
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
                                 
                                 <td>
                                     <input readonly class="form-control pull-right" value="<?=$val_tada->aoc_name; ?>">
                                 </td>
                                 
                                 <td>
                                     <input readonly class="form-control pull-right" value="<?=$val_tada->aoc_amount;
                                     ?>" style="width: 52px;     padding: 2px;">
                                 </td>
                                 
                                 
                                 <td>
                                     <input  class="form-control pull-right"
                                            value="<?=$val_tada->manager_remark; ?>" style="width: 52px;     padding: 2px;">
                                 
                                 </td>
                                 
                                 <td>
                                     <?php if(isset($admin_total_amount) && !empty($admin_total_amount)){ ?>
                                         <input readonly class="form-control pull-right"
                                         value="<?=$val_tada->admin_remark; ?>" style="width: 52px;     padding: 2px;">
                                   <?php  }else{ ?>
                                     <input type="number" name="admin_remark[]" value="" style="width: 52px;     padding: 2px;">
                                     <?php } ?>
                                 
                                 </td>
                               
                              </tr>
                             <?php
                  
          } ?>
                              <tr>
                                  <td colspan="4"><strong>GRANT TOTAL</strong></td>
                                  <td><strong><?=$gtta?></strong></td>
                                  <td><strong><?=$gtda?></strong></td>
                                  <td style="text-align: center;"><strong><?=$gtpostage?></strong></td>
                                  <td colspan="3"><strong><?=$gtrow?></strong>

                                      <input type="hidden" name="user" value=" <?= logged_user_data()?>">
                                      <input type="hidden" name="grant_total" value=" <?=$gtrow; ?>" >
                                  </td>
                                  <td> <?php if(isset($manager_total_amount) && !empty($manager_total_amount)){ ?>
                                             <strong><?=$manager_total_amount; ?> </strong>
                                            <?php  }else{ ?>
                                      <input type="text" name="manager_grant_total" value="" required="" style="width:52px;    padding: 2px;">
                                            <?php } ?>
                                  </td>
                                   <td> <?php if(isset($admin_total_amount) && !empty($admin_total_amount)){ ?>
                                             <strong><?=$admin_total_amount; ?> </strong>
                                            <?php  }else{ ?>
                                      <input type="text" name="admin_grant_total" value="" required="" style="width:52px; padding: 2px;">
                                            <?php } ?>
                                  </td>
                                  
                              </tr>
                              
                              
                </tbody>
              </table>
       	  </div>
      		<div class="row">
              <div class="col-md-12">
                  <!--<div class="form-group">-->
                  <div class="box-footer">
                      <?php  if(!isset($admin_total_amount)){ ?>
      	           <button type="submit" class="btn btn-info pull-right">Save</button>
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
    function printDiv() {

        var divToPrint=document.getElementById('printableTable');
        var newWin=window.open('','Print-Window','width=900,height=500,top=100,left=100');
        newWin.document.open();
        newWin.document.write('<html><head><style>#in {display:none}</style><body   onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
        newWin.document.close();
        setTimeout(function(){newWin.close();},10);
    }
</script>