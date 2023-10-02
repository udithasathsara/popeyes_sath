<?php
    include 'components/connect.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }else {
        $user_id = '';
    }
    $get_id = isset($_GET['get_id']) ? $_GET['get_id'] : '';


    include 'components/add_wishlist.php';
    include 'components/add_cart.php';

?>

<style>
    <?php include 'style.css'; ?>

</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <title>Simarto - menu page</title>
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>our menu</h1>
            <a href="home.php">home</a><span><i class="bx bx-right-arrow-alt"></i>our menu</span>
        </div>
    </div>
        <section class="products">
            <div class="box-container">
                <?php
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE status=?");
                    $select_products->execute(['active']);
                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {

                ?>
            <form action="" method="post" class="box">
                <img src="uploaded_img/<?= $fetch_products['image']; ?>" class="image">
                <div class="button">
                    <div><h3 class="name"><?= $fetch_products['name']; ?></h3></div>
                    <div>
                        <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                        <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                        <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="bx bxs-show"></a>
                    </div>
                </div>
                <p class="price">price Rs.<?= $fetch_products['price']; ?></p>
                <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                <div class="flex-btn">
                    <a href="checkout.php?get_id=<?= $fetch_products['id']; ?>" class="btn">buy now</a>
                    <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
                </div>
            </form>
            <?php
                }
                }else {
                        echo '
                            <div class="empty">
                            <p>no products added yet!</p>
                            </div>
                            ';
                }
            ?>
            </div>
        </section>       
    </div>
    <?php include 'components/footer.php'; ?>
    <?php include 'components/dark.php'; ?>

    <script type="text/javascript" src="script.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <?php include 'components/alert.php';?>  
</body>
</html>