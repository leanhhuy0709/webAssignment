<?php
require_once('model/AdminModel.php');
require_once('controller/CookieController.php');
require_once('controller/CustomerController.php');
class AdminController {
    public static function isAdmin()
    {
        $cookie = new CookieController();
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $userID = $cookie->decodeCookie($data['token']);
    }
    public static function getUserList()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $cookie = new CookieController();
        //$userID = $cookie->decodeCookie($data['token']);
        // tạm thời cho mọi người đều xem được danh sách user


        $res = getUserListModel();
        return json_encode($res);
    }

    public static function addProduct()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $tmp = checkIsValid($data, ['name', 'price', 'categoryID', 'description', 'imageURL']);
        if (!$tmp["result"])
            return $tmp; 

        $cookie = new CookieController();
        $userID = $cookie->decodeCookie($data['token']);

        $name = $data['name'];
        $price = $data['price'];
        $categoryID = $data['categoryID'];
        $supplierID = 1;
        $brandID = 1;
        $description = $data['description'];
        $imageURL = $data['imageURL'];

        $res = addProductModel($name, $price, $categoryID, $supplierID, $brandID, $description, $imageURL);
        
        return json_encode($res);
    }

    public static function updateProduct()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $cookie = new CookieController();
        $userID = $cookie->decodeCookie($data['token']);

        $productID = $data['productID'];
        $name = $data['name'];
        $price = $data['price'];
        $categoryID = $data['categoryID'];
        $supplierID = 1;
        $brandID = 1;
        $description = $data['description'];
        $imageURL = $data['imageURL'];

        $res = updateProductModel($name, $price, $categoryID, $supplierID, $brandID, $description, $imageURL, $productID);
        return json_encode($res);
    }

    public static function deleteUser()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $check = checkIsValid($data, ['token']);
        if (!$check["result"])
            return json_encode($check);
        $cookie = new CookieController();
        $userID = $cookie->decodeCookie($data['token']);
        $res = deleteUserModel($userID);
        return json_encode($res);
    }
}

?>