<?php
namespace App\Auth;

use App\Models\User;

class Auth
{
    public static function attempt($email, $password)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            //user do not exist
            return false;
        }
        if (password_verify($password, $user->password)) {
            //password passed, write into session
            session_regenerate_id(true);
            $_SESSION = array();
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_logged_in'] = true;

            return true;
        }
        return false;
    }

    public static function check()
    {
        return isset($_SESSION['user_logged_in']);
    }

    public static function user()
    {
        if (isset($_SESSION['user_id'])) {
            return User::find($_SESSION['user_id']);
        } else {
            return null;
        }
    }

    public static function guest()
    {
        if (isset($_SESSION['user_logged_in'])) {
            return false;
        }
        return true;
    }

    public static function logout()
    {
        session_destroy();
    }
}