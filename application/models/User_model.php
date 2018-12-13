<?php
class User_model extends CI_Model{
	//start of function to check login user details
	public function GetUserDetailsForLogin($username, $password){
		$enc_password = base64_encode($password);
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('roles', 'users.role_id = roles.role_id', 'left');
		$this->db->where(array(
				'username' => $username,
				'password' => $enc_password,
			));
		$query = $this->db->get();
		$data = $query->result();
		return $data[0];
	}
	//end of function to check login user details
	//start of function to fetch all active records from table
	public function GetAllActiveUsers(){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('roles', 'users.role_id = roles.role_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	//end of function to fetch all active records from table

	//start of function to get roles list from roles table
	public function GetRoleList(){
		$query = $this->db->get('roles');
		return $query->result();
	}
	//end of function to get roles list from roles table



	//start of function to insert user record in table
	public function createUser(){
		$password = base64_encode($this->input->post('password')); 
		$data = array(
				'role_id' => $this->input->post('roleName'),
				'username' => $this->input->post('userName'),
				'password' => $password,
				'first_name' => $this->input->post('firstName'),
				'last_name' => $this->input->post('lastName'),
				'contact_no' => $this->input->post('contactNumber'),
			);
		return $this->db->insert('users', $data);
	}
	//end of function to insert user record in table

	//strt of function to fetch record from table by id
	public function GetUserInfoById($user_id){
		$query = $this->db->get_where('users', array(
				'user_id' => $user_id,
			));
		$data = $query->result();
		return $data[0];
	}
	//end of function to fetch record from table by id

	//start of function to update user info by id
	public function UpdateUser($user_id){
		$data = array(
				'role_id' => $this->input->post('roleName'),
				'username' => $this->input->post('userName'),
				'first_name' => $this->input->post('firstName'),
				'last_name' => $this->input->post('lastName'),
				'contact_no' => $this->input->post('contactNumber'),
			);
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data);
	}
	//end of function to update user info by id

	//start of function to change active status to 0
	public function DeactivateUser($user_id){
		$data = array(
				'user_is_active' => 0,
			);
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data);
	}
	//end of function to change active status to 0

	//start of function to change active status to 1
	public function ActivateUser($user_id){
		$data = array(
				'user_is_active' => 1,
			);
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data);
	}
	//end of function to change active status to 1

	//start of function to delete record from table by id
	public function DeleteUser($user_id){
		$this->db->where('user_id', $user_id);
		$this->db->delete('users');
	}
	//end of function to delete record from table by id

	//start of function to change password of logged in user
	public function ChangePassword($username){
		$password = base64_encode($this->input->post('password'));
		$data = array(
				'password' => $password,
			);
		$this->db->where('username', $username);
		$this->db->update('users', $data);
	}
	//end of function to change password of logged in user
}