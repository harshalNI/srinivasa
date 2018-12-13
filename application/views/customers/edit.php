<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Customers</h2>
                    <a href="<?php echo base_url('customers/add');?>"><button class="btn btn-outline btn-success  dim" type="button">Add New Customer</button></a>
                    <a href="<?php echo base_url('customers');?>"><button class="btn btn-outline btn-info  dim active" type="button">List</button></a>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Update Customer</h5>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" method="post" action="<?php echo base_url('customers/edit/'.$customer_info->customer_id);?>" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-lg-2 control-label">Customer Name</label>
                                    <div class="col-lg-6">
                                        <?php if(form_error('customerName') != ''){?>
                                        <div class="form-group has-error">
                                        <?php }?>
                                            <input type="text" name="customerName" placeholder="Customer Name" value="<?php echo $customer_info->customer_name;?>" class="form-control"> 
                                        <?php if(form_error('customerName') != ''){?>
                                            <span class="help-block m-b-none"><?php echo form_error('customerName');?></span>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-lg-2 control-label">Contact Number</label>
                                    <div class="col-lg-6">
                                    <?php if(form_error('customerContactNo') != ''){?>
                                        <div class="form-group has-error">
                                    <?php }?>
                                            <input type="text" placeholder="Contact Number" name="customerContactNo" value="<?php echo $customer_info->customer_contactno;?>" class="form-control"> 
                                        <?php if(form_error('customerContactNo') != ''){?>
                                            <span class="help-block m-b-none"><?php echo form_error('customerContactNo');?></span>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>

                                 <div class="form-group"><label class="col-lg-2 control-label">Balance</label>
                                    <div class="col-lg-6">
                                            <input type="text" placeholder="Credit Balance" name="customerCreditBalance" value="<?php echo $customer_info->bal_amount;?>" class="form-control"> 
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-6">
                                        <input type="submit" name="Save" value="Save" class="btn btn-sm btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
                
            </div>
        </div>