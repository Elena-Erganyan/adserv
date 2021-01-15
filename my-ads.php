<?php

require_once "functions.php";
require_once "init.php";
require_once "categories.php";

session_start();

$user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

if (isset($user)) {

    $sql = "SELECT a.id, a.img, a.price, a.title AS ad_title, c.name AS category, 
    u.id AS user_id FROM ads AS a JOIN users AS u ON a.user_id = u.id 
    JOIN categories as c ON a.category_id = c.id WHERE u.id = " . $user["id"];

    $result = mysqli_query($connection, $sql);

    if($result) {

        $my_ads = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $title = "My ads";

        $page_content = renderTemplate("templates/my-ads.php", [
            "user" => $user,
            "my_ads" => $my_ads
        ]);

    } else {

        $error_message = "MySQL error: " . mysqli_error($connection);

        $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
        $title = "Error";
    }

} else {
    http_response_code(403);
    $page_content = renderTemplate("templates/my-ads.php");
    $title = "Access denied";
}

$layout_content = renderTemplate("templates/layout.php", [
    "title" => $title,
    "categories" => $categories,
    "content" => $page_content,
    "user" => $user
]);

print($layout_content);

?>
