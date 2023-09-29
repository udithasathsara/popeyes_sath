<?php
    include '../components/connect.php';
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)) {
        header('location:admin_login.php');
    }
?>

<style>
    <?php include 'admin_style.css'; ?>

</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <title>Admin - Dashboard</title>
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="dashboard">
            <h1 class="heading">dashboard</h1>
            <div class="box-container">
                <div class="box">
                    <h3>welcome!</h3>
                    <p><?= $fetch_profile['name']; ?></p>
                    <a href="update_profile.php" class="btn">update profile</a>
                </div>
                <div class="box">
                    <?php
                       $select_message = $conn->prepare("SELECT * FROM `message` ");
                       $select_message->execute();
                       $number_of_msg = $select_message->rowCount();
                    ?>
                    <h3><?= $number_of_msg; ?></h3>
                    <p>unread messages</p>
                    <a href="admin_message.php" class="btn">see messages<a>
                </div>
                <div class="box">
                    <?php
                       $select_post = $conn->prepare("SELECT * FROM `products` ");
                       $select_post->execute();
                       $number_of_post = $select_post->rowCount();
                    ?>
                    <h3><?= $number_of_post; ?></h3>
                    <p>products added</p>
                    <a href="admin_posts.php" class="btn">add new products<a>
                </div>
                <div class="box">
                    <?php
                       $select_active_post = $conn->prepare("SELECT * FROM `products` WHERE status =?");
                       $select_active_post->execute(['active']);
                       $number_of_active_post = $select_active_post->rowCount();
                    ?>
                    <h3><?= $number_of_active_post; ?></h3>
                    <p>total active products</p>
                    <a href="admin_posts.php" class="btn">see products<a>
                </div>
                <div class="box">
                    <?php
                       $select_deactive_post = $conn->prepare("SELECT * FROM `products` WHERE status =?");
                       $select_deactive_post->execute(['deactive']);
                       $number_of_deactive_post = $select_deactive_post->rowCount();
                    ?>
                    <h3><?= $number_of_deactive_post; ?></h3>
                    <p>total active products</p>
                    <a href="admin_posts.php" class="btn">see products<a>
                </div>
            </div>
        </section>
    </div>
    <?php include '../components/dark.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>