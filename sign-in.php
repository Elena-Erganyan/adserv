<?php

require_once "functions.php";
require_once "init.php";
require_once "categories.php";

session_start();

$required = ["email", "password"];
$errors = [];
$messages = [
    "email" => "Enter e-mail",
    "password" => "Enter password"
];

$user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

$sql = "SELECT * FROM users";
$result = mysqli_query($connection, $sql);

if ($result) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $title = "Sign in";
} else {
    $error_message = "MySQL error: " . mysqli_error($connection);

    $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
    $title = "Error";
}

if(!$user) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $form = $_POST;

        foreach ($_POST as $key => $value) {

            if (in_array($key, $required) && (!$value)) {
                $errors[$key] = $messages[$key];
            }

            if ($form["email"] !== "") {
                if ($user = searchUserByEmail($form["email"], $users)) {
                    if (password_verify($form["password"], $user["password"])) {
                        $_SESSION["user"] = $user;
                    } elseif ($form["password"] !== "") {
                        $errors["password"] = "You entered an incorrect password";
                    }
                } else {
                    $errors["email"] = "The user is not found";
                    if ($form["password"] !== "") {
                        $errors["password"] = "You entered an incorrect password";
                    }
                }
            }
        }

        if (count($errors)) {
            $page_content = renderTemplate("templates/sign-in.php", [
                "form" => $form,
                "errors" => $errors
            ]);
        } else {
            header("Location: /index.php");
            exit();
        }

    } else {
        $page_content = renderTemplate("templates/sign-in.php", [
            "errors" => $errors
        ]);
    }

    $layout_content = renderTemplate("templates/layout.php", [
        "title" => $title,
        "categories" => $categories,
        "content" => $page_content,
        "user" => $user
    ]);

    print($layout_content);

} else {
    header("Location: /index.php");
    exit();
}

?>
