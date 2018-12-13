<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Reset Password</h2>
        <ol class="breadcrumb">
            <li>
                <a href="dashboard.html">Home</a>
            </li>
            <li class="active">
                <a>Reset Password</a>
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
                            <h5>Rest Password</h5>
                        </div>
                        <div class="ibox-content">
                        <?php if($this->session->flashdata('msg')){?>
                            <div class="alert alert-success alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <?php echo $this->session->flashdata('msg');?>
                            </div>
                        <?php }?>
                            <form class="form-horizontal" method="post" action="<?php echo base_url('users/changepassword');?>">
                                <div class="form-group"><label class="col-lg-2 control-label">Password</label>
                                    <?php if(form_error('password')){?>
                                    <div class="form-group has-error">
                                    <?php }?>
                                        <div class="col-lg-4">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                            <input type="password" name="password" value="" placeholder="Change Password" class="form-control">
                                        </div>
                                    <?php if(form_error('password')){?>
                                    </div>
                                    <div class="form-group"><label class="col-lg-2 control-label"></label>
                                    <div class="col-lg-4">
                                    <span class="help-block m-b-none" style="color:red;"><?php echo form_error('Password');?></span>
                                    </div>
                                    <?php }?>
                                </div>
                                    
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <input type="reset" class="btn btn-white" name="Cancel" value="Cancel">
                                        <input type="submit" name="Save" value="Save" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>