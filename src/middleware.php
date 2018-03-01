<?php
//CSRF Token Middleware
$app->add(new \App\Middleware\CsrfMiddleware($app->getContainer()));