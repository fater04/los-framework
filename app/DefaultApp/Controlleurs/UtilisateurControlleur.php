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
        $msg = New FlashMessages();
        $variable['titre'] = "users";

        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if (isset($_GET['id'])) {
                if (isset($_GET['bq'])) {
                    $message = Utilisateur::blocker($_GET['id']);
                    if ($message == "ok") {
                        $msg->error("Bloquer  avec Succes ", "users");
                    }
                } elseif (isset($_GET['dbq'])) {
                    $message = Utilisateur::deblocker($_GET['id']);
                    if ($message == "ok") {
                        $msg->success("Debloquer  avec Succes ", "users");
                    }
                } else {
                    $resultat = Utilisateur::delete($_GET['id']);
                    if ($resultat == "ok") {
                        $msg->error("Suprime avec Succes ", "users");
                    }

                }

            }
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $nom = DefaultApp::trimInput($_POST['nomcomplet']);
            $email = DefaultApp::trimInput($_POST['email']);
            $pseudo = DefaultApp::trimInput($_POST['pseudo']);
            $role = DefaultApp::trimInput($_POST['role']);
            $password = DefaultApp::trimInput($_POST['password']);


            if (isset($_POST['add-user'])) {

                $user = new Utilisateur();
                $user->setNom($nom);
                $user->setEmail($email);
                $user->setPseudo($pseudo);
                $user->setMotdepasse($password);
                $user->setPrenom('');
                $user->setSexe('');
                $user->setTelephone('');
                $user->setImage('');

                $resultat = $user->ajouter();
                if ($resultat === 'ok') {
                    Utilisateur::ajouterRole(Utilisateur::last(), $role);
                    $msg->success("Utilisateur enregistré avec succes ");
                } else {
                    $msg->error($resultat);
                }
            }
            if (isset($_POST['edit-user'])) {
                $id=DefaultApp::trimInput($_POST['user_id']);
                $old_role = DefaultApp::trimInput($_POST['old_role']);
                $user = new Utilisateur();
                $user->setId($id);
                $user->setNom($nom);
                $user->setEmail($email);
                $user->setPseudo($pseudo);
                $user->setPrenom('');
                $user->setSexe('');
                $user->setTelephone('');
                $user->setImage('');
                $resultat=$user->modifier();

                if ($resultat == 'ok') {
                    if ($password != "0000000000") {
                        Utilisateur::changerMotdepasse($id,$password);
                    }
                    $msg->success("Utilisateur modifié avec succes ");
                } else {
                    $msg->error($resultat);
                }

            }
        }

        $utilisateur = New Utilisateur();
        $variable['listeutilisateur'] = $utilisateur->lister()
        ;
        return $this->render("default/utilisateur", $variable);
    }



//    public function change_password($id)
//    {
//        $variable = array();
//        $msg = new FlashMessages();
//        $variable['titre'] = "Modifier mot de passe";
//        $variable['id'] = $id;
//        if ($_SERVER['REQUEST_METHOD'] === "POST") {
//            $password1 = trim(addslashes($_POST['password1']));
//            $password2 = trim(addslashes($_POST['password2']));
//            if ($password1 === $password2) {
//                $r = Utilisateur::changerMotdepasse($id,$password2);
//                if ($r === 'ok') {
//                    $msg->success("Mot de passe modifié avec succès ! ");
//                    $variable['rediriger'] = "<script> setTimeout(\"location . href = '".DefaultApp::genererUrl('logout')."';\",3000);</script>";
//
//
//                } else {
//                    $msg->error("Une erreur s'est produite ,veuillez reessayer,svp ! ! ");
//                }
//            } else {
//                $msg->error('les mot de passe ne sont pas identiques ! ! ');
//            }
//
//        }
//        return $this->render("default/change-password", $variable);
//    }
}