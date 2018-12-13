<?php
class Payment_model extends CI_Model{
	//start of function to fetch records from table
	public function GetPaymentDetails(){
		/*$page = $page-1;

		if ($page<0) {
			$page = 0;
		}

		$from = $page*$perpage;*/

		$this->db->select('*');
		$this->db->from('purchases');
		//$this->db->join('payments', 'purchases.customer_id = payments.customer_id', 'left');
		$this->db->join('customers', 'purchases.customer_id = customers.customer_id', 'left');
		$this->db->group_by('purchases.customer_id');
		//$this->db->limit($perpage, $from);
		$query = $this->db->get();
		//echo "<pre>";print_r($query->result());exit;
		return $query->result();
	}
	//end of function to fetch records from table

	public function GetPaymentDetailsCount(){
		$this->db->select('*');
		$this->db->from('purchases');
		$this->db->join('payments', 'purchases.customer_id = payments.customer_id', 'left');
		$this->db->join('customers', 'payments.customer_id = customers.customer_id', 'left');
		$this->db->group_by('purchases.customer_id');
		$query = $this->db->get()->num_rows();
		return $query;
	}

	public function GetTotalPurchaseAmount($recpt_no){
		
		$this->db->select('*, SUM(purchases.rate) AS TotalPurchaseAmount');
		$this->db->from('purchases');
		$this->db->where('receipt_number', $recpt_no);
		$this->db->group_by('receipt_number');
		$query = $this->db->get();
		//echo"<pre>";print_r($query->result());
		$data = $query->result();
		if(!empty($data)){
			$TotalPurchaseAmount = $data[0]->TotalPurchaseAmount;
			//return $TotalPurchaseAmount;
		}else{
			$TotalPurchaseAmount = '';
			//return '';
		}
		return $TotalPurchaseAmount;
	}

	public function GetTotalPurchaseAmountByCustomerID($cust_id){
		$this->db->select('*, SUM(purchases.rate) AS TotalPurchaseAmount');
		$this->db->from('purchases');
		$this->db->where('customer_id', $cust_id);
		$this->db->group_by('customer_id');
		$query = $this->db->get();
		//echo"<pre>";print_r($query->result());exit;
		$data = $query->result();
		if(!empty($data)){
			$TotalPurchaseAmount = $data[0]->TotalPurchaseAmount;
			//return $TotalPurchaseAmount;
		}else{
			$TotalPurchaseAmount = '';

		}
		//echo "<pre>";print_r($TotalPurchaseAmount);exit;
        return $TotalPurchaseAmount;
	}

	public function  GetTotalPaidAmountByCustomerID($cust_id){
		//echo"<pre>";print_r($recpt_no);
		$this->db->select('*, SUM(transactions.amount) AS TotalPaidAmount');
		$this->db->from('transactions');
		$this->db->where(array(
				'customer_id' => $cust_id,
				//'cheque_status !=' => 1,
                'type' => 'Payment',
			));
		//$this->db->where('customer_id', $cust_id);
		$this->db->group_by('customer_id');
		$query = $this->db->get();
		//echo"<pre>";print_r($query->result());
		$data = $query->result();
		if(!empty($data)){
			$TotalPaidAmount = $data[0]->TotalPaidAmount;
            //echo"<pre>";print_r($TotalPaidAmount);exit;
			//return $TotalPaidAmount;
		}else{
			$TotalPaidAmount = '';
            //echo"<pre>";print_r($TotalPaidAmount);exit;
			//return $TotalPaidAmount;
		}

		return $TotalPaidAmount;
	}

	public function GetPreviousBalanceByCustomerID($cust_id){
	    $this->db->select('*');
	    $this->db->from('transactions');
	    $this->db->where('customer_id', $cust_id);
	    $this->db->order_by('tran_id', 'Desc');
	    $this->db->limit(1);
	    $query = $this->db->get()->row();
	    //echo "<pre>";print_r($query);exit;
		/*$query = $this->db->get_where('payments', array(
				'customer_id' => $cust_id,
			));*/
		//$data = $query->result();
        if(!empty($query)){
            $bal_amount = $query->balance_amount;
        }else{
            $bal_amount = 0;
        }
		return $bal_amount;
		echo"<pre>";print_r($bal_amount);exit;
	}

	public function GetTotalAmountPaid($recpt_no){
		$this->db->select('SUM(payments.amount) AS TotalAmount');
		$this->db->from('payments');
		$this->db->where('receipt_no', $recpt_no);
		$query = $this->db->get();
		$data = $query->result();
		if(!empty($data)){
			return $data[0]->TotalAmount;
		}else{
			return '';
		}
		//echo"<pre>";print_r($query->result());exit;
	}

	public function GetTotalAmountByID($customer_id){
		$this->db->select('*, SUM(purchases.rate) AS TotalPurchaseAmount');
		$this->db->from('purchases');
		$this->db->where('customer_id', $customer_id);
		$query = $this->db->get();
		$data = $query->result();
		//echo "<pre>";print_r($data);exit;
		return $data[0]->TotalPurchaseAmount;
	}

	public function AddPayment(){

		$customer_id = $this->input->post('customer_id');
		$amount = $this->input->post('amount');
        $query = $this->db->get_where('customers', array(
            'customer_id' => $customer_id,
        ))->row();
		//$previous_bal = $this->GetPreviousBalanceByCustomerID($customer_id);
        if(!empty($query->bal_amount) && $query->bal_amount > 0){
            $bal_amt = $query->bal_amount;
            $credit_bal_amount = 0;
        }else if(!empty($query->credit_balance) && $query->credit_balance > 0){
            $bal_amt = 0;
            $credit_bal_amount = $query->credit_balance;
        }else{
            $bal_amt = 0;
            $credit_bal_amount = 0;
        }

        //echo "<pre>";print_r($bal_amt);exit;

		$this->UpdateCustomerDetails($customer_id, $amount);
		$data = array(
				'customer_id' => $this->input->post('customer_id'),
				'receipt_no' => $this->input->post('receipt_no'),
				'amount' => $this->input->post('amount'),
				'date' => $this->input->post('to_date'),
				'amount_paid_date' => $this->input->post('to_date'),
				'payment_mode' => $this->input->post('paymentMode'),
				'bank_name' => $this->input->post('bankName'),
				'branch_name' => $this->input->post('branchName'),
				'cheque_number' => $this->input->post('chequeNumber'),
                'type' => 'Payment',
			);

        $data1 = array(
            'customer_id' => $this->input->post('customer_id'),
            'receipt_number' => $this->input->post('receipt_no'),
            'amount' => $this->input->post('amount'),
            'date' => $this->input->post('to_date'),
            'balance_amount' => $bal_amt,
            'credit_balance_amt' => $credit_bal_amount,
            'transaction_date' => $this->input->post('to_date'),
            'payment_mode' => $this->input->post('paymentMode'),
            'bank_name' => $this->input->post('bankName'),
            'branch_name' => $this->input->post('branchName'),
            'cheque_number' => $this->input->post('chequeNumber'),
            'type' => 'Payment',
        );
        //echo "<pre>";print_r($data1);exit;
		$this->db->insert('payments', $data);
		$this->db->insert('transactions', $data1);
	}

	private function UpdateCustomerDetails($customer_id, $amount){
	    //echo"<pre>";print_r($amount);exit;
		$query = $this->db->get_where('customers', array(
				'customer_id' => $customer_id,
			));
		$data = $query->row();

		if(!empty($data)){
			if(!empty($data->bal_amount)){
				if($data->bal_amount > $amount){
					$new_bal_amount = $data->bal_amount - $amount;
					$data_to_update = array(
						'bal_amount' => $new_bal_amount,
					);
				}else if($data->bal_amount < $amount){
					$new_bal_amount = $amount - $data->bal_amount;
					$data_to_update = array(
						'bal_amount' => 0,
						'credit_balance' => $new_bal_amount,
					);
				}else{
					$data_to_update = array(
						'bal_amount' => 0,
						'credit_balance' => 0,
					);
				}
				
			}else if(!empty($data->credit_balance)){
				if($data->credit_balance > $amount){
					$new_credit_balance = $data->credit_balance - $amount;
					$data_to_update = array(
						'credit_balance' => $new_credit_balance,
					);
				}else if($data->credit_balance < $amount){
					$new_balance_amount = $amount - $data->credit_balance;
					$data_to_update = array(
						'bal_amount' => $new_balance_amount,
						'credit_balance' => 0,
					);
				}else{
					$data_to_update = array(
						'bal_amount' => 0,
						'credit_balance' => 0,
					);
				}
				
			}
		}
		//echo"<pre>";print_r($data_to_update);exit;
		$this->db->where('customer_id', $customer_id);
		$this->db->update('customers', $data_to_update);
		//echo"<pre>";print_r($query->result());exit;
	}

	public function GetPaymentDetailsOfCustomerByCustomerID($cust_id){
		$this->db->select('*');
		$this->db->from('purchases');
		$this->db->join('customers', 'purchases.customer_id = customers.customer_id', 'left');
		$this->db->join('payments', 'purchases.receipt_number = payments.receipt_no', 'left');	
		$this->db->join('products', 'purchases.prod_id = products.product_id', 'left');
		$this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
		$this->db->where(array(
				'purchases.customer_id' => $cust_id,
			));
		//$this->db->group_by('purchases.receipt_number');
		$query = $this->db->get();
		//echo"<pre>";print_r($query->result());exit;
		return $query->result();
	}



	public function GetPaymentDetailsRecordOfCustomerByCustomerID($cust_id){
		$this->db->select('*');
		$this->db->from('payments');
		$this->db->join('customers', 'payments.customer_id = customers.customer_id', 'left');
		$this->db->where(array(
				'payments.customer_id' => $cust_id,
			));
		//$this->db->group_by('purchases.receipt_number');
		$query = $this->db->get();
		//echo"<pre>";print_r($query->result());exit;
		return $query->result();
	}

	public function GetPurchaseDate($receipt_no){
		$this->db->select('*');
		$this->db->from('purchases');
		$this->db->where(array(
				'receipt_number' => $receipt_no,
			));
		$this->db->group_by('receipt_number');
		$query = $this->db->get();
		/*$query = $this->db->get_Where('purchases', array(
				'receipt_number' => $receipt_no,
			));*/
		$data = $query->result();
		if(!empty($data)){
			return $data[0]->purchase_date;
		}else{
			return '';
		}
		
		//echo"<pre>";print_r($query->result());exit;
	}

	public function GetDailyIncome(){
		$date = date('Y-m-d');
		$this->db->select('SUM(payments.amount) AS DailyIncome');
		$this->db->from('payments');
		$this->db->where(array(
				'date' => $date,
			));
		$query = $this->db->get();
		$data = $query->result();
		return $data[0]->DailyIncome ;
		
	}

	public function GetCurrentMonthsIncome(){
		$month = date('m');
		$this->db->select('SUM(payments.amount) AS MonthsTotalIncome');
		$this->db->from('payments');
		$this->db->where('MONTH(date)', $month);
		$query = $this->db->get();
		$data = $query->result();
		return $data[0]->MonthsTotalIncome;
	}

	public function GetTotalPurchasedAmount(){
		$this->db->select('SUM(purchases.rate) AS TotalPurchasedAmount');
		$this->db->from('purchases');
		$query = $this->db->get();
		$data = $query->result();
		return $data[0]->TotalPurchasedAmount;
	}

	public function GetTotalPaidAmount(){
		$this->db->select('SUM(payments.amount) AS TotalPaidAmount');
		$this->db->from('payments');
		$query = $this->db->get();
		$data = $query->result();
		return $data[0]->TotalPaidAmount;
	}

	public function GetMonthsPurchasedAmount(){
		$month = date('m');
		$this->db->select('SUM(purchases.rate) AS TotalMonthsPurchasedAmount');
		$this->db->from('purchases');
		$this->db->where(array(
				'MONTH(purchase_date)' => $month
			));
		$query = $this->db->get();
		$data = $query->result();
		return $data[0]->TotalMonthsPurchasedAmount;
	}

	public function UpdateChequeStatusByPaymentID($payment_id){
		$date = date('Y-m-d');
		$pay_details = $this->db->get_where('payments', array(
		    'payment_id' => $payment_id,
        ))->row();
		$cheque_no = $pay_details->cheque_number;

		$data = array(
				'cheque_status' => 1,
				'cheque_return_date' => $date,
			);
		$this->db->where('payment_id', $payment_id);
		$this->db->update('payments', $data);

        $data1 = array(
            'cheque_status' => 1,
            'cheque_return_date' => $date,
            'type' => 'Cheque Returned',
        );
        $this->db->where('cheque_number', $cheque_no);
        $this->db->update('transactions', $data1);

		$query = $this->db->get_where('payments', array(
				'payment_id' => $payment_id,
			));
		$result = $query->result();
		$customer_id = $result[0]->customer_id;
		$amount = $result[0]->amount;
		$this->UpdateCustomerBalanceByCustomerID($customer_id, $amount);
	}

	private function UpdateCustomerBalanceByCustomerID($customer_id, $amount){
	    //echo "<pre>";print_r($amount);exit;
		$query = $this->db->get_where('customers', array(
				'customer_id' => $customer_id,
			));
		$res = $query->row();
		$balance_amount = $res->bal_amount;
		$credit_balance = $res->credit_balance;
		if(!empty($balance_amount)){
		    if($balance_amount > $amount){
		        $new_bal_amount = $balance_amount + $amount;
                $data_to_update = array(
                    'credit_balance' => '',
                    'bal_amount' => $new_bal_amount,
                );
            }else if($balance_amount < $amount){
		        $new_bal_amount = $amount - $balance_amount;
                $data_to_update = array(
                    'credit_balance' => $new_bal_amount,
                    'bal_amount' => '',
                );
            }

		}else if(!empty($credit_balance)){
		    if($credit_balance > $amount){
		        $amount = $credit_balance - $amount;
		        $data_to_update = array(
		            'credit_balance' => $amount,
                    'bal_amount' => '',
                );
            }else if($credit_balance < $amount){
		        $amount = $amount - $credit_balance;
                $data_to_update = array(
                    'bal_amount' => $amount,
                    'credit_balance' => '',
                );
            }else{

                $data_to_update = array(
                    'bal_amount' => '',
                    'credit_balance' => '',
                );
            }
        }else {
            $data_to_update = array(
                'credit_balance' => '',
                'bal_amount' => $amount,
            );
        }
        //echo "<pre>";print_r($data_to_update);exit;
		$this->db->where('customer_id', $customer_id);
		$this->db->update('customers', $data_to_update);
	}
	
	public function DeletePaymentDetailsByID($payment_id){
		$this->db->select('*');
		$this->db->from('payments');
		$this->db->join('customers', 'payments.customer_id = customers.customer_id', 'left');
		$this->db->where('payment_id', $payment_id);
		$query = $this->db->get();
		$data = $query->result();
		if(!empty($data)){
			$amt = $data[0]->amount;
			$old_bal_amt = $data[0]->bal_amount;
			$old_cr_bal = $data[0]->credit_balance;
		}
		
		if(!empty($old_bal_amt)){
			$new_bal_amt = $old_bal_amt + $amt;
			$data_to_update = array(
					'bal_amount' => $new_bal_amt,
			);
			$this->db->where('customer_id', $data[0]->customer_id);
			$this->db->update('customers', $data_to_update);
		}
		$this->db->where('payment_id', $payment_id);
		$this->db->delete('payments');

        $this->db->where('tran_id', $payment_id);
        $this->db->delete('transactions');
        echo"<pre>";print_r($this->db->last_query());exit;
	}
}