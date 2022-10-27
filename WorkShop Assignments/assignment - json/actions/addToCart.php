<?php
require_once("../inc/head.php");
if (!isset($_COOKIE["login"])) {
    header("location:./loginPage.php");
}
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $quantity = $_POST["quantity"];
    $errors  = [];

    $cart = file_get_contents("../database/cart.json");
    $cart_decode = json_decode($cart, true);

    $products = file_get_contents("../database/posts.json");
    $products_decode = json_decode($products, true);



    $count = count($products_decode);

    for ($i = 0; $i < $count; $i++) {
        if (in_array($id, $products_decode[$i])) {
            $cart_data = ["title" => $products_decode[$i]["title"], "description" => $products_decode[$i]["description"], "price" => $products_decode[$i]["price"], "quantity" => $products_decode[$i]["quantity"], "usersQuantity" => $quantity];

            if ($products_decode[$i]["quantity"] < $quantity) {
                $errors[] = "the quantity of product is finished we are sorry :(";
            }
        }
    }

    $cart_decode[] = $cart_data;
    $cartData_encode = json_encode($cart_decode);

    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
        header("location:../pages/product.php?id=$id");
    } else {
        unset($_SESSION["errors"]);
        $_SESSION["success"] = "product is added to cart";
        file_put_contents("../database/cart.json", $cartData_encode);
        header("location:../pages/product.php?id=$id");
    }
} else {
    echo <<<TYPE
    <div id="notfound"><div class="notfound"><div class="notfound-404"><h1>404</h1></div><h2>Oops! Nothing was found</h2><p>The page you are looking for might have been removed had its name changed or is temporarily unavailable. <a href="../pages/signupPage.php">Return to homepage</a></p></div></div>
    TYPE;
}
