<?php

/* 


 * Nitin Kumar


 * date : 23-10-2017


 * show list of users


 */
  $user_info = json_decode($user_data);
//  pr($user_info); die;
?>

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

<style>


  @media  only screen and (max-width: 760px),
  (min-device-width: 768px) and (max-device-width: 1024px)  {
    /*Label the data*/
  td:nth-of-type(1):before { content: "User Name"; }
  td:nth-of-type(2):before { content: "Email"; }
  td:nth-of-type(3):before { content: "Designation"; }
  td:nth-of-type(4):before { content: "SP Code"; }
  td:nth-of-type(5):before { content: "Employee Code"; }
  td:nth-of-type(6):before { content: "Sales Person Code"; }
  td:nth-of-type(7):before { content: "Action"; }
  }


</style>


<div class="content-wrapper">



    <!-- Main content -->

    <section class="content">

      <div class="row">

        <div class="col-xs-12">
   <?php echo get_flash(); ?>
          <div class="box">
            <div class="box-header">

                <a href="<?= base_url();?>admin_control/user_permission/add_user"> <h3 class="box-title"><button type="button" class="btn btn-block btn-success">Add New</button></h3></a>


            </div>


            <!-- /.box-header -->


            <div class="box-body">


                <table id="example2" class="table table-bordered table-striped">


                <thead>


                <tr>

                  <th> User Name</th>
                  <th> Email</th>
                  <th>Designation</th>
                  <th>SP Code</th>
                  <th>Employee Code</th>
          <th>Reporting Manager</th>
                  <th>Headquarter Pincode </th>
                  <th>Headquarter City </th>
                  <th>Action</th>

                </tr>


                </thead>


                <tbody>


                <?php
                $spCode=array();
                if(!empty($user_info)){foreach($user_info as $k_u=>$val_u){ ?>


        <tr>

                    <td><?=$val_u->name?></td>
                    <td><?=$val_u->email?></td>
                    <td><?=$val_u->designation_name?></td>
                    <td><?php
                        $sp=$val_u->sp_code;
                        $spCode=explode(',',$sp);
                        $countSP=count($spCode);
                        if($countSP > 2){ ?>
                        <button class="btn btn-info" data-toggle="modal" data-target="#myModal-<?=$val_u->id;?>"
                style="padding: 3px 6px !important;">SP
                        Code</button>
                            <div class="modal fade" id="myModal-<?=$val_u->id ?>" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title" style="text-align: center;"> SP Codes </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container col-md-12">
                                                <div class="row">
                                            <?php
                                            $codCount=0;
                                            foreach($spCode as $code){
                                                if($codCount==9){
                                                    echo "<br>";
                                                    $codCount++;
                                                }else{ ?>
                                                    <div class="col-md-3" style="width: auto;">
                                                        <p class="form-control" style=" border-radius: 5px;">
                                                        <?php echo $code; ?>
                                                        </p>
                                                    </div>
                                                <?php $codCount++; }
                                                ?>

                                            <?php }  ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }else{
                            echo @$spCode[0]."<br>";
                            echo @$spCode[1];
                        }  ?>

                    </td>
                    <td><?=$val_u->emp_code?></td>
          <td><?=get_user_name($val_u->bossid); ?></td>
                    <td><?=$val_u->hq_city_pincode?></td>
                    <td><?=$val_u->hq_city_name?></td>


          <td>


          <a href="<?php echo base_url()."admin_control/user_permission/add_user/". urisafeencode
            ($val_u->id);?>"><button type="button" class="btn btn-info" style="padding: 3px 6px
            !important;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>


                        <?php if($val_u->status==1){ ?>   | <a href="<?php echo base_url()."admin_control/user_permission/del_user/".urisafeencode($val_u->id);?>" onclick="return confirm('Are you sure want to In-Active this record.')" class=""><button type="button" class="btn btn-success" style="padding: 3px 4px !important;">Active</button></a><?php } ?>


                         <?php if($val_u->status==0){ ?>  | <a href="<?php echo base_url()."admin_control/user_permission/active_user/".urisafeencode($val_u->id);?>" onclick="return confirm('Are you sure want to Active this record.')" class=""><button type="button" class="btn btn-danger" style="padding: 3px 4px !important;">In-Active</button></a><?php } ?>


                   </td>


                </tr>


                    <?php }  } ?>


                


                </tbody>


              </table>


      </div>


          <!-- /.box -->


        </div>


        <!-- /.col -->


      </div>


      <!-- /.row -->


    </section>


    <!-- /.content -->



  </div>




<script>
  $(function () {
    $('#example2').DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength',
            'excel',
        ],
      'responsive' : true,
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
    'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
    })

  })
</script>
