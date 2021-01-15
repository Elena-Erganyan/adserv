<?php

require_once "functions.php";

$user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

$connection = mysqli_connect("localhost", "root", "", "adserv");

mysqli_set_charset($connection, "utf-8");

if(!$connection) {
    $error_message = "Connection error: " . mysqli_connect_error();

    $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);

    $layout_content = renderTemplate("templates/layout.php", [
        "title" => "Error",
        "content" => $page_content,
        "user" => $user
    ]);

    print($layout_content);

    exit();
}

?>
