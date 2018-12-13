<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	 public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'User');
        
    }

    //Start of function to log in user
    public function LoginUser(){
        if(!empty($this->session->userdata['email']) && uri_string() == 'users/login'){
            redirect('');
        }else{
            $this->form_validation->set_rules("username", "Username", "trim|required");
            $this->form_validation->set_rules("password", "Password", "trim|required");

              if ($this->form_validation->run() == FALSE)
              {//print_r('Error');exit;
                   //validation fails
                    $this->load->view('user/login');
              }
              else
              {
                   //validation succeeds
                   if ($this->input->post('btn_login') == "Login")
                   {
                        $username = $this->input->post('username');
                        $password = $this->input->post('password');
                        //check if username and password is correct
                        $usr_result = $this->User->GetUserDetailsForLogin($username, $password);
                        if (!empty($usr_result)) //active user record is present
                        {
                             //set the session variables
                             $sessiondata = array(
                                  'username' => $usr_result->username,
                                  'name' => $usr_result->first_name.' '.$usr_result->last_name,
                                  'role' => $usr_result->role_name,
                                  'role_id' => $usr_result->role_id,
                                  'user_id' => $usr_result->user_id,
                                  'loginuser' => TRUE
                             );
                             $this->session->set_userdata($sessiondata);

                             redirect("users");
                        }
                        else
                        {
                             $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                             redirect('users/login');
                        }
                   }
                   else
                   {
                        redirect('users/login');
                   }
              }
          }
    }
    //End of function to log in admin user

    //start of function to display list of all users
    public function UserList(){
      if(!empty($this->session->userdata['username'])){
      	$data['users'] = $this->User->GetAllActiveUsers();
          $this->load->view('common/header');
      	$this->load->view('user/list', $data);
      	$this->load->view('common/footer');
      }else{
        redirect('users/login');
      }
    }
    //end of function to display list of all users

    //start of function to create user
    public function  UserCreate(){
      if(!empty($this->session->userdata['username'])){
      	$this->form_validation->set_rules('firstName', 'First Name', 'trim|required');
      	$this->form_validation->set_rules('lastName', 'Last Name', 'trim|required');
      	$this->form_validation->set_rules('roleName', 'Role Name', 'trim|required');
    		$this->form_validation->set_rules('userName', 'User Name', 'trim|required');
    		$this->form_validation->set_rules('password', 'Password', 'trim|required');
    		$this->form_validation->set_rules('contactNumber', 'Contact Number', 'trim|required'); 
    		$data['roles'] = $this->User->GetRoleList();  	
        	if ($this->form_validation->run() === FALSE){
                $this->load->view('common/header');
    			$this->load->view('user/add', $data);
    			$this->load->view('common/footer');
    		}
    		else{
    			$this->User->createUser();
    			$this->session->set_flashdata('message', 'User created successfully.');
    			redirect('users');
    		}
      }else{
        redirect('users/login');
      }
    }
    //end of function to create user

    //start of function to update user info
    public function UserUpdate($user_id){
      if(!empty($this->session->userdata['username'])){
      	$this->form_validation->set_rules('firstName', 'First Name', 'trim|required');
      	$this->form_validation->set_rules('lastName', 'Last Name', 'trim|required');
      	$this->form_validation->set_rules('roleName', 'Role Name', 'trim|required');
    		$this->form_validation->set_rules('userName', 'User Name', 'trim|required');
    		$this->form_validation->set_rules('contactNumber', 'Contact Number', 'trim|required'); 
    		$data['details'] = $this->User->GetUserInfoById($user_id);
    		$data['roles'] = $this->User->GetRoleList();  	
        	if ($this->form_validation->run() === FALSE){
                $this->load->view('common/header');
    			$this->load->view('user/edit', $data);
    			$this->load->view('common/footer');
    		}
    		else{
    			$this->User->UpdateUser($user_id);
    			$this->session->set_flashdata('message', 'User updated successfully.');
    			redirect('users');
    		}
      }else{
        redirect('users/login');
      }
    }
    //end of function to update user info

    //start of function to deactivate user
    public function UserDeactivate(){
    	$user_id = $_REQUEST['user_id'];
    	$this->User->DeactivateUser($user_id);
    }
    //end of function to deactivate user

    //start of function to activate user
    public function UserActivate(){
    	$user_id = $_REQUEST['user_id'];
    	$this->User->ActivateUser($user_id);
    }
    //end of function to activate user

    //start of function to delete user
    public function UserDelete(){
    	$user_id = $_REQUEST['user_id'];
    	$this->User->DeleteUser($user_id);
    }
    //end of function to delete user

    //Start of functtion to change user password
    public function ChangePassword(){
        if(!empty($this->session->userdata['username'])){
                $this->form_validation->set_rules("password", "Password", "trim|required");

                  if ($this->form_validation->run() == FALSE)
                  {    //validation fails
                        $this->load->view('common/header');
                        $this->load->view('user/changepassword');
                        $this->load->view('common/footer');
                  }
                  else
                  {

                        $this->User->ChangePassword($this->session->userdata['username']);
                        $this->session->set_flashdata('msg', 'Password changed successfully!');
                        redirect('user/changepassword');
                  }
            }
            else{
                redirect('users/login');
            }
    }
    //End of function to change user password

    //Start of function to logout user
    public function LogoutUser(){
        $newdata = array(
                'username' => '',
                'name' => '',
                'role' => '',
                'logged_in' => FALSE,
               );

     $this->session->unset_userdata($newdata);
     $this->session->sess_destroy();
     redirect('users/login');
    }
    //End of function to logout user
}
