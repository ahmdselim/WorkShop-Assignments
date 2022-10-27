<?php
$id = $_GET["id"];
$file = fopen("../database/products.csv", "a+");

while (!feof($file)) {
    $data[] = fgetcsv($file, filesize("../database/products.csv"));
}

$count = count($data) - 1;
for ($i = 0; $i < $count; $i++) {
    if (in_array($id, $data[$i])) {
        unset($data[$i]);
    } else {
        $new[] = $data[$i];
    }
}

fclose($file);
$file = fopen("../database/products.csv", "w");

foreach ($new as $product) {
    fputcsv($file, $product);
}
fclose($file);



header("location:../pages/homePage.php");
