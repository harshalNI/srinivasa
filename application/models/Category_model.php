<?php
class Category_model extends CI_Model{
	//start of function to fetch all records from table
	public function GetAllCategories(){
		$query = $this->db->get('categories');
		return $query->result();
	}
	//end of function to fetch all records from table

	//start of function to insert record in table
	public function CareteCategory(){
		$data = array(
				'category_name' => $this->input->post('categoryName'),
			);
		return $this->db->insert('categories', $data);
	}
	//end of function to insert record in table

	//start of function get category details by id
	public function GetCategoryDetailsById($cat_id){
		$query = $this->db->get_where('categories', array(
				'category_id' => $cat_id,
			));
		$data = $query->result();
		return $data[0];
	}
	//end of function to get category details by id

	public function GetAllActiveProducts(){
		$query = $this->db->get_where('products', array(
				'product_is_active' => 1,
			));
		return $query->result();
	}

	//start of function to update record in table by id
	public function UpdateCategory($cat_id){
		$data = array(
				'category_name' => $this->input->post('categoryName'),
			);
		$this->db->where('category_id', $cat_id);
		$this->db->update('categories', $data);
	}
	//end of function to update record in table by id

	//start of function to change active status to 0
	public function DeactivateCategory($cat_id){
		$data = array(
				'category_is_active' => 0,
			);
		$this->db->where('category_id', $cat_id);
		$this->db->update('categories', $data);
	}
	//end of function to change active status to 0

	//start of function to change active status to 1
	public function ActivateCategory($cat_id){
		$data = array(
				'category_is_active' => 1,
			);
		$this->db->where('category_id', $cat_id);
		$this->db->update('categories', $data);
	}
	//end of function to change active status to 1

	//start of function to delete record from table by id
	public function DeleteCategory($cat_id){
		$this->db->where('category_id', $cat_id);
		$this->db->delete('categories');
	}
	//end of function to delete record from table by id

	//start of function to fetch all active records from table
	public function GetAllActiveCategories(){
		$query = $this->db->get_where('categories', array(
				'category_is_active' => 1,
			));
		return $query->result();
	}
	//end of function to fetch all active records from table

	public function GetTotalSalesByCategoryID($cat_id){
		$this->db->select('SUM(rate) AS TotalSales');
		$this->db->from('purchases');
		$this->db->where(array(
				'category_id' => $cat_id,
			));
		$query = $this->db->get();
		$data = $query->result();
		return $data[0]->TotalSales;
	}

	
}