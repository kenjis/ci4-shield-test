<?php

use App\Controllers\Api\User;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

$routes->post('auth/jwt', '\App\Controllers\Auth\LoginController::jwtLogin');
$routes->group('jwt/api', ['filter' => 'jwt'], static function ($routes) {
    $routes->get('users', [User::class, 'index']);
});

$routes->post('auth/hmac', '\App\Controllers\Auth\LoginController::hmacLogin');
$routes->group('hmac/api', ['filter' => 'hmac'], static function ($routes) {
    $routes->get('users', [User::class, 'index']);
});
