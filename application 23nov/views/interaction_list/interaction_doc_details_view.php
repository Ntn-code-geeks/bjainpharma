<?php
/* 
 * Developer: Nitin Kumar
 * Dated: 05-09-2019
 * Email: sss.shailesh@gmail.com
 * 
 * for show doctor interaction 
 * 
 */
$data_doc = file_get_contents ("ReportJSON/IntrctionDocSumry.json");
$json_doc = json_decode($data_doc, true);
$data_phr = file_get_contents ("ReportJSON/IntrctionPharmaSumry.json");
$json_phr = json_decode($data_phr, true);


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
	$doc_info=$json_doc;
	$pharma_int= $json_phr;
}else{
	$doc_info=$json_doc;
	$pharma_int= $json_phr;
}

$secondary_sum=0;
    
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
		} );
		table.buttons().container()
		.appendTo( '#example_wrapper .col-sm-6:eq(0)' );
		} );
	</script>
        <?php } ?>
<div class="content-wrapper">

   <section class="content">
<div class="row">
    <?= get_flash();?>
        <div class="col-md-12">
            <div class="box box-default">
                
        <div class="box-header with-border">

        </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="row" style="padding: 10px 175px 25px;">
					<div class="col-md-12">
						<strong>To Date('Month/Date/Year'):</strong>
						<input name="min" id="min" type="text" style="text-align: center;margin-left: 7px;">
						&nbsp;&nbsp;&nbsp;<strong style="margin-left: 30px;">From Date('Month/Date/Year'):</strong>
						<input name="max" id="max" type="text" style="text-align: center;margin-left: 5px;">
					</div>
				</div>


			<table id="example" class="table table-bordered table-striped">
				<thead>
				<tr>
					<th>Date</th>
					<th>Interaction With</th>
					<th>Interaction By</th>
					<th>City</th>
					<th>Category</th>
<!--					<th>Sample</th>-->
					<th>Met/Not Met</th>
					<th>Secondary Sale</th>
					<th>Remark</th>
					<?php if(is_admin()){ ?>
					<th>Action</th>
					<?php } ?>
				</tr>
				</thead>
			<tbody>
				<?php	//Doctor Interactions
				if(!empty($doc_info)){
				if(is_admin()){
				foreach($doc_info['doc_info'] as $k_doc=>$val_doc){
				?>
				<tr>
					<td>
						<?= date('Y/m/d',strtotime($val_doc['date'])); ?>
					</td>
					<td>
						<?=$val_doc['customer'];?>
					</td>
					<td>
						<?=$val_doc['user'];?>
					</td>
					<td>
						<?=$val_doc['city'];?>
					</td>
					<td>Doctor</td>
					<td>
						<?php
						if($val_doc['metnotmet']==TRUE ){
							echo "Met";
						}else if($val_doc['metnotmet']==FALSE && $val_doc['metnotmet']!=NULL ){
							echo "Not Met" ;
						}
						?>
					</td>

					<td>
						<?=$val_doc['secondary_sale'];?>
						<?php $secondary_sum=$secondary_sum+$val_doc['secondary_sale']?>
						<?php if(!empty($val_doc['secondary_sale']) && $val_doc['secondary_sale']!=0){?>
							<br><a href="<?php echo base_url()."order/interaction_order/view_order/". urisafeencode($val_doc['id']).'/'. urisafeencode($val_doc['doc_id']);?>"  target="_blank">View Product</a>
						<?php }?>
					</td>

					<td>
						<?=$val_doc['remark'];?>
					</td>

					<td>
						<?php   if(is_admin()){ ?>
							<a href="<?php echo base_url()."interaction/edit_doc_interaction/". urisafeencode($val_doc['id'] );?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
						<?php } ?>
					</td>
				</tr>
				<?php  }
				}else{
				foreach($doc_info['doc_info'] as $k_doc=>$val_doc){
					if(in_array($val_doc['user_id'],$childArr)){  ?>
						<tr>
							<td>
								<?= date('Y/m/d',strtotime($val_doc['date'])); ?>
							</td>
							<td>
								<?=$val_doc['customer'];?>
							</td>
							<td>
								<?=$val_doc['user'];?>
							</td>
							<td>
								<?=$val_doc['city'];?>
							</td>
							<td>Doctor</td>
							<td>
								<?php

								if($val_doc['metnotmet']==TRUE ){
									echo "Met";
								}
								else if($val_doc['metnotmet']==FALSE && $val_doc['metnotmet']!=NULL ){

									echo "Not Met" ;
								}
								?>

							</td>

							<td>
								<?=$val_doc['secondary_sale'];?>
								<?php $secondary_sum=$secondary_sum+$val_doc['secondary_sale']?>
								<?php if(!empty($val_doc['secondary_sale']) && $val_doc['secondary_sale']!=0){?>
									<br><a href="<?php echo base_url()."order/interaction_order/view_order/". urisafeencode($val_doc['id']).'/'. urisafeencode($val_doc['doc_id']);?>"  target="_blank">View Product</a>
								<?php }?>
							</td>

							<td>
								<?=$val_doc['remark'];?>
							</td>
							<?php   if(is_admin()){ ?>
							<td>
									<a href="<?php echo base_url()."interaction/edit_doc_interaction/". urisafeencode($val_doc['id'] );?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
							</td>
							<?php } ?>
						</tr>
				<?php	}
				}
				}
				} ?>

				<?php   //Sub Dealers/ Pharmacy Interactions
				if(!empty($pharma_int)){
						if(is_admin()){
							foreach($pharma_int['pharmacy_info'] as $k_p=>$val_p){	?>
								</tr>
								<td>
									<?= date('Y/m/d',strtotime($val_p['date'])); ?>
								</td>
								<td>
									<?=$val_p['customer'];?>
								</td>
								<td>
									<?=$val_p['user'];?>
								</td>
								<td>
									<?=$val_p['city'];?>
								</td>
								<td>Sub Dealer</td>
								<td>
									<?php
									if($val_p['metnotmet']==TRUE ){
										echo "Met";
									}else if($val_p['metnotmet']==FALSE && $val_p['metnotmet']!=NULL ){
										echo "Not Met" ;
									} ?>
								</td>
								<td>
									<?=$val_p['secondary_sale'];?>
									<?php $secondary_sum=$secondary_sum+$val_p['secondary_sale']?>
									<?php if(!empty($val_p['secondary_sale']) && $val_p['secondary_sale']!=0){?>
										<br><a href="<?php echo base_url()."order/interaction_order/view_order/". urisafeencode($val_p['id']).'/'. urisafeencode($val_p['pharma_id']);?>"  target="_blank">View Product</a>
									<?php }?>
								</td>
								<td>
									<?=$val_p['remark'];?>
								</td>
								<td>
									<?php
									if(is_admin() ){ ?>
										<a href="<?php echo base_url()."interaction/edit_pharma_interaction/". urisafeencode($val_p['id'] );?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
									<?php } ?>
								</td>
								</tr>
							<?php  }
						}else{
							foreach($pharma_int['pharmacy_info'] as $k_p=>$val_p) {
								if (in_array($val_p['user_id'], $childArr)) { ?>
									<tr>
										<td>
											<?= date('Y/m/d', strtotime($val_p['date'])); ?>
										</td>
										<td>
											<?= $val_p['customer']; ?>
										</td>
										<td>
											<?= $val_p['user']; ?>
										</td>
										<td>
											<?= $val_p['city']; ?>
										</td>
										<td>Sub Dealer</td>
										<td>
											<?php if ($val_p['metnotmet'] == TRUE) {
												echo "Met";
											} else if ($val_p['metnotmet'] == FALSE && $val_p['metnotmet'] != NULL) {
												echo "Not Met";
											}	?>
										</td>
										<td>
											<?= $val_p['secondary_sale']; ?>
											<?php $secondary_sum = $secondary_sum + $val_p['secondary_sale'] ?>
											<?php if (!empty($val_p['secondary_sale']) && $val_p['secondary_sale'] != 0) { ?>
												<br><a
													href="<?php echo base_url() . "order/interaction_order/view_order/" . urisafeencode($val_p['id']) . '/' . urisafeencode($val_p['pharma_id']); ?>"
													target="_blank">View Product</a>
											<?php } ?>
										</td>
										<td>
											<?= $val_p['remark']; ?>
										</td>
										<td>
											<?php if (is_admin()) {	?>
	<a href="<?php echo base_url() . "interaction/edit_pharma_interaction/" . urisafeencode($val_p['id']); ?>">
		<button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
	</a>
											<?php } ?>
										</td>
									</tr>
								<?php }
							}
						}
					 }
				?>

</tbody>
<?php if($secondary_sum!=0){?>
<tfooter><tr><td rowspan="6" colspan="6" style=""><strong>Grand Total</strong></td><td rowspan="" colspan="" style=""><strong><?=number_format($secondary_sum,2);?></strong></td></tr></tfooter>
<?php }?>
</table>
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
<!--	<script src="<?= base_url()?>design/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>design/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>-->
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

<script>
    $(document).ready(function(){
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                var min = $('#min').datepicker("getDate");
                var max = $('#max').datepicker("getDate");
                var startDate = new Date(data[0]);
                if (min == null && max == null) { return true; }
                if (min == null && startDate <= max) { return true;}
                if(max == null && startDate >= min) {return true;}
                if (startDate <= max && startDate >= min) { return true; }
                return false;
            }
        );

        $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true, autoclose: true });
        $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true , autoclose: true});
        var table = $('#example').DataTable();

        // Event listener to the two range filtering inputs to redraw on input
        $('#min, #max').change(function () {
            table.draw();
        });


    });
</script>
