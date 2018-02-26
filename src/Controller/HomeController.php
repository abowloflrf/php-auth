<?php
namespace App\Controller;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Illuminate\Database\Query\Builder;

class HomeController
{
    protected $container;
    protected $users;
    public function __construct(Container $c)
    {
        $this->container = $c;
        $this->users = $this->container->get('db')->table('users');
    }

    //显示登录后到home
    public function index(Request $request, Response $response, array $args)
    {
        return $this->container->renderer->render($response, 'home.phtml', $args);
    }
}