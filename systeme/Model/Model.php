<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 30/03/2018
 * Time: 13:25
 */

namespace systeme\Model;

use systeme\Application\Session;

class Model extends Session
{

    public static function connection()
    {
        return \systeme\Application\Application::connection();
    }

    public static function envoyerEmail($a, $sujet, $contenue, $attachement = "", $reply = "")
    {
        return \systeme\Application\Application::envoyerEmail($a, $sujet, $contenue, $attachement, $reply);
    }


}