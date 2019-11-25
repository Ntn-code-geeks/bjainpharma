<?php


defined('BASEPATH') OR exit('No direct script access allowed');





/* 


 * Niraj Kumar


 * Dated: 28/09/2017


 * 


 * 


 * This Controller is for To do list


 */





class To_do extends Parent_admin_controller {


    


    function __construct() 


    {


        parent::__construct();





        $loggedData=logged_user_data();


            


            if(empty($loggedData)){


                redirect('user'); 


            }


          


               $this->load->model('to_do_list/To_do_model','todo');


//        $this->load->model('school/School_model','school');


    }


    


    public function index(){
        $current_date= savedate();
        $data['title'] = "To Do List";
        $data['page_name'] = "To Do List";
        $data['action']= "to_do_list/to_do/update_to_do";
        $data['todo_info_doc']=$this->todo->get_to_do_doctor($current_date);
        $data['todo_info_dealer']=$this->todo->get_to_do_dealer($current_date);
        $this->load->get_view('to_do_list/to_do_view',$data);

    }


    


    // show data for previous and next date in dodo


      public function todo_datewise(){


        


         $todo_date = $this->input->post();


          $current_date = date("Y-m-d h:i:s",strtotime($todo_date['followupdate']));


           $data['todo_info_doc']=$this->todo->get_to_do_doctor($current_date);


        $data['todo_info_dealer']=$this->todo->get_to_do_dealer($current_date);


           


         $todo_doc = json_decode($data['todo_info_doc']);


         $todo_dealer = json_decode($data['todo_info_dealer']);


         


         foreach($todo_doc as $k=>$val){ 


               echo ' <li style="" class="">';


             


                


                  


                 echo ' <input name="doc_id[]" value="'.$val->id.'" type="checkbox">';


                   


                 echo '<span class="text">'.$val->doc_name.'</span>';


                 


                echo '</li>';


               


            }


            foreach($todo_dealer as $k_d=>$val_d){ 


               echo ' <li style="" class="">';


             


                


                  


                 echo ' <input name="d_id[]" value="'.$val_d->id.'" type="checkbox">';


                   


                 echo '<span class="text">'.$val_d->d_name.'</span>';


                 


                echo '</li>';


               


            }





              echo '</ul>';


         


    }


    


    


    // 


    public function completed_list(){


         $data['title'] = "To Do Completed";


         $data['page_name'] = "To Do Completed";


               


//        $data['todo_info']=$this->todo->get_to_do();


         $data['todo_info_doc']=$this->todo->get_to_do_doctor();


        $data['todo_info_dealer']=$this->todo->get_to_do_dealer();


//       pr(json_decode( $data['todo_info'])); die;


       $this->load->get_view('to_do_list/to_do_completed_view',$data);


        


        


    }


    public function update_to_do() {


        


        $request = $this->input->post();


//        pr($request); die;


        


        $success = $this->todo->interaction_update($request);


        


           if($success=1){  // on sucess


           


            set_flash('<div class="alert alert-success alert-dismissible">


                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>


                <h4><i class="icon fa fa-check"></i> Success!</h4>


              Your Task is done Successfully.


              </div>'); 


           


            redirect($_SERVER['HTTP_REFERER']);


           


       }


       else{ // on unsuccess


           set_flash('<div class="alert alert-danger alert-dismissible">


                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>


                <h4><i class="icon fa fa-ban"></i> Alert!</h4>


                Your Task is not saved Successfully.


              </div>');


            redirect($_SERVER['HTTP_REFERER']);


       }


        


    }


    


    


}





?>