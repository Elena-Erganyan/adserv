<?php 

    require_once "functions.php";
    require_once "init.php";
    require_once "categories.php";
    
    session_start();

    $user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;
   
    // pagination

    $cur_page = $_GET["page"] ?? 1; // number of the current page
    $page_items = 3; // number of lots on a page

    // total amount of lots
    $sql = "SELECT COUNT(*) as cnt FROM ads";

    $result = mysqli_query($connection, $sql);

    if ($result) {

        $items_count = mysqli_fetch_assoc($result)["cnt"];

        $pages_count = ceil($items_count / $page_items); // number of pages
        $offset = ($cur_page - 1) * $page_items; // offset

        $pages = range(1, $pages_count); // array with numbers of pages

        $address = $_SERVER["PHP_SELF"] . "?";

        $pagination = renderTemplate("templates/pagination.php", [
            "pages_count" => $pages_count,
            "pages" => $pages,
            "cur_page" => $cur_page,
            "address" => $address
        ]);

        $sql = "SELECT a.id, a.title, a.price, a.img, c.name AS cat_name FROM ads AS a JOIN categories AS c ON a.category_id = c.id ORDER BY a.created_at DESC LIMIT " . $page_items . " OFFSET " . $offset;

        $ads = mysqli_query($connection, $sql);

        if ($ads) {

            // get page content
            $page_content = renderTemplate("templates/index.php", [
                "ads" => $ads,
                "pagination" => $pagination
            ]);
        } else {
            $error_message = "MySQL error: " . mysqli_error($connection);

            // get page content
            $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
        }

    } else {
        $error_message = "MySQL error: " . mysqli_error($connection);

        // get page content
        $page_content = renderTemplate("templates/error.php", ["error_message" => $error_message]);
    }

    $title = $result ? "Main" : "Error";

    $layout_content = renderTemplate("templates/layout.php", [
        "title" => $title,
        "categories" => $categories,
        "content" => $page_content,
        "user" => $user
    ]);
        
    print($layout_content);
    // print(password_hash('12345', PASSWORD_DEFAULT));

?>