<?php
    include '../components/connect.php';
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)) {
        header('location:admin_login.php');
    }

    //delete message
    if (isset($_POST['delete_review'])) {
        $delete_id =$_POST['delete_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

        $verify_delete = $conn->prepare("SELECT * FROM `reviews` WHERE id=?");
        $verify_delete->execute([$delete_id]);

        if ($verify_delete->rowCount() > 0) {
            $delete_message = $conn->prepare("DELETE FROM `reviews` WHERE id=?");
            $delete_message->execute([$delete_id]);
            $success_msg[] = 'reviews deleted successfully!';
        }else{
            $warning_msg[] = 'reviews already deleted!';

        }
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
    <title>Admin - user's reviews page</title>
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="reviews-container">
            <h1 class="heading">user's reviews</h1>
            <div class="box-container">
            <?php
                    $select_reviews = $conn->prepare("SELECT * FROM `reviews`");
                    $select_reviews->execute();
                    if ($select_reviews->rowCount() > 0) {
                        while ($fetch_reviews = $select_reviews->fetch(PDO::FETCH_ASSOC)) {
                           
                ?>
                <div class="box">
                    <?php
                        $select_user = $conn->prepare("SELECT * FROM `users` WHERE id=?");
                        $select_user->execute([$fetch_reviews['user_id']]);
                            while ($fetch_user = $select_user->fetch(PDO::FETCH_ASSOC)) {
                           
                    ?>
                    <div class="user">
                        <?php if($fetch_user['profile'] != ''){?>
                            <img src="../uploaded_img/<?= $fetch_user['profile']; ?>">
                        <?php }else{ ?>
                            <h3><?= substr($fetch_user['name'], 0,1) ?></h3>
                        <?php } ?>
                        <div>
                            <p><?= $fetch_user['name']; ?></p>
                            <span><?= $fetch_reviews['date']; ?></span>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="ratings">
                        <?php if($fetch_reviews['rating'] == 1){?>
                            <p style="background: red;"><i class="bx bxs-star"></i><span><?= $fetch_reviews['rating']; ?></span></p>
                        <?php } ?>
                        <?php if($fetch_reviews['rating'] == 2){?>
                            <p style="background: red;"><i class="bx bxs-star"></i><span><?= $fetch_reviews['rating']; ?></span></p>
                        <?php } ?>
                        <?php if($fetch_reviews['rating'] == 3){?>
                            <p style="background: orange;"><i class="bx bxs-star"></i><span><?= $fetch_reviews['rating']; ?></span></p>
                        <?php } ?>
                        <?php if($fetch_reviews['rating'] == 4){?>
                            <p style="background: blue;"><i class="bx bxs-star"></i><span><?= $fetch_reviews['rating']; ?></span></p>
                        <?php } ?>
                        <?php if($fetch_reviews['rating'] == 5){?>
                            <p style="background: var(--inner-box-shadow);"><i class="bx bxs-star"></i><span><?= $fetch_reviews['rating']; ?></span></p>
                        <?php } ?>
                    </div>
                    <h3 class="title"><?= $fetch_reviews['title']; ?></h3>
                    <?php
                        if ($fetch_reviews['description'] != '') {
                            
                    ?>
                    <p class="description"><?= $fetch_reviews['description']; ?></p>
                    <?php } ?>
                    <form action="" method="post">
                        <input type="hidden" name="delete_id" value="<?= $fetch_reviews['id']; ?>">
                        <input type="submit" name="delete_review" value="delete review" class="btn" onclick="return confirm('delete this review');">
                    </form>
                </div>
                <?php
                        }
                    }else{
                        echo '
                            <div class="empty">
                                <p>no reviews yet! <br></p>
                            </div> 
                        ';
                    }
                ?>
            </div>
        </section>       
    </div>
    <?php 
    include '../components/dark.php'; ?>

    <script type="text/javascript" src="script.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <?php include '../components/alert.php';?>  
</body>
</html>