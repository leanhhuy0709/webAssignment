function handleLogin() {
    const loginForm = document.getElementById("login-form");
    axios.post('http://localhost/login', {
        username: loginForm.querySelector("#username").value,
        password: loginForm.querySelector("#password").value
    })
    .then(function (response) {
      console.log(response);
      if (response.data)
        window.location.pathname = "/home.html";
      else 
        alert("Tài khoản hoặc mật khẩu sai!")
    })
    .catch(function (error) {
      console.log(error);
    });
}