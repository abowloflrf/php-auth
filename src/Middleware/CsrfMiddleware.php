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
                return $response->write("CSRF token mismatch!");
            }
            if ($body['_token'] != $_SESSION['_token']) {
                return $response->write("CSRF token mismatch!");
            }
        } else {
            $this->generateToken(40);
        }

        $response = $next($request, $response);
        return $response;
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