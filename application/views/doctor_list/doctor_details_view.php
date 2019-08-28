<?php



/* 

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */



//  $dealer_data = json_decode($dealer_list);   // for all active dealers 

// $pharmacy_data = $pharma_list;

//  $dealer_data = json_decode($list_of_dealer_pharma); // list of dealers and pharmacy who will be add to the doctor

//pr($pharmacy_data); die;

  $doc_info = json_decode($doctor_data);

// $ms = json_decode($meeting_sample);



// $team_list=json_decode($users_team);  // show child and boss users

 

//  pr($doc_info); die;

  

?>

<!--<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style>
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

<div class="content-wrapper modal-open">

   

    <!-- Main content -->
    <section class="content">

      <div class="row">

        <div class="col-xs-12">

		<?php echo get_flash(); ?>

          <div class="box">

            <div class="box-header">

                <a href="<?= base_url();?>doctors/doctor/add_list"> <h3 class="box-title"><button type="button" class="btn btn-block btn-success">Add New</button></h3></a>
            </div>

            <!-- /.box-header -->

            <div class="box-body">

                <table id="example2" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th> Name</th>
							<th> Email</th>
							<th>Phone Number </th>
							<th>City </th>
							<th>City Pincode</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody>
                                       
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



<script type="text/javascript">
     $(document).ready(function() {
    $('#example2').DataTable( {

//        "aLengthMenu":  [[25, 50, 75, -1], [25, 50, 75, "All"]],
//        "iDisplayLength": 157,

//        "ajax": "<?php echo base_url()?>radar/customer/servserside_dtb"
//         dom: 'Bfrtip',
////         buttons: [
////             'csv', 'print',
////         ],
        "processing": true,
	    "serverSide": true,
	    "ajax":{
		     "url": "<?php echo base_url()?>doctors/doctor/doctor_master_details",
		     "dataType": "json",
		     "type": "POST",
		     "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
		                 }
                  },
	    	"columns": [
		          { "data": "Name" },
		          { "data": "Email" },
                  { "data": "Phone Number" },
                  { "data": 'City' },
                  { "data": "City Pincode" },
                  { "data": "Action" }
		       ],


    } );
});


</script>
