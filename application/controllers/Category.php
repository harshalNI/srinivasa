<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
	 public function __construct()
    {
        parent::__construct();
        $this->load->model('category_model', 'Category');
        if(!empty($this->session->userdata['username'])){
            $this->load->view('common/header');
        }else{
            redirect('users/login');
        }
        
    }

    //start of function to display list of categories
    public function CategoryList(){
        $data['categories'] = $this->Category->GetAllCategories();
        $this->load->view('categories/list', $data);
        $this->load->view('common/footer');
    }
    //end of function to display list of categories
    public function GetAllCategories(){
        $categories = $this->Category->GetAllCategories();
        echo json_encode($categories);exit;
    }

    //start of function to create category
    public function CategoryCreate(){
        $this->form_validation->set_rules('categoryName', 'Category Name', 'trim|required');
        if ($this->form_validation->run() === FALSE){
            $this->load->view('categories/add');
            $this->load->view('common/footer');
        }
        else{
            $this->Category->CareteCategory();
            $this->session->set_flashdata('message', 'Category created successfully.');
            redirect('categories');
        }
    }
    //end of function to create category

    //start of function to update category by id
    public function CategoryUpdate($cat_id){
        $this->form_validation->set_rules('categoryName', 'Category Name', 'trim|required');
        $data['details'] = $this->Category->GetCategoryDetailsById($cat_id);
        if ($this->form_validation->run() === FALSE){
            $this->load->view('categories/edit', $data);
            $this->load->view('common/footer');
        }
        else{
            $this->Category->UpdateCategory($cat_id);
            $this->session->set_flashdata('message', 'Category updated successfully.');
            redirect('categories');
        }
    }
    //end of function to update category by id

    //start of function to deactivate category
    public function CategoryDeactivate(){
        $cat_id = $_REQUEST['category_id'];
        $this->Category->DeactivateCategory($cat_id);
    }
    //end of function to deactivate category

    //start of function to activate category
    public function CategoryActivate(){
        $cat_id = $_REQUEST['category_id'];
        $this->Category->ActivateCategory($cat_id);
    }
    //end of function to activate category

    //start of function to delete category
    public function CategoryDelete(){
        $cat_id = $_REQUEST['category_id'];
        $this->Category->DeleteCategory($cat_id);
    }
    //end of function to delete category
}
