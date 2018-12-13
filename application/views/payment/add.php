<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Payments</h2>
        <a href="<?php echo base_url('payments/add');?>"><button class="btn btn-outline btn-success  dim active" type="button">Add New Payment</button></a>
        <a href="<?php echo base_url('payments');?>"><button class="btn btn-outline btn-info  dim " type="button">List</button></a>
        
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Add Payment</h5>
                    </div>
                    <div class="ibox-content">
                    <?php //echo"<pre>";print_r($this->input->post());exit;?>
                        <div class="row">
                        <form role="form" method="post" action="<?php echo base_url('payments/customers');?>">
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <div class="col-lg-4">
                                    <label>Customer</label>
                                        <?php if(form_error('customerName') != ''){?>
                                        <div class="form-group has-error">
                                        <?php }?>
                                            <select required="" name="customerName" <?php if(!empty($record)){?> readonly <?php }?> class="chosen-select" style="width: 300px;" id="customerName">
                                                <option value="">Select Customer</option>
                                                <?php foreach($customers as $customer):?>
                                                    <option <?php if(!empty($records)){ if($records[0]->customer_id == $customer->customer_id) {?> selected <?php }}?> value="<?php echo $customer->customer_id;?>"><?php echo $customer->customer_name;?></option>
                                                <?php endforeach;?>
                                            </select>
                                        <?php if(form_error('customerName') != ''){?>
                                            <span class="help-block m-b-none"><?php echo form_error('customerName');?></span>
                                        </div>
                                        <?php }?>
                                    </div>
                                    

                                    <div class="col-lg-2">
                                        <label></label><br/>
                                        <input type="submit" value="Get Details" name="Get Details" class="btn btn-outline btn-primary dim">
                                    </div>
                                    
                                </div>
                            </div>
                            </form>
                            <div class="col-sm-12">
                                <br><hr>
                            </div>
                            <?php if(isset($records) && !empty($records)){?>
                                <div class="col-lg-12">
                                <?php //echo"<pre>";print_r($records);exit;?>
                                    <div class="ibox float-e-margins">
                                    <h3>Payment Details of : <?php echo $records[0]->customer_name; ?> </h3>
                                        <div class="ibox-title">
                                            
                                            <div class="col-lg-3">
                                                <div class="ibox-tools">
                                                <?php
                                                    setlocale(LC_MONETARY,"en_IN.UTF-8");
                                                    $totalAmount = str_replace('INR','',money_format("%i", $total_amount));
                                                    $totalPaid = str_replace('INR','',money_format("%i", $total_paid));
                                                    $remaining = $total_amount-$total_paid;
                                                    $balanceAmount = str_replace('INR','',money_format("%i", $remaining));
                                                ?>
                                                    <strong>Total Amount :</strong>  Rs. <?php echo $totalAmount;?>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="ibox-tools">
                                                    <strong>Total Paid :</strong> Rs. <?php echo $totalPaid;?> 
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="ibox-tools">
                                                    <strong>Balance : Rs. <?php echo $balanceAmount;?></strong> 
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <a data-toggle="modal" href="#modal-form"><button class="btn btn-outline btn-success dim " type="button" id="pay">Pay </button></a>
                                                <button class="btn btn-outline btn-info dim " type="button" id="viewdetails">View Details </button>
                                            </div>
                                            
                                        </div>
                                        <div id="modal-form" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-8"><h3 class="m-t-none m-b">Add Payment</h3>

                                                    <form role="form" method="post" action="<?php echo base_url('payments/add');?>">
                                                        <input type="text" name="customer_id" id="customer">
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
                                                        <div class="form-group">
                                                            <label>Date</label> 
                                                            <div class="form-group" id="paid_date">
                                                                <div class="input-group date">
                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="to_date" required="" class="form-control">
                                                                </div>
                                                            </div>
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
                                        <div class="ibox-content" style="display: none;" id="paymentdetails">

                                            <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover " >
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Product</th>
                                            <th>Rate</th>
                                            <th>Purchase Date</th>
                                            <th>Paid Date</th>
                                            <th>Mode of Payment</th>
                                            <th>Cheque Details</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $sr = 1; 
                                            $sub_total = '';
                                            foreach($records as $record)://echo"<pre>";print_r($record);exit;
                                            $amount = $record->rate;
                                            $sub_total = $sub_total + $amount;
                                            setlocale(LC_MONETARY,"en_IN.UTF-8");
                                            $price = str_replace('INR','',money_format("%i", $amount));
                                            $totalPaid = str_replace('INR','',money_format("%i", $total_paid));
                                            
                                        ?>
                                        <tr class="gradeX" id="<?php //echo $sale->purchase_id;?>">
                                            <td><?php echo $sr;?></td>
                                            <td>
                                                <strong><?php echo ucwords($record->category_name);?> : </strong>
                                                <small><?php echo $record->product_name.' '.$record->quantity.' '.$record->product_measure;?></small>
                                            </td>
                                            <td><?php echo $price;?></td>
                                            <td><?php echo date('d/m/Y', strtotime($record->purchase_date));?></td>
                                            
                                            <!-- <td><?php echo $totalPaid;?></td> -->
                                            <td><?php echo date('d/m/Y', strtotime($record->paid_date));?></td>
                                            <td><?php echo ucfirst($record->payment_mode);?></td>
                                            <td>
                                                <?php if($record->payment_mode == 'cheque'){?>
                                                 <strong><?php echo ucwords($record->bank_name);?> : </strong>
                                                    <small><?php echo $record->branch_name.' '.$record->cheque_number;?></small>
                                                <?php }else{
                                                    echo"N/A";
                                                    }?>
                                                </td>
                                            <td >
                                                
                                                <!-- <a href="<?php echo base_url('sales/edit/'.$sale->receipt_number);?>"><button class="btn btn-outline btn-primary  dim" type="button">Edit </button></a> -->
                                            </td>
                                        </tr>
                                        <?php $sr++; endforeach;?>                    
                                        </tbody>
                                        
                                        
                                        </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php }?>
                                </div>
                                    
                            </div>
                        </div>
                        <div>
                        
                    </div>
                </div>
            </div>
    </div>
</div>