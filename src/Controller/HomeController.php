<?php
namespace App\Controller;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;

class HomeController extends Controller
{
    public function index(Request $request, Response $response)
    {
        return $this->container->view->render($response, 'home.twig');
    }
}