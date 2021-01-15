<?php

require_once("functions.php");
require_once("init.php");
require_once("categories.php");

session_start();

$user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

$title = "Adding a new ad";

$img_mime_types = [
    "image/jpeg",
    "image/pjpeg",
    "image/png",
    "image/x-png"
];

$required = ["title", "category", "description", "price"];
$errors = [];
$messages = [
    "title" => "Enter the name of the product or service",
    "category" => "Select a category",
    "description" => "Enter a description",
    "price" => "Enter the price"
];

if(isset($user)) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ad = $_POST;

        foreach ($_POST as $key => $value) {

            if (($key == "category") && ($value == "Select a category")) {
                $errors[$key] = $messages[$key];
            } elseif (in_array($key, $required) && (!$value)) {
                $errors[$key] = $messages[$key];
            }

            if ($key === "price" && ($value)) {
                $result = call_user_func("validateNumbers", $value);

                if ((!$result) || ($value <= 0) ) {
                    $errors[$key] = "Enter a positive integer";
                }
            }
        }

        if (is_uploaded_file($_FILES["img"]["tmp_name"])) {
            $tmp_name = $_FILES["img"]["tmp_name"];
            $file_name = $_FILES["img"]["name"];

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $tmp_name);

            if (!in_array($file_type, $img_mime_types)) {
                $errors["img"] = "Upload the image in the formats .jpeg, .jpg, .png";
            } else {
                $file_path = "photos/" . $file_name;
                move_uploaded_file($tmp_name, $file_path);
                $ad["img"] = $file_path;
            }
        }

        if (count($errors)) {
            $page_content = renderTemplate("templates/add-new-item.php", [
                "categories" => $categories,
                "ad" => $ad,
                "errors" => $errors,
                "user" => $user
            ]);
        } else {
            $title = $ad["title"];

            $sql = "INSERT INTO ads (title, created_at, price, img, description, category_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($connection, $sql);

            foreach ($categories as $cat) {
                if ($ad["category"] === $cat["name"]) {
                    $category_id = $cat["id"];
                }
            }

            $title = $ad["title"];
            $time = date("Y-m-d H:i:s", time());
            $price = $ad["price"];
            $img = isset($ad["img"]) ? $ad["img"] : "photos/No-image.jpg" ;
            $description = $ad["description"];
            $user_id = $user["id"];

            mysqli_stmt_bind_param($stmt, "sssssss", $title, $time, $price, $img, $description, $category_id, $user_id);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
                $id = mysqli_insert_id($connection);

                header("Location: /ad.php?id=" . $id);
            } else {
                $error_message = "MySQL error: " . mysqli_error($connection);

                $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
                $title = "Error";
            }
        }

    } else {
        $page_content = renderTemplate("templates/add-new-item.php", [
            "categories" => $categories,
            "errors" => $errors,
            "user" => $user
        ]);
    }

} else {
    http_response_code(403);
    $page_content = renderTemplate("templates/add-new-item.php", ["categories" => $categories]);
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