<?php
namespace App\Controller;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Illuminate\Database\Query\Builder;

class RegisterController
{
    protected $container;
    protected $users;
    public function __construct(Container $c)
    {
        $this->container = $c;
        $this->users = $this->container->get('db')->table('users');
    }

    //show register form
    public function showRegisterForm(Request $request, Response $response, array $args)
    {
        return $this->container->renderer->render($response, 'register.phtml', $args);
    }
    
    //handle the post data
    public function handleRegister(Request $request, Response $response, array $args)
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
        if ($this->users->where('email', $body['email'])->first()) {
            //email exsited
            return $response->withRedirect('/register', 301);
        }
        
        //save user data into database
        $newUserId = $this->users->insertGetId([
            "email" => $body['email'],
            "name" => $body['name'],
            "password" => password_hash($body['password'], PASSWORD_BCRYPT)
        ]);
        //insert successfull, login automatically and redirect to home
        session_regenerate_id(true);
        $_SESSION = array();
        $_SESSION['user_id'] = $newUserId;
        $_SESSION['user_name'] = $body['name'];
        $_SESSION['user_email'] = $body['email'];
        $_SESSION['user_logged_in'] = true;
        return $response->withRedirect('/home', 301);
    }

}