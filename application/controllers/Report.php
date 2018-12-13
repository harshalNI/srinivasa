<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Report
 * @property Report_model $Report
 * @property Customer_model $Customer
 */

class Report extends CI_Controller {
	 public function __construct()
    {
        parent::__construct();
        $this->load->model('report_model', 'Report');
        $this->load->model('customer_model', 'Customer');
        if(!empty($this->session->userdata['username'])){
            $this->load->view('common/header');
        }else{
            redirect('users/login');
        }
    }

    public function GenerateReport(){
        $this->form_validation->set_rules('customerName', 'Customer Name', 'trim|required');
        $data['customers'] = $this->Customer->GetListOfAllCustomers();
        if ($this->form_validation->run() === FALSE){
            $this->load->view('report/generate', $data);
            $this->load->view('common/footer');
        }else{
            $customer_id = $this->input->post('customerName');
            $data['customers'] = $this->Customer->GetListOfAllCustomers();
            $data['total_amount'] = $this->Report->GetTotalAmount();
            //echo"<pre>";print_r($data['total_amount']);
            $data['total_paid'] = $this->Report->GetTotalAmountPaid();
            //echo"<pre>";print_r($data['total_paid']);exit;
            $data['previous_balance'] = $this->Report->GetDetailsForPreviousBalance();
            /*if(!empty($data['previous_balance'][0]->bal_amount)){
                $data['balance_amount'] = 'Balance-'.$data['previous_balance'][0]->bal_amount;
            }elseif(!empty($data['previous_balance'][0]->credit_balance)){
                $data['balance_amount'] = 'Credit-'.$data['previous_balance'][0]->credit_balance;
            }else{
                $data['balance_amount'] = 'NoBal-0';
            }*/

            $data['records'] = $this->Report->GetDetailsNew();
            if(!empty($data['previous_balance']) && !empty($data['previous_balance'][0]->balance_amount)){
                $opening_bal = $data['previous_balance'][0]->balance_amount;
                //$op_bal = $opening_bal - $data['total_amount'];
            }else{
                $opening_bal = 0;
                //$op_bal = 0;
            }
            if(!empty($data['records'][0]->bal_amount)){
                $data['balance_amount'] = 'Balance-'.$data['records'][0]->bal_amount;
            }elseif(!empty($data['previous_balance'][0]->credit_balance)){
                $data['balance_amount'] = 'Credit-'.$data['records'][0]->credit_balance;
            }else{
                $data['balance_amount'] = 'NoBal-0';
            }
            $data['opening_bal'] = $opening_bal;
            //echo"<pre>";print_r($data['opening_bal']);exit;
            $this->load->view('report/generate', $data);
            $this->load->view('common/footer');
        }
    }

    public function printReport($customer, $from_date, $to_date){
        $data['customers'] = $this->Customer->GetListOfAllCustomers();
        $data['total_amount'] = $this->Report->GetTotalAmount($customer);
        $data['total_paid'] = $this->Report->GetTotalAmountPaid($customer);
        $data['previous_balance'] = $this->Report->GetDetailsForPreviousBalanceToPrint($customer);
        $data['previous_balance'] = $this->Report->GetDetailsForPreviousBalance($customer);
        if(!empty($data['previous_balance'][0]->bal_amount)){
            $data['balance_amount'] = 'Balance-'.$data['previous_balance'][0]->bal_amount;
        }elseif(!empty($data['previous_balance'][0]->credit_balance)){
            $data['balance_amount'] = 'Credit-'.$data['previous_balance'][0]->credit_balance;
        }
       // echo "<pre>";print_r($data['balance_amount']);exit;
        $data['records'] = $this->Report->GetDetailsNewToPrint($customer, $from_date, $to_date);
        if(!empty($data['previous_balance'])){
                $opening_bal = $data['previous_balance'][0]->balance_amount;
            }else{
                $opening_bal = 0;
            }
            $data['opening_bal'] = $opening_bal;
        $this->load->view('report/print-report', $data);
        //$this->load->view('common/footer');
    }
}
