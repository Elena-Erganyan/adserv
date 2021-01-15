<?php

require_once "functions.php";
require_once "init.php";
require_once "categories.php";

session_start();

$user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

$title = "All ads";
$ads = [];
$pagination = "";

$category_id = $_GET["category"] ?? "";

if ($category_id) {
    $cur_page = $_GET["page"] ?? 1; // number of the current page
    $page_items = 3; // number of lots on a page

    // total amount of lots found
    $sql = "SELECT COUNT(*) as cnt FROM ads AS a JOIN categories AS c ON a.category_id = c.id WHERE c.id = " . $category_id;

    $res = mysqli_query($connection, $sql);

    if ($res) {
        $items_count = mysqli_fetch_assoc($res)["cnt"];

        if ($items_count) {

            $pages_count = ceil($items_count / $page_items); // number of pages
            $pages = range(1, $pages_count); // array with numbers of pages

            $address = $_SERVER["PHP_SELF"] . "?category=" . $category_id . "&";

            $pagination = renderTemplate("templates/pagination.php", [
                "pages_count" => $pages_count,
                "pages" => $pages,
                "cur_page" => $cur_page,
                "address" => $address
            ]);

            $offset = ($cur_page - 1) * $page_items; // offset

            $sql = "SELECT a.id, a.title, a.price, a.img, c.name AS cat_name FROM ads AS a
            JOIN categories AS c ON a.category_id = c.id WHERE c.id = " . $category_id .
            " ORDER BY a.created_at DESC LIMIT " . $page_items . " OFFSET " . $offset;

            $result = mysqli_query($connection, $sql);

            if ($result) {
                $ads = mysqli_fetch_all($result, MYSQLI_ASSOC);

                $page_content = renderTemplate("templates/ads-in-category.php", [
                    "ads" => $ads,
                    "category_id" => $category_id,
                    "pagination" => $pagination
                ]);

            } else {
                $error_message = "MySQL error: " . mysqli_error($connection);

                // get page content
                $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
                $title = "Error";
            }
        } else {
            $error_message = "There are no ads in this category";

            // get page content
            $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
            $title = "There are no ads in this category";
        }
    } else {
        $error_message = "MySQL error: " . mysqli_error($connection);

        // get page content
        $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
        $title = "Error";
    }

} else {
    $error_message = "There is no category with this id";
    // get page content
    $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
    $title = "There is no category with this id";
}

$layout_content = renderTemplate("templates/layout.php", [
    "title" => $title,
    "categories" => $categories,
    "content" => $page_content,
    "user" => $user
]);

print($layout_content);

?>
