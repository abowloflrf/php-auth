<?php

namespace App\Twig;

class CsrfTwigExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('csrf_field', array($this, 'csrfField')),
        ];
    }

    public function csrfField()
    {
        $token = isset($_SESSION['_token']) ? $_SESSION['_token'] : '';
        return '
            <input type="hidden" name="_token" value="'. $token .'">
        ';
    }
}
