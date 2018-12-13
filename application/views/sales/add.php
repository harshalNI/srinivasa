<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Sales</h2>
            <a href="<?php echo base_url('sales/add');?>" ><button class="btn btn-outline btn-success  dim active" type="button">Add New Sale</button></a>
            <a href="<?php echo base_url('sales');?>"><button class="btn btn-outline btn-info  dim" type="button">List</button></a> 
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                        <h5>Sale <small>New Sale Info</small></h5>
                    </div>
                    <div class="ibox-content">
                    <form role="form" method="post" action="<?php echo base_url('sales/add');?>">
                        <div class="row" id="container">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="col-lg-3">
                                    <label>Customer</label>
                                        <div class="form-group">
                                            <select required="" name="customerName" <?php if(!empty($record)){?> readonly <?php }?> class="chosen-select"  id="customerName">
                                                <option value="">Select Customer</option>
                                                <?php foreach($customers as $customer):?>
                                                    <option <?php if(!empty($records)){ if($records[0]->customer_id == $customer->customer_id) {?> selected <?php }}?> value="<?php echo $customer->customer_id;?>"><?php echo $customer->customer_name;?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <!--<label>Advance</label>-->
                                        <input type="hidden" name="advanceAmount" id="advance" placeholder="Advance" class="form-control">
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Credit Balance</label>
                                        <input type="text" name="creditBalance" required="" id="creditBalance" placeholder="Credit Balance" readonly="" class="form-control">
                                    </div>

                                    
                                    <div class="col-lg-3">
                                        <label>Balance</label>
                                        <input type="text" name="balanceAmount" id="balAmt" readonly="" placeholder="Balance" class="form-control">
                                        <input type="hidden" name="balanceAmountOld" id="oldbalAmt" readonly="" placeholder="Balance" class="form-control">
                                         <input type="hidden" name="creditAmountOld" id="oldcreditAmt" readonly="" placeholder="Credit" class="form-control">
                                        <input type="hidden" name="recpt_no" value="<?php echo $receipt_no;?>">
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-sm-10">&nbsp;</div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="col-lg-2" id="">
                                        <label>Payment Mode</label>
                                        <select name="paymentMode" class="chosen-select" style="width: 120px;" id="paymentMode">
                                                <option value="">Select Mode of Payment</option>
                                                    <option value="cash">Cash</option>
                                                    <option value="cheque">Cheque</option>
                                            </select>
                                    </div>
                                    <div class="col-lg-2" id="bankName" style="display: none;">
                                        <label>Bank Name</label>
                                        <input type="text" name="bankName" placeholder="Bank Name" class="form-control">
                                    </div>

                                    <div class="col-lg-2" id="branchName" style="display: none;">
                                        <label>Branch</label>
                                        <input type="text" name="branchName" placeholder="Branch Name" class="form-control">
                                    </div>
                                    <div class="col-lg-2" id="chequeNumber" style="display: none;">
                                        <label>Cheque Number</label>
                                        <input type="text" name="chequeNumber" placeholder="Cheque Number" class="form-control">
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Purchase Date</label>
                                        <button class="btn btn-outline btn-info  dim" id="date" type="button">Edit</button>
                                        <div class="form-group" id="data_1" style="display: none;">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="purchaseDate" class="form-control">
                                            </div>
                                        </div>
                                        <button class="btn btn-outline btn-info  dim" style="display: none;" id="hide-date" type="button">Hide</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10">&nbsp;</div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="col-lg-2">
                                        <label>Work Site</label>
                                        <input type="text" name="workSite" placeholder="Work Site" class="form-control">
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Vehicle Number</label>
                                        <input type="text" name="vehicleNumber" placeholder="Vehicle Number" class="form-control">
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <br><hr>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-lg-3 pull-right">
                                        <div class="form-group">
                                            <label></label><br/>
                                            <button type="button" class="btn btn-outline btn-warning dim " id="addMore">Add More</button>
                                        </div>
                                    </div>
                            </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="col-lg-2">
                                            <label>Category</label> 
                                            <select name="categoryName[]" class="form-control" required="" id="category">
                                                <option value="">Please Select</option>
                                                <?php foreach($categories as $category):?>
                                                    <option value="<?php echo $category->category_id;?>"><?php echo ucwords($category->category_name);?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Product</label> 
                                            <select name="productName[]" class="form-control" required="" id="product">
                                                <option value="">Please Select</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Quantity</label> 
                                            <input type="text" name="productQuantity[]" id="quantity" class="form-control quantity">
                                        </div>
                                        <!-- <div class="col-lg-2">
                                            <label>Rate</label> 
                                            <input type="text" name="ratePerItem[]" id="ratePerItem" class="form-control ratePerItem">
                                        </div> -->
                                        <div class="col-lg-2">
                                            <label>Total</label> 
                                            <input type="text" name="productRate[]" id="rate" placeholder="Rate"  class="form-control rate">
                                        </div>
                                        
                                    </div>

                                </div>
                            </div>  
                            <div>
                                <br>
                            </div>
                                <div style="margin-bottom: 40px;">
                                <div class="col-lg-10">
                                    <div class="form-group ">
                                        <div class="col-lg-6">
                                                
                                        </div>
                                        <label class="col-lg-2 control-label">Gross Total</label>
                                            <div class="col-lg-3">
                                                <input type="text" name="totalAmount" readonly="" id="totalAmount" value="<?php echo $record->TotalAmount;?>" placeholder="Total" class="form-control">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-2">
                                        <label>Total</label>
                                        <input type="text" name="totalAmount" readonly="" id="totalAmount" value="<?php echo $record->TotalAmount;?>" placeholder="Total" class="form-control">
                                    </div> -->
                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Save</strong></button>
                                </div>     
                            
                            </form>
                             <!--  -->
                        </div>
            </div>
    </div>
</div>

