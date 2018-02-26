<?php
namespace App\Middleware;
// AuthMiddle 只允许已经登陆的用户通过，否则跳转到login
class AuthMiddleware
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
        if (!array_key_exists('user_logged_in', $_SESSION) || !$_SESSION['user_logged_in']) {
            return $response->withRedirect('/login', 301);
        }
        $response = $next($request, $response);
        return $response;
    }
}