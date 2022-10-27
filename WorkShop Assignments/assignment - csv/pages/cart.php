<?php
session_start();
require_once('../inc/header.php');

if (!isset($_COOKIE["login"])) {
    header("location:./loginPage.php");
}

$file = fopen("../database/cart.csv", "a+");

while (!feof($file)) {
    $data[] = fgetcsv($file, filesize("../database/cart.csv"));
}

$count = count($data);

?>

<div class="height d-flex justify-content-center align-items-center " style="
    flex-wrap: wrap;
">
    <?php
    if (!empty($data[0])) {
        for ($i = 0; $i < $count - 1; $i++) : ?>
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
                <h4>quantity of product : <?php echo $data[$i][5]; ?></h4>
                <h4>price of product : <?php echo $data[$i][3] . " $"; ?></h4>
                <h4>your quantity order : <?php echo $data[$i][6]; ?></h4>
                <h4>total : <?php echo $data[$i][3]  * $data[$i][6] . " $"; ?></h4>
                <p> <?php echo $data[$i][4]; ?></p>
                <a href="../actions/deleteCart.php?id=<?php echo $data[$i][0]; ?>" class="btn btn-danger">delete</a><br>
                <br>
            </div>
    <?php endfor;
    } else {
        echo "your cart is empty :(";
    }
    ?>


</div>
<?php if (!empty($data[0])) : ?>

    <a style="width:100%;" href="../actions/checkOut.php" class="btn btn-danger">checkOut</a><?php endif; ?>

</div>

<?php require_once('../inc/footer.php'); ?>