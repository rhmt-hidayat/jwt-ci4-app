<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//TES JWT VERSI 1
// $routes->get('/', 'Home::index', ['filter' => 'auth']); //proteksi route home butuh token
// $routes->post('register', 'Register::index');
// $routes->post('login', 'Login::index');
// $routes->get('profil', 'Profil::index');

//TES JWT VERSI 2
$routes->get('/', 'Home::index');
$routes->post('signup', 'Signup::index');
$routes->post('signin', 'Signin::index');
$routes->get('about', 'About::index', ['filter' => 'auth2']);
