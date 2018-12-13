<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Payments</h2>
                    <!-- <a href="<?php echo base_url('payments/customers');?>"><button class="btn btn-outline btn-success  dim" type="button">Add New Payment</button></a> -->
                    <a href="<?php echo base_url('payments');?>"><button class="btn btn-outline btn-info  dim active" type="button">List</button></a>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Payment List</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th></th>
                        <th>Customer Name</th>
                        <th>Contact Number</th>
                        <th>Credit Amount</th>
                        <th>Total Amount</th>
                        <th>Amount Paid</th>
                        <th>Balance Amount</th>
                        <th>Paid Date</th>
                        <th class="noExport"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //echo"<pre>";print_r($payments_details);exit;
                    $sr = 1; foreach($payments_details as $payments):
                        //echo"<pre>";print_r($payments);exit;
                        $customer_id = $payments->customer_id;
                        //$customer_details = $this->Customer->GetCustomerInfoByID($customer_id);
                        //echo"<pre>";print_r($customer_details);exit;
                        $recpt_no = $payments->receipt_number;

                    ?>
                     <tr class="gradeX" id="<?php echo $payments->customer_id;?>">
                        <td><?php echo $sr;?></td>
                        <td><?php echo ucwords($payments->customer_name);?></td>
                        <td><?php echo $payments->customer_contactno;?></td>
                        <td><?php if(!empty($payments->credit_balance)){ echo str_replace('INR','',money_format("%i", $payments->credit_balance));}else{echo "N/A";}?></td>
                        <td>Rs. <?php echo str_replace('INR','',money_format("%i", $payments->total_purchase_amount));?></td>
                        <td><?php if(!empty($payments->total_amount_paid)){ echo "Rs. ".str_replace('INR','',money_format("%i", $payments->total_amount_paid));}else{ echo 0;}?></td>
                        <td><?php if(!empty($payments->bal_amount)){ echo str_replace('INR','',money_format("%i", $payments->bal_amount));}else{echo "N/A";}?></td>
                        <td><?php echo date('d/m/Y', strtotime($payments->date));?></td>
                        <td colspan="2">
                           <a href="<?php echo base_url('payments/view/'.$payments->customer_id);?>"><button class="btn btn-outline btn-info  dim" type="button">View </button></a>
                           <?php if(!empty($payments->bal_amount)){?>
                           <a data-toggle="modal" href="#modal-form"><button class="btn btn-outline btn-success dim pay" type="button">Pay </button></a>
                           <?php }?>
                            <!-- <button class="btn btn-outline btn-danger dim delete_customer" type="button">Delete </button> -->

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
        <div id="modal-form" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-8"><h3 class="m-t-none m-b">Add Payment</h3>

                                                    <form role="form" method="post" action="<?php echo base_url('payments/add');?>">
                                                        <input type="hidden" name="customer_id" id="customer">
                                                        <div class="form-group"><label>Amount</label> 
                                                            <input type="text" name="amount" required="" placeholder="Enter Amount" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Payment Mode</label> 
                                                            <select name="paymentMode" required="" style="width: 300px;" id="paymentMode">
                                                                <option value="">Select Mode of Payment</option>
                                                                    <option value="cash">Cash</option>
                                                                    <option value="cheque">Cheque</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Date</label>
                                                            <div class="form-group" id="paid_date">
                                                                <div class="input-group date">
                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="to_date" required="" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" id="bankName" style="display: none;">
                                                            <label>Bank Name</label> 
                                                            <input type="text" name="bankName" placeholder="Bank Name" class="form-control">
                                                        </div>
                                                        <div class="form-group" id="branchName" style="display: none;">
                                                            <label>Branch Name</label> 
                                                            <input type="text" name="branchName" placeholder="Branch Name" class="form-control">
                                                        </div>
                                                        <div class="form-group" id="chequeNumber" style="display: none;">
                                                            <label>Cheque Number</label> 
                                                            <input type="text" name="chequeNumber" placeholder="Cheque Number" class="form-control">
                                                        </div>

                                                        <div>
                                                            <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Submit</strong></button>
                                                        </div>
                                                    </form>
                                                </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                        </div>