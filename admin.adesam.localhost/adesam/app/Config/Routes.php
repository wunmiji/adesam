<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);


$routes->get('/', 'Home::index', ['filter' => 'authenticated']);
$routes->post('/', 'Home::login', ['filter' => 'authenticated']);

$routes->group('forget-password', ['filter' => 'authenticated'], static function ($routes) {
    $routes->get('/', 'ForgetPassword::index');
    $routes->post('/', 'ForgetPassword::send');
});

$routes->group('reset-password', ['filter' => 'authenticated'], static function ($routes) {
    $routes->get('/', 'ResetPassword::index');
    $routes->post('/', 'ResetPassword::send');
});

$routes->get('logout', 'Dashboard::logout');

$routes->group('dashboard', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'Dashboard::index');
});

$routes->group('settings', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'Settings::index');
    $routes->post('/', 'Settings::update');
});

$routes->group('family', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'Family::index');
    $routes->get('create', 'Family::create');
    $routes->post('create', 'Family::store');
    $routes->get('(:segment)', 'Family::details/$1');
    $routes->get('(:segment)/update', 'Family::edit/$1');
    $routes->get('(:segment)/update_password', 'Family::editPassword/$1');
    $routes->get('(:segment)/social-media', 'Family::editSocialMedia/$1');
    $routes->post('(:segment)/update', 'Family::update/$1');
    $routes->post('(:segment)/update_password', 'Family::updatePassword/$1');
    $routes->post('(:segment)/social-media', 'Family::updateSocialMedia/$1');
});

$routes->group('contacts', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'Contact::index');
    $routes->get('create', 'Contact::create');
    $routes->post('create', 'Contact::store');

    $routes->get('tags', 'Contact::tags');
    $routes->post('tags/create', 'Contact::storeTag');
    $routes->get('tags/(:segment)/delete', 'Contact::tagDelete/$1');

    $routes->get('(:segment)', 'Contact::details/$1');
    $routes->get('(:segment)/update', 'Contact::edit/$1');
    $routes->post('(:segment)/update', 'Contact::update/$1');
    $routes->get('(:segment)/delete', 'Contact::delete/$1');
});

$routes->group('file-manager', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'FileManager::index');
    $routes->get('(:segment)', 'FileManager::indexAdesam/$1');
    $routes->get('(:segment)/create-folder', 'FileManager::createFolder/$1');
    $routes->post('(:segment)/create-folder', 'FileManager::storeFolder/$1');
    $routes->get('(:segment)/create-file', 'FileManager::createFile/$1');
    $routes->post('(:segment)/create-file', 'FileManager::storeFile/$1');
    $routes->post('(:segment)/rename', 'FileManager::renameFile/$1');
    $routes->get('(:segment)/download', 'FileManager::downloadFile/$1');
    $routes->get('(:segment)/delete-folder', 'FileManager::deleteFolder/$1');
    $routes->get('(:segment)/delete-file', 'FileManager::deleteFile/$1');
    $routes->get('(:segment)/update-folder', 'FileManager::editFolder/$1');
    $routes->post('(:segment)/update-folder', 'FileManager::updateFolder/$1');
    $routes->get('(:segment)/favourite', 'FileManager::favourite/$1');
    $routes->get('(:segment)/trash', 'FileManager::trash/$1');
    $routes->get('(:segment)/restore', 'FileManager::trash/$1');
    $routes->get('(:segment)/delete', 'FileManager::delete/$1');
});

$routes->group('occasions', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'Occasion::index');
    $routes->get('create', 'Occasion::create');
    $routes->post('create', 'Occasion::store');

    $routes->get('jobs', 'Occasion::jobs');

    $routes->get('tags', 'Occasion::tags');
    $routes->post('tags/create', 'Occasion::storeTag');
    $routes->get('tags/(:segment)/delete', 'Occasion::tagDelete/$1');

    $routes->get('(:segment)', 'Occasion::details/$1');
    $routes->get('(:segment)/delete', 'Occasion::delete/$1');
    $routes->get('(:segment)/update', 'Occasion::edit/$1');
    $routes->post('(:segment)/update', 'Occasion::update/$1');
});

$routes->group('calendar', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'Calendar::index');
    $routes->get('create', 'Calendar::create');
    $routes->post('create', 'Calendar::store');
    $routes->get('(:segment)', 'Calendar::date/$1');
    $routes->get('(:segment)/(:segment)', 'Calendar::details/$1/$2');
    $routes->get('(:segment)/(:segment)/delete', 'Calendar::delete/$1/$2');
    $routes->get('(:segment)/(:segment)/update', 'Calendar::edit/$1/$2');
    $routes->post('(:segment)/(:segment)/update', 'Calendar::update/$1/$2');
});

$routes->group('category', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'Category::index');
    $routes->get('create', 'Category::create');
    $routes->post('create', 'Category::store');
    $routes->get('(:segment)', 'Category::details/$1');
    $routes->get('(:segment)/delete', 'Category::delete/$1');
    $routes->get('(:segment)/update', 'Category::edit/$1');
    $routes->post('(:segment)/update', 'Category::update/$1');
});

$routes->group('products', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'Product::index');
    $routes->get('create', 'Product::create');
    $routes->post('create', 'Product::store');

    $routes->get('tags', 'Product::tags');
    $routes->post('tags/create', 'Product::storeTag');
    $routes->get('tags/(:segment)/delete', 'Product::tagDelete/$1');

    $routes->get('discounts', 'Product::discounts');
    $routes->post('discounts/create', 'Product::storeDiscount');
    $routes->get('discounts/(:segment)/delete', 'Product::discountDelete/$1');

    $routes->get('(:segment)', 'Product::details/$1');
    $routes->get('(:segment)/update', 'Product::edit/$1');
    $routes->post('(:segment)/update', 'Product::update/$1');
    $routes->get('(:segment)/delete', 'Product::delete/$1');
});

$routes->group('orders', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'Order::index');
    $routes->get('(:segment)', 'Order::details/$1');
    $routes->get('(:segment)/delete', 'Order::delete/$1');
    $routes->post('(:segment)/create-cash-payment', 'Order::createCashPayment/$1');
});

$routes->group('users', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'User::index');
    $routes->get('(:segment)', 'User::details/$1');
});



$routes->set404Override('App\Controllers\Errors::show404');



