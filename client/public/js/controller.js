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
        createModal(response.message);
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
        username: form.querySelector("#login-username").value,
        password: form.querySelector("#login-password").value
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
        createModal("Sign up successfully!");
        window.location.pathname = "/signup-login.html";
    }
    
    const data = JSON.stringify({
        username: form.querySelector("#username").value,
        password: form.querySelector("#password").value,
        email: form.querySelector("#email").value,
        phone: form.querySelector("#phone").value,
        fname: form.querySelector("#fname").value,
        lname: form.querySelector("#lname").value,
        gender: document.querySelector('input[name="gender"]:checked').value,
        age: form.querySelector("#age").value,
        DOB: form.querySelector("#DOB").value,
        imageURL: form.querySelector("#imageURL").value
    });
    xhr.send(data);
}

function handleResponseUser(response, isEdit = false) {

    const userInfo = document.getElementById('user-info');
    userInfo.innerHTML = `<div class="container py-5">
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="${response.imageURL}" alt="avatar"
                    class="rounded-circle img-fluid" style="width: 150px;">
                    <h5 class="my-3">${response.fname + " " + response.lname}</h5>
                    <p class="text-muted mb-1">${response.username}</p>
                    <p class="text-muted mb-4">${response.address[0]}</p>
                    <div class="d-flex justify-content-center mb-2">
                        <button type="button" class="btn m-1 btn-brand-color" onclick="editUserProfile()">Edit</button>
                        <button type="button" class="btn m-1 btn-brand-color" onclick="${isEdit?"handleUpdateUser()":"createModal('You have to press edit before updating!', false)"}">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <form id="update-form">
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0">First Name</p></div>
                        <div class="col-sm-9"><p class="text-muted mb-0">${isEdit?'<input id="fname" class="input w-100" value="' + response.fname + '">':response.fname}</p></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0">Last Name</p></div>
                        <div class="col-sm-9"><p class="text-muted mb-0">${isEdit?'<input id="lname" class="input w-100" value="' + response.lname + '">':response.lname}</p></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0">Date of birth</p></div>
                        <div class="col-sm-9"><p class="text-muted mb-0">${isEdit?'<input id="dob" class="input w-100" value="' + response.DOB + '" type="date">':response.DOB}</p></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0">Phone number</p></div>
                        <div class="col-sm-9"><p class="text-muted mb-0">${isEdit?'<input id="phone" class="input w-100" value="' + response.phoneNumber + '">':response.phoneNumber}</p></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0">Email</p></div>
                        <div class="col-sm-9"><p class="text-muted mb-0">${isEdit?'<input id="email" class="input w-100" value="' + response.email + '">':response.email}</p></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0">Address</p></div>
                        <div class="col-sm-9"><p class="text-muted mb-0">${isEdit?'<input id="address" class="input w-100" value="' + response.address[0] + '">':response.address[0]}</p></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0">ImageURL</p></div>
                        <div class="col-sm-9"><p class="text-muted mb-0">${isEdit?'<input id="imageURL" class="input w-100" value="' + response.imageURL + '">':response.imageURL}</p></div>
                    </div><hr>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>`;

}

function editUserProfile() {
    getUserInfo(true);
}

function getUserInfo(isEdit = false) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        console.log(this.responseText)
        if(!JSON.parse(this.responseText).result) {
            createModal(JSON.parse(this.responseText).message, false);
        }
        else {
            var res = JSON.parse(this.responseText).data;
            handleResponseUser(res, isEdit);
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
        createModal(res.message);
        getUserInfo();
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
            createModal(JSON.parse(this.responseText).message, false);
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
            <div class="product">
                <img src="${product.imageURL}" alt="product 1">
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
        createModal(res.message);
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

function buyNow(pID) {
    handleAddToCart(pID);
    window.location.pathname = "/cart.html";
}

function handleLogout()
{
    var time = new Date();
    time.setTime(time.getTime());
    document.cookie = "token=a; expires=" + time.toUTCString() + "; path=/";
    window.location.pathname = "/signup-login.html";
}

function handleDeleteToCart(id) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        console.log(this.responseText);
        var res = JSON.parse(this.responseText);
        console.log(res);
        createModal(res.message);
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
        createModal(res.message);
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

function getProducts(searchInput = "", page = 1) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        //console.log(this.responseText);
        if(!JSON.parse(this.responseText).result) {
            createModal(JSON.parse(this.responseText).message, false);
        }   
        else {
            var res = JSON.parse(this.responseText).data;
            showProducts(res, searchInput, page);
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
function showProducts(products, searchInput, page = 1)
{
    const productDiv = document.getElementById("product-list");
    productDiv.innerHTML = "";
    var result = "";
    var pS = (page - 1) * 6, pE = pS + 6;
    products.slice(pS, pE).forEach((product)=>{
        result += `
            <div class="card m-3 d-inline-block" style="width: 18rem;">
                <img src="${product.imageURL}" class="card-img-top" onerror="this.onerror=null; this.src='https://media.istockphoto.com/id/1216251206/vector/no-image-available-icon.jpg?s=170667a&w=0&k=20&c=N-XIIeLlhUpm2ZO2uGls-pcVsZ2FTwTxZepwZe4DuE4=';">
                <div class="card-body">
                    <h5 class="card-title">${product.name}</h5>
                    <p class="card-text">${product.description}</p>
                    <a href="./product-detail.html?productID=${product.productID}" class="btn btn-primary">Go somewhere</a>
                    <button onclick="handleAddToCart(${product.productID})" class="btn btn-primary">Add to cart</button>
                </div>
            </div>`;
    })
    productDiv.innerHTML = result;
    const pageDiv = document.getElementById("page-list");
    pageDiv.className = "d-flex justify-content-center"
    pageDiv.innerHTML = "";
    result = "";
    var maxPage = Math.ceil(products.length / 6);
    for (var i = 1; i <= maxPage; i++) {
        result += `<button class="btn btn-primary m-2" onclick="getProducts('${searchInput}', ${i})">${i}</button>`;
    }
    pageDiv.innerHTML = result;

}
function getCategories()
{
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        //console.log(this.responseText);
        if(!JSON.parse(this.responseText).result) {
            createModal(JSON.parse(this.responseText).message, false);
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
            createModal(JSON.parse(this.responseText).message, false);
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
            createModal(JSON.parse(this.responseText).message, false);
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
                <img src="${product.imageURL}" class="card-img-top" alt="product 1">
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
    const form = document.getElementById("signup-form");
    var username = form.querySelector("#username").value;
    var password = form.querySelector("#password").value;
    var email = form.querySelector("#email").value;
    var phone = form.querySelector("#phone").value;
    var firstName = form.querySelector("#fname").value;
    var lastName = form.querySelector("#lname").value;
    var gender = document.querySelector('input[name="gender"]:checked').value;
    var age = form.querySelector("#age").value;
    var DOB = form.querySelector("#DOB").value;
    var imageURL = form.querySelector("#imageURL").value;
    var regex = /\S+@\S+\.\S+/;

    if (!regex.test(email)) {
        createModal("Invalid email address", false);
        return false;
    }
    if (phone.length != 10){
        createModal("Invalid phone", false);
        return false;
    }
    if (firstName.length < 2 || firstName.length > 30){
        createModal("Invalid first name.", false);
        return false;
    }
    if (lastName.length < 2 || lastName.length > 30){
        createModal("Invalid last name.", false);
        return false;
    }
    if (age < 0){
        createModal("Invalid age", false);
        return false;
    }
    if (imageURL.length >= 1000){
        createModal("Invalid link", false);
        return false;
    }
}

function createModal(message, isSuccess = true) {
    var color = isSuccess ? "success" : "danger";
    var modalHtml = '<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">';
    modalHtml += '<div class="modal-dialog" role="document">';
    modalHtml += '<div class="modal-content">';
    modalHtml += '<div class="modal-header bg-' + color + '">';
    modalHtml += '<h5 class="modal-title" id="alertModalLabel">Alert</h5>';
    modalHtml += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    modalHtml += '<span aria-hidden="true">&times;</span>';
    modalHtml += '</button>';
    modalHtml += '</div>';
    modalHtml += '<div class="modal-body">';
    modalHtml += '<p>' + message + '</p>';
    modalHtml += '</div>';
    modalHtml += '<div class="modal-footer">';
    modalHtml += '<button type="button" class="btn btn-' + color + '" data-dismiss="modal">OK</button>';
    modalHtml += '</div>';
    modalHtml += '</div>';
    modalHtml += '</div>';
    modalHtml += '</div>';
  
    $(modalHtml).modal('show');
}
  
  
// Check cookie is valid!
if (getCookieValueByName('token')) {
}
else 
{
    if (window.location.pathname != "/signup-login.html")
    {
        window.location.pathname = "/signup-login.html";
    }
}
