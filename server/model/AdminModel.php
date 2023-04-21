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
?>