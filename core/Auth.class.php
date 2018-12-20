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

        return true;
    }

    public static function user()
    {
        $user = new User();
        $user->id = "2";
        $user->hydrate();

        return $user;
    }
}
