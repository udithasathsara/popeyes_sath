<?php
    include '../components/connect.php';
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)) {
        header('location:admin_login.php');
    }
    //update booking
    if (isset($_POST['update_booking'])) {
        $booking_id = $_POST['booking_id'];
        $booking_id = filter_var($booking_id, FILTER_SANITIZE_STRING);

        $confirm_booking = $_POST['confirm_booking'];
        $confirm_booking = filter_var($confirm_booking, FILTER_SANITIZE_STRING);

        $update_booking = $conn->prepare("UPDATE `reservation` SET confirmation = ? WHERE id = ?");
        $update_booking->execute([$confirm_booking, $booking_id]);
        $success_msg[] = 'booking updated!';
    }
    
    //delete reservation
    if (isset($_POST['delete_booking'])) {
        $delete_id = $_POST['booking_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

        $verify_delete = $conn->prepare("SELECT * FROM `reservation` WHERE id=?");
        $verify_delete->execute([$delete_id]);

        if ($verify_delete->rowCount() > 0) {
            $delete_booking = $conn->prepare("DELETE FROM `reservation` WHERE id=?");
            $delete_booking->execute([$delete_id]);
            $success_msg[] = 'reservation deleted!';
        }else{
            $warning_msg[] = 'reservation already deleted';
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
            <h1 class="heading">user's reservation</h1>
            <div class="box-container">
            <?php
                    $select_reservation = $conn->prepare("SELECT * FROM `reservation`");
                    $select_reservation->execute();
                    if ($select_reservation->rowCount() > 0) {
                        while ($fetch_reservation = $select_reservation->fetch(PDO::FETCH_ASSOC)) {
                           
                ?>
                <div class="box">
                        <p class="name"><?= $fetch_reservation['name']; ?></span></p>
                        <p><span>user email: </span><?= $fetch_reservation['user_id']; ?></p>
                        <p><span>user number: </span><?= $fetch_reservation['number']; ?></p>
                        <p><span>total person: </span><?= $fetch_reservation['select_one']; ?></p>
                        <p><span>date: </span><?= $fetch_reservation['date']; ?></p>
                        <p><span>time: </span><?= $fetch_reservation['time']; ?></p>
                        <p><span>comment: </span><?= $fetch_reservation['comment']; ?></p>
                        <form action="" method="post">
                        <input type="hidden" name="booking_id" value="<?= $fetch_reservation['id']; ?>">
                        <select name="confirm_booking">
                            <option selected disabled><?= $fetch_reservation['confirmation']; ?></option>
                            <option value="pending">Pending</option>
                            <option value="complete">Complete</option>
                        </select>
                        <div class="flex-btn">
                        <input type="submit" name="update_booking" value="update booking" class="btn">
                        <input type="submit" name="delete_booking" value="delete booking" class="btn" onclick="return confirm('delete this booking');">
                        </div>
                    </form>
                    </div>
                <?php
                        }
                    }else{
                        echo '
                            <div class="empty">
                                <p>no reservation yet! <br></p>
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