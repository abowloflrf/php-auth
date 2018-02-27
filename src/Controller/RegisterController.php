<?php
namespace App\Controller;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;

class RegisterController
{
    protected $container;
    public function __construct(Container $c)
    {
        $this->container = $c;
    }

    //show register form
    public function showRegisterForm(Request $request, Response $response)
    {
        return $this->container->view->render($response, 'register.twig');
    }
    
    //handle the post data
    public function handleRegister(Request $request, Response $response)
    {
        //parse post data
        $body = $request->getParsedBody();

        //validate
        if ($body['name'] == '' || $body['email'] == '' || $body['password'] == '' || $body['password_confirmation'] == '') {
            //empty string detected
            return $response->withRedirect('/register', 301);
        }
        if ($body['password'] != $body['password_confirmation']) {
            //password not confirmed
            return $response->withRedirect('/register', 301);
        }
        if (strlen($body['password']) <= 6) {
            //password too short
            return $response->withRedirect('/register', 301);
        }
        if (User::where('email', $body['email'])->first()) {
            //email exsited
            return $response->withRedirect('/register', 301);
        }
        
        //save user data into database
        $newUser = User::create([
            "email" => $body['email'],
            "name" => $body['name'],
            "password" => password_hash($body['password'], PASSWORD_BCRYPT)
        ]);

        //insert successfull, login automatically and redirect to home
        session_regenerate_id(true);
        $_SESSION = array();
        $_SESSION['user_id'] = $newUser->id;
        $_SESSION['user_name'] = $newUser->name;
        $_SESSION['user_email'] = $newUser->email;
        $_SESSION['user_logged_in'] = true;

        //redirect
        return $response->withRedirect('/home', 301);
    }

}