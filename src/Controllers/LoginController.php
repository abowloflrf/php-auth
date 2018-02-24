<?php
namespace App\Controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Illuminate\Database\Query\Builder;

class LoginController
{
    protected $container;
    protected $users;
    public function __construct(Container $c)
    {
        $this->container = $c;
        $this->users = $this->container->get('db')->table('users');
    }

    //显示登录表单
    public function showLoginForm(Request $request, Response $response, array $args)
    {

        if (!array_key_exists('user_logged_in', $_SESSION) || !$_SESSION['user_logged_in']) {
            return $this->container->renderer->render($response, 'login.phtml', $args);

        } else {
            return $response->withRedirect('/home', 301);
        }

    }

    //登录操作
    public function handleLogin(Request $request, Response $response, array $args)
    {
        //从Request获取post过来的数据
        $body = $request->getParsedBody();
        //根据email查询数据库得到相应的User信息
        $queryUser = $this->users->where('email', $body['email'])->first();
        //User不存在
        if (!$queryUser) {
            echo "User doesn's exsit!";
            return;
        }
        //密码错误
        if (!password_verify($body['password'], $queryUser->password)) {
            echo "Wrong password!";
            return;
        } else {
            //认证成功，重新生成session_id并写入内容
            session_regenerate_id(true);
            $_SESSION = array();
            $_SESSION['user_id'] = $queryUser->id;
            $_SESSION['user_name'] = $queryUser->name;
            $_SESSION['user_email'] = $queryUser->email;
            $_SESSION['user_logged_in'] = true;
            return $response->withRedirect('/home', 301);
        }
    }

    //注销当前帐号操作
    public function logout(Request $request, Response $response, array $args)
    {
        session_destroy();
        return $response->withRedirect('/', 301);
    }
}
