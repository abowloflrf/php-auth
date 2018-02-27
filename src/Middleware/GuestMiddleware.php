<?php
namespace App\Middleware;

use App\Auth\Auth;

//GuestMiddleware 只允许为登陆的游客通过，否则跳转到home
class GuestMiddleware extends Middleware
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
        if (Auth::check()) {
            return $response->withRedirect('/home', 301);
        }
        $response = $next($request, $response);
        return $response;
    }
}