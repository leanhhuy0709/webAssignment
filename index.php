<?php
require_once('controller/CookieController.php');

$cookie = new CookieController();
$check = $cookie->getUserID();

if (isset($_COOKIE['token']) && !empty($_COOKIE['token']) && ($check != -1)) {
    // Cookie hợp lệ, xử lý tương ứng ở đây
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($_SERVER['REQUEST_URI'] === '/webAssignment/login')
        {
            require_once('view/login.php');
        }
        else if ($_SERVER['REQUEST_URI'] === '/webAssignment/home')
        {
            require_once('view/home.html');
        }
        else if ($_SERVER['REQUEST_URI'] === '/webAssignment/signup')
        {
            require_once('view/signup.php');
        }
        else if ($_SERVER['REQUEST_URI'] === '/webAssignment/aboutus')
        {
            require_once('view/aboutus.php');
        }
        else if ($_SERVER['REQUEST_URI'] === '/webAssignment/admin-updateproduct')
        {
            require_once('view/admin-updateproduct.php');
        }
        else 
            require_once('view/home.html');
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
        if ($_SERVER['REQUEST_URI'] === '/webAssignment/login')
        {
            require_once('view/login.php');
        }
        else if ($_SERVER['REQUEST_URI'] === '/webAssignment/signup')
        {
            require_once('view/signup.php');
        }
        else require_once('view/login.php');
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
}
?>