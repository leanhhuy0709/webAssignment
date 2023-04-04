<?php
require_once('model/CustomerModel.php');
require_once('vendor/autoload.php'); // Thư viện JWT

use \Firebase\JWT\JWT;

class CustomerController {
    public static function login()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $username = $data['username'];
        $password = $data['password'];
        //Token nó vì không lưu tk, mk trong database!!!
        $res = loginModel($username, $password); // Trả về id người dùng

        if ($res["id"] != -1)
        {
            $key = "my_secret_key"; // Khóa bí mật

            // Thông tin payload để mã hóa vào token
            $payload = array(
                "id" => $res["id"]
            );

            $jwt = JWT::encode($payload, $key, 'HS256');
            //1 -> jsfbwfbsfnwfnoweofoiwe1231
            //Tạo cookie
            setcookie('token', $jwt, time() + 3600);
        }
        return json_encode(array("message" => $res["message"], "result" => $res["id"] != -1));
    }
    public static function signup()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $username = $data['username'];
        $password = $data['password'];
        $fname = $data['fname'];
        $lname = $data['lname'];
        $gender = $data['gender'];
        $age = $data['age'];
        $email = $data['email'];
        $phone = $data['phone'];
        $DOB = $data['DOB'];
        //Token nó vì không lưu tk, mk trong database!!!
        $res = signupModel($username, $password, $fname, $lname, $gender, $age, $email, $phone, $DOB); // Trả về id người dùng

        return json_encode($res);
    }
    public static function logout()
    {
        setcookie('token', '', time() - 3600);
        return json_encode(array("message" => "Logout successfully"));
    }
    public static function getProducts()
    {
        $res = getProductsModel();
        return json_encode($res);
    }
}
?>
