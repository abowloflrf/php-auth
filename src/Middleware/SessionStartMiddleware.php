<?php
namespace App\Middleware;


class SessionStartMiddleware extends Middleware
{
    /**
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */

    public function __invoke($request, $response, $next)
    {
        $config = $this->container['settings']['session'];
        $this->start($config);

        if (!isset($_SESSION['_token'])) {
            //generate csrf token
            $this->generateToken(40);
        }

        $this->initialForTwig();

        $response = $next($request, $response);
        return $response;
    }
    public function start($config)
    {
        //服务端 Session 有效时间10天
        ini_set('session.gc_maxlifetime', $config['gc_maxlifetime']);
        //客户端 Cookie 登陆状态有效时间10天
        ini_set('session.cookie_lifetime', $config['cookie_lifetime']);
        //将session储存地址设置为本地storage文件夹
        ini_set('session.save_path', $config['save_path']);
        //开始session会话
        session_start();
    }

    public function initialForTwig()
    {
        $view = $this->container['view'];
        $view->getEnvironment()->addGlobal('token', $_SESSION['_token']);
        $view->getEnvironment()->addGlobal('auth', [
            'check' => \App\Auth\Auth::check(),
            'user' => \App\Auth\Auth::user()
        ]);
    }

    public function generateToken($length)
    {
        //generate a csrf token to session
        $token = '';
        while (($len = strlen($token)) < $length) {
            $size = $length - $len;
            $bytes = random_bytes($size);
            $token .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }
        $_SESSION['_token'] = $token;
    }
}