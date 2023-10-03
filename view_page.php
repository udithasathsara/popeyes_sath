<?php
    include 'components/connect.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }else {
        $user_id = '';
    }

    if (isset($_GET['get_id'])) {
        $get_id = $_GET['get_id'];
    } else {
        $get_id = ''; // Set a default value if 'get_id' is not provided in the query string
    }
   
    include 'components/add_cart.php';
    include 'components/add_wishlist.php';
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
    <title>Simarto - view product page</title>
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>view product</h1>
            <a href="home.php">home</a><span><i class="bx bx-right-arrow-alt"></i>view product</span>
        </div>
    </div>
        <section class="view_page">
            <?php
                if (isset($_GET['pid'])) {
                    $pid = $_GET['pid'];
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id='$pid'");
                    $select_products->execute();
                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
 
            ?>
            <form action="" method="post" class="box">
                <img src="uploaded_img/<?= $fetch_products['image']; ?>">
                <div class="detail">
                    <p class="price">Rs. <?= $fetch_products['price']; ?>/-</p>
                    <div class="name"><?= $fetch_products['name']; ?></div>
                    <p class="product-detail"><?= $fetch_products['product_detail']; ?></p>
                    <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                    <div class="button">
                        <button type="submit" name="add_to_wishlist" class="btn">add to wishlist<i class="bx bx-heart"></i></button>
                        <input type="hidden" name="qty" value="1" min="0" class="quantity">
                        <button type="submit" name="add_to_cart" class="btn">add to cart<i class="bx bx-cart"></i></button>
                    </div>
                </div>
            </form>
            <?php 
                        }
                     }
                } 
            ?>
        </section>
        <section class="products">
            <div class="title">
                <h1>similar products</h1>
                <p>Java Lounge Colombo is one of the oldest coffee houses in Sri Lanka. Java is well known for emphasizing on serving quality coffee all the time. We currently have around 5 branches and is growing rapidly</p>
            </div>
            <?php include 'components/shop.php';?>
        </section>  
    </div>
    <?php include 'components/footer.php'; ?>
    <?php include 'components/dark.php'; ?>

    <script type="text/javascript" src="script.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <?php include 'components/alert.php';?>  
</body>
</html>