<?php
class Product_model extends CI_Model{
	//start of function to fetch records from table
	public function GetListOfAllProducts(){
		$this->db->select('*, SUM(purchases.quantity) AS TotalQuantitySold');
		$this->db->from('products');
		$this->db->join('categories', 'products.cat_id = categories.category_id', 'left');
		$this->db->join('purchases', 'products.product_id = purchases.prod_id', 'left');
		$this->db->group_by('products.product_name');
		$query = $this->db->get();
		//echo"<pre>";print_r($query->result());exit;
		return $query->result();
	}
	//end of function to fetch records from table

	public function GetCountOfPurchasedStockByProductID($prod_name){
		$this->db->select('SUM(products.product_quantity) AS TotalQuantityPurchased');
		$this->db->from('products');
		$this->db->where(array(
				'product_name' => $prod_name,
			));
		$this->db->group_by('product_name');
		$query = $this->db->get();
		$data = $query->result();
		if(!empty($data)){
			return $data[0]->TotalQuantityPurchased;	
		}else{
			return '';
		}
		
	}

	//start of function to insert record in table
	public function CareteProduct(){
		$data = array(
				'cat_id' => $this->input->post('categoryName'),
				'product_name' => $this->input->post('productName'),
				'product_quantity' => $this->input->post('productQuantity'),
				'product_measure' => $this->input->post('productMeasure'),
			);
		return $this->db->insert('products', $data);
	}
	//end of function to insert record in table

	//start of function to fetch record from table by id
	public function GetProductInfoByID($prod_id){
		$query = $this->db->get_where('products', array(
				'product_id' => $prod_id
			));
		$data = $query->result();
		return $data[0];
	}
	//end of function to fetch record from table by id

	//start of function to update record in table by id
	public function UpdateProduct($prod_id){
		$data = array(
				'cat_id' => $this->input->post('categoryName'),
				'product_name' => $this->input->post('productName'),
				'product_quantity' => $this->input->post('productQuantity'),
				'product_measure' => $this->input->post('productMeasure'),
			);
		$this->db->where('product_id', $prod_id);
		$this->db->update('products', $data);
	}
	//end of function to update record in table by id

	//start of function to change the active status to 0
	public function DeactivateProduct($prod_id){
		$data = array(
				'product_is_active' => 0,
			);
		$this->db->where('product_id', $prod_id);
		$this->db->update('products', $data);
	}
	//end of function to change the active status to 0

	//start of function to change the active status to 1
	public function ActivateProduct($prod_id){
		$data = array(
				'product_is_active' => 1,
			);
		$this->db->where('product_id' , $prod_id);
		$this->db->update('products', $data);
	}
	//end of function to change the active status to 1

	//start of function to delete the record from table
	public function DeleteProduct($prod_id){
		$this->db->where('product_id', $prod_id);
		$this->db->delete('products');
	}
	//end of function to delete the record from table

	public function GetProductsByCategoryID($cat_id){
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where(array(
				'product_is_active' => 1,
				'cat_id' => $cat_id
			));
		$this->db->group_by('product_name');
		$query = $this->db->get();
		return $query->result();
	}

	public function GetTotalQuantityOfSoldSteel($prod_name){
		$query = $this->db->get_where('categories', array(
				'category_name' => $prod_name,
			));
		$data = $query->result();
		$category_id = $data[0]->category_id;

		$total_sold = $this->GetTotalSales($category_id);
		return $total_sold;
	}

	private function GetTotalSales($category_id){
		$this->db->select('SUM(purchases.quantity) AS TotalQuantitySold');
		$this->db->from('purchases');
		$this->db->where(array(
				'category_id' => $category_id,
			));
		$query = $this->db->get();
		$data = $query->result();
		if(!empty($data)){
			return $data[0]->TotalQuantitySold;	
		}else{
			return '';
		}
		
		//echo"<pre>";print_r($query->result());exit;
	}

	public function GetTotalStockPurchasedForCememtByProductID($product_id){
		$this->db->select('SUM(products.product_quantity) AS TotalQuantityPurchased');
		$this->db->from('products');
		$this->db->where(array(
				'product_id' => $product_id,
			));
		$query = $this->db->get();
		$data = $query->result();
		//echo"<pre>";print_r($data);exit;
		if(!empty($data)){
			return $data[0]->TotalQuantityPurchased;	
		}else{
			return '';
		}
	}

	public function GetTotalStockSoldForCememtByProductID($product_id){
		$this->db->select('SUM(purchases.quantity) AS TotalQuantitySold');
		$this->db->from('purchases');
		$this->db->where(array(
				'prod_id' => $product_id,
			));
		$query = $this->db->get();
		$data = $query->result();
		//echo"<pre>";print_r($data);exit;
		if(!empty($data)){
			return $data[0]->TotalQuantitySold;	
		}else{
			return '';
		}
	}

	public function GetCategoryIdByCategoryName($prod_name1){
		$query = $this->db->get_where('categories', array(
				'category_name' => $prod_name1,
			));
		$data = $query->result();
		//echo "<pre>";print_r($data);exit;
		if(!empty($data)){
			return $data[0]->category_id;	
		}else{
			return '';
		}
		
		//echo"<pre>";print_r($query->result());exit;
	}

	public function GetAllProductsByCategoryID($category_id){
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where(array(
				'cat_id' => $category_id,
			));
		$this->db->group_by('product_name');
		$query = $this->db->get();
		return $query->result();
	}
}