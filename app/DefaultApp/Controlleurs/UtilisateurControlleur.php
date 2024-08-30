<?php
/**
 * UtilisateurControlleur.php
 * project los-framework
 * user fater04
 * created at 1/27/2022 - 10:25 AM
 */

namespace app\DefaultApp\Controlleurs;

use app\DefaultApp\DefaultApp;
use Plasticbrain\FlashMessages\FlashMessages;
use systeme\Controlleur\Controlleur;
use systeme\Model\Utilisateur;

class UtilisateurControlleur extends Controlleur
{
    public function lister()
    {
        $variable['titre'] = "Utilisateur";
        return $this->render("default/utilisateur", $variable);
    }



    public function change_password()
    {
        $variable = array();
        $msg = new FlashMessages();
        $variable['titre'] = "Modifier mot de passe";
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $password0 = trim(addslashes($_POST['password0']));
            $password1 = trim(addslashes($_POST['password1']));
            $password2 = trim(addslashes($_POST['password2']));
            if ($password1 === $password2) {
                $r = Utilisateur::updateMotDePasse(Utilisateur::session_valeur(),$password2);
                if ($r === 'ok') {
                    $msg->info("Mot de passe modifié  ! ",'logout');
                } else {
                    $msg->info("Une erreur s'est produite ,veuillez reessayer,svp ! ! ");
                }
            } else {
                $msg->info('les mot de passe ne sont pas identiques ! ! ');
            }

        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $password0 = trim($_POST['password0']);
            $password1 = trim($_POST['password1']);
            $password2 = trim($_POST['password2']);
            if ($password1 === $password2) {
                $u0=new Utilisateur();
                $user = $u0->findById(Utilisateur::session_valeur());
                if (password_verify($password0, $user->getMotDePasse())) {
                    $r = Utilisateur::updateMotDePasse($user->getId(), $password2);
                    if ($r === 'ok') {
                        $msg->info("Mot de passe modifié !");
                    } else {
                        $msg->info("Une erreur s'est produite, veuillez réessayer, s'il vous plaît !");
                    }
                } else {
                    $msg->info('Le mot de passe actuel est incorrect !');
                }
            } else {
                $msg->info('Les mots de passe ne sont pas identiques !');
            }
        }

        return $this->render("default/change-password", $variable);
    }
}