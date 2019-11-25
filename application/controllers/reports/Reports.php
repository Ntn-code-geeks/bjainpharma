<?php


defined('BASEPATH') OR exit('No direct script access allowed');





/* 


 * Niraj Kumar


 * Dated: 06/03/2018


 * 


 * This Controller is for Report


 */





class Reports extends Parent_admin_controller {





   function __construct() 


    {


        parent::__construct();


            $loggedData=logged_user_data();


            


            if(empty($loggedData)){


                redirect('user'); 


            }


        $this->load->library('excel');


        $this->load->model('report/report_model','report');


        $this->load->model('report/user_report_model','user_report');


        $this->load->model('user_model','user');


    }


    
public function tp_reports($userid=''){
	if($userid=='')
    {
    	$data['user_id']='';
    }
    else
    {
    	$data['user_id']=urisafedecode($userid);
    }
	$data['title'] = "TP Report";
	$data['page_name'] = "TP Reports";
	$data['action'] ="reports/reports/get_tp_report";
	$data['users'] =$this->user->users_report();
	$this->load->get_view('report/tp_reports',$data);
}


    public function get_tp_report(){
		$request = $this->input->post();
		if(!empty($request)){
		$report_date = explode('-',$request['report_date'] );
		$followstart_date =  trim($report_date[0]);
			$newstartdate = str_replace('/', '-', $followstart_date);
			$followend_date =  trim($report_date[1]);
			$newenddate = str_replace('/', '-', $followend_date);
			$start = date('Y-m-d', strtotime($newstartdate))." 00:00:00";
			$end = date('Y-m-d', strtotime($newenddate))." 23:59:59";
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_id', 'User', 'required');
			$this->form_validation->set_rules('report_date', 'Report Date range', 'required'); 
			if($this->form_validation->run() == TRUE){
				$this->generate_tp_report($request['user_id'],$start,$end);
				//$data['attendance_report'] =$this->user_report->get_attendance_report($request['user_id'],$start,$end);
			}else{
			  // for false validation
			 $this->tp_reports();  
			}
		}
		else{
		 $this->tp_reports();  
		}
   }

   public function generate_tp_report($userid,$start,$end)
    {
		$this->excel->setActiveSheetIndex(0);
        //name the worksheet
		$this->excel->getActiveSheet()->setTitle('TP Report');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', 'Date');
//		$this->excel->getActiveSheet()->setCellValue('B1', 'Source City');
		$this->excel->getActiveSheet()->setCellValue('B1', 'City');
		$this->excel->getActiveSheet()->setCellValue('C1', 'Remark');
		$this->excel->getActiveSheet()->setCellValue('D1', 'Assign By');
                
		$data['attendance_report'] =$this->user_report->get_tp_report($userid,$start,$end);
		$k_num = 2;
		/* pr($data['attendance_report']);die; */ 
		/* For Attendance */
		if(!empty($data['attendance_report'])){
			foreach ( $data['attendance_report']as $row){ 
				$this->excel->getActiveSheet()->setCellValue('A'.$k_num, date('d.m.Y',strtotime($row['dot'])));
//				$this->excel->getActiveSheet()->setCellValue('B'.$k_num, get_city_name($row['source']));
				$this->excel->getActiveSheet()->setCellValue('B'.$k_num, get_city_name($row['destination']));
				$this->excel->getActiveSheet()->setCellValue('C'.$k_num, $row['remark']);
				$this->excel->getActiveSheet()->setCellValue('D'.$k_num, get_user_name($row['assign_by']));
				$k_num++;
			}
		}
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//		$this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$name=preg_replace('/\s+/', '', ucfirst(get_user_name($userid)));
		$filename=$name.'TPReport.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//ob_end_clean();
		//ob_start();
		$objWriter->save('php://output');
	}

    public function travel_report(){


         if(is_admin()){


			$data['title'] = "Travel Report List";


			$data['page_name'] = "Travel Reports";


			$data['action'] ="reports/reports/get_travel_report";


			$data['users'] =$this->user->users_report();


			$this->load->get_view('report/travel_report_view',$data);


         }


         else{


             redirect('user');


         }


         


        


    }


	


    public function get_travel_report(){
        if(is_admin()){
			$request = $this->input->post();
			$this->load->library('form_validation');
			$this->form_validation->set_rules('user_id', 'User', "required");
			if($this->form_validation->run() == TRUE){
					/* $report_date = explode('-',$request['report_date'] );
					$followstart_date =  trim($report_date[0]);
					$newstartdate = str_replace('/', '-', $followstart_date);
					$followend_date =  trim($report_date[1]);
					$newenddate = str_replace('/', '-', $followend_date);
					$start = date('Y-m-d', strtotime($newstartdate))." 00:00:00";
					$end = date('Y-m-d', strtotime($newenddate))." 23:59:59";
					$this->load->library('form_validation');
					$this->form_validation->set_rules('user_id', 'User', 'required');
					$this->form_validation->set_rules('report_date', 'Report Date range', 'required'); 
					if($this->form_validation->run() == TRUE){
					$this->generate_travel_report($request['user_id'],$start,$end);
					//$data['travel_report'] =$this->user_report->get_travel_report();
					}else{
					  // for false validation
					 $this->travel_report();  
					}*/
					$report_date = explode('-',$request['report_date'] );
					$followstart_date =  trim($report_date[0]);
					$newstartdate = str_replace('/', '-', $followstart_date);
					$followend_date =  trim($report_date[1]);
					$newenddate = str_replace('/', '-', $followend_date);
					$start = date('Y-m-d', strtotime($newstartdate));
					$end = date('Y-m-d', strtotime($newenddate));
				$data=$this->user_report->get_create_tansitdata($request['user_id'],$start,$end);
			}
			else{
				 redirect('reports/reports/travel_report'); 
			}


		}


		else{


		  redirect('user');


		}


    }


	


	public function generate_travel_report($userid,$start,$end)


    {


		$this->excel->setActiveSheetIndex(0);


                //name the worksheet


		$this->excel->getActiveSheet()->setTitle('Travel Report');

		$this->excel->getActiveSheet()->setCellValue('A1', 'Customer');

		$this->excel->getActiveSheet()->setCellValue('B1', 'Transit Source City');


		$this->excel->getActiveSheet()->setCellValue('C1', 'Transit Destination City');


		$this->excel->getActiveSheet()->setCellValue('D1', 'Transit Date');


		$this->excel->getActiveSheet()->setCellValue('E1', 'Fare');


		$this->excel->getActiveSheet()->setCellValue('F1', 'Distance');


		$this->excel->getActiveSheet()->setCellValue('G1', 'Meeting Type');


		$this->excel->getActiveSheet()->setCellValue('H1', 'Meeting Place');


		$this->excel->getActiveSheet()->setCellValue('I1', 'Meeting Date');


		$this->excel->getActiveSheet()->setCellValue('J1', 'Ticket Attachment');


		$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);


		$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);


		$this->excel->getActiveSheet()->setCellValue('K1', 'Stay');


		$this->excel->getActiveSheet()->setCellValue('L1', 'Bill Attachment');


		$data['travel_report'] =$this->user_report->get_travel_report($userid,$start,$end);


		$k_num = 2;


		 /* pr($data['travel_report']);


		die; */ 


		/* For Transit */


		if(!empty($data['travel_report'])){


			foreach ( $data['travel_report']as $row){


				$this->excel->getActiveSheet()->getRowDimension($k_num)->setRowHeight(100);


				


				if(array_key_exists("user_name",$row)){


					$this->excel->getActiveSheet()->setCellValue('A'.$k_num, get_user_name($row['user_name']));


				}


				else{


					$this->excel->getActiveSheet()->setCellValue('A'.$k_num, '--------');


				}


				if(array_key_exists("source_city",$row)){


					$this->excel->getActiveSheet()->setCellValue('B'.$k_num, get_city_name($row['source_city']));


				}


				else{


					$this->excel->getActiveSheet()->setCellValue('B'.$k_num, '--------');


				}


				


				if(array_key_exists("destination_city",$row)){


					$this->excel->getActiveSheet()->setCellValue('C'.$k_num, get_city_name($row['destination_city']));


				}


				else{


					$this->excel->getActiveSheet()->setCellValue('C'.$k_num, '--------');


				}


				if(array_key_exists("transit_date",$row)){


					$this->excel->getActiveSheet()->setCellValue('D'.$k_num, date('d.m.Y',strtotime($row['transit_date'])));


				}


				else{


					$this->excel->getActiveSheet()->setCellValue('D'.$k_num, '--------');


				}


				


				if(array_key_exists("fare",$row)){


					$this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['fare']);


				}


				else{


					$this->excel->getActiveSheet()->setCellValue('E'.$k_num, '--------');


				}


				if(array_key_exists("total_distance",$row)){


					$this->excel->getActiveSheet()->setCellValue('F'.$k_num, $row['total_distance']);


				}


				else{


					$this->excel->getActiveSheet()->setCellValue('F'.$k_num, '--------');


				}


				


				if(array_key_exists("meeting_type",$row)){


					$meeting='';


					if($row['meeting_type']==1){


						$meeting='Monthly';


					}elseif($row['meeting_type']==2){


						$meeting='Quarterly';


					}elseif($row['meeting_type']==3){


						$meeting='Annually';


					}


					$this->excel->getActiveSheet()->setCellValue('G'.$k_num,$meeting);


				}


				else{


					$this->excel->getActiveSheet()->setCellValue('G'.$k_num, '--------');


				}


				


				if(array_key_exists("meeting_place",$row)){


					$this->excel->getActiveSheet()->setCellValue('H'.$k_num, get_city_name($row['meeting_place']));


				}


				else{


					$this->excel->getActiveSheet()->setCellValue('H'.$k_num, '--------');


				}


				if(array_key_exists("meeting_date",$row)){


					$this->excel->getActiveSheet()->setCellValue('I'.$k_num, date('d.m.Y',strtotime($row['meeting_date'])));


				}


				else{


					$this->excel->getActiveSheet()->setCellValue('I'.$k_num, '--------');


				}


				if(array_key_exists("ticket_attachment",$row)){


					if(!empty($row['ticket_attachment'])){


						$objDrawing = new PHPExcel_Worksheet_Drawing();


						$objDrawing->setName('Ticket Attachment');


						$objDrawing->setDescription('Ticket Attachment');


						$objDrawing->setPath('./assets/proof/'.$row['ticket_attachment']);


						$objDrawing->setCoordinates('J'.$k_num);


						$objDrawing->setHeight(100);


						$objDrawing->setWidth(100);


						$objDrawing->setWorksheet($this->excel->getActiveSheet());


					}


					else{


						$this->excel->getActiveSheet()->setCellValue('J'.$k_num, '--------');


					}


				}


				else{


					$this->excel->getActiveSheet()->setCellValue('J'.$k_num, '--------');


				}


				


				if(array_key_exists("stay",$row)){


					$stay='';


					if($row['stay']==1){


						$stay='Stay';


					}elseif($row['stay']==0){


						$stay='Not Stay';


					}


					$this->excel->getActiveSheet()->setCellValue('K'.$k_num,$stay);


				}


				else{


					$this->excel->getActiveSheet()->setCellValue('K'.$k_num, '--------');


				}


				if(array_key_exists("bill_attachment",$row)){


					if(!empty($row['bill_attachment'])){


						$objDrawing = new PHPExcel_Worksheet_Drawing();


						$objDrawing->setName('Bill Attachment');


						$objDrawing->setDescription('Bill Attachment');


						$objDrawing->setPath('./assets/proof/'.$row['bill_attachment']);


						$objDrawing->setCoordinates('L'.$k_num);


						$objDrawing->setHeight(100);


						$objDrawing->setWidth(100);


						$objDrawing->setWorksheet($this->excel->getActiveSheet());


					}


					else{


						$this->excel->getActiveSheet()->setCellValue('J'.$k_num, '--------');


					}


				}


				else{


					$this->excel->getActiveSheet()->setCellValue('L'.$k_num, '--------');


				}


				



				$k_num++;


			}


		}


	
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$name=preg_replace('/\s+/', '', ucfirst(get_user_name($userid)));


		$filename=$name.'TravelReport.xls'; //save our workbook as this file name


		header('Content-Type: application/vnd.ms-excel'); //mime type


		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name


		header('Cache-Control: max-age=0'); //no cache





		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)


		//if you want to save it as .XLSX Excel 2007 format


		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  


		//force user to download the Excel file without writing it to server's HD


		$objWriter->save('php://output');


	}


	


	public function attendance_report(){


        if(is_admin()){


			$data['title'] = "Attendance Report List";


			$data['page_name'] = "Attendance Reports";


			$data['action'] ="reports/reports/get_attendance_report";


			$data['users'] =$this->user->users_report();


			$this->load->get_view('report/travel_report_view',$data);


        }


		else{


			redirect('user');


		}


    }

	public function attendance_report_all(){
        if(is_admin()){
			$data['title'] = "Attendance Report List";
			$data['page_name'] = "Attendance Reports";
			$data['action'] ="reports/reports/get_attendance_report_all";
			$data['users'] =$this->user->users_report();
			$this->load->get_view('report/attendance_report_view',$data);
        }
		else{
			redirect('user');
		}
    }

	
    public function get_attendance_report_all(){
      


        if(is_admin()){


			$request = $this->input->post();


			if(!empty($request)){


				$report_date = explode('-',$request['report_date'] );


				$followstart_date =  trim($report_date[0]);


				$newstartdate = str_replace('/', '-', $followstart_date);


				$followend_date =  trim($report_date[1]);


				$newenddate = str_replace('/', '-', $followend_date);


				$start = date('Y-m-d', strtotime($newstartdate))." 00:00:00";


				$end = date('Y-m-d', strtotime($newenddate))." 23:59:59";


				$this->load->library('form_validation');


				//$this->form_validation->set_rules('user_id', 'User', 'required');


				$this->form_validation->set_rules('report_date', 'Report Date range', 'required'); 


				if($this->form_validation->run() == TRUE){


					$this->generate_attendance_report_all($start,$end);


					//$data['attendance_report'] =$this->user_report->get_attendance_report($request['user_id'],$start,$end);


				}else{


				  // for false validation


				 $this->attendance_report_all();  


				}


			}


			else{


			 redirect('reports/reports/attendance_report_all'); 


			}


		}


		else{


		  redirect('user');


		}


    }

	public function get_attendance_report(){


        


        if(is_admin()){


			$request = $this->input->post();


			if(!empty($request)){


				$report_date = explode('-',$request['report_date'] );


				$followstart_date =  trim($report_date[0]);


				$newstartdate = str_replace('/', '-', $followstart_date);


				$followend_date =  trim($report_date[1]);


				$newenddate = str_replace('/', '-', $followend_date);


				$start = date('Y-m-d', strtotime($newstartdate))." 00:00:00";


				$end = date('Y-m-d', strtotime($newenddate))." 23:59:59";


				$this->load->library('form_validation');


				$this->form_validation->set_rules('user_id', 'User', 'required');


				$this->form_validation->set_rules('report_date', 'Report Date range', 'required'); 


				if($this->form_validation->run() == TRUE){


					$this->generate_attendance_report($request['user_id'],$start,$end);


					//$data['attendance_report'] =$this->user_report->get_attendance_report($request['user_id'],$start,$end);


				}else{


				  // for false validation


				 $this->attendance_report();  


				}


			}


			else{


			 redirect('reports/reports/attendance_report'); 


			}


		}


		else{


		  redirect('user');


		}


    }


/*Overall Attendance Report*/
public function generate_attendance_report_all($start,$end)
    {
		$this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Attendance Report');
		$this->excel->getActiveSheet()->setCellValue('A1', 'Employee Code');
		$this->excel->getActiveSheet()->setCellValue('B1', 'Name');
		$this->excel->getActiveSheet()->setCellValue('C1', 'Total Day');
		$this->excel->getActiveSheet()->setCellValue('D1', 'Working Day');
		$this->excel->getActiveSheet()->setCellValue('E1', 'Sunday');
		$this->excel->getActiveSheet()->setCellValue('F1', 'Leave');
		$this->excel->getActiveSheet()->setCellValue('G1', 'Holiday');
		$this->excel->getActiveSheet()->setCellValue('H1', 'ABSENT');
		$data['attendance_report'] =$this->user_report->get_attendance_sheet_all($start,$end);
		// pr($data['attendance_report']); die;

		$k_num = 2;
		if(!empty($data['attendance_report'])){


			foreach ( $data['attendance_report']as $row){
				$this->excel->getActiveSheet()->setCellValue('A'.$k_num, $row['user_emp']);
				$this->excel->getActiveSheet()->setCellValue('B'.$k_num, $row['user_name']);
				$this->excel->getActiveSheet()->setCellValue('C'.$k_num, $row['tot_day']);
				$this->excel->getActiveSheet()->setCellValue('D'.$k_num, $row['working_day']);
				$this->excel->getActiveSheet()->setCellValue('E'.$k_num, $row['sunday']);
				$this->excel->getActiveSheet()->setCellValue('F'.$k_num, $row['leave_day']);
				$this->excel->getActiveSheet()->setCellValue('G'.$k_num, $row['holiday'] );
				$this->excel->getActiveSheet()->setCellValue('H'.$k_num, $row['absent'] );
				$k_num++;
			}
		}
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		//$name=preg_replace('/\s+/', '', ucfirst(get_user_name($userid)));
		$filename='AttendanceReport.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
	//	ob_end_clean();
		//ob_start();
		$objWriter->save('php://output');
	}

/*User-wise Attendance Report*/
public function generate_attendance_report($userid,$start,$end)
    {
		$this->excel->setActiveSheetIndex(0);
        //name the worksheet
		$this->excel->getActiveSheet()->setTitle('Attendance Report');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', 'Customer');
		$this->excel->getActiveSheet()->setCellValue('B1', 'Date');
		$this->excel->getActiveSheet()->setCellValue('C1', 'Status');
		$this->excel->getActiveSheet()->setCellValue('D1', 'Leave From Date');
		$this->excel->getActiveSheet()->setCellValue('E1', 'Leave To Date');
		$data['attendance_report'] =$this->user_report->get_attendance_report($userid,$start,$end);
		$k_num = 2;
		 //pr($data['attendance_report']);die;
		/* For Attendance */
		if(!empty($data['attendance_report'])){
			$gazetted_holidays=get_gazetted_holiday();
			$yearly_holidays=json_decode($gazetted_holidays);
			$gazt_holidayz=array();
			$gazt_date_list=array();
			$currnt_yr=date('Y');
			foreach ($yearly_holidays as $yr_data){
				$gazt_holidayz[]=$yr_data->date_holiday.'-'.$currnt_yr.','.$yr_data->name_holiday;
				$gazt_date_list[]=$yr_data->date_holiday.'-'.$currnt_yr;
			}

			foreach ( $data['attendance_report']as $row){
				$row_date=date('m-d-Y',strtotime($row['date']));
				$this->excel->getActiveSheet()->setCellValue('A'.$k_num, get_user_name($userid));
				$this->excel->getActiveSheet()->setCellValue('B'.$k_num, date('d.m.Y',strtotime($row['date'])));
				if(array_key_exists("day",$row)){
					if($row['day']=='Sunday'){
						$phpColor = new PHPExcel_Style_Color();
						$phpColor->setRGB('FFC300');  
						$this->excel->getActiveSheet()->setCellValue('C'.$k_num, $row['day']);
						$this->excel->getActiveSheet()->getStyle('C'.$k_num)->getFont()->setColor( $phpColor );
					}
					elseif($row['day']=='Working')
					{
						$phpColor = new PHPExcel_Style_Color();
						$phpColor->setRGB('008000');  
						$this->excel->getActiveSheet()->setCellValue('C'.$k_num, $row['day']);
						$this->excel->getActiveSheet()->getStyle('C'.$k_num)->getFont()->setColor( $phpColor );
					}
				}
				else{
					$phpColor = new PHPExcel_Style_Color();
					$result=$this->user_report->check_leave_holiday($row['date'],$userid);
					if($result==1)
					{
						$phpColor->setRGB('FF0000'); 
						$this->excel->getActiveSheet()->setCellValue('C'.$k_num, 'On Leave');
						$this->excel->getActiveSheet()->getStyle('C'.$k_num)->getFont()->setColor( $phpColor );
					}
					elseif($result==2)
					{
						$phpColor->setRGB('33acff'); 
						$this->excel->getActiveSheet()->setCellValue('C'.$k_num, 'Holiday');
						$this->excel->getActiveSheet()->getStyle('C'.$k_num)->getFont()->setColor( $phpColor );
					}	
					elseif($result==3){
						if(in_array($row_date,$gazt_date_list)){
							foreach ($gazt_holidayz as $val_g ){
								$gaz=explode(',',$val_g);
								if($gaz[0]==$row_date){
								$phpColor->setRGB('ff3336');
								$this->excel->getActiveSheet()->setCellValue('C'.$k_num, $gaz[1]);
								$this->excel->getActiveSheet()->getStyle('C'.$k_num)->getFont()->setColor( $phpColor );
								}
							}

						}else{
							$phpColor->setRGB('33acff');
							$this->excel->getActiveSheet()->setCellValue('C'.$k_num, 'Absent / Not Interacted / Leave Not Applied.');
							$this->excel->getActiveSheet()->getStyle('C'.$k_num)->getFont()->setColor( $phpColor );
						}
					}
				} 
					
				if(array_key_exists("from_date",$row)){
					$this->excel->getActiveSheet()->setCellValue('D'.$k_num,  date('d.m.Y',strtotime($row['from_date'])));
				}
				else{
					$this->excel->getActiveSheet()->setCellValue('D'.$k_num, '--------');
				}
				if(array_key_exists("to_date",$row)){
					$this->excel->getActiveSheet()->setCellValue('E'.$k_num, date('d.m.Y',strtotime($row['to_date'])));
				}
				else{
					$this->excel->getActiveSheet()->setCellValue('E'.$k_num, '--------');
				}
				$k_num++;
			}
		}
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$name=preg_replace('/\s+/', '', ucfirst(get_user_name($userid)));
		$filename=$name.'AttendanceReport.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//ob_end_clean();
		//ob_start();
		$objWriter->save('php://output');
	}

	

        
    // for user base    
    public function get_tada_report($userid=''){ 
      
        if(!is_admin()){
        $data['title'] = "TA DA Report List";
        $data['page_name'] = "TA DA Report List";
        $data['action'] ="reports/reports/generate_tada_report";

        $this->load->get_view('report/check_ta_da_report_view',$data);
        }else{
             redirect('user'); 
        }

  }  


 public function generate_tada_report(){
       $data['title'] = "TA DA Report";
        $data['page_name'] = "TA DA Report";
//        if(is_admin()){
          $request = $this->input->post();
//echo $request['report_date'].'<br>'; 
          
//          echo $request['report_date']; die;
          
        if($this->report->first_time_genrate($request['report_date'], logged_user_data())){
          
          $report_date = explode('-',$request['report_date'] );
//          pr($report_date);
          $follow_month =  trim($report_date[0]); $follow_year =  trim($report_date[1]);
          $newstartdate =    $follow_month.'/01/'.$follow_year;         
//          str_replace('/', '-', $followstart_month);
          
          $newenddate =  $follow_month.'/20/'.$follow_year;  
                  
//                  str_replace('/', '-', $followend_date);
          $start = date('Y-m-d', strtotime($newstartdate))." 00:00:00";
          $end = date('Y-m-t', strtotime($newenddate))." 23:59:59";
          $this->load->library('form_validation');
//          $this->form_validation->set_rules('user_id', 'User', 'required');
          $this->form_validation->set_rules('report_date', 'Report Date range', 'required'); 
          if($this->form_validation->run() == TRUE){
//              echo $start; echo '<br>'.$end;
             $data['report_date'] = $request['report_date'];
             $data['tada_report'] =$this->report->get_tada_report(logged_user_data(),$start,$end);


             $gazetted_holidays=get_gazetted_holiday();
             $gaz_holid=json_decode($gazetted_holidays);
             $year_d=date('Y');
			 $date_gz_list=array();
             $gz_list=array();
             foreach ($gaz_holid as $gz){
             	 $date_gz=$year_d.'-'.$gz->date_holiday;
				 $date_gz_list[]=$date_gz;
             	 $gz_list[]= $date_gz .';'. $gz->name_holiday ;
			 }
             $data['date_gz_holiday']=$date_gz_list;
             $data['gazetted_holidays']=$gz_list;
             
             $trip_details=get_trip_details(logged_user_data());
			if(!empty($trip_details)){
				$from=$trip_details->from_date;
				$to=$trip_details->to_date;
				$data['tripName']=$trip_details->remarks;
				$tripDateBetw=getDatesFromRange($from,$to);
				$dateTrip=array();
				foreach ($tripDateBetw as $daTrp){
					$dateTrip[]=substr($daTrp, 0, 10);
				}
				$data['tripDateList']=$dateTrip;
			}
             
//             pr($data['tada_report'] ); die;
              $data['action'] ="reports/reports/send_for_approval";
             
             $this->load->get_view('report/ta_da_report_view',$data);
             
//            $this->show_tada_report($request['user_id'],$start,$end);
            //$data['attendance_report'] =$this->user_report->get_attendance_report($request['user_id'],$start,$end);
          }else{
              // for false validation
              $this->get_tada_report();  
          }

        }else{
              
              $this->get_tada_report(); 
          } 
//        else{
//          redirect('user');
//        }
  }
  
  // send for approval to Manager
  public function send_for_approval(){
      
      $post = $this->input->post();
      
      $success =$this->report->save_tada_report_of_approval($post);
      
      
//      $success = $this->tour->add_bulk_tour($post_data);
		if($success>0){  // on sucess
			set_flash('<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-check"></i> Success!</h4>Tours Saved Successfully.</div>'); 
			redirect('reports/reports/generate_tada_report');
		}
		else{ // on unsuccess
			set_flash('<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-ban"></i> Alert!</h4>Tour Does not Save.</div>');
			redirect('reports/reports/generate_tada_report');
		}
      
//           pr($post); die;
      
  }
  
  
  // Show user ta/da report to their boss and admin
  public function user_ta_da_report(){
      
         $data['title'] = "TA/DA List";
         $data['page_name']="TA/DA List";
         $data['user_tada_report'] = $this->report->tada_report_list();
      
         $this->load->get_view('report/ta_da_details_view',$data);
         
//        pr($data['user_tada_report']); die;
  }
  
  
  
//     public function ta_da_manager_view($id,$is_approved=''){
      
//       $tada_id = urisafedecode($id);
//         $data['title'] = "TA/DA";
//         $data['page_name']="TA/DA";
       
        
        
//         if(!empty($is_approved)){
//             $data['manager_total_amount'] = urisafedecode($is_approved);
//         }
//       $data['tada_report'] =$this->report->genrated_tada_report($tada_id);
             
// //             pr($data['tada_report'] ); die;
//              $data['action'] ="reports/reports/send_for_admin/$id";
             
//              $this->load->get_view('report/ta_da_manager_detail_view',$data);
      
      
//   }

 public function ta_da_manager_view($id,$name='',$month_year='',$grant_total='',$is_approved=''){
      
       $tada_id = urisafedecode($id);
        $data['title'] = "TA/DA";
        $data['page_name']="TA/DA";
        $data['month_year']=urisafedecode($month_year);
        $data['name']=urisafedecode($name);
        
        $data['grand_total']=urisafedecode($grant_total);
        if(!empty($is_approved)){
            $data['manager_total_amount'] = urisafedecode($is_approved);
        }
       $data['tada_report'] =$this->report->genrated_tada_report($tada_id);
             
//             pr($data['tada_report'] ); die;
             $data['action'] ="reports/reports/send_for_admin/$id";
             
             $this->load->get_view('report/ta_da_manager_detail_view',$data);
      
      
  }
  
  
    public function send_for_admin($id){
       $tada_id = urisafedecode($id);
      $post = $this->input->post();
      
      $success =$this->report->save_tada_approved_report_of_manager($post,$tada_id);
      
      
//      $success = $this->tour->add_bulk_tour($post_data);
		if($success>0){  // on sucess
			set_flash('<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-check"></i> Success!</h4>'.$success.'Tours Saved Successfully.</div>'); 
			redirect('reports/reports/user_ta_da_report');
		}
		else{ // on unsuccess
			set_flash('<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-ban"></i> Alert!</h4>Tour Does not Save.</div>');
			redirect('reports/reports/user_ta_da_report');
		}
      
//           pr($post); die;
      
  }
  
  
  
            public function ta_da_aprroved_report(){

                  $data['title'] = "TA/DA List";
                  $data['page_name']="TA/DA List";
                  $data['user_tada_report'] = $this->report->tada_report_list();

                  $this->load->get_view('report/ta_da_details_view',$data);

             //        pr($data['user_tada_report']); die;
               }
               
               // my ta da report
               public function my_ta_da_report(){

                  $data['title'] = "TA/DA List";
                  $data['page_name']="TA/DA List";
                  $data['user_tada_report'] = $this->report->tada_report_list();

                  $this->load->get_view('report/myta_da_details_view',$data);

             //        pr($data['user_tada_report']); die;
               } 
               
                 public function my_ta_da_view($id,$name='',$month_year='',$grant_total='',$manager_approved='',$admin_approved=''){
                $tada_id = urisafedecode($id);
                 $data['title'] = "TA/DA";
                 $data['page_name']="TA/DA";

                  $data['month_year']=urisafedecode($month_year);
                     $data['name']=urisafedecode($name);
                     $data['grand_total']=urisafedecode($grant_total);

                     $data['manager_total_amount'] = urisafedecode($manager_approved);

//                 if(!empty($admin_approved)){
                     $data['admin_total_amount'] = urisafedecode($admin_approved);
//                 }
                $data['tada_report'] =$this->report->genrated_tada_report($tada_id);

         //             pr($data['tada_report'] ); die;
//                      $data['action'] ="reports/reports/approved_by_admin/$id";

                      $this->load->get_view('report/myta_da_detail_view',$data);


           }
               
               
         public function ta_da_admin_view($id,$name='',$month_year='',$grant_total='',$manager_approved='',$admin_approved=''){

                $tada_id = urisafedecode($id);
                 $data['title'] = "TA/DA";
                 $data['page_name']="TA/DA";
                 $data['month_year']=urisafedecode($month_year);
                 $data['name']=urisafedecode($name);

                     $data['manager_total_amount'] = urisafedecode($manager_approved);
                      $data['grand_total']=urisafedecode($grant_total);

                 if(!empty($admin_approved)){
                     $data['admin_total_amount'] = urisafedecode($admin_approved);
                 }

                $data['tada_report'] =$this->report->genrated_tada_report($tada_id);
              //  pr($data); die;
         //             pr($data['tada_report'] ); die;
                      $data['action'] ="reports/reports/approved_by_admin/$id";

                      $this->load->get_view('report/ta_da_admin_detail_view',$data);


           }
  
      public function approved_by_admin($id){
       $tada_id = urisafedecode($id);
      $post = $this->input->post();
      
      $success =$this->report->save_tada_approved_report_of_admin($post,$tada_id);
      
      
//      $success = $this->tour->add_bulk_tour($post_data);
		if($success>0){  // on sucess
			set_flash('<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-check"></i> Success!</h4>'.$success.'Tours Saved Successfully.</div>'); 
			redirect('reports/reports/ta_da_aprroved_report');
		}
		else{ // on unsuccess
			set_flash('<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-ban"></i> Alert!</h4>Tour Does not Save.</div>');
			redirect('reports/reports/ta_da_aprroved_report');
		}
      
//           pr($post); die;
      
  }
  
  
  

  	/**NITIN KUMAR
  	 * Dynamic User's DA
  	 * */
	public function users_da(){
	$data['title'] = "User's DA List";
	$data['page_name']="User's DA List";
	$data['users_da']=get_users_da();
	$this->load->get_view('users_da/list_users_da',$data);
	}

	public function edit_user_da($id=''){
	  if($id!=''){
		  $data['title']="Edit DA";
		  $data['page_name'] = "Edit DA";
		  $data['action'] = "reports/reports/save_user_da/$id";
		  $cm_id= urisafedecode($id);
		  $data['user_da'] = get_userwise_da($cm_id);
		  $this->load->get_view('users_da/user_da_edit_view',$data);
	  }
	}

	public function add_user_da(){
	  $data['title'] = "Add User's DA";
	  $data['page_name']="Add User's DA";
	  $data['users']=get_all_paharma_user();
	  $data['action']="reports/reports/save_new_user_da";
	  $this->load->get_view('users_da/add_users_da',$data);
	}

	public function get_designation_name(){
		$post=$this->input->post();
		$data=get_user_deatils($post['desg_id']);
		$desg_name=get_designation_name($data->user_designation_id);
		echo $desg_name->designation_name.'-'.$data->user_designation_id;
	}

	public function save_new_user_da(){

	$this->load->library('form_validation');
	  $this->form_validation->set_rules('hq_rates', 'Headquarter rates', 'required');
	  $this->form_validation->set_rules('ex_hq_rates', 'Ex Headquarter rates', 'required');
	  $this->form_validation->set_rules('out_st_rates', 'Out station rates', 'required');
	  $this->form_validation->set_rules('trans_rate', 'Transit rates', 'required');

	  if($this->form_validation->run() == TRUE){
		  $pos=$this->input->post();
		  $success = $this->report->add_users_da($pos);
		  if($success=1){  // on sucess
			  set_flash('<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-check"></i> Success!</h4>
		   User\'s DA Created Successfully.
		  </div>');
			  $this->users_da();
		  }
		  else{ // on unsuccess
			  set_flash('<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-ban"></i> Alert!</h4>
		   User\'s DA does not Save. Plaese Try again !!
		  </div>');
			  $this->users_da();
		  }

	  }



	}

	public function save_user_da($id=''){

	  $this->load->library('form_validation');
	  $this->form_validation->set_rules('hq_rates', 'Headquarter rates', 'required');
	  $this->form_validation->set_rules('ex_hq_rates', 'Ex Headquarter rates', 'required');
	  $this->form_validation->set_rules('out_st_rates', 'Out station rates', 'required');
	  $this->form_validation->set_rules('trans_rate', 'Transit rates', 'required');

	  if($this->form_validation->run() == TRUE){
		  $sm_id= urisafedecode($id);
		  $post_data = $this->input->post();

		  $success = $this->report->update_users_da($post_data,$sm_id);
		  if($success=1){  // on sucess
			set_flash('<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-check"></i> Success!</h4>
		   User\'s DA Updated Successfully.
		  </div>');
			  $this->users_da();
		  }
		  else{ // on unsuccess
			set_flash('<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-ban"></i> Alert!</h4>
		   User\'s DA does not Save. Plaese Try again !!
		  </div>');
			  $this->users_da();
		  }

	  }
	  else{  // for false validation
		  if($id!=''){  // go to edit if id have
			  $this->edit_user_da($id);
		  }else{
			  $this->users_da();
		  }

	  }

	}
        
}
?>