<?php
namespace App\Controller;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;
use App\Auth\Auth;

class LoginController extends Controller
{
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
        //check is user exists
        if (!User::where('email', $body['email'])->first()) {
            $_SESSION['errors']['email'] = "User doesn't exist!";
            return $response->withRedirect('/login', 301);
        }
        //check if password is correct
        $auth = Auth::attempt($body['email'], $body['password']);
        if (!$auth) {
            //wrong password
            $_SESSION['errors']['password'] = "Wrong password!";
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
