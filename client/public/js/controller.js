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
    if(validateForm() == false){
        return;
    }
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

function handleLogout()
{
    var time = new Date();
    time.setTime(time.getTime() - (1 * 60 * 60 * 1000));   // 1 hour
    document.cookie = "token=a; expires=" + time.toUTCString() + "; path=/";
    window.location.pathname = "/login.html";
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

function getProducts(searchInput = "") {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        //console.log(this.responseText);
        if(!JSON.parse(this.responseText).result) {
            alert(JSON.parse(this.responseText).message);
        }   
        else {
            var res = JSON.parse(this.responseText).data;
            showProducts(res);
        }   
    }
    xhttp.open("GET", "http://localhost/products?search="+searchInput, true);
    xhttp.send();
}
function handleSearch()
{
    if (window.location.pathname != "/product.html")
        window.location.pathname = "/product.html";
    const searchInput = document.getElementById("search");
    getProducts(searchInput.value);
}
function showProducts(products)
{
    const productDiv = document.getElementById("product-list");
    productDiv.innerHTML = "";
    var result = "";
    products.forEach((product)=>{
        result += `
            <div class="card m-3 d-inline-block" style="width: 18rem;">
                <img src="${product.imageURL}" class="card-img-top" onerror="this.onerror=null; this.src='https://media.istockphoto.com/id/1216251206/vector/no-image-available-icon.jpg?s=170667a&w=0&k=20&c=N-XIIeLlhUpm2ZO2uGls-pcVsZ2FTwTxZepwZe4DuE4=';">
                <div class="card-body">
                    <h5 class="card-title">${product.name}</h5>
                    <p class="card-text">${product.description}</p>
                    <a href="./product-detail.html?productID=${product.productID}" class="btn btn-primary">Go somewhere</a>
                    <button onclick="handleAddToCart(${product.productID})">Add to cart</button>
                </div>
            </div>`;
    })
    productDiv.innerHTML = result;
}
function getCategories()
{
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        //console.log(this.responseText);
        if(!JSON.parse(this.responseText).result) {
            alert(JSON.parse(this.responseText).message);
        }   
        else {
            var res = JSON.parse(this.responseText).data;
            showCategories(res);
        }   
    }
    xhttp.open("GET", "http://localhost/category", true);
    xhttp.send();
}
function showCategories(categories)
{
    const categoryDiv = document.getElementById("category-list");
    categoryDiv.innerHTML = "";
    var result = "";
    categories.forEach((category)=>{
        result += `<h3>${category.name}</h3>`;
    })
    categoryDiv.innerHTML = result;
}

function getOrder()
{
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        //console.log(this.responseText);

        if(!JSON.parse(this.responseText).result) {
            alert(JSON.parse(this.responseText).message);
        }   
        else {
            var res = JSON.parse(this.responseText).data;
            console.log(res);
            handleResponseOrder(res);
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

    xhttp.open("POST", "http://localhost/orders");
    xhttp.setRequestHeader("Content-Type", "application/json"); // Thiết lập header cho request
    xhttp.send(jsonData); // Gửi request với body là chuỗi JSON
}

function handleResponseOrder(orders) {
    console.log(orders);
    const orderDiv = document.getElementById("order");
    orderDiv.innerHTML = "";
    var result = "";
    orders.forEach((order)=>{
        //show block which have orderID, orderDate, shippingDate, completeDate, totalPrice, shippingAddress, paymentMethod, orderStatus of order
        result += `<div class="card m-3" style="width: 18rem;">
                <div class="card-body">
                <h5 class="card-title">Order ID: ${order.orderID}</h5>
                <p class="card-text">Order Date: ${order.orderDate}</p>
                <p class="card-text">Shipping Date: ${order.shippingDate}</p>
                <p class="card-text">Complete Date: ${order.completeDate?order.completeDate:"None"}</p>
                <p class="card-text">Total Price: ${order.totalPrice}</p>
                <p class="card-text">Shipping Address: ${order.shippingAddress}</p>
                <p class="card-text">Payment Method: ${order.paymentMethod}</p>
                <p class="card-text">Order Status: ${order.orderStatus}</p>
                <button onclick="handleOrderDetail(${order.orderID})">Order Detail</button>
                </div>
            </div>
        `;
    })
    orderDiv.innerHTML = result;
}


function getOrderDetail() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        //console.log(this.responseText);

        if(!JSON.parse(this.responseText).result) {
            alert(JSON.parse(this.responseText).message);
        }   
        else {
            var res = JSON.parse(this.responseText).data;
            handleResponseOrderDetail(res);
        }   
    }
    xhttp.onerror = function(err) {
        console.log("Error");
        console.log(err);
    }

    // Tạo object chứa token
    const data = {
        token: getCookieValueByName('token'),
        orderID: window.location.search.split("=")[1]
    };

    // Chuyển object thành chuỗi JSON
    const jsonData = JSON.stringify(data);

    xhttp.open("POST", "http://localhost/order/detail");
    xhttp.setRequestHeader("Content-Type", "application/json"); // Thiết lập header cho request
    xhttp.send(jsonData); // Gửi request với body là chuỗi JSON
}


function handleResponseOrderDetail(order) {
    const orderDetailDiv = document.getElementById("order-detail");
    orderDetailDiv.innerHTML = "";
    //show order detail: orderID, orderDate, shippingDate, completeDate, totalPrice, shippingAddress, paymentMethod, orderStatus of order
    var result = `<div class="card m-3" style="width: 18rem;">
                <div class="card-body">
                <h5 class="card-title">Order ID: ${order.orderID}</h5>
                <p class="card-text">Order Date: ${order.orderDate}</p>
                <p class="card-text">Shipping Date: ${order.shippingDate}</p>
                <p class="card-text">Complete Date: ${order.completeDate?order.completeDate:"None"}</p>
                <p class="card-text">Total Price: ${order.totalPrice}</p>
                <p class="card-text">Shipping Address: ${order.shippingAddress}</p>
                <p class="card-text">Payment Method: ${order.paymentMethod}</p>
                <p class="card-text">Order Status: ${order.orderStatus}</p>
                </div>
                </div>
    `;

    order.products.forEach((product)=>{
        result += `
            <div class="card m-3" style="width: 18rem;">
                <img src="./images/${product.imageURL}" class="card-img-top" alt="product 1">
                <div class="card-body">
                    <h5 class="card-title">${product.name}</h5>
                    <p class="card-text">${product.description}</p>
                    <p class="card-text">Price: ${product.price}</p>
                    <p class="card-text">Quantity: ${product.quantity}</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>`;
    })
    orderDetailDiv.innerHTML = result;
}

// Kiểm tra dữ liệu đầu vào
function validateForm() {
    // có nên đổi thứ tự ở đây ko ?
    var username = form.querySelector("#username").value;
    var password = form.querySelector("#password").value;
    var email = form.querySelector("#email").value;
    var phone = form.querySelector("#phone").value;
    var firstName = form.querySelector("#fname").value;
    var lastName = form.querySelector("#lname").value;
    var gender = form.querySelector("#gender").value;
    var age = form.querySelector("#age").value;
    var DOB = form.querySelector("#DOB").value;
    var imageURL = form.querySelector("#imageURL").value;
    var regex = /\S+@\S+\.\S+/;

    if (!regex.test(email)) {
        alert("Invalid email address");
        return false;
    }
    if (phone.length != 10){
        alert("Invalid phone");
        return false;
    }
    if (firstName.length < 2 || firstName.length > 30){
        alert("Invalid first name.");
        return false;
    }
    if (lastName.length < 2 || lastName.length > 30){
        alert("Invalid last name.");
        return false;
    }
    if (age < 0){
        alert("Invalid age");
        return false;
    }
    if (imageURL.length < 100){
        alert("Invalid link");
        return false;
    }
    
}