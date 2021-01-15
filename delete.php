<?php

require_once "functions.php";
require_once "init.php";
require_once "categories.php";

session_start();

$user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;


if(isset($user)){

    if(isset($_GET["id"])) {
        
        $id = intval($_GET["id"]);
        $sql = "SELECT a.user_id FROM ads AS a WHERE a.id = " . $id;
        
        $result = mysqli_query($connection, $sql);

        if ($result) {
            $ad = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $is_ad_author = ($user["id"] === $ad["user_id"]);
        } else {
            $error_message = "MySQL error: " . mysqli_error($connection);
    
            $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
            $title = "Error";
        }

        if($is_ad_author) {

            $sql = "DELETE FROM ads WHERE id = " . $id;
            $result = mysqli_query($connection, $sql);

            if ($result) {
                $page_content = "<h2>The ad was successfully deleted</h2>";
                $title = "The ad was successfully deleted";
            } else {
                $error_message = "MySQL error: " . mysqli_error($connection);
        
                $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
                $title = "Error";
            }
        } else {
            http_response_code(403);
            $page_content = "<h2>Access denied</h2>";
            $title = "Access denied";
        }
    }
} else {
    http_response_code(403);
    $page_content = "<h2>Access denied</h2>";
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