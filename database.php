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

    function insertMessage($name, $message, $channel): void
    {
        $sql = "INSERT INTO messages (username, message, channel) VALUES ('$name', '$message', '$channel')";

        if ($GLOBALS['conn']->query($sql) === false) {
            error_log("Error inserting: " . $GLOBALS['conn']->error);
        }
    }
?>