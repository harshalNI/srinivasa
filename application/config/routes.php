<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['users/login'] = 'user/LoginUser';
$route['users/logout'] = 'user/LogoutUser';
$route['users/changepassword'] = 'user/ChangePassword';
$route['users'] = 'user/UserList';
$route['users/add'] = 'user/UserCreate';
$route['users/edit/(:any)'] = 'user/UserUpdate/$1';
$route['user/inactivate'] = 'user/UserDeactivate';
$route['user/activate'] = 'user/UserActivate';
$route['user/delete'] = 'user/UserDelete';
$route['categories'] = 'category/CategoryList';
$route['categories/add'] = 'category/CategoryCreate';
$route['categories/edit/(:any)'] = 'category/CategoryUpdate/$1';
$route['category/inactivate'] = 'category/CategoryDeactivate';
$route['category/activate'] = 'category/CategoryActivate';
$route['category/delete'] = 'category/CategoryDelete';
$route['categories/GetCategories'] = 'category/GetAllCategories';
$route['categories/GetAllProductsByCategory'] = 'product/GetAllProductsByCatID';
$route['categories/products'] = 'product/ProductList';
$route['categories/products/add'] = 'product/ProductCreate';
$route['categories/products/edit/(:any)'] = 'product/ProductUpdate/$1';
$route['categories/product/deactivate'] = 'product/ProductDeactivate';
$route['categories/product/activate'] = 'product/ProductActivate';
$route['categories/product/delete'] = 'product/ProductDelete';
$route['customers'] = 'customer/CustomerList';
$route['customers/add'] = 'customer/CustomerCreate';
$route['customers/edit/(:any)'] = 'customer/CustomerUpdate/$1';
$route['customers/delete'] = 'customer/CustomerDelete';
$route['sales'] = 'sales/SalesList';
$route['sales/report'] = 'sales/SalesReport';
$route['sales/add'] = 'sales/SalesCreate';
$route['sales/delete'] = 'sales/SalesDelete';
$route['sales/add-new-row'] = 'sales/AddNewRow';
$route['order/details/(:any)'] = 'sales/ViewPurchaseDetail/$1';
$route['sales/addnewrow'] = 'sales/AddNewRow';
$route['sales/GetAllProductsByCategory'] = 'sales/GetAllProductsByCatID';
$route['sales/edit/(:any)'] = 'sales/SalesUpdate/$1';
$route['sales/getTotalCreditBalance'] = 'sales/GetCreditBalanceAmount';

$route['branches'] = 'branch/BranchList';
$route['branches/add'] = 'branch/BranchCreate';
$route['branches/edit/(:any)'] = 'branch/BranchUpdate/$1';
$route['branches/deactivate'] = 'branch/BranchDeactivate';
$route['branches/activate'] = 'branch/BranchActivate';
$route['branches/delete'] = 'branch/BranchDelete';

$route['branch/users'] = 'branchuser/BranchUserList';
$route['branch/users/add'] = 'branchuser/BranchUserCreate';
$route['branch/users/edit/(:any)'] = 'branchuser/BranchUserUpdate/$1';

$route['customer/product/add'] = 'sales/CreateSaleToCustomer';
$route['payments'] = 'payment/PaymentDetails';
$route['payments/details/(:any)?'] = 'payment/PaymentDetails';
$route['payments/customers'] = 'payment/ViewCustomerPaymentDetails';
$route['payments/add'] = 'payment/AddPaymentOfCustomer';
$route['payments/view/(:any)'] = 'payment/ViewPaymentofCustomer/$1';
$route['payment/ChequeReturn'] = 'payment/ReturnChequeForPayment';
$route['payment/DeletPayment'] = 'payment/DeletePaymentDetails';

$route['print/invoice/(:any)'] = 'customer/printInvoice/$1';
$route['print/report/(:any)/(:any)/(:any)'] = 'report/printReport/$1/$2/$3';

$route['reports/customer'] = 'report/GenerateReport';
$route['404_override'] = '';
$route['payments/get-payment-details'] = 'payment/ViewPaymentDetails';
$route['translate_uri_dashes'] = FALSE;
