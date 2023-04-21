<?php
require_once('model/AdminModel.php');
require_once('controller/CookieController.php');
class AdminController {
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
}

?>