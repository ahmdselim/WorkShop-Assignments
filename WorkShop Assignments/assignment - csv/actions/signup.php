<?php
session_start();
require_once('./head.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $file = fopen("../database/users.csv", "a+");




    while (!feof($file)) {
        $users = fgetcsv($file);
        $allUsers[] = $users;
    }

    $countUsers = count($allUsers);

    for ($i = 0; $i < $countUsers; $i++) {
        $emails[] = $allUsers[$i][0];
    }


    $email = $_POST["email"];
    $password = $_POST["password"];
    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);

    if (empty($email)) {
        $errors[] = "Email is required !";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Un validate Email :( ";
    }

    if (empty($username)) {
        $errors[] = "username is required !";
    } elseif (strlen($username) < 3) {
        $errors[] = "username must be greater than 5 :( ";
    } elseif (strlen($username) > 25) {
        $errors[] = "username must be less than 25 :( ";
    }

    if (empty($password)) {
        $errors[] = "password is required !";
    } elseif (strlen($password) < 5) {
        $errors[] = "password must be greater than 5 :( ";
    } elseif (strlen($password) > 25) {
        $errors[] = "password must be less than 25 :( ";
    }

    // if ($emailDb == $email) {
    //     $errors[] = "your email it`s in our database please signup with another email";
    // }

    if (in_array($email, $emails)) {
        $errors[] = "your email it`s in our database please signup with another email";
    }

    if (!empty($errors)) {
        $_SESSION["error"] = $errors;
        header("location: ../pages/signupPage.php");
    } else {
        unset($_SESSION["error"]);
        $_SESSION["success"] = "Congrats You are In Now (:";
        $_SESSION["users"] = $userEmail;
        setcookie("login", "login", time() + 60 * 60, "/");
        $user = [$email, $username, sha1($password)];
        $file = fopen("../database/users.csv", "a+");

        fputcsv($file, $user);
        fclose($file);
        header("location: ../pages/signupPage.php");
    }
} else {
    echo <<<TYPE
    <div id="notfound"><div class="notfound"><div class="notfound-404"><h1>404</h1></div><h2>Oops! Nothing was found</h2><p>The page you are looking for might have been removed had its name changed or is temporarily unavailable. <a href="../pages/signupPage.php">Return to homepage</a></p></div></div>
    TYPE;
}
