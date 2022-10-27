<?php

$file = fopen("../database/cart.csv", "a+");

while (!feof($file)) {
    $data[] = fgetcsv($file);
}
$new = $data;
$count = count($data) - 1;

for ($i = 0; $i < $count; $i++) {
    unset($data[$i]);
}
fclose($file);

$file = fopen("../database/cart.csv", "w");
$count = count($data) - 1;

if (empty($data[1])) {
    for ($i = 0; $i < $count; $i++) {
        fputcsv($file, $data[$i]);
    }
    echo "<pre>";
    print_r($new);

    $checkout_file = fopen("../database/checkOut.csv", "a+");
    $count = count($new) - 1;

    for ($i = 0; $i < $count; $i++) {
        fputcsv($checkout_file, $new[$i]);
    }
}


fclose($file);
header("location:../pages/cart.php");
