<?php
namespace App\Controller;

use Slim\Container;

class Controller
{
    protected $container;
    public function __construct(Container $c)
    {
        $this->container = $c;
    }
}