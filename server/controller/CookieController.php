<?php
require_once('model/CustomerModel.php');
class CookieController {
    public static function decodeCookie($cookie)
    {
        $key = "aptxadaq32fgsq"; // Khóa bí mật
        //id -> 5 char
        //key -> 14 char
        //isAdmin -> 7 char
        $id = substr($cookie, 0, 5);
        $keyString = substr($cookie, 5, 14);
        $isAdmin = substr($cookie, 19, 7);

        $id = intval((intval($id) - 14142)/19);
        $keyString2 = "";
        $chars = str_split($keyString);
        for($i = 0; $i < count($chars); $i++)
        {
            $keyString2 .= chr(ord($keyString[$i]) - 2);
        }
        $isAdmin = $isAdmin == "a9f9xa3";

        if ($keyString2 != $key or $id <= 0)
            return -1;
        return $id;
    }
    public static function encodeCookie($payload, $key)
    {
        $id = $payload["id"];
        $isAdmin = $payload["isAdmin"];
        $val = 0;
        $chars = str_split($key);
        $keyString = "";
        for($i = 0; $i < count($chars); $i++)
        {
            $keyString .= chr(ord($key[$i]) + 2);
        }
        $val %= 1000;
        //id -> 5 char
        //key -> 4 char
        //isAdmin -> 4 char
        $result = "";
        $idString = strval($id * 19 + 14142);
        if ($isAdmin)
            $isAdminString = "a9f9xa3";
        else
            $isAdminString = "f73ne82";
        $result = $idString . $keyString . $isAdminString;
        return $result;
    } 
    public static function decodeCookieIsAdmin($cookie)
    {
        $key = "aptxadaq32fgsq"; // Khóa bí mật
        //id -> 5 char
        //key -> 14 char
        //isAdmin -> 7 char
        $id = substr($cookie, 0, 5);
        $keyString = substr($cookie, 5, 14);
        $isAdmin = substr($cookie, 19, 7);

        $id = intval((intval($id) - 14142)/19);
        $keyString2 = "";
        $chars = str_split($keyString);
        for($i = 0; $i < count($chars); $i++)
        {
            $keyString .= chr((ord($key[$i]) - 2 + 122 - 48 + 1) % (122 - 48 + 1) + 48);
        }
        $isAdmin = $isAdmin == "a9f9xa3";

        if ($keyString != $key or $id <= 0)
            return false;
        
        return $isAdmin;
    }   
}


?>