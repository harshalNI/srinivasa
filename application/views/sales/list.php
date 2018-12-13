<?php
header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");
?>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Sales</h2>
                    <a href="<?php echo base_url('sales/add');?>"><button class="btn btn-outline btn-success  dim" type="button">Add New Sale</button></a>
                    <a href="<?php echo base_url('sales');?>"><button class="btn btn-outline btn-info  dim active" type="button">List</button></a>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="ibox-content">
                    <div class="row">
                        <form role="form" method="post" action="<?php echo base_url('sales');?>">
                            <div class="col-sm-10">
                                <div class="form-group">
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
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Sales List</h5>
                    <div class="ibox-content">

                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th></th>
                        <th>Customer Name</th>
                        <th>Balance Amount</th>
                        <th>Advance Amount</th>
                        <th>Rate</th>
                        <th>Advance Paid</th>
                        <!-- <th>Balance Amount</th> -->
                        <th>Purchase Date</th>
                        <th>Work Site</th>
                        <th>Vehicle Number</th>
                        <th class="noExport">Order Detail</th>
                        <th class="noExport"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sr = 1; foreach($sales as $sale)://echo"<pre>";print_r($sale);exit;
                        $receipt_no = $sale->receipt_number;
                        $record = $this->Sales->GetTotalAmountPaidByReceiptNo($receipt_no);
                        if(!empty($record)){
                            $amount = $record->amount;    
                        }
                        setlocale(LC_MONETARY,"en_IN.UTF-8");
                        if(!empty($sale->bal_amount)){
                        	$balAmount = str_replace('INR','',money_format("%i", $sale->bal_amount));
                        }else{
                            $balAmount = 'N/A';
                        }

                        if(!empty($sale->credit_balance)){
                            $creditBalance = str_replace('INR','',money_format("%i", $sale->credit_balance));
                        }else{
                            $creditBalance = 'N/A';
                        }
                        
                        //echo"<pre>";print_r($record);exit;
                    ?>
                    <tr class="gradeX" id="<?php echo $sale->receipt_number;?>">
                        <td><?php echo $sr;?></td>
                        <td><?php echo ucwords($sale->customer_name);?></td>
                        <td><?php echo $balAmount;?></td>
                        <td><?php echo $creditBalance;?></td>
                        <td><?php echo $sale->TotalAmount;?></td>
                        <td><?php if(!empty($record)){ echo $amount; }?></td>
                        <!-- <td><?php echo $balance_amount;?></td> -->
                        <td><?php echo date('d/m/Y', strtotime($sale->purchase_date));?></td>
                        <td><?php echo $sale->work_site;?></td>
                        <td><?php echo $sale->vehicle_no;?></td>
                        <td>
                            <a href="<?php echo base_url('order/details/'.$sale->receipt_number);?>"><button class="btn btn-outline btn-info  dim" type="button">View</button></a>
                        </td>
                        <td colspan="2">
                            
                            <a href="<?php echo base_url('sales/edit/'.$sale->receipt_number);?>"><button class="btn btn-outline btn-primary  dim" type="button">Edit </button></a>
                            <button class="btn btn-outline btn-danger dim delete_sale" type="button">Delete </button>
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

