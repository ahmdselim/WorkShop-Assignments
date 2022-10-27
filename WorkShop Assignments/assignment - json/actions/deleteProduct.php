<?php

$id = $_GET["id"];

$data = file_get_contents("../database/posts.json");
$file_decode = json_decode($data, true);
$count = count($file_decode);

for ($i = 0; $i < $count; $i++) {
    if (in_array($id, $file_decode[$i])) {
        unset($file_decode[$i]);
    } else {
        $new[] = $file_decode[$i];
        continue;
    }
}

$fileEncode = json_encode($new);
file_put_contents("../database/posts.json", $fileEncode);
header("location:../pages/homePage.php");
