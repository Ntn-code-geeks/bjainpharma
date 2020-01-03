<?php

/**
 * Developer: Shailesh Saraswat
 * Email: sss.shailesh@gmail.com
 * Dated: 20-Nov-2018
 * 
 * List of invoice data
 */


$navinvoice = json_decode($nav_invoice);

//pr($navinvoice); die;

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
	<title>Bjain Item Inventory</title>
	<link rel="shortcut icon" type="image/png" href="/media/images/favicon.png">
	<!--<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">-->
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
	<script type="text/javascript" class="init">

            $(document).ready(function() {
                    var table = $('#example').DataTable( {
                            lengthChange: false,
                            buttons: [ 'excel', 'pdf' ]
                    } );

                    table.buttons().container()
                            .appendTo( '#example_wrapper .col-sm-6:eq(0)' );
            } );

	</script>
</head>

<body class="wide comments example dt-example-bootstrap">
	
	<div class="fw-container">		
		<div class="fw-body">
			<div class="content">
				<h1 class="page_title">Bjain Products</h1>
				
				<table id="example" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
						    <!--<th>S.No.</th>-->
							<th>Number</th>
							<th>SKU Code</th>
							<th>Description</th>
							<th>Pack Size</th>
							<th>Potency</th>
                            <th>In-Stock</th>
							
						</tr>
					</thead>
					<tbody>
						<?php  if(!empty($navinvoice)){ 
                                                    foreach($navinvoice as $k_c=>$val_c){      ?>
						<tr>
						    <!--<td><?=++$k_c;?></td>-->
							<td><?=$val_c->No;?></td>
							<td><?=$val_c->_x0031_mg_Sku_Code;?></td>
							<td><?=$val_c->Description;?></td>
							<td><?=$val_c->Pack_Size;?></td>
							<td><?=$val_c->Potency;?></td>
                                                        <td><?php 
                                                        if($val_c->Inventory>0 || $val_c->Product_Group_Code==102){
                                                        // if($val_c->Inventory>0){
                                                            echo 'Yes';
                                                        }else{
                                                            echo 'No';
                                                        }?></td>
						 </tr>
						<?php }} ?>
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
	
</body>
</html>