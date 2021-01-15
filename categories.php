<?php

    $sql = "SELECT * FROM categories ORDER BY id";

    $result = mysqli_query($connection, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    } else {
        $error_message = "MySQL error: " . mysqli_error($connection);

        $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
    }

?>
