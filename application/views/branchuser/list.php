<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Branch Admin Users</h2>
                    <a href="<?php echo base_url('branch/users');?>"><button class="btn btn-outline btn-success  dim active" type="button">List</button></a>
                    <a href="<?php echo base_url('branch/users/add');?>"><button class="btn btn-outline btn-info  dim " type="button">Add New User</button></a>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox-content">
                    <div class="row">
                        <form role="form" method="post" action="<?php echo base_url('branch/users');?>">
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <div class="col-lg-3">
                                        <label>Branch</label>
                                        <div class="form-group">
                                            <select required="" name="branchName" class="chosen-select">
                                                <option value="">Select Customer</option>
                                                <?php foreach($branches as $branch):?>
                                                    <option <?php if(!empty($users) && $users[0]->user_branch_id == $branch->branch_id){?> selected <?php }?> value="<?php echo $branch->branch_id;?>"><?php echo $branch->branch_name;?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    

                                    <div class="col-lg-2">
                                        <label></label><br/>
                                        <input type="submit" value="submit" name="submit" class="btn btn-outline btn-primary dim">
                                    </div>
                                    
                                </div>
                            </div>
                            </form>
                    </div>
                </div>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Branch <small>Admin user</small></h5>
                        <?php if(isset($users) && !empty($users)){?>
                        <div class="col-lg-2">
                            <strong>Branch Name :</strong><?php echo $users[0]->branch_name;?>
                        </div>
                    </div>
                    
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th></th>
                        <th>First Name</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Contact Number</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sr = 1; 
                        $sub_total = '';
                        foreach($users as $user)://echo"<pre>";print_r($user);exit;
                    ?>
                    <tr class="gradeX" id="<?php echo $user->user_id;?>">
                        <td><?php echo $sr;?></td>
                        <td><?php echo ucwords($user->first_name).' '.ucwords($user->last_name);?></td>
                        <td><?php echo $user->username;?></td>
                        <td><?php echo ucwords($user->role_name);?></td>
                        <td><?php echo $user->contact_no;?></td>
                        <td>
                            <?php if($user->user_is_active == 1){?>
                                <button class="btn btn-outline btn-warning  dim deactivate_user" type="button">Deactivate </button>
                            <?php }else{?>
                                <button class="btn btn-outline btn-success  dim activate_user" type="button">Activate </button>
                            <?php }?>
                        </td>
                        <td colspan="2">
                            <a href="<?php echo base_url('branch/users/edit/'.$user->user_id);?>"><button class="btn btn-outline btn-info  dim" type="button">Edit </button></a>
                            <button class="btn btn-outline btn-danger dim delete_user" type="button">Delete </button>
                        </td>
                    </tr>
                    <?php $sr++; endforeach;?>                    
                    </tbody>
                    </table>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
            </div>
        </div>