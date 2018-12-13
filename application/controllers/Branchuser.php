<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branchuser extends CI_Controller {
	 public function __construct()
    {
        parent::__construct();
        $this->load->model('branchuser_model', 'Branchuser');
        $this->load->model('branch_model', 'Branch');
        $this->load->model('user_model', 'User');
        if(!empty($this->session->userdata['username'])){
            $this->load->view('common/header');
        }else{
            redirect('users/login');
        }
        
    }

    //start of function to display list of branch addmin users
    public function BranchUserList(){
        $this->form_validation->set_rules('branchName', 'Branch Name', 'trim|required');
        $data['branches'] = $this->Branch->GetAllActiveBranches();
        if ($this->form_validation->run() === FALSE){
            $this->load->view('branchuser/list', $data);
            $this->load->view('common/footer');
        }
        else{
            $branch_id = $this->input->post('branchName');
            $data['branch_name'] = $branch_id;
            $data['users'] = $this->Branchuser->GetAdminUsersByBranch($branch_id);
            $this->load->view('branchuser/list', $data);
            $this->load->view('common/footer');
        }
        
    }
    //end of function to display list of branch admin users

    //start of function to create branch admin user
    public function BranchUserCreate(){
        $data['branches'] = $this->Branch->GetAllActiveBranches();
        $this->form_validation->set_rules('branchName', 'Branch Name', 'trim|required');
        $this->form_validation->set_rules('firstName', 'First Name', 'trim|required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('roleName', 'Role Name', 'trim|required');
        $this->form_validation->set_rules('userName', 'User Name', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('contactNumber', 'Contact Number', 'trim|required'); 
        $data['roles'] = $this->User->GetRoleList();  
        if ($this->form_validation->run() === FALSE){
            $this->load->view('branchuser/add', $data);
            $this->load->view('common/footer');
        }
        else{
            $this->Branchuser->CareteBranchUser();
            $this->session->set_flashdata('message', 'Branch User created successfully.');
            redirect('branch/users');
        }
    }
    //end of function to create branch admin user

    //start of function to update branch by id
    public function BranchUserUpdate($user_id){
        $data['branches'] = $this->Branch->GetAllActiveBranches();
        $this->form_validation->set_rules('branchName', 'Branch Name', 'trim|required');
        $this->form_validation->set_rules('firstName', 'First Name', 'trim|required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('roleName', 'Role Name', 'trim|required');
        $this->form_validation->set_rules('userName', 'User Name', 'trim|required');
        $this->form_validation->set_rules('contactNumber', 'Contact Number', 'trim|required'); 
        $data['details'] = $this->User->GetUserInfoById($user_id);
        $data['roles'] = $this->User->GetRoleList();  
        if ($this->form_validation->run() === FALSE){
            $this->load->view('branchuser/edit', $data);
            $this->load->view('common/footer');
        }
        else{
            $this->Branchuser->UpdateBranchUser($user_id);
            $this->session->set_flashdata('message', 'Branch user updated successfully.');
            redirect('branch/users');
        }
    }
    //end of function to update branch by id
}
