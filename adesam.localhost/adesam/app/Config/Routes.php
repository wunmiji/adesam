<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);


$routes->get('/', 'Home::index');
$routes->get('logout', 'Home::logout');

$routes->group('occasions', static function ($routes) {
    $routes->get('/', 'Occasion::index');
    $routes->get('tags', 'Occasion::tags');
    $routes->get('tags/(:segment)', 'Occasion::tagList/$1');
    $routes->get('(:segment)', 'Occasion::details/$1');
    $routes->post('(:segment)/comments', 'Occasion::comments/$1');
    $routes->get('(:segment)/comments/(:segment)/remove', 'Occasion::removeComment/$1/$2');
});

$routes->group('shop', static function ($routes) {
    $routes->get('/', 'Shop::index');
    $routes->get('categories', 'Shop::categories');
    $routes->get('categories/(:segment)', 'Shop::categoryList/$1');
    $routes->get('tags', 'Shop::tags');
    $routes->get('tags/(:segment)', 'Shop::tagList/$1');
    $routes->get('(:num)', 'Shop::details/$1');
    $routes->post('(:num)', 'Shop::enquiry/$1');
    $routes->get('(:num)/remove', 'Shop::removeCart/$1');
    $routes->get('cart', 'Shop::cart');
    $routes->post('cart', 'Shop::saveCart');
    $routes->post('update-cart', 'Shop::updateCart');
    $routes->get('cart/empty-cart', 'Shop::emptyCart/$1');
    $routes->get('checkout', 'Shop::checkout', ['filter' => 'authenticate']);
    $routes->post('checkout', 'Shop::saveCheckout', ['filter' => 'authenticate']);
});

$routes->group('about', static function ($routes) {
    $routes->get('/', 'About::index');
});

$routes->group('contact', static function ($routes) {
    $routes->get('/', 'Contact::index');
    $routes->post('/', 'Contact::send');
});

$routes->group('privacy', static function ($routes) {
    $routes->get('/', 'Privacy::index');
});

$routes->group('terms', static function ($routes) {
    $routes->get('/', 'Terms::index');
});

$routes->group('user', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'User::index');
    $routes->post('/', 'User::saveUpdate');
});

$routes->group('search', static function ($routes) {
    $routes->match(['GET', 'POST'], '/', 'Search::index');
});

$routes->group('login', ['filter' => 'authenticated'], static function ($routes) {
    $routes->get('/', 'Login::index');
    $routes->post('/', 'Login::login');
});

$routes->group('register', ['filter' => 'authenticated'], static function ($routes) {
    $routes->get('/', 'Register::index');
    $routes->post('/', 'Register::register');
});

$routes->group('forget-password', ['filter' => 'authenticated'], static function ($routes) {
    $routes->get('/', 'ForgetPassword::index');
    $routes->post('/', 'ForgetPassword::send');
});

$routes->group('reset-password', ['filter' => 'authenticated'], static function ($routes) {
    $routes->get('/', 'ResetPassword::index');
    $routes->post('/', 'ResetPassword::send');
});



$routes->set404Override('App\Controllers\Errors::show404');





