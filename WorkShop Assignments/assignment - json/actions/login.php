<?php
require_once("../inc/head.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = sha1($_POST["password"]);
    $errors = [];

    $allData = file_get_contents("../database/users.json");
    $decode_allData = json_decode($allData, true);
    echo "<pre>";

    foreach ($decode_allData as $users) {
        // print_r($users);
        if ($users["email"] == $email) {
            if ($users["password"] == $password) {
                break;
            }
        } else {
            $errors[] = "email or password wrong";
            break;
        }
    }

    if (empty($email)) {
        $errors[] = "email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "email not validate";
    }

    if (empty($password)) {
        $errors[] = "password is required";
    }

    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
        header("location: ../pages/loginPage.php");
        // print_r($errors);
    } else {
        unset($_SESSION["errors"]);
        $_SESSION["success"] = "welcome back :) ";
        $_SESSION["users"] = $email;
        header("location: ../pages/homePage.php");
        setcookie("login", "login", time() + 3600, "/");
    }
} else {
    echo <<<TYPE
    <div id="notfound"><div class="notfound"><div class="notfound-404"><h1>404</h1></div><h2>Oops! Nothing was found</h2><p>The page you are looking for might have been removed had its name changed or is temporarily unavailable. <a href="../pages/signupPage.php">Return to homepage</a></p></div></div>
    TYPE;
}
