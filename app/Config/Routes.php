<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Home;
/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/signup', 'Home::signup');
