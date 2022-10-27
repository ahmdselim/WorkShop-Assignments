<?php
session_start();
require_once('./head.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $quantity = $_POST["quantity"];

    $user = $_SESSION["users"];

    $file = fopen("../database/products.csv", "a+");

    while (!feof($file)) {
        $data[] = fgetcsv($file);
    }

    $count = count($data) - 1;

    for ($i = 0; $i < $count; $i++) {
        if (in_array($id, $data[$i])) {
            $new = $data[$i];
        }
    }

    fclose($file);
    $cartFile = fopen("../database/cart.csv", "a+");
    $new[] = $quantity;
    $new[] = $user;
    fputcsv($cartFile, $new);

    fclose($cartFile);
    header("location:../pages/product.php?id=$id");
} else {
    echo <<<TYPE
    <div id="notfound"><div class="notfound"><div class="notfound-404"><h1>404</h1></div><h2>Oops! Nothing was found</h2><p>The page you are looking for might have been removed had its name changed or is temporarily unavailable. <a href="../pages/signupPage.php">Return to homepage</a></p></div></div>
    TYPE;
}
