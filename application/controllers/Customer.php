<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Customer
 * @property customer_model $Customer
 * @property paymet_model $Payment
 * @property sales_model $Sales
 */

class Customer extends CI_Controller {
	 public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_model', 'Customer');
        $this->load->model('sales_model','Sales');
        $this->load->model('report_model','Report');
        if(!empty($this->session->userdata['username'])){
            $this->load->view('common/header');
        }else{
            redirect('users/login');
        }
    }

    //start of function to display list of all customers
    public function CustomerList(){
        $data['customers'] = $this->Customer->GetListOfAllCustomers();
        $this->load->view('customers/list', $data);
        $this->load->view('common/footer');
    }
    //end of function to display list of all customers

    //start of function to create customer
    public function CustomerCreate(){
        $this->form_validation->set_rules('customerName', 'Customer Name', 'trim|required');
        $this->form_validation->set_rules('customerContactNo', 'Contact Number', 'trim|required');
        if ($this->form_validation->run() === FALSE){
            $this->load->view('customers/add');
            $this->load->view('common/footer');
        }
        else{
            $this->Customer->CareteCustomer();
            $this->session->set_flashdata('message', 'Customer created successfully.');
            redirect('customers');
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
        $this->Sales->DeletePurchaseInfoOfCustomer($cust_id);
        $this->Sales->DeletePaymentInfoOfCustomer($cust_id);
        $this->Sales->DeleteTrandactionInfoOfCustomer($cust_id);
        $this->Customer->DeleteCustomer($cust_id);
    }
    //end of function to delete customer

    public function printInvoice($recpt_no){
        $data['order_details'] = $this->Sales->GetPurchaseDetailByReceiptNo($recpt_no);
        //echo"<pre>";print_r($data['order_details']);exit;
        $cust_id = $data['order_details'][0]->customer_id;
        $data['total_paid'] = $this->Sales->GetTotalAmountPaidByReceiptNo($recpt_no);
        $total_amount_paid = $data['total_paid']->amount;
        $previous_balance = $data['total_paid']->previous_balance;
       // echo"<pre>";print_r($previous_balance);exit;
        $total_amount = $this->Report->GetTotalAmountForAjaxCall($cust_id);
        
        $total_paid = $this->Report->GetTotalAmountPaidForAjaxCall($cust_id);
        $data['total_paid'] = $total_amount_paid;
        $amtdetails = $this->Sales->GetAmountDetailsByReceiptNo($recpt_no);
        //echo"<pre>";print_r($amtdetails);exit;
        if($amtdetails->TotalPreviousBalance != 0){
            $data['previous_bal'] = $amtdetails->previous_balance;
            $data['prev_credit_balance'] = $amtdetails->previous_credit_balance; 
        }else{
            $data['previous_bal'] = $amtdetails->previous_balance;
            $data['prev_credit_balance'] = $amtdetails->previous_credit_balance; 
        }
       /* $data['order_details'] = $this->Sales->GetPurchaseDetailByReceiptNo($recpt_no);
        $cust_id = $data['order_details'][0]->customer_id;
        $data['total_paid'] = $this->Sales->GetTotalAmountPaidByReceiptNo($recpt_no);
        $total_amount = $this->Report->GetTotalAmountForAjaxCall($cust_id);
        $total_paid = $this->Report->GetTotalAmountPaidForAjaxCall($cust_id);
        if($total_amount < $total_paid){
            $data['creditamount'] = $total_paid - $total_amount;
        }*/
        $this->load->view('customers/print-invoice',$data);
        $this->load->view('common/footer');
    }
}
