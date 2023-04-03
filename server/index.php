<?php
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
        
        if ($_SERVER['REQUEST_URI'] === '/webAssignment/login')
        {
            require_once('controller/CustomerController.php');
            $customer = new CustomerController();
            $customer->login();
        }
        else if ($_SERVER['REQUEST_URI'] === '/webAssignment/signup')
        {
            require_once('controller/CustomerController.php');
            $customer = new CustomerController();
            $customer->signup();
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
            $customer->login();
        }
        else if ($_SERVER['REQUEST_URI'] === '/signup')
        {
            require_once('controller/CustomerController.php');
            $customer = new CustomerController();
            $customer->signup();
        }
        
    }
}
?>