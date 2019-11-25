<?php
/*
 * Developer: Nitin Kumar
 * Dated: 05-09-2019
 * Email: sss.shailesh@gmail.com
 *
 * for show doctor interaction
 *
 */
$data = file_get_contents ("ReportJSON/IntrctionDealerSumry.json");
$json = json_decode($data, true);

if(!is_admin()){
	$usrID=logged_user_data();
	$uID=array($usrID);
	$childData=get_child_user($usrID);
	$childCount=count(get_child_user($usrID));
	if($childCount > 1){
		$childArr=array_merge($childData,$uID);
	}else{
		$childArr=$uID;
	}
	$dealer_int=$json;
}else{
	$dealer_int=$json;
}
    $secondary_sum = 0; 

    

?>

        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap.min.css">
	
	<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
	
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
	
        <?php if(is_admin()){  ?>
        <script type="text/javascript" class="init">
            $(document).ready(function() {
                    var table = $('#example').DataTable( {
                            lengthChange: false,
                            buttons: [ 'excel']
                    });
                    table.buttons().container()
                    .appendTo( '#example_wrapper .col-sm-6:eq(0)' );
            });
	</script>
        <?php } ?>
<style>



@media



	only screen and (max-width: 760px),



	(min-device-width: 768px) and (max-device-width: 1024px)  {

	

		/*



		Label the data



		*/



		td:nth-of-type(1):before { content: "Date"; }

		td:nth-of-type(2):before { content: "Interaction With"; }

		td:nth-of-type(3):before { content: " Interaction By"; }

		td:nth-of-type(4):before { content: "City"; }

		td:nth-of-type(5):before { content: "Met/Not Met"; }

		td:nth-of-type(6):before { content: "Primary Sale"; }

		td:nth-of-type(7):before { content: "Payment"; }

		td:nth-of-type(8):before { content: "Stock"; }

		td:nth-of-type(9):before { content: "Remark"; }

		td:nth-of-type(10):before { content: "Action"; }



	}



	



</style>

<div class="content-wrapper">



   <section class="content">

<div class="row">

        <div class="col-md-12">

            <div class="box box-default">

         

            <!-- /.box-header -->

            <div class="box-body">

                      	<div class="fw-container">		
		<div class="fw-body">
			<div class="content">  

					<table id="example" class="table table-striped table-bordered">

					 <thead>

						<tr>

						  <th>Date</th>

						  <th>Interaction With</th>

						  <th>Interaction By</th>

						  <th>City</th>

						  <th>Met/Not Met</th>

						  <th>Primary Sale</th>

						  <th>Payment</th>

						  <th>Stock</th>

						  <th>Remark</th>

						  <th>Action</th>



						</tr>



					</thead>

					<tbody>



                <?php

                 if(!empty($dealer_int)){
                 	if(is_admin()){
						foreach($dealer_int['dealer_info'] as $k_d=>$val_d){
							?>
							<tr>

								<td>

									<?= date('Y/m/d',strtotime($val_d['date'])); ?>

								</td>

								<td>

									<?=$val_d['customer'];?>

								</td>

								<td>

									<?=$val_d['user'];?>

								</td>

								<td>

									<?=$val_d['city'];?>

								</td>

								<td>

									<?php



									if($val_d['metnotmet']==TRUE ){

										echo "Met";

									}

									else if($val_d['metnotmet']==FALSE && $val_d['metnotmet']!=NULL ){



										echo "Not Met" ;

									}

									?>

								</td>

								<td>

									<?=$val_d['sale'];?>
									<?php $secondary_sum=$secondary_sum+$val_d['sale']?>
									<?php if(!empty($val_d['sale'])){?>
										<br><a href="<?php echo base_url()."order/interaction_order/view_order/". urisafeencode($val_d['id']).'/'. urisafeencode($val_d['d_id']);?>"  target="_blank">View Product</a>
									<?php }?>
								</td>

								<td>

									<?=$val_d['payment'];?>

								</td>

								<td>

									<?=$val_d['stock'];?>

								</td>

								<td>

									<?=$val_d['remark'];?>

								</td>

								<td>

									<?php

									if(is_admin()){

										?>



										<a href="<?php echo base_url()."interaction/edit_dealer_interaction/". urisafeencode($val_d['id'] );?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>



									<?php } ?>

								</td>

							</tr>

						<?php  }
					}else{
						foreach($dealer_int['dealer_info'] as $k_d=>$val_d) {
							if (in_array($val_d['user_id'], $childArr)) {	?>
								<tr>

									<td>

										<?= date('Y/m/d', strtotime($val_d['date'])); ?>

									</td>

									<td>

										<?= $val_d['customer']; ?>

									</td>

									<td>

										<?= $val_d['user']; ?>

									</td>

									<td>

										<?= $val_d['city']; ?>

									</td>

									<td>

										<?php


										if ($val_d['metnotmet'] == TRUE) {

											echo "Met";

										} else if ($val_d['metnotmet'] == FALSE && $val_d['metnotmet'] != NULL) {


											echo "Not Met";

										}

										?>

									</td>

									<td>

										<?= $val_d['sale']; ?>
										<?php $secondary_sum = $secondary_sum + $val_d['sale'] ?>
										<?php if (!empty($val_d['sale'])) { ?>
											<br><a
												href="<?php echo base_url() . "order/interaction_order/view_order/" . urisafeencode($val_d['id']) . '/' . urisafeencode($val_d['d_id']); ?>"
												target="_blank">View Product</a>
										<?php } ?>
									</td>

									<td>

										<?= $val_d['payment']; ?>

									</td>

									<td>

										<?= $val_d['stock']; ?>

									</td>

									<td>

										<?= $val_d['remark']; ?>

									</td>

									<td>

										<?php

										if (is_admin()) {

											?>


											<a href="<?php echo base_url() . "interaction/edit_dealer_interaction/" . urisafeencode($val_d['id']); ?>">
												<button type="button" class="btn btn-info"><i
														class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
											</a>


										<?php } ?>

									</td>

								</tr>
							<?php }
						}
					}

                 } ?>

                 

    

</tbody>
<?php if($secondary_sum!=0){?>
<tfooter><tr><td rowspan="5" colspan="5" style=""><strong>Grand Total</strong></td><td rowspan="" colspan="" style=""><strong><?=$secondary_sum?></strong></td></tr></tfooter>
<?php }?>

</table>

                
                        </div></div></div>
                

                

              

            </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->

        </div>

        <!-- /.col -->



     </div>



 </section>

    <!-- /.content -->

  </div>
  <?php if(!is_admin()){  ?>
  <script>  
  $(function () {  
    $('#example').DataTable({     
      'responsive' : true,    
      'paging'      : true, 
      'lengthChange': true,    
      'searching'   : true,    
      'ordering'    : true,    
      'info' : true,   
      'autoWidth'   : true,    
    })  
  })
</script>
  <?php } ?>
