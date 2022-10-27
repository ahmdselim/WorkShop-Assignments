<?php
session_start();
require_once('./head.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $category = $_POST["category"];
    $product = $_POST["product"];
    $description = $_POST["description"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];

    $errors = [];
    $file = fopen("../database/products.csv", "a+");

    while (!feof($file)) {
        $data[] = fgetcsv($file);
    }


    $count = count($data) - 1;

    for ($i = 0; $i < $count; $i++) {
        if (in_array($id, $data[$i])) {
            $data[$i][1] = $category;
            $data[$i][2] = $product;
            $data[$i][3] = $price;
            $data[$i][4] = $description;
            $data[$i][5] = $quantity;
        }
    }

    fclose($file);
    echo "<pre>";
    print_r($data);

    if (empty($category)) {
        $errors[] = "category is required";
    }
    if (empty($product)) {
        $errors[] = "product is required";
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
        print_r($errors);

        header("location:../pages/editProduct.php?id=$id");
    } else {
        unset($_SESSION["error"]);
        $file = fopen("../database/products.csv", "w");

        for ($i = 0; $i < $count; $i++) {
            fputcsv($file, $data[$i]);
        }
        fclose($file);
        $_SESSION["success"] = "product updated";
        header("location:../pages/editProduct.php?id=$id");
    }
} else {
    echo <<<TYPE
    <div id="notfound"><div class="notfound"><div class="notfound-404"><h1>404</h1></div><h2>Oops! Nothing was found</h2><p>The page you are looking for might have been removed had its name changed or is temporarily unavailable. <a href="../pages/signupPage.php">Return to homepage</a></p></div></div>
    TYPE;
}
