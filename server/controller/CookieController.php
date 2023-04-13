<?php
require_once('model/CustomerModel.php');
require_once('vendor/autoload.php'); // Thư viện JWT
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
class CookieController {
    public static function getUserID()
    {
        if (empty($_COOKIE["token"]))
        {
            return -2;
        }
        $token = $_COOKIE["token"];
        $key = "my_secret_key"; // Khóa bí mật
        try{
            $decode = (array) JWT::decode($token, new Key($key, 'HS256'));
            return $decode;
        }
        catch(Exception $e){
            echo "Error: ", $e;
            return -1;
        }
    }
    public static function decodeCookie($cookie)
    {
        $key = "my_secret_key"; // Khóa bí mật
        try{
            $decode = (array) JWT::decode($cookie, new Key($key, 'HS256'));
            return $decode["id"];
        }
        catch(Exception $e){
            echo "Error: ", $e;
            return -1;
        }
    }
}


?>