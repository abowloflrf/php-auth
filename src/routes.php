<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/login', '\App\Controllers\LoginController:showLoginForm');
$app->post('/login', '\App\Controllers\LoginController:handleLogin');
$app->post('/logout','\App\Controllers\LoginController:logout');
$app->get('/home','\App\Controllers\HomeController:index');
