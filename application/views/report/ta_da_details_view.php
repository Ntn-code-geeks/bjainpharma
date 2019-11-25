<?php



/* 

 * Niraj Kumar

 * Dated: 25-oct-2017

 * 

 * show all Retail pharmacy

 */



	$tada_data = json_decode($user_tada_report);   // for all tada user report list
	


?>

<!--<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>-->
<!--<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<!--<style>
	@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
		/* Label the data */
		td:nth-of-type(1):before { content: "Name"; }
		td:nth-of-type(2):before { content: "Email"; }
		td:nth-of-type(3):before { content: "Phone Number"; }
		td:nth-of-type(4):before { content: "City"; }
		td:nth-of-type(5):before { content: "City Pincode"; }
		td:nth-of-type(6):before { content: "Action"; }
	}
</style>-->



<div class="content-wrapper modal-open">
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
							<th> Employee Name</th>
							<th> Month</th>
							<!-- <th>Grant Total </th> -->
                            <th>Manager Approved or Not</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($tada_data)){ foreach($tada_data as $k_c=>$val_c){  ?>
								<tr>
									<td> <?=$val_c->name;?></td>
									<td><?=$val_c->month_year;?></td>
									<!-- <td><?=$val_c->grant_total;?></td> -->
                                                                        <td><?php 
                                                                                if(empty($val_c->manager_id)){
                                                                                    echo 'Not Aproved';
                                                                                }else{
                                                                                    echo 'Approved by Manager';
                                                                                }
                                                                         ?></td>
                                                                        
                                                                        
								<td>
                                                                            
        <?php

            if(empty($val_c->manager_id)){
                ?>
             <a href="<?php echo base_url()."reports/reports/ta_da_manager_view/". urisafeencode($val_c->id).'/'.urisafeencode($val_c->name).'/'.urisafeencode($val_c->month_year).'/'.urisafeencode($val_c->grant_total);?>"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a>

          <?php  }elseif(!is_admin()){
               ?>
             <a href="<?php echo base_url()."reports/reports/ta_da_manager_view/". urisafeencode($val_c->id).'/'.urisafeencode($val_c->name).'/'.urisafeencode($val_c->month_year).'/'.urisafeencode($val_c->grant_total).'/'.urisafeencode($val_c->manager_total_amount);?>"><button type="button" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i></button></a>

           <?php }elseif(is_admin() && !empty($val_c->manager_id) && empty($val_c->admin_id)){  ?>
             <a href="<?php echo base_url()."reports/reports/ta_da_admin_view/". urisafeencode($val_c->id).'/'.urisafeencode($val_c->name).'/'.urisafeencode($val_c->month_year).'/'.urisafeencode($val_c->grant_total).'/'.urisafeencode($val_c->manager_total_amount);?>"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
      <?php   }elseif(is_admin() && !empty($val_c->manager_id) && !empty($val_c->admin_id)){ ?>
             <a href="<?php echo base_url()."reports/reports/ta_da_admin_view/". urisafeencode($val_c->id).'/'.urisafeencode($val_c->name).'/'.urisafeencode($val_c->month_year).'/'.urisafeencode($val_c->grant_total).'/'.urisafeencode($val_c->manager_total_amount).'/'.urisafeencode($val_c->admin_total_amount);?>"><button type="button" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
      <?php     }
     ?>
										
									</td>
									</tr>

							

						<?php }} ?>
					</tbody>
				 </table>

            </div>

            <!-- /.box-body -->

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

<script type="text/javascript">
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