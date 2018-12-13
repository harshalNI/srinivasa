<script type="text/javascript">
        window.print();
    </script>
<style type="text/css">
    table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
</style>

<?php //echo"<pre>";print_r($this->input->post());exit;
    $customer_name = $this->input->post('customerName');
    $uri = uri_string();
    $exploded_uri = explode('/',$uri);
    //echo"<pre>";print_r($exploded_uri);exit;
    $from_date = $exploded_uri[3];
    $to_date = $exploded_uri[4];
?>
            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Customer Name : <?php if(!empty($records)){ echo ucwords($records[0]['customer_name']);}?></h5>
                        <?php //echo"<pre>";print_r($records);exit;?>
                        <?php if(isset($records) && !empty($records)){?>
                        <div class="col-lg-6">
                            <?php
                                setlocale(LC_MONETARY,"en_IN.UTF-8");
                                $totalAmount = str_replace('INR','',money_format("%i", $total_amount));
                                setlocale(LC_MONETARY,"en_IN.UTF-8");
                                $totalPaid = str_replace('INR','',money_format("%i", $total_paid));
                                if($total_amount < $total_paid){
                                    $creditamt = $total_paid - $total_amount;
                                    $creditAmount = str_replace('INR','',money_format("%i", $creditamt));
                                }else{
                                    $remaining = $total_amount-$total_paid;
                                    $balanceAmount = str_replace('INR','',money_format("%i", $remaining));
                                }
                            ?>

                        </div>
                        <div class="col-lg-3" style="float: right;">
                            <strong>Phone :</strong><?php echo $records[0]['customer_contactno'];?>
                        </div>

                    </div>

                    <div class="ibox-title">
                        <div class="col-lg-3" style="float: left;">
                            <strong>From : <?php echo date('d/m/Y', strtotime($from_date));?></strong>
                        </div>

                        <div class="col-lg-3" style="float: right;">
                            <strong>To : <?php echo date('d/m/Y', strtotime($to_date));?></strong>
                        </div>
                    </div>

                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Cheque Return Date</th>
                        <th>Work Site</th>
                        <th>Vehicle Number</th>
                        <th>Mode of Payment</th>
                        <th>Cheque Detail</th>
                        <!-- <th></th> -->
                    </tr>
                    </thead>
                                <tbody>
                                <?php $sr = 1;
                                // $sub_total = '';
                                $amt = '';

                                foreach($records as $key => $record)://echo"<pre>";print_r($record);
                                    if(!empty($record->receipt_number)){//print_r('here');
                                        $recpt_no = $record->receipt_number;
                                    }else{
                                        $recpt_no = '';
                                    }
                                    //$amt1 = $opening_bal;
                                    if($record['type'] == 'Sales' || $record['type'] == 'Cheque Returned'){
                                        if($key == 0){
                                            $amt = $opening_bal + $record['amount'];
                                        }else{
                                            $amt = $record['amount'];
                                        }

                                    }else{
                                        if($record['cheque_status'] == 0){
                                            $amt = $amt - $record['amount'];
                                        }else{
                                            $amt = $amt + $record['amount'];
                                        }

                                    }
                                    $purchase_details = $record['purchase_details'];
                                    if(!empty($purchase_details)){


                                        foreach ($purchase_details as $p_details)://echo"<pre>";print_r($record);
                                            ?>
                                            <tr class="gradeX" id="<?php //echo $sale->purchase_id;?>" <?php if(empty($p_details->category_name) && $p_details->category_name != 'cheque'){?> style="color:green;" <?php } else if($p_details->category_name == 'Cheque'){?> style="color:red;" <?php }?>>

                                                <td>
                                                    <?php if(!empty($record['transaction_date'])){ echo date('d/m/Y', strtotime($record['transaction_date'])); }?>
                                                </td>
                                                <td ><?php if($p_details->category_name != 'Cheque'){echo $record['type'];}else{ echo 'Payment';} ?></td>
                                                <td>
                                                    <strong><?php if(!empty($p_details->category_name)){ echo ucwords($p_details->category_name);?> : </strong>
                                                    <small><?php echo $p_details->product_name.' '.$p_details->quantity.' '.$p_details->product_measure;?></small>
                                                    <?php }else{?>
                                                        <small>Amount Paid</small>
                                                    <?php }?>
                                                </td>
                                                <td><?php echo $p_details->rate;?></td>


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
                                                <!-- <td>
                            <a href="<?php echo base_url('order/details/'.$record->receipt_no);?>"><button class="btn btn-outline btn-info  dim" target="_blank" type="button">View</button></a>
                        </td> -->
                                            </tr>
                                        <?php endforeach;}else{ //echo"<pre>";print_r($record);?>
                                        <tr class="gradeX" <?php if($record['cheque_status'] == 0){?>style="color: #00CC00" <?php }else{?> style="color: #953b39" <?php }?> id="<?php //echo $sale->purchase_id;?>">

                                            <td ><?php if(!empty($record['transaction_date'])){ echo date('d/m/Y', strtotime($record['transaction_date'])); }?></td>
                                            <td ><?php echo $record['type'];?></td>
                                            <td><?php if($record['cheque_status'] == 0){?><small>Amount Paid</small><?php }else{?> <small>Cheque Returned</small> <?php }?></td>
                                            <td><?php echo $record['amount'];?></td>
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
                                            <!-- <td>
                            <a href="<?php echo base_url('order/details/'.$record->receipt_no);?>"><button class="btn btn-outline btn-info  dim" target="_blank" type="button">View</button></a>
                        </td> -->
                                        </tr>
                                    <?php }$sr++; endforeach;//exit;?>
                                </tbody>

                    </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                <tr>
                                    <!-- <th></th> -->
                                </tr>
                                </thead>

                                <tfoot>
                                <?php
                                $exp = explode('-',$balance_amount);
                                $grosspuramount = $total_amount + $opening_bal;
                                if($exp[0] == 'Balance'){
                                    $total_paid_amount = $grosspuramount - $exp[1];
                                }else{
                                    $total_paid_amount = $exp[1] - $grosspuramount;
                                }


                                setlocale(LC_MONETARY,"en_IN.UTF-8");
                                $totalPaid = str_replace('INR','',money_format("%i", $total_paid));
                                $grosspuramount = $total_amount + $opening_bal;
                                $remaining = $grosspuramount-$total_paid;
                                if($remaining > 0){
                                    $balanceAmountNew = $remaining;
                                }else{
                                    $balanceAmountNew = 0;
                                }
                                //echo"<pre>";print_r($balanceAmountNew);exit;
                                $balanceAmount = str_replace('INR','',money_format("%i", $balanceAmountNew));
                                $openingBalance = str_replace('INR','',money_format("%i", $opening_bal));
                                ?>
                                <tr >
                                    <td colspan="10">
                                        <span style="float: right"><strong>TOTAL AMOUNT :</strong></span>
                                    </td>
                                    <td colspan="2">
                                        <span style="float: left;">Rs. <?php echo $totalAmount;?></span>
                                    </td>
                                </tr>
                                <tr >
                                    <td colspan="10">
                                        <span style="float: right"><strong>Opening Balance :</strong></span>
                                    </td>
                                    <td colspan="2">
                                        <span style="float: left;">Rs. <?php echo $openingBalance;?></span>
                                    </td>
                                </tr>
                                <tr >
                                    <td colspan="10">
                                        <span style="float: right"><strong>TOTAL PAID :</strong></span>
                                    </td>
                                    <td colspan="2">
                                        <span style="float: left;">Rs. <?php echo str_replace('INR','',money_format("%i", $total_paid));;?></span>
                                    </td>
                                </tr>
                                <?php if($remaining > 0){?>
                                    <tr >
                                        <td colspan="10">
                                            <span style="float: right"><strong>BALANCE AMOUNT :</strong></span>
                                        </td>
                                        <td colspan="2">
                                            <span style="float: left;"><strong>Rs. <?php echo str_replace('INR','',money_format("%i", $remaining));?></strong></span>
                                        </td>
                                    </tr>
                                <?php } elseif($remaining < 0){?>
                                    <tr >
                                        <td colspan="10">
                                            <span style="float: right"><strong>CREDIT AMOUNT :</strong></span>
                                        </td>
                                        <td colspan="2">
                                            <span style="float: left;"><strong>Rs. <?php echo str_replace('INR','',money_format("%i", $exp[1]));?></strong></span>
                                        </td>
                                    </tr>
                                <?php }else{?>
                                    <tr >
                                        <td colspan="10">
                                            <span style="float: right"><strong>CREDIT AMOUNT :</strong></span>
                                        </td>
                                        <td colspan="2">
                                            <span style="float: left;"><strong>Rs. <?php echo $creditAmount;?></strong></span>
                                        </td>
                                    </tr>
                                <?php }?>
                                </tfoot>

                            </table>
                            <table >

                            </table>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
            </div>
        </div>
 <!-- <script type="text/javascript">
      window.onload = function () {
          window.print();
          //setTimeout(function(){window.close();}, 1);
        }

    </script> -->
