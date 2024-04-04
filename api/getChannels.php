<?php
    require "database.php";
    $conn = connect();

    $sql = "SELECT * FROM channels";
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
?>
