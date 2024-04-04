<?php
    require "database.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM `users` WHERE username = '$username' and password = '$password'";
        $result = $GLOBALS["conn"]->query($sql);

        $response = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $response[] = array(
                    'access_token' => $row["access_token"],
                );
            }
        }

        echo json_encode($response);
    }
?>