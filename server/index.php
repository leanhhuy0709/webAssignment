<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');

require_once('controller/CookieController.php');
require_once('controller/CustomerController.php');
require_once('controller/AdminController.php');


if (strpos($_SERVER['REQUEST_URI'], '/products') !== false)
{
    $customer = new CustomerController();
    echo $customer->getProductsByCategoryAndSearch();
}
else if (strpos($_SERVER['REQUEST_URI'], '/product/detail') !== false)
{
    $customer = new CustomerController();
    echo $customer->getProductDetail();
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
else if ($_SERVER['REQUEST_URI'] === '/cart/payment')
{
    $customer = new CustomerController();
    echo $customer->payment();
}
else if ($_SERVER['REQUEST_URI'] === '/orders')
{
    $customer = new CustomerController();
    echo $customer->getOrders();
}
else if ($_SERVER['REQUEST_URI'] === '/order/detail')
{
    $customer = new CustomerController();
    echo $customer->getOrderDetail();
}
else if ($_SERVER['REQUEST_URI'] === '/category')
{
    $customer = new CustomerController();
    echo $customer->getCategories();
}
else if ($_SERVER['REQUEST_URI'] === '/product/review')
{
    $customer = new CustomerController();
    echo $customer->comment();
}
else if ($_SERVER['REQUEST_URI'] === '/cart/coupon')
{
    $customer = new CustomerController();
    echo $customer->cartApplyCoupon();
}
else if ($_SERVER['REQUEST_URI'] === '/admin/userlist')
{
    $admin = new AdminController();
    echo $admin->getUserList();
}
else if ($_SERVER['REQUEST_URI'] === '/admin/product/add')
{
    $admin = new AdminController();
    echo $admin->addProduct();
}
else if ($_SERVER['REQUEST_URI'] === '/admin/product/update')
{
    $admin = new AdminController();
    echo $admin->updateProduct();
}
else if ($_SERVER['REQUEST_URI'] === '/admin/user/delete')
{
    $admin = new AdminController();
    echo $admin->deleteUser();
}
else if ($_SERVER['REQUEST_URI'] === '/admin/review/delete')
{
    $admin = new AdminController();
    echo $admin->deleteComment();
}
else echo "Welcome to PHP Server!";
?>