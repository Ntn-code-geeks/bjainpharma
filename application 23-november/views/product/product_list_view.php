<?php/*  * Niraj Kumar * date : 23-10-2017 * show list of users */ // $user_info = json_decode($user_data);//  pr($user_info); die;?><link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/><link href="<?= base_url()?>design/css/div_table/custom_table.css" rel="stylesheet" type="text/css"/><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><link rel="stylesheet" href="<?= base_url()?>design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"><!--<style>@media	only screen and (max-width: 760px),	(min-device-width: 768px) and (max-device-width: 1024px)  {		/*		Label the data		*/		td:nth-of-type(1):before { content: "Product Name"; }		td:nth-of-type(2):before { content: "Parent Category"; }		td:nth-of-type(3):before { content: "Potency"; }		td:nth-of-type(4):before { content: "Packsize"; }		td:nth-of-type(5):before { content: "Price"; }		td:nth-of-type(6):before { content: "Status"; }		td:nth-of-type(7):before { content: "Action"; }	}	</style>--><div class="content-wrapper">       <!-- Main content -->    <section class="content">      <div class="row">        <div class="col-xs-12">   <?php echo get_flash(); ?>          <div class="box">            <div class="box-header">                <a href="<?= base_url();?>product/product/add_product"> <h3 class="box-title"><button type="button" class="btn btn-block btn-success">Add New</button></h3></a>            </div>            <!-- /.box-header -->            <div class="box-body">                <table id="example2" class="table table-bordered table-striped">                <thead>                <tr>                  <th>Product Name</th>                  <th>Parent Category</th>                  <th>Potency</th>                  <th>Packsize </th>                  <th>Price </th>                  <th>Status </th>				  <th>Action</th>                                  </tr>                </thead>                <tbody>				 <?php if(!empty($product_list)){foreach($product_list as $product){ ?>                 <tr>					<td><?= $product['product_name']?></td>					<td><?= get_category_name($product['product_category'])?></td>					<td><?= get_potency_value($product['product_potency'])?></td>					<td><?= get_packsize_value($product['product_packsize'])?></td>					<td><?= $product['product_price']?>&#8377;</td>					<td><?= ($product['status']==1)?'Enable':'Disable'?></td>					<td><a href="<?php echo base_url()."product/product/edit_product/". urisafeencode($product['product_id']);?>"><button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>					</td>				 </tr>                <?php }  } ?>                </tbody>              </table>			</div>          <!-- /.box -->        </div>        <!-- /.col -->      </div>      <!-- /.row -->    </section>    <!-- /.content -->  </div>  <script src="<?= base_url()?>design/bower_components/datatables.net/js/jquery.dataTables.min.js"></script><script src="<?= base_url()?>design/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script><script>  $(function () {    $('#example2').DataTable({      'responsive' : true,      'paging'      : true,      'lengthChange': true,      'searching'   : true,      'ordering'    : true,      'info'        : true,      'autoWidth'   : true,    })  })</script>