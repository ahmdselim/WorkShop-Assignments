<?php
$id = $_GET["id"];
$file = fopen("../database/cart.csv", "a+");

while (!feof($file)) {
    $data[] = fgetcsv($file, filesize("../database/cart.csv"));
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
$file = fopen("../database/cart.csv", "w");

foreach ($new as $product) {
    fputcsv($file, $product);
}
fclose($file);



header("location:../pages/cart.php");
