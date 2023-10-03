<?php
    include 'components/connect.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }else {
        $user_id = '';
    }

    //send message
    if (isset($_POST['send_message'])) {
        if ($user_id != '') {
            $id = unique_id();
            $name = $_POST['name'];
            $name = filter_var($name, FILTER_SANITIZE_STRING);
            $email = $_POST['email'];
            $email = filter_var($email, FILTER_SANITIZE_STRING);
            $subject = $_POST['subject'];
            $subject = filter_var($subject, FILTER_SANITIZE_STRING);
            $message = $_POST['message'];
            $message = filter_var($message, FILTER_SANITIZE_STRING);

            $verify_message = $conn->prepare("SELECT * FROM `message` WHERE user_id=? AND name=? AND email=? AND subject=? AND message =?");
            $verify_message->execute([$user_id,$name,$email,$subject,$message]);

            if ($verify_message->rowCount() > 0) {
                $warning_msg[] = 'message already exist';
            }else {
                $insert_message = $conn->prepare("INSERT INTO `message`(id,user_id,name,email,subject,message) VALUES(?,?,?,?,?,?)");
                $insert_message->execute([$id,$user_id,$name,$email,$subject,$message]);
                $success_msg[] = 'comment inserted successfully';
            }
        }else {
            $warning_msg[] = 'please login first!';
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
    
    <?php include 'components/footer.php'; ?>
    <?php include 'components/dark.php'; ?>

    <script type="text/javascript" src="script.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <?php include 'components/alert.php';?>  
</body>
</html>