<?php

require_once "functions.php";
require_once "init.php";
require_once "categories.php";

session_start();

$user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

$ad = [];
$error = null;
$is_ad_author = false;

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
}

$sql = "SELECT a.id, a.title, a.user_id, a.price, a.img, a.description, u.id, u.phone 
FROM ads AS a JOIN users AS u ON a.user_id = u.id WHERE a.id = " . $id;

$result = mysqli_query($connection, $sql);

if ($result) {
    $ad = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if(isset($user)){
        $is_ad_author = ($user["id"] === $ad["user_id"]);
    }

    $title = $ad["title"];
} else {
    $error_message = "MySQL error: " . mysqli_error($connection);

    $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
    $title = "Error";
}

$page_content = renderTemplate("templates/ad.php", [
    "ad" => $ad,
    "user" => $user,
    "error" => $error,
    "is_ad_author" => $is_ad_author
]);

$layout_content = renderTemplate("templates/layout.php", [
    "title" => $title,
    "categories" => $categories,
    "content" => $page_content,
    "user" => $user
]);

print($layout_content);

?>
