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
    <title>registered user's page</title>
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="accounts">
            <h1 class="heading">registered user's</h1>
            <div class="box-container">
                <?php
                    $select_admins = $conn->prepare("SELECT * FROM `admin`");
                    $select_admins->execute();
                    if ($select_admins->rowCount() > 0) {
                        while ($fetch_admins = $select_admins->fetch(PDO::FETCH_ASSOC)) {
                            $admins_id = $fetch_admins['id'];
                ?>
                <div class="box">
                    <img src="../uploaded_img/<?= $fetch_admins['profile']; ?>">
                    <p>admin id: <span><?= $admins_id ?></span></p>
                    <p>admin name: <span><?= $fetch_admins['name']; ?></span></p>
                    <p>admin email: <span><?= $fetch_admins['email']; ?></span></p>

                </div>
                <?php
                        }
                    }else{
                        echo '
                            <div class="empty">
                                <p>no admin registered yet! <br></p>
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