<?php
require_once("../inc/header.php");
if (!isset($_COOKIE["login"])) {
    header("location:./loginPage.php");
}
$file = file_get_contents("../database/posts.json");
$file_decode = json_decode($file, true);
?>



<div class="container">
    <br>
    <br>
    <br>

    <form method="POST" action="../actions/addProduct.php">

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
                <?php echo $_SESSION["success"];
                unset($_SESSION["success"]);
                ?>

            </div>
        <?php } ?>



        <div class="mb-3 col-2">
            <label for="exampleInputEmail1" class="form-label">name</label>
            <input type="text" class="form-control" name="name" aria-describedby="emailHelp">
        </div>
        <div class="mb-3 col-2">
            <label for="exampleInputEmail1" class="form-label">description</label>
            <input type="text" class="form-control" name="description" aria-describedby="emailHelp">
        </div>
        <div class="mb-3 col-2">
            <label for="exampleInputPassword1" class="form-label">quantity</label>
            <input type="number" class="form-control" name="quantity">
        </div>
        <div class="mb-3 col-2">
            <label for="exampleInputPassword1" class="form-label">price</label>
            <input type="number" class="form-control" name="price">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <br>
    <div class="row">
        <?php if (!empty($file_decode)) : foreach ($file_decode as $key => $posts) :  ?>

                <div class="col-sm">
                    <div class="card">
                        <img class="card-img-top" src="https://th.bing.com/th/id/R.dae6c907958c2419e3b590b6b9440a2d?rik=8hBHSDg5GpFkJA&pid=ImgRaw&r=0" alt=" Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $posts["title"]; ?></h5>
                            <p class="card-text"><?php echo $posts["description"]; ?></p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted"><?php echo $posts["price"]; ?></small>
                            <a href="../actions/deleteProduct.php?id=<?php echo $posts["id"]; ?>">
                                <button>حذف</button>
                            </a>

                            <a href="./editProduct.php?id=<?php echo $posts["id"]; ?>">
                                <button>تعديل</button>
                            </a>

                            <a href="./product.php?id=<?php echo $posts["id"]; ?>">
                                <button>الذهاب الي المنتج</button>
                            </a>

                        </div>
                    </div>
                </div>


        <?php endforeach;
        endif; ?>
    </div>
</div>

<?php require_once("../inc/footer.php"); ?>