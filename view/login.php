<form method="POST" action="/webAssignment/login">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <label for="username">Tên đăng nhập:</label>
    <input type="text" name="username" name="username">
    <br>
    <label for="password">Mật khẩu:</label>
    <input type="password" name="password" name="password">
    <br>
    <input type="submit" value="Đăng nhập">
</form>