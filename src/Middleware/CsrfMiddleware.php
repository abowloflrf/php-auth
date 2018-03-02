<?php
namespace App\Middleware;


class CsrfMiddleware extends Middleware
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
        if (in_array($request->getMethod(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            $body = $request->getParsedBody();
            if (!isset($body['_token'])) {
                return $response->write("CSRF token missing!");
            }
            if ($body['_token'] != $_SESSION['_token']) {
                return $response->write("CSRF token mismatch!");
            }
        }
        $response = $next($request, $response);
        return $response;
    }
}