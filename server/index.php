<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');

require_once('controller/CookieController.php');
require_once('controller/CustomerController.php');

$cookie = new CookieController();
$check = $cookie->getUserID();


    // Cookie hợp lệ, xử lý tương ứng ở đây
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($_SERVER['REQUEST_URI'] === '/products')
        {
            $customer = new CustomerController();
            echo $customer->getProducts();
        }
        else echo "Welcom to PHP server!";
    }
    else if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if ($_SERVER['REQUEST_URI'] === '/login')
        {
            $customer = new CustomerController();
            echo $customer->login();
        }
        else if ($_SERVER['REQUEST_URI'] === '/signup')
        {
            $customer = new CustomerController();
            echo $customer->signup();
        }
    }


?>