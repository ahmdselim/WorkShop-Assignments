<?php
require_once("../inc/head.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
    $password = $_POST["password"];

    $errors = [];

    if (empty($email)) {
        $errors[] = "email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "email not validate";
    }

    if (empty($username)) {
        $errors[] = "username is required";
    } elseif (strlen($username) < 2) {
        $errors[] = "username must greater than 2 char";
    } elseif (strlen($username) > 25) {
        $errors[] = "username must less than 25 char";
    }

    if (empty($password)) {
        $errors[] = "password is required";
    } elseif (strlen($password) < 4) {
        $errors[] = "password must greater than 2 char";
    } elseif (strlen($password) > 25) {
        $errors[] = "password must less than 25 char";
    }


    $allPastData = file_get_contents("../database/users.json");
    $allPastData_decode = json_decode($allPastData, true);
    echo "<pre>";

    foreach ($allPastData_decode as $allUsers) {
        if ($allUsers["email"] != $email) {
            break;
        } else {
            $errors[] = "please use another email";
            break;
        }
    }



    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
        // print_r($errors);
        header("location: ../pages/signupPage.php");
    } else {
        $_SESSION["success"] = "you are with our now";
        $userData = ["email" => $email, "username" => $username, "password" => sha1($password)];
        $pastData = file_get_contents("../database/users.json");
        $pastData_decode = json_decode($pastData, true);

        if (!empty($pastData_decode)) {
            if (count($pastData_decode) > 0) {
                $pastData_decode[] = $userData;
                $allData_encode = json_encode($pastData_decode);
                file_put_contents("../database/users.json", $allData_encode);
            } else {
                $allData = [];
                $allData[] = $userData;
                $allData_encode = json_encode($allData);
                file_put_contents("../database/users.json", $allData_encode);
            }
        } else {
            $allData = [];
            $allData[] = $userData;
            $allData_encode = json_encode($allData);
            file_put_contents("../database/users.json", $allData_encode);
        }
        $getAllData = file_get_contents("../database/users.json", true);
        $getAllData_decode = json_decode($getAllData, true);
        unset($_SESSION["errors"]);
        unset($_SESSION["exist"]);
        header("location: ../pages/signupPage.php");
    }
} else {
    echo <<<TYPE
    <div id="notfound"><div class="notfound"><div class="notfound-404"><h1>404</h1></div><h2>Oops! Nothing was found</h2><p>The page you are looking for might have been removed had its name changed or is temporarily unavailable. <a href="../pages/signupPage.php">Return to homepage</a></p></div></div>
    TYPE;
}
