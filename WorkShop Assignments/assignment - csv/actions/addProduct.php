<?php
session_start();
require_once('./head.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST["category"];
    $product = $_POST["product"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $description = $_POST["description"];




    $errors = [];

    if (empty($category)) {
        $errors[] = " category required";
    } elseif (strlen($category) > 30) {
        $errors[] = "category must have < 30 char";
    } elseif (strlen($category) < 3) {
        $errors[] = "category must have > 3 char";
    }

    if (empty($product)) {
        $errors[] = " product required";
    } elseif (strlen($product) > 30) {
        $errors[] = "product must have < 30 char";
    } elseif (strlen($product) < 3) {
        $errors[] = "product must have > 3 char";
    }

    if (empty($description)) {
        $errors[] = " description required";
    } elseif (strlen($description) > 30) {
        $errors[] = "description must have < 30 char";
    } elseif (strlen($description) < 3) {
        $errors[] = "description must have > 3 char";
    }

    if (empty($price)) {
        $errors[] = " category required";
    }
    if (empty($quantity)) {
        $errors[] = " quantity required";
    }

    if (!empty($errors)) {
        $_SESSION["error"] = $errors;
        print_r($errors);
        header("location:../pages/homepage.php");
    } else {
        unset($errors);
        $file = fopen("../database/products.csv", "a+");
        $products = [rand(1, 300), $category, $product, $price, $description, $quantity];
        fputcsv($file, $products);
        fclose($file);
        $_SESSION["success"] = "good product uploaded";
        header("location:../pages/homepage.php");
    }
} else {
    echo <<<TYPE
    <div id="notfound"><div class="notfound"><div class="notfound-404"><h1>404</h1></div><h2>Oops! Nothing was found</h2><p>The page you are looking for might have been removed had its name changed or is temporarily unavailable. <a href="../pages/signupPage.php">Return to homepage</a></p></div></div>
    TYPE;
}
