<?php //echo"<pre>";print_r($detail);exit;?>


<div class="row wrapper border-bottom white-bg page-heading">
                
        <div class="row content">
            <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="ibox-content p-xl">
                    <div class="row">
                        <div class="col-sm-6">
                        <?php //echo"<pre>";print_r($order_details);exit;?>
                            <!-- <h4>Invoice No.</h4>
                            <h4 class="text-navy"><?php echo $order_details[0]->receipt_number;?></h4> -->
                            <address>
                                <strong><?php echo $order_details[0]->customer_name;?></strong><br>
                                <abbr title="Phone">P:</abbr> <?php echo $order_details[0]->customer_contactno;?>
                            </address>
                        </div>

                        <div class="col-sm-6 text-right">
                            <p>
                                <span><strong>Invoice Date:</strong> <?php echo date('d/m/Y', strtotime($order_details[0]->purchase_date));?></span>
                            </p>
                        </div>
                    </div>

                    <div class="table-responsive m-t">
                        <table class="table invoice-table">
                            <thead>
                            <tr>
                                <th>Item List</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sr = 1; 
                                $sub_total = '';
                                foreach($order_details as $details):
                                    $amount = $details->rate;
                                   //echo"<pre>";print_r($previous_bal);exit;
                                    $sub_total = $sub_total + $amount;
                                    setlocale(LC_MONETARY,"en_IN.UTF-8");
                                    $price = str_replace('INR','',money_format("%i", $amount));
                            ?>
                            <tr>
                                <td>
                                    <div>
                                        <strong><?php echo $sr.') '. $details->category_name;?> : </strong>
                                        <small><?php echo $details->product_name;?></small>
                                    </div>
                                </td>
                                <td><?php echo $details->quantity.' '. $details->product_measure;?></td>
                                <td>Rs. <?php echo $price;?></td>
                            </tr>
                            <?php $sr++; endforeach;?>
                            </tbody>
                        </table>
                    </div><!-- /table-responsive -->

                    <table class="table invoice-total">
                        <tbody>
                        <tr>
                            <td><strong>Sub Total :</strong></td>
                            <?php 
                                setlocale(LC_MONETARY,"en_IN.UTF-8");
                                $sub_total_price = str_replace('INR','',money_format("%i", $sub_total));
                                setlocale(LC_MONETARY,"en_IN.UTF-8");
                                if(!empty($total_paid)){
                                $totalPaid = str_replace('INR','',money_format("%i", $total_paid));
                            }
                                if(!empty($previous_bal)){
                                    $pre_bal_amt = str_replace('INR','',money_format("%i", $previous_bal));
                                }
                                
                                if(!empty($prev_credit_balance)){
                                    $pre_cr_amt = str_replace('INR','',money_format("%i", $prev_credit_balance));
                                }
                                $grand_total = $sub_total + $previous_bal;
                                $creditamount = $total_paid - $grand_total;
                               // print_r($creditamount);exit;
                                $remaining = $sub_total-$prev_credit_balance;
                                setlocale(LC_MONETARY,"en_IN.UTF-8");
                                $balanceAmount = str_replace('INR','',money_format("%i", $remaining));
                            ?>
                            <td>Rs. <?php echo $sub_total_price;?></td>
                        </tr>
                        <?php //echo"<pre>";print_r($prev_credit_balance);exit;?>
                        <?php if($previous_bal != 0){?>
                        <tr>
                            <td><strong>Previous Balance :</strong></td>
                            <td><strong>Rs. <?php echo $pre_bal_amt;?></strong></td>
                        </tr>

                        <tr>
                            <td><strong>Total Paid :</strong></td>
                            <td>Rs. <?php if(!empty($total_paid)){ echo $totalPaid;}else{echo "N/A";}?></td>
                        </tr>
                        
                        <tr>
                            <td><strong>Credit Amount :</strong></td>
                            <td><strong>Rs. <?php echo $creditamount;?></strong></td>
                        </tr>
                        
                        
                        <?php }else{?>
                        <tr>
                            <td><strong>Previous Credit Balance :</strong></td>
                            <td><strong>Rs. <?php echo $pre_cr_amt;?></strong></td>
                        </tr>

                        <tr>
                            <td><strong>Balance :</strong></td>
                            <td><strong>Rs. <?php echo $balanceAmount;?></strong></td>
                        </tr>
                        <?php }?>
                        </tbody>
                    </table>
                    <!-- <div class="text-right">
                        <button class="btn btn-primary"> Make A Payment</button>
                    </div> -->
                </div>
        </div>
    </div>
        </div>

<script type="text/javascript">
        window.print();
    </script>