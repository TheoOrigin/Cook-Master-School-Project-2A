<?php

ini_set('display_errors', 1);

//require('../web/config/config.php');
require('vendor/autoload.php');

use App\JsonResponse;
use App\Router;
use Routes\UserRoutes;

$router = new Router();

$userController = new UserRoutes();

$validAccessToken = 'test';

$authMiddleware = function () use ($validAccessToken) {
    $headers = getallheaders();
    return true;
/*     if (isset($headers['Authorization']) && $headers['Authorization'] === 'Bearer ' . $validAccessToken) {
        return true;
    } else {
        JsonResponse::error('Unauthorized', 401);
        return false;
    } */
};

// Add routes using the user controller methods
$router->addRoute('POST', '/login', [$userController, 'login'], $authMiddleware);
$router->addRoute('POST', '/register', [$userController, 'register'], $authMiddleware);

$router->addRoute('GET', '/users/{id}', [$userController, 'getUser'], $authMiddleware);
$router->addRoute('GET', '/users', [$userController, 'getUsers'], $authMiddleware);
$router->addRoute('POST', '/users', [$userController, 'createUser'], $authMiddleware);

// Retrieve the HTTP method and URI of the incoming request (suppose they are in $method and $uri variables)
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Handle the request using the router
$router->handleRequest($method, $uri);
