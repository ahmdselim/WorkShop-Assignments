<?php

require_once("../inc/head.php");
session_start();


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST["id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $errors = [];

    $file = file_get_contents("../database/posts.json");
    $file_decode = json_decode($file, true);
    $count = count($file_decode);

    for ($i = 0; $i < $count; $i++) {
        if (in_array($id, $file_decode[$i])) {
            $file_decode[$i]["title"] = $title;
            $file_decode[$i]["description"] = $description;
            $file_decode[$i]["quantity"] = $quantity;
            $file_decode[$i]["price"] = $price;
        }
    }



    if (empty($title)) {
        $errors[] = "title is required";
    }
    if (empty($description)) {
        $errors[] = "description is required";
    }
    if (empty($quantity)) {
        $errors[] = "quantity is required";
    }
    if (empty($price)) {
        $errors[] = "price is required";
    }

    if (!empty($errors)) {
        $_SESSION["error"] = $errors;

        header("location:../pages/editProduct.php?id=$id");
    } else {
        unset($errors);
        $file_encode = json_encode($file_decode);
        file_put_contents("../database/posts.json", $file_encode);
        $_SESSION["success"] = "product updated";
        header("location:../pages/editProduct.php?id=$id");
    }

    // print_r($file_decode);
} else {
    echo <<<TYPE
    <div id="notfound"><div class="notfound"><div class="notfound-404"><h1>404</h1></div><h2>Oops! Nothing was found</h2><p>The page you are looking for might have been removed had its name changed or is temporarily unavailable. <a href="../pages/signupPage.php">Return to homepage</a></p></div></div>
    TYPE;
}
