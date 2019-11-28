<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'ha ji'; die;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Bjain Pharma  | Bjain Pharma</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- daterange picker -->

  <link rel="stylesheet" href="<?=base_url();?>/design/bower_components/bootstrap-daterangepicker/daterangepicker.css">

  <!-- bootstrap datepicker -->

  <link rel="stylesheet" href="<?=base_url();?>/design/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

  <!-- iCheck for checkboxes and radio inputs -->

  <link rel="stylesheet" href="<?=base_url();?>/design/plugins/iCheck/all.css">

  <!-- Bootstrap Color Picker -->

  <link rel="stylesheet" href="<?=base_url();?>/design/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">

  <!-- Bootstrap time Picker -->

  <link rel="stylesheet" href="<?=base_url();?>/design/plugins/timepicker/bootstrap-timepicker.min.css">

  <!-- Select2 -->

  <link rel="stylesheet" href="<?=base_url();?>/design/bower_components/select2/dist/css/select2.min.css">



<!-- AdminLTE Skins. Choose a skin from the css/skins

       folder instead of downloading all of them to reduce the load. -->

  <link rel="stylesheet" href="<?=base_url();?>/design/css/skins/_all-skins.min.css">

<!-- jvectormap -->

  <link rel="stylesheet" href="<?=base_url();?>/design/bower_components/jvectormap/jquery-jvectormap.css">

<!-- Bootstrap 3.3.7 -->

  <link rel="stylesheet" href="<?=base_url();?>/design/bower_components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Font Awesome -->

  <link rel="stylesheet" href="<?=base_url();?>/design/bower_components/font-awesome/css/font-awesome.min.css">

  <!-- Ionicons -->

  <link rel="stylesheet" href="<?=base_url();?>/design/bower_components/Ionicons/css/ionicons.min.css">

  <!-- Theme style -->

  <link rel="stylesheet" href="<?=base_url();?>/design/css/AdminLTE.css">

  <!-- iCheck -->

  <link rel="stylesheet" href="<?=base_url();?>/design/plugins/iCheck/square/blue.css">

</head>

<body class="hold-transition login-page">


    <form role="form" method="post"  action="<?php echo base_url()."user/change_password"?>" enctype= "multipart/form-data">
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">

                    <h4 class="modal-title">Change Password</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group" >
                      <label>New Password *</label>
                      <input required class="form-control" id="password" name="password" placeholder="Enter Password..." type="password" >
                       <input class="form-control" name="user_id" value="<?=$userid?>" type="hidden" >
                    </div>  
                  </div>
                <button type="submit" class="btn btn-warning btn-block btn-flat">Save</button>
                </div>

              </div>
    </form>

     
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url();?>/design/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?=base_url();?>/design/plugins/iCheck/icheck.min.js"></script>
<!-- fullCalendar -->
<script src="<?=base_url();?>/design/bower_components/jquery-ui/jquery-ui.min.js"></script>

<script src="<?=base_url();?>/design/bower_components/moment/moment.js"></script>

<script src="<?=base_url();?>/design/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>

<!--Select2--> 
<script src="<?=base_url();?>/design/bower_components/select2/dist/js/select2.full.min.js"></script>



<!-- InputMask -->

<script src="<?=base_url();?>/design/plugins/input-mask/jquery.inputmask.js"></script>

<script src="<?=base_url();?>/design/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>

<script src="<?=base_url();?>/design/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<!-- date-range-picker -->

<script src="<?=base_url();?>/design/bower_components/moment/min/moment.min.js"></script>

<script src="<?=base_url();?>/design/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- bootstrap datepicker -->

<script src="<?=base_url();?>/design/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- bootstrap color picker -->

<script src="<?=base_url();?>/design/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

<!-- bootstrap time picker -->

<script src="<?=base_url();?>/design/plugins/timepicker/bootstrap-timepicker.min.js"></script>




<!-- FastClick -->

<script src="<?=base_url();?>/design/bower_components/fastclick/lib/fastclick.js"></script>

<!-- AdminLTE App -->

<script src="<?=base_url();?>/design/js/adminlte.min.js"></script>

<!-- Sparkline -->

<script src="<?=base_url();?>/design/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jvectormap  -->

<script src="<?=base_url();?>/design/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>

<script src="<?=base_url();?>/design/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- SlimScroll -->

<script src="<?=base_url();?>/design/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?=base_url();?>/design/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script src="<?=base_url();?>/design/js/highcharts.js"></script>
<script src="<?=base_url();?>/design/js/exporting.js"></script>
<?php die; ?>
 

    </body>
</html>
