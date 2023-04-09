// Lấy cookie từ trình duyệt
function getHTML(id, file)
{
    //get tag by id
    const tag = document.getElementById(id);
        //load nav.html to nav
        fetch(file)
        .then(response=> response.text())
        .then(text => 
        {
            tag.innerHTML = text;
        });
}

function getCookieValueByName(cname)
{
    var cookieList = document.cookie.split(";");
    for (var i = 0; i < cookieList.length; i++)
    {
        var cookie = cookieList[i];
        while (cookie.charAt(0) == ' ')
        {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(cname) == 0)
        {
            return cookie.substring(cname.length + 1, cookie.length);
        }
    }
}
// Xử lý khi người dùng click vào nút đăng nhập
function handleLogin()
{
    const form = document.getElementById("login-form");
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/login", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onload = function() {
        console.log(this.responseText);
        var response = JSON.parse(this.responseText);
        alert(response.message);
        if (response.result)
        {
            var token = response.token;
            var time = new Date();
            time.setTime(time.getTime() + (1 * 60 * 60 * 1000));   // 1 hour
            document.cookie = "token=" + token + "; expires=" + time.toUTCString() + "; path=/";
            window.location.pathname = "/home.html";
        }
    }
    
    const data = JSON.stringify({
        username: form.querySelector("#username").value,
        password: form.querySelector("#password").value
    });
    xhr.send(data);
}

function handleSignUp() {
    const form = document.getElementById("signup-form");
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/signup", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onload = function() {
        //console.log(this.responseText);
        alert("Sign up successfully!");
        window.location.pathname = "/login.html";
    }
    
    const data = JSON.stringify({
        username: form.querySelector("#username").value,
        password: form.querySelector("#password").value,
        email: form.querySelector("#email").value,
        phone: form.querySelector("#phone").value,
        fname: form.querySelector("#fname").value,
        lname: form.querySelector("#lname").value,
        gender: form.querySelector("#gender").value,
        age: form.querySelector("#age").value,
        DOB: form.querySelector("#DOB").value,
        imageURL: form.querySelector("#imageURL").value
    });
    xhr.send(data);
}

function handleResponseUser(response) {
    //console.log(response);
    const updateForm = document.getElementById('update-form');
    updateForm.querySelector('#fname').value = response.fname;
    updateForm.querySelector('#lname').value = response.lname;
    updateForm.querySelector('#dob').value = response.DOB;
    updateForm.querySelector('#phone').value = response.phoneNumber;
    updateForm.querySelector('#email').value = response.email;
    updateForm.querySelector('#address').value = response.address[0];
    updateForm.querySelector('#imageURL').value = response.imageURL;
    const userImage = document.getElementById('user-image');
    userImage.src = response.imageURL;
}

function getUserInfo() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        console.log(this.responseText)
        if(!JSON.parse(this.responseText).result) {
            alert(JSON.parse(this.responseText).message);
        }
        else {
            var res = JSON.parse(this.responseText).data;
            handleResponseUser(res);
        }
    }
    xhttp.onerror = function(err) {
        console.log("Error");
        console.log(err);
    }

    // Tạo object chứa token
    const data = {
        token: getCookieValueByName('token')
    };

    // Chuyển object thành chuỗi JSON
    const jsonData = JSON.stringify(data);

    xhttp.open("POST", "http://localhost/user");
    xhttp.setRequestHeader("Content-Type", "application/json"); // Thiết lập header cho request
    xhttp.send(jsonData); // Gửi request với body là chuỗi JSON
}

function handleUpdateUser() {
    const updateForm = document.getElementById('update-form');
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "http://localhost/user/update", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.onload = function() {
        console.log(this.responseText);
        var res = JSON.parse(this.responseText);
        console.log(res);
        alert(res.message);
    }
    xhttp.onerror = function(err) {
        console.log("Error");
        console.log(err);
    }
    const data = JSON.stringify({
        token: getCookieValueByName('token'),
        fname: updateForm.querySelector('#fname').value,
        lname: updateForm.querySelector('#lname').value,
        DOB: updateForm.querySelector('#dob').value,
        phone: updateForm.querySelector('#phone').value,
        email: updateForm.querySelector('#email').value,
        address: updateForm.querySelector('#address').value,
        imageURL: updateForm.querySelector('#imageURL').value
    });
    xhttp.send(data);

}

function getCart() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        //console.log(this.responseText);

        if(!JSON.parse(this.responseText).result) {
            alert(JSON.parse(this.responseText).message);
        }   
        else {
            var res = JSON.parse(this.responseText).data;
            handleResponseCart(res);
        }   
    }
    xhttp.onerror = function(err) {
        console.log("Error");
        console.log(err);
    }

    // Tạo object chứa token
    const data = {
        token: getCookieValueByName('token')
    };

    // Chuyển object thành chuỗi JSON
    const jsonData = JSON.stringify(data);

    xhttp.open("POST", "http://localhost/cart");
    xhttp.setRequestHeader("Content-Type", "application/json"); // Thiết lập header cho request
    xhttp.send(jsonData); // Gửi request với body là chuỗi JSON
}

function handleResponseCart(products) {
    console.log(products);
    const productDiv = document.getElementById("cart");
    productDiv.innerHTML = "";
    var result = "";
    products.forEach((product)=>{
        result += `
            <div class="card m-3" style="width: 18rem;">
                <img src="./images/${product.imageURL}" class="card-img-top" alt="product 1">
                <div class="card-body">
                    <h5 class="card-title">${product.name}</h5>
                    <p class="card-text">${product.description}</p>
                    <p class="card-text">Price: ${product.price}</p>
                    <p class="card-text">Quantity: ${product.quantity}</p>
                    <button onclick="handleAddToCart(${product.productID})">Add to cart</button>
                    <button onclick="handleDeleteToCart(${product.productID})">Delete to cart</button>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>`;
    })
    productDiv.innerHTML = result;
}

function handleAddToCart(id) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        var res = JSON.parse(this.responseText);
        console.log(res);
        alert(res.message);
        if (window.location.pathname == "/cart.html")
            getCart();
    }
    xhttp.onerror = function(err) {
        console.log("Error");
        console.log(err);
    }
    const data = JSON.stringify({
        token: getCookieValueByName('token'),
        productID: id,
        quantity: 1
    });
    xhttp.open("POST", "http://localhost/cart/add");
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(data);
}

function handleDeleteToCart(id) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        var res = JSON.parse(this.responseText);
        console.log(res);
        alert(res.message);
        if (window.location.pathname == "/cart.html")
            getCart();
    }
    xhttp.onerror = function(err) {
        console.log("Error");
        console.log(err);
    }
    const data = JSON.stringify({
        token: getCookieValueByName('token'),
        productID: id,
        quantity: 1
    });
    xhttp.open("POST", "http://localhost/cart/delete");
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(data);
}

function handlePayment(paymentMethod)
{
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        console.log(this.responseText);
        var res = JSON.parse(this.responseText);
        console.log(res);
        alert(res.message);
    }
    xhttp.onerror = function(err) {
        console.log("Error");
        console.log(err);
    }
    const data = JSON.stringify({
        token: getCookieValueByName('token'),
        paymentMethod: paymentMethod
    });
    xhttp.open("POST", "http://localhost/cart/payment");
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(data);
}
