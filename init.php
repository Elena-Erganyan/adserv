<?php

require_once "functions.php";

$user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

if ($_SERVER['SERVER_NAME'] == "adserv61.herokuapp.com") {
	$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
	$host = $url["host"];
	$username = $url["user"];
	$password = $url["pass"];
	$dbname = substr($url["path"], 1);
} else {
	$host = "localhost";
	$dbname = "adserv";
	$username = "root";
	$password = "";
}

$connection = mysqli_connect($host, $username, $password, $dbname);

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
