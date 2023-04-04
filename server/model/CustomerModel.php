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
    
    function addProductToCartModel($cartID, $productID, $quantity) {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
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
    //Doing ..., don't use anything below this line
    function getUserInfoModel()
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("select name, price, imageURL, description from product left join image on product.productID = image.productID;");
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
    function updateUserInfoModel()
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("select name, price, imageURL, description from product left join image on product.productID = image.productID;");
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
    function getOrdersModel()
    {
        return null;
    }
    function getOrderDetailModel($orderID)
    {
        return null;
    }
    function paymentModel($address, $phone)
    {
        return null;
    }
    function getProductDetailModel($productID)
    {
        return null;
    }
?>