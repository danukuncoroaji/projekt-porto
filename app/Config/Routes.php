<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');
$routes->get('/', 'LandingController::index');

$routes->get('/app/login', 'LoginController::index');
$routes->post('/app/login', 'LoginController::loginAuth');
$routes->get('/app/logout', 'LoginController::logout');
$routes->get('/app/register', 'LoginController::register');
$routes->post('/app/register', 'LoginController::registerStore');

$routes->addRedirect('/app', '/app/beranda');
$routes->get('/app/beranda', 'BerandaController::index',['filter' => 'authGuard']);

//galeri
$routes->get('/app/galeri', 'GaleriController::index',['filter' => 'authGuard']);
$routes->get('/app/galeri/tambah', 'GaleriController::create',['filter' => 'authGuard']);
$routes->post('/app/galeri/store', 'GaleriController::store',['filter' => 'authGuard']);
$routes->get('/app/galeri/edit/(:any)', 'GaleriController::edit/$1',['filter' => 'authGuard']);
$routes->post('/app/galeri/update/(:any)', 'GaleriController::update/$1',['filter' => 'authGuard']);
$routes->get('/app/galeri/delete/(:any)', 'GaleriController::delete/$1',['filter' => 'authGuard']);

//Pembayaran
$routes->get('/app/pembayaran', 'PembayaranController::index',['filter' => 'authGuard']);
$routes->get('/app/pembayaran/tambah', 'PembayaranController::create',['filter' => 'authGuard']);
$routes->post('/app/pembayaran/store', 'PembayaranController::store',['filter' => 'authGuard']);
$routes->get('/app/pembayaran/edit/(:any)', 'PembayaranController::edit/$1',['filter' => 'authGuard']);
$routes->post('/app/pembayaran/update/(:any)', 'PembayaranController::update/$1',['filter' => 'authGuard']);
$routes->get('/app/pembayaran/delete/(:any)', 'PembayaranController::delete/$1',['filter' => 'authGuard']);

//customer
$routes->get('/app/customer', 'CustomerController::index',['filter' => 'authGuard']);
$routes->get('/app/customer/tambah', 'CustomerController::create',['filter' => 'authGuard']);
$routes->post('/app/customer/store', 'CustomerController::store',['filter' => 'authGuard']);
$routes->get('/app/customer/edit/(:any)', 'CustomerController::edit/$1',['filter' => 'authGuard']);
$routes->post('/app/customer/update/(:any)', 'CustomerController::update/$1',['filter' => 'authGuard']);
$routes->get('/app/customer/delete/(:any)', 'CustomerController::delete/$1',['filter' => 'authGuard']);

//admin
$routes->get('/app/admin', 'AdminController::index',['filter' => 'authGuard']);
$routes->get('/app/admin/tambah', 'AdminController::create',['filter' => 'authGuard']);
$routes->post('/app/admin/store', 'AdminController::store',['filter' => 'authGuard']);
$routes->get('/app/admin/edit/(:any)', 'AdminController::edit/$1',['filter' => 'authGuard']);
$routes->post('/app/admin/update/(:any)', 'AdminController::update/$1',['filter' => 'authGuard']);
$routes->get('/app/admin/delete/(:any)', 'AdminController::delete/$1',['filter' => 'authGuard']);

//tanggal
$routes->get('/app/tanggal', 'TanggalController::index',['filter' => 'authGuard']);
$routes->get('/app/tanggal/tambah', 'TanggalController::create',['filter' => 'authGuard']);
$routes->post('/app/tanggal/store', 'TanggalController::store',['filter' => 'authGuard']);
$routes->get('/app/tanggal/edit/(:any)', 'TanggalController::edit/$1',['filter' => 'authGuard']);
$routes->post('/app/tanggal/update/(:any)', 'TanggalController::update/$1',['filter' => 'authGuard']);
$routes->get('/app/tanggal/delete/(:any)', 'TanggalController::delete/$1',['filter' => 'authGuard']);

//reservasi
$routes->get('/app/reservasi', 'ReservasiController::index',['filter' => 'authGuard']);
$routes->get('/app/reservasi/tambah', 'ReservasiController::create',['filter' => 'authGuard']);
$routes->post('/app/reservasi/konfirmasi', 'ReservasiController::konfirmasi',['filter' => 'authGuard']);
$routes->post('/app/reservasi/store', 'ReservasiController::store',['filter' => 'authGuard']);
$routes->get('/app/reservasi/edit/(:any)', 'ReservasiController::edit/$1',['filter' => 'authGuard']);
$routes->post('/app/reservasi/update/(:any)', 'ReservasiController::update/$1',['filter' => 'authGuard']);
$routes->get('/app/reservasi/delete/(:any)', 'ReservasiController::delete/$1',['filter' => 'authGuard']);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
