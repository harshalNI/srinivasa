<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Products</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url('dashboard');?>">Home</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('categories/products');?>">Product</a>
                        </li>
                        <li class="active">
                            <strong>Update</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Update Product</h5>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" method="post" action="<?php echo base_url('categories/products/edit/'.$product_info->product_id);?>" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-lg-2 control-label">Category Name</label>
                                    <div class="col-lg-6">
                                        <?php if(form_error('categoryName') != ''){?>
                                        <div class="form-group has-error">
                                        <?php }?>
                                            <select name="categoryName" class="form-control">
                                                <option value="">Please Select</option>
                                                <?php foreach($categories as $category):?>
                                                    <option <?php if($product_info->cat_id == $category->category_id){ ?> selected <?php }?> value="<?php echo $category->category_id;?>"><?php echo ucwords($category->category_name);?></option>
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
                                            <input type="text" name="productName" placeholder="Product Name" value="<?php echo $product_info->product_name;?>" class="form-control"> 
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
                                            <input type="text" placeholder="Quantity" name="productQuantity" value="<?php echo $product_info->product_quantity;?>" class="form-control"> 
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
                                            <input type="text" name="productMeasure" value="<?php echo $product_info->product_measure;?>" placeholder="Measure" class="form-control">
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