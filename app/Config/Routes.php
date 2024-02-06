<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Landingpage::index');
$routes->get('/form', 'Home::index');
$routes->post('/upload', 'Home::uploadData');

$routes->get('/dashboard', 'admin\Dashboard::index');
$routes->get('/class', 'admin\Dashboard::class');
$routes->get('/booking', 'admin\Dashboard::booking');
$routes->get('booking/delete/(:num)', 'admin\Dashboard::deleteBooking/$1');
$routes->get('/affiliate', 'admin\Dashboard::affiliate');
$routes->get('/customers', 'admin\Dashboard::customers');
$routes->get('/bank', 'admin\Dashboard::bank');

$routes->post('downloadPdf', 'admin\Dashboard::downloadPdf');

$routes->match(['get', 'post'], 'action_booking', 'admin\Dashboard::action_booking');

$routes->match(['get', 'post'], 'auth', 'admin\Auth::index');
$routes->match(['get', 'post'], 'logout', 'admin\Dashboard::logout');

$routes->group('setting', function($routes) {
    $routes->get('/', 'admin\Dashboard::identity');
    $routes->match(['get', 'post'], 'create', 'Landingpage::createIdentity');
    $routes->match(['get', 'post'], 'update/(:num)', 'Landingpage::updateIdentity/$1');
    $routes->get('delete/(:num)', 'Landingpage::deleteIdentity/$1');
});


$routes->group('api', function($routes)
{
    $routes->group('users', function($routes)
    {
        $routes->get('/', 'api\UserController::index'); // Untuk menampilkan semua user
        $routes->post('create', 'api\UserController::create'); // Untuk membuat user baru
        $routes->put('update/(:num)', 'api\UserController::update/$1'); // Untuk memperbarui user berdasarkan ID
        $routes->delete('delete/(:num)', 'api\UserController::delete/$1'); // Untuk menghapus user berdasarkan ID
        $routes->get('readByUsername/(:alphanum)', 'api\UserController::readByUsername/$1'); // Untuk menampilkan user berdasarkan username
    });

    $routes->group('class', function($routes)
    {
        $routes->get('/', 'api\ClassesController::index'); // Untuk menampilkan semua class
        $routes->get('show/(:num)', 'api\ClassesController::show/$1'); // Untuk menampilkan class berdasarkan ID
        $routes->post('create', 'api\ClassesController::create'); // Untuk membuat class baru
        $routes->put('update/(:num)', 'api\ClassesController::update/$1'); // Untuk memperbarui class berdasarkan ID
        $routes->put('close/(:num)', 'api\ClassesController::delete/$1'); // Untuk menutup class berdasarkan ID (mengganti status menjadi "closed")
    });

    $routes->group('bank', function($routes)
    {
        $routes->get('/', 'api\BankAccountController::index'); // Untuk menampilkan semua data bank_account
        $routes->post('create', 'api\BankAccountController::create'); // Untuk membuat data bank_account baru
        $routes->put('update/(:num)', 'api\BankAccountController::update/$1'); // Untuk memperbarui data bank_account berdasarkan ID
        $routes->delete('delete/(:num)', 'api\BankAccountController::delete/$1'); // Untuk menghapus data bank_account berdasarkan ID
    });
});