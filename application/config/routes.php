<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'home_page';

// Homepage: Product
$route['product/load_more'] = 'home_page/loadMore';
$route['cart/add_to_cart'] = 'cart/add_to_cart';
$route['cart/get_cart_items'] = 'cart/get_cart_items';
$route['cart/remove_from_cart'] = 'cart/remove_from_cart';
$route['cart/checkout'] = 'cart/checkout';

$route['checkout'] = 'checkout/index';
$route['checkout/place_order'] = 'checkout/place_order';
$route['checkout/success'] = 'checkout/success';

$route['order/history'] = 'order/history';

// Login / Register
$route['auth/register'] = 'auth/register';
$route['auth/login'] = 'auth/login';
$route['auth/logout'] = 'auth/logout';
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';

// BACKUP
$route['backoffice/backup-database'] = 'backoffice/backup';
$route['backoffice/backup-database/create'] = 'backoffice/backup/create';

$route['mail/send'] = 'mail';
$route['mail/template'] = 'mail/order';
$route['mail/invoice'] = 'mail/invoice';
$route['mail/queue'] = 'backoffice/email_processor/processQueue';
$route['404_override'] = 'err_page';
$route['translate_uri_dashes'] = FALSE;
