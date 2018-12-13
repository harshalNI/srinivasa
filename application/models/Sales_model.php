<?php
class Sales_model extends CI_Model{
	//start of function to fetch records from table
	public function GetListOfAllSalesDone(){
		$date = date('Y-m-d');
		//print_r($date);exit;
		$this->db->select('*, SUM(purchases.rate) AS TotalAmount');
		$this->db->from('purchases');
		$this->db->join('products', 'purchases.prod_id = products.product_id', 'left');
		$this->db->join('customers', 'purchases.customer_id = customers.customer_id', 'left');
		$this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
		//$this->db->join('payments', 'payments.receipt_no = purchases.receipt_number', 'left');
		$this->db->group_by('purchases.receipt_number');
		$this->db->where('purchases.purchase_date', $date);
		$query = $this->db->get();
		//echo"<pre>";print_r($query->result());exit;
		return $query->result();
	}
	//end of function to fetch records from table

	//start of function to fetch record from table within from and to date
	public function GetListOfAllSalesDoneFromToDate(){
		$start_date = $this->input->post('from_date');
		$end_date = $this->input->post('to_date');
		$this->db->select('*, SUM(purchases.rate) AS TotalAmount');
		$this->db->from('purchases');
		$this->db->join('products', 'purchases.prod_id = products.product_id', 'left');
		$this->db->join('customers', 'purchases.customer_id = customers.customer_id', 'left');
		$this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
		$this->db->where('purchases.date BETWEEN "'. date('Y-m-d H:i:s', strtotime($start_date)). '" and "'. date('Y-m-d H:i:s', strtotime($end_date)).'"');
		$this->db->group_by('purchases.receipt_number');
		/*  $this->db->where(array(
				'purchases.date >=' => $start_date,
				'purchases.date <=' => $end_date,
		)); */
		$query = $this->db->get();
		//echo"<pre>";print_r($this->db->last_query());exit;
		return $query->result();
	}
	//end of function to fetch record from table within from and to date

	//start of function to insert record in table
	public function CareteSales(){
		$data = array(
				'customer_name' => $this->input->post('customerName'),
				'customer_contactno' => $this->input->post('customerContactNo'),
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

	public function GetLastReceiptNo(){
		$this->db->select('receipt_number');
		$this->db->from('purchases');
		$this->db->group_by('receipt_number');
		$this->db->order_by('purchase_id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();
		$data = $query->result();
		//echo"<pre>";print_r($data);exit;
		if(!empty($data)){
			$number = $data[0]->receipt_number;
			//echo"<pre>";print_r($number);exit;
			//$var = explode('-', $number);
			return $number;
		}else{
			return 0;
		}
	}

	public function GetTotalAmount($receipt_no = null){
		$this->db->select('*, SUM(purchases.rate) AS TotalAmount');
		$this->db->from('purchases');
		$this->db->where('receipt_number', $receipt_no);
		$query = $this->db->get();
		$data = $query->result();
		return $data[0];
	}

	public function AddProductToCustomer(){
		$data = array(
				'customer_id' => $this->input->post('customerName'),
				'receipt_number' => $this->input->post('recpt_no'),
				'category_id' => $this->input->post('categoryName'),
				'prod_id' => $this->input->post('productName'),
				'quantity' => $this->input->post('productQuantity'),
				'rate' => $this->input->post('productRate'),
			);
		return $this->db->insert('purchases_tmp', $data);
	}

	private function GetCategoryNameByCatID($cat){
	    $query = $this->db->get_where('categories', array(
	        'category_id' => $cat,
        ))->row();
	    return $query->category_name;
    }

	public function UpdateCreditBalanceAmount(){
        $category_name = $this->input->post('categoryName');
        $cat = $category_name[0];
        $cat_name = $this->GetCategoryNameByCatID($cat);

		$cust_id = $this->input->post('customerName');
		$check_bal = $this->CheckBalance($cust_id);
		//echo"<pre>";print_r($check_bal);exit;

		$exp_amt = explode('-',$check_bal);

		if($exp_amt[0] == 'Credit'){

			$total_amount = $this->input->post('totalAmount');
			$credit_balance = $this->input->post('creditBalance');
			if($total_amount > $credit_balance){//echo"<pre>";print_r($this->input->post());exit;
				$balanceAmount = $total_amount - $credit_balance;

				$data_to_update = array(
						'bal_amount' => $balanceAmount,
						'credit_balance' => '',
					);

			}else if($total_amount < $credit_balance){//echo"<pre>";print_r('credit balance is more');exit;
				$creditBalance = $credit_balance - $total_amount;
				//echo"<pre>";print_r($creditBalance);exit;
				$data_to_update = array(
						'credit_balance' => $creditBalance,
					);
			}else{
				$data_to_update = array(
						'credit_balance' => '',
						'bal_amount' => '',
					);
			}

		}else{
            //echo"<pre>";print_r($this->input->post());exit;
			$total_amount = $this->input->post('totalAmount');
			$balance_amount = $this->input->post('balanceAmount');
			$old_balance_amt = $this->input->post('balanceAmountOld');
			$advanceAmount = $this->input->post('advanceAmount');
            $category_name = $this->input->post('categoryName');
            $cat = $category_name[0];
            $cat_name = $this->GetCategoryNameByCatID($cat);
			if($cat_name != 'Cheque'){
                if ($balance_amount > $total_amount) {
                    //echo"<pre>";print_r($this->input->post());exit;
                    $balanceAmount = $this->input->post('balanceAmount');
                    $new_amount = $balanceAmount + $total_amount;
                    $data_to_update = array(
                        'bal_amount' => $new_amount,
                    );
                    //echo"<pre>";print_r($data_to_update);exit;
                } else if ($balance_amount < $total_amount) {
                    //echo"<pre>";print_r($this->input->post());exit;
                    $totalpuramt = $total_amount + $old_balance_amt;
                    if ($advanceAmount < $totalpuramt) {
                        $balanceAmount = $totalpuramt - $advanceAmount;
                        $data_to_update = array(
                            'credit_balance' => '',
                            'bal_amount' => $balanceAmount,
                        );
                    } else if ($advanceAmount > $totalpuramt) {
                        $creditAmount = $advanceAmount - $totalpuramt;
                        $data_to_update = array(
                            'credit_balance' => $creditAmount,
                            'bal_amount' => '',
                        );
                    } else {
                        $data_to_update = array(
                            'credit_balance' => '',
                            'bal_amount' => '',
                        );
                    }

                } else {
                    $data_to_update = array(
                        'credit_balance' => '',
                        'bal_amount' => '',
                    );
                }
            }else{
			    $balanceAmount = $this->input->post('balanceAmount');
			    $total_amount = $this->input->post('totalAmount');
                    $new_amount = $balanceAmount + $total_amount;
			        $data_to_update = array(
			        'credit_balance' => '',
                    'bal_amount' => $new_amount,
                );


			}


		}
		//echo"<pre>";print_r($data_to_update);exit;
		$this->db->where('customer_id', $cust_id);
		$this->db->update('customers', $data_to_update);
	}

	public function AddProductToCustomerPurchase($category_name, $product_name, $product_quantity, $product_rate){

		$purchase_date = $this->input->post('purchaseDate');
		if(!empty($purchase_date)){
			$data = array(
				'customer_id' => $this->input->post('customerName'),
				'receipt_number' => $this->input->post('recpt_no'),
				'category_id' => $category_name,
				'prod_id' => $product_name,
				'quantity' => $product_quantity,
				'rate' => $product_rate,
				'balance_amount' => $this->input->post('balanceAmount'),
				'work_site' => $this->input->post('workSite'),
				'vehicle_no' => $this->input->post('vehicleNumber'),
				'purchase_date' => $purchase_date,
				'date' => $purchase_date,
			);
		}else{
			$data = array(
				'customer_id' => $this->input->post('customerName'),
				'receipt_number' => $this->input->post('recpt_no'),
				'category_id' => $category_name,
				'prod_id' => $product_name,
				'quantity' => $product_quantity,
				'rate' => $product_rate,
				'balance_amount' => $this->input->post('balanceAmount'),
				'work_site' => $this->input->post('workSite'),
				'vehicle_no' => $this->input->post('vehicleNumber'),
				'date' => date('Y-m-d H:i:s'),
				'purchase_date' => date('Y-m-d H:i:s'),
			);

		}

		//echo "<pre>";print_r($data1);exit;
        $this->db->insert('purchases', $data);
	}

	private function AddPaymentDetailsRecord($advance){
        $customer_id = $this->input->post('customerName');
        //$this->UpdateCustomerDetails($customer_id, $amount);
        $purchase_date = $this->input->post('purchaseDate');
        $pre_bal_amount = $this->input->post('balanceAmount');
        $total_bal_amount = $pre_bal_amount + $advance;
        if(!empty($purchase_date)){
            $data = array(
                'customer_id' => $customer_id,
                'receipt_number' => $this->input->post('recpt_no'),
                'amount' => $advance,
                'balance_amount' => $this->input->post('balanceAmount'),
                'transaction_date' => $purchase_date,
                'date' => $purchase_date,
                'payment_mode' => $this->input->post('paymentMode'),
                'bank_name' => $this->input->post('bankName'),
                'branch_name' => $this->input->post('branchName'),
                'cheque_number' => $this->input->post('chequeNumber'),
                'type' => 'Payment',
            );
        }else{
            $data = array(
                'customer_id' => $this->input->post('customerName'),
                'receipt_number' => $this->input->post('recpt_no'),
                'amount' => $advance,
                'balance_amount' => $this->input->post('balanceAmount'),
                'date' => date('Y-m-d H:i:s'),
                'transaction_date' => date('Y-m-d H:i:s'),
                'payment_mode' => $this->input->post('paymentMode'),
                'bank_name' => $this->input->post('bankName'),
                'branch_name' => $this->input->post('branchName'),
                'cheque_number' => $this->input->post('chequeNumber'),
                'type' => 'Payment',
            );
        }
        $this->db->insert('transactions', $data);
        //echo"<pre>";print_r($this->db->last_query());exit;
    }

    public function AddTransactionDetails(){

	    $categories = $this->input->post('categoryName');
	    $products = $this->input->post('productName');
	    $quantities = $this->input->post('productQuantity');
	    $old_bal = $this->input->post('balanceAmountOld');
	    $new_pur_amount = $this->input->post('totalAmount');
	    if($old_bal != 0 && $old_bal > $new_pur_amount){
	        $new_bal_amount = $old_bal + $new_pur_amount;
	        $new_credit_amount = '';
        }elseif ($old_bal != 0 && $old_bal < $new_pur_amount){
	        $new_credit_amount = $new_pur_amount - $old_bal;
	        $new_bal_amount = '';
        }elseif ($old_bal == 0){
            $new_bal_amount = $old_bal + $new_pur_amount;
            $new_credit_amount = '';
        }else{
            $new_bal_amount = '';
            $new_credit_amount = '';
        }

	    $cat_name = '';
	    $product = '';
	    $prod_quantity = '';
	    foreach($categories as $key => $cat):
            $cat_name = $cat_name.','.$cat;
        endforeach;
        foreach($products as $key1 => $prod):
            $product = $product.','.$prod;
        endforeach;
        foreach($quantities as $key2 => $quantity):
            $prod_quantity = $prod_quantity.','.$quantity;
        endforeach;
        $cats = ltrim($cat_name, ',');
        $prods = ltrim($product, ',');
        $qty = ltrim($prod_quantity, ',');
        $purchase_date = $this->input->post('purchaseDate');
        if(!empty($purchase_date)){
            $data1 = array(
                'customer_id' => $this->input->post('customerName'),
                'receipt_number' => $this->input->post('recpt_no'),
                'category_id' => $cats,
                'prod_id' => $prods,
                'quantity' => $qty,
                'amount' => $this->input->post('totalAmount'),
                'balance_amount' => $new_bal_amount,
                'credit_balance_amt' => $new_credit_amount,
                'work_site' => $this->input->post('workSite'),
                'vehicle_no' => $this->input->post('vehicleNumber'),
                'transaction_date' => $purchase_date,
                'date' => $purchase_date,
                'bank_name' => $this->input->post('bankName'),
                'branch_name' => $this->input->post('branchName'),
                'cheque_number' => $this->input->post('chequeNumber'),
                'type' => 'Sales',
            );
        }else{
            $data1 = array(
                'customer_id' => $this->input->post('customerName'),
                'receipt_number' => $this->input->post('recpt_no'),
                'category_id' => $cats,
                'prod_id' => $prods,
                'quantity' => $qty,
                'amount' => $this->input->post('totalAmount'),
                'balance_amount' => $new_bal_amount,
                'credit_balance_amt' => $new_credit_amount,
                'work_site' => $this->input->post('workSite'),
                'vehicle_no' => $this->input->post('vehicleNumber'),
                'date' => date('Y-m-d H:i:s'),
                'transaction_date' => date('Y-m-d H:i:s'),
                'bank_name' => $this->input->post('bankName'),
                'branch_name' => $this->input->post('branchName'),
                'cheque_number' => $this->input->post('chequeNumber'),
                'type' => 'Sales',
            );
        }

        //echo "<pre>";print_r($data1);exit;
        //$this->db->insert('purchases', $data);

        $this->db->insert('transactions', $data1);
        //echo "<pre>";print_r($this->db->last_query());exit;
        $advance = $this->input->post('advanceAmount');
        if(!empty($advance)){
            $this->AddPaymentDetailsRecord($advance);
        }
    }

	private function CheckBalance($cust_id){
		$query = $this->db->get_where('customers', array(
				'customer_id' => $cust_id,
			));
		$data = $query->result();
		//echo "<pre>";print_r($data);exit;

		if(empty($data[0]->bal_amount) || $data[0]->bal_amount == 0){
			$credit_balance = "Credit-".$data[0]->credit_balance;
			return $credit_balance;
		}else{
			$balance = "Balance-".$data[0]->bal_amount;
			return $balance;
		}
	}

	private function ChangePreviousChequeStatus($customer_id){
	    $cheque_number = $this->input->post('chequeNumber');
	    $data = array(
	        'cheque_status' => 1,
        );
	    $this->db->where(array(
	        'cheque_number' => $cheque_number,
            'customer_id' => $customer_id,
            'type' => 'Payment',
            'payment_mode' => 'cheque'
        ));
	    $this->db->update('payments', $data);

        /*$cheque_number = $this->input->post('chequeNumber');
        $data = array(
            'cheque_status' => 1,
        );
        $this->db->where(array(
            'cheque_number' => $cheque_number,
            'customer_id' => $customer_id,
            'type' => 'Payment',
            'payment_mode' => 'cheque'
        ));
        $this->db->update('transactions', $data);*/
    }

	public function AddPaymentDetailsOfPurchase($amt, $advance_amt){
	    //echo "<pre>";print_r($this->input->post());exit;
        $customer_id = $this->input->post('customerName');
        $this->ChangePreviousChequeStatus($customer_id);
        //echo "<pre>";print_r('Changed');exit;
	    $old_bal = $this->input->post('balanceAmountOld');
	    $new_pur_amount = $this->input->post('totalAmount');
	    if($old_bal != 0 && $old_bal > $new_pur_amount){
	        $new_bal_amount = $old_bal + $new_pur_amount;
	        $new_credit_amount = '';
        }elseif ($old_bal != 0 && $old_bal < $new_pur_amount){
	        $new_bal_amount = '';
	        $new_credit_amount = $new_pur_amount - $old_bal;
        }else{

        }
	if($advance_amt > 0){
		$amount_paid_date = date('Y-m-d H:i:s');
	}else{
		$amount_paid_date = 'NULL';
	}
		 $array = array(
	     		'customer_id' => $this->input->post('customerName'),
				'receipt_no' => $this->input->post('recpt_no'),
				'amount' => $advance_amt,
				'previous_balance' => $new_bal_amount,
				'previous_credit_balance' => $new_credit_amount,
				'payment_mode' => $this->input->post('paymentMode'),
				'bank_name' => $this->input->post('bankName'),
				'branch_name' => $this->input->post('branchName'),
				'cheque_number' => $this->input->post('chequeNumber'),
				'amount_paid_date' => $amount_paid_date,
	     	);
	     return $this->db->insert('payments', $array);
	}

	public function GetPurchaseDetailByReceiptNo($receipt_no){
		$this->db->select('*');
		$this->db->from('purchases');
		$this->db->join('products', 'purchases.prod_id = products.product_id', 'left');
		$this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
		$this->db->join('customers', 'purchases.customer_id = customers.customer_id', 'left');
		$this->db->where(array(
				'purchases.receipt_number' => $receipt_no,
			));
		$query = $this->db->get();
		return $query->result();
	}

	public function GetAmountDetailsByReceiptNo($recpt_no){
		$this->db->select('*, SUM(payments.previous_balance) AS TotalPreviousBalance');
		$this->db->from('payments');
		$this->db->join('customers', 'payments.customer_id = customers.customer_id', 'left');
		$this->db->where(array(
				'payments.receipt_no' => $recpt_no,
			));
		//$this->db->group_by('payments.receipt_no');
		$query = $this->db->get();
		$data = $query->result();
		//echo"<pre>";print_r($data[0]);exit;
		return $data[0];
	}

	public function GetTotalAmountPaidByReceiptNo($receipt_no){
		$this->db->select('*');
		$this->db->from('payments');
		$this->db->where(array(
				'receipt_no' => $receipt_no,
			));
		$query = $this->db->get();
		$data = $query->result();
		if(!empty($data)){
			return $data[0];
		}else{
			return '';
		}

	}

	public function GetAllPurchaseRecordsByReceiptNo($receipt_no){
		$data = $this->db->get_where('purchases', array(
				'receipt_number' => $receipt_no,
			));
		return $data->result();
	}

	public function DeleteSalesByReceiptNo($recpt_no){
		$this->UpdateBalanceAmountAfterRecordDelete($recpt_no);
		$this->DeletePaymentDetails($recpt_no);
		$this->DeleteTransactionDetailsByRecptNo($recpt_no);
		$this->db->where('receipt_number', $recpt_no);
		$this->db->delete('purchases');
	}

	private function DeleteTransactionDetailsByRecptNo($recpt_no){
	    $this->db->where('receipt_number', $recpt_no);
	    $this->db->delete('transactions');
    }

	private function DeletePaymentDetails($recpt_no){
		$this->db->where('receipt_no', $recpt_no);
		$this->db->delete('payments');
	}

	private function UpdateBalanceAmountAfterRecordDelete($recpt_no){
		$this->db->select('SUM(purchases.rate) AS TotalAmount');
		$this->db->from('purchases');
		$this->db->where(array(
				'receipt_number' => $recpt_no,
			));
		$query = $this->db->get();
		$data = $query->result();

		$purchase_amount = $data[0]->TotalAmount;
        echo "<pre>";print_r($purchase_amount);
		$this->db->select('*, SUM(payments.amount) AS TotalAmountPaid');
		$this->db->from('payments');
		$this->db->where(array(
				'receipt_no' => $recpt_no,
			));
		$query1 = $this->db->get();
		$data1 = $query1->result();
		$paid_amount = $data1[0]->TotalAmountPaid;

        $cust_id = $data1[0]->customer_id;

        $details = $this->db->get_where('customers', array(
            'customer_id' => $cust_id,
        ));
        $data2 = $details->result();
        $oldbal = $data2[0]->bal_amount;

		$amount_to_deduct = $oldbal - $purchase_amount;

        if(!empty($data2[0]->bal_amount)){
            $old_bal_amt = $data2[0]->bal_amount;
            $new_bal_amt = $old_bal_amt - $purchase_amount;
            $data_to_update = array(
                'bal_amount' => $new_bal_amt,
                'credit_balance' => '',
            );

        }elseif(!empty($data2[0]->credit_balance)){
            $old_credit_amt = $data2[0]->credit_balance;
            $new_credit_amt = $old_credit_amt + $purchase_amount;
            $data_to_update = array(
                'credit_balance' => $new_credit_amt,
                'bal_amount' => '',
            );

        }
        //echo"<pre>";print_r($data_to_update);exit;

		$this->db->where('customer_id', $cust_id);
		$this->db->update('customers', $data_to_update);
		//$this->db->select();
		//echo"<pre>";print_r($new_bal_amt);exit;
	}

	public function DeletePurchaseInfoOfCustomer($cust_id){
        $this->db->where('customer_id', $cust_id);
        $this->db->delete('purchases');
    }

    public function DeletePaymentInfoOfCustomer($cust_id){
        $this->db->where('customer_id', $cust_id);
        $this->db->delete('payments');
    }

    public function DeleteTrandactionInfoOfCustomer($cust_id){
        $this->db->where('customer_id', $cust_id);
        $this->db->delete('transactions');
    }
}