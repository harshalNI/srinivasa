<?php
class Customer_model extends CI_Model{
	//start of function to fetch records from table
	public function GetListOfAllCustomers(){
		$this->db->select('*');
		$this->db->from('customers');
		//$this->db->join('categories', 'products.cat_id = categories.category_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	//end of function to fetch records from table

	//start of function to insert record in table
	public function CareteCustomer(){
		$data = array(
				'customer_name' => $this->input->post('customerName'),
				'customer_contactno' => $this->input->post('customerContactNo'),
				'bal_amount' => $this->input->post('customerCreditBalance'),
			);
		return $this->db->insert('customers', $data);
	}
	//end of function to insert record in table

	//start of function to fetch record from table by id
	public function GetCustomerInfoByID($cust_id){
		$query = $this->db->get_where('customers', array(
				'customer_id' => $cust_id
			));
		$data = $query->result();
		return $data[0];
	}
	//end of function to fetch record from table by id

	//start of function to update record in table by id
	public function UpdateCustomer($cust_id){
		$data = array(
				'customer_name' => $this->input->post('customerName'),
				'customer_contactno' => $this->input->post('customerContactNo'),
				'bal_amount' => $this->input->post('customerCreditBalance'),
			);
		$this->db->where('customer_id', $cust_id);
		$this->db->update('customers', $data);
	}
	//end of function to update record in table by id

	//start of function to delete the record from table
	public function DeleteCustomer($cust_id){
		$this->db->where('customer_id', $cust_id);
		$this->db->delete('customers');
	}
	//end of function to delete the record from table

	public function GetTotalCustomer(){
		$query = $this->db
        ->select('count(customers.customer_id) as TotalCustomers')
        ->from('customers')
        ->get();
        $data = $query->result();
        return $data[0]->TotalCustomers;
	}
}