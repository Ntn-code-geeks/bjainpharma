<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Niraj Kuamr
 * Dated: 12/03/2018
 * 
 * This Controller is for Add Product
 */

class Product extends Parent_admin_controller {

   function __construct() 
    {
        parent::__construct();
            $loggedData=logged_user_data();
            
            if(empty($loggedData)){
                redirect('user'); 
            }
        $this->load->model('category/category_model','category');
        $this->load->model('product/product_model','product');
    }
    
    public function index(){    
                    $data['title'] = "Product List";
                    $data['page_name'] = "Product List";
                            $data['product_list']=array();
                            $productList= $this->product->get_product_list();
                            if($productList!=FALSE)
                            {
                                    $data['product_list'] =$this->product->get_product_list();
                            }
                    $this->load->get_view('product/product_list_view',$data);
    }

    public function add_product(){
        		$data['category_list']=array();
        		$data['potency_list']=array();
        		$data['packsize_list']=array();
        		$data['title'] = "Add Product";
                $data['page_name'] = "Add Product";
        		$categoryList= $this->category->get_active_category();
        		$potencyList= $this->product->get_potency_list();
        		$packsizeList= $this->product->get_packsize_list();
        		if($categoryList!=FALSE)
        		{
        			$data['category_list'] =$this->category->get_category(); 
        		}
        		if($potencyList!=FALSE)
        		{
        			$data['potency_list'] =$this->product->get_potency_list(); 
        		}
        		if($packsizeList!=FALSE)
        		{
        			$data['packsize_list'] =$this->product->get_packsize_list(); 
        		}
        		$data['action'] = "product/product/save_product"; 
                $this->load->get_view('product/add_product_view',$data);
    }
	
	public function save_product(){
		$post_data = $this->input->post();
		$this->load->library('form_validation');
        $this->form_validation->set_rules('category_id', 'Category', "required");
        $this->form_validation->set_rules('pro_name', 'Product name', "required");
       // $this->form_validation->set_rules('potency_id', 'Potency', "required");
        // $this->form_validation->set_rules('packsize_id', 'Packsize', "required");
        $this->form_validation->set_rules('price', 'Price', "required|numeric");
		if($this->form_validation->run() == TRUE){
			$success= $this->product->save_product($post_data);
			if($success)
			{
				set_flash('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Success!</h4>Category Successfully Added. </div>'); 
				redirect('product/product/index');
			}
			else
			{
				set_flash('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Alert!</h4>Category Can Not Successfully Added.</div>');
				redirect('product/product/add_product');
			}
		}
		else{
			$this->add_product();
		}
    }
	
		
	public function edit_product($id=''){
		$data['category_list']=array();
		$data['potency_list']=array();
		$data['packsize_list']=array();
        $productid= urisafedecode($id);
		$categoryList= $this->category->get_active_category();
		$potencyList= $this->product->get_potency_list();
		$packsizeList= $this->product->get_packsize_list();
		if($categoryList!=FALSE)
		{
			$data['category_list'] =$this->category->get_category(); 
		}
		if($potencyList!=FALSE)
		{
			$data['potency_list'] =$this->product->get_potency_list(); 
		}
		if($packsizeList!=FALSE)
		{
			$data['packsize_list'] =$this->product->get_packsize_list(); 
		}
		$data['title'] = "Edit Product";
        $data['page_name'] = "Edit Product";
		$data['action'] = "product/product/update_product";
		$data['category_data']=array();
		$productData=$this->product->get_product_data($productid);
		if($productData!=FALSE)
		{
			$data['product_data'] =$productData; 
		}
		$this->load->get_view('product/edit_product_view',$data);
    }
	
	public function update_product(){
		$post_data = $this->input->post();
		$this->load->library('form_validation');
        $this->form_validation->set_rules('category_id', 'Category', "required");
        $this->form_validation->set_rules('pro_name', 'Product name', "required");
       // $this->form_validation->set_rules('potency_id', 'Potency', "required");
        $this->form_validation->set_rules('packsize_id', 'Packsize', "required");
        $this->form_validation->set_rules('price', 'Price', "required|numeric");
		if($this->form_validation->run() == TRUE){
			$success=$this->product->update_product($post_data);
			if($success==1){  // on sucess
			
				set_flash('<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-check"></i> Success!</h4>
				Product Successfully Updated. </div>'); 
				redirect('product/product/index');
			   
		   }
		   else{ // on fail
			   set_flash('<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> Alert!</h4>
				Product Not Successfully Updated.</div>');
				redirect('product/product/edit_product/'.urisafeencode($post_data['category_id']));
		   }

		}
		else{
			$this->edit_product(urisafeencode($post_data['product_id']));
		}
    }


/*Import Product via CSV*/
    public function import_product(){
		if(is_admin()){
			$data['title']="Import Product";
			$data['page_name'] = "Import Product";
			$data['action'] = "product/product/save_bulk_product";
			$this->load->get_view('product/product_import_view',$data);
		}
		else{
			redirect('user');
		}
	}

    public function save_bulk_product(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user', 'User', 'required');
		if($this->form_validation->run() == FALSE){
			return $this->import_doctor();

		}
		else{
			$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
			if(in_array($_FILES['file']['type'],$mimes)){
				$filename=$_FILES["file"]["tmp_name"];
				if($_FILES["file"]["size"] > 0)
				{
					$file = fopen($filename, "r");
					$row=1;
					$count=0;
					while (($importdata = fgetcsv($file, 1000000, ",")) !== FALSE)
					{
						if($row == 1){ $row++; continue; }
						if($importdata[5] != ''){
							$id=$this->doctor->doc_last_id()+1;
							$doctor_id='doc_'.$id;
							$data = array(
//								'doctor_id' =>$doctor_id,
//								'doc_name' => $importdata[0],
//								'doc_email' => $importdata[6],
//								'doc_phone' => $importdata[5],
//								'doc_address' => $importdata[2],
//								'city_id' => $importdata[3],
//								'state_id' => $importdata[4],
//								'doc_gender' => $importdata[1],
//								'city_pincode'=>$importdata[7],
//								'sp_code'=>$importdata[8],
//								'crm_user_id' => $this->input->post('user'),
//								'last_update' => savedate(),
//								'doc_status' =>1,
//								'blocked' =>0,
							);
							$insert = $this->doctor->doc_import_save($data);
							if(!$insert)
							{
								$count=$count+1;
							}
						}
					}
					fclose($file);
					set_flash('<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-check"></i> Success!</h4>
					Doctor are imported successfully.'.$count.' Duplicate Mobile Found. </div>');
					redirect('doctors/doctor/import_doctor');
				}else{
					set_flash('<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-ban"></i> Alert!</h4>
					Empty File !!
					</div>');
					redirect('doctors/doctor/import_doctor');
				}
			} else {
				set_flash('<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> Alert!</h4>
				Sorry file not allowed. Try again !!
				</div>');
				redirect('doctors/doctor/import_doctor');
			}
		}
	}

}

?>
