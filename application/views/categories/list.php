<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Categories</h2>
                    <a href="<?php echo base_url('categories/add');?>"><button class="btn btn-outline btn-success  dim" type="button">Add New Category</button></a>
                    <a href="<?php echo base_url('categories');?>"><button class="btn btn-outline btn-info  dim active" type="button">Category List</button></a>
                    <a href="<?php echo base_url('categories/products');?>"><button class="btn btn-outline btn-success  dim" type="button">Product List</button></a>
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
                        <h5>Category List</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th class="noExport">Status</th>
                        <th class="noExport"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sr = 1; foreach($categories as $category):?>
                    <tr class="gradeX" id="<?php echo $category->category_id;?>">
                        <td><?php echo $sr;?></td>
                        <td><?php echo $category->category_name;?></td>
                        <td>
                            <?php if($category->category_is_active == 1){?>
                                <button class="btn btn-outline btn-warning  dim deactivate_category" type="button">Deactivate </button>
                            <?php }else{?>
                                <button class="btn btn-outline btn-success  dim activate_category" type="button">Activate </button>
                            <?php }?>
                        </td>
                        <td colspan="2">
                            <a href="<?php echo base_url('categories/edit/'.$category->category_id);?>"><button class="btn btn-outline btn-info  dim" type="button">Edit </button></a>
                            <button class="btn btn-outline btn-danger dim delete_category" type="button">Delete </button>
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