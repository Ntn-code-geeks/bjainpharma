<?php





/* 


 * To change this license header, choose License Headers in Project Properties.


 * To change this template file, choose Tools | Templates


 * and open the template in the editor.


 */


//$appointment_data = json_decode($ap_list);





//pr($appointment_data); die;


/*pr($city_data);
		die;*/


?>


<!-- fullCalendar -->





  <link rel="stylesheet" href="<?php echo base_url();?>design/bower_components/fullcalendar/dist/fullcalendar.min.css">


  <link rel="stylesheet" href="<?php echo base_url();?>design/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">


 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<div class="content-wrapper">


    <!-- Main content -->


    <section class="content">


      <div class="row">


          <?php echo get_flash(); ?>
         
	  		<div class="col-md-12">
	  			<?php if(get_tour_info() && userDesig()==FALSE){
//                                if(get_tour_info()){ ?>
	  			 	<a title="Create TP" href="<?php echo base_url().'tour_plan/tour_plan/create_tour/'; ?>"><input class="btn btn-info" value="Create TP" id="btnPrint" style="margin: 5px auto;" type="button"></a>
	  			 <?php } ?>
                                        <?php if(get_tour_info() && userDesig()==TRUE){?>
	  			 	<a title="Create TP" href="<?php echo base_url().'tour_plan/tour_plan/asm_create_tour/'; ?>"><input class="btn btn-info" value="Create TP" id="btnPrint" style="margin: 5px auto;" type="button"></a>
	  			 <?php } ?>
	  			 <?php if(is_admin() ){?>
	          		<a title="Create TP" href="<?php echo base_url().'tour_plan/tour_plan/assign_tp/'; ?>"><input class="btn btn-info" value="Assign TP" id="btnPrint" style="float: right;margin: 5px auto;" type="button"></a>
				<?php }else{ if(logged_user_child()){?>
					<a title="Subordinate Tour Plan" href="<?php echo base_url().'reports/reports/tp_reports/'.urisafeencode(logged_user_data()); ?>"><input class="btn btn-info" value="Subordinate Tour Plan" id="btnPrint" style="float: right;margin: 5px auto;" type="button"></a>
				<?php }} ?>
	                </div>
        <div class="col-md-12">


          <div class="box box-primary">


            <div class="box-body no-padding">


              <!-- THE CALENDAR -->


              <div id="calendar"></div>


            </div>


            <!-- /.box-body -->


          </div>


          <!-- /. box -->


        </div>


        <!-- /.col -->


      </div>


      <!-- /.row -->


      


      


      <div class="modal modal-info fade" id="modal-info">


          <div class="modal-dialog">


             


            <div class="modal-content">


              <div class="modal-header">


                <button type="button" class="close" data-dismiss="modal" aria-label="Close">


                  <span aria-hidden="true">&times;</span></button>


                  <span id="modeltime">Create Tour Plan For </span><span id="modalEndtime"></span>


                  <h4 id="modalTitle" class="modal-title"></h4>


              </div>


              <div class="modal-body" id="modalBody">


                <?php  echo form_open_multipart($action); ?>


                    <input type="hidden" id="tour_date" name="tour_date"/>


					<div class="row">


<!--						<div class="col-md-6">


							<div class="form-group">


								<label>SOURCE : </label>


								<select required name="source_city" id="source_city"  class="form-control select2" style="width: 100%;">
								  <option value="">--Select Source City --</option>
									<?php foreach($city_data as $city){ ?>   
										<option value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option>
									<?php }  ?>
								</select>


							</div>


						</div>-->


						<div class="col-md-12">


							<div class="form-group">


								<label>City : </label>


								<select required name="dest_city" id="dest_city"  class="form-control select2" style="width: 100%;">
								    <option value="">--Select City--</option>
									<?php foreach($city_data as $city){ ?>   
										<option value="<?=$city['city_id']?>" ><?=$city['city_name'].'('.$city['state_name'].')'?></option>
									<?php }  ?>
								</select>


							</div>


						</div>


					</div>

<!--
					<div class="row">


						<div class="col-md-6">


							<div class="bootstrap-timepicker">


								<div class="form-group">


								  <label>Start Time:</label>





								  <div class="input-group">


									<input readonly type="text" name="tour_st_time" id="tour_st_time" class="form-control timepicker">





									<div class="input-group-addon">


									  <i class="fa fa-clock-o"></i>


									</div>


								  </div>


								   /.input group 


								</div>


								 /.form group 


							 </div>


						</div>


						 <div class="col-md-6">


							<div class="bootstrap-timepicker">


							<div class="form-group">


							  <label>End Time:</label>


							  <div class="input-group">


								<input readonly type="text" name="tour_time_end" id="tour_time_end" class="form-control timepicker">





								<div class="input-group-addon">


								  <i class="fa fa-clock-o"></i>


								</div>


							  </div>


							   /.input group 


							</div>


							 /.form group 


						  </div>


						</div>


					</div>-->


					<div class="row">


						<div class="col-md-12">


							<div class="">


								<div class="form-group">


									<label>Remark</label>


									<textarea class="form-control" rows="3" name="remark" id="remark" placeholder="About the Plan ..."></textarea>





								</div>


							</div>


						</div>


					</div>


					<div class="row">


						<div class="col-md-12">


							<div class="">


							<button type="submit" class="btn btn-info pull-right">Submit</button>


							</div>


						</div>


					</div>


                 <?php echo form_close();  ?>


              </div>


              <div class="modal-footer">


                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>


              </div>


            </div>


          </div>


        </div>


		<!--Modal For Tour View-->


		<div class="modal modal-info fade" id="modal-infoView">


          <div class="modal-dialog">


             


            <div class="modal-content">


              <div class="modal-header">


                <button type="button" class="close" data-dismiss="modal" aria-label="Close">


                  <span aria-hidden="true">&times;</span></button>


                  <span id="">Tour Date</span> <span id="tour_now_date"></span>


                  <h4 id="modalTitleView" class="modal-title"></h4>


              </div>


              <div class="modal-body" id="modalBodyView">


                    <input type="hidden" id="tour_dateView" name="tour_date"/>


					<div class="row">


<!--						<div class="col-md-6">


							<span>Source City &nbsp; : &nbsp; </span>	&nbsp; <span id="source_cityValue"></span>


						</div>-->


						<div class="col-md-6">


							<span>City &nbsp; : &nbsp;</span>	&nbsp; <span id="destination_city"></span>


						</div>
                                                <div class="col-md-6">


							<span>Assign by &nbsp; : &nbsp; </span>	&nbsp; <span id="assignby"></span>


						</div>


					</div>


<!--					<div class="row">


						<div class="col-md-6">


							<span> Start time &nbsp;	: 	&nbsp; </span>	&nbsp; <span id="start_time"></span>


						</div>


						<div class="col-md-6">


							<span>End Time &nbsp;	:	&nbsp; </span>	&nbsp; <span id="end_time"></span>


						</div>


					</div>-->


					<div class="row">


						<div class="col-md-12">


							<span>Remark &nbsp; : &nbsp; </span>	&nbsp; <span id="remarkValue"></span>


						</div>

						





					</div>


                <?php  /*echo form_open_multipart($updateaction); ?>


                    <input type="hidden" id="tour_id" name="tour_id"/> 


					<div class="row" style="margin-top:10px">


						<div class="col-md-6">


							<div class="">


								<div class="form-group">


									<label>Visited &nbsp; : &nbsp; &nbsp;</label>


									<!-- <select required name="visited" id="visited"  class="form-control select2" style="width: 100%;">


										<option value="">--Select Option--</option>


										<option value="0">No</option>


										<option value="1" >Yes</option>


									</select>-->


									<input type="radio" class="form-check-input" name="visited" id="optionsNo" value="0">


									No


									<input type="radio" class="form-check-input" name="visited" id="optionsYes" value="1">


									Yes


								</div>


							</div>


						</div>


					</div>


					<div class="row">


						<div class="col-md-12">


							<div class="">


							<button type="submit" class="btn btn-info pull-right">Submit</button>


							</div>


						</div>


					</div>


				<?php echo form_close(); */ ?>


              </div>


              <div class="modal-footer">


                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>


              </div>


            </div>


          </div>


        </div>


		


    


      


    </section>


    <!-- /.content -->


  </div>


</div>


<script type='text/javascript'>


    $(function(){





    $('.select2').select2();


     


    });


    


</script>


<script type="text/javascript">


  $(function () {


var currentLangCode = 'en';





        // build the language selector's options


        $.each($.fullCalendar.langs, function(langCode) {


            $('#lang-selector').append(


                $('<option/>')


                    .attr('value', langCode)


                    .prop('selected', langCode == currentLangCode)


                    .text(langCode)


            );


        });





        // rerender the calendar when the selected option changes


        $('#lang-selector').on('change', function() {


            if (this.value) {


                currentLangCode = this.value;


                $('#calendar').fullCalendar('destroy');


                renderCalendar();


            }


        });


    /* initialize the external events


     -----------------------------------------------------------------*/


    function init_events(ele) {


      ele.each(function () {





        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)


        // it doesn't need to have a start or end


        var eventObject = {


          title: $.trim($(this).text()) // use the element's text as the event title


        }





        // store the Event Object in the DOM element so we can get to it later


        $(this).data('eventObject', eventObject)





        // make the event draggable using jQuery UI


        $(this).draggable({


          zIndex        : 1070,


          revert        : true, // will cause the event to go back to its


          revertDuration: 0  //  original position after the drag


        })





      })


    }





    init_events($('#external-events div.external-event'))





    /* initialize the calendar


     -----------------------------------------------------------------*/


    //Date for the calendar events (dummy data)


    var date = new Date()


    var d    = date.getDate(),


        m    = date.getMonth(),


        y    = date.getFullYear()


    $('#calendar').fullCalendar({


      header    : {
        left  : 'prev, today',
        center: 'title',
        right : 'next'
      },


      buttonText: {
        today: 'Current Month',
        //month: 'Month',
        prev: 'Previous Month',
        next: 'Next Month',
      },

	dayClick: function(date, allDay, jsEvent, view) {
		var start = $.fullCalendar.formatDate(date, "Y-MM-DD");
		var date = $.fullCalendar.formatDate(date, "DD-MM-Y");
	var data=moment(start);
		var dayNum=data.isoWeekday();
		if(dayNum==7){
		    //console.log("Sunday");
		    alert("Sunday - Interactions not allowed.")
        }else{
            $('#tour_date').val(start);
            $('#modalEndtime').html(date);
            $('#modal-info').modal();
        }
	},


    eventClick:  function(event, jsEvent, view) {
			$('#tour_id').val(event.tour_id);
		    $('#tour_now_date').html(event.tour_now_date);
			if(event.visited==1){
				$('#optionsYes').attr('checked', true);
			}
			else{
				$('#optionsNo').attr('checked', true);
			}
            $('#source_cityValue').html(event.source_city);
            $('#destination_city').html(event.destination);
            $('#start_time').html(event.time);
            $('#end_time').html(event.endtime);
            $('#remarkValue').html(event.description);
            $('#assignby').html(event.assign_by);
            $('#modal-infoView').modal();
    },
      //Random default events
		<?php if($tour_list!=''){?>
		events    : <?=$tour_list?>,
		<?php }?>
        buttonIcons: false, // show the prev/next text
//      weekNumbers: true,
        eventLimit: true, 
        displayEventTime: false,
    });
 })


</script>










