<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/register', 'UserController::register');

$routes->get('/login', 'UserController::login');

$routes->post('/post-register', 'UserController::postRegister');

$routes->post('/post-login', 'UserController::postLogin');

$routes->get('/logout', 'UserController::logOut');


