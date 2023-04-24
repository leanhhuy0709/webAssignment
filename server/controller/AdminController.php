<?php
require_once('model/AdminModel.php');
require_once('controller/CookieController.php');
require_once('controller/CustomerController.php');

function isAdmin($token)
{
    $cookie = new CookieController();
    return $cookie->decodeCookieIsAdmin($token);
}
class AdminController {
    public static function getUserList()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $tmp = checkIsValid($data, ['token']);
        if (!$tmp["result"])
            return $tmp; 

        if (!isAdmin($data['token']))
            return json_encode(array(
                "result" => false,
                "message" => "You are not admin"
            ));

        $res = getUserListModel();
        return json_encode($res);
    }

    public static function addProduct()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $tmp = checkIsValid($data, ['name', 'price', 'categoryID', 'description', 'imageURL', 'token']);
        if (!$tmp["result"])
            return $tmp; 

        if (!isAdmin($data['token']))
            return json_encode(array(
                "result" => false,
                "message" => "You are not admin"
            ));

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

        $tmp = checkIsValid($data, ['name', 'price', 'categoryID', 'description', 'imageURL', 'token']);
        if (!$tmp["result"])
            return $tmp;

        if (!isAdmin($data['token']))
            return json_encode(array(
                "result" => false,
                "message" => "You are not admin"
            ));

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
        $check = checkIsValid($data, ['token', 'userID']);
        if (!$check["result"])
            return json_encode($check);
        $cookie = new CookieController();
        $userID = $cookie->decodeCookie($data['token']);

        $userIDIsDelete = $data['userID'];
        $res = deleteUserModel($userIDIsDelete);
        return json_encode($res);
    }

    public static function deleteComment()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $check = checkIsValid($data, ['token', 'commentID']);
        if (!$check["result"])
            return json_encode($check);
        
        if (!isAdmin($data['token']))
            return json_encode(array(
                "result" => false,
                "message" => "You are not admin"
            ));

        $commentID = $data['commentID'];
        $res = deleteCommentModel($commentID);
        return json_encode($res);
    }
}

?>