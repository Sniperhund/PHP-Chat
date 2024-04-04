<?php
    require "database.php";
    $conn = connect();

    if(isset($_GET['channel'])) {
        $channel = $_GET['channel'];
        $sql = "SELECT * FROM `messages` WHERE channel_id = '$channel'";
        $result = $GLOBALS["conn"]->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='message'>
                                    <p>" . $row["username"] . "</p>
                                    <p>" . $row["message"] . "</p>
                                </div>";
            }
        } else {
            echo "This is empty, maybe you should send a message";
        }
    } else {
        echo "Channel parameter not provided";
    }

    $conn->close();
?>
