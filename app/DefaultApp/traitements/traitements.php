<?php
/**
 * traitements.php
 * courrier
 * @author : fater04
 * @created :  14:37 - 2024-08-29
 **/

use PHPMailer\PHPMailer\PHPMailer;

require_once '../../../vendor/autoload.php';

if (isset($_GET['delete_user'])) {
    $r = new \systeme\Model\Utilisateur();
    $resultat = $r ->deleteById($_GET['delete_user']);
    if ($resultat == 'ok') {
        $msg = "Utilisateur supprimé avec succes !";
    } else {
        $msg = $resultat;
    }
    echo $msg;
}
if (isset($_GET['bloker_user'])) {
    $r = new \systeme\Model\Utilisateur();
    $resultat = $r::blocker($_GET['bloker_user']);
    if ($resultat == 'ok') {
        $msg = "Utilisateur bloqué  !";
    } else {
        $msg = $resultat;
    }
    echo $msg;
}
if (isset($_GET['debloker_user'])) {
    $r = new \systeme\Model\Utilisateur();
    $resultat = $r::deblocker($_GET['debloker_user']);
    if ($resultat == 'ok') {
        $msg = "Utilisateur débloqué  !";
    } else {
        $msg = $resultat;
    }
    echo $msg;
}

if (isset($_GET['ajouter_utilisateur'])) {
    $resultat = array();
    $email=$_POST['email'];
    $password=\app\DefaultApp\DefaultApp::generatePassword(8);
    $r = new \systeme\Model\Utilisateur();
    $r->setNom($_POST['nomcomplet']);
    $r->setEmail($email);
    $r->setTelephone($_POST['telephone']);
    $r->setPseudo($_POST['pseudo']);
    $r->setRole($_POST['role']);
    $r->setStatut('oui');
    $r->setPhoto('n/a');
    $r->setDateCreation(Date('d-m-Y H:i:s'));
    $r->setMotdepasse($password);
    $r1 = $r->add();
    if ($r1 == 'ok') {
        try{
        $mail2 = new PHPMailer(true);
        $mail2->isSMTP();
        $mail2->Host = "node13-ca.n0c.com";
        $mail2->SMTPAuth = true;
        $mail2->Username = "mail@ewallpay.com";
        $mail2->Password = "Haiti2024#";
        $mail2->SMTPSecure = 'tls';
        $mail2->Port = 587;
        $mail2->setFrom("info@app.com", "DEMO");
        $mail2->isHTML(true);
        $message2='<!doctypehtml><html lang="fr"><meta charset="UTF-8"><meta content="width=device-width,initial-scale=1" name="viewport"><title>DEMO</title><style>a,body,table,td{text-size-adjust:100%;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}table,td{mso-table-rspace:0;mso-table-lspace:0}img{-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none}body{margin:0;padding:0;width:100%;background-color:#f4f4f4;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif}.container{width:100%;max-width:600px;margin:0 auto;background-color:#fff;border-radius:10px;box-shadow:0 4px 8px rgba(0,0,0,.1);overflow:hidden}.header{background:#fff;padding:20px;text-align:center;border-bottom:1px solid gray}.header img{max-width:150px;margin-bottom:20px}.content{padding:20px}.content h2{font-size:24px;color:#333;margin-bottom:15px}.content p{font-size:16px;color:#666;line-height:1.6;margin-bottom:20px}.cta{text-align:center;margin:30px 0}.cta a{padding:15px 30px;background-color:#07b6f5;color:#fff;text-decoration:none;font-weight:700;border-radius:5px;box-shadow:0 4px 6px rgba(0,0,0,.1);transition:background-color .3s ease}.cta a:hover{background-color:#069dc2}.footer{background-color:#333;color:#fff;padding:20px;text-align:center;font-size:12px}.footer a{color:#07b6f5;text-decoration:none}</style><div class="container"><div class="header"></div><div class="content"><h2>Votre Mot de passe est :</h2><p>'.$password.'</p></div><div class="footer"></div></div>';
        $mail2->addAddress($email);
        $mail2->Subject = "DEMO";
        $mail2->Body = $message2;
        $mail2->send();
        $resultat["status"] = 'ok';
        $resultat['message'] = "Utilisateur ajouté avec succès !, Mot de passe envoyer par mail";
    } catch (Exception $e) {
            $resultat['status'] = 'no';
            $resultat['message'] = 'Message could not be sent. Mailer Error: ' . $mail2->ErrorInfo;
        }
    } else {
        $resultat['status'] = 'no';
        $resultat['message'] = 'une erreur s\'est produite , svp veuillez reessayer !';
    }
    echo json_encode($resultat);
}
if (isset($_GET['modifier_utilisateur'])) {
    $resultat = array();
    $r = new \systeme\Model\Utilisateur();
    $r->setNom($_POST['nomcomplet']);
    $r->setEmail($_POST['email']);
    $r->setTelephone($_POST['telephone']);
    $r->setPseudo($_POST['pseudo']);
    $r->setRole($_POST['role']);
    $r->setStatut('oui');
    $r->setPhoto('n/a');
//    $r->setMotdepasse('12345');
    $r1 = $r->modifier($_POST['id']);
    if ($r1 == 'ok') {
        $resultat["status"] = 'ok';
        $resultat['message'] = "Utilisateur modifié  !";
    } else {
        $resultat['status'] = 'no';
        $resultat['message'] = $r1;
//        $resultat['message'] = 'une erreur s\'est produite , svp veuillez reessayer !';
    }
    echo json_encode($resultat);
}
