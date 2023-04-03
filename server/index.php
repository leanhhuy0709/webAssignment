<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');

require_once('controller/CookieController.php');

$cookie = new CookieController();
$check = $cookie->getUserID();

if (isset($_COOKIE['token']) && !empty($_COOKIE['token']) && ($check != -1)) {
    // Cookie hợp lệ, xử lý tương ứng ở đây
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo "Welcome to PHP server!";
    }
    else if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if ($_SERVER['REQUEST_URI'] === '/login')
        {
            require_once('controller/CustomerController.php');
            $customer = new CustomerController();
            echo json_encode($customer->login());
        }
        else if ($_SERVER['REQUEST_URI'] === '/signup')
        {
            require_once('controller/CustomerController.php');
            $customer = new CustomerController();
            echo json_encode($customer->signup());
        }
    }
} else {
    // Cookie không hợp lệ, xử lý tương ứng ở đây
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo "Welcome to PHP server!";
    }
    else if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if ($_SERVER['REQUEST_URI'] === '/login')
        {
            require_once('controller/CustomerController.php');
            $customer = new CustomerController();
            echo ($customer->login());
        }
        else if ($_SERVER['REQUEST_URI'] === '/signup')
        {
            require_once('controller/CustomerController.php');
            $customer = new CustomerController();
            echo ($customer->signup());
        }
        else 
            echo $_SERVER['REQUEST_URI'];
        
    }
}
?>