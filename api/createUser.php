<?php
    require "database.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        connect();

        $sql = "SELECT * FROM `users` WHERE username = '$username'";
        $result = $GLOBALS["conn"]->query($sql);

        if ($result->num_rows > 0) {
            echo "User already exists";
            return;
        }

        $sql = "INSERT INTO `users` (`username`, `password`) VALUES ('$username', '$password')";
        $result = $GLOBALS["conn"]->query($sql);

        $last_id = $GLOBALS["conn"]->insert_id;

        $sql = "SELECT * FROM `users` WHERE id = '$last_id'";
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