<?php
    include '../components/connect.php';
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)) {
        header('location:admin_login.php');
    }

    //delete message
    if (isset($_POST['delete_msg'])) {
        $delete_id =$_POST['delete_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

        $verify_delete = $conn->prepare("SELECT * FROM `message` WHERE id=?");
        $verify_delete->execute([$delete_id]);

        if ($verify_delete->rowCount() > 0) {
            $delete_message = $conn->prepare("DELETE FROM `message` WHERE id=?");
            $delete_message->execute([$delete_id]);
            $success_msg[] = 'message deleted successfully!';
        }else{
            $warning_msg[] = 'message already deleted!';

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
    <title>Admin - unread message page</title>
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="message-container">
            <h1 class="heading">user's messages</h1>
            <div class="box-container">
                <?php
                    $select_message = $conn->prepare("SELECT * FROM `message`");
                    $select_message->execute();
                    if ($select_message->rowCount() > 0) {
                        while ($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)) {
                           
                ?>
                <div class="box">
                    <h3 class="name"><?= $fetch_message['name']; ?></h3>
                    <h4><?= $fetch_message['subject']; ?></h4>
                    <p><?= $fetch_message['message']; ?></p>
                    <form action="" method="post">
                        <input type="hidden" name="delete_id" value="<?= $fetch_message['id']; ?>">
                        <input type="submit" name="delete_msg" value="delete message" class="btn" onclick="return confirm('delete this message');">
                    </form>
                </div>
                <?php
                        }
                    }else{
                        echo '
                            <div class="empty">
                                <p>no unread message yet! <br></p>
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