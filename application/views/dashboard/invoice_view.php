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
<!--<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
	<title>Bjain Item Inventory</title>
	<link rel="shortcut icon" type="image/png" href="/media/images/favicon.png">-->
	<!--<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">-->
	
<!--</head>-->
<body class="wide comments example dt-example-bootstrap" >
	
	<div class="fw-container">
		
		<div class="fw-body">
			<div class="content">
				<h1 class="page_title">Bjain Products</h1>
				
				<table id="example" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
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
							<td><?=$val_c->No;?></td>
							<td><?=$val_c->_x0031_mg_Sku_Code;?></td>
							<td><?=$val_c->Description;?></td>
							<td><?=$val_c->Pack_Size;?></td>
							<td><?=$val_c->Potency;?></td>
                                                        <td><?php if($val_c->Inventory>0){
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



