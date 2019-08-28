<?php


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


    td:nth-of-type(2):before { content: "Source City"; }


    td:nth-of-type(3):before { content: "Destination City"; }


    td:nth-of-type(4):before { content: "Distance In KM"; }


    td:nth-of-type(5):before { content: "Fare In INR"; }


    td:nth-of-type(6):before { content: "Remark"; }


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

            <!-- /.box-header -->

            <div class="box-body">


                <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th> User Name</th>
                  <th> Date of Tour</th>
                  <th>Is Approved</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php 

                if((!empty($pendingData))){                  
                  foreach($pendingData as $tour){ 
                  ?>
         <tr>
                    <td><?=get_user_name($tour['crm_user_id'])?></td>
                    <td><?=$tour['dot']?></td>
                    <td><?php echo $tour['is_approved']==1? 'YES':'NO' ?></td>

          <td>
            <a href="<?php echo base_url()."tour_plan/tour_plan/pending_user_tour/".urisafeencode($tour['crm_user_id']); ?>">
            <button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>


          </td>


                </tr>


                    <?php }  }  ?>


                


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