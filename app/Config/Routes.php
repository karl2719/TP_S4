<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;
use Config\Services;

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// AUTH FRONT
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::doLogin');
$routes->get('logout', 'Auth::logout');
$routes->get('register/step1', 'Auth::registerStep1');
$routes->post('register/step1', 'Auth::doRegisterStep1');
$routes->get('register/step2', 'Auth::registerStep2');
$routes->post('register/step2', 'Auth::doRegisterStep2');

// FRONT USER (protege par filtre auth)
$routes->get('dashboard', 'Dashboard::index');
$routes->get('profil', 'Profil::index');
$routes->post('profil/update', 'Profil::update');
$routes->get('regimes', 'Regime::index');
$routes->get('regimes/(:num)', 'Regime::detail/$1');
$routes->post('regimes/acheter', 'Regime::acheter');
$routes->get('wallet', 'Wallet::index');
$routes->post('wallet/crediter', 'Wallet::crediter');
$routes->get('gold', 'Gold::index');
$routes->post('gold/activer', 'Gold::activer');
$routes->get('export/pdf/(:num)', 'Export::pdf/$1');

// BACK OFFICE (protege par filtre admin)
$routes->get('admin', 'admin\AdminAuth::login');
$routes->post('admin/login', 'admin\AdminAuth::doLogin');
$routes->get('admin/logout', 'admin\AdminAuth::logout');
$routes->get('admin/dashboard', 'admin\AdminDashboard::index');

// CRUD Regimes admin
$routes->get('admin/regimes', 'admin\AdminRegimes::index');
$routes->get('admin/regimes/create', 'admin\AdminRegimes::create');
$routes->post('admin/regimes/store', 'admin\AdminRegimes::store');
$routes->get('admin/regimes/edit/(:num)', 'admin\AdminRegimes::edit/$1');
$routes->post('admin/regimes/update/(:num)', 'admin\AdminRegimes::update/$1');
$routes->get('admin/regimes/delete/(:num)', 'admin\AdminRegimes::delete/$1');

// CRUD Activites admin
$routes->get('admin/activites', 'admin\AdminActivites::index');
$routes->get('admin/activites/create', 'admin\AdminActivites::create');
$routes->post('admin/activites/store', 'admin\AdminActivites::store');
$routes->get('admin/activites/edit/(:num)', 'admin\AdminActivites::edit/$1');
$routes->post('admin/activites/update/(:num)', 'admin\AdminActivites::update/$1');
$routes->get('admin/activites/delete/(:num)', 'admin\AdminActivites::delete/$1');

// CRUD Codes admin
$routes->get('admin/codes', 'admin\AdminCodes::index');
$routes->get('admin/codes/create', 'admin\AdminCodes::create');
$routes->post('admin/codes/store', 'admin\AdminCodes::store');
$routes->get('admin/codes/delete/(:num)', 'admin\AdminCodes::delete/$1');

// CRUD Parametres admin
$routes->get('admin/params', 'admin\AdminParams::index');
$routes->post('admin/params/update', 'admin\AdminParams::update');

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
