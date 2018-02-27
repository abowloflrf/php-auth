<?php

use Slim\Http\Request;
use Slim\Http\Response;

//登陆与未登陆用户均可以访问的首页，根据登陆状态显示内容
$app->get('/', function (Request $request, Response $response, array $args) {
    return $this->view->render($response, 'index.twig');
});

//未登录的游客才可访问的路由
$app->group('', function () {
    $this->get('/login', '\App\Controller\LoginController:showLoginForm');
    $this->get('/register', '\App\Controller\RegisterController:showRegisterForm');
    $this->post('/login', '\App\Controller\LoginController:handleLogin');
    $this->post('/register', '\App\Controller\RegisterController:handleRegister');
})->add(new \App\Middleware\GuestMiddleware());

//已经登陆的用户才可以访问的路由
$app->group('', function () {
    $this->post('/logout', '\App\Controller\LoginController:logout');
    $this->get('/home', '\App\Controller\HomeController:index');
})->add(new \App\Middleware\AuthMiddleware());