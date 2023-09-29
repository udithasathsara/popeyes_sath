<?php
    include '../components/connect.php';
    session_start();

    if (isset($_POST['submit'])) {
        $name=$_POST['name'];
        $name=filter_var($name, FILTER_SANITIZE_STRING);
        $pass=sha1($_POST['pass']);
        $pass=filter_var($pass, FILTER_SANITIZE_STRING);

        $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name=? AND password=?");
        $select_admin->execute([$name, $pass]);

        if ($select_admin->rowCount() > 0) {
            $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
            $_SESSION['admin_id'] = $fetch_admin_id['id'];
            header('location:dashboard.php');
        }else {
            $warning_msg[]='incorrect username or password';
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Admin - registration page</title>
</head>
<body>
        <section class="form-container" id="admin-login">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3> login now </h3>
                    <div class="input-field">
                        <label>user name <sup>*</sup></label>
                        <input type="text" name="name" maxlength="20" required placeholder="Enter User Name" oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <div class="input-field">
                        <label>user password <sup>*</sup></label>
                        <input type="password" name= "pass" maxlength="20" required placeholder="Enter Your Password" oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <input type="submit" name="submit" value="login now" class="btn">
                </form>
        </section>
    <?php 
    include '../components/dark.php';
    include '../components/alert.php';
    ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>