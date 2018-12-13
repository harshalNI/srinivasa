<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Products</h2>
                    <a href="<?php echo base_url('categories/add');?>"><button class="btn btn-outline btn-success  dim" type="button">Add New Category</button></a>
                    <a href="<?php echo base_url('categories');?>"><button class="btn btn-outline btn-info  dim" type="button">Category List</button></a>
                    <a href="<?php echo base_url('categories/products');?>"><button class="btn btn-outline btn-success  dim active" type="button">Product List</button></a>
                    <a href="<?php echo base_url('categories/products/add');?>"><button class="btn btn-outline btn-info  dim" type="button">Add New Product</button></a>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Products List</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Quantity
                            <div>(Purchased / Sold)</div>
                        </th>
                        <th>Measure</th>
                        <th>Purchased Date</th>
                        <th class="noExport">Status</th>
                        <th class="noExport"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sr = 1; foreach($products as $product):
                        $prod_name = $product->product_name;
                        $TotalQuantityPurchased = $this->Product->GetCountOfPurchasedStockByProductID($prod_name);
                    //echo"<pre>";print_r($product);exit;?>
                    <tr class="gradeX" id="<?php echo $product->product_id;?>">
                        <td><?php echo $sr;?></td>
                        <td><?php echo ucwords($product->product_name);?></td>
                        <td><?php echo ucwords($product->category_name);?></td>
                        <td><?php echo $TotalQuantityPurchased .' / '.$product->TotalQuantitySold;?></td>
                        <td><?php echo $product->product_measure;?></td>
                        <td><?php echo date('d/m/Y', strtotime($product->purchase_date));?></td>
                        <td>
                            <?php if($product->product_is_active == 1){?>
                                <button class="btn btn-outline btn-warning  dim deactivate_product" type="button">Deactivate </button>
                            <?php }else{?>
                                <button class="btn btn-outline btn-success  dim activate_product" type="button">Activate </button>
                            <?php }?>
                        </td>
                        <td colspan="2">
                            <a href="<?php echo base_url('categories/products/edit/'.$product->product_id);?>"><button class="btn btn-outline btn-info  dim" type="button">Edit </button></a>
                            <button class="btn btn-outline btn-danger dim delete_product" type="button">Delete </button>
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