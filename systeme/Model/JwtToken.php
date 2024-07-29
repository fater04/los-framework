<?php
/**
 * JwtToken.php
 * natcash_api
 * @author : fater04
 * @created :  08:52 - 2024-07-25
 **/

namespace systeme\Model;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtToken extends Model
{
 public static function secretKey(){ return  $secretKey = "your-256-bit-secret";}

  public static  function generateJWT($userId) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // jwt valid for 1 hour from the issued time
        $payload = [
            'iat' => $issuedAt,
//            'exp' => $expirationTime,
            'userId' => $userId
        ];
        $jwt = JWT::encode($payload, self::secretKey(), 'HS256');
        return $jwt;
    }
  public static function validateJWT($jwt) {
        try {
            $decoded = JWT::decode($jwt, new Key(self::secretKey(), 'HS256'));
            return (array) $decoded; // Valid token
        } catch (Exception $e) {
            return false; // Invalid token
        }
    }

    // Example usage
//$userId = 1;
//$jwt = generateJWT($userId, $secretKey);
//storeJWT($userId, $jwt, $pdo);
//echo "JWT JwtToken: $jwt\n";

// Validate token
//$jwtToValidate = $jwt; // Normally this would come from the client
//$decodedToken = validateJWT($jwtToValidate, $secretKey);

//if ($decodedToken) {
//echo "JwtToken is valid.\n";
//print_r($decodedToken);
//} else {
//    echo "JwtToken is invalid.\n";
//}

}