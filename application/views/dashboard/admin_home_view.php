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
        $weekproductive_report = json_decode($week_prodcutive); //for Productive call
        $weeknoroder_report = json_decode($week_no_order);  //for No order but met
        $weeknotmet_report = json_decode($week_not_met);  //for Not met
   /*end for this week*/
   
   /*For this Month*/
        $secondary_month_report = json_decode($secondary_month);  //for secondary
        $prodcutive_month_report = json_decode($prodcutive_month); //for Productive call
        $no_order_month_report = json_decode($no_order_month);  //for No order but met
        $not_met_month_report = json_decode($not_met_month);  //for Not met
   /*end for this Month*/
   
    /*For this Quarter*/ 
        $secondary_quarter_report = json_decode($secondary_quarter);  //for secondary
        $productive_quarter_report = json_decode($prodcutive_quarter); //for Productive call
        $no_order_quarter_report = json_decode($no_order_quarter);  //for No order but met
        $not_met_quarter_report = json_decode($not_met_quarter);  //for Not met
   /*end for this Quarter*/

	/*For this Year*/
	   $secondary_year_report = json_decode($secondary_year);  // for see Doctor
	   $productive_year_report = json_decode($prodcutive_year); // for see Dealer
	   $no_order_year_report = json_decode($no_order_year);  // for see Pharma
	   $not_met_year_report = json_decode($not_met_year);  // for see Pharma
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


        <!-- fix for small devices only -->
       <!--  <div class="clearfix visible-sm-block"></div>-->

     
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
         <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Secondary Analysis</h4>
                  <img src="<?= base_url()?>design/img/analysis/total_sale.png" alt=""/>

              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Secondary Sale this Week</h3>
              <!--<h5 class="widget-user-desc">1st Sales</h5>-->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">

                  <li><a href="#">Highest <span class="pull badge bg-blue"><?=substr($weeksecondary_report->highest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$weeksecondary_report->highest->meeting_sale;?></span></a></li>
                  <li><a href="#">Lowest <span class="pull badge bg-blue"><?=substr($weeksecondary_report->lowest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$weeksecondary_report->lowest->meeting_sale;?></span></a></li>

              </ul>

            </div>
          </div>
          <!-- /.widget-user -->
        </div>
           <?php } ?>
        <!-- / Top sales Customer -->

        <?php if(!empty($weekproductive_report)){ ?>
        <!--Top Payment Customer-->
        <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Productive Call Analysis</h4>

                  <img src="<?= base_url()?>design/img/analysis/payment.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Productive Call this Week</h3>
              <!--<h5 class="widget-user-desc">1st Payment</h5>-->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">

                <li><a href="#">Highest <span class="pull badge bg-blue"><?=substr($weekproductive_report->highest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$weekproductive_report->highest->produtive_call;?></span></a></li>
                  <li><a href="#">Lowest <span class="pull badge bg-blue"><?=substr($weekproductive_report->lowest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$weekproductive_report->lowest->produtive_call;?></span></a></li>

              </ul>

            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.top payment customer -->

        <?php if(!empty($weeknoroder_report)){ ?>
        <!--Top Secondary Customer-->
        <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">No Order Analysis</h4>
                  <img src="<?= base_url()?>design/img/analysis/secondary_sales.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">No Order this Week</h3>
              <!--<h5 class="widget-user-desc">1st Sales</h5>-->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">

                  <li><a href="#">Highest <span class="pull badge bg-blue"><?=substr($weeknoroder_report->highest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$weeknoroder_report->highest->produtive_call;?></span></a></li>
                  <li><a href="#">Lowest <span class="pull badge bg-blue"><?=substr($weeknoroder_report->lowest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$weeknoroder_report->lowest->produtive_call;?></span></a></li>

              </ul>

            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.Top Secondary Customer -->

         <?php if(!empty($weeknotmet_report)){ ?>
        <!--Top Secondary Customer-->
        <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-red active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Not Met Analysis</h4>
                  <img src="<?= base_url()?>design/img/analysis/secondary_sales.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Not Met this Week</h3>
              <!--<h5 class="widget-user-desc">1st Sales</h5>-->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">

                  <li><a href="#">Highest <span class="pull badge bg-blue"><?=substr($weeknotmet_report->highest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$weeknotmet_report->highest->produtive_call;?></span></a></li>
                  <li><a href="#">Lowest <span class="pull badge bg-blue"><?=substr($weeknotmet_report->lowest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$weeknotmet_report->lowest->produtive_call;?></span></a></li>

              </ul>

            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        
        
      </div>
          
      <!--For the Month-->
       <div class="row tab-pane" id="month">
           <?php if(!empty($secondary_month_report)){ ?>
        <!--Top sales Customer-->
          <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Secondary Analysis</h4>
                  <img src="<?= base_url()?>design/img/analysis/total_sale.png" alt=""/>
                
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Secondary Sale this Month</h3>
              <!--<h5 class="widget-user-desc">1st Sales</h5>-->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
             
                 <li><a href="#">Highest <span class="pull badge bg-blue"><?=substr($secondary_month_report->highest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$secondary_month_report->highest->meeting_sale;?></span></a></li>
                 <li><a href="#">Lowest <span class="pull badge bg-blue"><?=substr($secondary_month_report->lowest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$secondary_month_report->lowest->meeting_sale;?></span></a></li>

              </ul>
                
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
           <?php } ?>
        <!-- / Top sales Customer -->
        
        <?php if(!empty($prodcutive_month_report)){ ?>
        <!--Top Payment Customer-->
        <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Productive Call Analysis</h4>
                  
                  <img src="<?= base_url()?>design/img/analysis/payment.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Productive Call this Month</h3>
              <!--<h5 class="widget-user-desc">1st Payment</h5>-->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
               
                <li><a href="#">Highest <span class="pull badge bg-blue"><?=substr($prodcutive_month_report->highest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$prodcutive_month_report->highest->produtive_call;?></span></a></li>
                <li><a href="#">Lowest <span class="pull badge bg-blue"><?=substr($prodcutive_month_report->lowest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$prodcutive_month_report->lowest->produtive_call;?></span></a></li>

              </ul>
               
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.top payment customer -->
        
        <?php if(!empty($no_order_month_report)){ ?>
        <!--Top Secondary Customer-->
        <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">No Order Analysis</h4>
                  <img src="<?= base_url()?>design/img/analysis/secondary_sales.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">No Order this Month</h3>
              <!--<h5 class="widget-user-desc">1st Sales</h5>-->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                
                <li><a href="#">Highest <span class="pull badge bg-blue"><?=substr($no_order_month_report->highest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$no_order_month_report->highest->produtive_call;?></span></a></li>
                <li><a href="#">Lowest <span class="pull badge bg-blue"><?=substr($no_order_month_report->lowest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$no_order_month_report->lowest->produtive_call;?></span></a></li>

              </ul>
               
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.Top Secondary Customer -->
      
          <?php if(!empty($not_met_month_report)){ ?>
        <!--Top Secondary Customer-->
        <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-red active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Not Met Analysis</h4>
                  <img src="<?= base_url()?>design/img/analysis/secondary_sales.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Not Met this Month</h3>
              <!--<h5 class="widget-user-desc">1st Sales</h5>-->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                
                <li><a href="#">Highest <span class="pull badge bg-blue"><?=substr($not_met_month_report->highest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$not_met_month_report->highest->produtive_call;?></span></a></li>
                <li><a href="#">Lowest <span class="pull badge bg-blue"><?=substr($not_met_month_report->lowest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$not_met_month_report->lowest->produtive_call;?></span></a></li>

              </ul>
               
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.Top Secondary Customer -->
        
        
      </div>
      <!--./ For the Month-->
      
      <!--This quarter report-->
     <div class="row tab-pane" id="quarter">
           <?php if(!empty($secondary_quarter_report)){ ?>
        <!--Top sales Customer-->
          <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Secondary Analysis</h4>
                  <img src="<?= base_url()?>design/img/analysis/total_sale.png" alt=""/>
                
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Secondary Sale this Quarter</h3>
<!--              <h5 class="widget-user-desc">1st Sales</h5>-->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
              
                <li><a href="#">Highest <span class="pull badge bg-blue"><?=substr($secondary_quarter_report->highest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$secondary_quarter_report->highest->meeting_sale;?></span></a></li>
                <li><a href="#">Lowest <span class="pull badge bg-blue"><?=substr($secondary_quarter_report->lowest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$secondary_quarter_report->lowest->meeting_sale;?></span></a></li>

              </ul>
                
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
           <?php } ?>
        <!-- / Top sales Customer -->
        
        <?php if(!empty($productive_quarter_report)){ ?>
        <!--Top Payment Customer-->
        <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Productive Call Analysis</h4>
                  
                  <img src="<?= base_url()?>design/img/analysis/payment.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Productive Call this Quarter</h3>
              <!--<h5 class="widget-user-desc">1st Payment</h5>-->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                
                <li><a href="#">Highest <span class="pull badge bg-blue"><?=substr($productive_quarter_report->highest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$productive_quarter_report->highest->produtive_call;?></span></a></li>
                <li><a href="#">Lowest <span class="pull badge bg-blue"><?=substr($productive_quarter_report->lowest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$productive_quarter_report->lowest->produtive_call;?></span></a></li>

               
              </ul>
              
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.top payment customer -->
        
        <?php if(!empty($no_order_quarter_report)){ ?>
        <!--Top Secondary Customer-->
        <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">No Order Analysis</h4>
                  <img src="<?= base_url()?>design/img/analysis/secondary_sales.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">No Order this Quarter</h3>
              <!--<h5 class="widget-user-desc">1st Sales</h5>-->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                
                <li><a href="#">Highest <span class="pull badge bg-blue"><?=substr($no_order_quarter_report->highest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$no_order_quarter_report->highest->produtive_call;?></span></a></li>
                <li><a href="#">Lowest <span class="pull badge bg-blue"><?=substr($no_order_quarter_report->lowest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$no_order_quarter_report->lowest->produtive_call;?></span></a></li>

              </ul>
               
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.Top Secondary Customer -->
        <?php if(!empty($not_met_quarter_report)){ ?>
        <!--Top Secondary Customer-->
        <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-red active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Not Met Analysis</h4>
                  <img src="<?= base_url()?>design/img/analysis/secondary_sales.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Not Met this Quarter</h3>
              <!--<h5 class="widget-user-desc">1st Sales</h5>-->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                
                <li><a href="#">Highest <span class="pull badge bg-blue"><?=substr($not_met_quarter_report->highest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$not_met_quarter_report->highest->produtive_call;?></span></a></li>
                <li><a href="#">Lowest <span class="pull badge bg-blue"><?=substr($not_met_quarter_report->lowest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$not_met_quarter_report->lowest->produtive_call;?></span></a></li>

              </ul>
               
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.Top Secondary Customer -->
        
      </div>
      <!--/. End of this quarter report-->
      
     <div class="row tab-pane" id="year">
           <?php if(!empty($secondary_year_report)){ ?>
        <!--Top sales Customer-->
          <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Secondary Analysis</h4>
                  <img src="<?= base_url()?>design/img/analysis/total_sale.png" alt=""/>
                
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Secondary this Year</h3>
              <!--<h5 class="widget-user-desc">1st Sales</h5>-->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
              
                 <li><a href="#">Highest <span class="pull badge bg-blue"><?=substr($secondary_year_report->highest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$secondary_year_report->highest->meeting_sale;?></span></a></li>
                 <li><a href="#">Lowest <span class="pull badge bg-blue"><?=substr($secondary_year_report->lowest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$secondary_year_report->lowest->meeting_sale;?></span></a></li>

              </ul>
               
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
           <?php } ?>
        <!-- / Top sales Customer -->
        
        <?php if(!empty($productive_year_report)){ ?>
        <!--Top Payment Customer-->
        <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Productive Call Analysis</h4>
                  
                  <img src="<?= base_url()?>design/img/analysis/payment.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Productive Call this Year</h3>
              <!--<h5 class="widget-user-desc">1st Payment</h5>-->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                
                 <li><a href="#">Highest <span class="pull badge bg-blue"><?=substr($productive_year_report->highest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$productive_year_report->highest->produtive_call;?></span></a></li>
                <li><a href="#">Lowest <span class="pull badge bg-blue"><?=substr($productive_year_report->lowest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$productive_year_report->lowest->produtive_call;?></span></a></li>

              </ul>
               
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.top payment customer -->
        
        <?php if(!empty($no_order_year_report)){ ?>
        <!--Top Secondary Customer-->
        <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">No Order Analysis</h4>
                  <img src="<?= base_url()?>design/img/analysis/secondary_sales.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">No Order this Year</h3>
              <!--<h5 class="widget-user-desc">1st Sales</h5>-->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                  
                  <li><a href="#">Highest <span class="pull badge bg-blue"><?=substr($no_order_year_report->highest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$no_order_year_report->highest->produtive_call;?></span></a></li>
                  <li><a href="#">Lowest <span class="pull badge bg-blue"><?=substr($no_order_year_report->lowest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$no_order_year_report->lowest->produtive_call;?></span></a></li>

              </ul>
               
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.Top Secondary Customer -->
        
         <?php if(!empty($not_met_year_report)){ ?>
        <!--Top Secondary Customer-->
        <div class="col-md-3">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-red active">
              <div class="widget-user-image">
                  <h4 style="border-bottom: 1px solid;">Not Met Analysis</h4>
                  <img src="<?= base_url()?>design/img/analysis/secondary_sales.png" alt=""/>
                <!--<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">-->
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Not Met this Year</h3>
              <!--<h5 class="widget-user-desc">1st Sales</h5>-->
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                  
                  <li><a href="#">Highest <span class="pull badge bg-blue"><?=substr($not_met_year_report->highest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$not_met_year_report->highest->produtive_call;?></span></a></li>
                  <li><a href="#">Lowest <span class="pull badge bg-blue"><?=substr($not_met_year_report->lowest->empname,0,11);?></span><span class="pull-right badge bg-green"><?=$not_met_year_report->lowest->produtive_call;?></span></a></li>

              </ul>
               
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <?php } ?>
        <!-- /.Top Secondary Customer -->
     
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
					  <table id="example2" class="table table-bordered table-striped">
						  <thead>
						  <tr>
							  <th>Name</th>
							  <th>Reporting Manager</th>
							  <th>Designation</th>
							  <th>Total No. of Doctors</th>
							  <th>Total No. of Doctors Interaction</th>
							  <th>Total No. of Team Members</th>
							  <th>Total Secondary Sale </th>
							  <th>Total Productive Call </th>
							  <th>Total Number of Order </th>
							  <th>Total Not Met </th>
						  </tr>
						  </thead>

						  <tbody>
						  <?php
						  $ci =&get_instance();
						  $ci->load->model('Data_report_Analysis');
						  $ci->load->model('user_model');
						  $ci->load->model('doctor/Doctor_model');
						  $ci->load->model('report/report_model');
						  $userdata =$ci->user_model->users_report();
						  $userList=json_decode($userdata);
						  $userID=logged_user_data();
						  $child_users=get_child_user($userID);  //Get Team total team members
						 // pr($child_users);
						   if(!empty($child_users)){
							   /*Overall Report*/
							   foreach($child_users as  $val){
								   $user_SP=getuserSPcode($val);
								   $userSP = $user_SP->sp_code;
								   $user_name=get_user_name($val);
								   $userid=$val;
								   $weekly='month';
								   $get_boss=get_user_boss($val);
								   $get_boss_name=get_user_name($get_boss[0]['boss_id']);
								   $bossid=$get_boss[0]['boss_id'];
								   $get_uid=get_user_id($user_name);
								   $get_designation=get_designation_name($get_uid->user_designation_id);
								   $total_doctors = $ci->doctor->total_doctor_data($userSP);  //Total No. of doctors
								   @$doc_interaction = total_doctor_interaction($userid); //Total Doctor interaction
								   $child_users=count(get_child_user($userid));  //Get Team total team members

								   for ($iDay = 30; $iDay >= 0; $iDay--) {
									   @$aDays[31 - $iDay] = date('Y-m-d 00:00:00', strtotime("-" . $iDay . " day"));
								   }
								   @$total_doc_interaction= count(array_intersect($doc_interaction,$aDays));
								   @$week_secondary=total_secondary_analysis($weekly,$userid);
								   @$weekproductive_report =total_productive_analysis($weekly,$userid);
								   @$weeknoroder_report=total_noorder_met_analysis($weekly,$userid);
								   @$weeknotmet_report=total_not_met_analysis($weekly,$userid);
								   /*For this week*/
								   $weeksecondary_report = $week_secondary->total_secondry;  //for secondary
								   ?>
								   <tr>
									   <td><?=$user_name ?></td>
									   <td><?=$get_boss_name ?></td>
									   <td><?=$get_designation->designation_name ?></td>
									   <td><?=$total_doctors ?></td>
									   <td><?=$total_doc_interaction ?></td>
									   <td><?=$child_users ?></td>
									   <?php if(!empty($weeksecondary_report)){ ?>
										   <td><?=number_format($weeksecondary_report,2);?></td>
									   <?php }else{ ?>
										   <td>0</td>
									   <?php } ?>
									   <?php if(!empty($weekproductive_report)){ ?>
										   <td><?=$weekproductive_report;?></td>
									   <?php }else{ ?>
										   <td>0</td>
									   <?php } ?>
									   <?php if(!empty($weeknoroder_report)){ ?>
										   <td><?=$weeknoroder_report;?></td>
									   <?php }else{ ?>
										   <td>0</td>
									   <?php } ?>

									   <?php if(!empty($weeknotmet_report)){ ?>
										   <td><?=$weeknotmet_report;?></td>
									   <?php }else{ ?>
										   <td>0</td>
									   <?php } ?>
								   </tr>
							   <?php	  }
						   }
						   else{
								   $user_SP=getuserSPcode($userID);
								   $userSP = $user_SP->sp_code;
								   $user_name=get_user_name($userID);
								   $userid=$userID;
								   $weekly='month';
								   $get_boss=get_user_boss($userID);
								   $get_boss_name=get_user_name($get_boss[0]['boss_id']);
								   $bossid=$get_boss[0]['boss_id'];
								   $get_uid=get_user_id($user_name);
								   $get_designation=get_designation_name($get_uid->user_designation_id);
								   $total_doctors = $ci->doctor->total_doctor_data($userSP);  //Total No. of doctors
								   @$doc_interaction = total_doctor_interaction($userID); //Total Doctor interaction
								   $child_users=count(get_child_user($userID));  //Get Team total team members

								   for ($iDay = 30; $iDay >= 0; $iDay--) {
									   @$aDays[31 - $iDay] = date('Y-m-d 00:00:00', strtotime("-" . $iDay . " day"));
								   }
								   @$total_doc_interaction= count(array_intersect($doc_interaction,$aDays));
								   @$week_secondary=total_secondary_analysis($weekly,$userid);
								   @$weekproductive_report =total_productive_analysis($weekly,$userid);
								   @$weeknoroder_report=total_noorder_met_analysis($weekly,$userid);
								   @$weeknotmet_report=total_not_met_analysis($weekly,$userid);
								   /*For this week*/
								   $weeksecondary_report = $week_secondary->total_secondry;  //for secondary
								   ?>
								   <tr>
									   <td><?=$user_name ?></td>
									   <td><?=$get_boss_name ?></td>
									   <td><?=$get_designation->designation_name ?></td>
									   <td><?=$total_doctors ?></td>
									   <td><?=$total_doc_interaction ?></td>
									   <td><?=$child_users ?></td>
									   <?php if(!empty($weeksecondary_report)){ ?>
										   <td><?=number_format($weeksecondary_report,2);?></td>
									   <?php }else{ ?>
										   <td>0</td>
									   <?php } ?>
									   <?php if(!empty($weekproductive_report)){ ?>
										   <td><?=$weekproductive_report;?></td>
									   <?php }else{ ?>
										   <td>0</td>
									   <?php } ?>
									   <?php if(!empty($weeknoroder_report)){ ?>
										   <td><?=$weeknoroder_report;?></td>
									   <?php }else{ ?>
										   <td>0</td>
									   <?php } ?>
									   <?php if(!empty($weeknotmet_report)){ ?>
										   <td><?=$weeknotmet_report;?></td>
									   <?php }else{ ?>
										   <td>0</td>
									   <?php } ?>
								   </tr>
							   <?php
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
		});
	});


</script>
