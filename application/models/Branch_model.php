<?php
class Branch_model extends CI_Model{
	//start of function to fetch all records from table
	public function GetAllBranches(){
		$query = $this->db->get('branches');
		return $query->result();
	}
	//end of function to fetch all records from table

	//start of function to insert record in table
	public function CareteBranch(){
		$data = array(
				'branch_name' => $this->input->post('branchName'),
			);
		return $this->db->insert('branches', $data);
	}
	//end of function to insert record in table

	//start of function get branch details by id
	public function GetBranchDetailsById($branch_id){
		$query = $this->db->get_where('branches', array(
				'branch_id' => $branch_id,
			));
		$data = $query->result();
		return $data[0];
	}
	//end of function to get branch details by id

	//start of function to update record in table by id
	public function UpdateBranch($branch_id){
		$data = array(
				'branch_name' => $this->input->post('branchName'),
			);
		$this->db->where('branch_id', $branch_id);
		$this->db->update('branches', $data);
	}
	//end of function to update record in table by id

	//start of function to change active status to 0
	public function DeactivateBranch($branch_id){
		$data = array(
				'branch_is_active' => 0,
			);
		$this->db->where('branch_id', $branch_id);
		$this->db->update('branches', $data);
	}
	//end of function to change active status to 0

	//start of function to change active status to 1
	public function ActivateBranch($branch_id){
		$data = array(
				'branch_is_active' => 1,
			);
		$this->db->where('branch_id', $branch_id);
		$this->db->update('branches', $data);
	}
	//end of function to change active status to 1

	//start of function to delete record from table by id
	public function DeleteBranch($branch_id){
		$this->db->where('branch_id', $branch_id);
		$this->db->delete('branches');
	}
	//end of function to delete record from table by id

	//start of function to fetch all active records from table
	public function GetAllActiveBranches(){
		$query = $this->db->get_where('branches', array(
				'branch_is_active' => 1,
			));
		return $query->result();
	}
	//end of function to fetch all active records from table
}