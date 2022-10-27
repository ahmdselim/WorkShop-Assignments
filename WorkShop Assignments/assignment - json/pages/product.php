<?php
require_once("../inc/header.php");
if (!isset($_COOKIE["login"])) {
    header("location:./loginPage.php");
}
$id = $_GET["id"];
$file = file_get_contents("../database/posts.json");
$file_decode = json_decode($file, true);
$count = count($file_decode);
?>

<?php for ($i = 0; $i < $count; $i++) : ?>

    <?php if (in_array($id, $file_decode[$i])) : ?>

        <div class="container">
            <div class="row">
                <br>
                <br>
                <br>


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


                <div class="col-sm">
                    <div class="card">
                        <img class="card-img-top" src="https://th.bing.com/th/id/R.dae6c907958c2419e3b590b6b9440a2d?rik=8hBHSDg5GpFkJA&pid=ImgRaw&r=0" alt=" Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $file_decode[$i]["title"]; ?></h5>
                            <p class="card-text"><?php echo $file_decode[$i]["description"]; ?></p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted"><?php echo $file_decode[$i]["price"]; ?></small>


                            <form action="../actions/addToCart.php" method="POST">
                                <div class="mb-3 col-2">
                                    <label for="exampleInputPassword1" class="form-label">quantity</label>
                                    <input type="number" class="form-control" name="quantity">
                                    <input type="hidden" class="form-control" name="id" value="<?php echo $file_decode[$i]["id"]; ?>">
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php endif;
endfor; ?>

<?php require_once("../inc/footer.php"); ?>