<?php
    include 'components/connect.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }else {
        $user_id = '';
    }

    if (isset($_POST['submit'])) {
        /*$id = uniqid_id();*/

        $email=$_POST['email'];
        $email=filter_var($email, FILTER_SANITIZE_STRING);
        $pass=sha1($_POST['pass']);
        $pass=filter_var($pass, FILTER_SANITIZE_STRING);

        $select_user =$conn->prepare("SELECT * FROM  `users` WHERE email=? AND password=?");
        $select_user->execute([$email, $pass]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($select_user->rowCount() > 0) {
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
        }else {
            $warning_msg[] = 'incorrect password or username' ;
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>user - login page</title>
</head>
<body>
            <section>
            <div class="form-container" id="admin-login">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3>login now</h3>
                    <div class="input-field">
                        <label>user email<sup>*</sup></label>
                        <input type="email" name= "email" maxlength="25" required placeholder="Enter User Email" oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <div class="input-field">
                        <label>user password <sup>*</sup></label>
                        <input type="password" name= "pass" maxlength="20" required placeholder="Enter Your Password" oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <input type="submit" name="submit" value="login now" class="btn">
                    <p>do not have an account <a href="register.php"> Register now! </a></p>
                </form>
            </div>
        </section>
    <?php 
    include 'components/dark.php';
    include 'components/alert.php';
    ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>