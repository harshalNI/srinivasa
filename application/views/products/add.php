<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Products</h2>
                    <a href="<?php echo base_url('categories/add');?>"><button class="btn btn-outline btn-success  dim" type="button">Add New Category</button></a>
                    <a href="<?php echo base_url('categories');?>"><button class="btn btn-outline btn-info  dim" type="button">Category List</button></a>
                    <a href="<?php echo base_url('categories/products');?>"><button class="btn btn-outline btn-success  dim" type="button">Product List</button></a>
                    <a href="<?php echo base_url('categories/products/add');?>"><button class="btn btn-outline btn-info  dim active" type="button">Add New Product</button></a>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>New Product</h5>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" method="post" action="<?php echo base_url('categories/products/add');?>" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-lg-2 control-label">Category Name</label>
                                    <div class="col-lg-6">
                                        <?php if(form_error('categoryName') != ''){?>
                                        <div class="form-group has-error">
                                        <?php }?>
                                            <select name="categoryName" class="form-control">
                                                <option value="">Please Select</option>
                                                <?php foreach($categories as $category):?>
                                                    <option value="<?php echo $category->category_id;?>"><?php echo ucwords($category->category_name);?></option>
                                                <?php endforeach;?>
                                            </select>
                                        <?php if(form_error('categoryName') != ''){?>
                                            <span class="help-block m-b-none"><?php echo form_error('categoryName');?></span>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-lg-2 control-label">Product Name</label>
                                    <div class="col-lg-6">
                                        <?php if(form_error('productName') != ''){?>
                                        <div class="form-group has-error">
                                        <?php }?>
                                            <input type="text" name="productName" placeholder="Product Name" value="<?php echo set_value('productName');?>" class="form-control"> 
                                        <?php if(form_error('productName') != ''){?>
                                            <span class="help-block m-b-none"><?php echo form_error('productName');?></span>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-lg-2 control-label">Quantity</label>
                                    <div class="col-lg-6">
                                    <?php if(form_error('productQuantity') != ''){?>
                                        <div class="form-group has-error">
                                    <?php }?>
                                            <input type="text" placeholder="Quantity" name="productQuantity" value="<?php echo set_value('productQuantity');?>" class="form-control"> 
                                        <?php if(form_error('productQuantity') != ''){?>
                                            <span class="help-block m-b-none"><?php echo form_error('productQuantity');?></span>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>

                                <div class="form-group"><label class="col-lg-2 control-label">Measure</label>
                                    <div class="col-lg-6">
                                    <?php if(form_error('productMeasure') != ''){?>
                                        <div class="form-group has-error">
                                    <?php }?>
                                            <input type="text" name="productMeasure" placeholder="Measure" class="form-control">
                                    <?php if(form_error('productMeasure') != ''){?>
                                            <span class="help-block m-b-none"><?php echo form_error('productMeasure');?></span>
                                        </div>
                                    <?php }?>
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