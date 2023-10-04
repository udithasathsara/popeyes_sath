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
    }else {
        $get_id = '';
        header('location:order.php');
    }

    if (isset($_POST['cancel'])) {
        $update_order = $conn->prepare("UPDATE `orders` SET status=? WHERE id=?");
        $update_order->execute(['canceled',$get_id]);
        header('location:order.php');
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
    <title>Simarto - view order page</title>
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>order-detail</h1>
            <a href="home.php">home</a><span><i class="bx bx-right-arrow-alt"></i>my order</span>
        </div>
    </div>
    <div class="order-detail">
        <div class="title">
            <h1>my order detail</h1>
            <p>Since 1979 with years of experience and commitment to our customers, </p>
        </div>
        <div class="box-container">
            <?php
                $grand_total = 0;
                $select_order = $conn->prepare("SELECT * FROM `orders` WHERE id=? LIMIT 1");
                $select_order->execute([$get_id]);
                if ($select_order->rowCount() > 0) {
                    while ($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)) {
                        $select_product = $conn->prepare("SELECT * FROM `products` WHERE id=? LIMIT 1");
                        $select_product->execute([$fetch_order['product_id']]);
                        if($select_product->rowCount() > 0){
                            while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                               $sub_total = ($fetch_order['price']*$fetch_order['qty']);
                               $grand_total+= $sub_total;
                    
            ?>
            <div class="box">
                <div class="col">
                    <p class="title"><i class="bx bxs-calender-alt"></i><?= $fetch_order['date']; ?></p>
                    <img src="uploaded_img/<?= $fetch_product['image']; ?>" class="image">
                    <p class="price">Rs.<?= $fetch_product['price'];?> X <?= $fetch_order['qty']; ?>/-</p>
                    <h3 class="name"><?= $fetch_product['name']; ?></h3>
                    <p class="grand-total">total amount payable : <span><?= $grand_total; ?></span></p>
                </div>
                <div class="col">
                    <p class="title">billing address</p>
                    <p class="user"><i class="bi bi-person-bouding-box"></i><?= $fetch_order['name']; ?></p>
                    <p class="user"><i class="bi bi-phone"></i><?= $fetch_order['number']; ?></p>
                    <p class="user"><i class="bi bi-envelope"></i><?= $fetch_order['email']; ?></p>
                    <p class="user"><i class="bi bi-pin-map-fill"></i><?= $fetch_order['address']; ?></p>
                    <p class="title">status</p>
                    <p class="status" style="color:<?php if($fetch_order['status']=='delivered'){echo "green";}elseif($fetch_order['status']=='canceled')
                    {echo "red";}else{echo "orange";}?>"><?= $fetch_order['status']; ?></p>
                    <?php
                        if ($fetch_order['status']=='canceled') { ?>
                          <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn">order again</a>  
                        <?php }else{ ?>
                            <form action="" method="post">
                                <button type="submit" name="cancel" class="btn" onclick="return confirm('do you want to cancel this order')">cancel</button>
                            </form>
                    <?php } ?>
                </div>
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