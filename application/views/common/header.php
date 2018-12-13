<!DOCTYPE html>
<html >

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Admin</title>

    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/chosen/chosen.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/colorpicker/bootstrap-colorpicker.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/datapicker/datepicker3.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/sweetalert/sweetalert.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/dropzone/basic.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/dropzone/dropzone.css');?>" rel="stylesheet">
    <!-- Toastr style -->
    <link href="<?php echo base_url('assets/css/plugins/toastr/toastr.min.css');?>" rel="stylesheet">

    <!-- Gritter -->
    <link href="<?php echo base_url('assets/js/plugins/gritter/jquery.gritter.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/iCheck/custom.css');?>" rel="stylesheet">

    <link href="<?php echo base_url('assets/css/plugins/steps/jquery.steps.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/animate.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/summernote/summernote.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/plugins/summernote/summernote-bs3.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <!-- <img alt="image" class="img-circle" src="<?php echo base_url('assets');?>/img/profile_small.jpg" /> -->
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo ucfirst($this->session->userdata['name']).' ('.ucfirst($this->session->userdata['role']). ')';?></strong>
                            </span> <span class="text-muted text-xs block">Settings <b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="<?php echo base_url('users/changepassword');?>">Change Password</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url('users/logout');?>">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            BT
                        </div>
                    </li>
                    <li <?php if(uri_string() == ''){ ?> class="active" <?php }?>>
                        <a href="<?php echo base_url('');?>" title="Dashboard"><i class="fa fa-diamond"></i> <span class="nav-label">Dashboard</span></a>
                    </li>
                    <li <?php if(uri_string() == 'customers' || uri_string() == 'customers/add'){ ?> class="active" <?php }?>>
                       <a href="<?php echo base_url('customers/add');?>" title="Customers"> <i class="fa fa-group"></i> <span class="nav-label">Customer</span></a>
                    </li>
                    
                    <li <?php if(uri_string() == 'categories' || uri_string() == 'categories/add' || uri_string() == 'categories/products' || uri_string() == 'categories/products/add'){ ?> class="active" <?php }?>>
                       <a href="<?php echo base_url('categories/products');?>" title="Stock Management"> <i class="fa fa-cogs"></i> <span class="nav-label">Stock Management</span> </a>
                    </li>
                    <li <?php if(uri_string() == 'sales' || uri_string() == 'sales/add' || strpos(uri_string(), 'order/details') !== false){ ?> class="active" <?php }?>>
                       <a href="<?php echo base_url('sales/add');?>" title="Sales"> <i class="fa fa-exchange"></i> <span class="nav-label">Sales</span></a>
                    </li>
                    <li <?php if(uri_string() == 'payments' || uri_string() == 'payments/add'){ ?> class="active" <?php }?>>
                       <a href="<?php echo base_url('payments');?>" title="Payments"> <i class="fa fa-money"></i> <span class="nav-label">Payments</span></a>
                    </li>
                    <li <?php if(uri_string() == 'users' || uri_string() == 'users/add'){ ?> class="active" <?php }?>>
                       <a href="<?php echo base_url('users/add');?>" title="Users"> <i class="fa fa-user"></i> <span class="nav-label">Users</span> </a>
                    </li>
                    <!-- <li <?php if(uri_string() == 'branches'){ ?> class="active" <?php }?>>
                       <a href="<?php echo base_url('branches');?>"> <i class="fa fa-edit"></i> <span class="nav-label">Branches</span> </a>
                    </li>
                    <li <?php if(uri_string() == 'branch/users'){ ?> class="active" <?php }?>>
                       <a href="<?php echo base_url('branch/users');?>"> <i class="fa fa-edit"></i> <span class="nav-label">Branch Users</span> </a>
                    </li> -->
                    <li <?php if(uri_string() == 'reports/customer'){ ?> class="active" <?php }?>>
                       <a href="<?php echo base_url('reports/customer');?>" title="Report"> <i class="fa fa-edit"></i> <span class="nav-label">Customer Report</span> </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="row">
            <div class="col-lg-12">
            <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome to Admin.</span>
                </li>
                
                <li>
                    <a href="<?php echo base_url('users/logout');?>">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('users/changepassword');?>" title="Change Password" class="right-sidebar-toggle">
                        <i class="fa fa-tasks"></i>
                    </a>
                </li>
            </ul>

        </nav>
        </div>