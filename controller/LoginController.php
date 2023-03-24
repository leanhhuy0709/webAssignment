<?php
class LoginController {
    public function index() {
        require_once('view/login.php');
    }

    public function login() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Kiểm tra thông tin đăng nhập
        if ($username === 'admin' && $password === 'admin') {
            // Nếu thông tin đăng nhập đúng, chuyển hướng đến trang chủ
            header('Location: /webAssignment/home');
            exit();
        } else {
            // Nếu thông tin đăng nhập sai, hiển thị lại trang đăng nhập với thông báo lỗi
            $error = 'Thông tin đăng nhập không chính xác';
            require_once('view/login.php');
        }
    }
}
?>