<?php
    $SQLservername = "localhost";
    $SQLusername = "root";
    $SQLpassword = "123456";
    $SQLdbname = "oliviashop";

    function loginModel($username, $password)
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("SELECT * FROM customer WHERE username = ? AND password = ?;");
        $stmt->bind_param("ss", $username, $password);

        $result = "";

        try {
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $result = $row["customerID"];
                    $result = array(
                        "id" => $row["customerID"],
                        "message" => "Login successfully",
                        "isAdmin" => false
                    );
                }
            } 
            else
            {
                $stmt->close();
                $stmt = $conn->prepare("SELECT * FROM customer WHERE email = ? AND password = ?;");
                $stmt->bind_param("ss", $username, $password);
                $stmt->execute();
                $SQLresult = $stmt->get_result();
                if ($SQLresult->num_rows > 0) {
                    while($row = $SQLresult->fetch_assoc()) {
                        $result = $row["customerID"];
                        $result = array(
                            "id" => $row["customerID"],
                            "message" => "Login successfully",
                            "isAdmin" => false
                        );
                    }
                }
                else 
                {
                    $result = array(
                        "id" => -1,
                        "message" => "Wrong username or password",
                        "isAdmin" => false
                    );
                }
            }

            if ($result["id"] != -1)
            {
                $result["isAdmin"] = false;
                $stmt->close();
                $stmt = $conn->prepare("SELECT * FROM admin WHERE adminId = ?");
                $stmt->bind_param("i", $result["id"]);
                $stmt->execute();
                $SQLresult = $stmt->get_result();
                if ($SQLresult->num_rows > 0) {
                    while($row = $SQLresult->fetch_assoc()) {
                        $result["isAdmin"] = true;
                    }
                }
            }
        }
        catch (Exception $e) {
            $result = array(
                "id" => -1,
                "message" => $e->getMessage(),
                "isAdmin" => false
            );
        }
        finally {
            $stmt->close();
            $conn->close();
            return $result;
        }
    }

    function signupModel($username, $password, $fname, $lname, $gender, $age, $email, $phone, $DOB, $imageURL, $address)
    {
        $DOB = date('Y-m-d', strtotime($DOB));
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("INSERT INTO customer(username, password, fname, lname, gender, age, email, phoneNumber, DOB, imageURL, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("sssssisiss", $username, $password, $fname, $lname, $gender, $age, $email, $phone, $DOB, $imageURL, $address);
        $result = 1;
        try {
            $stmt->execute();
            $stmt->close();
            //insert cart
            $stmt = $conn->prepare("INSERT INTO cart(customerID) VALUES ((SELECT MAX(customerID) FROM Customer));");
            $stmt->execute();
            $result = array(
                "result" => true,
                "message" => "Sign up successfully"
            );

        }
        catch (Exception $e) {
            $result = array(
                "result" => false,
                "message" => $e->getMessage()
            );
        }
        finally {
            $stmt->close();
            $conn->close();
            return $result;
        }
    }
    function getProductsByCategoryAndSearchModel($category, $search) 
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Prepare and bind the INSERT statement
        $category = "%".$category."%";
        $search = "%".$search."%";
        //$stmt = $conn->prepare("select product.name as name, price, imageURL, product.description, category.name as category from (product left join image on product.productID = image.productID) join category on category.categoryID = product.categoryID where category like ? and name like ?;");
        $stmt = $conn->prepare("SELECT product.productID, product.name AS name, price, imageURL, product.description, category.name AS category
                        FROM product
                        LEFT JOIN image ON product.productID = image.productID
                        JOIN category ON category.categoryID = product.categoryID
                        WHERE category.name LIKE ? AND product.name LIKE ?;");
        $stmt->bind_param("ss", $category, $search);
        try {
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $result = array();
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $result[] = $row;
                }
            } 
            $result = array(
                "result" => true,
                "message" => "Get products successfully",
                "data" => $result
            );
        }
        catch (Exception $e) {
            $result = array(
                "result" => false,
                "message" => $e->getMessage()
            );
        }
        finally {
            $stmt->close();
            $conn->close();
            return $result;
        }
    }
    function getCartModel($userID) {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //get cartID
        $stmt = $conn->prepare("SELECT MAX(cartID) FROM cart WHERE customerID = ?;");
        $stmt->bind_param("i", $userID);
        try {
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $cartID = 0;
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $cartID = $row["MAX(cartID)"];
                }
            }
            $stmt->close();
            // Prepare and bind the INSERT statement
            $stmt = $conn->prepare("SELECT product.productID, product.name AS name, price, imageURL, product.description, productAddToCart.quantity
                            FROM cart
                            JOIN productAddToCart ON cart.cartID = productAddToCart.cartID
                            JOIN product ON productAddToCart.productID = product.productID
                            LEFT JOIN image ON product.productID = image.productID
                            WHERE customerID = ? AND cart.cartID = ?;");
            $stmt->bind_param("ii", $userID, $cartID);
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $result = array();
            $total = 0;
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    //insert a row to cart
                    $totalPerProduct = $row["price"] * $row["quantity"];
                    $total += $totalPerProduct;
                    $row["total"] = $totalPerProduct;
                    $result[] = $row;
                }
            }
            $stmt->close();
            $stmt = $conn->prepare("SELECT cart.cartID, Coupon.CouponCode, name, percent, value, adminID
                FROM cart
                JOIN cartApplyCoupon ON cart.cartID = cartApplyCoupon.cartID
                JOIN Coupon ON cartApplyCoupon.couponCode = Coupon.couponCode
                WHERE cart.cartID = ?;");
            $stmt->bind_param("i", $cartID);
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $couponName = "None";
            $couponValue = 0;
            $couponPercent = 0;
            if ($SQLresult->num_rows > 0)
            {
                while($row = $SQLresult->fetch_assoc()) {
                    //insert a row to cart
                    $couponName = $row["name"];
                    $couponValue = $row["value"];
                    $couponPercent = $row["percent"];
                }
            }
            $result = array(
                "data" => $result,
                "total" => $total,
                "shippingCost" => 22000,
                "totalWithShipping" => $total + 22000,
                "couponName" => $couponName,
                "couponPercent" => $couponPercent,
                "couponValue" => $couponValue,
                "totalWithShippingAndCoupon" => ($total + 22000) * (100 - $couponPercent) / 100 - $couponValue
            );
            $result = array(
                "result" => true,
                "message" => "Get cart successfully",
                "data" => $result
            );
        }
        catch (Exception $e) {
            $result = array(
                "result" => false,
                "message" => $e->getMessage()
            );
        }
        finally {
            $stmt->close();
            $conn->close();
            return $result;
        }
    }
    
    function addProductToCartModel($userID, $productID, $quantity) {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //get cartID
        $stmt = $conn->prepare("SELECT MAX(cartID) FROM cart WHERE customerID = ?;");
        $stmt->bind_param("i", $userID);
        
        try {
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $cartID = 0;
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $cartID = $row["MAX(cartID)"];
                }
            }
            $stmt->close();
            //check product is already in cart
            $stmt = $conn->prepare("SELECT * FROM productAddToCart WHERE cartID = ? AND productID = ?;");
            $stmt->bind_param("ii", $cartID, $productID);
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            if ($SQLresult->num_rows > 0) {
                //update quantity
                $stmt = $conn->prepare("UPDATE productAddToCart SET quantity = quantity + ? WHERE cartID = ? AND productID = ?;");
                $stmt->bind_param("iii", $quantity, $cartID, $productID);
                $stmt->execute();
                $result = array(
                    "result" => true,
                    "message" => "Update quantity successfully"
                );
            }
            else {
                //insert new product
                $stmt = $conn->prepare("INSERT INTO productAddToCart (cartID, productID, quantity) VALUES (?, ?, ?);");
                $stmt->bind_param("iii", $cartID, $productID, $quantity);
                $stmt->execute();
                $result = array(
                    "result" => true,
                    "message" => "Add product successfully"
                );
            }
        }
        catch (Exception $e) {
            $result = array(
                "result" => false,
                "message" => $e->getMessage()
            );
        }
        finally {
            $conn->close();
            $stmt->close();
            return $result;
        }
    }
    function deleteProductToCartModel($userID, $productID, $quantity)
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //get cartID
        $stmt = $conn->prepare("SELECT MAX(cartID) FROM cart WHERE customerID = ?;");
        $stmt->bind_param("i", $userID);
        try {
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $cartID = 0;
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $cartID = $row["MAX(cartID)"];
                }
            }
            $stmt->close();
            //check product is already in cart
            $stmt = $conn->prepare("SELECT * FROM productAddToCart WHERE cartID = ? AND productID = ?;");
            $stmt->bind_param("ii", $cartID, $productID);
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            if ($SQLresult->num_rows > 0) {
                //update quantity
                $stmt = $conn->prepare("UPDATE productAddToCart SET quantity = quantity - ? WHERE cartID = ? AND productID = ?;");
                $stmt->bind_param("iii", $quantity, $cartID, $productID);
                $stmt->execute();
                $stmt->close();

                //check quantity == 0
                $stmt = $conn->prepare("SELECT quantity FROM productAddToCart WHERE cartID = ? AND productID = ?;");
                $stmt->bind_param("ii", $cartID, $productID);
                $stmt->execute();

                $SQLresult = $stmt->get_result();
                $quantity = 0;
                if ($SQLresult->num_rows > 0) {
                    while($row = $SQLresult->fetch_assoc()) {
                        $quantity = $row["quantity"];
                    }
                    if ($quantity <= 0) {
                        $stmt->close();
                        $stmt = $conn->prepare("DELETE FROM productAddToCart WHERE cartID = ? AND productID = ?;");
                        $stmt->bind_param("ii", $cartID, $productID);
                        $stmt->execute();
                    }

                    $result = array(
                        "result" => true,
                        "message" => "Update quantity successfully"
                    );
                }
                else {
                    $result = array(
                        "result" => false,
                        "message" => "Product is not in cart"
                    );
                    return $result;
                }

                
            }
            else {
                $result = array(
                    "result" => false,
                    "message" => "Product is not in cart"
                );
            }
        }
        catch (Exception $e) {
            $result = array(
                "result" => false,
                "message" => $e->getMessage()
            );
        }
        finally {
            $conn->close();
            $stmt->close();
            return $result;
        }
    }
    
    function getUserInfoModel($userID)
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("SELECT username, fname, lname, gender, age, DOB, email, phoneNumber, imageURL, address 
                        FROM customer 
                        WHERE customer.customerID = ?;");
        $stmt->bind_param("i", $userID);
        try {
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $result = array();
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $result[] = $row;
                }
            }
            $result = $result[0];
            $result = array(
                "result" => true,
                "message" => "Get user info successfully",
                "data" => $result
            );
        }
        catch (Exception $e) {
            $result = array(
                "result" => false,
                "message" => $e->getMessage()
            );
        }
        finally {
            $conn->close();
            $stmt->close();
            return $result;
        }
    }
    
    function updateUserInfoModel($userID, $fname, $lname, $DOB, $phone, $email, $address, $imageURL)
    {
        $DOB = date('Y-m-d', strtotime($DOB));
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("UPDATE customer SET fname = ?, lname = ?, DOB = ?, phoneNumber = ?, email = ?, imageURL = ? WHERE customerID = ?;");
        $stmt->bind_param("ssssssi", $fname, $lname, $DOB, $phone, $email, $imageURL, $userID);

        try {
            $stmt->execute();
            $stmt->close();
            //update address
            $stmt = $conn->prepare("UPDATE address SET address = ? WHERE customerID = ?;");
            $stmt->bind_param("si", $address, $userID);
            $stmt->execute();
            $result = array(
                "result" => true,
                "message" => "Update user info successfully"
            );
        }
        catch (Exception $e) {
            $result = array(
                "result" => false,
                "message" => $e->getMessage()
            );
        }
        finally {
            $conn->close();
            $stmt->close();
            return $result;
        }
    }
    //Doing ..., don't use anything below this line
    function getOrdersModel($userID)
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("SELECT orderID, orderDate, shippingDate, completeDate, totalPrice, shippingAddress, paymentMethod, orderStatus 
                            FROM `order`
                            WHERE customerID = ?;");
        $stmt->bind_param("i", $userID);
        try {
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $result = array();
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $result[] = $row;
                }
            }
            $result = array(
                "result" => true,
                "message" => "Get orders successfully",
                "data" => $result
            );
        }
        catch (Exception $e) {
            $result = array(
                "result" => false,
                "message" => $e->getMessage()
            );
        }
        finally {
            $stmt->close();
            $conn->close();
            return $result;
        }
    }
    function getOrderDetailModel($userID, $orderID)
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("SELECT orderID, orderDate, shippingDate, completeDate, totalPrice, shippingAddress, paymentMethod, orderStatus 
                        FROM `order`
                        WHERE orderID = ?");
        $stmt->bind_param("i", $orderID);
        try {
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $result = 0;
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $result = $row;
                }
            }
            $stmt->close();
            //get cart id

            $stmt = $conn->prepare("SELECT cartID 
                            FROM `order`
                            WHERE orderID = ?;");
            $stmt->bind_param("i", $orderID);
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $cartID = 0;
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $cartID = $row["cartID"];
                }
            }
            $stmt->close();
            //get cart detail
            $stmt = $conn->prepare("SELECT product.productID, product.name AS name, price, imageURL, product.description, productAddToCart.quantity
                            FROM cart
                            JOIN productAddToCart ON cart.cartID = productAddToCart.cartID
                            JOIN product ON productAddToCart.productID = product.productID
                            LEFT JOIN image ON product.productID = image.productID
                            WHERE customerID = ? AND cart.cartID = ?;");
            $stmt->bind_param("ii", $userID, $cartID);
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $cartDetail = array();
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $cartDetail[] = $row;
                }
            }
            $result["products"] = $cartDetail;

            $result = array(
                "result" => true,
                "message" => "Get order detail successfully",
                "data" => $result
            );
        }
        catch (Exception $e) {
            $result = array(
                "result" => false,
                "message" => $e->getMessage()
            );
        }
        finally {
            $conn->close();
            $stmt->close();
            return $result;
        }
    }
    function paymentModel($userID, $paymentMethod)
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //find cart id
        $stmt = $conn->prepare("SELECT MAX(cartID) FROM cart WHERE customerID = ?;");
        $stmt->bind_param("i", $userID);
        $result = array();
        try {
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $cartID = 0;
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $cartID = $row["MAX(cartID)"];
                }
            }
            $stmt->close();
            $stmt = $conn->prepare("CALL Payment(?, ?, ?);");
            $stmt->bind_param("iis", $userID, $cartID, $paymentMethod);
            $stmt->execute();
            $result = array(
                "result" => true,
                "message" => "Payment successfully"
            );
        }
        catch (Exception $e) {
            $result = array(
                "result" => false,
                "message" => $e->getMessage()
            );
        }
        finally {
            $conn->close();
            $stmt->close();
            return $result;
        }
    }
    function getProductDetailModel($productID)
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("SELECT productID, name, price, description, price 
                        FROM product WHERE productID = ?;");
        $stmt->bind_param("i", $productID);

        try {
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $result = array();
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $result = $row;
                }
            }
            $stmt->close();

            $stmt = $conn->prepare("SELECT imageURL FROM image WHERE productID = ?;");
            $stmt->bind_param("i", $productID);
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $imageResult = array();
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $imageResult[] = $row["imageURL"];
                }
            }
            $result["imageURL"] = $imageResult;
            $stmt->close();
            $stmt = $conn->prepare("SELECT fname, lname, imageURL, rating, title, text, reviewDate, status 
                            FROM review 
                            JOIN customer ON review.customerID = customer.customerID
                            WHERE productID = ?
                            ORDER BY reviewDate;");
            $stmt->bind_param("i", $productID);
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $reviewResult = array();
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $reviewResult[] = $row;
                }
            }
            $result["review"] = $reviewResult;
            $result["averageStar"] = 0;
            for($i = 0; $i < count($reviewResult); $i++)
            {
                $result["averageStar"] += $reviewResult[$i]["rating"];
            }
            if (count($reviewResult) == 0) $result["averageStar"] = 2.5; 
            else $result["averageStar"] /= count($reviewResult);
            $result["numComment"] = count($reviewResult);
            $result = array(
                "result" => true,
                "message" => "Get product detail successfully",
                "data" => $result
            );
        }
        catch (Exception $e) {
            $result = array(
                "result" => false,
                "message" => $e->getMessage()
            );
        }
        finally {
            $conn->close();
            $stmt->close();
            return $result;
        }
    }
    function getCategoriesModel()
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("SELECT * FROM category;");
        try {
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $result = array();
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $result[] = $row;
                }
            }
            $result = array(
                "result" => true,
                "message" => "Get categories successfully",
                "data" => $result
            );
        }
        catch (Exception $e) {
            $result = array(
                "result" => false,
                "message" => $e->getMessage()
            );
        }
        finally {
            $conn->close();
            $stmt->close();
            return $result;
        }
    }

    function commentModel($userID, $productID, $title, $text, $rating)
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("CALL Comment(?, ?, ?, ?, ?);");
        $stmt->bind_param("iiiss", $userID, $productID, $rating, $title, $text);
        try {
            $stmt->execute();
            $result = array(
                "result" => true,
                "message" => "Comment successfully"
            );
        }
        catch (Exception $e) {
            $result = array(
                "result" => false,
                "message" => $e->getMessage()
            );
        }
        finally {
            $conn->close();
            $stmt->close();
            return $result;
        }
    }

    function cartApplyCouponModel($userID, $couponCode)
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //find cart id
        $stmt = $conn->prepare("SELECT MAX(cartID) FROM cart WHERE customerID = ?;");
        $stmt->bind_param("i", $userID);
        $result = array();
        try {
            $stmt->execute();
            $SQLresult = $stmt->get_result();
            $cartID = 0;
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $cartID = $row["MAX(cartID)"];
                }
            }
            $stmt->close();
            $stmt = $conn->prepare("CALL applyCoupon(?, ?);");
            $stmt->bind_param("si", $couponCode, $cartID);
            $stmt->execute();
            $result = array(
                "result" => true,
                "message" => "Apply coupon sucessfull"
            );
        }
        catch (Exception $e) {
            $result = array(
                "result" => false,
                "message" => $e->getMessage()
            );
        }
        finally {
            $conn->close();
            $stmt->close();
            return $result;
        }
    }

?>