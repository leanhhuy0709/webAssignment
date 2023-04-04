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
        $stmt = $conn->prepare("select * from customer where username = ? and password = ?;");
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

?>