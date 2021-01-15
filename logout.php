<?php

session_start();

if (isset($_SESSION["user"])) {

    unset($_SESSION["user"]);

    header("Location: /index.php");

} else {
    http_response_code(403);
}

?>