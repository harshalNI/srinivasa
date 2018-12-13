<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Users</h2>
                    <a href="<?php echo base_url('users/add');?>"><button class="btn btn-outline btn-success  dim" type="button">Add New User</button></a>
                    <a href="<?php echo base_url('users');?>"><button class="btn btn-outline btn-info  dim active" type="button">List</button></a>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Users List</h5>
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
                    <?php $sr = 1; foreach($users as $user):?>
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
                            <a href="<?php echo base_url('users/edit/'.$user->user_id);?>"><button class="btn btn-outline btn-info  dim" type="button">Edit </button></a>
                            <button class="btn btn-outline btn-danger dim delete_user" type="button">Delete </button>
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