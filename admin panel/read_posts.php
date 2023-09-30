<?php
    include '../components/connect.php';
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)) {
        header('location:admin_login.php');
    }

    $get_id = $_GET['post_id'];

    //delete post
    if (isset($_POST['delete'])) {
        $p_id = $_POST['product_id'];
        $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);
    
        $delete_image = $conn->prepare("SELECT * FROM `products` WHERE id=?");
        $delete_image->execute([$p_id]);
        $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
        $success_msg[] = "product deleted successfully";
        if ($fetch_delete_image[''] != '') {
            unlink('../uploaded_img/'.$fetch_delete_image['image']);
        }
        $delete_post = $conn->prepare("DELETE FROM `products` WHERE id=?");
        $delete_post->execute([$p_id]);
        header("location:view_posts.php");
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
    <title>Admin - add product page</title>
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="read-post">
            <h1 class="heading">your product</h1>
            <div class="box-container">
                <?php
                    $select_post = $conn->prepare("SELECT * FROM `products` WHERE id=?");
                    $select_post->execute([$_GET['post_id']]);
                    if ($select_post->rowCount() > 0) {
                        while ($fetch_post = $select_post->fetch(PDO::FETCH_ASSOC)) {
                            
                     
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="product_id" value="<?= $fetch_post['id']; ?>">
                    <div class="status" style="color: <?php if($fetch_post['status']== 'active'){
                        echo "limegreen";
                    }else{echo "coral";} ?>;"><?= $fetch_post['status']; ?>
                    </div>
                    <?php if ($fetch_post['image'] != '') { ?>
                        <img src="../uploaded_img/<?= $fetch_post['image']; ?>" class="image">
                    <?php } ?>
                    <div class="price">Rs.<?= $fetch_post['price']; ?>/-</div>
                    <div class="title"><?= $fetch_post['name']; ?></div>
                    <div class="content"><?= $fetch_post['product_detail']; ?></div>
                    <div class="flex-btn">
                        <a href="edit_post.php?id=<?= $fetch_post['id']; ?>" class="btn">edit</a>
                        <button type="submit" name="delete" class="btn" onclick="return confirm('delete this product');">delete</button>
                        <a href="view_posts.php?post_id=<?= $fetch_post['id']; ?>" class="btn">go back</a>
                    </div>
                </form>
                <?php
                        }
                    }else{
                        echo '
                            <div class="empty">
                                <p>no products added yet! <br><a href="add_posts.php" class="btn" style="margin-top:1.5rem;">add product</a></p>
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