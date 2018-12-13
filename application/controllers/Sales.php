<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Sales
 * @property Customer_model $customer
 * @property Category_model $Category
 * @property Product_model $Product
 * @property Sales_model $Sales
 * @property Report_model $Report
 */

class Sales extends CI_Controller {
	 public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model', 'Customer');
        $this->load->model('Category_model', 'Category');
        $this->load->model('Product_model', 'Product');
        $this->load->model('Sales_model', 'Sales');
        $this->load->model('Report_model', 'Report');
        if(!empty($this->session->userdata['username'])){
            $this->load->view('common/header');
        }else{
            redirect('users/login');
        }
    }

    //start of function to display list of all customers
    public function SalesList(){
    	$this->form_validation->set_rules('from_date', 'From Date', 'trim|required');
    	$this->form_validation->set_rules('to_date', 'To Date', 'trim|required');
    	if ($this->form_validation->run() === FALSE){
	        $data['sales'] = $this->Sales->GetListOfAllSalesDone();
	        $this->load->view('sales/list', $data);
	        $this->load->view('common/footer');
    	}else{
    		$data['sales'] = $this->Sales->GetListOfAllSalesDoneFromToDate();
    		$this->load->view('sales/list', $data);
    		$this->load->view('common/footer');
    	}
    }
    //end of function to display list of all customers
    
    //start of function to display list of all sales with from and to date
    public function SalesReport(){
    	$this->form_validation->set_rules('from_date', 'From Date', 'trim|required');
    	$this->form_validation->set_rules('to_date', 'To Date', 'trim|required');
    	if ($this->form_validation->run() === FALSE){
    	$data['sales'] = $this->Sales->GetListOfAllSalesDoneFromToDate();
    	$this->load->view('sales/list', $data);
    	$this->load->view('common/footer');
    	}
    }
    //end of fucntion to display list of all sales with from and to date

    //start of function to create customer
    public function SalesCreate(){
        $this->form_validation->set_rules('customerName', 'Customer Name', 'trim|required');
        $data['customers'] = $this->Customer->GetListOfAllCustomers();
        $data['categories'] = $this->Category->GetAllActiveCategories(); 
        $receipt = $this->Sales->GetLastReceiptNo();
        $receipt_no = $receipt + 1;
        //print_r($receipt);exit;
        $data['receipt_no'] = $receipt_no;
        $data['record'] = $this->Sales->GetTotalAmount();
        if ($this->form_validation->run() === FALSE){
            $this->load->view('sales/add', $data);
            $this->load->view('common/footer');
        }
        else{

            $bal_amt = $this->input->post('balanceAmount');
           
           // $adv_amt = $this->input->post('advanceAmount');
            //echo"<pre>";print_r($adv_amt);exit;
            if($bal_amt != 0){//print_r('here');exit;
                $amt = '';
                $adv_amt = $this->input->post('totalAmount');
                $advance_amt = $adv_amt; 
            }else{//print_r('there');exit;
                $amt = $bal_amt;
                $adv_amt = $this->input->post('advanceAmount');
                $advance_amt = $adv_amt; 
            }
            //echo"<pre>";print_r($advance_amt);exit;

            $this->Sales->UpdateCreditBalanceAmount();
            
            foreach($this->input->post('categoryName') as $key => $value):
                $category_name = $value;
                $product_name = $this->input->post('productName')[$key];
                $product_quantity = $this->input->post('productQuantity')[$key];
                $product_rate = $this->input->post('productRate')[$key];
                $this->Sales->AddProductToCustomerPurchase($category_name, $product_name, $product_quantity, $product_rate);
            endforeach;
            $this->Sales->AddTransactionDetails();
            $this->Sales->AddPaymentDetailsOfPurchase($amt, $advance_amt);
            $this->session->set_flashdata('message', 'Record inserted successfully.');
            redirect('sales');
        }
    }
    //end of function to create customer

    //start of function to update customer info
    public function CustomerUpdate($cust_id){
        $this->form_validation->set_rules('customerName', 'Customer Name', 'trim|required');
        $this->form_validation->set_rules('customerContactNo', 'Contact Number', 'trim|required');
        $data['customer_info'] = $this->Customer->GetCustomerInfoByID($cust_id);
        if ($this->form_validation->run() === FALSE){
            $this->load->view('customers/edit', $data);
            $this->load->view('common/footer');
        }
        else{
            $this->Customer->UpdateCustomer($cust_id);
            $this->session->set_flashdata('message', 'Customer updated successfully.');
            redirect('customers');
        }
    }
    //end of function to update customer info

    //start of function to delete customer
    public function CustomerDelete(){
        $cust_id = $_REQUEST['cust_id'];
        $this->Customer->DeleteCustomer($cust_id);
    }
    //end of function to delete customer

    public function CreateSaleToCustomer(){
        $this->Sales->AddProductToCustomer();
    }

    public function ViewPurchaseDetail($receipt_no){
        $data['order_details'] = $this->Sales->GetPurchaseDetailByReceiptNo($receipt_no);
        //echo"<pre>";print_r($data['order_details']);exit;
        $cust_id = $data['order_details'][0]->customer_id;
        $data['total_paid'] = $this->Sales->GetTotalAmountPaidByReceiptNo($receipt_no);
        $total_amount_paid = $data['total_paid']->amount;
        $previous_balance = $data['total_paid']->previous_balance;
       // echo"<pre>";print_r($previous_balance);exit;
        $total_amount = $this->Report->GetTotalAmountForAjaxCall($cust_id);
        
        $total_paid = $this->Report->GetTotalAmountPaidForAjaxCall($cust_id);
        $data['total_paid'] = $total_amount_paid;
        $amtdetails = $this->Sales->GetAmountDetailsByReceiptNo($receipt_no);
        //echo"<pre>";print_r($amtdetails);exit;
        if(!empty($amtdetails->bal_amount)){
            $data['previous_bal'] = $amtdetails->previous_balance;
            $data['prev_credit_balance'] = $amtdetails->previous_credit_balance; 
        }else{
            $data['previous_bal'] = $amtdetails->previous_balance;
            $data['prev_credit_balance'] = $amtdetails->previous_credit_balance; 
        }
        $this->load->view('customers/order-details',$data);
        $this->load->view('common/footer');
    }

    public function AddNewRow(){
        $cnt = $_REQUEST['count']; 
        $categories = $this->Category->GetAllActiveCategories();
        echo"<div class='col-sm-12'><div class='form-group'><div class='col-lg-2'><div class='form-group'><select required='' name='categoryName[]' class='form-control ' id = category-".$cnt."><option vlaue=''>Please Select</option>";
        foreach($categories as $category):
            echo"<option value =".$category->category_id.">".$category->category_name."</option>";
        endforeach;
        echo"</select></div></div>";
        echo"<div class='col-lg-2'><select name='productName[]' class='form-control' id = product-".$cnt."><option value=''>Please Select</option></select></div>";
        echo"<div class='col-lg-2'><input type='text' name='productQuantity[]' class='form-control quantity' id='quantity-".$cnt."'></div>";
        /*echo"<div class='col-lg-2'><input type='text' name='ratePerItem[]' class='form-control ratePerItem' id='ratePerItem-".$cnt."'></div>";*/
        echo"<div class='col-lg-2'><input type='text' name='productRate[]' placeholder='Rate' class='form-control rate' id='rate-".$cnt."'></div>";

        echo"</div></div>";exit;
    }

    public function GetAllProductsByCatID(){
        $cat_id = $_REQUEST['cat_id'];
        $products = $this->Product->GetProductsByCategoryID($cat_id);
        echo"<option value=''>Please Select</option>";
        foreach($products as $product):
            echo"<option value='$product->product_id'>$product->product_name</option>";
        endforeach;exit;
    }

    //Start of function to update sales info
    public function SalesUpdate($receipt_no){
        $this->form_validation->set_rules('customerName', 'Customer Name', 'trim|required');//
        $this->form_validation->set_rules('advanceAmount', 'Advance', 'trim|required');
        $data['receipt_no'] = $receipt_no;
        $data['details'] = $this->Sales->GetPurchaseDetailByReceiptNo($receipt_no);
        $data['customers'] = $this->Customer->GetListOfAllCustomers();
        $data['categories'] = $this->Category->GetAllActiveCategories();
        $data['products'] = $this->Category->GetAllActiveProducts(); 
        $data['record'] = $this->Sales->GetTotalAmount($receipt_no);
        $data['advanceamount'] = $this->Sales->GetTotalAmountPaidByReceiptNo($receipt_no);
        $data['purchase_records'] = $this->Sales->GetAllPurchaseRecordsByReceiptNo($receipt_no);
        if ($this->form_validation->run() === FALSE){
            $this->load->view('sales/edit', $data);
            $this->load->view('common/footer');
        }
        else{
            foreach($this->input->post('categoryName') as $key => $value):
                $category_name = $value;
                $product_name = $this->input->post('productName')[$key];
                $product_quantity = $this->input->post('productQuantity')[$key];
                $product_rate = $this->input->post('productRate')[$key];
                $this->Sales->UpdateProductToCustomerPurchase($category_name, $product_name, $product_quantity, $product_rate);
            endforeach;
            $this->Sales->UpdatePaymentDetailsOfPurchase();
            $this->session->set_flashdata('message', 'Customer created successfully.');
            redirect('sales');
        }
    }
    //End of function to update sales info

    public function GetCreditBalanceAmount(){
        $cust_id = $_REQUEST['cust_id'];
        $balance = $this->Report->GetCreditBalanceAmountByUserID($cust_id);
        if(!empty($balance)){
            $creditBalance = $balance;
            echo $creditBalance;exit;
        }else{
            $total_amount = $this->Report->GetTotalAmountForAjaxCall($cust_id);

            $total_paid = $this->Report->GetTotalAmountPaidForAjaxCall($cust_id);

            if($total_amount < $total_paid){//echo"<pre>";print_r('here');exit;
                $creditBalance = $total_amount - $total_paid;    
                echo $creditBalance;exit;
            }else{//echo"<pre>";print_r('there');exit;
                $creditBalance = $total_paid - $total_amount;    
                echo $creditBalance;exit;
            }
        }exit;
        
        
        
    }

    public function SalesDelete(){
        $recpt_no = $_REQUEST['recpt_no'];
        //echo"<pre>";print_r($recpt_no);exit;
        $this->Sales->DeleteSalesByReceiptNo($recpt_no);
    }
}
