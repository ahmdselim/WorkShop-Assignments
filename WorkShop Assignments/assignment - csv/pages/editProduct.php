<?php
require_once("../inc/header.php");
if (!isset($_COOKIE["login"])) {
    header("location:./loginPage.php");
}
$id = $_GET["id"];

$file = fopen("../database/products.csv", "a+");

while (!feof($file)) {
    $data[] = fgetcsv($file, filesize("../database/products.csv"));
}

$count = count($data) - 1;

?>


<div class="container py-4 my-4 mx-auto d-flex flex-column">
    <?php for ($i = 0; $i < $count; $i++) : ?>
        <?php if (in_array($id, $data[$i])) : ?>
            <div class="header">
                <div class="row r1">
                    <div class="col-md-9 abc">
                        <h1><?php echo $data[$i][1]; ?></h1>
                    </div>
                    <div class="col-md-3 text-right pqr"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                </div>
            </div>
            <div class="container-body mt-4">
                <div class="row r3">
                    <div class="col-md-5 p-0 klo">

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


                        <form method="POST" action="../actions/updateProduct.php">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">category </label>
                                <input type="text" class="form-control" name="category" value="<?php echo $data[$i][1]; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">product Name</label>
                                <input type="text" class="form-control" name="product" value="<?php echo $data[$i][2]; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">description</label>
                                <input type="text" class="form-control" name="description" value="<?php echo $data[$i][4]; ?>">
                            </div>

                            <input type="hidden" hidden name="id" value="<?php echo $data[$i][0]; ?>" />

                            <div class=" mb-3">
                                <label for="exampleInputPassword1" class="form-label">quantity</label>
                                <input type="number" class="form-control" name="quantity" value="<?php echo $data[$i][5]; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">price</label>
                                <input type="number" class="form-control" name="price" value="<?php echo $data[$i][3]; ?>">
                            </div>

                            <button type="submit" class="btn btn-primary">تعديل</button>
                        </form>
                    </div>
                    <div class="col-md-7"> <img src="https://assetscdn1.paytm.com/images/catalog/product/K/KI/KIDTORADO-MUSCUTORA65799297FD22C/1564571511644_0.jpg" width="90%" height="95%"> </div>
                </div>
            </div>

        <?php endif; ?> <?php endfor; ?>

</div>
<?php require_once("../inc/footer.php"); ?>