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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'main';

$route['blogs/(:any)'] = 'blog/slugData/$1';
$route['category/(:any)/(:num)'] = 'blog/categoryData/$1/$2';
$route['category/(:any)'] = 'blog/categoryData/$1';
$route['testing'] = 'blog/testing';
$route['privious'] = 'blog/previosData';
$route['blogs'] = "blog/index";
$route['moreBlogs'] = "blog/more_any_blogs";

// Faq
$route['faqs'] = 'main/faq';

// Cart
$route['add-to-cart'] = 'cart/add_to_cart';
$route['checkout'] = 'cart/checkout';
$route['remove-cart-prod'] = "Cart_controller/remove_prod";
// package
$route['buy-tiktok-(:any)'] = 'main/package/$1';
$route['package_data'] = 'main/package_getdata';
$route['buy-(:num)-tiktok-(:any)'] = 'main/purchase_package/$1/$2';

// buy now
$route['get_tiktokuser_data'] = 'main/get_user_data_api';
$route['find'] = 'main/request';
$route['comments'] = 'main/comment_section';


$route['about-us'] = 'main/aboutus';
$route['apply_copon'] = 'main/apply_coppen';
$route['subcribe_for_news'] = 'main/subcribe_for_new';

/*cart Stripe related urls */
$route['setCartProductSetting'] = 'cart/setStripeCartSession';
$route['sessionstripeCart'] = 'cart/sessionstripeCart';

// Invoice Page after successfully completed order.
$route['successpayment/(:num)'] = 'Order/successInvoice/$1';
$route['multi_order_success/(:num)'] = 'Order/multiOrderSuccessInvoice/$1';
////////tracking order////////////////////////////
$route['tracking'] = 'Order/trackOrder';
$route['tracking/(:num)'] = 'Order/trackOrder/$1';
$route['track-order'] = 'Order/trackOldOrder';
$route['track-order/(:num)'] = 'Order/trackOldOrder/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
