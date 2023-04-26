<?php
    $SQLservername = "localhost";
    $SQLusername = "root";
    $SQLpassword = "";
    $SQLdbname = "oliviashop";

    function getUserListModel()
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $stmt = $conn->prepare("SELECT * from customer;");
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
                "message" => "Get user list successfully",
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

    function addProductModel($name, $price, $categoryID, $supplierID, $brandID, $description, $imageURL)
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("INSERT INTO product(name, price, categoryID, supplierID, brandID, description) VALUES (?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("siiiis", $name, $price, $categoryID, $supplierID, $brandID, $description);
        try {
            $stmt->execute();
            $stmt->close();
            //insert address
            $stmt = $conn->prepare("INSERT INTO image VALUES (?, (SELECT MAX(productID) FROM product));");
            $stmt->bind_param("s", $imageURL);
            $stmt->execute();
            $result = array(
                "result" => true,
                "message" => "Add product successfully"
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

    function updateProductModel($name, $price, $categoryID, $supplierID, $brandID, $description, $imageURL, $productID)
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("UPDATE product SET name = ?, price = ?, categoryID = ?, supplierID = ?, brandID = ?, description = ? WHERE productID = ?");
        $stmt->bind_param("siiiisi", $name, $price, $categoryID, $supplierID, $brandID, $description, $productID);
        try {
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare("UPDATE image SET imageURL = ? WHERE productID = ?");
            $stmt->bind_param("si", $imageURL, $productID);
            $stmt->execute();
            $result = array(
                "result" => true,
                "message" => "Update product successfully"
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

    function deleteUserModel($userID)
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //Check i isAdmin?
        $stmt = $conn->prepare("SELECT * FROM admin WHERE adminId = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $SQLresult = $stmt->get_result();
        if ($SQLresult->num_rows > 0) {
            while($row = $SQLresult->fetch_assoc()) {
                $result = array(
                    "result" => false,
                    "message" => "You can't delete admin"
                );
                return $result;
            }
        }
        $stmt = $conn->prepare("CALL DeleteUser(?);");
        $stmt->bind_param("i", $userID);
        try {
            $stmt->execute();
            $result = array(
                "result" => true,
                "message" => "Delete user successfully"
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

    function deleteCommentModel($reviewID)
    {
        global $SQLservername, $SQLusername, $SQLpassword, $SQLdbname;
        // Create connection
        $conn = new mysqli($SQLservername, $SQLusername, $SQLpassword, $SQLdbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("DELETE FROM review WHERE reviewID = ?");
        $stmt->bind_param("i", $reviewID);
        try {
            $stmt->execute();
            $result = array(
                "result" => true,
                "message" => "Delete comment successfully"
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