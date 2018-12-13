<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Branches</h2>
                    <a href="<?php echo base_url('branches');?>"><button class="btn btn-outline btn-info  dim active" type="button">Branch List</button></a>
                    <a href="<?php echo base_url('branches/add');?>"><button class="btn btn-outline btn-success  dim" type="button">Add New Branch</button></a>
                    
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Branch List</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sr = 1; foreach($branches as $branch):?>
                    <tr class="gradeX" id="<?php echo $branch->branch_id;?>">
                        <td><?php echo $sr;?></td>
                        <td><?php echo $branch->branch_name;?></td>
                        <td>
                            <?php if($branch->branch_is_active == 1){?>
                                <button class="btn btn-outline btn-warning  dim deactivate_branch" type="button">Deactivate </button>
                            <?php }else{?>
                                <button class="btn btn-outline btn-success  dim activate_branch" type="button">Activate </button>
                            <?php }?>
                        </td>
                        <td colspan="2">
                            <a href="<?php echo base_url('branches/edit/'.$branch->branch_id);?>"><button class="btn btn-outline btn-info  dim" type="button">Edit </button></a>
                            <button class="btn btn-outline btn-danger dim delete_branch" type="button">Delete </button>
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