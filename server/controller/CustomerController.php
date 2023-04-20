<?php
require_once('model/CustomerModel.php');
require_once('controller/CookieController.php');

function checkIsValid($data, $string)
{
    for ($i = 0; $i < count($string); $i++)
        if (!isset($data[$string[$i]]))
            return array(
                "result" => false,
                "message" => $string[$i]." is not valid");
    return array(
        "result" => true,
        "message" => ""
    );
}

class CustomerController {
    public static function login()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $check = checkIsValid($data, ['username', 'password']);
        if (!$check["result"])
            return json_encode($check);//

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

            $cookie = new CookieController();
            $jwt = $cookie->encodeCookie($payload, $key);
            

            $result["token"] = $jwt;
        }
        return json_encode($result);
    }
    public static function signup()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $check = checkIsValid($data, ['username', 'password', 'fname', 'lname', 'gender', 'age', 'email', 'phone', 'DOB', 'imageURL']);

        if (!$check["result"])
            return json_encode($check);

        $username = $data['username'];
        $password = $data['password'];
        $fname = $data['fname'];
        $lname = $data['lname'];
        $gender = $data['gender'];
        $age = $data['age'];
        $email = $data['email'];
        $phone = $data['phone'];
        $DOB = $data['DOB'];
        $imageURL = $data['imageURL'];
        //$address = $data['address'];
        $address = "None";
        //Token nó vì không lưu tk, mk trong database!!!
        $res = signupModel($username, $password, $fname, $lname, $gender, $age, $email, $phone, $DOB, $imageURL, $address); // Trả về id người dùng

        return json_encode($res);
    }
    public static function logout()
    {
        setcookie('token', '', time() + 30*24*60*60);
        return json_encode(array("message" => "Logout successfully"));
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
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $check = checkIsValid($data, ['token']);
        if (!$check["result"])
            return json_encode($check);
        $cookie = new CookieController();
        $userID = $cookie->decodeCookie($data['token']);
        $res = getCartModel($userID);
        return json_encode($res);
    }
    
    public static function addProductToCart()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $check = checkIsValid($data, ['token', 'productID', 'quantity']);
        if (!$check["result"])
            return json_encode($check);

        $productID = $data['productID'];
        $quantity = $data['quantity'];

        $cookie = new CookieController();
        $userID = $cookie->decodeCookie($data['token']);

        $res = addProductToCartModel($userID, $productID, $quantity);
        return json_encode($res);
    }
    public static function deleteProductToCart()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $check = checkIsValid($data, ['token', 'productID', 'quantity']);
        if (!$check["result"])
            return json_encode($check);

        $productID = $data['productID'];
        $quantity = $data['quantity'];
        
        $cookie = new CookieController();
        $userID = $cookie->decodeCookie($data['token']);
        
        $res = deleteProductToCartModel($userID, $productID, $quantity);
        return json_encode($res);
    }
    
    public static function getUserInfo()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $check = checkIsValid($data, ['token']);
        if (!$check["result"])
            return json_encode($check);

        $cookie = new CookieController();
        $userID = $cookie->decodeCookie($data['token']);
        $res = getUserInfoModel($userID);
        return json_encode($res);
    }
    
    public static function updateUserInfo() {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $check = checkIsValid($data, ['token', 'fname', 'lname', 'DOB', 'phone', 'email', 'address', 'imageURL']);
        if (!$check["result"])
            return json_encode($check);

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
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $check = checkIsValid($data, ['token']);
        if (!$check["result"])
            return json_encode($check);

        $cookie = new CookieController();
        $userID = $cookie->decodeCookie($data['token']);
        $res = getOrdersModel($userID);
        return json_encode($res);
    }
    public static function getOrderDetail() {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $check = checkIsValid($data, ['orderID', 'token']);
        if (!$check["result"])
            return json_encode($check);

        $orderID = $data['orderID'];
        $cookie = new CookieController();
        $userID = $cookie->decodeCookie($data['token']);

        $res = getOrderDetailModel($userID, $orderID);
        return json_encode($res);//?
    }
    public static function payment()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $check = checkIsValid($data, ['token', 'paymentMethod']);
        if (!$check["result"])
            return json_encode($check);

        $paymentMethod = $data['paymentMethod'];
        $cookie = new CookieController();
        $userID = $cookie->decodeCookie($data['token']);
        $res = paymentModel($userID, $paymentMethod);
        return json_encode($res);
    }
    public static function getProductDetail()
    {
        $productID = $_GET['productID'];
        $res = getProductDetailModel($productID);
        return json_encode($res);
    }

    public static function getCategories()
    {
        $res = getCategoriesModel();
        return json_encode($res);
    }

    public static function comment()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        /*"token": getCookieValueByName('token'),
                "productID": 1,
                "title": "test title",
                "text": "test tfext",
                "rating": 5 */

        $check = checkIsValid($data, ['token', 'productID', 'title', 'text', 'rating']);
        if (!$check["result"])
            return json_encode($check);
        $cookie = new CookieController();
        $userID = $cookie->decodeCookie($data['token']);
        $productID = $data['productID'];
        $title = $data['title'];
        $text = $data['text'];
        $rating = $data['rating'];
        //return json_encode(array("data"=>$data));
        $res = commentModel($userID, $productID, $title, $text, $rating);
        return json_encode($res);
    }
}
?>
