<!DOCTYPE html>
<html>
    <head>
        <title>Message Submission</title>
    </head>
    <body>
        <?php
            require "database.php";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST['username'];
                $message = $_POST['message'];
                $channel = $_POST['channel'];

                connect();

                insertMessage($username, $message, $channel);
            }
        ?>
    </body>
</html>