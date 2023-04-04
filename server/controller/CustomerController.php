<?php
require_once('model/CustomerModel.php');
require_once('vendor/autoload.php'); // Thư viện JWT
require_once('controller/CookieController.php');
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
    
    public static function getProductsByCategoryAndSearch()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        if (isset($data['category']))
            $category = $data['category'];
        else
            $category = "";
        if (isset($data['search']))
            $search = $data['search'];
        else
            $search = "";
        $res = getProductsByCategoryAndSearchModel($category, $search);
        return json_encode($res);
    }
    public static function getCart()
    {
        $res = getCartModel();
        return json_encode($res);
    }
    
    public static function addProductToCart()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $productID = $data['productID'];
        $quantity = $data['quantity'];
        $cookie = new CookieController();
        $cartID = $cookie->getUserID();
        $res = addProductToCartModel($cartID, $productID, $quantity);
        return json_encode($res);
    }
    //Doing ..., don't use anything below this line
    public static function getUserInfo()
    {
        $res = getUserInfoModel();
        return json_encode($res);
    }
    public static function updateUserInfo() {
        $res = updateUserInfoModel();
        return json_encode($res);
    }
    public static function getOrders() {
        //check cookie to know customer
        $res = getOrdersModel();
        return json_encode($res);
    }
    public static function getOrderDetail() {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $orderID = $data['orderID'];
        $res = getOrderDetailModel($orderID);
        return json_encode($res);
    }
    public static function payment()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $address = $data['address'];
        $phone = $data['phone'];
        $res = paymentModel($address, $phone);
        return json_encode($res);
    }
    public static function getProductDetail()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $productID = $data['productID'];
        $res = getProductDetailModel($productID);
        return json_encode($res);
    }

}
?>
