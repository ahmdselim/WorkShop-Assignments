<?php

require_once("../inc/header.php");
$file = file_get_contents("../database/users.json");
if (isset($_SESSION["errors"])) {
    print_r($_SESSION["errors"]);
}
if (isset($_SESSION["success"])) {
    print_r($_SESSION["success"]);
}

// var_dump(json_decode($file));
// while (!feof($file)) {
//     $read = fread($file, filesize("../database/users.json"));
//     $decodeJson = json_decode($read, JSON_FORCE_OBJECT);
//     print_r($decodeJson[0]);
// }
?>

<br><br>
<div class="container">
    <div class="row">
        <div class="col-8 mx-auto">
            <?php
            if (isset($_SESSION["errors"])) {
                foreach ($_SESSION["errors"] as $user) {
                    echo  <<<TYPE
                     <div class="alert alert-primary" role="alert"> $user</div>
                     TYPE;
                }
                unset($_SESSION["errors"]);
            } elseif (isset($_SESSION["success"])) { ?>
                <div class="alert alert-primary" role="alert">
                    <?php echo $_SESSION["success"]; ?>
                </div>


            <?php
                unset($_SESSION["success"]);
            } elseif (isset($_SESSION["exist"])) { ?> <div class="alert alert-primary" role="alert">
                    <?php echo $_SESSION["exist"]; ?>
                </div>
            <?php    }
            unset($_SESSION["exist"]);
            ?>


            <form method="POST" action="../actions/signup.php">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Name</label>
                    <input type="string" class="form-control" name="username">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php require_once("../inc/footer.php"); ?>