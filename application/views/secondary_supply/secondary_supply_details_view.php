<?php
/*
New Module Developed by:
* NITIN KUMAR
* Created On: 23-August-2019
 */
$doc_secondary_list = json_decode(file_get_contents ("ReportJSON/doc_secondary_supply.json"),true);
$pharma_secondary_list = json_decode(file_get_contents ("ReportJSON/phar_secondary_supply.json"),true);

?>



<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style>
@media
	only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px)  {
td {	padding-left: 60% !important;		}
		/*		Label the data		*/
		td:nth-of-type(1):before { content: "Date"; }
		td:nth-of-type(2):before { content: "Doctor/Sub Dealer Name"; }
		td:nth-of-type(3):before { content: " Supply by Dealer/pharmacy"; }
		td:nth-of-type(4):before { content: "Secondary Sale "; }
		td:nth-of-type(5):before { content: "Remains"; }
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
            <!-- /.box-header -->
            <div class="box-body">
              <p style="padding: inherit;"> <strong>Filters </strong></p>
            <div class="row" style="padding: 10px 65px 25px;">
              <div class="col-md-12">
                <strong>To Date('Month/Date/Year'):</strong>
                <input name="min" id="min" type="text" style="text-align: center;margin-left: 7px;">
                &nbsp;&nbsp;&nbsp;<strong style="margin-left: 30px;">From Date('Month/Date/Year'):</strong>
                <input name="max" id="max" type="text" style="text-align: center;margin-left: 5px;">
              </div>
            </div>

            <div class="row" style="padding: 10px 65px 25px;">
              <div class="col-md-12">
                <strong>Doctor/Pharamcy:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="search-doc" id="search-doc" type="text">
                &nbsp;&nbsp;&nbsp;<strong style="margin-left: 30px;">Supply by Dealer/pharmacy:</strong>&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="search-dealer" id="search-dealer" type="text">
              </div>
           </div>
          
          </br>
          </br>
            <div class="table-responsive">
              <table id="example2" class="table table-bordered table-striped">
					 <thead>
						<tr>
						  <th>Date('Year/Month/Date')</th>
						  <th>Doctor/Sub Dealer Name</th>
						  <th>Supply by Dealer/pharmacy</th>
						  <th>Interaction Secondary</th>
						  <th>Actual Secondary</th>
						  <th>Action</th>
						</tr>
					</thead>
					<tbody>
              <?php
			   if(!empty($doc_secondary_list)){
			  foreach($doc_secondary_list as $k_c=>$val_c){
			  	if(!is_admin()){
						if(in_array($val_c['user_id'], $allchilds)){
							if($val_c['secondarysale']!=''){
								?>
								<tr>
									<td>
										<?=date('Y/m/d', strtotime($val_c['date_of_interaction']));?>
									</td>

									<td>
										<?=$val_c['doctorname'];?>
									</td>
									<td>
										<?=$val_c['dealer_name'];?>
									</td>

									<td>
										<?=$val_c['secondarysale'];?>
									</td>

									<td>
										<?php
										if($val_c['actualsale']!=0){
											//$remais = ($val_c->secondarysale)-($val_c->actualsale);
											$remais = ($val_c['actualsale']);
											echo $remais;
										}
										else{
											echo "--";
										}
										?>

									</td>
									<td>
										<?php
										if($val_c['close_status']==0){
											?>
											<a href="<?php echo base_url()."secondary_supply/secondary_supply/close_secondary/"
												.urisafeencode($val_c['id']);?>" onclick="return confirm('Are you sure want to Close ' +
								 'this Secondary Sale.')" class=""><button type="button" class="btn btn-warning">Close</button></a>

											<button type="button" class="btn btn-info" data-toggle="modal"
													data-target="#modal_info_doctor<?=$val_c['id'] ?>">

												Supply

											</button>

										<?php }else{ ?>
											<button type="button" class="btn btn-success">Closed</button>
										<?php } ?>
									</td>
								</tr>
							<?php  }
						}
				}else{
					if($val_c['secondarysale']!=''){
						?>
						<tr>
							<td>
								<?=date('Y/m/d', strtotime($val_c['date_of_interaction']));?>
							</td>

							<td>
								<?=$val_c['doctorname'];?>
							</td>
							<td>
								<?=$val_c['dealer_name'];?>
							</td>

							<td>
								<?=$val_c['secondarysale'];?>
							</td>

							<td>
								<?php
								if($val_c['actualsale']!=0){
									//$remais = ($val_c->secondarysale)-($val_c->actualsale);
									$remais = ($val_c['actualsale']);
									echo $remais;
								}
								else{
									echo "--";
								}
								?>

							</td>
							<td>
								<?php
								if($val_c['close_status']==0){
									?>
									<a href="<?php echo base_url()."secondary_supply/secondary_supply/close_secondary/"
										.urisafeencode($val_c['id']);?>" onclick="return confirm('Are you sure want to Close ' +
								 'this Secondary Sale.')" class=""><button type="button" class="btn btn-warning">Close</button></a>

									<button type="button" class="btn btn-info" data-toggle="modal"
											data-target="#modal_info_doctor<?=$val_c['id'] ?>">

										Supply

									</button>

								<?php }else{ ?>
									<button type="button" class="btn btn-success">Closed</button>
								<?php } ?>
							</td>
						</tr>
					<?php  }
				}

			     }
			   }
           		 // for pharma interaction list
			  if(!empty($pharma_secondary_list)){
			 foreach($pharma_secondary_list as $k_c=>$val_c){
				if(!is_admin()){
					if(in_array($val_c['user_id'], $allchilds)){
						if($val_c['secondarysale']!=''){
							?>
							<tr>
								<td>
									<?=date('Y/m/d', strtotime($val_c['date_of_interaction']));?>
								</td>
								<td>
									<?=$val_c['pharmaname'];?>
								</td>
								<td>
									<?=$val_c['dealer_name'];?>
								</td>
								<td>
									<?=$val_c['secondarysale'];?>
								</td>
								<td>
									<?php
									if($val_c['actualsale']!=0){
										// $remais = ($val_c->secondarysale)-($val_c->actualsale);
										$remais = $val_c['actualsale'];
										echo $remais;
									}
									else{
										echo "--";
									}
									?>
								</td>
								<td>
									<a href="<?php echo base_url()."secondary_supply/secondary_supply/close_secondary_pharmacy/"
										.urisafeencode($val_c['id']);?>" onclick="return confirm('Are you sure want to Close this ' +
							   'Secondary Sale.')" class=""><button type="button" class="btn btn-warning">Close</button></a>

									<button type="button" class="btn btn-info" data-toggle="modal"
											data-target="#modal_info_pharmacy<?=$val_c['id'] ?>">Supply</button>

								</td>
							</tr>
						<?php  }
					}
				}else{
					if($val_c['secondarysale']!=''){
						?>
						<tr>
							<td>
								<?=date('Y/m/d', strtotime($val_c['date_of_interaction']));?>
							</td>
							<td>
								<?=$val_c['pharmaname'];?>
							</td>
							<td>
								<?=$val_c['dealer_name'];?>
							</td>
							<td>
								<?=$val_c['secondarysale'];?>
							</td>
							<td>
								<?php
								if($val_c['actualsale']!=0){
									// $remais = ($val_c->secondarysale)-($val_c->actualsale);
									$remais = $val_c['actualsale'];
									echo $remais;
								}
								else{
									echo "--";
								}
								?>
							</td>
							<td>
								<a href="<?php echo base_url()."secondary_supply/secondary_supply/close_secondary_pharmacy/"
									.urisafeencode($val_c['id']);?>" onclick="return confirm('Are you sure want to Close this ' +
							   'Secondary Sale.')" class=""><button type="button" class="btn btn-warning">Close</button></a>

								<button type="button" class="btn btn-info" data-toggle="modal"
										data-target="#modal_info_pharmacy<?=$val_c['id'] ?>">Supply</button>

							</td>
						</tr>
					<?php  }
				}

			 }
				}
				?>

		</tbody>
</table>

          <p><?php /* echo $links; */ ?></p>
          </div>
            <!-- /.box-body -->
            </div></div>
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
            var table = $('#example2').DataTable();

            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
              table.draw();
            });

            $('#search-doc').keyup(function () {
              table
              .column(1)
              .search(this.value)
              .draw();
            });
            $('#search-dealer').keyup(function () {
              table
              .column(2)
              .search(this.value)
              .draw();
            });

        });
</script> 
