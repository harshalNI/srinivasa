<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends CI_Controller {
	 public function __construct()
    {
        parent::__construct();
        $this->load->model('branch_model', 'Branch');
        if(!empty($this->session->userdata['username'])){
            $this->load->view('common/header');
        }else{
            redirect('users/login');
        }
        
    }

    //start of function to display list of branches
    public function BranchList(){
        $data['branches'] = $this->Branch->GetAllBranches();
        $this->load->view('branches/list', $data);
        $this->load->view('common/footer');
    }
    //end of function to display list of categories
    public function GetAllCategories(){
        $categories = $this->Category->GetAllCategories();
        echo json_encode($categories);exit;
    }

    //start of function to create branch
    public function BranchCreate(){
        $this->form_validation->set_rules('branchName', 'Branch Name', 'trim|required');
        if ($this->form_validation->run() === FALSE){
            $this->load->view('branches/add');
            $this->load->view('common/footer');
        }
        else{
            $this->Branch->CareteBranch();
            $this->session->set_flashdata('message', 'Branch created successfully.');
            redirect('branches');
        }
    }
    //end of function to create branch

    //start of function to update branch by id
    public function BranchUpdate($branch_id){
        $this->form_validation->set_rules('branchName', 'Branch Name', 'trim|required');
        $data['details'] = $this->Branch->GetBranchDetailsById($branch_id);
        if ($this->form_validation->run() === FALSE){
            $this->load->view('branches/edit', $data);
            $this->load->view('common/footer');
        }
        else{
            $this->Branch->UpdateBranch($branch_id);
            $this->session->set_flashdata('message', 'Branch updated successfully.');
            redirect('branches');
        }
    }
    //end of function to update branch by id

    //start of function to deactivate branch
    public function BranchDeactivate(){
        $branch_id = $_REQUEST['branch_id'];
        $this->Branch->DeactivateBranch($branch_id);
    }
    //end of function to deactivate branch

    //start of function to activate branch
    public function BranchActivate(){
        $branch_id = $_REQUEST['branch_id'];
        $this->Branch->ActivateBranch($branch_id);
    }
    //end of function to activate branch

    //start of function to delete branch
    public function BranchDelete(){
        $branch_id = $_REQUEST['branch_id'];
        $this->Branch->DeleteBranch($branch_id);
    }
    //end of function to delete branch
}
