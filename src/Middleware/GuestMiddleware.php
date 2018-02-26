<?php
namespace App\Middleware;
//GuestMiddleware 只允许为登陆的游客通过，否则跳转到home
class GuestMiddleware
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
        if (array_key_exists('user_logged_in', $_SESSION)) {
            return $response->withRedirect('/home', 301);
        }
        $response = $next($request, $response);
        return $response;
    }
}