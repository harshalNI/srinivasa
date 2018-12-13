<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
	 public function __construct()
    {
        parent::__construct();
        $this->load->model('category_model', 'Category');
        $this->load->model('product_model', 'Product');
        if(!empty($this->session->userdata['username'])){
            $this->load->view('common/header');
        }else{
            redirect('users/login');
        }
    }

    //start of function to display list of all products
    public function ProductList(){
        $data['products'] = $this->Product->GetListOfAllProducts();
        $this->load->view('products/list', $data);
        $this->load->view('common/footer');
    }
    //end of function to display list of all products

    public function GetAllProductsByCatID(){
        $cat_id = $_REQUEST['cat_id'];
        $products = $this->Product->GetProductsByCategoryID($cat_id);
        echo"<option value=''>Please Select</option>";
        foreach($products as $product):
            echo"<option value='$product->product_id'>$product->product_name</option>";
        endforeach;exit;
    }

    //start of function to create products
    public function ProductCreate(){
        $this->form_validation->set_rules('categoryName', 'Category Name', 'trim|required');
        $this->form_validation->set_rules('productName', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('productQuantity', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('productMeasure', 'Measure', 'trim|required');
        $data['categories'] = $this->Category->GetAllActiveCategories();
        if ($this->form_validation->run() === FALSE){
            $this->load->view('products/add', $data);
            $this->load->view('common/footer');
        }
        else{
            $this->Product->CareteProduct();
            $this->session->set_flashdata('message', 'Product created successfully.');
            redirect('categories/products');
        }
    }
    //end of function to create products

    //start of function to update product info
    public function ProductUpdate($prod_id){
        $this->form_validation->set_rules('categoryName', 'Category Name', 'trim|required');
        $this->form_validation->set_rules('productName', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('productQuantity', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('productMeasure', 'Measure', 'trim|required');
        $data['categories'] = $this->Category->GetAllActiveCategories();
        $data['product_info'] = $this->Product->GetProductInfoByID($prod_id);
        if ($this->form_validation->run() === FALSE){
            $this->load->view('products/edit', $data);
            $this->load->view('common/footer');
        }
        else{
            $this->Product->UpdateProduct($prod_id);
            $this->session->set_flashdata('message', 'Product updated successfully.');
            redirect('categories/products');
        }
    }
    //end of function to update product info

    //start of function to deactivate product
    public function ProductDeactivate(){
        $prod_id = $_REQUEST['prod_id'];
        $this->Product->DeactivateProduct($prod_id);
    }
    //end of function to deactivate product

    //start of function to activate product
    public function ProductActivate(){
        $prod_id = $_REQUEST['prod_id'];
        $this->Product->ActivateProduct($prod_id);
    }
    //end of function to activate product

    //start of function to delete product
    public function ProductDelete(){
        $prod_id = $_REQUEST['prod_id'];
        $this->Product->DeleteProduct($prod_id);
    }
    //end of function to delete product
}
