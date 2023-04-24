
function getHTML(id, file) {
    if(file == "nav.html")
    {
        if (localStorage.getItem("isAdmin") === 'true')
        {

        }
        else 
        {
            file = "nav-not-admin.html";
        }
    }
    //get tag by id
    const tag = document.getElementById(id);
    //load nav.html to nav
    fetch(file)
        .then(response => response.text())
        .then(text => {
            tag.innerHTML = text;
        });
}
// Lấy cookie từ trình duyệt
function getCookieValueByName(cname) {
    var cookieList = document.cookie.split(";");
    for (var i = 0; i < cookieList.length; i++) {
        var cookie = cookieList[i];
        while (cookie.charAt(0) == ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(cname) == 0) {
            return cookie.substring(cname.length + 1, cookie.length);
        }
    }
}
// Xử lý khi người dùng click vào nút đăng nhập
function handleLogin() {
    const form = document.getElementById("login-form");
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/login", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onload = function () {
        console.log(this.responseText);
        var response = JSON.parse(this.responseText);
        createModal(response.message, response.result);
        if (response.result) {
            var token = response.token;
            var time = new Date();
            time.setTime(time.getTime() + (1 * 60 * 60 * 1000));   // 1 hour
            document.cookie = "token=" + token + "; expires=" + time.toUTCString() + "; path=/";
            window.location.pathname = "/home.html";
            localStorage.setItem("isAdmin") = response.isAdmin;
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
    if (validateForm() == false) {
        return;
    }
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/signup", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onload = function () {
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
        imageURL: form.querySelector("#imageURL").value,
        address: form.querySelector("#address").value
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
                    class="rounded-circle img-fluid" style="width: 150px;"
                    onerror="this.onerror=null; this.src='https://static.vecteezy.com/system/resources/previews/008/442/086/original/illustration-of-human-icon-user-symbol-icon-modern-design-on-blank-background-free-vector.jpg';">
                    <h5 class="my-3">${response.fname + " " + response.lname}</h5>
                    <p class="text-muted mb-1">${response.username}</p>
                    <p class="text-muted mb-4">${response.address}</p>
                    <div class="d-flex justify-content-center mb-2">
                        <button type="button" class="btn m-1 btn-brand-color" onclick="editUserProfile()">Edit</button>
                        <button type="button" class="btn m-1 btn-brand-color" onclick="${isEdit ? "handleUpdateUser()" : "createModal('You have to press edit before updating!', false)"}">Update</button>
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
                        <div class="col-sm-9"><p class="text-muted mb-0">${isEdit ? '<input id="fname" class="input w-100" value="' + response.fname + '">' : response.fname}</p></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0">Last Name</p></div>
                        <div class="col-sm-9"><p class="text-muted mb-0">${isEdit ? '<input id="lname" class="input w-100" value="' + response.lname + '">' : response.lname}</p></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0">Date of birth</p></div>
                        <div class="col-sm-9"><p class="text-muted mb-0">${isEdit ? '<input id="dob" class="input w-100" value="' + response.DOB + '" type="date">' : response.DOB}</p></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0">Phone number</p></div>
                        <div class="col-sm-9"><p class="text-muted mb-0">${isEdit ? '<input id="phone" class="input w-100" value="' + response.phoneNumber + '">' : response.phoneNumber}</p></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0">Email</p></div>
                        <div class="col-sm-9"><p class="text-muted mb-0">${isEdit ? '<input id="email" class="input w-100" value="' + response.email + '">' : response.email}</p></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0">Address</p></div>
                        <div class="col-sm-9"><p class="text-muted mb-0">${isEdit ? '<input id="address" class="input w-100" value="' + response.address + '">' : response.address}</p></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0">ImageURL</p></div>
                        <div class="col-sm-9"><p class="text-muted mb-0">${isEdit ? '<input id="imageURL" class="input w-100" value="' + response.imageURL + '">' : response.imageURL}</p></div>
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
    xhttp.onload = function () {
        console.log(this.responseText)
        if (!JSON.parse(this.responseText).result) {
            createModal(JSON.parse(this.responseText).message, false);
        }
        else {
            var res = JSON.parse(this.responseText).data;
            handleResponseUser(res, isEdit);
        }
    }
    xhttp.onerror = function (err) {
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
    xhttp.onload = function () {
        console.log(this.responseText);
        var res = JSON.parse(this.responseText);
        console.log(res);
        createModal(res.message);
        getUserInfo();
    }
    xhttp.onerror = function (err) {
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
    xhttp.onload = function () {
        //console.log(this.responseText);

        if (!JSON.parse(this.responseText).result) {
            createModal(JSON.parse(this.responseText).message, false);
        }
        else {
            var res = JSON.parse(this.responseText).data;
            handleResponseCart(res);
        }
    }
    xhttp.onerror = function (err) {
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
    const productDiv = document.getElementById("cart-products");
    productDiv.innerHTML = "";
    var result = "";

    if (products.total == 0) {
        productDiv.innerHTML = `<div class="cart-empty">Cart empty</div>`;
    }
    else {
        products.data.forEach((product) => {
            result += `
                <div class="product">
                    <div class="img"><img src="${product.imageURL}" alt="product 1"></div>
                    <div class="info">
                        <h5>${product.name}</h5>
                        <div class="quantity-price">
                            <button onclick="handleAddToCart(${product.productID})"><span>&#43;</span></button>
                            <div class="quantity">${product.quantity}</div>
                            <button onclick="handleDeleteToCart(${product.productID})"><span>&#8722;</span></button>
                            <div>Price: ${product.price}</div>
                            <div id="total">${product.total}</div>
                        </div>
                    </div>
                </div>`;
        })
        productDiv.innerHTML = result;
    }

    const infoDiv = document.getElementById("cart-info");
    infoDiv.innerHTML = `
    <p>couponName: ${products.couponName} </p>
    <p>couponPercent: ${products.couponPercent} %</p>
    <p>couponValue: ${products.couponValue}</p>
    <p>total: ${products.total}</p>
    <p>shippingCost: ${products.shippingCost}</p>
    <p>totalWithShipping: ${products.totalWithShipping}</p>
    <p>totalWithShippingAndCoupon: ${products.totalWithShippingAndCoupon}</p>
    <p>Coupon: <input id="coupon"></p>
    <button onclick="handleApplyCoupon()">Apply</button>
    `;
}

function handleAddToCart(id) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        var res = JSON.parse(this.responseText);
        console.log(res);
        createModal(res.message);
        if (window.location.pathname == "/cart.html")
            getCart();
    }
    xhttp.onerror = function (err) {
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

function handleLogout() {
    var time = new Date();
    time.setTime(time.getTime());
    document.cookie = "token=a; expires=" + time.toUTCString() + "; path=/";
    window.location.pathname = "/signup-login.html";
    localStorage.clear();
}

function handleDeleteToCart(id, num = 1) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        //console.log(this.responseText);
        var res = JSON.parse(this.responseText);
        //console.log(res);
        createModal(res.message);
        if (window.location.pathname == "/cart.html")
            getCart();
    }
    xhttp.onerror = function (err) {
        console.log("Error");
        console.log(err);
    }
    const data = JSON.stringify({
        token: getCookieValueByName('token'),
        productID: id,
        quantity: num
    });
    xhttp.open("POST", "http://localhost/cart/delete");
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(data);
}

function handlePayment(paymentMethod) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        //console.log(this.responseText);
        var res = JSON.parse(this.responseText);
        //console.log(res);
        createModal(res.message, res.result);
        getCart();
    }
    xhttp.onerror = function (err) {
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

function getProducts(page = 1) {
    var searchInput = "", categoryInput = "";
    var list = window.location.search.split("&");
    //delete first char in list[0]
    list[0] = list[0].substring(1);

    for (var i = 0; i < list.length; i++) {
        tmp = list[i].split("=");
        if (tmp[0] == "search")
            searchInput = tmp[1];
        else if (tmp[0] == "category")
            categoryInput = tmp[1];
    }


    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        //console.log(this.responseText);
        if (!JSON.parse(this.responseText).result) {
            createModal(JSON.parse(this.responseText).message, false);
        }
        else {
            var res = JSON.parse(this.responseText).data;
            showProducts(res, page);
        }
    }
    xhttp.open("GET", "http://localhost/products?search=" + searchInput + "&category=" + categoryInput, true);
    xhttp.send();
}
function handleSearch() {
    const searchInput = document.getElementById("search");
    var pn = window.location.pathname;
    var host = window.location.origin;
    if (pn != "/new.html" && pn != "/sale.html" && pn != "/category.html") {
        window.location.href = host + "/new.html?search=" + searchInput.value;
    }
    else
        window.location.href = host + pn + "?search=" + searchInput.value;
}
function showProducts(products, page = 1) {
    const productDiv = document.getElementById("product-list");
    productDiv.innerHTML = "";
    var result = "";
    var pS = (page - 1) * 6, pE = pS + 6;
    products.slice(pS, pE).forEach((product) => {
        result += `
            <div class="card" style="width: 30%; margin: 0 3% 3% 0">
                <img src="${product.imageURL}" class="card-img-top" onerror="this.onerror=null; this.src='https://media.istockphoto.com/id/1216251206/vector/no-image-available-icon.jpg?s=170667a&w=0&k=20&c=N-XIIeLlhUpm2ZO2uGls-pcVsZ2FTwTxZepwZe4DuE4=';">
                <div class="card-body" style="height:25%">
                    <h5 class="card-title" style="text-align:center; font-size:2vw;" id="productcart-name">${product.name}</h5>
                    <p class="card-text" style="text-align:center; font-weight: bold; font-size:2vw;">Price: $${product.price}</p>
                </div>
                <div class="card-footer" style="text-align:center;"> 
                    <a href="./product-detail.html?productID=${product.productID}" class="btn btn-dark" style="text-align:center; font-size:2vw; width: 100%; border-radius: 10px">Detail</a>
                    <button onclick="handleAddToCart(${product.productID})" class="btn btn-danger" style="text-align:center; font-size:2vw; width: 100%; margin-top: 3%; border-radius: 10px">Add to cart</button>
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
        result += `<button class="btn btn-primary m-2" onclick="getProducts(${i})">${i}</button>`;
    }
    pageDiv.innerHTML = result;

}
function getCategories() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        //console.log(this.responseText);
        if (!JSON.parse(this.responseText).result) {
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
function showCategories(categories) {
    const categoryDiv = document.getElementById("category-list");
    categoryDiv.innerHTML = "";
    var result = "";
    categories.forEach((category) => {
        result += `<h3>${category.name}</h3>`;
    })
    categoryDiv.innerHTML = result;
}

function getOrder() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        //console.log(this.responseText);

        if (!JSON.parse(this.responseText).result) {
            createModal(JSON.parse(this.responseText).message, false);
        }
        else {
            var res = JSON.parse(this.responseText).data;
            //console.log(res);
            handleResponseOrder(res);
        }
    }
    xhttp.onerror = function (err) {
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
    //console.log(orders);
    const orderDiv = document.getElementById("order");
    orderDiv.innerHTML = "";
    var result = "";
    orders.forEach((order) => {
        //show block which have orderID, orderDate, shippingDate, completeDate, totalPrice, shippingAddress, paymentMethod, orderStatus of order
        result += `<div class="card m-3" style="width: 18rem;">
                <div class="card-body">
                <h5 class="card-title">Order ID: ${order.orderID}</h5>
                <p class="card-text">Order Date: ${order.orderDate}</p>
                <p class="card-text">Shipping Date: ${order.shippingDate}</p>
                <p class="card-text">Complete Date: ${order.completeDate ? order.completeDate : "None"}</p>
                <p class="card-text">Total Price: ${order.totalPrice}</p>
                <p class="card-text">Shipping Address: ${order.shippingAddress}</p>
                <p class="card-text">Payment Method: ${order.paymentMethod}</p>
                <p class="card-text">Order Status: ${order.orderStatus}</p>
                <a class="btn btn-primary" href="./order-detail.html?orderID=${order.orderID}">Order Detail</a>
                </div>
            </div>
        `;
    })
    orderDiv.innerHTML = result;
}


function getOrderDetail() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        //console.log(this.responseText);

        if (!JSON.parse(this.responseText).result) {
            createModal(JSON.parse(this.responseText).message, false);
        }
        else {
            var res = JSON.parse(this.responseText).data;
            handleResponseOrderDetail(res);
        }
    }
    xhttp.onerror = function (err) {
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
                <p class="card-text">Complete Date: ${order.completeDate ? order.completeDate : "None"}</p>
                <p class="card-text">Total Price: ${order.totalPrice}</p>
                <p class="card-text">Shipping Address: ${order.shippingAddress}</p>
                <p class="card-text">Payment Method: ${order.paymentMethod}</p>
                <p class="card-text">Order Status: ${order.orderStatus}</p>
                </div>
                </div>
    `;

    order.products.forEach((product) => {
        result += `
            <div class="card m-3" style="width: 18rem;">
                <img src="${product.imageURL}" class="card-img-top" alt="product 1" onerror="this.onerror=null; this.src='https://media.istockphoto.com/id/1216251206/vector/no-image-available-icon.jpg?s=170667a&w=0&k=20&c=N-XIIeLlhUpm2ZO2uGls-pcVsZ2FTwTxZepwZe4DuE4=';">
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
    if (phone.length != 10) {
        createModal("Invalid phone", false);
        return false;
    }
    if (firstName.length < 2 || firstName.length > 30) {
        createModal("Invalid first name.", false);
        return false;
    }
    if (lastName.length < 2 || lastName.length > 30) {
        createModal("Invalid last name.", false);
        return false;
    }
    if (age < 0) {
        createModal("Invalid age", false);
        return false;
    }
    if (imageURL.length >= 1000) {
        createModal("Invalid link", false);
        return false;
    }
}

function createModal(message, isSuccess = true) {
    var color = isSuccess ? "success" : "danger";
    var modalHtml = '<div class="modal fade" id="createModalModal" tabindex="-1" role="dialog" aria-labelledby="createModalModalLabel" aria-hidden="true">';
    modalHtml += '<div class="modal-dialog" role="document">';
    modalHtml += '<div class="modal-content">';
    modalHtml += '<div class="modal-header bg-' + color + '">';
    modalHtml += '<h5 class="modal-title" id="createModalModalLabel">Alert</h5>';
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
    // Lắng nghe sự kiện 'show.bs.modal' để chặn chuyển trang khi modal được mở
    $('#createModalModal').on('show.bs.modal', function (e) {
        $(this).data('bs.modal').isShown = false;
    });

    // Lắng nghe sự kiện 'hide.bs.modal' để cho phép chuyển trang khi modal bị đóng
    $('#createModalModal').on('hide.bs.modal', function (e) {
        $(this).data('bs.modal').isShown = false;
    });

}

function getProductDetail() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        //console.log(this.responseText);
        if (!JSON.parse(this.responseText).result) {
            createModal(JSON.parse(this.responseText).message);
        }
        else {
            var res = JSON.parse(this.responseText).data;
            //console.log(res);
            showProductDetail(res);
        }
    }
    //?productID=1
    var productID = window.location.search.split("=")[1];
    xhttp.open("GET", "http://localhost/product/detail?productID=" + productID, true);
    xhttp.send();
}

function getProductDetail2() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        //console.log(this.responseText);
        if (!JSON.parse(this.responseText).result) {
            createModal(JSON.parse(this.responseText).message);
        }
        else {
            var res = JSON.parse(this.responseText).data;
            console.log(res);
            const updateForm = document.getElementById("update-form");
            updateForm.querySelector("#productTitle").value = res.name;
            updateForm.querySelector('#productID').value = res.productID;
            updateForm.querySelector("#price").value = res.price;
            updateForm.querySelector("#productDescription").value = res.description;
            updateForm.querySelector("#productImage").value = res.imageURL;
            updateForm.querySelector("#image").src = res.imageURL;
        }
    }
    //?productID=1
    var productID = window.location.search.split("=")[1];
    xhttp.open("GET", "http://localhost/product/detail?productID=" + productID, true);
    xhttp.send();
}

function handleImageChange() {
    var image = document.getElementById("productImage").value;
    document.getElementById("image").src = image;
}

function setDefaultImage(img) {
    img.src = "https://static.vecteezy.com/system/resources/previews/005/337/799/original/icon-image-not-found-free-vector.jpg";
}

function showProductDetail(res) {
    var productDetail = document.getElementById("product-detail");
    var productDetailHTML = "";
    productDetailHTML += `
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <img src="${res.imageURL[0]}" alt="" style="width: 100%;" onerror="this.onerror=null; this.src='https://media.istockphoto.com/id/1216251206/vector/no-image-available-icon.jpg?s=170667a&w=0&k=20&c=N-XIIeLlhUpm2ZO2uGls-pcVsZ2FTwTxZepwZe4DuE4=';">
                </div>
                <div class="col-6 product-info">
                    <h1>${res.name}</h1>
                    <!-- Cho gia tri sao trung binh nhu vi du duoi day-->
                    <p>${res.averageStar}<meter class="average-rating" min="0" max="5"></meter></p>
                    <h3>${res.price} đồng</h3>
                    <button type="button" class="btn btn-primary buy-now" onclick="buyNow(${res.productID})">Buy now</button>
                    <button type="button" class="btn btn-primary" onclick="handleAddToCart(${res.productID})">Add to cart</button>
                    <a class="btn btn-primary" href="./admin-updateproduct.html?productID=${res.productID}"${localStorage.getItem("isAdmin")==="true"?"":" style='display:None;'"}>Edit</a>
                </div>
            </div>
            <div class="description">
                <h2>Description</h2>
                <p>${res.description}</p>
            </div>
            <h2 id="comment-title">Comments</h2>
        </div>
    `;
    const headTag = document.getElementsByTagName('head')[0];
    const styleTag = document.createElement("style");
    styleTag.innerHTML = `
        :root {
            --percent: calc(${res.averageStar}/5*100%);
        }
        `;
    // --percent: calc([gia tri sao trung binh]/5*100%);
    headTag.appendChild(styleTag);
    for (var i = 0; i < res.review.length; i++) {
        //comment
        productDetailHTML += `
            <div id="comment-block" class="container">
                <div class="row">
                    <div class="col-2">
                        <img src="${res.review[i].imageURL}" alt="No Image" onerror="this.onerror=null; this.src='https://static.vecteezy.com/system/resources/previews/008/442/086/original/illustration-of-human-icon-user-symbol-icon-modern-design-on-blank-background-free-vector.jpg';">
                    </div>
                    <div class="col-2 name">
                        <h3>${res.review[i].fname + " " + res.review[i].lname}</h3>
                        <p>${res.review[i].rating} star</p>
                    </div>
                    <div class="col-6">
                        <div class="detail">
                            <h3>${res.review[i].title}</h3>
                            <p>${res.review[i].text}</p>
                            <p>${res.review[i].reviewDate}</p>
                        </div>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-brand-color" onclick="handleDeleteComment(${res.review[i].reviewID})"${localStorage.getItem("isAdmin")==="true"?"":" style='display:None;'"}>Delete</button>
                    </div>
                </div>
            </div>
        `;
    }
    productDetailHTML += `   
    <div class="write-comment container">
        <h2>What do you thing about this product ?</h2>
        <div class="input-name">
            <input type="text" id="title" placeholder="Overview">
            <span class="underline-animation"></span>
        </div>
        <div class="input-name">
            <input type="text" id="text" placeholder="Detail">
            <span class="underline-animation"></span>
        </div>
        <div class="input-name">
            <input type="number" id="rating" placeholder="Rating">
            <span class="underline-animation"></span>
        </div>
        <button onclick="handleComment()">Comment</button>
    </div>
    `;
    productDetail.innerHTML = productDetailHTML;
}
function handleComment() {
    if (document.getElementById("title").value == ""
        || document.getElementById("text").value == "") {
        createModal("Please fill all fields", false);
        return;
    }
    if (document.getElementById("rating").value < 1 || document.getElementById("rating").value > 5) {
        createModal("Rating must be between 1 and 5", false);
        return;
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        //console.log(this.responseText);
        if (!JSON.parse(this.responseText).result) {
            createModal(JSON.parse(this.responseText).message);
        }
        else {
            createModal("Comment successfully");
            getProductDetail();
        }
    }
    xhttp.open("POST", "http://localhost/product/review", true);
    xhttp.setRequestHeader("Content-type", "application/json");
    var productID = window.location.search.split("=")[1];
    xhttp.send(JSON.stringify({
        "token": getCookieValueByName('token'),
        "productID": productID,
        "title": document.getElementById("title").value,
        "text": document.getElementById("text").value,
        "rating": document.getElementById("rating").value
    }));
}

function getUserList() {
    var xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        //console.log(this.responseText);
        if (!JSON.parse(this.responseText).result) {
            createModal(JSON.parse(this.responseText).message);
        }
        else {
            var res = JSON.parse(this.responseText).data;
            //console.log(res);
            showUserList(res);
        }
    }
    xhttp.open("POST", "http://localhost/admin/userlist", true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send(JSON.stringify({
        "token": getCookieValueByName('token')
    }));
}

function showUserList(users) {
    const userListDiv = document.getElementById("user-list");
    userListDiv.innerHTML = "";
    var result = `
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Image</th>
                <th scope="col">Username</th>
                <th scope="col">Last name</th>
                <th scope="col">First name</th>
                <th scope="col">Gender</th>
                <th scope="col">Email</th>
                <th scope="col">Phone number</th>
                <th scope="col">Date of birth</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>`;
    console.log(users[0]);
    users.forEach(user => {
        result += `
        <tr>
            <th scope="row">${user.customerID}</th>
            <td><img class="rounded-circle" src="${user.imageURL}" width="50px" height="50px" onerror="this.onerror=null; this.src='https://static.vecteezy.com/system/resources/previews/008/442/086/original/illustration-of-human-icon-user-symbol-icon-modern-design-on-blank-background-free-vector.jpg';"></td>
            <td>${user.username}</td>
            <td>${user.lname}</td>
            <td>${user.fname}</td>
            <td>${user.gender}</td>
            <td>${user.email}</td>
            <td>${user.phoneNumber}</td>
            <td>${user.DOB}</td>
            <td><button class="btn btn-brand-color" onclick="handleDeleteUser(${user.customerID})">Delete</button></td>
        </tr>
        `;
    });
    result += `
            </tbody>
        </table>
    </div>`;
    userListDiv.innerHTML = result;

}

function handleDeleteUser(userID) {
    var xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        //console.log(this.responseText);
        if (!JSON.parse(this.responseText).result) {
            createModal(JSON.parse(this.responseText).message);
        }
        else {
            createModal("Delete user successfully");
            getUserList();
        }
    }
    xhttp.open("POST", "http://localhost/admin/user/delete", true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send(JSON.stringify({
        "token": getCookieValueByName('token'),
        "userID": userID
    }));
}

function handleUpdateProduct() {
    const updateForm = document.getElementById('update-form');
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "http://localhost/admin/product/update", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.onload = function () {
        console.log(this.responseText);
        var res = JSON.parse(this.responseText);
        console.log(res);
        createModal(res.message);
    }
    xhttp.onerror = function (err) {
        console.log("Error");
        console.log(err);
    }
    console.log(updateForm.querySelector('#productID').value);
    const data = JSON.stringify({
        token: getCookieValueByName('token'),
        name: updateForm.querySelector('#productTitle').value,
        productID: updateForm.querySelector('#productID').value,
        price: updateForm.querySelector('#price').value,
        description: updateForm.querySelector('#productDescription').value,
        imageURL: updateForm.querySelector('#productImage').value,
        categoryID: 1
    });
    xhttp.send(data);
}

function handleAddProduct() {
    const updateForm = document.getElementById('add-product-form');
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "http://localhost/admin/product/add", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.onload = function () {
        console.log(this.responseText);
        var res = JSON.parse(this.responseText);
        console.log(res);
        createModal(res.message);
    }
    xhttp.onerror = function (err) {
        console.log("Error");
        console.log(err);
    }
    const data = JSON.stringify({
        token: getCookieValueByName('token'),
        name: updateForm.querySelector('#productTitle').value,
        price: updateForm.querySelector('#price').value,
        description: updateForm.querySelector('#productDescription').value,
        imageURL: updateForm.querySelector('#productImage').value,
        categoryID: 1
    });

    xhttp.send(data);
}

function handleApplyCoupon() {
    var couponCode = document.getElementById("coupon").value;
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "http://localhost/cart/coupon", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.onload = function () {
        console.log(this.responseText);
        var res = JSON.parse(this.responseText);
        console.log(res);
        createModal(res.message, res.result);
        getCart();
    }
    xhttp.onerror = function (err) {
        console.log("Error");
        console.log(err);
    }
    const data = JSON.stringify({
        token: getCookieValueByName('token'),
        couponCode: couponCode
    });

    xhttp.send(data);
}

function handleDeleteComment(reviewID)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        console.log(this.responseText);
        if(!JSON.parse(this.responseText).result) {
            createModal(JSON.parse(this.responseText).message);
        }   
        else {
            createModal("Delete comment successfully");
            getProductDetail();
        }   
    }
    xhttp.open("POST", "http://localhost/admin/review/delete", true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send(JSON.stringify({
        "token": getCookieValueByName('token'),
        "commentID": reviewID
    }));
}


// Check cookie is valid!
if (getCookieValueByName('token')) {

}
else {
    if (window.location.pathname != "/signup-login.html") {
        alert("You need to login first!");
        window.location.pathname = "/signup-login.html";
    }
}

