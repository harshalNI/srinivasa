<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Payment
 * @property Payment_model $Payment
 * @property Customer_model $Customer
 * @property Product_model $Product
 * @property Report_model $Report
 */

class Payment extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('customer_model', 'Customer');
        $this->load->model('category_model', 'Category');
        $this->load->model('product_model', 'Product');
        $this->load->model('payment_model', 'Payment');
        $this->load->model('report_model', 'Report');
        if(!empty($this->session->userdata['username'])){
            $this->load->view('common/header');
        }else{
            redirect('users/login');
        }
    }

    //Start of function to get list of Customer Payments
    public function PaymentDetails(){
        //$data["payments_details"] = $this->Payment->GetPaymentDetails();
        $purchase_details = $this->Payment->GetPaymentDetails();
        foreach ($purchase_details as $details):
            //$previous_bal = $this->Report->GetDetailsForPreviousBalanceOfCustomer($details->customer_id);
            $total_amount = $this->Payment->GetTotalPurchaseAmountByCustomerID($details->customer_id);
            if(!empty($details->balance_amount)){
                $pre_bal = $details->balance_amount;
            }else{
                $pre_bal = 0;
            }

            //$total_purchased_amount = $total_amount + $pre_bal;
            //echo "<pre>";print_r($details);
            $tpa = $total_amount + $pre_bal;
            //echo "<pre>";print_r($tpa);
            if(!empty($tpa)){
                $total_purchased_amount = $tpa;
            }else{
                $total_purchased_amount = 0;
            }
            //$total_paid_amount = $this->Payment->GetTotalPaidAmountByCustomerID($customer_id);

            $previous_balance = $this->Report->GetDetailsForPreviousBalanceOfCustomer($details->customer_id);

            //echo"<pre>";print_r($payments);
            if(!empty($previous_balance->bal_amount)){
                $balance_amount = 'Balance-'.$details->balance_amount;
            }elseif(!empty($details->credit_balance)){
                $balance_amount = 'Credit-'.$previous_balance->credit_balance;
            }else{
                $balance_amount = 'NoBal-0';
            }

            $total_paid_amt = $this->Report->GetTotalAmountPaidForAjaxCall($details->customer_id);

            $exp = explode('-',$balance_amount);

            /*if(isset($exp[0]) && $exp[0] == 'Balance'){
                $total_paid_amount = $total_purchased_amount - $exp[1];
            }else{
                $total_paid_amount = $exp[1] - $total_purchased_amount;
            }*/
            /*if($total_paid_amt < $total_purchased_amount){
                $total_paid_amount = $total_paid_amt;
            }*/

            $TotalPaidAmount = $total_paid_amt;
            setlocale(LC_MONETARY,"en_IN.UTF-8");
            $TotalPurchasedAmount = $total_purchased_amount;


           if($TotalPurchasedAmount > $TotalPaidAmount){
            $bal_amount_new = $TotalPurchasedAmount - $TotalPaidAmount;
            $cre_amount_new = '';
           }else{
            $bal_amount_new = '';
            $cre_amount_new = $TotalPaidAmount - $TotalPurchasedAmount;
           }
            $data_new[] = (object) array(
                'purchase_id' => $details->purchase_id,
                'customer_id' => $details->customer_id,
                'receipt_number' => $details->receipt_number,
                'category_id' => $details->category_id,
                'prod_id' => $details->prod_id,
                'quantity' => $details->quantity,
                'rate' => $details->rate,
                'advance_amount' => $details->advance_amount,
                'balance_amount' => $bal_amount_new,
                'work_site' => $details->work_site,
                'vehicle_no' => $details->vehicle_no,
                'purchase_date' => $details->purchase_date,
                'date' => $details->date,
                'customer_name' => $details->customer_name,
                'customer_contactno' => $details->customer_contactno,
                'bal_amount' => $bal_amount_new,
                'credit_balance' => $cre_amount_new,
                'total_purchase_amount' => $TotalPurchasedAmount,
                'total_amount_paid' => $TotalPaidAmount,
                //'previous_balance' => $this->Report->GetDetailsForPreviousBalanceOfCustomer($details->customer_id),
            );
        endforeach;
        if(!empty($data_new)){
            $data['payments_details'] = $data_new;
        }else{
            $data['payments_details'] = array();
        }

        /*$cust_id = $data['payments_details'][0]->customer_id;
        $data['previous_balance'] = $this->Report->GetDetailsForPreviousBalance($cust_id);
        if(!empty($data['payments_details'][0]->bal_amount)){
            $data['balance_amount'] = 'Balance-'.$data['previous_balance'][0]->bal_amount;
        }elseif(!empty($data['payments_details'][0]->credit_balance)){
            $data['balance_amount'] = 'Credit-'.$data['previous_balance'][0]->credit_balance;
        }*/
        $this->load->view('payment/list', $data);
        $this->load->view('common/footer');
    }
    //End of function to get list of Customer Payments

    public function GetPaymentDetailsByCustomerID($customer_id){
    }

    //Start of function to view payment details of Customers
    public function ViewCustomerPaymentDetails(){
        $this->form_validation->set_rules('customerName', 'Customer Name', 'trim|required');
        $data['customers'] = $this->Customer->GetListOfAllCustomers();
        if ($this->form_validation->run() === FALSE){
            $this->load->view('payment/add', $data);
            $this->load->view('common/footer');
        }else{
            $customer_id = $this->input->post('customerName');
            $data1['customers'] = $this->Customer->GetListOfAllCustomers();
            $data1['total_amount'] = $this->Report->GetTotalAmount();
            $data1['total_paid'] = $this->Report->GetTotalAmountPaid();
            $data1['records'] = $this->Report->GetPaymentDetails();
            $this->load->view('payment/add', $data1);
            $this->load->view('common/footer');
        }
    }
    //End of function to view payment details of Customers

    //Start of function to add payment of customer
    public function AddPaymentOfCustomer(){
        $this->Payment->AddPayment();
        $this->session->set_flashdata('message', 'Payment added successfully.');
        redirect('payments');
    }
    //End of function to add payment of customer

    public function ViewPaymentofCustomer($cust_id){
        $data['payment_details'] = $this->Payment->GetPaymentDetailsRecordOfCustomerByCustomerID($cust_id);

        //$data['payment_details'] = $this->Payment->GetPaymentDetailsOfCustomerByCustomerID($cust_id);
        $total_amount = $this->Report->GetTotalAmountForAjaxCall($cust_id);
        $data['total_paid'] = $this->Report->GetTotalAmountPaidForAjaxCall($cust_id);
        $data['previous_balance'] = $this->Report->GetDetailsForPreviousBalance($cust_id);
        //echo"<pre>";print_r($data['previous_balance']);exit;
        $data['records'] = $this->Report->GetDetailsNew();
        if(!empty($data['previous_balance']) && !empty($data['previous_balance'][0]->balance_amount)){
            $opening_bal = $data['previous_balance'][0]->balance_amount;
            //$op_bal = $opening_bal - $data['total_amount'];
        }else{
            $opening_bal = 0;
            //$op_bal = 0;
        }
        $data['opening_bal'] = $opening_bal;
        $data['total_amount'] = $total_amount + $opening_bal;
        //echo"<pre>";print_r($data['total_amount']);exit;
        $this->load->view('payment/view-details', $data);
        $this->load->view('common/footer');
    }

    public function ReturnChequeForPayment(){
        $payment_id = $_REQUEST['payment_id'];
        $this->Payment->UpdateChequeStatusByPaymentID($payment_id);
    }
    
    public function DeletePaymentDetails(){
    	$payment_id = $_REQUEST['payment_id'];
    	$this->Payment->DeletePaymentDetailsByID($payment_id);
    }
}
