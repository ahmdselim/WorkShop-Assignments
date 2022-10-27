<?php
setcookie("login", "login", time() - 3600, "/");
header("location: ./loginPage.php");

session_destroy();
