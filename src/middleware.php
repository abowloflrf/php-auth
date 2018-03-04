<?php
//Add the global middlewares here

//CSRF Token Middleware
$app->add(new \App\Middleware\CsrfMiddleware($app->getContainer()));

// The last middleware is the first to excute

// Start session
$app->add(new \App\Middleware\SessionStartMiddleware($app->getContainer()));
