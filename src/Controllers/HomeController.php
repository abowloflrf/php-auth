<?php
namespace App\Controllers;

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
        if ($_SESSION['user_logged_in']) {
            return $this->container->renderer->render($response, 'home.phtml', $args);
        } else {
            return $response->withRedirect('/login', 301);
        }
    }
}