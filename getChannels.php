<?php
    require "database.php";
    $conn = connect();

    $sql = "SELECT * FROM messages";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $channels[] = $row["channel"];
        }

        $uniqueChannels = array_unique($channels);

        foreach ($uniqueChannels as $channel) {
            echo "<p>" . $channel . "</p>";
        }
    } else {
        echo "0 results";
    }

    $conn->close();
?>