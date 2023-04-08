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
        $result = array("message" => $res["message"], "result" => $res["id"] != -1);
        if ($res["id"] != -1)
        {
            $key = "my_secret_key"; // Khóa bí mật

            // Thông tin payload để mã hóa vào token
            $payload = array(
                "id" => $res["id"]
            );

            $jwt = JWT::encode($payload, $key, 'HS256');
            //1 -> jsfbwfbsfnwfnoweofoiwe1231
            $result["token"] = $jwt;
        }
        return json_encode($result);
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
        setcookie('token', '', time() + 30*24*60*60);
        return json_encode(array("message" => "Logout successfully"));
    }
    public static function getProducts()
    {
        $res = getProductsModel();
        return json_encode($res);
    }
    
    public static function getProductsByCategoryAndSearch()
    {
        if (isset($_GET['category']))
            $category = $_GET['category'];
        else
            $category = "";
        if (isset($_GET['search']))
            $search = $_GET['search'];
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
        $userID = $cookie->getUserID();
        $res = addProductToCartModel($userID, $productID, $quantity);
        return json_encode($res);
    }
    public static function deleteProductToCart()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $productID = $data['productID'];
        $quantity = $data['quantity'];
        $cookie = new CookieController();
        $userID = $cookie->getUserID();
        $res = deleteProductToCartModel($userID, $productID, $quantity);
        return json_encode($res);
    }
    
    public static function getUserInfo()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $cookie = new CookieController();
        $userID = $cookie->decodeCookie($data['token']);
        $res = getUserInfoModel($userID);
        return json_encode($res);
    }
    
    public static function updateUserInfo() {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $cookie = new CookieController();
        $userID = $cookie->decodeCookie($data['token']);
        $fname = $data['fname'];
        $lname = $data['lname'];
        $DOB = $data['DOB'];
        $phone = $data['phone'];
        $email = $data['email'];
        $address = $data['address'];
        $imageURL = $data['imageURL'];
        $res = updateUserInfoModel($userID, $fname, $lname, $DOB, $phone, $email, $address, $imageURL);
        return json_encode($res);
    }
    public static function getOrders() {
        //check cookie to know customer
        $cookie = new CookieController();
        $userID = $cookie->getUserID();
        $res = getOrdersModel($userID);
        return json_encode($res);
    }
    public static function getOrderDetail() {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $orderID = $data['orderID'];
        $res = getOrderDetailModel($orderID);
        return json_encode($res);//?
    }
    public static function payment()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $paymentMethod = $data['paymentMethod'];
        $cookie = new CookieController();
        $userID = $cookie->getUserID();
        $res = paymentModel($userID, $paymentMethod);
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

    public static function getCategories()
    {
        $res = getCategoriesModel();
        return json_encode($res);
    }

}
?>
