<?php



/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

//$users = json_decode(users_list_pharma());

//pr(logged_user_cities()); die;

?>

<style>
#myInput {
	background-position: 10px 12px;
	background-repeat: no-repeat;
	width: 96%;
	font-size: 15px;
	padding: 5px;
	margin: 5px;
	border: 1px solid #ddd;
}
</style>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper" style="background-color: #ffffff1a;">

<header class="main-header">



    <!-- Logo -->

   

      <a href="http://bjainpharma.com/" class="logo">

          <img style="height: 43px;" src="<?=base_url();?>/design/bjain_pharma/bjain_logo.png" alt=""/>

   

      </a>

    

<!--<button onclick="history.go(-1);"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>-->









    <!-- Header Navbar: style can be found in header.less -->

    <nav class="navbar navbar-static-top">

    

      

      <!-- Navbar Right Menu -->

      <div class="navbar-custom-menu">

        <ul class="nav navbar-nav">

          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
             <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown">-->
              <!--<img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
              <!--<span class="hidden-xs"><?=$this->session->userdata('userName');?></span>-->
            <!--</a>-->
              <!--<div class="pull-right">-->
                  <a href="<?= base_url();?>invoice_admin/invoice_user/logout" class="dropdown-toggle">Sign out</a>
                <!--</div>-->
            
          </li>
          <!-- Control Sidebar Toggle Button -->
            <!--<li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>-->
        </ul>
      </div>
     </nav>
  </header>

  

<script>
function myFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";

        }
    }
}
</script>