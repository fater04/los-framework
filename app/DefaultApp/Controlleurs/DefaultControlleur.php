<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 29/03/2018
 * Time: 22:30
 */

namespace app\DefaultApp\Controlleurs;

use Plasticbrain\FlashMessages\FlashMessages;
use systeme\Controlleur\Controlleur;
use systeme\Model\Utilisateur;

class DefaultControlleur extends Controlleur
{
    public function dashboard()
    {
        $variable['titre'] = "Dashboard";
        return $this->render("default/dashboard", $variable);
    }

    public function logout()
    {
        $variable['titre'] = "Logout";
        $msg = new FlashMessages();
        $variable = array();
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if(Utilisateur::logout()) {
                setcookie("utilisateur", "", -1, "/");
                unset($_COOKIE['utilisateur']);
                $msg->info("Sign Out sucessfully", 'login');
            }
        }
        return $this->render("default/login", $variable);

    }

    public function login()
    {
        $variable['titre'] = "login";
        $msg = new FlashMessages();
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (isset($_POST['login'])) {
                $email = trim(addslashes($_POST['username']));
                $password = trim(addslashes($_POST['password']));
                $result =   Utilisateur::login($email,$password);
                if ($result != 'ok') {
                    $msg->error($result, 'login');
                } else {
                    if (isset($_POST["remember"])) {
                        session_start();
                        $expiration = time() + (86400 * 30);
                        setcookie("utilisateur", $_SESSION['utilisateur'], $expiration, "/");
                        $_SESSION["remember"] = "ok";
                    } else {
                        session_start();
                        $_SESSION["remember"] = "non";
                    }
                }
            }
        }
        return $this->render("default/login", $variable);
    }


}