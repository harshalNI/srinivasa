<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Payment Details</h2>
                    <!-- <a href="<?php echo base_url('customers/add');?>"><button class="btn btn-outline btn-success  dim" type="button">Add New Customer</button></a>
                    <a href="<?php echo base_url('customers');?>"><button class="btn btn-outline btn-info  dim active" type="button">List</button></a> -->
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Customer Name : <?php echo $payment_details[0]->customer_name; ?></h5>
                        
                    </div>
                    <div class="ibox-title">
                        <div class="col-lg-3">
                            <?php
                                setlocale(LC_MONETARY,"en_IN.UTF-8");
                                $totalAmount = str_replace('INR','',money_format("%i", $total_amount));
                                $totalPaid = str_replace('INR','',money_format("%i", $total_paid));
                                if($total_amount < $total_paid){
                                    $creditamt = $payment_details[0]->credit_balance;
                                    $creditAmount = str_replace('INR','',money_format("%i", $creditamt));
                                }else{
                                    $remaining = $payment_details[0]->bal_amount;
                                    $balanceAmount = str_replace('INR','',money_format("%i", $remaining));
                                }
                            ?>
                            <strong>Total Purchases :</strong> Rs. <?php echo $totalAmount;?>
                        </div>
                        <div class="col-lg-3">
                            <strong>Total Paid :</strong> Rs. <?php echo $totalPaid;?>
                        </div>
                        <?php if(empty($creditamt)){?>
                        <div class="col-lg-3">
                            <strong>Balance : Rs. <?php echo $balanceAmount;?></strong>
                        </div>
                        <?php }else{?>
                        <div class="col-lg-3">
                            <strong>Credit Amount:</strong> Rs. <?php echo $creditAmount;?>
                        </div>
                        <?php }?>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th></th>
                        <!-- <th>Product</th> -->
                        <th>Paid Amount</th>
                        <th>Purchase Date</th>
                        <th>Paid Date</th>
                        <th>Mode of Payment</th>
                        <th>Cheque Details</th>
                        <th>Cheque Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sr = 1; $sub_total = ''; foreach($payment_details as $record):
                    //echo"<pre>";print_r($record);exit;
                        $amount = $record->amount;
                        //$sub_total = $amount;
                        $cust_id =  $record->customer_id;
                        $purchase_date = $this->Payment->GetPurchaseDate($record->receipt_no);
                    ?>
                    <tr class="gradeX" id="<?php echo $record->payment_id;?>">
                        <td><?php echo $sr;?></td>
                        <td><?php echo $amount;?></td>
                        <td><?php if(!empty($purchase_date)){ echo date('d/m/Y', strtotime($purchase_date));}else{echo "N/A";}?></td>
                        <td><?php echo date('d/m/Y', strtotime($record->date));?></td>
                        <td><?php echo ucfirst($record->payment_mode);?></td>
                        <td>
                            <?php if($record->payment_mode == 'cheque'){?>
                             <strong><?php echo ucwords($record->bank_name);?> : </strong>
                                <small><?php echo $record->branch_name.' ('.$record->cheque_number.' )  ';?></small>
                            <?php }else{
                                echo"N/A";
                                }?>
                        </td>
                        <td>
                            <?php if($record->payment_mode == 'cheque' && $record->cheque_status == '0'){?>
                                <button class="btn btn-outline btn-info dim cheque_return" type="button">Cheque Return </button>
                            <?php }else if($record->payment_mode == 'cheque' && $record->cheque_status == '1'){?>
                                Cheque Returned
                            <?php }?>
                        </td>
                        <td>
                        	<button class="btn btn-outline btn-danger dim delete_payment" type="button">Delete </button>
                        </td>
                    </tr>
                    <?php $sr++; endforeach;?>      
                                    
                    </tbody>
                    
                    </table>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>