<?php
    function connect()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "chat";

        $GLOBALS['conn'] = new mysqli($servername, $username, $password, $dbname);

        if ($GLOBALS['conn']->connect_error) {
            die("Connection failed: " . $GLOBALS['conn']->connect_error);
        }

        return $GLOBALS['conn'];
    }

    function insertMessage($access_token, $message, $channel): void
    {
        $sql = "SELECT * FROM `users` WHERE access_token = '$access_token'";
        $result = $GLOBALS['conn']->query($sql);

        $username = "";

        error_log("$access_token");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $username = $row["username"];
            }
        } else {
            error_log("No access");
            return;
        }

        $sql = "INSERT INTO `messages` (`username`, `message`, `channel_id`, `access_token`) VALUES ('$username', '$message', '$channel', '$access_token')";

        if ($GLOBALS['conn']->query($sql) === false) {
            error_log("Error inserting: " . $GLOBALS['conn']->error);
        }
    }

    function newChannel($name) {
        $sql = "INSERT INTO `channels`(`name`) VALUES ('$name')";

        if ($GLOBALS['conn']->query($sql) === false) {
            error_log("Error inserting: " . $GLOBALS['conn']->error);
            return null; // Return null if insertion fails
        } else {
            // Fetch the inserted row and return it
            $last_id = $GLOBALS['conn']->insert_id;
            return $last_id;
        }
    }
?>