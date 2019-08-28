<!-- jQuery 3 -->
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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <?php echo get_flash(); ?>

    <!-- Main content -->
    <div class="container">

        <table class="table table-hover">
            <thead>
            <?php
            if($period==''){
                ?>
                <h2 style="text-align: center;" class="page-header"> Weekly Report</h2>
                <tr>
                    <th>Name</th>
                    <th>Reporting Manager</th>
                    <th>Designation</th>
                    <th>Total No. of Doctors</th>
                    <th>Secondary Sale </th>
                    <th>Total Productive Call </th>
                    <th>Total Number of Order </th>
                    <th>Total Not Met </th>
                </tr>

            <?php }
            if($period=='month'){  ?>
                <!--For the Month-->
                <h2 style="text-align: center;" class="page-header">Monthly Report</h2>
                <tr>
                    <th>Name</th>
                    <th>Reporting Manager</th>
                    <th>Designation</th>
                    <th>Total No. of Doctors</th>
                    <th>Secondary Sale </th>
                    <th>Total Productive Call </th>
                    <th>Total Number of Order </th>
                    <th>Total Not Met </th>
                </tr>
            <?php }
            if($period=='quarter'){ ?>
                <!--This quarter report-->
                <h2 style="text-align: center;" class="page-header">Quarterly Report</h2>
                <tr>
                    <th>Name</th>
                    <th>Reporting Manager</th>
                    <th>Designation</th>
                    <th>Total No. of Doctors</th>
                    <th>Secondary Sale </th>
                    <th>Total Productive Call </th>
                    <th>Total Number of Order </th>
                    <th>Total Not Met </th>
                </tr>
            <?php }
            if($period=='year'){ ?>
                <h2 style="text-align: center;" class="page-header">Yearly Report</h2>
                <tr>
                    <th>Name</th>
                    <th>Reporting Manager</th>
                    <th>Designation</th>
                    <th>Total No. of Doctors</th>
                    <th>Secondary Sale </th>
                    <th>Total Productive Call </th>
                    <th>Total Number of Order </th>
                    <th>Total Not Met </th>
                </tr>
            <?php }
            ?>
            </thead>
            <tbody>
           <?php
            $ci =&get_instance();
            $ci->load->model('data_report_analysis');
            $ci->load->model('user_model');
            $ci->load->model('doctor/Doctor_model');
            $ci->load->model('report/report_model');
            $userdata =$ci->user_model->users_report();
            $userList=json_decode($userdata);




    foreach($userList as $k => $val){

        $user_SP=getuserSPcode($val->userid);
        $userSP = $user_SP->sp_code;
        $user_name=get_user_name($val->userid);
        $userid=$val->userid;
        $weekly=$period;     // for weekly data
        $get_boss=get_user_boss($val->userid);
        $get_boss_name=get_user_name($get_boss[0]['boss_id']);
        $bossid=$get_boss[0]['boss_id'];
        $get_uid=get_user_id($user_name);
        $get_designation=get_designation_name($get_uid->user_designation_id);  ///

        $total_doctors = $ci->doctor->total_doctor_data($userSP);   /// Total No. of doctors

//        $total_record = total_doctor_interaction($userid);
//pr(count($total_record));
//die;
        $week_secondary = $ci->data_report_analysis->secondary_analysis($weekly,$userSP);
        $week_prodcutive = $ci->data_report_analysis->productive_analysis($weekly,$userSP);
        $week_no_order = $ci->data_report_analysis->noorder_met_analysis($weekly,$userSP);
        $week_not_met = $ci->data_report_analysis->not_met_analysis($weekly,$userSP);
        /*For this week*/
        $weeksecondary_report = json_decode($week_secondary);  //for secondary
        $weekproductive_report = json_decode($week_prodcutive); //for Productive call
        $weeknoroder_report = json_decode($week_no_order);  //for No order but met
        $weeknotmet_report = json_decode($week_not_met);  //for Not met
        /*end for this week*/

        $secondary_month = $ci->data_report_analysis->secondary_analysis('-1 month',$userSP);
        $prodcutive_month = $ci->data_report_analysis->productive_analysis('-1 month',$userSP);
        $no_order_month = $ci->data_report_analysis->noorder_met_analysis('-1 month',$userSP);
        $not_met_month = $ci->data_report_analysis->not_met_analysis('-1 month',$userSP);
        /*For this Month*/
        $secondary_month_report = json_decode($secondary_month);  //for secondary
        $prodcutive_month_report = json_decode($prodcutive_month); //for Productive call
        $no_order_month_report = json_decode($no_order_month);  //for No order but met
        $not_met_month_report = json_decode($not_met_month);  //for Not met
        /*end for this Month*/

        $secondary_quarter = $ci->data_report_analysis->secondary_analysis('-3 month',$userSP);
        $prodcutive_quarter = $ci->data_report_analysis->productive_analysis('-3 month',$userSP);
        $no_order_quarter = $ci->data_report_analysis->noorder_met_analysis('-3 month',$userSP);
        $not_met_quarter = $ci->data_report_analysis->not_met_analysis('-3 month',$userSP);
        /*For this Quarter*/
        $secondary_quarter_report = json_decode($secondary_quarter);  //for secondary
        $productive_quarter_report = json_decode($prodcutive_quarter); //for Productive call
        $no_order_quarter_report = json_decode($no_order_quarter);  //for No order but met
        $not_met_quarter_report = json_decode($not_met_quarter);  //for Not met
        /*end for this Quarter*/

        $secondary_year = $ci->data_report_analysis->secondary_analysis('-1 year',$userSP);
        $prodcutive_year = $ci->data_report_analysis->productive_analysis('-1 year',$userSP);
        $no_order_year = $ci->data_report_analysis->noorder_met_analysis('-1 year',$userSP);
        $not_met_year = $ci->data_report_analysis->not_met_analysis('-1 year',$userSP);
        /*For this Year*/
        $secondary_year_report = json_decode($secondary_year);  // for see Doctor
        $productive_year_report = json_decode($prodcutive_year); // for see Dealer
        $no_order_year_report = json_decode($no_order_year);  // for see Pharma
        $not_met_year_report = json_decode($not_met_year);  // for see Pharma
        /*end for this Year*/

        if($period==''){
            ?><tr>
            <td><?=$user_name ?></td>
            <td><?=$get_boss_name ?></td>
            <td><?=$get_designation->designation_name ?></td>
            <td><?=$total_doctors ?></td>
            <?php if(!empty($weeksecondary_report)){ ?>
                <td><?=$weeksecondary_report->highest->meeting_sale;?></td>
            <?php }else{ ?>
                <td>0</td>
            <?php } ?>
            <?php if(!empty($weekproductive_report)){ ?>
                <td><?=$weekproductive_report->highest->produtive_call;?></td>
            <?php }else{ ?>
                <td>0</td>
            <?php } ?>
            <?php if(!empty($weeknoroder_report)){ ?>
                <td><?=$weeknoroder_report->highest->produtive_call;?></td>
            <?php }else{ ?>
                <td>0</td>
            <?php } ?>

            <?php if(!empty($weeknotmet_report)){ ?>
                <td><?=$weeknotmet_report->highest->produtive_call;?></td>
            <?php }else{ ?>
                <td>0</td>
            <?php } ?>
            </tr>
        <?php }
        if($period=='month'){  ?>
            <!--For the Month-->
              <tr>
               <td><?=$user_name ?></td>
                <?php  if(!empty($secondary_month_report)){ ?>
               <td><?=$secondary_month_report->highest->meeting_sale;?></td>
                <?php }else{ ?>
                    <td>0</td>
                <?php } ?>
                <?php if(!empty($prodcutive_month_report)){ ?>
                      <td><?=$prodcutive_month_report->highest->produtive_call;?></td>
                <?php }else{ ?>
                    <td>0</td>
                <?php } ?>

                <?php if(!empty($no_order_month_report)){ ?>
                 <td><?=$no_order_month_report->highest->produtive_call;?></td>
                <?php } else{ ?>
                     <td>0</td>
                <?php } ?>

                <?php if(!empty($not_met_month_report)){ ?>
                  <td><?=$not_met_month_report->highest->produtive_call;?></td>
                <?php } else{ ?>
                    <td>0</td>
                <?php } ?>
              </tr>
            <!--./ For the Month-->
        <?php }
        if($period=='quarter'){ ?>
          <tr>
              <td><?=$user_name ?></td>
                <?php if(!empty($secondary_quarter_report)){ ?>
                    <td><?=$secondary_quarter_report->highest->meeting_sale;?></td>
                <?php } else{ ?>
                    <td>0</td>
                <?php } ?>
                <?php if(!empty($productive_quarter_report)){ ?>
                    <td><?=$productive_quarter_report->highest->produtive_call;?></td>                         <?php } else{ ?>
                    <td>0</td>
                <?php } ?>
                <?php if(!empty($no_order_quarter_report)){ ?>
                    <td><?=$no_order_quarter_report->highest->produtive_call;?></td>
                <?php } else{ ?>
                       <td>0</td>
                <?php } ?>
                <?php if(!empty($not_met_quarter_report)){ ?>
                    <td><?=$not_met_quarter_report->highest->produtive_call;?></td>                            <?php } else{ ?>
                      <td>0</td>
                <?php } ?>
            </tr>
        <?php }
        if($period=='year'){ ?>
           <tr>
               <td><?=$user_name ?></td>
                <?php if(!empty($secondary_year_report)){ ?>
                   <td><?=$secondary_year_report->highest->meeting_sale;?></td>
                <?php } else{ ?>
                       <td>0</td>
                <?php } ?>
                <?php if(!empty($productive_year_report)){ ?>
                    <td><?=$productive_year_report->highest->produtive_call;?></td>
                <?php } else{ ?>
                    <td>0</td>
                <?php } ?>
                <!-- /.top payment customer -->

                <?php if(!empty($no_order_year_report)){ ?>
                    <td><?=$no_order_year_report->highest->produtive_call;?></td>
                <?php } else{ ?>
                   <td>0</td>
                <?php } ?>

                <?php if(!empty($not_met_year_report)){ ?>
                    <td><?=$not_met_year_report->highest->produtive_call;?></td>
                <?php } else{ ?>
                        <td>0</td>
                <?php } ?>
                <!-- /.Top Secondary Customer -->
            </tr>
        <?php }

      }



                ?>
            </tbody>
        </table>
    </div>

        <iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>


<button id="printReport" onclick="printDiv()" class="btn btn-primary hidden-print"><span class="glyphicon
glyphicon-print" aria-hidden="true"></span> Print</button>

<script type="text/javascript">
    function printDiv() {
        window.frames["print_frame"].document.body.innerHTML = document.getElementById("printableTable").innerHTML;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
    }

</script>