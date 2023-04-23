<?php
require_once('model/CustomerModel.php');
class CookieController {
    public static function decodeCookie($cookie)
    {
        $magicNum = (int) $cookie;
        $key = "my_secret_key"; // Khóa bí mật

        $magicNum = $magicNum - 1000 - strlen($key);
        return $magicNum;
    }
    public static function encodeCookie($payload, $key)
    {
        $magicNum = $payload["id"];
        $magicNum = $magicNum + 1000 + strlen($key);

        return strval($magicNum);
    }    
}


?>