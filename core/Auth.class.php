<?php
/**
 * Created by PhpStorm.
 * User: tartiflette
 * Date: 20/12/18
 * Time: 10:59
 */

namespace Lag\Core;

use Lag\Model\User;

class Auth
{
    public static function isLogged()
    {
        if(!isset($_SESSION['token']))
        {
            return false;
        }else
        {
            return true;
        }
    }

    public static function user()
    {
        if(self::isLogged())
        {
            $token = $_SESSION['token'];
            $user = User::findBy('token', $token);
            if(count($user > 0))
            {
                return $user[0];
            }
        }

        return false;
    }
}
