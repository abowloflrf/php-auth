<?php
//Add the global middlewares here

//CSRF Token Middleware
$app->add(new \App\Middleware\CsrfMiddleware($app->getContainer()));




// The last one is the middleware first excute

// Start session
$app->add(new \App\Middleware\SessionStartMiddleware($app->getContainer()));
