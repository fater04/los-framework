<?php


namespace systeme\Model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    private static $configuration;
    private static $from;

    public function __construct($configuration = array())
    {
        self::$configuration = $configuration;
        self::$from = $configuration['from'];

    }

    private function configuration()
    {
        $mail = new PHPMailer(true);
        try {

            $mail->isSMTP();
            $mail->Host = self::$configuration['host'];
            $mail->SMTPAuth = true;
            $mail->Username = self::$configuration['utilisateur'];
            $mail->Password = self::$configuration['motdepasse'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = self::$configuration['port'];
            $mail->setFrom('hello@bioshaiti.com', 'BIOS WEBSITE');
            $mail->addAddress('wilkerdorvelus@yahoo.com', 'Administrateur');
            $mail->isHTML(true);
            return $mail;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function envoyer($to, $sujet, $contenue, $atachement = "", $reply = "")
    {

        try {
            $mail = $this->configuration();
            $mail->setFrom(self::$from['email'], self::$from['nom']);
            if (is_array($to)) {
                foreach ($to as $m) {
                    if (strpos($m, ",") !== FALSE) {
                        $t = explode(",", $m);
                        $mail->addAddress($t[0], $t[1]);
                    } else {
                        $mail->addAddress($m);
                    }
                }
            }
            else {
                if (strpos($to, ",") !== FALSE) {
                    $t = explode(",", $to);
                    $mail->addAddress($t[0], $t[1]);
                } else {
                    $mail->addAddress($to);
                }
            }
            if ($atachement != "") {
                if (is_array($atachement)) {
                    foreach ($atachement as $attache) {
                        $mail->addAttachment($attache);
                    }
                } else {
                    $mail->addAttachment($atachement);
                }
            }
            if ($reply != "") {
                $mail->addReplyTo($reply);
            }
            $mail->Subject = $sujet;
            $mail->Body = $contenue;
            $mail->send();
            return "ok";
        } catch (Exception $e) {
            return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
    }


}