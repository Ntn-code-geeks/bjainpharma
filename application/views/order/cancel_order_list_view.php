<?php/*  * Niraj Kumar * date : 23-10-2017 * show list of users */ // $user_info = json_decode($user_data);//  pr($user_info); die;?><link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/><link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"><style>@media	only screen and (max-width: 760px),	(min-device-width: 768px) and (max-device-width: 1024px)  {		/*		Label the data		*/		td:nth-of-type(1):before { content: "Interact With"; }		td:nth-of-type(2):before { content: "Sale"; }		td:nth-of-type(3):before { content: "Remark"; }		td:nth-of-type(4):before { content: "Interaction Date"; }		td:nth-of-type(5):before { content: "Action"; }	}	</style><div class="content-wrapper">       <!-- Main content -->    <section class="content">      <div class="row">        <div class="col-xs-12">   <?php echo get_flash(); ?>          <div class="box">            <!-- /.box-header -->            <div class="box-body">                <table id="example2" class="table table-bordered table-striped">                <thead>                <tr>                  <th>Interact With</th>                  <th>Sale</th>                  <th>Remark</th>                  <th>Interaction Date</th>				  <th>Action</th>                </tr>                </thead>                <tbody>				 <?php if(!empty($order_list)){foreach($order_list as $order){ ?>				<?php if(get_cancel_order($order['id'],$order['int_id'])==0){?>                 <tr>									<td><?php  /* echo get_complete_order($order['id'],$order['int_id']);					  echo get_cancel_order($order['id'],$order['int_id']); */					if(is_numeric($order['int_id'])){ echo get_dealer_name($order['int_id']);}					else{echo (substr($order['int_id'],0,3)=='doc')?get_doctor_name($order['int_id']):get_pharmacy_name($order['int_id']);}					?></td>					<td><?= $order['meeting_sale']?>&#8377;</td>					<td><?= substr($order['remark'], 0, 20)."...";?></td>					<td><?= date('d-m-Y',strtotime($order['create_date']))?></td>					<td><a href="<?php echo base_url()."order/interaction_order/view_order/". urisafeencode($order['id']).'/'. urisafeencode($order['int_id']);?>"><button type="button" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i></button></a></td>				 </tr>				 <?php } } } ?>                </tbody>              </table>			</div>          <!-- /.box -->        </div>        <!-- /.col -->      </div>      <!-- /.row -->    </section>    <!-- /.content -->  </div>  <script>  $(function () {    $('#example2').DataTable({      'responsive' : true,      'paging'      : true,      'lengthChange': true,      'searching'   : true,      'ordering'    : true,      'info'        : true,      'autoWidth'   : true,    })  })</script>