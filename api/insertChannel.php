<?php
    require "database.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $access_token = $_POST['access_token'];

        $sql = "SELECT * FROM `users` WHERE access_token = '$access_token'";
        $result = $GLOBALS['conn']->query($sql);

        if ($result->num_rows < 0) {
            return;
        }

        connect();

        $last_id = newChannel($name);

        $conn = connect();

        $sql = "SELECT * FROM channels WHERE id = '$last_id'";
        $result = $conn->query($sql);

        $response = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $response[] = array(
                    'name' => $row["name"],
                    'id' => $row["id"],
                );
            }
        } else {
            $response['error'] = "No results found";
        }

        $conn->close();

        echo json_encode($response);
    }
?>