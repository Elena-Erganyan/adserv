<?php

require_once "functions.php";
require_once "init.php";
require_once "categories.php";

session_start();

$user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;
$title = "New user registration";

$required = ["email", "password", "name", "phone"];
$errors = [];
$messages = [
    "email" => "Enter your e-mail",
    "password" => "Enter your password",
    "name" => "Enter your name",
    "phone" => "Enter your phone number"
];

if (isset($user)) {
    header("Location: /index.php");
    exit();
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $sql = "SELECT email from users";

        $result = mysqli_query($connection, $sql);

        if($result) {
            $emails = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            $error_message = "MySQL error: " . mysqli_error($connection);

            $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
            $title = "Error";
        }

        $new_user = $_POST;

        foreach ($_POST as $key => $value) {

            if (in_array($key, $required) && (!$value)) {
                $errors[$key] = $messages[$key];
            }

            if ($key == 'email' && ($value)) {
                $result = call_user_func('validateEmail', $value);

                if (!$result) {
                    $errors[$key] = "Enter a valid email";
                } elseif (isset($emails)) {
                    foreach ($emails as $item) {
                        if ($item["email"] === $_POST["email"]) {
                            $errors[$key] = "A user with this email address is already registered";
                            break;
                        }
                    }
                }
            }

            if ($key == 'phone' && ($value)) {
                $result = call_user_func('validatePhone', $value);

                if (!$result) {
                    $errors[$key] = "Enter a valid phone number";
                }
            }
        }

        if (count($errors)) {
            $page_content = renderTemplate("templates/sign-up.php", [
                "errors" => $errors,
                "user" => $user,
                "new_user" => $new_user
            ]);
        } else {
            $sql = "INSERT INTO users (registered_at, name, email, password, phone) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($connection, $sql);

            $time = date("Y-m-d H:i:s", time());
            $name = $new_user["name"];
            $email = $new_user["email"];
            $password = password_hash($new_user["password"], PASSWORD_DEFAULT);
            $phone = $new_user["phone"];
        
            mysqli_stmt_bind_param($stmt, "sssss", $time, $name, $email, $password, $phone);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
                header("Location: /sign-in.php");
            } else {
                $error_message = "MySQL error: " . mysqli_error($connection);

                $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
                $title = "Error";
            }
        }
    }
}

$page_content = renderTemplate("templates/sign-up.php", [
    "user" => $user,
    "errors" => $errors
]);

$layout_content = renderTemplate("templates/layout.php", [
    "title" => $title,
    "categories" => $categories,
    "content" => $page_content,
    "user" => $user
]);

print($layout_content);

?>
