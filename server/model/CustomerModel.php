<?php
    $SQLservername = "localhost";
    $SQLusername = "root";
    $SQLpassword = "";
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
        if ($stmt->execute() === TRUE) {
            $SQLresult = $stmt->get_result();
            if ($SQLresult->num_rows > 0) {
                while($row = $SQLresult->fetch_assoc()) {
                    $result = $row["customerID"];
                    $result = array(
                        "id" => $row["customerID"],
                        "message" => "Login successfully"
                    );
                }
            } 
            else $result = array(
                "id" => -1,
                "message" => "Wrong username or password" 
            );
        } else {
            $result = array(
                "id" => -1,
                "message" => $stmt->error 
            );
        }        
        $stmt->close();
        $conn->close();

        return $result;
    }

    function signupModel($username, $password, $fname, $lname, $gender, $age, $email, $phone, $DOB)
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
        $stmt = $conn->prepare("INSERT INTO customer(username, password, fname, lname, gender, age, email, phoneNumber, DOB) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("sssssisis", $username, $password, $fname, $lname, $gender, $age, $email, $phone, $DOB);

        $result = 1;
        if ($stmt->execute() === TRUE) {
            $result = array(
                "result" => true,
                "message" => "Sign up successfully"
            );
        } else {
            $result = array(
                "result" => false,
                "message" => $stmt->error
            );
        }

        $stmt->close();
        $conn->close();

        return $result;
    }
    function getProductsModel()
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("SELECT name, price, imageURL, description 
                        from product 
                        left join image on product.productID = image.productID;");
        $stmt->execute();
        $SQLresult = $stmt->get_result();
        $result = array();
        if ($SQLresult->num_rows > 0) {
            while($row = $SQLresult->fetch_assoc()) {
                $result[] = $row;
            }
        } 
        $stmt->close();
        $conn->close();

        return $result;
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
        $stmt = $conn->prepare("SELECT product.name AS name, price, imageURL, product.description, category.name AS category
                        FROM product
                        LEFT JOIN image ON product.productID = image.productID
                        JOIN category ON category.categoryID = product.categoryID
                        WHERE category.name LIKE ? AND product.name LIKE ?;");
        $stmt->bind_param("ss", $category, $search);
        $stmt->execute();
        $SQLresult = $stmt->get_result();
        $result = array();
        if ($SQLresult->num_rows > 0) {
            while($row = $SQLresult->fetch_assoc()) {
                $result[] = $row;
            }
        } 
        $stmt->close();
        $conn->close();

        return $result;
    }
    function getCartModel() {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("SELECT product.name AS name, price, imageURL, product.description, productAddToCart.quantity
                        FROM cart
                        JOIN productAddToCart ON cart.cartID = productAddToCart.cartID
                        JOIN product ON productAddToCart.productID = product.productID
                        LEFT JOIN image ON product.productID = image.productID
                        WHERE customerID = 1;");
        $stmt->execute();
        $SQLresult = $stmt->get_result();
        $result = array();
        if ($SQLresult->num_rows > 0) {
            while($row = $SQLresult->fetch_assoc()) {
                $result[] = $row;
            }
        } 
        $stmt->close();
        $conn->close();

        return $result;
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
        if ($stmt->execute() === FALSE) {
            return array(
                "result" => false,
                "message" => $stmt->error
            );
        }
        $SQLresult = $stmt->get_result();
        $cartID = 0;
        if ($SQLresult->num_rows > 0) {
            $row = $SQLresult->fetch_assoc();
            $cartID = $row["MAX(cartID)"];
        }
        else return array(
            "result" => false,
            "message" => "No cart found"
        );
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
            if ($stmt->execute() === TRUE) {
                $result = array(
                    "result" => true,
                    "message" => "Add to cart successfully"
                );
            } else {
                $result = array(
                    "result" => false,
                    "message" => $stmt->error
                );
            }
        }
        else {
            // Prepare and bind the INSERT statement
            $stmt = $conn->prepare("INSERT INTO productAddToCart(productID, cartID, quantity) 
                            VALUES (?, ?, ?);");
            $stmt->bind_param("iii", $productID, $cartID, $quantity);

            if ($stmt->execute() === TRUE) {
                $result = array(
                    "result" => true,
                    "message" => "Add to cart successfully"
                );
            } else {
                $result = array(
                    "result" => false,
                    "message" => $stmt->error
                );
            }
        }
        $stmt->close();
        $conn->close();

        return $result;
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
        if ($stmt->execute() === FALSE) {
            return array(
                "result" => false,
                "message" => $stmt->error
            );
        }
        $SQLresult = $stmt->get_result();
        $cartID = 0;
        if ($SQLresult->num_rows > 0) {
            $row = $SQLresult->fetch_assoc();
            $cartID = $row["MAX(cartID)"];
        }
        else return array(
            "result" => false,
            "message" => "No cart found"
        );
        $stmt->close();
        //check product is already in cart
        $stmt = $conn->prepare("SELECT quantity FROM productAddToCart WHERE cartID = ? AND productID = ?;");
        $stmt->bind_param("ii", $cartID, $productID);
        $stmt->execute();
        $SQLresult = $stmt->get_result();
        if ($SQLresult->num_rows > 0) {
            $row = $SQLresult->fetch_assoc();
            if ($row["quantity"] > $quantity) {
                //update quantity
                $stmt = $conn->prepare("UPDATE productAddToCart SET quantity = quantity - ? WHERE cartID = ? AND productID = ?;");
                $stmt->bind_param("iii", $quantity, $cartID, $productID);
                if ($stmt->execute() === TRUE) {
                    $result = array(
                        "result" => true,
                        "message" => "Delete from cart successfully"
                    );
                } else {
                    $result = array(
                        "result" => false,
                        "message" => $stmt->error
                    );
                }
            }
            else {
                //delete product
                $stmt = $conn->prepare("DELETE FROM productAddToCart WHERE cartID = ? AND productID = ?;");
                $stmt->bind_param("ii", $cartID, $productID);
                if ($stmt->execute() === TRUE) {
                    $result = array(
                        "result" => true,
                        "message" => "Delete from cart successfully"
                    );
                } else {
                    $result = array(
                        "result" => false,
                        "message" => $stmt->error
                    );
                }
            }
        }
        else {
            $result = array(
                "result" => false,
                "message" => "Product is not in cart"
            );
        }
        return $result;
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
        $stmt = $conn->prepare("SELECT username, fname, lname, gender, age, DOB, email, phoneNumber, imageURL 
                        FROM customer 
                        WHERE customer.customerID = ?;");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $SQLresult = $stmt->get_result();
        $result = array();
        if ($SQLresult->num_rows > 0) {
            while($row = $SQLresult->fetch_assoc()) {
                $result[] = $row;
            }
        }
        $result = $result[0];
        $stmt->close();

        $stmt = $conn->prepare("SELECT address.address
                        FROM address 
                        WHERE address.customerID = ?;");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $SQLresult = $stmt->get_result();
        $address = array();
        if ($SQLresult->num_rows > 0) {
            while($row = $SQLresult->fetch_assoc()) {
                $address[] = $row["address"];
            }
        }
        $result["address"] = $address;
        $stmt->close();
        $conn->close();
        return $result;
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
        if ($stmt->execute() === TRUE) {
            $stmt = $conn->prepare("UPDATE address SET address = ? WHERE customerID = ?;");//careful
            $stmt->bind_param("si", $address, $userID);
            if ($stmt->execute() === TRUE) {
                $result = array(
                    "result" => true,
                    "message" => "Update user info successfully"
                );
            } else {
                $result = array(
                    "result" => false,
                    "message" => $stmt->error
                );
            }
        } else {
            $result = array(
                "result" => false,
                "message" => $stmt->error
            );
        }
        return $result;
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
        $stmt = $conn->prepare("SELECT orderID, orderDate, orderStatus, totalAmount, paymentMethod, shippingMethod, shippingAddress, shippingPhone 
                        FROM orders 
                        WHERE customerID = ?;");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $SQLresult = $stmt->get_result();
        $result = array();
        if ($SQLresult->num_rows > 0) {
            while($row = $SQLresult->fetch_assoc()) {
                $result[] = $row;
            }
        }
        $stmt->close();
        $conn->close();
        return $result;
    }
    function getOrderDetailModel($orderID)
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("SELECT orderID, orderDate, orderStatus, totalAmount, paymentMethod, shippingMethod, shippingAddress, shippingPhone 
                        FROM orders 
                        WHERE orderID = ?;");
        $stmt->bind_param("i", $orderID);
        $stmt->execute();
        $SQLresult = $stmt->get_result();
        $result = array();
        if ($SQLresult->num_rows > 0) {
            while($row = $SQLresult->fetch_assoc()) {
                $result[] = $row;
            }
        }
        $stmt->close();
        $conn->close();
        return $result;
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
        $stmt->execute();
        $SQLresult = $stmt->get_result();
        $result = array();
        if ($SQLresult->num_rows > 0) {
            while($row = $SQLresult->fetch_assoc()) {
                $result[] = $row;
            }
        }
        $cartID = $result[0]["MAX(cartID)"];
        $stmt->close();
        //payment
        $stmt = $conn->prepare("CALL Payment(?, ?, ?);");
        $stmt->bind_param("iis", $userID, $cartID, $paymentMethod);
        if ($stmt->execute() === TRUE) {
            $result = array(
                "result" => true,
                "message" => "Payment successfully"
            );
        } else {
            $result = array(
                "result" => false,
                "message" => $stmt->error
            );
        }
        $stmt->close();
        $conn->close();
        return $result;
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
        $stmt->execute();
        $SQLresult = $stmt->get_result();
        $result = array();
        if ($SQLresult->num_rows > 0) {
            while($row = $SQLresult->fetch_assoc()) {
                $result[] = $row;
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
                $imageResult[] = $row;
            }
        }
        $result[0]["imageURL"] = $imageResult;
        $stmt->close();
        $stmt = $conn->prepare("SELECT * FROM review WHERE productID = ?;");
        $stmt->bind_param("i", $productID);
        $stmt->execute();
        $SQLresult = $stmt->get_result();
        $reviewResult = array();
        if ($SQLresult->num_rows > 0) {
            while($row = $SQLresult->fetch_assoc()) {
                $reviewResult[] = $row;
            }
        }
        $result[0]["review"] = $reviewResult;
        $stmt->close();
        $conn->close();
        return $result;
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
        $stmt->execute();
        $SQLresult = $stmt->get_result();
        $result = array();
        if ($SQLresult->num_rows > 0) {
            while($row = $SQLresult->fetch_assoc()) {
                $result[] = $row;
            }
        }
        $stmt->close();
        $conn->close();
        return $result;
    }
?>