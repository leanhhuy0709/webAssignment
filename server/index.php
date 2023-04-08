<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');

require_once('controller/CookieController.php');
require_once('controller/CustomerController.php');


if (strpos($_SERVER['REQUEST_URI'], '/products') !== false)
{
    $customer = new CustomerController();
    echo $customer->getProductsByCategoryAndSearch();
}
else if ($_SERVER['REQUEST_URI'] === '/cart')
{
    $customer = new CustomerController();
    echo $customer->getCart();
}
else if ($_SERVER['REQUEST_URI'] === '/user')
{
    $customer = new CustomerController();
    echo $customer->getUserInfo();
}
else if ($_SERVER['REQUEST_URI'] === '/product/detail')
{
    $customer = new CustomerController();
    echo $customer->getProductDetail();
}
else if ($_SERVER['REQUEST_URI'] === '/login')
{
    $customer = new CustomerController();
    echo $customer->login();
}
else if ($_SERVER['REQUEST_URI'] === '/signup')
{
    $customer = new CustomerController();
    echo $customer->signup();
}
else if ($_SERVER['REQUEST_URI'] === '/user/update')
{
    $customer = new CustomerController();
    echo $customer->updateUserInfo();
}
else if ($_SERVER['REQUEST_URI'] === '/cart/add')
{
    $customer = new CustomerController();
    echo $customer->addProductToCart();
}
else if ($_SERVER['REQUEST_URI'] === '/cart/delete')
{
    $customer = new CustomerController();
    echo $customer->deleteProductToCart();
}
else if ($_SERVER['REQUEST_URI'] === '/category')
{
    $customer = new CustomerController();
    echo $customer->getCategories();
}
else echo "Welcom to PHP server!";
?>