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
                        <h5>Customers List</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th></th>
                        <th>Customer Name</th>
                        <th>Contact Number</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sr = 1; foreach($customers as $customer):?>
                    <tr class="gradeX" id="<?php echo $customer->customer_id;?>">
                        <td><?php echo $sr;?></td>
                        <td><?php echo ucwords($customer->customer_name);?></td>
                        <td><?php echo $customer->customer_contactno;?></td>
                        <td colspan="2">
                           <a href="<?php echo base_url('customers/edit/'.$customer->customer_id);?>"><button class="btn btn-outline btn-info  dim" type="button">Edit </button></a>
                                    <button class="btn btn-outline btn-danger dim delete_customer" type="button">Delete </button>
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