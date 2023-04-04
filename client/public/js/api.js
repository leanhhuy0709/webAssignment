function handleLogin() {
    const form = document.getElementById("login-form");
    axios.post('http://localhost/login', {
        username: form.querySelector("#username").value,
        password: form.querySelector("#password").value
    })
    .then(function (response) {
      console.log(response);
      alert(response.data.message);
      if (response.data.result)
        window.location.pathname = "/home.html";
    })
    .catch(function (error) {
      console.log(error);
    });
}

function handleSignUp() {
  const form = document.getElementById("signup-form");
  axios.post('http://localhost/signup', {
      username: form.querySelector("#username").value,
      password: form.querySelector("#password").value,
      email: form.querySelector("#email").value,
      phone: form.querySelector("#phone").value,
      fname: form.querySelector("#fname").value,
      lname: form.querySelector("#lname").value,
      gender: form.querySelector("#gender").value,
      age: form.querySelector("#age").value,
      DOB: form.querySelector("#DOB").value
  })
  .then(function (response) {
    console.log(response);
  })
  .catch(function (error) {
    console.log(error);
  });
}

async function getProducts() {
  axios.get('http://localhost/products')
  .then(function (response) {
    console.log(response);
    return response.data;
  })
  .catch(function (error) {
    console.log(error);
  });
}