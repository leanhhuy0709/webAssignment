<?php
require_once('model/CustomerModel.php');
class CookieController {
    public static function decodeCookie($cookie)
    {
        $key = "aptxadaq32fgsq"; // Khóa bí mật
        //id -> 5 char
        //isAdmin -> 4 char
        //key -> 4 char
        $val = 0;
        $chars = str_split($key);
        for($i = 0; $i < count($chars); $i++)
        {
            $val += ord($key[$i]);
        }
        $val %= 1000;
        $id = intval(substr($cookie, 0, 5)) - 10000;
        $isAdmin = substr($cookie, 8, 2) == "44";
        return $id;
    }
    public static function encodeCookie($payload, $key)
    {
        $id = $payload["id"];
        $isAdmin = $payload["isAdmin"];
        $val = 0;
        $chars = str_split($key);
        for($i = 0; $i < count($chars); $i++)
        {
            $val += ord($key[$i]);
        }
        $val %= 1000;
        //id -> 5 char
        //key -> 4 char
        //isAdmin -> 4 char
        $result = "";
        $idString = strval($id + 10000);
        if ($isAdmin)
            $isAdminString = "44";
        else
            $isAdminString = "35";
        $keyString = strval($val);
        $result = $idString . $keyString . $isAdminString;
        return $result;
    } 
    public static function decodeCookieIsAdmin($cookie)
    {
        $key = "my_secret_key"; // Khóa bí mật
        //id -> 5 char
        //isAdmin -> 4 char
        //key -> 4 char
        $val = 0;
        $chars = str_split($key);
        for($i = 0; $i < count($chars); $i++)
        {
            $val += ord($key[$i]);
        }
        $val %= 1000;
        $id = intval(substr($cookie, 0, 5)) - 10000;
        $isAdmin = substr($cookie, 8, 2) == "44";
        return $isAdmin;
    }   
}


?>