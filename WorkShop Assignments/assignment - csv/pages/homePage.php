<?php
session_start();
require_once('../inc/header.php');

if (!isset($_COOKIE["login"])) {
    header("location:./loginPage.php");
}

$file = fopen("../database/products.csv", "a+");

while (!feof($file)) {
    $data[] = fgetcsv($file, filesize("../database/products.csv"));
}

$count = count($data);

?>
<div class="container">

    <form method="POST" action="../actions/addProduct.php">

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

        <div class="mb-3 col-2">
            <label for="exampleInputEmail1" class="form-label">category</label>
            <input type="text" class="form-control" name="category" aria-describedby="emailHelp">
        </div>
        <div class="mb-3 col-2">
            <label for="exampleInputEmail1" class="form-label">product</label>
            <input type="text" class="form-control" name="product" aria-describedby="emailHelp">
        </div>
        <div class="mb-3 col-2">
            <label for="exampleInputPassword1" class="form-label">price</label>
            <input type="number" class="form-control" name="price">
        </div>
        <div class="mb-3 col-2">
            <label for="exampleInputPassword1" class="form-label">quantity</label>
            <input type="number" class="form-control" name="quantity">
        </div>
        <div class="mb-3 col-2">
            <label for="exampleInputPassword1" class="form-label">description</label>
            <input type="text" class="form-control" name="description">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <div class="height d-flex justify-content-center align-items-center " style="
    flex-wrap: wrap;
">
        <?php for ($i = 0; $i < $count - 1; $i++) : ?>
            <div class="card p-3 " style="margin-left: 20px;">
                <div class="d-flex justify-content-between align-items-center  ">
                    <div class="mt-2">
                        <h4 class="text-uppercase"><?php echo $data[$i][1]; ?></h4>
                        <div class="mt-5">
                            <h1 class="main-heading mt-0"><?php echo $data[$i][2]; ?></h1>
                        </div>
                    </div>
                    <div class="image">
                        <img src="https://i.imgur.com/MGorDUi.png" width="200">
                    </div>
                </div>
                <h4>quantity : <?php echo $data[$i][5] . " $"; ?></h4>
                <p> <?php echo $data[$i][4]; ?></p>
                <a href="../actions/deleteProduct.php?id=<?php echo $data[$i][0]; ?>" class="btn btn-danger">delete</a>
                <br>
                <a href="./editProduct.php?id=<?php echo $data[$i][0]; ?>" class="btn btn-danger">edit</a>
                <br>
                <a href="./product.php?id=<?php echo $data[$i][0]; ?>" class="btn btn-danger">Go to product</a>
            </div>
        <?php endfor; ?>


    </div>
</div>

<?php require_once('../inc/footer.php'); ?>