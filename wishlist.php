<?php
    include 'components/connect.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }else {
        $user_id = '';
    }
   
    include 'components/add_cart.php';

    //delete product in wishlist
    if (isset($_POST['delete_item'])) {
        $wishlist_id = $_POST['wishlist_id'];
        $wishlist_id = filter_var($wishlist_id, FILTER_SANITIZE_STRING);

        $verify_delete = $conn->prepare("SELECT * FROM `wishlist` WHERE id=?");
        $verify_delete->execute([$wishlist_id]);

        if ($verify_delete->rowCount() > 0) {
            $delete_wishlist_id = $conn->prepare("DELETE FROM `wishlist` WHERE id=?");
            $delete_wishlist_id->execute([$wishlist_id]);
            $success_msg[] = 'wishlist item deleted successfully';
        }else {
            $warning_msg[] = 'wishlist item already deleted';

        }

    }

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
    <title>Simarto - wishlist page</title>
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>my wishlist</h1>
            <a href="home.php">home</a><span><i class="bx bx-right-arrow-alt"></i>my wishlist</span>
        </div>
    </div>
        <section class="products">
            <div class="title">
                <h1>products added in wishlist</h1>
            </div>
            <div class="box-container">
                <?php
                    $grand_total = 0;
                    $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id=?");
                    $select_wishlist->execute([$user_id]);
                    if ($select_wishlist->rowCount() > 0) {
                        while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
                            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id=?");
                            $select_products->execute([$fetch_wishlist['product_id']]);
                            if ($select_products->rowCount() > 0) {
                                $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                             
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
                    <img src="uploaded_img/<?= $fetch_products['image']; ?>">
                    <div class="button">
                        <div><h3 class="name"><?= $fetch_products['name']; ?></h3></div>
                        <div>
                            <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                            <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="bx bxs-show"></a>
                            <button type="submit" name="delete_item" onclick="return confirm('delete this item');"><i class="bx bx-x"></i></button>
                        </div>
                    </div>
                    <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                    <div class="flex">
                        <p class="price">price Rs.<?= $fetch_products['price']; ?>/-</p>
                    </div>
                    <div class="flex">
                        <input type="hidden" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
                        <a href="checkout.php?get_id=<?= $fetch_products['id']; ?>" class="btn" style="width:100%;">buy now</a>
                    </div>
                </form>
                <?php
                            $grand_total+=$fetch_wishlist['price'];
                            }
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