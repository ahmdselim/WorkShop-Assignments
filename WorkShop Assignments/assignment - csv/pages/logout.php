<?php
setcookie("login", "login", time() + - (60 * 60), "/");
header("location: ./loginPage.php");
