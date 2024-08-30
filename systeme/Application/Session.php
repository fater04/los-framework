<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 18/08/2018
 * Time: 15:40
 */

namespace systeme\Application;

session_start();

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
class Session
{
    public static  function encryptSession($value, $key="Fater_04")
    {
        $value=json_encode($value);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encryptedValue = openssl_encrypt($value, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($encryptedValue . '::' . $iv);
    }


    public static  function decryptSession($encryptedValue, $key="Fater_04")
    {
        list($encryptedValue, $iv) = explode('::', base64_decode($encryptedValue), 2);
        $value= openssl_decrypt($encryptedValue, 'aes-256-cbc', $key, 0, $iv);
        return json_decode($value);
    }

}