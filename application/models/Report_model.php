<?php
class Report_model extends CI_Model{
	public function GetOpeningBalance($customer_id){
		$start_date = date('Y-m-d', strtotime($this->input->post('from_date')));
		$end_date = date('Y-m-d', strtotime($this->input->post('to_date')));
		$this->db->select('*');
		$this->db->from('purchases');
		$this->db->join('customers', 'purchases.customer_id = customers.customer_id', 'left');
		$this->db->join('payments', 'purchases.receipt_number = payments.receipt_no', 'left');	
		$this->db->join('products', 'purchases.prod_id = products.product_id', 'left');
		$this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
		$this->db->where(array(
				'purchases.customer_id' => $customer_id,
				'purchases.date >=' => $start_date,
				'purchases.date <=' => $end_date,
			));
		$this->db->order_by('purchases.purchase_id', 'asc');
		$this->db->group_by('purchases.rate');
		$query = $this->db->get();
		$data = $query->result();
		return $data[0]->previous_balance;
	}

	public function GetDetailsForPreviousBalance($cust_id = null){
		$start_date = date('Y-m-d', strtotime($this->input->post('from_date')));
		$end_date = date('Y-m-d', strtotime($this->input->post('to_date')));
		if(!empty($cust_id)){
		    $customer_id = $cust_id;
        }else{
            $customer_id = $this->input->post('customerName');
        }

		$this->db->select('*');
		$this->db->from('purchases');
		$this->db->join('customers', 'purchases.customer_id = customers.customer_id', 'left');
		$this->db->join('payments', 'purchases.receipt_number = payments.receipt_no', 'left');	
		$this->db->join('products', 'purchases.prod_id = products.product_id', 'left');
		$this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
		$this->db->where(array(
				'purchases.customer_id' => $customer_id,
				/* 'purchases.date >=' => $start_date,
				'purchases.date <=' => $end_date, */
			));
		$this->db->order_by('purchases.purchase_id', 'asc');
		//$this->db->group_by('purchases.rate');
		$query = $this->db->get();
		//echo"<pre>";print_r($query->result());exit;
		return $query->result();
	}

	public function GetDetailsForPreviousBalanceOfCustomer($cust_id = null){
        $this->db->select('*');
        $this->db->from('purchases');
        $this->db->join('customers', 'purchases.customer_id = customers.customer_id', 'left');
        $this->db->join('payments', 'purchases.receipt_number = payments.receipt_no', 'left');
        $this->db->join('products', 'purchases.prod_id = products.product_id', 'left');
        $this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
        $this->db->where(array(
            'purchases.customer_id' => $cust_id,
            /* 'purchases.date >=' => $start_date,
            'purchases.date <=' => $end_date, */
        ));
        $this->db->order_by('purchases.purchase_id', 'asc');
        //$this->db->group_by('purchases.rate');
        $query = $this->db->get();
        return $query->row();
    }

	public function GetDetailsForPreviousBalanceToPrint($customer){
		$this->db->select('*');
		$this->db->from('purchases');
		$this->db->join('customers', 'purchases.customer_id = customers.customer_id', 'left');
		$this->db->join('payments', 'purchases.receipt_number = payments.receipt_no', 'left');	
		$this->db->join('products', 'purchases.prod_id = products.product_id', 'left');
		$this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
		$this->db->where(array(
				'purchases.customer_id' => $customer,
			));
		$this->db->order_by('purchases.purchase_id', 'asc');
		//$this->db->group_by('purchases.rate');
		$query = $this->db->get();
		return $query->result();
	}

	public function GetDetails(){
		//echo"<pre>";print_r($this->input->post());exit;
		$start_date = date('Y-m-d', strtotime($this->input->post('from_date')));
		$end_date = date('Y-m-d', strtotime($this->input->post('to_date')));
		$customer_id = $this->input->post('customerName');
		$this->db->select('*');
		$this->db->from('purchases');
		$this->db->join('customers', 'purchases.customer_id = customers.customer_id', 'left');
		$this->db->join('payments', 'purchases.receipt_number = payments.receipt_no', 'left');	
		$this->db->join('products', 'purchases.prod_id = products.product_id', 'left');
		$this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
		$this->db->where(array(
				'purchases.customer_id' => $customer_id,
				'purchases.date >=' => $start_date,
				'purchases.date <=' => $end_date,
			));
		$this->db->order_by('purchases.purchase_id', 'asc');
		//$this->db->group_by('purchases.rate');
		$query = $this->db->get();
		$purchase_details = $query->result();
		

		$this->db->select('*');
		$this->db->from('payments');
		$this->db->join('customers', 'payments.customer_id = customers.customer_id', 'left');
		$this->db->where(array(
				'payments.customer_id' => $customer_id,
			));
		//$this->db->group_by('purchases.receipt_number');
		$query1 = $this->db->get();
		//echo"<pre>";print_r($query->result());exit;
		$payment_details = $query1->result();
		
		$records = array_merge($purchase_details, $payment_details);

		if(!empty($records)){
		foreach($records as $key => $row):
			$orderByDate[$key] = strtotime($row->date);
		endforeach;
		/*foreach ($records as $key => $row) {
		    $orderByDate[$key]  = strtotime($row['date']);
		}*/

		array_multisort($orderByDate, SORT_ASC, $records);
		//echo"<pre>";print_r($records);exit;
		//$a = ksort($records);
		//echo"<pre>";print_r($records);exit;
		return $records;
		}
		//echo"<pre>";print_r($records);exit;
		//
	}

    public function GetDetailsNew(){
        //echo"<pre>";print_r($this->input->post());exit;
        $start_date = date('Y-m-d', strtotime($this->input->post('from_date')));
        $end_date = date('Y-m-d', strtotime($this->input->post('to_date')));
        $customer_id = $this->input->post('customerName');
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->join('customers', 'transactions.customer_id = customers.customer_id', 'left');
        //$this->db->join('payments', 'purchases.receipt_number = payments.receipt_no', 'left');
        //$this->db->join('products', 'purchases.prod_id = products.product_id', 'left');
        //$this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
        $this->db->where(array(
            'transactions.customer_id' => $customer_id,
            'transactions.date >=' => $start_date,
            'transactions.date <=' => $end_date,
        ));
        $this->db->order_by('transactions.date', 'asc');
        //$this->db->group_by('purchases.rate');
        $query = $this->db->get();
        $purchase_details = $query->result();
        //echo "<pre>";print_r($purchase_details);exit;
        foreach ($purchase_details as $details):
            //echo "<pre>";print_r($details);exit;
            $data[] = array(
                'tran_id' => $details->tran_id,
                'customer_id' => $details->customer_id,
                'receipt_number' => $details->receipt_number,
                'amount' => $details->amount,
                'purchase_details' => $this->GetPurchaseDetails($details->category_id, $details->type, $details->receipt_number),
                'balance_amount' => $details->balance_amount,
                'credit_balance_amt' => $details->credit_balance_amt,
                'work_site' => $details->work_site,
                'vehicle_no' => $details->vehicle_no,
                'transaction_date' => $details->transaction_date,
                'payment_mode' => $details->payment_mode,
                'bank_name' => $details->bank_name,
                'branch_name' => $details->branch_name,
                'cheque_number' => $details->cheque_number,
                'cheque_status' => $details->cheque_status,
                'cheque_return_date' => $details->cheque_return_date,
                'type' => $details->type,
                'date' => $details->date,
                'customer_name' => $details->customer_name,
                'customer_contactno' => $details->customer_contactno,
                'bal_amount' => $details->bal_amount,
                'credit_balance' => $details->credit_balance,
            );
        endforeach;
        //echo "<pre>";print_r($data);exit;
        if(!empty($data)){
            return $data;
        }

    }

    private function GetPurchaseDetails($categories, $type, $recpt_no){

        if($type == 'Sales'){
            $exp_categories = explode(',', $categories);
            $start_date = date('Y-m-d', strtotime($this->input->post('from_date')));
            $end_date = date('Y-m-d', strtotime($this->input->post('to_date')));
            $customer_id = $this->input->post('customerName');
            foreach($exp_categories as $cat):
                $this->db->select('*');
                $this->db->from('purchases');
                $this->db->join('products', 'purchases.prod_id = products.product_id', 'left');
                $this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
                $this->db->where(array(
                    'purchases.customer_id' => $customer_id,
                    'purchases.date >=' => $start_date,
                    'purchases.date <=' => $end_date,
                    'purchases.category_id' => $cat,
                    'purchases.receipt_number' => $recpt_no,
                ));
                $this->db->order_by('purchases.purchase_id', 'asc');
                //$this->db->group_by('purchases.rate');
                $query = $this->db->get();
                $purchase_details[] = $query->result();
            endforeach;

            foreach ($purchase_details as $details):
                $data1[] = (object)array(
                    'purchase_id' => $details[0]->purchase_id,
                    'customer_id' => $details[0]->customer_id,
                    'receipt_number' => $details[0]->receipt_number,
                    'category_id' => $details[0]->category_id,
                    'prod_id' => $details[0]->prod_id,
                    'quantity' => $details[0]->quantity,
                    'rate' => $details[0]->rate,
                    'advance_amount' => $details[0]->advance_amount,
                    'balance_amount' => $details[0]->balance_amount,
                    'product_name' => $details[0]->product_name,
                    'product_measure' => $details[0]->product_measure,
                    'category_name' => $details[0]->category_name,
                );
            endforeach;
            if(!empty($data1)){

                return $data1;
            }
        }
    }

    private function GetPurchaseDetailsToPrint($categories, $type, $recpt_no, $customer, $from_date, $to_date){
        if($type == 'Sales'){
            $exp_categories = explode(',', $categories);

            foreach($exp_categories as $cat):
                $this->db->select('*');
                $this->db->from('purchases');
                $this->db->join('products', 'purchases.prod_id = products.product_id', 'left');
                $this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
                $this->db->where(array(
                    'purchases.customer_id' => $customer,
                    'purchases.date >=' => $from_date,
                    'purchases.date <=' => $to_date,
                    'purchases.category_id' => $cat,
                    'purchases.receipt_number' => $recpt_no,
                ));
                $this->db->order_by('purchases.purchase_id', 'asc');
                //$this->db->group_by('purchases.rate');
                $query = $this->db->get();
                $purchase_details[] = $query->result();
            endforeach;

            foreach ($purchase_details as $details):
                $data1[] = (object)array(
                    'purchase_id' => $details[0]->purchase_id,
                    'customer_id' => $details[0]->customer_id,
                    'receipt_number' => $details[0]->receipt_number,
                    'category_id' => $details[0]->category_id,
                    'prod_id' => $details[0]->prod_id,
                    'quantity' => $details[0]->quantity,
                    'rate' => $details[0]->rate,
                    'advance_amount' => $details[0]->advance_amount,
                    'balance_amount' => $details[0]->balance_amount,
                    'product_name' => $details[0]->product_name,
                    'product_measure' => $details[0]->product_measure,
                    'category_name' => $details[0]->category_name,
                );
            endforeach;
            if(!empty($data1)){

                return $data1;
            }
        }
    }

	public function GetPaidDate($recpt_no){
		$this->db->select('*');
		$this->db->from('payments');
		$this->db->where(array(
				'receipt_no' => $recpt_no,
			));
		$this->db->group_by('receipt_no');
		$query = $this->db->get();
		$data = $query->result();
		if(!empty($data)){
			return $data[0]->amount_paid_date;
		}else{
			return '';
		}
		//echo"<pre>";print_r($query->result());exit;
	}

    public function GetDetailsNewToPrint($customer, $from_date, $to_date){
        //$start_date = date('Y-m-d', strtotime($from_date));
        //$end_date = date('Y-m-d', strtotime($to_date));
        //$customer_id = $this->input->post('customerName');
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->join('customers', 'transactions.customer_id = customers.customer_id', 'left');
        //$this->db->join('payments', 'purchases.receipt_number = payments.receipt_no', 'left');
        //$this->db->join('products', 'purchases.prod_id = products.product_id', 'left');
        //$this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
        $this->db->where(array(
            'transactions.customer_id' => $customer,
            'transactions.date >=' => $from_date,
            'transactions.date <=' => $to_date,
        ));
        $this->db->order_by('transactions.date', 'asc');
        //$this->db->group_by('purchases.rate');
        $query = $this->db->get();
        $purchase_details = $query->result();
        //echo "<pre>";print_r($purchase_details);exit;
        foreach ($purchase_details as $details)://echo "<pre>";print_r($details);exit;
            //echo "<pre>";print_r($details);exit;
            $data[] = array(
                'tran_id' => $details->tran_id,
                'customer_id' => $details->customer_id,
                'receipt_number' => $details->receipt_number,
                'amount' => $details->amount,
                'purchase_details' => $this->GetPurchaseDetailsToPrint($details->category_id, $details->type, $details->receipt_number, $customer, $from_date, $to_date),
                'balance_amount' => $details->balance_amount,
                'credit_balance_amt' => $details->credit_balance_amt,
                'work_site' => $details->work_site,
                'vehicle_no' => $details->vehicle_no,
                'transaction_date' => $details->transaction_date,
                'payment_mode' => $details->payment_mode,
                'bank_name' => $details->bank_name,
                'branch_name' => $details->branch_name,
                'cheque_number' => $details->cheque_number,
                'cheque_status' => $details->cheque_status,
                'cheque_return_date' => $details->cheque_return_date,
                'type' => $details->type,
                'date' => $details->date,
                'customer_name' => $details->customer_name,
                'customer_contactno' => $details->customer_contactno,
                'bal_amount' => $details->bal_amount,
                'credit_balance' => $details->credit_balance,
            );
        endforeach;
        //echo "<pre>";print_r($data);exit;
        return $data;
    }

	public function GetDetailsToPrint($customer, $from_date, $to_date){
		//$start_date = date('Y-m-d', strtotime($this->input->post('from_date')));
		//$end_date = date('Y-m-d', strtotime($this->input->post('to_date')));
		//$customer_id = $this->input->post('customerName');
		$this->db->select('*');
		$this->db->from('purchases');
		$this->db->join('customers', 'purchases.customer_id = customers.customer_id', 'left');	
		$this->db->join('payments', 'purchases.receipt_number = payments.receipt_no', 'left');	
		$this->db->join('products', 'purchases.prod_id = products.product_id', 'left');
		$this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
		$this->db->where(array(
				'purchases.customer_id' => $customer,
				'purchases.date >=' => $from_date,
				'purchases.date <=' => $to_date,
			));
		$this->db->order_by('purchases.purchase_id', 'asc');
		//$this->db->group_by('purchases.rate');
		$query = $this->db->get();
		$purchase_details = $query->result();
		

		$this->db->select('*');
		$this->db->from('payments');
		$this->db->join('customers', 'payments.customer_id = customers.customer_id', 'left');
		$this->db->where(array(
				'payments.customer_id' => $customer,
			));
		//$this->db->group_by('purchases.receipt_number');
		$query1 = $this->db->get();
		//echo"<pre>";print_r($query->result());exit;
		$payment_details = $query1->result();
		
		$records = array_merge($purchase_details, $payment_details);

		if(!empty($records)){
		foreach($records as $key => $row):
			$orderByDate[$key] = strtotime($row->date);
		endforeach;
		/*foreach ($records as $key => $row) {
		    $orderByDate[$key]  = strtotime($row['date']);
		}*/

		array_multisort($orderByDate, SORT_ASC, $records);
		//echo"<pre>";print_r($records);exit;
		//$a = ksort($records);
		//echo"<pre>";print_r($records);exit;
		return $records;
		}
		/*$this->db->select('*');
		$this->db->from('purchases');
		$this->db->join('customers', 'purchases.customer_id = customers.customer_id', 'left');	
		$this->db->join('payments', 'purchases.receipt_number = payments.receipt_no', 'left');	
		$this->db->join('products', 'purchases.prod_id = products.product_id', 'left');
		$this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
		$this->db->where(array(
				'purchases.customer_id' => $customer,
				'purchases.date >=' => $from_date,
				'purchases.date <=' => $to_date,
			));
		$query = $this->db->get();
		//echo"<pre>";print_r($query->result());exit;
		return $query->result();*/
	}


	public function GetPaymentDetails(){
		$customer_id = $this->input->post('customerName');
		$this->db->select('*');
		$this->db->from('payments');
		$this->db->join('customers', 'payments.customer_id = customers.customer_id', 'left');	
		$this->db->join('purchases', 'payments.receipt_no = purchases.receipt_number', 'left');	
		$this->db->join('products', 'purchases.prod_id = products.product_id', 'left');
		$this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
		$this->db->where(array(
				'payments.customer_id' => $customer_id,
				'paymentts.cheque_status' => 0,
			));
		$query = $this->db->get();
		return $query->result();
	}

	public function GetTotalAmount($cust_id = null){
		if(isset($cust_id)){
		  $customer_id = $cust_id;
		}else{
		  $customer_id = $this->input->post('customerName');
		}
		$start_date = date('Y-m-d', strtotime($this->input->post('from_date')));
		$end_date = date('Y-m-d', strtotime($this->input->post('to_date')));
		
		$this->db->select('*, SUM(purchases.rate) AS TotalAmount');
		$this->db->from('purchases');
		$this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
		$this->db->where(array(
				'purchases.customer_id' => $customer_id,
				/* 'purchases.date >=' => $start_date,
				'purchases.date <=' => $end_date, */
				'categories.category_name !=' => 'cheque',
			));
		$query = $this->db->get();
		$data = $query->result();
		//echo"<pre>";print_r($this->db->last_query());exit;
		return $data[0]->TotalAmount;
	}

	public function GetTotalAmountToPrint($customer, $from_date, $to_date){
		$this->db->select('*, SUM(purchases.rate) AS TotalAmount');
		$this->db->from('purchases');
		$this->db->join('categories', 'purchases.category_id = categories.category_id', 'left');
		$this->db->where(array(
				'customer_id' => $customer,
				/* 'date >=' => $from_date,
				'date <=' => $to_date, */
            'categories.category_name !=' => 'cheque',
			));
		$query = $this->db->get();
		$data = $query->result();
		return $data[0]->TotalAmount;
	}

	public function GetCreditBalanceAmountByUserID($cust_id){
		$query = $this->db->get_where('customers', array(
				'customer_id' => $cust_id,
			));
		$data = $query->result();
		//echo"<pre>";print_r($data);exit;
		if($data[0]->bal_amount == ''){
			$credit_balance = 'Credit-'.$data[0]->credit_balance;
			return $credit_balance;
			//print_r('Credit Balance');exit;
		}else{
			//print_r('Balance Amount');exit;
			$balance = 'Balance-'.$data[0]->bal_amount;
			return $balance;	
		}
		
	}

	public function GetTotalAmountForAjaxCall($cust_id){
		$customer_id = $this->input->post('customerName');
		$this->db->select('*, SUM(purchases.rate) AS TotalAmount');
		$this->db->from('purchases');
		$this->db->where(array(
				'customer_id' => $cust_id,
			));
		$query = $this->db->get();
		$data = $query->result();

		return $data[0]->TotalAmount;
	}

	public function GetTotalAmountPaid($cust_id = null){
	if(isset($cust_id)){
		$customer_id = $cust_id;
	}else{
		$customer_id = $this->input->post('customerName');
	}
	    //echo "<pre>";print_r($this->input->post());exit;
		$start_date = date('Y-m-d', strtotime($this->input->post('from_date')));
		$end_date = date('Y-m-d', strtotime($this->input->post('to_date')));
		//$customer_id = $this->input->post('customerName');
		$this->db->select('*, SUM(transactions.amount) AS TotalPaidAmount');
		$this->db->from('transactions');
		$this->db->where(array(
				'customer_id' => $customer_id,
				/* 'date >=' => $start_date,
				'date <=' => $end_date, */
				'type' => 'Payment',
			));

		$query = $this->db->get();
		$data = $query->result();
		//echo "<pre>";print_r($data);exit;
		return $data[0]->TotalPaidAmount;
	}

	public function GetTotalAmountPaidToPrint($customer, $from_date, $to_date){
		$this->db->select('*, SUM(transactions.amount) AS TotalPaidAmount');
		$this->db->from('transactions');
		$this->db->where(array(
				'customer_id' => $customer,
                'type' => 'Payment',
			));
		$query = $this->db->get();
		$data = $query->result();
		return $data[0]->TotalPaidAmount;
	}

	public function GetTotalAmountPaidForAjaxCall($cust_id){
	    //echo"<pre>";print_r($cust_id);exit;
		//$customer_id = $this->input->post('customerName');
		$this->db->select('*, SUM(transactions.amount) AS TotalPaidAmount');
		$this->db->from('transactions');
		$this->db->where(array(
				'customer_id' => $cust_id,
				//'cheque_status !=' => 1,
                'type' => 'Payment',
			));
		$query = $this->db->get();
		$data = $query->result();
		if(!empty($data[0]->TotalPaidAmount)){
            $total_paid = $data[0]->TotalPaidAmount;
        }else{
		    $total_paid = 0;
        }
        return $total_paid;
	}
}