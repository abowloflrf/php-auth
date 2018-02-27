<?php
namespace App\Controller;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;
use App\Auth\Auth;

class LoginController
{
    protected $container;

    public function __construct(Container $c)
    {
        $this->container = $c;
    }

    //show login form
    public function showLoginForm(Request $request, Response $response)
    {
        return $this->container->view->render($response, 'login.twig');
    }

    //handle login request
    public function handleLogin(Request $request, Response $response)
    {
        //get post data from request
        $body = $request->getParsedBody();
        //attempt
        $auth = Auth::attempt($body['email'], $body['password']);
        if (!$auth) {
            //invalid credentials, return to login page
            return $response->withRedirect('/login', 301);
        }
        //login succcessfully, redirect to home page
        return $response->withRedirect('/home', 301);
    }

    //logout
    public function logout(Request $request, Response $response)
    {
        Auth::logout();
        return $response->withRedirect('/', 301);
    }
}
