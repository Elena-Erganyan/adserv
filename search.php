<?php

require_once("functions.php");
require_once("init.php");
require_once("categories.php");

session_start();

$user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

$title = "Search results";

$ads = [];
$pagination = "";

$search = trim($_GET["search"]) ?? "";

if (!empty($search)) {
    $cur_page = $_GET["page"] ?? 1; // number of pages
    $page_items = 3; // array with numbers of pages

    // total number of ads found
    $sql = "SELECT COUNT(*) as cnt FROM ads WHERE MATCH(title, description) AGAINST(? IN BOOLEAN MODE)";

    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "s", $search);
    $res = mysqli_stmt_execute($stmt);

    if ($res) {
        $result = mysqli_stmt_get_result($stmt);
        $items_count = mysqli_fetch_assoc($result)["cnt"];
        if ($items_count) {

            $pages_count = ceil($items_count / $page_items); // number of pages
            $pages = range(1, $pages_count); // array with numbers of pages

            $address = $_SERVER["PHP_SELF"] . "?search=" . $search . "&";

            $pagination = renderTemplate("templates/pagination.php", [
                "pages_count" => $pages_count,
                "pages" => $pages,
                "cur_page" => $cur_page,
                "address" => $address
            ]);

            $offset = ($cur_page - 1) * $page_items; // offset

            $sql = "SELECT a.id, a.title, a.price, a.img, c.name as cat_name FROM ads AS a
             JOIN categories AS c ON a.category_id = c.id WHERE MATCH(a.title, description) 
             AGAINST(? IN BOOLEAN MODE) ORDER BY created_at DESC LIMIT " . $page_items 
             . " OFFSET " . $offset;

            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($stmt, "s", $search);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {

                $result = mysqli_stmt_get_result($stmt);

                $ads = mysqli_fetch_all($result, MYSQLI_ASSOC);

                $page_content = renderTemplate("templates/search.php", [
                    "categories" => $categories,
                    "ads" => $ads,
                    "pagination" => $pagination,
                    "search" => $search
                ]);

            } else {
                $error_message = "MySQL error: " . mysqli_error($connection);

                $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
                $title = "Error";
            }

        }
    } else {
        $error_message = "MySQL error: " . mysqli_error($connection);

        $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
        $title = "Error";
    }
} else {
    $error_message = "Error";
    $title = "Empty request";
}

$page_content = renderTemplate("templates/search.php", [
    "ads" => $ads,
    "pagination" => $pagination,
    "search" => $search
]);

$layout_content = renderTemplate("templates/layout.php", [
    "title" => $title,
    "categories" => $categories,
    "content" => $page_content,
    "user" => $user,
    "search" => $search
]);

print($layout_content);

?>
