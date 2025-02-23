<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'auth']); //proteksi route home butuh token
$routes->post('register', 'Register::index');
$routes->post('login', 'Login::index');
$routes->get('profil', 'Profil::index');
