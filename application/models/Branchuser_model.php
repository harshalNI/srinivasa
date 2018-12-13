<?php
class Branchuser_model extends CI_Model{
	//start of function to fetch all records from table
	public function GetAdminUsersByBranch($branch_id){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('branches', 'users.user_branch_id = branches.branch_id', 'left');
		$this->db->join('roles', 'users.role_id = roles.role_id', 'left');
		$this->db->where(array(
				'user_branch_id' => $branch_id,
			));
		$query = $this->db->get();
		return $query->result();
	}
	//end of function to fetch all records from table

	//start of function to insert record in table
	public function CareteBranchUser(){
		$password = base64_encode($this->input->post('password')); 
		$data = array(
				'role_id' => $this->input->post('roleName'),
				'user_branch_id' => $this->input->post('branchName'),
				'username' => $this->input->post('userName'),
				'password' => $password,
				'first_name' => $this->input->post('firstName'),
				'last_name' => $this->input->post('lastName'),
				'contact_no' => $this->input->post('contactNumber'),
			);
		return $this->db->insert('users', $data);
	}
	//end of function to insert record in table

	//start of function to update record in table
	public function UpdateBranchUser($user_id){
		$data = array(
				'role_id' => $this->input->post('roleName'),
				'user_branch_id' => $this->input->post('branchName'),
				'username' => $this->input->post('userName'),
				'first_name' => $this->input->post('firstName'),
				'last_name' => $this->input->post('lastName'),
				'contact_no' => $this->input->post('contactNumber'),
			);
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data);
	}
	//end of function to update record in table
}