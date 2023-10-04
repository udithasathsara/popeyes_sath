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

    //add review
    if (isset($_POST['add_review'])) {
        if ($user_id != '') {
            $id = unique_id();
            $title = $_POST['title'];
            $title = filter_var($title,FILTER_SANITIZE_STRING);

            $description = $_POST['description'];
            $description = filter_var($description,FILTER_SANITIZE_STRING);

            $ratings = $_POST['ratings'];
            $ratings = filter_var($ratings,FILTER_SANITIZE_STRING);

            $verify_rating = $conn->prepare("SELECT * FROM `reviews` WHERE post_id=? AND user_id=?");
            $verify_rating->execute([$get_id,$user_id]);

            if ($verify_rating->rowCount() > 0) {
                $warning_msg[] = 'your review already added';
            }else {
                $add_review = $conn->prepare("INSERT INTO `reviews`(id,post_id,user_id,rating,title,description) VALUES(?,?,?,?,?,?)");
                $add_review->execute([$id,$get_id,$user_id,$ratings,$title,$description]);
                $success_msg[] = 'Review added!';
            }
        }
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
    <title>Simarto - add review page</title>
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>add review</h1>
            <a href="home.php">home</a><span><i class="bx bx-right-arrow-alt"></i>add review</span>
        </div>
    </div>
    <div class="review">
        <div class="title">
            <h1>post your review</h1>
            <p>Since 1979 with years of experience and commitment to our customers</p>
        </div>
        <div class="form-container">
            <form action="" method="post">
                <div class="input-field">
                    <label>review title <sup>*</sup></label>
                    <input type="text" name="title" required maxlength="50" placeholder="Enter review title">
                </div>
                <div class="input-field">
                    <label>review description <sup>*</sup></label>
                    <textarea name="description" maxlength="100" cols="30" rows="10" placeholder="Enter review description"></textarea>
                 </div>
                 <div class="input-field">
                    <label>give ratings <sup>*</sup></label>
                    <select name="ratings" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                 </div>
                 <div class="flex-btn">
                    <input type="submit" name="add_review" value="post your review" class="btn">
                    <a href="order.php?get_id=<?= $get_id; ?>" class="btn" style="padding: 1rem 20%;">go back</a>
                 </div>
            </form>
        </div>   
    <?php include 'components/footer.php'; ?>
    <?php include 'components/dark.php'; ?>

    <script type="text/javascript" src="script.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <?php include 'components/alert.php';?>  
</body>
</html>