<!DOCTYPE html>
<html>
    <head>
        <title>Message Submission</title>
    </head>
    <body>
        <?php
            require "database.php";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $message = $_POST['message'];
                $channel = $_POST['channel'];
                $access_token = $_POST['access-token'];

                connect();

                error_log("Token: $access_token");

                insertMessage($access_token, $message, $channel);
            }
        ?>
    </body>
</html>