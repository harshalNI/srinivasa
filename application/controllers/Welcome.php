<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		//echo"<pre>";print_r($this->session->userdata);exit;
		if(!empty($this->session->userdata['username'])){
			$this->load->model('payment_model', 'Payment');
			$this->load->model('customer_model', 'Customer');
			$this->load->model('category_model', 'Category');
			$this->load->model('product_model', 'Product');
			//$this->load->model('purchase_model', 'Purchase');
			$data['monthly_income'] = $this->Payment->GetCurrentMonthsIncome();
			$total_purchased_amount = $this->Payment->GetTotalPurchasedAmount();
			$total_paid_amount = $this->Payment->GetTotalPaidAmount();
			$data['total_outstanding'] = $total_paid_amount - $total_purchased_amount;
			//echo "<pre>";print_r($data['total_outstanding']);exit;

			$months_purchased_amount = $this->Payment->GetMonthsPurchasedAmount();
			$months_paid_amount = $this->Payment->GetCurrentMonthsIncome();
			$data['current_months_outstanding'] = $months_paid_amount - $months_purchased_amount;
			
			$data['total_customer'] = $this->Customer->GetTotalCustomer();

			//echo"<pre>";print_r($data['available_steel_stock']);exit;
			$this->load->view('common/header');
			$this->load->view('dashboard', $data);
			$this->load->view('common/footer');
		}else{
			redirect('users/login');
		}
	}
}
