<?php
session_start();
require_once('./head.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = $_POST["email"];
    $password = $_POST["password"];

    $errors = [];
    $file = fopen("../database/users.csv", "a+");

    // while (($dataFile = fgetcsv($file, filesize("../database/users.csv"))) !== FALSE) {
    //     $arr[] = $dataFile;
    // }

    while (!feof($file)) {
        $arr[] =  fgetcsv($file, filesize("../database/users.csv"));
    }

    $countArr = count($arr);

    for ($i = 0; $i < $countArr; $i++) {
        $users_email[] = ($arr[$i][0]);
    }

    for ($i = 0; $i < $countArr; $i++) {
        $users_password[] = ($arr[$i][2]);
    }


    if (!in_array($userEmail, $users_email) || !in_array(sha1($password), $users_password)) {
        $errors[] = "the email or password is wrong";
    }


    if (empty($userEmail)) {
        $errors[] = "Email is required !";
    }

    if (empty($password)) {
        $errors[] = "password is required !";
    }

    if (!empty($errors)) {
        $_SESSION["error"] = $errors;
        print_r($errors);
        header("location: ../pages/loginPage.php");
    } else {
        unset($_SESSION["error"]);
        $_SESSION["success"] = "Welcome back bro (:";
        $_SESSION["users"] = $userEmail;
        header("location: ../pages/loginPage.php");
        setcookie("login", "login", time() + 60 * 60, "/");
    }
} else {
    echo <<<TYPE
    <div id="notfound"><div class="notfound"><div class="notfound-404"><h1>404</h1></div><h2>Oops! Nothing was found</h2><p>The page you are looking for might have been removed had its name changed or is temporarily unavailable. <a href="../pages/signupPage.php">Return to homepage</a></p></div></div>
    TYPE;
}
