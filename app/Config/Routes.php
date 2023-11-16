<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

$routes->post('auth/jwt', '\App\Controllers\Auth\LoginController::jwtLogin');

use App\Controllers\Api\User;

$routes->group('jwt/api', ['filter' => 'jwt'], static function ($routes) {
    $routes->get('users', [User::class, 'index']);
});
