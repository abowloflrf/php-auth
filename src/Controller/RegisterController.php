<?php
namespace App\Controller;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;

class RegisterController extends Controller
{
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
        $pass = true;
        
        //validate
        if ($body['name'] == '' || $body['email'] == '' || $body['password'] == '' || $body['password_confirmation'] == '') {
            //empty string detected
            $pass = false;
        }
        if ($body['password'] != $body['password_confirmation']) {
            //password not confirmed
            $_SESSION['errors']['password'] = "Please confirm your password!";
            $pass = false;
        } else if (strlen($body['password']) <= 6) {
            //password too short
            $_SESSION['errors']['password'] = "Password too short (longer than 6)!";
            $pass = false;
        }
        if (strlen($body['name']) <= 6) {
            //username too short
            $_SESSION['errors']['name'] = "Username too short! (longer than 6)!";
            $pass = false;
        }
        if (User::where('email', $body['email'])->first()) {
            //email exsited
            $_SESSION['errors']['email'] = "Email has been registered!";
            $pass = false;
        }


        if (!$pass) {
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