<?php





/* 


 * To change this license header, choose License Headers in Project Properties.


 * To change this template file, choose Tools | Templates


 * and open the template in the editor.


 */





?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>








<div class="content-wrapper">





    <!-- Main content -->


    <section class="content">


    <?php echo get_flash(); ?>


      <!-- Contact Add -->


      <div class="box box-default">


        <div class="box-header with-border">


          <h3 class="box-title">Add</h3>


        </div>


        <!-- /.box-header -->


        <div class="box-body">


            


            <?php 


            echo form_open_multipart($action);


//            xss_clean();?>


			<div class="row">


				<div class="col-md-6">


				   <div class="form-group">


					<label>Navigation ID*</label>


					<input type="number" name="navigate_id" required id="navigate_id">


					<span class="control-label" for="inputError" style="color: red"><?php echo form_error('navigate_id'); ?></span>


				  </div>


				</div>


				<div class="col-md-6">


				   <div class="form-group">


					<label>Select &nbsp; : &nbsp;&nbsp;</label>


					<input type="radio" class="form-check-input" checked name="visited" id="" value="1">


					&nbsp; Doctor &nbsp;


					<input type="radio" class="form-check-input" name="visited" id="" value="2">


					&nbsp; Dealer &nbsp;


					<input type="radio" class="form-check-input" name="visited" id="" value="3">


					&nbsp; Sub Dealer &nbsp; 


					<span class="control-label" for="inputError" style="color: red"><?php echo form_error('navigate_id'); ?></span>


				  </div>


				</div>





				<div class="col-md-12">


					<div class="box-footer">


						<button type="submit" class="btn btn-info pull-right">Save</button>


					</div>


				</div>


				


			  </div>


          <!-- /.row -->


          


          <?php


          echo form_close(); 


          ?>


        </div>


        <!-- /.box-body -->


        


      </div>


      <!-- /.box -->





    </section>


    <!-- /.content -->


  </div>


