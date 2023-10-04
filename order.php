<?php
    include 'components/connect.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }else {
        $user_id = '';
    }

    //send message
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
    <title>Simarto - my order page</title>
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>my order</h1>
            <a href="home.php">home</a><span><i class="bx bx-right-arrow-alt"></i> my order</span>
        </div>
    </div>
    <div class="orders">
        <div class="title">
            <h1>my orders</h1>
            <p>Since 1979 with years of experience and commitment to our customers</p>
        </div>
        <div class="box-container">
            <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id=? ORDER BY date DESC");
                $select_orders->execute([$user_id]);
                if ($select_orders->rowCount() > 0) {
                    while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                        $product_id = $fetch_orders['product_id'];
                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id=?");
                        $select_products->execute([$fetch_orders['product_id']]);
                        if ($select_products->rowCount() > 0) {
                            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                                
            ?>
            <div class="box" <?php if ($fetch_orders['status']=='canceled') {echo 'style="border:2px solid red;"';}?>>
                <a href="view_order.php?get_id=<?= $fetch_orders['id']; ?>">
                <p class="date"><i class="bx bxs-calender-alt"></i><span><?= $fetch_orders['date']; ?></span></p>
                <img src="uploaded_img/<?= $fetch_products['image']; ?>" class="image">
                <div class="row">
                    <h3 class="name"><?= $fetch_products['name']; ?></h3>
                    <p class="price">Price: Rs.<?= $fetch_products['price']; ?>/-</p>
                    <p class="status" style="color:<?php if($fetch_orders['status']=='delivered'){echo "green";}elseif($fetch_orders['status']=='canceled')
                    {echo "red";}else{echo "orange";}?>"><?= $fetch_orders['status']; ?></p>
                </div>
                </a>
                <a href="add_review.php?get_id=<?= $product_id; ?>" class="btn">add_review</a>
            </div>
            <?php
                                }
                            }
                        }
                    }else {
                        echo '<p class="empty">no order take placed yet!</p>';
                    }
            ?>
        </div>
    </div>
    <?php include 'components/footer.php'; ?>
    <?php include 'components/dark.php'; ?>

    <script type="text/javascript" src="script.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <?php include 'components/alert.php';?>  
</body>
</html>