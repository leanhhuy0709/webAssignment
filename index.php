<?php


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_SERVER['REQUEST_URI'] === '/webAssignment/login')
    {
        require_once('view/login.php');
    }
    else if ($_SERVER['REQUEST_URI'] === '/webAssignment/home')
    {
        require_once('view/home.php');
    }
    else 
        require_once('view/home.php');
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    require_once('controller/LoginController.php');
    if ($_SERVER['REQUEST_URI'] === '/webAssignment/login')
    {
        $loginController = new LoginController();
        $loginController->login();
    }
}


?>