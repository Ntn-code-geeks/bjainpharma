<?php $loggedData=logged_user_data();

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
	<title>Bjain Item Inventory</title>
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
<?php $this->load->view("elements/header");?>

</head>

        <?php 

        if($this->session->userdata('userId') && $this->session->userdata('SiteUrl_id')== base_url()){


            $this->load->view("elements/invoice_top_bar");    

        }

        ?>

	<?php 
                        $this->load->view($page_view);

           ?>
        <?php if($page_view!='appointment/appoint_details_view'){$this->load->view("elements/footer");}?>

    </body>

</html>

