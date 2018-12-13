<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Branches</h2>
                    <a href="<?php echo base_url('branches');?>"><button class="btn btn-outline btn-info  dim" type="button">Branch List</button></a>
                    <a href="<?php echo base_url('branches/add');?>"><button class="btn btn-outline btn-success  dim active" type="button">Add New Branch</button></a>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>New Brranch</h5>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" method="post" action="<?php echo base_url('branches/add');?>" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-lg-2 control-label">Branch Name</label>
                                    <div class="col-lg-6">
                                        <?php if(form_error('branchName') != ''){?>
                                        <div class="form-group has-error">
                                        <?php }?>
                                            <input type="text" name="branchName" placeholder="Branch Name" value="<?php echo set_value('branchName');?>" class="form-control"> 
                                        <?php if(form_error('branchName') != ''){?>
                                            <span class="help-block m-b-none"><?php echo form_error('branchName');?></span>
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