<?php



/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

?>



<body class="hold-transition login-page">

<div class="login-box">

  <div class="login-logo">

      <a href="http://bjainpharma.com/">

        

          <img src="<?=base_url();?>/design/bjain_pharma/bjain_logo.png" alt=""/>

          

      </a>

    

  </div>

  <!-- /.login-logo -->

  <div class="login-box-body">

    <p class="login-box-msg">Sign in</p>

    



    <?php echo get_flash();

    echo form_open_multipart($action);

    ?>

      <div class="form-group has-feedback">

        <input type="email" name="email" class="form-control" placeholder="Email">

        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

      </div>

      <div class="form-group has-feedback" style="width: 100%; display: inline-flex;">

		  <input id="pass_log_id" type="password" name="password" class="form-control" placeholder="Password">
		  <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password" style="padding: 10px; cursor: pointer;"></span>


<!--		  <input type="password" name="password" class="form-control" placeholder="Password" id="myInput">-->
<!--		<span class="glyphicon glyphicon-eye-open" onclick="myFunction()" style="padding: 10px; cursor: pointer;"></span>-->
      </div>

<script>
    $(document).on('click', '.toggle-password', function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#pass_log_id");
        input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
    });
</script>

      <div class="row">

        <div class="col-xs-8">

<!--          <div class="checkbox icheck">

            <label>

              <input type="checkbox"> Remember Me

            </label>

          </div>-->

        </div>

        <!-- /.col -->

        <div class="col-xs-4">

          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>

        </div>

        <!-- /.col -->

      </div>

   

    <?php echo form_close(); ?>



<!--    <div class="social-auth-links text-center">

      <p>- OR -</p>

      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using

        Facebook</a>

      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using

        Google+</a>

    </div>-->

    <!-- /.social-auth-links -->



<!--    <a href="#">I forgot my password</a><br>

    <a href="register.html" class="text-center">Register a new membership</a>-->



  </div>

  <!-- /.login-box-body -->

</div>

<script>
    $(document).ready(function() {
        $("html").on("contextmenu",function(){
            return false;
        });
    });


    // function myFunction() {
    //     var x = document.getElementById("myInput");
    //     if (x.type === "password") {
    //         x.type = "text";
    //     } else {
    //         x.type = "password";
    //     }
    // }
</script>
