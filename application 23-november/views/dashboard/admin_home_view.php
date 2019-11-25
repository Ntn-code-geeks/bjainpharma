<?php

/*
 * Developer: Shailesh Saraswat
 * Email: sss.shailesh@gmail.com
 * Dated: 28-DEC-2018
 *
 * Dashboard for admin and for the Boss(like: ASM/DSM etc)
 */

/*For this week*/
$weeksecondary_report = json_decode($week_secondary);  //for secondary
$dealer_week_secondary=json_decode($dealer_secondary_week);
$visit_week=json_decode($visit_weekly);
//        $weekproductive_report = json_decode($week_prodcutive); //for Productive call
//        $weeknoroder_report = json_decode($week_no_order);  //for No order but met
//        $weeknotmet_report = json_decode($week_not_met);  //for Not met
/*end for this week*/

/*For this Month*/
$secondary_month_report = json_decode($secondary_month);  //for secondary
$dealer_month_secondary=json_decode($dealer_secondary_month);
$visit_month=json_decode($visit_monthly);
//        $prodcutive_month_report = json_decode($prodcutive_month); //for Productive call
//        $no_order_month_report = json_decode($no_order_month);  //for No order but met
//        $not_met_month_report = json_decode($not_met_month);  //for Not met
/*end for this Month*/

/*For this Quarter*/
$secondary_quarter_report = json_decode($secondary_quarter);  //for secondary
$dealer_quart_secondary=json_decode($dealer_secondary_quart);
$visit_quarter=json_decode($visit_quart);
//pr($visit_quarter); die;
//        $productive_quarter_report = json_decode($prodcutive_quarter); //for Productive call
//        $no_order_quarter_report = json_decode($no_order_quarter);  //for No order but met
//        $not_met_quarter_report = json_decode($not_met_quarter);  //for Not met
/*end for this Quarter*/

/*For this Year*/
$secondary_year_report = json_decode($secondary_year);  // for see Doctor
$dealer_year_secondary=json_decode($dealer_secondary_year);
$visit_year=json_decode($visit_yearly);
//     $productive_year_report = json_decode($prodcutive_year); // for see Dealer
//     $no_order_year_report = json_decode($no_order_year);  // for see Pharma
//     $not_met_year_report = json_decode($not_met_year);  // for see Pharma
/*end for this Year*/


//pr($sales_report); die;
?>
<!-- jQuery 3 -->
<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<script src="<?= base_url()?>design/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>design/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>
<script type="text/javascript">
    $(function(){
        $(".search").keyup(function()
        {
//    alert('demo');
            var searchid = $(this).val();
            var dataString = 'search='+ searchid;

            if(searchid!='')
            {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url()?>global_search/search_suggestion",
                    data: dataString,
                    cache: false,
                    success: function(html)
                    {
                        $("#result").html(html).show();
                    }
                });
            }return false;
        });

        jQuery("#result").click(function(e){

            var $clicked = $(e.target);
            var $name = $clicked.find('.name').html();

            var decoded = $("<div/>").html($name).text();
//        alert(decoded);
            $('#searchid').val(decoded);
        });
        jQuery(document).click(function(e) {
//      alert("hello");
            var $clicked = $(e.target);
            if (! $clicked.hasClass("search")){
                jQuery("#result").fadeOut();
            }
        });
        $('#searchid').click(function(){

            jQuery("#result").fadeIn();
        });
    });
</script>
<style type="text/css">
	#searchid
	{
		/*width:500px;*/
		/*border:solid 1px #000;*/
		padding:10px;
		font-size:14px;
	}
	#result
	{
		position:absolute;
		width:100%;
		padding:10px;
		display:none;
		margin-top:-1px;
		border-top:0px;
		overflow:hidden;
		border:1px #CCC solid;
		background-color: white;
		z-index: 999;
		margin-top: 32px;
		max-height: 300px;
		overflow-y: auto;
	}
	.show
	{
		padding:10px;
		border-bottom:1px #999 dashed;
		font-size:15px;
		height:50px;
	}
	.show:hover
	{
		background:#4c66a4;
		color:#FFF;
		cursor:pointer;
	}

	@media  only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
		/*
		Label the data
		*/
		td:nth-of-type(1):before { content: "Name"; }
		td:nth-of-type(2):before { content: "Reporting Manager"; }
		td:nth-of-type(3):before { content: "Designation"; }
		td:nth-of-type(4):before { content: "Total No. of Doctors"; }
		td:nth-of-type(5):before { content: "Secondary Sale"; }
		td:nth-of-type(6):before { content: "Total Productive Call"; }
		td:nth-of-type(7):before { content: "Total Number of Order"; }
		td:nth-of-type(8):before { content: "Total Not Met"; }
	}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Dashboard
			<!--<small>Booklings</small>-->
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Dashboard</li>
		</ol>
	</section>

	<?php echo get_flash(); ?>

	<!-- Main content -->
	<section class="content">
		<!-- Info boxes -->
		<div class="row">



			<div class="col-md-12 col-lg-12 col-lg-12 col-xs-12">
				<div class="box-tools" style="margin-top: 10px;margin-bottom: 10px;">

				</div>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12">
				<a href="<?= base_url();?>interaction/index/"><div class="info-box">
						<span class="info-box-icon bg-green"><i class="fa fa-handshake-o" aria-hidden="true"></i></span>

						<div class="info-box-content">
							<span class="info-box-text" style="padding: 20px">Interaction</span>
							<!--<span class="info-box-number">760</span>-->
						</div>
						<!-- /.info-box-content -->
					</div></a>
				<!-- /.info-box -->
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12">
				<a href="<?= base_url();?>interaction/customer_list/">
					<div class="info-box">
						<span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
						<div class="info-box-content">
							<span class="info-box-text" style="padding: 20px">Customer</span>
							<!--<span class="info-box-number">90<small>%</small></span>-->
						</div>
						<!-- /.info-box-content -->
					</div>
				</a>
				<!-- /.info-box -->
			</div>

			<div class="col-md-3 col-sm-6 col-xs-12">
				<a href="<?= base_url();?>meeting/meeting/interact_with_ho"><div class="info-box">
						<span class="info-box-icon bg-red"><i class="fa fa-envelope" aria-hidden="true"></i></span>

						<div class="info-box-content">
							<span class="info-box-text" style="padding: 16px;white-space: normal!important">Interaction with HO</span>
							<!--<span class="info-box-number">41,410</span>-->
						</div>
						<!-- /.info-box-content -->
					</div></a>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->

			<div class="col-md-3 col-sm-6 col-xs-12">
				<a href="<?= base_url();?>tour_plan/tour_plan"><div class="info-box">
						<span class="info-box-icon bg-yellow"><i class="fa fa-bus" aria-hidden="true"></i></span>
						<div class="info-box-content">
							<span class="info-box-text" style="padding: 20px">Tour Plan</span>
							<!--<span class="info-box-number">41,410</span>-->
						</div>
						<!-- /.info-box-content -->
					</div></a>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->

		</div>
		<!-- /.row -->


		<h2 class="page-header">Customer Analysis</h2>

		<div class="nav-tabs-custom">

			<ul class="nav nav-tabs">
				<li class="active"><a href="#week" data-toggle="tab" aria-expanded="true">Week</a></li>
				<li class=""><a href="#month" data-toggle="tab" aria-expanded="false">Month</a></li>
				<li class=""><a href="#quarter" data-toggle="tab" aria-expanded="false">This Quarter</a></li>
				<li class=""><a href="#year" data-toggle="tab" aria-expanded="false">This Year</a></li>
			</ul>
			<div class="tab-content">
				<div class="row tab-pane active" id="week">
					<?php if(!empty($weeksecondary_report)){ ?>
						<!--Top sales Customer-->
						<div class="col-md-4">
							<!-- Widget: user widget style 1 -->
							<div class="box box-widget widget-user-2">
								<!-- Add the bg color to the header using any of the bg-* classes -->
								<div class="widget-user-header bg-yellow" style="border-radius: 15px;">
									<div class="widget-user-image">
										<h4 style="border-bottom: 1px solid;">Doctor Analysis</h4>
										<img src="<?= base_url()?>design/img/analysis/total_sale.png" alt=""/>

									</div>
									<!-- /.widget-user-image -->
									<h3 class="widget-user-username">Secondary Sale this Week</h3>
									<!--<h5 class="widget-user-desc">1st Sales</h5>-->
								</div>
								<div class="box-footer no-padding">
									<ul class="nav nav-stacked">
										<?php if($weeksecondary_report->weekly[0]->secondary > 0){ ?>
											<li><a href="#">1st Highest <span class="pull badge bg-blue"><?=substr
														($weeksecondary_report->weekly[0]->username,0,11);?></span><span class="pull-right badge bg-green"><?=$weeksecondary_report->weekly[0]->secondary;?></span></a></li>
										<?php } ?>

										<?php if($weeksecondary_report->weekly[1]->secondary > 0){ ?>
											<li><a href="#">2nd Highest <span class="pull badge bg-blue"><?=substr
														($weeksecondary_report->weekly[1]->username,0,11);?></span><span class="pull-right
    badge bg-green"><?=$weeksecondary_report->weekly[1]->secondary;?></span></a></li>
										<?php } ?>

										<?php if($weeksecondary_report->weekly[2]->secondary > 0){ ?>
											<li><a href="#">3rd Highest <span class="pull badge bg-blue"><?=substr
														($weeksecondary_report->weekly[2]->username,0,11);?></span><span class="pull-right
    badge bg-green"><?=$weeksecondary_report->weekly[2]->secondary;?></span></a></li>
										<?php } ?>


										<?php if($weeksecondary_report->low_week[0]->secondary > 0){ ?>
											<li><a href="#">1st Lowest <span class="pull badge bg-blue"><?=substr
														($weeksecondary_report->low_week[0]->username,0,11);?></span><span class="pull-right badge
    bg-green"><?=$weeksecondary_report->low_week[0]->secondary;?></span></a></li>
										<?php } ?>
										<?php if($weeksecondary_report->low_week[1]->secondary > 0){ ?>
											<li><a href="#">2nd Lowest <span class="pull badge bg-blue"><?=substr
														($weeksecondary_report->low_week[1]->username,0,11);?></span><span class="pull-right
    badge bg-green"><?=$weeksecondary_report->low_week[1]->secondary;?></span></a></li>
										<?php } ?>
										<?php if($weeksecondary_report->low_week[2]->secondary > 0){ ?>
											<li><a href="#">3rd Lowest <span class="pull badge bg-blue"><?=substr
														($weeksecondary_report->low_week[2]->username,0,11);?></span><span class="pull-right
    badge bg-green"><?=$weeksecondary_report->low_week[2]->secondary;?></span></a></li>
										<?php } ?>

									</ul>

								</div>
							</div>
							<!-- /.widget-user -->
						</div>
					<?php } ?>
					<!-- / Top sales Customer -->
					<?php if(!empty($dealer_week_secondary->top) && !empty($dealer_week_secondary->least)){
						//pr($dealer_week_secondary); ?>
						<!--Top Payment Customer-->
						<div class="col-md-4">
							<!-- Widget: user widget style 1 -->
							<div class="box box-widget widget-user-2">
								<!-- Add the bg color to the header using any of the bg-* classes -->
								<div class="widget-user-header bg-aqua-active" style="border-radius: 15px;">
									<div class="widget-user-image">
										<h4 style="border-bottom: 1px solid;">Dealers Analysis</h4>

										<img src="<?= base_url()?>design/img/analysis/payment.png" alt=""/>
										<!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
									</div>
									<!-- /.widget-user-image -->
									<h3 class="widget-user-username">Secondary Sale this Week</h3>
									<!--<h5 class="widget-user-desc">1st Payment</h5>-->
								</div>
								<div class="box-footer no-padding">
									<ul class="nav nav-stacked">
										<?php if($dealer_week_secondary->top[0]->secondary_amt > 0){ ?>
											<li><a href="#">1st Highest <span class="pull badge bg-blue"><?=substr ($dealer_week_secondary->top[0]->dealer_name,0,11);?></span><span  class="pull-right badge bg-green"><?=$dealer_week_secondary->top[0]->secondary_amt; ?></span></a></li>
										<?php } ?>
										<?php if($dealer_week_secondary->top[1]->secondary_amt > 0){ ?>
											<li><a href="#">2nd Highest <span class="pull badge bg-blue"><?=substr
														($dealer_week_secondary->top[1]->dealer_name,0,11);?></span><span  class="pull-right
                   badge bg-green"><?=$dealer_week_secondary->top[1]->secondary_amt; ?></span></a></li>
										<?php } ?>
										<?php if($dealer_week_secondary->top[2]->secondary_amt > 0){ ?>
											<li><a href="#">3rd Highest <span class="pull badge bg-blue"><?=substr
														($dealer_week_secondary->top[2]->dealer_name,0,11);?></span><span  class="pull-right
                   badge bg-green"><?=$dealer_week_secondary->top[2]->secondary_amt; ?></span></a></li>
										<?php } ?>

										<?php if($dealer_week_secondary->least[0]->secondary_amt > 0){ ?>
											<li><a href="#">1st Lowest <span class="pull badge bg-blue"><?=substr
														($dealer_week_secondary->least[0]->dealer_name,0,11);?></span><span
														class="pull-right badge bg-green"><?=$dealer_week_secondary->least[0]->secondary_amt;?></span></a></li>
										<?php } ?>
										<?php if($dealer_week_secondary->least[1]->secondary_amt > 0){ ?>
											<li><a href="#">2nd Lowest <span class="pull badge bg-blue"><?=substr($dealer_week_secondary->least[1]->dealer_name,0,
															11);?></span><span class="pull-right badge bg-green"><?=$dealer_week_secondary->least[1]->secondary_amt;
														?></span></a></li>
										<?php } ?>
										<?php if($dealer_week_secondary->least[2]->secondary_amt > 0){ ?>
											<li><a href="#">3rd Lowest <span class="pull badge bg-blue"><?=substr($dealer_week_secondary->least[2]->dealer_name,0,
															11);?></span><span class="pull-right badge bg-green"><?=$dealer_week_secondary->least[2]->secondary_amt;
														?></span></a></li>
										<?php } ?>
									</ul>

								</div>
							</div>
							<!-- /.widget-user -->
						</div>
					<?php } ?>
					<!-- /.top payment customer -->

					<?php if(!empty($visit_week->min_visit) && !empty($visit_week->max_visit)){ ?>
						<!--Top Secondary Customer-->
						<div class="col-md-4">
							<!-- Widget: user widget style 1 -->
							<div class="box box-widget widget-user-2">
								<!-- Add the bg color to the header using any of the bg-* classes -->
								<div class="widget-user-header bg-green active" style="border-radius: 15px;">
									<div class="widget-user-image">
										<h4 style="border-bottom: 1px solid;">Visits Analysis</h4>
										<img src="<?= base_url()?>design/img/analysis/secondary_sales.png" alt=""/>
										<!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
									</div>
									<!-- /.widget-user-image -->
									<h3 class="widget-user-username">Number of visits this week</h3>
									<!--<h5 class="widget-user-desc">1st Sales</h5>-->
								</div>
								<div class="box-footer no-padding">
									<ul class="nav nav-stacked">
										<li><a href="#">Maximum <span class="pull badge bg-blue"><?=substr
													(get_doctor_name($visit_week->doc_max),0,11);?></span><span class="pull-right badge
                   bg-green"><?=$visit_week->max_visit;?></span></a></li>
										<li><a href="#">Minimum <span class="pull badge bg-blue"><?=substr
													(get_doctor_name($visit_week->doc_min),0,11);?></span><span class="pull-right badge
                  bg-green"><?=$visit_week->min_visit;?></span></a></li>

									</ul>

								</div>
							</div>
							<!-- /.widget-user -->
						</div>
					<?php } ?>


				</div>

				<!--For the Month-->
				<div class="row tab-pane" id="month">
					<?php if(!empty($secondary_month_report)){  ?>
						<!--Top sales Customer-->
						<div class="col-md-4">
							<!-- Widget: user widget style 1 -->
							<div class="box box-widget widget-user-2">
								<!-- Add the bg color to the header using any of the bg-* classes -->
								<div class="widget-user-header bg-yellow" style="border-radius: 15px;">
									<div class="widget-user-image">
										<h4 style="border-bottom: 1px solid;">Doctor Analysis</h4>
										<img src="<?= base_url()?>design/img/analysis/total_sale.png" alt=""/>

									</div>
									<!-- /.widget-user-image -->
									<h3 class="widget-user-username">Secondary Sale this Month</h3>
									<!--<h5 class="widget-user-desc">1st Sales</h5>-->
								</div>
								<div class="box-footer no-padding">
									<ul class="nav nav-stacked">
										<?php if($secondary_month_report->monthly[0]->secondary > 0){ ?>
											<li><a href="#">1st Highest <span class="pull badge bg-blue"><?=substr
														($secondary_month_report->monthly[0]->username,0,11);?></span><span class="pull-right badge bg-green"><?=$secondary_month_report->monthly[0]->secondary;?></span></a></li>
										<?php } ?>
										<?php if($secondary_month_report->monthly[1]->secondary > 0){ ?>
											<li><a href="#">2nd Highest <span class="pull badge bg-blue"><?=substr
														($secondary_month_report->monthly[1]->username,0,11);?></span><span class="pull-right
                badge bg-green"><?=$secondary_month_report->monthly[1]->secondary;?></span></a></li>
										<?php } ?>
										<?php if($secondary_month_report->monthly[2]->secondary > 0){ ?>
											<li><a href="#">3rd Highest <span class="pull badge bg-blue"><?=substr
														($secondary_month_report->monthly[2]->username,0,11);?></span><span class="pull-right
                badge bg-green"><?=$secondary_month_report->monthly[2]->secondary;?></span></a></li>
										<?php } ?>

										<?php if($secondary_month_report->low_month[0]->secondary > 0){ ?>
											<li><a href="#">1st Lowest <span class="pull badge bg-blue"><?=substr
														($secondary_month_report->low_month[0]->username,0,11);?></span><span class="pull-right badge
                bg-green"><?=$secondary_month_report->low_month[0]->secondary;?></span></a></li>
										<?php } ?>
										<?php if($secondary_month_report->low_month[1]->secondary > 0){ ?>
											<li><a href="#">2nd Lowest <span class="pull badge bg-blue"><?=substr
														($secondary_month_report->low_month[1]->username,0,11);?></span><span class="pull-right
                badge bg-green"><?=$secondary_month_report->low_month[1]->secondary;?></span></a></li>
										<?php } ?>
										<?php if($secondary_month_report->low_month[2]->secondary > 0){ ?>
											<li><a href="#">3rd Lowest <span class="pull badge bg-blue"><?=substr
														($secondary_month_report->low_month[2]->username,0,11);?></span><span class="pull-right
                badge bg-green"><?=$secondary_month_report->low_month[2]->secondary;?></span></a></li>
										<?php } ?>

									</ul>

								</div>
							</div>
							<!-- /.widget-user -->
						</div>
					<?php } ?>
					<!-- / Top sales Customer -->
					<?php if(!empty($dealer_month_secondary->top) && !empty($dealer_month_secondary->least)){
						//pr($dealer_month_secondary);
						?>
						<!--Top Payment Customer-->
						<div class="col-md-4">
							<!-- Widget: user widget style 1 -->
							<div class="box box-widget widget-user-2">
								<!-- Add the bg color to the header using any of the bg-* classes -->
								<div class="widget-user-header bg-aqua-active" style="border-radius: 15px;">
									<div class="widget-user-image">
										<h4 style="border-bottom: 1px solid;">Dealers Analysis</h4>
										<img src="<?= base_url()?>design/img/analysis/payment.png" alt=""/>
									</div>
									<!-- /.widget-user-image -->
									<h3 class="widget-user-username">Secondary Sale this Month</h3>
									<!--<h5 class="widget-user-desc">1st Payment</h5>-->
								</div>
								<div class="box-footer no-padding">
									<ul class="nav nav-stacked">
										<?php if($dealer_month_secondary->top[0]->secondary_amt > 0){ ?>
											<li><a href="#">1st Highest <span class="pull badge bg-blue"><?=substr($dealer_month_secondary->top[0]->dealer_name,0,11);?></span><span
														class="pull-right
                    badge bg-green"><?=$dealer_month_secondary->top[0]->secondary_amt; ?></span></a></li>
										<?php } ?>
										<?php if($dealer_month_secondary->top[1]->secondary_amt > 0){ ?>
											<li><a href="#">2nd Highest <span class="pull badge bg-blue"><?=substr($dealer_month_secondary->top[1]->dealer_name,0,11);?></span><span  class="pull-right
                   badge bg-green"><?=$dealer_month_secondary->top[1]->secondary_amt; ?></span></a></li>
										<?php } ?>
										<?php if($dealer_month_secondary->top[2]->secondary_amt > 0){ ?>
											<li><a href="#">3rd Highest <span class="pull badge bg-blue"><?=substr($dealer_month_secondary->top[2]->dealer_name,0,11);?></span><span  class="pull-right badge bg-green"><?=$dealer_month_secondary->top[2]->secondary_amt; ?></span></a></li>
										<?php } ?>

										<?php if($dealer_month_secondary->least[0]->secondary_amt > 0){ ?>
											<li><a href="#">1st Lowest <span class="pull badge bg-blue"><?=substr($dealer_month_secondary->least[0]->dealer_name,
														0,11);?></span><span class="pull-right badge bg-green"><?=$dealer_month_secondary->least[0]->secondary_amt;?></span></a></li><?php } ?>
										<?php if($dealer_month_secondary->least[1]->secondary_amt > 0){ ?>
											<li><a href="#">2nd Lowest <span class="pull badge bg-blue"><?=substr($dealer_month_secondary->least[1]->dealer_name,0,
														11);?></span><span class="pull-right badge bg-green"><?=$dealer_month_secondary->least[1]->secondary_amt;
													?></span></a></li><?php } ?>
										<?php if($dealer_month_secondary->least[2]->secondary_amt > 0){ ?>
											<li><a href="#">3rd Lowest <span class="pull badge bg-blue"><?=substr($dealer_month_secondary->least[2]->dealer_name,0,
														11);?></span><span class="pull-right badge bg-green"><?=$dealer_month_secondary->least[2]->secondary_amt;
													?></span></a></li><?php } ?>


									</ul>

								</div>
							</div>
							<!-- /.widget-user -->
						</div>
					<?php } ?>
					<!-- /.top payment customer -->
					<?php if(!empty($visit_month->min_visit) && !empty($visit_month->max_visit)){ ?>
						<!--Top Secondary Customer-->
						<div class="col-md-4">
							<!-- Widget: user widget style 1 -->
							<div class="box box-widget widget-user-2">
								<!-- Add the bg color to the header using any of the bg-* classes -->
								<div class="widget-user-header bg-green active" style="border-radius: 15px;">
									<div class="widget-user-image">
										<h4 style="border-bottom: 1px solid;">Visits Analysis</h4>
										<img src="<?= base_url()?>design/img/analysis/secondary_sales.png" alt=""/>
									</div>
									<!-- /.widget-user-image -->
									<h3 class="widget-user-username">Number of visits this Month</h3>
									<!--<h5 class="widget-user-desc">1st Sales</h5>-->
								</div>
								<div class="box-footer no-padding">
									<ul class="nav nav-stacked">
										<li><a href="#">Maximum <span class="pull badge bg-blue"><?=substr
													(get_doctor_name($visit_month->doc_max),0,11);?></span><span
													class="pull-right badge
                   bg-green"><?=$visit_month->max_visit;?></span></a></li>
										<li><a href="#">Minimum <span class="pull badge bg-blue"><?=substr
													(get_doctor_name($visit_month->doc_min),0,11);?></span><span
													class="pull-right badge
                  bg-green"><?=$visit_month->min_visit;?></span></a></li>

									</ul>

								</div>
							</div>
							<!-- /.widget-user -->
						</div>
					<?php } ?>


				</div>
				<!--./ For the Month-->

				<!--This quarter report-->
				<div class="row tab-pane" id="quarter">
					<?php if(!empty($secondary_quarter_report)){ ?>
						<!--Top sales Customer-->
						<div class="col-md-4">
							<!-- Widget: user widget style 1 -->
							<div class="box box-widget widget-user-2">
								<!-- Add the bg color to the header using any of the bg-* classes -->
								<div class="widget-user-header bg-yellow" style="border-radius: 15px;">
									<div class="widget-user-image">
										<h4 style="border-bottom: 1px solid;">Doctor Analysis</h4>
										<img src="<?= base_url()?>design/img/analysis/total_sale.png" alt=""/>

									</div>
									<!-- /.widget-user-image -->
									<h3 class="widget-user-username">Secondary Sale this Quarter</h3>
									<!--              <h5 class="widget-user-desc">1st Sales</h5>-->
								</div>
								<div class="box-footer no-padding">
									<ul class="nav nav-stacked">
										<?php if($secondary_quarter_report->quarter[0]->secondary > 0){ ?>
											<li><a href="#">1st Highest <span class="pull badge bg-blue"><?=substr($secondary_quarter_report->quarter[0]->username,0,11);?></span><span class="pull-right badge bg-green"><?=$secondary_quarter_report->quarter[0]->secondary;?></span></a></li>
										<?php } ?>
										<?php if($secondary_quarter_report->quarter[1]->secondary > 0){ ?>
											<li><a href="#">2nd Highest <span class="pull badge bg-blue"><?=substr($secondary_quarter_report->quarter[1]->username,0,11);?></span><span class="pull-right
                badge bg-green"><?=$secondary_quarter_report->quarter[1]->secondary;?></span></a></li>
										<?php } ?>

										<?php if($secondary_quarter_report->quarter[2]->secondary > 0){ ?>
											<li><a href="#">3rd Highest <span class="pull badge bg-blue"><?=substr($secondary_quarter_report->quarter[2]->username,0,11);?></span><span class="pull-right
                badge bg-green"><?=$secondary_quarter_report->quarter[2]->secondary;?></span></a></li>
										<?php } ?>


										<?php if($secondary_quarter_report->low_quart[0]->secondary > 0){ ?>
											<li><a href="#">1st Lowest <span class="pull badge bg-blue"><?=substr($secondary_quarter_report->low_quart[0]->username,0,11);?></span><span class="pull-right badge bg-green"><?=$secondary_quarter_report->low_quart[0]->secondary;?></span></a></li>
										<?php } ?>
										<?php if($secondary_quarter_report->low_quart[1]->secondary > 0){ ?>
											<li><a href="#">2nd Lowest <span class="pull badge bg-blue"><?=substr($secondary_quarter_report->low_quart[1]->username,0,11);?></span><span class="pull-right badge bg-green"><?=$secondary_quarter_report->low_quart[1]->secondary;?></span></a></li>
										<?php } ?>
										<?php if($secondary_quarter_report->low_quart[2]->secondary > 0){ ?>
											<li><a href="#">3rd Lowest <span class="pull badge bg-blue"><?=substr($secondary_quarter_report->low_quart[2]->username,0,11);?></span><span class="pull-right badge bg-green"><?=$secondary_quarter_report->low_quart[2]->secondary;?></span></a></li>
										<?php } ?>

									</ul>

								</div>
							</div>
							<!-- /.widget-user -->
						</div>
					<?php } ?>
					<!-- / Top sales Customer -->
					<?php if(!empty($dealer_quart_secondary->top) && !empty($dealer_quart_secondary->least)){  ?>
						<!--Top Payment Customer-->
						<div class="col-md-4">
							<!-- Widget: user widget style 1 -->
							<div class="box box-widget widget-user-2">
								<!-- Add the bg color to the header using any of the bg-* classes -->
								<div class="widget-user-header bg-aqua-active" style="border-radius: 15px;">
									<div class="widget-user-image">
										<h4 style="border-bottom: 1px solid;">Dealers Analysis</h4>

										<img src="<?= base_url()?>design/img/analysis/payment.png" alt=""/>
										<!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
									</div>
									<!-- /.widget-user-image -->
									<h3 class="widget-user-username">Secondary Sale this Quarter</h3>
									<!--<h5 class="widget-user-desc">1st Payment</h5>-->
								</div>
								<div class="box-footer no-padding">
									<ul class="nav nav-stacked">
										<?php if($dealer_quart_secondary->top[0]->secondary_amt > 0){ ?>
											<li><a href="#">1st Highest <span class="pull badge bg-blue"><?=substr ($dealer_quart_secondary->top[0]->dealer_name,0,11);?></span><span  class="pull-right badge bg-green"><?=$dealer_quart_secondary->top[0]->secondary_amt; ?></span></a></li><?php } ?>
										<?php if($dealer_quart_secondary->top[1]->secondary_amt > 0){ ?>
											<li><a href="#">2nd Highest <span class="pull badge bg-blue"><?=substr($dealer_quart_secondary->top[1]->dealer_name,0,11);?></span><span  class="pull-right badge bg-green"><?=$dealer_quart_secondary->top[1]->secondary_amt; ?></span></a></li><?php } ?>
										<?php if($dealer_quart_secondary->top[2]->secondary_amt > 0){ ?>
											<li><a href="#">3rd Highest <span class="pull badge bg-blue"><?=substr($dealer_quart_secondary->top[2]->dealer_name,0,11);?></span><span  class="pull-right badge bg-green"><?=$dealer_quart_secondary->top[2]->secondary_amt; ?></span></a></li><?php } ?>

										<?php if($dealer_quart_secondary->least[0]->secondary_amt > 0){ ?>
											<li><a href="#">1st Lowest <span class="pull badge bg-blue"><?=substr($dealer_quart_secondary->least[0]->dealer_name,0,11);?></span><span class="pull-right badge bg-green"><?=$dealer_quart_secondary->least[0]->secondary_amt;?></span></a></li><?php } ?>
										<?php if($dealer_quart_secondary->least[1]->secondary_amt > 0){ ?>
											<li><a href="#">2nd Lowest <span class="pull badge bg-blue"><?=substr($dealer_quart_secondary->least[1]->dealer_name,0,
														11);?></span><span class="pull-right badge bg-green"><?=$dealer_quart_secondary->least[1]->secondary_amt;
													?></span></a></li><?php } ?>
										<?php if($dealer_quart_secondary->least[2]->secondary_amt > 0){ ?>
											<li><a href="#">3rd Lowest <span class="pull badge bg-blue"><?=substr($dealer_quart_secondary->least[2]->dealer_name,0,
															11);?></span><span class="pull-right badge bg-green"><?=$dealer_quart_secondary->least[2]->secondary_amt;
														?></span></a></li> <?php } ?>


									</ul>

								</div>
							</div>
							<!-- /.widget-user -->
						</div>
					<?php } ?>
					<!-- /.top payment customer -->
					<?php if(!empty($visit_quarter->min_visit) && !empty($visit_quarter->max_visit)){ ?>
						<!--Top Secondary Customer-->
						<div class="col-md-4">
							<!-- Widget: user widget style 1 -->
							<div class="box box-widget widget-user-2">
								<!-- Add the bg color to the header using any of the bg-* classes -->
								<div class="widget-user-header bg-green active" style="border-radius: 15px;">
									<div class="widget-user-image">
										<h4 style="border-bottom: 1px solid;">Visits Analysis</h4>
										<img src="<?= base_url()?>design/img/analysis/secondary_sales.png" alt=""/>
									</div>
									<!-- /.widget-user-image -->
									<h3 class="widget-user-username">Number of visits in Quarter</h3>
									<!--<h5 class="widget-user-desc">1st Sales</h5>-->
								</div>
								<div class="box-footer no-padding">
									<ul class="nav nav-stacked">
										<li><a href="#">Maximum <span class="pull badge bg-blue"><?=substr
													(get_doctor_name($visit_quarter->doc_max),0,11);?></span><span
													class="pull-right badge
                   bg-green"><?=$visit_quarter->max_visit;?></span></a></li>
										<li><a href="#">Minimum <span class="pull badge bg-blue"><?=substr
													(get_doctor_name($visit_quarter->doc_min),0,11);?></span><span
													class="pull-right badge
                  bg-green"><?=$visit_quarter->min_visit;?></span></a></li>

									</ul>

								</div>
							</div>
							<!-- /.widget-user -->
						</div>
					<?php } ?>


				</div>
				<!--/. End of this quarter report-->

				<div class="row tab-pane" id="year">
					<?php if(!empty($secondary_year_report)){ ?>
						<!--Top sales Customer-->
						<div class="col-md-4">
							<!-- Widget: user widget style 1 -->
							<div class="box box-widget widget-user-2">
								<!-- Add the bg color to the header using any of the bg-* classes -->
								<div class="widget-user-header bg-yellow" style="border-radius: 15px;">
									<div class="widget-user-image">
										<h4 style="border-bottom: 1px solid;">Doctor Analysis</h4>
										<img src="<?= base_url()?>design/img/analysis/total_sale.png" alt=""/>

									</div>
									<!-- /.widget-user-image -->
									<h3 class="widget-user-username">Secondary this Year</h3>
									<!--<h5 class="widget-user-desc">1st Sales</h5>-->
								</div>
								<div class="box-footer no-padding">
									<ul class="nav nav-stacked">
										<?php if($secondary_year_report->yearly[0]->secondary > 0){ ?>
											<li><a href="#">1st Highest <span class="pull badge bg-blue"><?=substr
														($secondary_year_report->yearly[0]->username,0,11);?></span><span class="pull-right badge bg-green"><?=$secondary_year_report->yearly[0]->secondary;?></span></a></li>
										<?php } ?>
										<?php if($secondary_year_report->yearly[1]->secondary > 0){ ?>
											<li><a href="#">2nd Highest <span class="pull badge bg-blue"><?=substr
														($secondary_year_report->yearly[1]->username,0,11);?></span><span class="pull-right
                badge bg-green"><?=$secondary_year_report->yearly[1]->secondary;?></span></a></li>
										<?php } ?>
										<?php if($secondary_year_report->yearly[2]->secondary > 0){ ?>
											<li><a href="#">3rd Highest <span class="pull badge bg-blue"><?=substr
														($secondary_year_report->yearly[2]->username,0,11);?></span><span class="pull-right
                badge bg-green"><?=$secondary_year_report->yearly[2]->secondary;?></span></a></li>
										<?php } ?>

										<?php if($secondary_year_report->low_year[0]->secondary > 0){ ?>
											<li><a href="#">1st Lowest <span class="pull badge bg-blue"><?=substr
														($secondary_year_report->low_year[0]->username,0,11);?></span><span class="pull-right badge
                bg-green"><?=$secondary_year_report->low_year[0]->secondary;?></span></a></li>
										<?php } ?>
										<?php if($secondary_year_report->low_year[1]->secondary > 0){ ?>
											<li><a href="#">2nd Lowest <span class="pull badge bg-blue"><?=substr
														($secondary_year_report->low_year[1]->username,0,11);?></span><span class="pull-right
                badge bg-green"><?=$secondary_year_report->low_year[1]->secondary;?></span></a></li>
										<?php } ?>
										<?php if($secondary_year_report->low_year[2]->secondary > 0){ ?>
											<li><a href="#">3rd Lowest <span class="pull badge bg-blue"><?=substr
														($secondary_year_report->low_year[2]->username,0,11);?></span><span class="pull-right
                badge bg-green"><?=$secondary_year_report->low_year[2]->secondary;?></span></a></li>
										<?php } ?>


									</ul>

								</div>
							</div>
							<!-- /.widget-user -->
						</div>
					<?php } ?>
					<!-- / Top sales Customer -->
					<?php if(!empty($dealer_year_secondary->top) && !empty($dealer_year_secondary->least)){
						// $contsec=count($dealer_year_secondary);
						?>
						<!--Top Payment Customer-->
						<div class="col-md-4">
							<!-- Widget: user widget style 1 -->
							<div class="box box-widget widget-user-2">
								<!-- Add the bg color to the header using any of the bg-* classes -->
								<div class="widget-user-header bg-aqua-active" style="border-radius: 15px;">
									<div class="widget-user-image">
										<h4 style="border-bottom: 1px solid;">Dealers Analysis</h4>

										<img src="<?= base_url()?>design/img/analysis/payment.png" alt=""/>
										<!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
									</div>
									<!-- /.widget-user-image -->
									<h3 class="widget-user-username">Secondary Sale this Year</h3>
									<!--<h5 class="widget-user-desc">1st Payment</h5>-->
								</div>
								<div class="box-footer no-padding">
									<ul class="nav nav-stacked">
										<?php if($dealer_year_secondary->top[0]->secondary_amt > 0){ ?>
											<li><a href="#">1st Highest <span class="pull badge bg-blue"><?=substr
													($dealer_year_secondary->top[0]->dealer_name,0,11);?></span><span
													class="pull-right badge bg-green"><?=$dealer_year_secondary->top[0]->secondary_amt; ?></span></a></li><?php } ?>
										<?php if($dealer_year_secondary->top[1]->secondary_amt > 0){ ?>
											<li><a href="#">2nd Highest <span class="pull badge bg-blue"><?=substr
													($dealer_year_secondary->top[1]->dealer_name,0,11);?></span><span  class="pull-right
		       badge bg-green"><?=$dealer_year_secondary->top[1]->secondary_amt; ?></span></a></li><?php } ?>
										<?php if($dealer_year_secondary->top[2]->secondary_amt > 0){ ?>
											<li><a href="#">3rd Highest <span class="pull badge bg-blue"><?=substr
														($dealer_year_secondary->top[2]->dealer_name,0,11);?></span><span  class="pull-right
		       badge bg-green"><?=$dealer_year_secondary->top[2]->secondary_amt; ?></span></a></li> <?php } ?>

										<?php if($dealer_year_secondary->least[0]->secondary_amt > 0){ ?>
											<li><a href="#">1st Lowest <span class="pull badge bg-blue"><?=substr
													($dealer_year_secondary->least[0]->dealer_name,0,11);?></span><span
													class="pull-right badge bg-green"><?=$dealer_year_secondary->least[0]->secondary_amt;?></span></a></li><?php } ?>
										<?php if($dealer_year_secondary->least[1]->secondary_amt > 0){ ?>
											<li><a href="#">2nd Lowest <span class="pull badge bg-blue"><?=substr($dealer_year_secondary->least[1]->dealer_name,0,
														11);?></span><span class="pull-right badge bg-green"><?=$dealer_year_secondary->least[1]->secondary_amt;
													?></span></a></li><?php } ?>
										<?php if($dealer_year_secondary->least[2]->secondary_amt > 0){ ?>
											<li><a href="#">3rd Lowest <span class="pull badge bg-blue"><?=substr($dealer_year_secondary->least[2]->dealer_name,0,
														11);?></span><span class="pull-right badge bg-green"><?=$dealer_year_secondary->least[2]->secondary_amt;
													?></span></a></li><?php } ?>


									</ul>

								</div>
							</div>
							<!-- /.widget-user -->
						</div>
					<?php } ?>
					<!-- /.top payment customer -->
					<?php if(!empty($visit_year->min_visit) && !empty($visit_year->max_visit)){ ?>
						<!--Top Secondary Customer-->
						<div class="col-md-4">
							<!-- Widget: user widget style 1 -->
							<div class="box box-widget widget-user-2">
								<!-- Add the bg color to the header using any of the bg-* classes -->
								<div class="widget-user-header bg-green active" style="border-radius: 15px;">
									<div class="widget-user-image">
										<h4 style="border-bottom: 1px solid;">Visits Analysis</h4>
										<img src="<?= base_url()?>design/img/analysis/secondary_sales.png" alt=""/>
									</div>
									<!-- /.widget-user-image -->
									<h3 class="widget-user-username">Number of visits in Year</h3>
									<!--<h5 class="widget-user-desc">1st Sales</h5>-->
								</div>
								<div class="box-footer no-padding">
		<ul class="nav nav-stacked">
			<li><a href="#">Maximum <span class="pull badge bg-blue"><?=substr
						(get_doctor_name($visit_year->doc_max),0,11);?></span><span class="pull-right
		badge bg-green"><?=$visit_year->max_visit;?></span></a></li>
			<li><a href="#">Minimum <span class="pull badge bg-blue"><?=substr
						(get_doctor_name($visit_year->doc_min),0,11);?></span><span class="pull-right
		badge bg-green"><?=$visit_year->min_visit;?></span></a></li>

		</ul>

								</div>
							</div>
							<!-- /.widget-user -->
						</div>
					<?php } ?>


				</div>
			</div>

			<div class="control-sidebar-bg"></div>

		</div>


		<!-- Main content of Secondary Table -->
		<section class="content" style="padding-left: 0px !important; padding-right: 0px !important;">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="page-header">Secondary Report</h2>
					<div class="box">
						<!-- /.box-header -->
						<div class="box-body">
							<?php
							$current_date=date('d-m-Y');
							$past_date= date('d-m-Y', strtotime(" -1 month"));
							?>
							<p style="text-align: center; font-weight: 700; padding: 10px;">Report Dated: <?=$past_date ?> - <?=$current_date ?> </p>
							<table id="example2" class="table table-bordered table-striped">
								<thead>
								<tr>
									<th>Name</th>
									<th>Reporting Manager</th>
									<th>Designation</th>
									<th>Total No. of Doctors</th>
									<th>Total No. of Doctors Interaction</th>
									<th>Total Secondary Sale </th>
									<th>Total Order Received </th>
									<!--                <th>Total Number of Order </th>-->
									<th>Total Not Met </th>
									<th>Total No. of Team Members</th>
									<th>Average Interaction</th>
									<th>Average Secondary</th>
									<th>Total Dealers</th>
									<th>Total Sub-Dealers</th>
								</tr>
								</thead>

								<tbody>
								<?php
								$ci =&get_instance();
								$ci->load->model('user_model');
								$userdata =$ci->user_model->users_report();
								$userList=json_decode($userdata);
								$userID=logged_user_data();
								$child_users=get_child_user($userID);  //Get Team total team members
								//              pr($child_users); die;
								if(!empty($child_users)){
									/*Overall Report*/
									$data = file_get_contents ("ReportJSON/monthly.json");
									$json = json_decode($data, true);
									foreach($child_users as  $val) {
										foreach ($json as $weekly_data) {
											if ($weekly_data['user_id'] == $val) {
												?>
												<tr>
													<td><?= $weekly_data['username'] ?></td>
													<td><?= $weekly_data['bossname'] ?></td>
													<td><?= $weekly_data['designation_name'] ?></td>
													<td><?= $weekly_data['total_doctors'] ?></td>
													<?php  if($weekly_data['total_orders_not_met']){ ?>
														<td><?= $weekly_data['total_doc_interaction'] - $weekly_data['total_orders_not_met'] ?></td>
													<?php }else{ ?>
														<td><?= $weekly_data['total_doc_interaction'] ?></td>
													<?php }  ?>
													<?php if (!empty($weekly_data['total_secondary'])) { ?>
														<td><?= $weekly_data['total_secondary']; ?></td>
													<?php } else { ?>
														<td>0</td>
													<?php } ?>
													<?php if (!empty($weekly_data['total_productive_call'])) { ?>
														<td><?= $weekly_data['total_productive_call']; ?></td>
													<?php } else { ?>
														<td>0</td>
													<?php } ?>

													<?php if (!empty($weekly_data['total_orders_not_met'])) { ?>
														<td><?= $weekly_data['total_orders_not_met']; ?></td>
													<?php } else { ?>
														<td>0</td>
													<?php } ?>
													<td><?= $weekly_data['team_members'] ?></td>
													<td><?php if(!empty($weekly_data['total_doc_interaction'])){ ?>
														<?=number_format(($weekly_data['total_doc_interaction'] - $weekly_data['total_orders_not_met'])/ 30 , 2, '.', ''); ?></td>
												<?php }else{ ?>
													<td>0.00</td>
												<?php } ?>

													<?php if (!empty($weekly_data['total_secondary'])) {
														$tot_interact=$weekly_data['total_doc_interaction'] - $weekly_data['total_orders_not_met'];
														$tot_sec=str_replace( ',', '', $weekly_data['total_secondary']);
														$avg_sec=($tot_sec/$tot_interact); ?>
														<td>
															<?= number_format($avg_sec,2,'.',''); ?></td>
													<?php }else { ?>
														<td>0.00</td>
													<?php } ?>
													<td><?=get_dealers_count($weekly_data['user_id']); ?></td>
													<td><?=get_pharma_count($weekly_data['user_id']); ?></td>
												</tr>
											<?php }
										}
									}
								}
								else{
									$data = file_get_contents ("ReportJSON/monthly.json");
									$json = json_decode($data, true);//for secondary
									foreach($json as $weekly_data){
										if($weekly_data['user_id'] == $userID){
											?>
											<tr>
												<td><?= $weekly_data['username'] ?></td>
												<td><?=$weekly_data['bossname'] ?></td>
												<td><?=$weekly_data['designation_name'] ?></td>
												<td><?=$weekly_data['total_doctors'] ?></td>
												<?php  if($weekly_data['total_orders_not_met']){ ?>
													<td><?= $weekly_data['total_doc_interaction'] - $weekly_data['total_orders_not_met'] ?></td>
												<?php }else{ ?>
													<td><?= $weekly_data['total_doc_interaction'] ?></td>
												<?php }  ?>
												<?php if(!empty($weekly_data['total_secondary'])){ ?>
													<td><?=$weekly_data['total_secondary'];?></td>
												<?php }else{ ?>
													<td>0</td>
												<?php } ?>
												<?php if(!empty($weekly_data['total_productive_call'])){ ?>
													<td><?=$weekly_data['total_productive_call'];?></td>
												<?php }else{ ?>
													<td>0</td>
												<?php } ?>
												<?php if(!empty($weekly_data['total_orders_not_met'])){ ?>
													<td><?=$weekly_data['total_orders_not_met'];?></td>
												<?php }else{ ?>
													<td>0</td>
												<?php } ?>
												<td><?=$weekly_data['team_members'] ?></td>
												<?php if(!empty($weekly_data['total_doc_interaction']) && $weekly_data['total_doc_interaction'] !=0 && $weekly_data['total_doc_interaction']==''){ ?>
													<td><?=number_format(($weekly_data['total_doc_interaction'] - $weekly_data['total_orders_not_met'])/ 30 , 2, '.', ''); ?></td>
												<?php }else{ ?>
													<td>0.00</td>
												<?php } ?>

												<?php
												$tot_interact=$weekly_data['total_doc_interaction'] - $weekly_data['total_orders_not_met'];
												$tot_sec=str_replace( ',', '', $weekly_data['total_secondary']);
												if (!empty($weekly_data['total_secondary']) && $tot_sec!=0 && $tot_interact!=0) {
													$avg_sec=($tot_sec/$tot_interact); ?>
													<td>
														<?= number_format($avg_sec,2,'.',''); ?></td>
												<?php }else { ?>
													<td>0.00</td>
												<?php } ?>
												<td><?=get_dealers_count($weekly_data['user_id']); ?></td>
												<td><?=get_pharma_count($weekly_data['user_id']); ?></td>
											</tr>
										<?php }
									}
								}
								?>
								</tbody>
							</table>
							<p style="color: darkgrey;">**This table shows your monthly report from today's date.</p>
						</div>
						<!-- /.box-body -->
					</div></div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
			<!-- /.row -->
		</section>
		<!-- /.content -->


		<script>

            $(function () {
                $('#example2').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'csv', 'print',
                    ],
                    'responsive' : true,
                    'paging'      : true,
                    'lengthChange': true,
                    'searching'   : true,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : true,
                    'scrollX'     : true,
                });
            });


		</script>
