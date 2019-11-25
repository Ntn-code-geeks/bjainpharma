<?php

/* 


 * Niraj Kumar


 * date : 23-10-2017


 * show list of users


 */
  //$user_info = json_decode($user_data);
//  pr($user_info); die;
//pr($leave_list);
?>


<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>


<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


<style>


@media


	only screen and (max-width: 760px),


	(min-device-width: 768px) and (max-device-width: 1024px)  {


		/*


		Label the data


		*/

    td:nth-of-type(1):before { content: "User Name"; }
		td:nth-of-type(2):before { content: "From Date"; }
		td:nth-of-type(3):before { content: "To City"; }
		td:nth-of-type(4):before { content: "Remark"; }
		td:nth-of-type(5):before { content: "Status"; }
		td:nth-of-type(6):before { content: "Action"; }


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


                <a href="<?= base_url().$action;?>"> <h3 class="box-title"><button type="button" class="btn btn-block
                 btn-success">Apply Leave</button></h3></a>


            </div>


            <!-- /.box-header -->


            <div class="box-body">


                <table id="example2" class="table table-bordered table-striped">

                <thead>
                <tr>
                  <th>User Name</th>
                  <th>From Date</th>
                  <th>To Date</th>
                  <th>Remark </th>
                  <th>Status</th>
				  <th>Action</th>
                </tr>
                </thead>
                <tbody>
 <?php
                if(is_admin()){
                    if(!empty($leave_list)){
                        foreach($leave_list as $leave){    ?>
                                <tr>
                                    <td><?= get_user_name($leave['user_id'])?></td>

                                    <td><?= date('d-m-Y',strtotime($leave['from_date']))?></td>
                                    <td><?= date('d-m-Y',strtotime($leave['to_date']))?></td>
                                    <td><?=substr($leave['remark'], 0, 20)."...";?></td>
                                    <td>
                                        <?php if($leave['leave_status']==1 && $leave['status']==1 ){?>
                                            <span style="color: red;">Pending</span>
                                        <?php }if($leave['leave_status']==0){ ?>
                                            <span style="color: red; font-weight: bold;">Cancelled</span>
                                        <?php }if($leave['status']==0){ ?>
                                            <span style="color: green; font-weight: bold;">Approved</span>
                                        <?php } ?></td>


                                    <td>
                                        <?php
                                        if($leave['leave_status']==1 && $leave['status']==1){?>
                                            <a href="<?php echo
                                                base_url()."leave/user_leave/edit_leave/". urisafeencode($leave['leave_id']);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>


                                            <?php //if(is_admin()){  ?>
                                            <a   onclick="return confirm('Are you sure? You want to cancel leave.')" title="Cancel Leave" href="<?php echo base_url()."leave/user_leave/cancel_leave/". urisafeencode($leave['leave_id']);?>"><button type="button" class="btn btn-danger"><i class="fa fa-remove" aria-hidden="true"></i></button></a>
                                            <?php //}
                                        } ?>


                                    </td>


                                </tr>


                            <?php  }
                          }
                }else{
                    $bosID=logged_user_data();
                    $child_userID=get_child_user($bosID);
                    if(!empty($child_userID)){
                        if(!empty($leave_list)){
                            foreach($leave_list as $leave){
                                if(in_array($leave['user_id'],$child_userID)) {  ?>
                                    <tr>
                                        <td><?= get_user_name($leave['user_id'])?></td>

                                        <td><?= date('d-m-Y',strtotime($leave['from_date']))?></td>
                                        <td><?= date('d-m-Y',strtotime($leave['to_date']))?></td>
                                        <td><?=substr($leave['remark'], 0, 20)."...";?></td>
                                        <td>
                                            <?php if($leave['leave_status']==1 && $leave['status']==1 ){?>
                                                <span style="color: red;">Pending</span>
                                            <?php }if($leave['leave_status']==0){ ?>
                                                <span style="color: red; font-weight: bold;">Cancelled</span>
                                            <?php }if($leave['status']==0){ ?>
                                                <span style="color: green; font-weight: bold;">Approved</span>
                                            <?php } ?></td>


                                        <td>
                                            <?php
                                            if($leave['leave_status']==1 && $leave['status']==1){?>
                                                <a href="<?php echo
                                                    base_url()."leave/user_leave/edit_leave/". urisafeencode($leave['leave_id']);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>


                                                <?php //if(is_admin()){  ?>
                                                <a   onclick="return confirm('Are you sure? You want to cancel leave.')" title="Cancel Leave" href="<?php echo base_url()."leave/user_leave/cancel_leave/". urisafeencode($leave['leave_id']);?>"><button type="button" class="btn btn-danger"><i class="fa fa-remove" aria-hidden="true"></i></button></a>
                                                <?php //}
                                            } ?>


                                        </td>


                                    </tr>


                                <?php  } }  } }
                }
                ?>

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


<script src="<?= base_url()?>design/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>

<script src="<?= base_url()?>design/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

        


<script>


  $(function () {


    $('#example2').DataTable({


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