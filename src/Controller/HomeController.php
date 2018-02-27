<?php
namespace App\Controller;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;

class HomeController
{
    protected $container;
    public function __construct(Container $c)
    {
        $this->container = $c;
    }

    //显示登录后到home
    public function index(Request $request, Response $response)
    {
        return $this->container->view->render($response, 'home.twig');
    }
}