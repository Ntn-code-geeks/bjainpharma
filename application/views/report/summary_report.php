<?php
/*
 * Developed By:
** Nitin kumar
 * Created on: 31-07-2019
*/
?>
<!--<link href="<?= base_url()?>design/css/div_table/one.css" rel="stylesheet" type="text/css"/>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <?php echo get_flash(); ?>


        <div class="box box-success">
            <!--<div class="box box-primary">-->

            <div class="box-header">
                <h3 class="box-title"> Secondary Summary Report </h3>
            </div>

            <div class="box-body">
                <div class="row" style="display: flex;">

                <div class="col-md-6" style="float: left;">
                    <h4 style="font-weight: 600;">User-wise Secondary Report</h4>
                    <br>
                    <?php
                    echo form_open($action);
                    ?>
                    <!-- Date range -->
                    <div class="form-group">
                        <label>Employee Name: </label>
                        <select name="working_user_id" id="working_user_id"  class="form-control select3" style="width: 100%;">
                        <option value="">--Select Employee--</option>
                        <?php foreach($child_user_list as $k_cul=>$val_cul){ echo $val_cul['username']; ?>
                            <option value="<?=$val_cul['userid']?>" ><?=$val_cul['username'];?></option>
                            <?php }  ?>
                        </select>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                    <!-- Date and time range -->
                    <div class="form-group">
                        <label>Summary Report Period:</label>
                        <select name="period" id="period" class="form-control select3" style="width: 100%;">                                 <option value="">Weekly</option>
                            <option value="month">Monthly</option>
                            <option value="quarter">Quarterly</option>
                            <option value="year">Yearly</option>
                        </select>
                        <!-- /.input group -->
                    </div>

                    <!-- Date and time range -->
                    <div class="form-group">
                        <!--                <label></label>-->
                        <div class="input-group">
                            <button type="submit" name="send1" value="1" class="btn btn-default">View</button>
                        </div>
                    </div>
                    <!-- /.form group -->
                    <?php echo form_close(); ?>
                </div>

              <?php if(is_admin()){ ?>

                <div class="vl" style="border-left: 2px solid green; height: 200px;"></div>

                <div class="col-md-6" style="float: left;">
                        <h4 style="font-weight: 600;">Overall Secondary Report</h4>
                        <br>
                    <?php
                    echo form_open($action);
                    ?>
                        <!-- Date range -->
                        <div class="form-group">
                            <label>Summary Report Period:</label>
                            <select name="period" id="period" class="form-control select3" style="width: 100%;">
                                <!--                                <option value="">--Select Secondary Report Period--</option>-->
                                <option value="">Weekly</option>
                                <option value="month">Monthly</option>
                                <option value="quarter">Quarterly</option>
                                <option value="year">Yearly</option>
                            </select>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->

                        <!-- Date and time range -->
                        <div class="form-group">
                            <!--                <label></label>-->
                            <div class="input-group">
                                <button type="submit" name="send" value="1" class="btn btn-default">View</button>
                            </div>
                        </div>
                        <!-- /.form group -->
                        <?php echo form_close(); ?>
                    </div>
            <?php } ?>

            </div>
                <!-- /.box -->
            </div>
            <!-- /.col (left) -->
        </div>

    </section>
    <!-- /.content -->
</div>
<script type="text/javascript">
    $(function(){
        $('.select3').select2();

        $('.select4').select2({selectOnClose: true}).on("select2:select", function(e) {
            var dealerId= $(this).val();
            if(dealerId)
            {
                $('.select5').prop('disabled', true);
            }
            else
            {
                $('.select5').prop('disabled', false);
            }
        });
        $('.select5').select2({selectOnClose: true}).on("select2:select", function(e) {
            var pharmaId= $(this).val();
            if(pharmaId)
            {
                $('.select4').prop('disabled', true);
            }
            else
            {
                $('.select4').prop('disabled', false);
            }

        });
    });



</script>

