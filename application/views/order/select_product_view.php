<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$edit_doctor=json_decode($edit_doctor_list);
$dealer_data = json_decode($dealer_list);   // for all active dealers
?>
<script src="<?php echo base_url().'design/js/ajax.3.2.js'?>"></script>

<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
    <?php echo get_flash(); ?>
      <!-- Contact Add -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Add Product </h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo form_open_multipart($action);?>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Category : </label><br>
						<input type="hidden" name ="order_id" value="<?= $order_id ?>">
						<input type="hidden" name ="person_id" value="<?= $person_id ?>">
							<?php foreach($category_list as $category){ ?>
								<div class="col-md-4">
								<input class="cat_list" catid="<?= $category['category_id'] ?>" type="checkbox" name="category_list[]" value="<?= $category['category_id'] ?>">&nbsp;&nbsp;<?= $category['category_name'] ?>
								</div>
							<?php }  ?>
					</div>
				</div>
			</div>
			<br><br>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Product List : </label><br>
						<div class="product_data" id="product_data" >
							<div class="table-responsive">
								<table  class="col-md-12 table" >
									<thead>
										<tr>
											
											<th>
												Product Potency 
											</th>
											<th>
												Product Packsize 
											</th>
											<th>
												Product Name 
											</th>
											<th>
												MRP 
											</th>
											<th>
												Quantity  
											</th>
											<th>
												Discount (%) 
											</th>
											<th>
												Amount  
											</th>
											<th>
												Action  
											</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach($category_list as $category){  ?>

									<div>
										<tr id="procat_name_<?= $category['category_id'] ?>" style="display:none">
									        <th>
	                   							<span><?= $category['category_name'] ?></span>
	                   						</th>
	                   						
	                   					</tr>
										<tr id="" class="product_row procat_box_<?= $category['category_id'] ?>" style="display:none">
											
	                   						<td >
	                   							<?php if(get_cat_potency($category['category_id'] )){?>
												<select  catid="<?= $category['category_id'] ?>"
														 name="product_potency[]" id="" class="product_select_potency form-control procat_option_box_potency_<?= $category['category_id'] ?>"  style="width: 100%;">
	                                   	 		
	                            				</select>
	                            				<?php }?>
	                   						</td>
	                   						<td >
												<select  catid="<?= $category['category_id'] ?>"
														 name="product_packsize[]" id="" class="product_select_packsize form-control procat_option_box_packsize_<?= $category['category_id'] ?>"  style="width: 100%;">
	                                   	 		            
	                            				</select>
	                   						</td>
	                   						<td >
												<select  catid="<?= $category['category_id'] ?>" name="product_name[]" id="" class="product_select form-control select3 procat_option_box_<?= $category['category_id'] ?>"  style="width: 100%;">
	                                   	 		       
	                            				</select>
	                   						</td>
	                   						<td>
	                   							<input id="" class="form-control pro_mrp_val" name="pro_mrp_val[]" type="text"  value="">
	                   						</td>
	                   						<td>
	                   							<input id="" class="form-control pro_qnty" name="pro_qnty[]" type="text" value="">
	                   						</td>
	                   						<td>
	                   							<input id="" class="form-control pro_dis" name="pro_dis[]" type="text" value="">
	                   						</td>
	                   						<td>
	                   							<input id="" class="form-control pro_amt" name="pro_amt[]" type="text" readonly value="0">
	                   						</td>
	                   						
	                   					</tr>
	                   					<tr id="procat_footer_row_<?= $category['category_id'] ?>" style="display:none">
									        <td colspan="8" style="text-align:right">
	                   							<button type="button"  catid="<?= $category['category_id'] ?>" class="btn btn-info pull-right add_row">Add Product</button>
	                   						</td>
	                   						
	                   					</tr>
									<?php }  ?>
									</tbody>
									<tfoot>
										<tr>
											<th colspan="7" style="text-align:right"> 
												Total Amount : 
											</th>
											<th id="">
												<input id="tot_amt" class="form-control" name="tot_amt" type="text" readonly value="">
											</th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
                            
                       
			<div class="form-group">
				<label>Payment Terms *</label>
				<input class="form-control" id="payment" style="display: none" name="payment" placeholder="Enter No. of Days" value="" type="number">               
	                
			<select name="payment_term" id="payment_term" class="form-control select11" required="" style="width: 100%;">
				    <option value="">--Select Payment Terms--</option>
   					<option value="1">No of Days</option>
				    <option value="2">On Delivery</option>

				</select>
                        
                        </div>
                            
            <div class="form-group">
				<label>Mode of Payment *</label>
			<select name="payment_mode" id="payment_mode"  class="form-control select10" required="" style="width: 100%;">
				    <option value="">--Select Mode of Payment--</option>
					<option value="1">Cash</option>
				    <option value="2">Cheque</option>
			</select>
                </div>


			<div class="form-group" id="d_list<?=$edit_doctor->doctor_id ?>" style="">
				<label>Dealer/pharmacy List<span style="color: red;font-size: 20px">*</span></label>
				<select id="dealer_id<?=$edit_doctor->doctor_id ?>" name="dealer_id" class="form-control select2" style="width: 100%;">
					<?php
					if(!empty($edit_doctor->dealers_id)){
						foreach($dealer_data as $k_s => $val_s){
							/*for dealers id who belogs to this doctor*/
							if(!empty(($edit_doctor->dealers_id))){
								$dealers_are = explode(',', $edit_doctor->dealers_id);
							}
							else{
								$dealers_are=array();
							}
							/*end of dealers id who belogs to this doctor */
							if(in_array($val_s->dealer_id,$dealers_are)){
								if($val_s->blocked==0){     ?>
									<option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?>><?=$val_s->dealer_name.','.$val_s->city_name;?></option>
								<?php } } } ?>

						<?php
						foreach($pharma_list as $k_pl => $val_pl){
							/*for dealers id who belogs to this doctor*/
							if(!empty(($edit_doctor->dealers_id))){
								$dealers_are = explode(',', $edit_doctor->dealers_id);
							}
							else{
								$dealers_are=array();
							}
							/*end of dealers id who belogs to this doctor */
							if(in_array($val_pl['id'],$dealers_are)){
								if($val_pl['blocked']==0){          ?>
									<option value="<?=$val_pl['id']?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_pl['id']);} ?>><?=$val_pl['com_name'].', (Sub Dealer)';?></option>
								<?php } } } ?>

						<!--<option value="none" id="none" >NONE</option>-->
					<?php }else{ ?>

						<!--   <button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal_add_dealer<?=$edit_doctor->doctor_id ?>">Add Dealer/Sub Dealer  </button>

         <a href="<?= base_url()?>doctors/doctor/edit_doctor/<?php echo urisafeencode($edit_doctor->doctor_id); ?>" style="color: #fff"><button type="button" class="btn btn-warning">Add Dealer/Sub Dealer  </button></a> -->
					<?php } ?>
				</select>
				<br/>

				<button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modal_add_dealer<?=$edit_doctor->doctor_id ?>">Add Dealer/Sub Dealer  </button>
				<span class="control-label" id="dealer_id_help<?=$edit_doctor->doctor_id ?>" for="inputError" style="color: red"><?php echo form_error('dealer_id'); ?></span>



			</div>
			<div class="form-group">
				<label>Send Mail to Dealer/Sub Dealer &nbsp; : &nbsp;&nbsp;</label>
				<br>
				<input  type="radio" class="form-check-input" checked name="dealer_mail" id="" value="1">
				&nbsp;Yes &nbsp;
				<input type="radio" class="form-check-input" name="dealer_mail" id="" value="0">
				&nbsp;  No &nbsp;
			</div>


		</div>
		
		<div class="row">
            <div class="col-md-12">
                <!--<div class="form-group">-->
                <div class="box-footer">
					<button type="submit" class="btn btn-info pull-right">Save</button>

                </div>
            </div>
        </div>
          <!-- /.row --><?php	echo form_close();	?>
		  <button id="cancel-order" class="btn btn-danger ">Cancel</button>


        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>


<div class="modal modal-info fade" id="modal_add_dealer<?=$edit_doctor->doctor_id ?>">

	<form id="<?=$edit_doctor->doctor_id ?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Add Dealer/Sub Dealer</h4>
				</div>
				<div class="modal-body">
					<div class="form-group" id="d_list<?=$edit_doctor->doctor_id ?>">
						<label>Dealer/pharmacy List</label>
						<select multiple="" id="dealer_id<?=$edit_doctor->doctor_id ?>" name="dealer_id[]" class="form-control select5" style="width: 100%;">
							<?php
							foreach($dealer_data as $k_s => $val_s){
								/*for dealers id who belogs to this doctor*/
								if(!empty(($edit_doctor->dealers_id))){
									$dealers_are = explode(',', $edit_doctor->dealers_id);
								}
								else{
									$dealers_are=array();
								}
								/*end of dealers id who belogs to this doctor */
								if(in_array($val_s->dealer_id,$dealers_are)){
//                    if($val_s->blocked==0){
									?>
									<option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?> selected=""><?=$val_s->dealer_name.','.$val_s->city_name;?></option>
								<?php  } else{
									if($val_s->status==1){     ?>
										<option value="<?=$val_s->dealer_id?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_s->dealer_id);} ?> ><?=$val_s->dealer_name.','.$val_s->city_name;?></option>
										<?php
									} } } ?>

							<?php
							foreach($pharma_list as $k_pl => $val_pl){
								/*for dealers id who belogs to this doctor*/
								if(!empty(($edit_doctor->dealers_id))){
									$dealers_are = explode(',', $edit_doctor->dealers_id);
								}
								else{
									$dealers_are=array();
								}
								/*end of dealers id who belogs to this doctor */
								if(in_array($val_pl['id'],$dealers_are)){
//                     if($val_pl['blocked']==0){
									?>
									<option value="<?=$val_pl['id']?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_pl['id']);} ?> selected=""><?=$val_pl['com_name'].', (Sub Dealer)';?></option>
								<?php }

								elseif($val_pl['status']==1){
									?>
									<option value="<?=$val_pl['id']?>" <?php if(isset($_POST['dealer_id'])){echo set_select('dealer_id',  $val_pl['id']);} ?> ><?=$val_pl['com_name'].', (Sub Dealer)';?></option>

									<?php
								}

							} ?>

							<!--<option value="none" id="none" >NONE</option>-->

						</select> <br/>

						<?php // } ?>

						<span class="control-label" id="dealer_id_help<?=$edit_doctor->doctor_id ?>" for="inputError" style="color: red"><?php echo form_error('dealer_id'); ?></span>

					</div>

				</div>

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
				<button id="submit" type="submit" class="btn btn-outline submit" >Save changes</button>
			</div>
		</div>
	</form>
	<?php // echo form_close(); ?>
	<!-- /.modal-content -->
</div>


<script type="text/javascript">   // for multipile model open
    $("#modal_add_dealer<?=$edit_doctor->doctor_id ?>").on('hidden.bs.modal', function (event) {
        if ($('.modal:visible').length) //check if any modal is open
        {
            $('body').addClass('modal-open');//add class to body
        }
    });

    $(document).ready(function() {
        var dp;
        var $eventSelect5 = $('.select5').select2();
        $eventSelect5.on("change", function (e) {
            var dealer_pharma = $(this).val();
            dp = dealer_pharma;
            //alert(dealer_pharma);
        });


    $(".submit").click(function(){
            var newdealer_pharma =  dp;
            var formid = $(this).closest("form").attr('id');
            var dataString = 'dealerpharma='+ newdealer_pharma+'&doctor_id='+formid;
            if(newdealer_pharma=='' || formid=='')
            {
                alert("Please Fill All Fields");
            }
            else
            {
// AJAX Code To Submit Form.
                var urlData=<?php echo "'".base_url()."doctors/doctor/add_dealer_pharma/"."'";?>;
                $.ajax({
                    type: "POST",
                    url: urlData,
                    data: dataString,
                    cache: false,
                    success: function(result){
                        alert(result);
                        $('#modal_add_dealer<?=$edit_doctor->doctor_id;?>').modal('toggle');
                        if(dataString!=''){
                            var urlData1=<?php echo "'".base_url()."doctors/doctor/dealer_pharma_list/"."'";?>;
                            $.ajax({
                                type: "POST",
                                url: urlData1+formid,
                                cache: false,
                                success: function(result){
                                    $("#dealer_id"+formid).html(result);
                                }
                            });
                        }
                    }
                });

            }
            return false;
        });
    });

</script>

<script src="<?php echo base_url();?>design/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
    $(document).on('click','.cat_list',function(){
        var cat_ID=$(this).val();
        if($(this).is(':checked')){
            $('.procat_option_box_potency_'+cat_ID+' option').each(function(){
              if($('.procat_option_box_potency_'+cat_ID+' option[value="'+$(this).val()+'"]').length) $(this).remove();
            });
            $('.procat_option_box_packsize_'+cat_ID+' option').each(function(){
              if($('.procat_option_box_packsize_'+cat_ID+' option[value="'+$(this).val()+'"]').length) $(this).remove();
            });

            $('.procat_option_box_potency_'+cat_ID).prop('selectedIndex',0);
            $('.procat_option_box_packsize_'+cat_ID).prop('selectedIndex',0);

        }
        else{
            var amt= $('.procat_box_'+cat_ID).find('.pro_amt').val();
            var tot_amount=$('#tot_amt').val();
            var balance_amt=tot_amount-amt;
            $('#tot_amt').val(parseFloat(balance_amt).toFixed(2));
			$('.procat_box_'+cat_ID).find('.pro_mrp_val').val(0);
            $('.procat_box_'+cat_ID).find('.pro_amt').val(0);

            $('.procat_option_box_potency_'+cat_ID).prop('selectedIndex',0);
            $('.procat_option_box_packsize_'+cat_ID).prop('selectedIndex',0);

            $('.procat_option_box_potency_'+cat_ID+' option').each(function(){
             if($('.procat_option_box_potency_'+cat_ID+' option[value="'+$(this).val()+'"]').length) $(this).remove();
            });
            $('.procat_option_box_packsize_'+cat_ID+' option').each(function(){
             if($('.procat_option_box_packsize_'+cat_ID+' option[value="'+$(this).val()+'"]').length) $(this).remove();
            });

        }
    });
</script>

<script type='text/javascript'>

  $(document).on('click','.cat_list',function(){
      var catid=$(this).val();
	  if($(this).is(':checked')){
			$('.procat_box_'+catid).css('display','table-row');
			$('#procat_name_'+catid).css('display','table-row');
			$('#procat_footer_row_'+catid).css('display','table-row');
			if(catid==11 || catid==9 || catid==8)//potency category
    		{
    			$.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_potency_list/",
			   data : 'id='+catid,
			   success:function(res){ 
					if(res){
						$(".procat_option_box_potency_"+catid).append(res);
					}

				}
				});	
    		}

 			if(catid==15) {
              $(".procat_option_box_packsize_"+catid).css('display','none');
              $.ajax({
                  type: "POST",
                  url: "<?= base_url();?>order/interaction_order/products_list/",
                  data: 'catid=' + catid,
                  success: function (res) {

                      if(res){

                          $(".procat_option_box_"+catid).append(res);

                          $(document).on("change",".product_select", function() {
                              var proID= $('.product_select ').find(":selected").val();
                              $.ajax({
                                  type: "POST",
                                  url: "<?= base_url();?>order/interaction_order/products_list_get/",
                                  data: 'productid=' + proID,
                                  success: function (rest) {
                                      //alert(rest);
                                      var data = $.parseJSON(rest);
                                      var theElement = $(this);
                                      if(data!=false)
                                      {
                                          // $('.pro_mrp_val').val(data[0].product_price);
                                          $('.procat_box_'+catid).find('.pro_mrp_val').val(data[0].product_price);
                                          var qunat=$(theElement).closest('tr').find('.pro_qnty').val();
                                          if (typeof qunat === "undefined") {
                                              var qunatity=1;
                                          }else{
                                              var qunatity=qunat;
                                          }

                                          var dis=$(theElement).closest('tr').find('.pro_dis').val();
                                          var amount=data[0].product_price;
                                          var net_amount=(amount-((amount*dis)/100))*qunatity;
                                          $(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
                                          var extratitles = document.getElementsByName('pro_amt[]');
                                          var str = 0;
                                          for (var i = 0; i < extratitles.length; i++) {
                                              var inp=extratitles[i];
                                              str=str+parseFloat(inp.value);
                                          }
                                          $('#tot_amt').val(parseFloat(str).toFixed(2));
                                      }
                                      else
                                      {
                                          $(theElement).closest('tr').find('.pro_mrp_val').val();
                                          $(theElement).closest('tr').find('.pro_dis').val();
                                          $(theElement).closest('tr').find('.pro_qnty').val();
                                          var qunatity='';
                                          var dis='';
                                          var amount='';
                                          var net_amount=(amount-((amount*dis)/100))*qunatity;
                                          $(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
                                          var extratitles = document.getElementsByName('pro_amt[]');
                                          var str = 0;
                                          for (var i = 0; i < extratitles.length; i++) {
                                              var inp=extratitles[i];
                                              str=str+parseFloat(inp.value);
                                          }
                                          $('#tot_amt').val(parseFloat(str).toFixed(2));
                                      }
                                  }

                              });
                          });

                      }

                  }
              });

          }

			$.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_packsize_list/",
			   data : 'id='+catid,
			   success:function(res){ 
					if(res){
						$(".procat_option_box_packsize_"+catid).append(res);
					}

				}
			});
	  }
	  else
	  {
		$('.procat_box_'+catid).css('display','none');
		$('#procat_name_'+catid).css('display','none');
		$('#procat_footer_row_'+catid).css('display','none');
	  }
  });
   
</script>

<!--Go Back on previous page with all session and $_GET data-->
<script type="text/javascript">
    $("#cancel-order").click(function (){
        window.history.back();
    });
</script>

<!-- Get details of product on product change -->
<script type='text/javascript'>
    $(".add_row").on("click", function(e) {
  		// alert('asa');

    	var theElement = $(this);
    	var catid=$(this).attr("catid");

    	$('.select3').select2('destroy');
    		
    		//$(".select3").select2();

    	//alert(catid);
    	if(catid==11 || catid==9 || catid==8)
    	{
    		var strVar = '<tr id="" class="product_row procat_box_'+catid+' "> <td> <select catid="'+catid+'" name="product_potency[]" id="" class="product_select_potency form-control  procat_option_box_potency_'+catid+'" style="width: 100%;"></td><td> <select catid="'+catid+'" name="product_packsize[]" id="" class="product_select_packsize form-control procat_option_box_packsize_'+catid+'" style="width: 100%;"></td><td> <select catid="'+catid+'" name="product_name[]" id="" class="product_select form-control select3 procat_option_box_'+catid+'" style="width: 100%;"></td><td><input id="" class="form-control pro_mrp_val" name="pro_mrp_val[]" type="text"  value=""></td><td><input id="" class="form-control pro_qnty" name="pro_qnty[]"type="text" value=""></td><td><input id="" class="form-control pro_dis" name="pro_dis[]" type="text" value=""></td><td><input id="" class="form-control pro_amt" type="text" name="pro_amt[]" readonly value="0"></td><td><button type="button" catid="<?= $category['category_id'] ?>" class="btn btn-danger pull-right delete_row">Delete Product</button></td></tr>';
    	 	$(theElement).closest('tr').before(strVar);
    	 }
    	 else if(catid==1 || catid==2 || catid==3 || catid==4 || catid==6 || catid==10 || catid==7 || catid==14 || catid==13)
    	 {
    	  	var strVar = '<tr id="" class="product_row procat_box_'+catid+' "> <td></td><td> <select catid="'+catid+'" name="product_packsize[]" id="" class="product_select_packsize form-control  procat_option_box_packsize_'+catid+'" style="width: 100%;"></td><td> <select catid="'+catid+'" name="product_name[]" id="" class="product_select form-control select3 procat_option_box_'+catid+'" style="width: 100%;"></td><td><input id="" class="form-control pro_mrp_val" name="pro_mrp_val[]" type="text"  value=""></td><td><input id="" class="form-control pro_qnty" name="pro_qnty[]"type="text" value=""></td><td><input id="" class="form-control pro_dis" name="pro_dis[]" type="text" value=""></td><td><input id="" class="form-control pro_amt" type="text" name="pro_amt[]" readonly value="0"></td><td><button type="button" catid="<?= $category['category_id'] ?>" class="btn btn-danger pull-right delete_row">Delete Product</button></td></tr>';
    	 	$(theElement).closest('tr').before(strVar);
    	 }
    	   else if(catid==15){
            var strVar = '<tr id="" class="product_row procat_box_'+catid+' "> <td></td><td></td> <td> <select catid="'+catid+'" name="product_name[]" id="proname" class="product_select form-control select3 procat_option_box_'+catid+'" style="width: 100%;"></td><td><input id="prod" class="form-control pro_mrp_val" name="pro_mrp_val[]" type="text"  value=""></td><td><input id="" class="form-control pro_qnty" name="pro_qnty[]"type="text" value=""></td><td><input id="" class="form-control pro_dis" name="pro_dis[]" type="text" value=""></td><td><input id="" class="form-control pro_amt" type="text" name="pro_amt[]" readonly value="0"></td><td><button type="button" catid="<?= $category['category_id'] ?>" class="btn btn-danger pull-right delete_row">Delete Product</button></td></tr>';
            $(theElement).closest('tr').before(strVar);

            $.ajax({
                type: "POST",
                url: "<?= base_url();?>order/interaction_order/products_list/",
                data: 'catid=' + catid,
                success: function (res) {
                    if(res){
                        $("#proname").append(res);
                        $(document).on("change",".product_select", function() {
                            var proID= $('#proname').find(":selected").val();
                            $.ajax({
                                type: "POST",
                                url: "<?= base_url();?>order/interaction_order/products_list_get/",
                                data: 'productid=' + proID,
                                success: function (rest) {
                                    var data = $.parseJSON(rest);
                                    var theElement = $(this);
                                    if(data!=false)
                                    {
                                        $('.procat_box_'+catid).find('#prod').val(data[0]
                                            .product_price);
                                        var qunat=$(theElement).closest('tr').find('.pro_qnty').val();
                                        if (typeof qunat === "undefined") {
                                            var qunatity=1;
                                        }else{
                                            var qunatity=qunat;
                                        }
                                        var dis=$(theElement).closest('tr').find('.pro_dis').val();
                                        var amount=data[0].product_price;
                                        var net_amount=(amount-((amount*dis)/100))*qunatity;
                                        $(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
                                        var extratitles = document.getElementsByName('pro_amt[]');
                                        var str = 0;
                                        for (var i = 0; i < extratitles.length; i++) {
                                            var inp=extratitles[i];
                                            str=str+parseFloat(inp.value);
                                        }
                                        $('#tot_amt').val(parseFloat(str).toFixed(2));
                                    }
                                    else
                                    {
                                        $(theElement).closest('tr').find('.pro_mrp_val').val();
                                        $(theElement).closest('tr').find('.pro_dis').val();
                                        $(theElement).closest('tr').find('.pro_qnty').val();
                                        var qunatity='';
                                        var dis='';
                                        var amount='';
                                        var net_amount=(amount-((amount*dis)/100))*qunatity;
                                        $(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
                                        var extratitles = document.getElementsByName('pro_amt[]');
                                        var str = 0;
                                        for (var i = 0; i < extratitles.length; i++) {
                                            var inp=extratitles[i];
                                            str=str+parseFloat(inp.value);
                                        }
                                        $('#tot_amt').val(parseFloat(str).toFixed(2));
                                    }
                                }

                            });
                        });

                    }

                }
            });

        }


    	 var $evenSelect22	=	$(".select3").select2();
	       $evenSelect22.on("change", function(e) {
	        	//alert('sdfds');
	    	var productId= $(this).val();
	    	var theElement = $(this);
	    	var catid=$(this).attr("catid");

			$.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_details/",
			   data : 'productid='+productId,
			   success:function(res){ 
					if(res){
						var data = $.parseJSON(res);
						if(data!=false)
						{
							$(theElement).closest('tr').find('.pro_mrp_val').val(data[0].product_price);
							var qunatity=$(theElement).closest('tr').find('.pro_qnty').val();
		  					var dis=$(theElement).closest('tr').find('.pro_dis').val();
		  					var amount=data[0].product_price;
		  					var net_amount=(amount-((amount*dis)/100))*qunatity;
							$(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
							var extratitles = document.getElementsByName('pro_amt[]');
							var str = 0;
							for (var i = 0; i < extratitles.length; i++) { 
								var inp=extratitles[i];
								str=str+parseFloat(inp.value);
							}
							$('#tot_amt').val(parseFloat(str).toFixed(2));
						}
						else
						{
							$(theElement).closest('tr').find('.pro_mrp_val').val();
							$(theElement).closest('tr').find('.pro_dis').val();
							$(theElement).closest('tr').find('.pro_qnty').val();
							var qunatity='';
		  					var dis='';
		  					var amount='';
		  					var net_amount=(amount-((amount*dis)/100))*qunatity;
							$(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
							var extratitles = document.getElementsByName('pro_amt[]');
							var str = 0;
							for (var i = 0; i < extratitles.length; i++) { 
								var inp=extratitles[i];
								str=str+parseFloat(inp.value);
							}
							$('#tot_amt').val(parseFloat(str).toFixed(2));
						}
					}
				}
			});
   	 	});
    });
  
</script>

 <script type='text/javascript'>
	
    $(document).on("click",".product_select_packsize", function() {

  		var catid=$(this).attr("catid");
  		//alert(catid);
  		var theElement = $(this);
  		var procount=$(theElement).has('option').length;
  		if(procount==0)
  		{
  			var option='<option vlaue="">---Select Product---</option>';
   			$.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_packsize_list/",
			   data : 'id='+catid,
			   success:function(res){ 
					$(theElement).append(res);
				}
			});
   		}
    });
  
</script>

 <script type='text/javascript'>
	
    $(document).on("click",".product_select_potency", function() {

  		var catid=$(this).attr("catid");
  		//alert(catid);
  		var theElement = $(this);
  		var procount=$(theElement).has('option').length;
  		if(procount==0)
  		{
  			var option='<option vlaue="0">---Select Potency---</option>';
   			$.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_potency_list/",
			   data : 'id='+catid,
			   success:function(res){ 
					$(theElement).append(res);
				}
			});
   		}
    });
  
</script>

<script type='text/javascript'>
	
    $(document).on("change",".product_select_packsize", function() {
  		var catid=$(this).attr("catid");
  		var packsize=$(this).val();
  		var theElement = $(this);
  		if(catid==11 || catid==9 || catid==8)
    	{
    		var potency=$(theElement).closest('tr').find('.product_select_potency').val();
    		if(potency!='')
    		{
    			if(!$.isEmptyObject(potency)){
	    			$.ajax({
					   type:"POST",
					   url:"<?= base_url();?>order/interaction_order/get_product_list/",
					   data : 'catid='+catid+'&packsize='+packsize+'&potency='+potency,
					   success:function(res){ 
							//$(theElement).append(res);
							//$(theElement).closest('tr').find('.product_select').html(res);
//						     alert(res);
						//$(theElement).append(res);
                                                if(Math.floor(res) == res && $.isNumeric(res)){
                                                    if(catid==11){
                                                    $(theElement).closest('tr').find('.product_select').html('<option value="11582">DILUTIONS</option>');
                                                     }
                                        $.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_details/",
			   data : 'productid='+res,
			   success:function(res){ 
					if(res){
						var data = $.parseJSON(res);
						if(data!=false)
						{
							$(theElement).closest('tr').find('.pro_mrp_val').val(data[0].product_price);
							var qunatity=$(theElement).closest('tr').find('.pro_qnty').val();
		  					var dis=$(theElement).closest('tr').find('.pro_dis').val();
		  					var amount=data[0].product_price;
		  					var net_amount=(amount-((amount*dis)/100))*qunatity;
							$(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
							var extratitles = document.getElementsByName('pro_amt[]');
							var str = 0;
							for (var i = 0; i < extratitles.length; i++) { 
								var inp=extratitles[i];
								str=str+parseFloat(inp.value);
							}
							$('#tot_amt').val(parseFloat(str).toFixed(2));
						}
						else
						{
							$(theElement).closest('tr').find('.pro_mrp_val').val();
							$(theElement).closest('tr').find('.pro_dis').val();
							$(theElement).closest('tr').find('.pro_qnty').val();
							var qunatity='';
		  					var dis='';
		  					var amount='';
		  					var net_amount=(amount-((amount*dis)/100))*qunatity;
							$(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
							var extratitles = document.getElementsByName('pro_amt[]');
							var str = 0;
							for (var i = 0; i < extratitles.length; i++) { 
								var inp=extratitles[i];
								str=str+parseFloat(inp.value);
							}
							$('#tot_amt').val(parseFloat(str).toFixed(2));
						}
					}
				}
			});
					}else{
						 $(theElement).closest('tr').find('.product_select').html(res);

					}
					}
					});
	    		}
    		}
    	}
		else if(catid==1 || catid==2 || catid==3 || catid==4 || catid==6 || catid==10 || catid==7 || catid==14 || catid==13)
		{
   			$.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_list/",
			   data : 'catid='+catid+'&packsize='+packsize,
			   success:function(res){ 
					//$(theElement).append(res);
//					$(theElement).closest('tr').find('.product_select').html(res);
				  if(Math.floor(res) == res && $.isNumeric(res)){
				   if(catid==7){
					$(theElement).closest('tr').find('.product_select').html('<option value="11583">MOTHER TINCTURES</option>');
					 }

			   $.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_details/",
			   data : 'productid='+res,
			   success:function(res){ 
					if(res){
						var data = $.parseJSON(res);
						if(data!=false)
						{
							$(theElement).closest('tr').find('.pro_mrp_val').val(data[0].product_price);
							var qunatity=$(theElement).closest('tr').find('.pro_qnty').val();
		  					var dis=$(theElement).closest('tr').find('.pro_dis').val();
		  					var amount=data[0].product_price;
		  					var net_amount=(amount-((amount*dis)/100))*qunatity;
							$(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
							var extratitles = document.getElementsByName('pro_amt[]');
							var str = 0;
							for (var i = 0; i < extratitles.length; i++) { 
								var inp=extratitles[i];
								str=str+parseFloat(inp.value);
							}
							$('#tot_amt').val(parseFloat(str).toFixed(2));
						}
						else
						{
							$(theElement).closest('tr').find('.pro_mrp_val').val();
							$(theElement).closest('tr').find('.pro_dis').val();
							$(theElement).closest('tr').find('.pro_qnty').val();
							var qunatity='';
		  					var dis='';
		  					var amount='';
		  					var net_amount=(amount-((amount*dis)/100))*qunatity;
							$(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
							var extratitles = document.getElementsByName('pro_amt[]');
							var str = 0;
							for (var i = 0; i < extratitles.length; i++) { 
								var inp=extratitles[i];
								str=str+parseFloat(inp.value);
							}
							$('#tot_amt').val(parseFloat(str).toFixed(2));
						}
					}
				}
			});
					}else{
						 $(theElement).closest('tr').find('.product_select').html(res);

					}

				}
			});
                        
	   	}
    });
  
</script>

<script type='text/javascript'>
	
    $(document).on("change",".product_select_potency", function() {
  		var catid=$(this).attr("catid");
  		var potency=$(this).val();
  		var theElement = $(this);
		var packsize=$(theElement).closest('tr').find('.product_select_packsize').val();
		if(packsize!='')
		{
			if(!$.isEmptyObject(packsize)){
				$.ajax({
				   type:"POST",
				   url:"<?= base_url();?>order/interaction_order/get_product_list/",
				   data : 'catid='+catid+'&packsize='+packsize+'&potency='+potency,
				   success:function(res){ 
                                      // alert(res);
						//$(theElement).append(res);
					if(Math.floor(res) == res && $.isNumeric(res)){
						 if(catid==11){
						$(theElement).closest('tr').find('.product_select').html('<option value="11582">DILUTIONS</option>');
						 }if(catid==7){
						$(theElement).closest('tr').find('.product_select').html('<option value="11583">MOTHER TINCTURES</option>');
						 }
                                                     
                                                     
			   $.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_details/",
			   data : 'productid='+catid,
			   success:function(res){ 
					if(res){
						var data = $.parseJSON(res);
						if(data!=false)
						{
							$(theElement).closest('tr').find('.pro_mrp_val').val(data[0].product_price);
							var qunatity=$(theElement).closest('tr').find('.pro_qnty').val();
		  					var dis=$(theElement).closest('tr').find('.pro_dis').val();
		  					var amount=data[0].product_price;
		  					var net_amount=(amount-((amount*dis)/100))*qunatity;
							$(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
							var extratitles = document.getElementsByName('pro_amt[]');
							var str = 0;
							for (var i = 0; i < extratitles.length; i++) { 
								var inp=extratitles[i];
								str=str+parseFloat(inp.value);
							}
							$('#tot_amt').val(parseFloat(str).toFixed(2));
						}
						else
						{
							$(theElement).closest('tr').find('.pro_mrp_val').val();
							$(theElement).closest('tr').find('.pro_dis').val();
							$(theElement).closest('tr').find('.pro_qnty').val();
							var qunatity='';
		  					var dis='';
		  					var amount='';
		  					var net_amount=(amount-((amount*dis)/100))*qunatity;
							$(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
							var extratitles = document.getElementsByName('pro_amt[]');
							var str = 0;
							for (var i = 0; i < extratitles.length; i++) { 
								var inp=extratitles[i];
								str=str+parseFloat(inp.value);
							}
							$('#tot_amt').val(parseFloat(str).toFixed(2));
						}
					}
				}
			});
				}else{
					 $(theElement).closest('tr').find('.product_select').html(res);

				}
						
					}
				});
			}
		}


    });
  
</script>

 <script type='text/javascript'>
    $(document).on("click",".delete_row", function() {
    		var theElement = $(this);
  			$(theElement).closest('tr').remove();
  			var extratitles = document.getElementsByName('pro_amt[]');
			var str = 0;
			for (var i = 0; i < extratitles.length; i++) { 
				var inp=extratitles[i];
				 str=str+parseFloat(inp.value);
			}
			$('#tot_amt').val(parseFloat(str).toFixed(2));
   		
    });
   
</script>
 <script type='text/javascript'>
    $(function(){
 		//$('body').on('DOMNodeInserted', 'select', function () {
                $(".select10").select2(); // for Mode of payment
         var $evenSelect11  = $(".select11").select2(); // for payment terms
 		 var $evenSelect2   = $(".select3").select2();
         
         $evenSelect11.on('change',function(e){
             var paymentterm = $(this).val();
             if(paymentterm==1){
                 $('#payment').css('display','block');
                 $("#payment").attr("required", true);

                // $evenSelect11.css('display','none');
             }else{
                 $('#payment').css('display','none');
                 $("#payment").attr("required", false);
             }
         });
         
	       $evenSelect2.on("change", function(e) {
	        	//alert('sdfds');
	    	var productId= $(this).val();
	    	var theElement = $(this);
	    	var catid=$(this).attr("catid");

			$.ajax({
			   type:"POST",
			   url:"<?= base_url();?>order/interaction_order/get_product_details/",
			   data : 'productid='+productId,
			   success:function(res){ 
					if(res){
						var data = $.parseJSON(res);
						if(data!=false)
						{
							$(theElement).closest('tr').find('.pro_mrp_val').val(data[0].product_price);
							var qunatity=$(theElement).closest('tr').find('.pro_qnty').val();
		  					var dis=$(theElement).closest('tr').find('.pro_dis').val();
		  					var amount=data[0].product_price;
		  					var net_amount=(amount-((amount*dis)/100))*qunatity;
							$(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
							var extratitles = document.getElementsByName('pro_amt[]');
							var str = 0;
							for (var i = 0; i < extratitles.length; i++) { 
								var inp=extratitles[i];
								str=str+parseFloat(inp.value);
							}
							$('#tot_amt').val(parseFloat(str).toFixed(2));
						}
						else
						{
							$(theElement).closest('tr').find('.pro_mrp_val').val();
							$(theElement).closest('tr').find('.pro_dis').val();
							$(theElement).closest('tr').find('.pro_qnty').val();
							var qunatity='';
		  					var dis='';
		  					var amount='';
		  					var net_amount=(amount-((amount*dis)/100))*qunatity;
							$(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
							var extratitles = document.getElementsByName('pro_amt[]');
							var str = 0;
							for (var i = 0; i < extratitles.length; i++) { 
								var inp=extratitles[i];
								str=str+parseFloat(inp.value);
							}
							$('#tot_amt').val(parseFloat(str).toFixed(2));
						}
					}
				}
			});
   	 	});
   // });
  
 });
   
</script>

<script type='text/javascript'>
    
    $(document).on("blur",".pro_dis ", function() {
	    var theElement = $(this);
	  	var dis =$(theElement).val();
	  	var qunatity=$(theElement).closest('tr').find('.pro_qnty').val();
	  	var amount=$(theElement).closest('tr').find('.pro_mrp_val').val();
	   	if(dis!=''){
			if(dis<100){
				var net_amount=(amount-((amount*dis)/100))*qunatity;
				$(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
				var extratitles = document.getElementsByName('pro_amt[]');
				var str = 0;
				for (var i = 0; i < extratitles.length; i++) { 
					var inp=extratitles[i];
					 str=str+parseFloat(inp.value);
				}
				$('#tot_amt').val(parseFloat(str).toFixed(2));
			}
			else
			{
				alert('Please Enter Discount Below 100');
			}
		}
		else{
			alert('Please Enter Discount Greater or equal 0');
		}
    });
</script>

<script type='text/javascript'>
    
    $(document).on("blur",".pro_qnty", function() {
	    var theElement = $(this);
	    var qunatity=$(theElement).val();
	  	var dis=$(theElement).closest('tr').find('.pro_dis').val();
	  	var amount=$(theElement).closest('tr').find('.pro_mrp_val').val();
	   if(qunatity!=''){
       		if(qunatity>0){
       			
				var net_amount=(amount-((amount*dis)/100))*qunatity;
				$(theElement).closest('tr').find('.pro_amt').val(parseFloat(net_amount).toFixed(2));
				var extratitles = document.getElementsByName('pro_amt[]'); 
		    	var str = 0;
				for (var i = 0; i < extratitles.length; i++) { 
					var inp=extratitles[i];
					 str=str+parseFloat(inp.value);
				}
				$('#tot_amt').val(parseFloat(str).toFixed(2));
			}
			else	
	        {		
	            alert('Please Enter Quantity greater than 1');	
	        }	
        }	
        else{	
            alert('Please Enter Quatity Greater or equal 1');
        }
});
</script>


