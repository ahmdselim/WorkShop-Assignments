<?php
require_once("../inc/head.php");
if (!isset($_COOKIE["login"])) {
    header("location:./loginPage.php");
}
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productName = $_POST["name"];
    $productDescription = $_POST["description"];
    $productQuantity = $_POST["quantity"];
    $productPrice = $_POST["price"];
    $id = 0;

    $errors = [];

    $product = ["id" => rand(0, 300), "title" => $productName, "description" => $productDescription, "quantity" => $productQuantity, "price" => $productPrice];

    $file = file_get_contents("../database/posts.json");
    $file_decode = json_decode($file, true);

    $file_decode[] = $product;
    $file_encode = json_encode($file_decode);

    if (empty($productName)) {
        $errors[] = "product name is required";
    } elseif (empty($productDescription)) {
        $errors[] = "product description is required";
    } elseif (empty($productQuantity)) {
        $errors[] = "product quantity is required";
    } else if (empty($productPrice)) {
        $errors[] = "product price is required";
    }


    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
        header("location: ../pages/homePage.php");
    } else {
        unset($_SESSION["errors"]);
        $_SESSION["success"] = "product is added";
        file_put_contents("../database/posts.json", $file_encode);
        header("location: ../pages/homePage.php");
    }
} else {
    echo <<<TYPE
    <div id="notfound"><div class="notfound"><div class="notfound-404"><h1>404</h1></div><h2>Oops! Nothing was found</h2><p>The page you are looking for might have been removed had its name changed or is temporarily unavailable. <a href="../pages/signupPage.php">Return to homepage</a></p></div></div>
    TYPE;
}
