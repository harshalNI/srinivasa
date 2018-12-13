<?php
header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");
?>
<?php //echo"<pre>";print_r($this->input->post());exit;
    $customer_name = $this->input->post('customerName');
    $from_date = $this->input->post('from_date');
    $to_date = $this->input->post('to_date');
?>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2>Customer Report</h2>
                    <!-- <a href="<?php echo base_url('customers/add');?>"><button class="btn btn-outline btn-success  dim" type="button">Add New Customer</button></a>
                    <a href="<?php echo base_url('customers');?>"><button class="btn btn-outline btn-info  dim active" type="button">List</button></a> -->
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
                        <!-- <a href="#" class="btn btn-white"><i class="fa fa-pencil"></i> Edit </a>
                        <a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save </a> -->
                        <?php if(!empty($records)){?>
                        <a href="<?php echo base_url('print/report/'.$customer_name.'/'.$from_date.'/'.$to_date);?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Report </a>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox-content">
                    <div class="row">
                        <form role="form" method="post" action="<?php echo base_url('reports/customer');?>">
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <div class="col-lg-3">
                                    <?php //echo"<pre>";print_r($records);exit;?>
                                        <label>Customer</label>
                                        <div class="form-group">
                                            <select required="" name="customerName" <?php if(!empty($records)){?> readonly <?php }?> id="customerName" class="chosen-select" >
                                                <option value="">Select Customer</option>
                                                <?php foreach($customers as $customer):
                                                    if(!empty($records) && $records[0]['customer_id'] == $customer->customer_id){
                                                        $selected = 'selected';
                                                    }else{
                                                        $selected = '';
                                                    }
                                                    ?>
                                                    <option <?php echo $selected;?> value="<?php echo $customer->customer_id;?>"><?php echo $customer->customer_name;?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>From Date</label>
                                        <div class="form-group" id="from_date">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="from_date" <?php if(!empty($records)){?> value="<?php echo $this->input->post('from_date');?>" <?php }?> required="" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>To Date</label>
                                        <div class="form-group" id="to_date">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="to_date" <?php if(!empty($records)){?> value="<?php echo $this->input->post('to_date');?>" <?php }?> required="" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <label></label><br/>
                                        <input type="submit" value="submit" name="submit" class="btn btn-outline btn-primary dim">
                                    </div>

                                </div>
                            </div>
                            </form>
                    </div>
                </div>
                <div class="ibox float-e-margins">
                <?php if(!empty($records)){?>
                    <div class="ibox-title">
                        <h5>Customer Name : <?php echo ucwords($records[0]['customer_name']);?></h5>
                        <?php //echo"<pre>";print_r($records);exit;?>
                        <div class="col-lg-4">
                           &nbsp;
                        </div>
                        <div class="col-lg-3">
                            <strong>Phone :</strong><?php echo $records[0]['customer_contactno'];?>
                        </div>
                    </div>
                    <?php }?>
                    <div class="ibox-title">
                        <?php if(isset($records) && !empty($records)){?>
                        <div class="col-lg-3">
                            <?php
                                //$opening_balance = $records[0]->previous_balance;
                            $openingBalance = str_replace('INR','',money_format("%i", $opening_bal));
                            $grosspuramt = $total_amount + $opening_bal;

                               $exp = explode('-',$balance_amount);
                            //echo"<pre>";print_r($grosspuramt);
                            //echo"<pre>";print_r($total_paid);exit;
                           // echo"<pre>";print_r($exp);exit;
                            if($exp[0] == 'Balance'){
                                $total_paid_amount = $grosspuramt - $exp[1];
                            }else{
                                $total_paid_amount = $exp[1] - $grosspuramt;
                            }
                                //echo"<pre>";print_r($total_paid_amount);exit;
                                setlocale(LC_MONETARY,"en_IN.UTF-8");
                                $totalAmount = str_replace('INR','',money_format("%i", $total_amount));


                                //echo"<pre>";print_r($grosspuramt);exit;

                                $totalPaid = str_replace('INR','',money_format("%i", $total_paid_amount));

                                if($grosspuramt < $total_paid){
                                    $creditamt = $total_paid - $grosspuramt;
                                    $creditAmount = str_replace('INR','',money_format("%i", $creditamt));
                                }else{
                                    $remaining = $grosspuramt - $total_paid;
                                    $balanceAmount = str_replace('INR','',money_format("%i", $remaining));
                                }
                                //echo"<pre>";print_r('Balance Amount : '. $balanceAmount);exit;
                                //echo"<pre>";print_r('Credit Amount : '. $creditAmount);exit;
                            ?>
                            <strong>Purchase Amount :</strong> Rs. <?php echo $totalAmount;?>
                        </div>
                        <div class="col-lg-3">
                            <strong>Opening Balance :</strong> Rs. <span id="op_bal"><?php echo $openingBalance;?></span>
                        </div>
                        <div class="col-lg-3">
                            <strong>Total Paid Amount:</strong> Rs. <?php echo str_replace('INR','',money_format("%i", $total_paid));?>
                        </div>
                        <?php if(!empty($remaining)){?>
                        <div class="col-lg-3">
                            <strong>Balance : Rs. <?php echo $balanceAmount;?></strong>
                        </div>
                        <?php }else if(!empty($creditamt)){ ?>
                        <div class="col-lg-3">
                            <strong>Credit Amount :</strong> Rs. <?php echo $creditAmount;?>
                        </div>
                        <?php } else{?>
                        <div class="col-lg-3">
                            <strong>Credit Amount :</strong> N/A
                        </div>
                        <?php }?>
                    </div>

                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th style="display: none;"></th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Cheque Return Date</th>
                        <th>Work Site</th>
                        <th>Vehicle Number</th>
                        <th>Mode of Payment</th>
                        <th>Cheque Details</th>
                        <th>Balance Due</th>
                        <!-- <th>Order Detail</th> -->
                        <!-- <th></th> -->
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sr = 1;
                       // $sub_total = '';
                    $amt = '';
                        foreach($records as $key => $record)://echo"<pre>";print_r($opening_bal);exit;
                        if(!empty($record->receipt_number)){//print_r('here');
                            $recpt_no = $record->receipt_number;
                        }else{
                            $recpt_no = '';
                        }
                        $amt1 = $opening_bal;
                            if($record['type'] == 'Sales'){
                                if($key == 0){
                                    $amt = $opening_bal + $record['amount'];
                                }else{
                                    $amt = $amt + $record['amount'];
                                }
                                //echo "<pre>";print_r('Sales : '.$amt);

                            }else if($record['type'] == 'Payment'){

                                if($key == 0){
                                    $amt = $opening_bal - $record['amount'];
                                }else{
                                    $amt = $amt - $record['amount'];
                                }
                            }else{
                                if($record['cheque_status'] == 0){
                                    $amt = $record['amount'] - $amt;
                                }else{
                                    //echo "<pre>";print_r('A : '.$amt);
                                    //echo "<pre>";print_r($record['amount']);exit;
                                    $amt = $amt;
                                }

                            }
                        //echo "<pre>";print_r($amt);
                            $purchase_details = $record['purchase_details'];
                            if(!empty($purchase_details)){


                            foreach ($purchase_details as $p_details)://echo"<pre>";print_r($record);
                    ?>
                    <tr class="gradeX" id="<?php //echo $sale->purchase_id;?>" <?php if(empty($p_details->category_name) && $p_details->category_name != 'cheque'){?> style="color:green;" <?php } else if($p_details->category_name == 'Cheque'){?> style="color:red;" <?php }?>>
                        <td style="display: none;"></td>
                        <td>
                            <?php if(!empty($record['transaction_date'])){ echo date('d/m/Y', strtotime($record['transaction_date'])); }?>
                        </td>
                        <td class="type"><?php if($record['type'] != 'Cheque Returned'){echo $record['type'];}else{ echo 'Payment';} ?></td>
                        <td>
                            <strong><?php if(!empty($p_details->category_name)){ echo ucwords($p_details->category_name);?> : </strong>
                            <small><?php echo $p_details->product_name.' '.$p_details->quantity.' '.$p_details->product_measure;?></small>
                            <?php }else{?>
                                <small>Amount Paid</small>
                            <?php }?>
                        </td>
                        <td class="amt"><?php echo $p_details->rate;?></td>


                        <!--<td ></td>-->

                        <!--<td <?php /*if(empty($record->category_name)){*/?> style="color:green;" <?php /*} else if($record->category_name == 'Cheque'){*/?> style="color:red;" <?php /*}*/?>><?php /*if(isset($record->cheque_return_date) && !empty($record->cheque_return_date) && $record->cheque_return_date != '0000-00-00 00:00:00'){ echo date('d/m/Y', strtotime($record->cheque_return_date)); }else{ echo "N/A"; }*/?></td>-->

                        <td>

                        </td>

                        <td ><?php echo ucwords($record['work_site']);?></td>

                        <td ><?php echo $record['vehicle_no'];?></td>


                        <td></td>
                        <td>
                            <?php if(!empty($record['bank_name'])){?>
                                <strong><?php echo ucwords($record['bank_name']);?> </strong>
                                <small><?php echo $record['branch_name'].' '.$record['cheque_number'];?></small>
                            <?php }else{
                                echo"N/A";
                            }?>
                        </td>
                        <td class="amount"><?php echo $amt;?></td>
                        <!-- <td>
                            <a href="<?php echo base_url('order/details/'.$record->receipt_no);?>"><button class="btn btn-outline btn-info  dim" target="_blank" type="button">View</button></a>
                        </td> -->
                    </tr>
                    <?php endforeach;}else{ //echo"<pre>";print_r($record);?>
                                <tr class="gradeX" <?php if($record['cheque_status'] == 0){?>style="color: #00CC00" <?php }else{?> style="color: #953b39" <?php }?> id="<?php //echo $sale->purchase_id;?>">

                                    <td ><?php if(!empty($record['transaction_date'])){ echo date('d/m/Y', strtotime($record['transaction_date'])); }?></td>
                                    <td class="type"><?php if($record['type'] != 'Cheque Returned'){echo $record['type'];}else{echo "Payment";} ?></td>
                                    <td><?php if($record['cheque_status'] == 0){?><small>Amount Paid</small><?php }else{?> <small>Cheque Returned</small> <?php }?></td>
                                    <td class="amt"><?php echo $record['amount'];?></td>
                                   <!-- <td>N/A</td>-->

                                    <!--<td <?php /*if(empty($record->category_name)){*/?> style="color:green;" <?php /*} else if($record->category_name == 'Cheque'){*/?> style="color:red;" <?php /*}*/?>><?php /*if(isset($record->cheque_return_date) && !empty($record->cheque_return_date) && $record->cheque_return_date != '0000-00-00 00:00:00'){ echo date('d/m/Y', strtotime($record->cheque_return_date)); }else{ echo "N/A"; }*/?></td>-->

                                    <td><?php if(!empty($record['cheque_return_date'])){ echo date('d/m/Y', strtotime($record['cheque_return_date'])); }?></td>

                                    <td ><?php echo ucwords($record['work_site']);?></td>

                                    <td ><?php echo $record['vehicle_no'];?></td>

                                    <td><?php echo ucwords($record['payment_mode']);?></td>

                                    <td >
                                        <?php if($record['payment_mode'] == 'cheque' || !empty($record['bank_name'])){?>
                                            <strong><?php echo ucwords($record['bank_name']);?> </strong>
                                            <small><?php echo $record['branch_name'].' '.$record['cheque_number'];?></small>
                                        <?php }else{
                                            echo"N/A";
                                        }?>
                                    </td>
                                    <td class="amount"><?php echo $amt;?></td>
                                    <!-- <td>
                            <a href="<?php echo base_url('order/details/'.$record->receipt_no);?>"><button class="btn btn-outline btn-info  dim" target="_blank" type="button">View</button></a>
                        </td> -->
                                </tr>
                            <?php }$sr++; endforeach;//exit;?>
                    </tbody>


                    </table>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
            </div>
        </div>
<script src="<?php echo base_url('assets');?>/js/jquery-2.1.1.js"></script>
<script>
    $(document).ready(function(){
        var config = {
            '.chosen-select'           : {},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
            '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    });
</script>