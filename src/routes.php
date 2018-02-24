<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function (Request $request, Response $response, array $args) {
    return $this->renderer->render($response, 'index.phtml', $args);
});
$app->get('/login', '\App\Controllers\LoginController:showLoginForm');
$app->get('/register','\App\Controllers\RegisterController:showRegisterForm');
$app->post('/register','\App\Controllers\RegisterController:handleRegister');
$app->post('/login', '\App\Controllers\LoginController:handleLogin');
$app->post('/logout', '\App\Controllers\LoginController:logout');
$app->get('/home', '\App\Controllers\HomeController:index');
