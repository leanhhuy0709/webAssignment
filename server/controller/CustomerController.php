<?php
require_once('model/CustomerModel.php');
require_once('vendor/autoload.php'); // Thư viện JWT

use \Firebase\JWT\JWT;

class CustomerController {
    public static function login()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $username = isset($data['username']) ? $data['username'] : null;
        $password = isset($data['password']) ? $data['password'] : null;
        //Token nó vì không lưu tk, mk trong database!!!
        $res = loginModel($username, $password); // Trả về id người dùng

        if ($res != -1)
        {
            $key = "my_secret_key"; // Khóa bí mật

            // Thông tin payload để mã hóa vào token
            $payload = array(
                "id" => $res
            );

            $jwt = JWT::encode($payload, $key, 'HS256');
            //1 -> jsfbwfbsfnwfnoweofoiwe1231
            //Tạo cookie
            setcookie('token', $jwt, time() + 3600);
            return "true";
        }
        else 
            return "false";
    }
    public static function signup()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $DOB = $_POST['DOB'];
        //Token nó vì không lưu tk, mk trong database!!!
        $res = signupModel($username, $password, $fname, $lname, $gender, $age, $email, $phone, $DOB); // Trả về id người dùng

        if ($res != -1)
        {
            $error = 'Đăng ký thành công';
            require_once('view/login.php');
        }
        else 
        {
            $error = 'Đăng kí thất bại';
            require_once('view/login.php');
        }
    }
}
?>
