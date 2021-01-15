<?php

require_once "functions.php";
require_once "init.php";
require_once "categories.php";

session_start();

$user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

if(isset($user)){

    if(isset($_GET["id"])) {
        
        $id = intval($_GET["id"]);
        $sql = "SELECT a.title, a.description, a.price, a.img, a.category_id, a.user_id,  
        c.id, c.name as cat_name FROM ads AS a JOIN categories AS C 
        ON a.category_id = c.id WHERE a.id = " . $id;
        
        $result = mysqli_query($connection, $sql);

        if ($result) {
            $old_ad = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $is_ad_author = ($user["id"] === $old_ad["user_id"]);
        } else {
            $error_message = "MySQL error: " . mysqli_error($connection);
    
            $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
            $title = "Error";
        }

        if($is_ad_author) {
            $title = "Editing an ad";

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
                    $page_content = renderTemplate("templates/edit.php", [
                        "categories" => $categories,
                        "ad" => $ad,
                        "errors" => $errors,
                        "user" => $user
                    ]);
                } else {
                    $title = $ad["title"];

                    $sql = "UPDATE ads SET title = ?, created_at = ?, price = ?, img = ?, 
                    description = ?, category_id = ? WHERE ads.id = " . $id;
                    
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
            
                    mysqli_stmt_bind_param($stmt, "ssssss", $title, $time, $price, $img, $description, $category_id);
                    $res = mysqli_stmt_execute($stmt);
            
                    if ($res) {            
                        header("Location: /ad.php?id=" . $id);
                    } else {
                        $error_message = "MySQL error: " . mysqli_error($connection);
            
                        $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
                        $title = "Error";
                    }
                }
            } else {
                $page_content = renderTemplate("templates/edit.php", [
                    "categories" => $categories,
                    "errors" => $errors,
                    "user" => $user,
                    "ad" => $old_ad
                ]);
            }
        } else {
            http_response_code(403);
            $page_content = renderTemplate("templates/edit.php", ["categories" => $categories]);
            $title = "Access denied";
        }
    }
} else {
    http_response_code(403);
    $page_content = renderTemplate("templates/edit.php", ["categories" => $categories]);
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