<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Users</h2>
                    <a href="<?php echo base_url('users/add');?>"><button class="btn btn-outline btn-success  dim active" type="button">Add New User</button></a>
                    <a href="<?php echo base_url('users');?>"><button class="btn btn-outline btn-info  dim" type="button">List</button></a>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>New User</h5>
                        </div>
                        <div class="ibox-content">
                            <form class="form-horizontal" method="post" action="<?php echo base_url('users/add');?>" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-lg-2 control-label">First Name</label>
                                    <div class="col-lg-6">
                                        <?php if(form_error('firstName') != ''){?>
                                        <div class="form-group has-error">
                                        <?php }?>
                                            <input type="text" name="firstName" placeholder="First Name" value="<?php echo set_value('firstName');?>" class="form-control"> 
                                        <?php if(form_error('firstName') != ''){?>
                                            <span class="help-block m-b-none"><?php echo form_error('firstName');?></span>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-lg-2 control-label">Last Name</label>
                                    <div class="col-lg-6">
                                        <?php if(form_error('lastName') != ''){?>
                                        <div class="form-group has-error">
                                        <?php }?>
                                            <input type="text" name="lastName" placeholder="Last Name" value="<?php echo set_value('lastName');?>" class="form-control"> 
                                        <?php if(form_error('lastName') != ''){?>
                                            <span class="help-block m-b-none"><?php echo form_error('lastName');?></span>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-lg-2 control-label">Username</label>
                                    <div class="col-lg-6">
                                    <?php if(form_error('userName') != ''){?>
                                        <div class="form-group has-error">
                                    <?php }?>
                                            <input type="text" placeholder="Username" name="userName" value="<?php echo set_value('username');?>" class="form-control"> 
                                        <?php if(form_error('userName') != ''){?>
                                            <span class="help-block m-b-none"><?php echo form_error('userName');?></span>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>

                                <div class="form-group"><label class="col-lg-2 control-label">Password</label>
                                    <div class="col-lg-6">
                                    <?php if(form_error('password') != ''){?>
                                        <div class="form-group has-error">
                                    <?php }?>
                                            <input type="password" name="password" placeholder="Password" class="form-control">
                                    <?php if(form_error('password') != ''){?>
                                            <span class="help-block m-b-none"><?php echo form_error('password');?></span>
                                        </div>
                                    <?php }?>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-lg-2 control-label">Role</label>
                                    <div class="col-lg-6">
                                    <?php if(form_error('roleName') != ''){?>
                                        <div class="form-group has-error">
                                    <?php }?>
                                        <select name="roleName" class="form-control">
                                            <option value="">Please Select</option>
                                            <?php foreach($roles as $role):?>
                                                <option value="<?php echo $role->role_id;?>"><?php echo ucwords($role->role_name);?></option>
                                            <?php endforeach;?>
                                        </select>
                                    <?php if(form_error('roleName') != ''){?>
                                            <span class="help-block m-b-none"><?php echo form_error('roleName');?></span>
                                        </div>
                                    <?php }?>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-lg-2 control-label">Contact Number</label>
                                    <div class="col-lg-6">
                                    <?php if(form_error('contactNumber') != ''){?>
                                        <div class="form-group has-error">
                                    <?php }?>
                                        <input type="text" name="contactNumber" value="<?php echo set_value('contactNumber');?>" placeholder="Contact Number" class="form-control"> 
                                       <?php if(form_error('contactNumber') != ''){?>
                                            <span class="help-block m-b-none"><?php echo form_error('contactNumber');?></span>
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