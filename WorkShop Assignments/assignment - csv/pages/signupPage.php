<?php require_once('../inc/header.php');
session_start();
if (isset($_COOKIE["login"])) {
    header("location:./homePage.php");
}
?>
<br><br>
<div class="container">
    <div class="row">
        <div class="col-8 mx-auto">
            <?php if (isset($_SESSION["error"])) {
                foreach ($_SESSION["error"] as $value) {
                    echo  <<<TYPE
                     <div class="alert alert-primary" role="alert"> $value</div>
                     TYPE;
                }
                unset($_SESSION["error"]);
            } ?>

            <?php if (isset($_SESSION["success"])) : ?>
                <div class="alert alert-primary" role="alert">
                    <?php
                    echo $_SESSION["success"];
                    unset($_SESSION["success"]); ?>
                </div>
            <?php endif; ?>

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
<?php require_once('../inc/footer.php'); ?>