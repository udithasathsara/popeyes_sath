<?php
    include 'components/connect.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }else {
        $user_id = '';
    }

    //booking table
    if (isset($_POST['book_table'])) {
        if ($user_id != '') {
            $id = unique_id();
            $name = $_POST['name'];
            $name = filter_var($name, FILTER_SANITIZE_STRING);
            $email = $_POST['email'];
            $email = filter_var($email, FILTER_SANITIZE_STRING);
            $number = $_POST['number'];
            $number = filter_var($number, FILTER_SANITIZE_STRING);
            $select = $_POST['select'];
            $select = filter_var($select, FILTER_SANITIZE_STRING);
            $date = $_POST['date'];
            $date = filter_var($date, FILTER_SANITIZE_STRING);
            $time = $_POST['time'];
            $time = filter_var($time, FILTER_SANITIZE_STRING);
            $comment = $_POST['comment'];
            $comment = filter_var($comment, FILTER_SANITIZE_STRING);

            $reserve_table = $conn->prepare("INSERT INTO `reservation`(id,user_id,name,email,number,select_one,date,time,comment) VALUES(?,?,?,?,?,?,?,?,?)");
            $reserve_table->execute([$id,$user_id,$name,$email,$number,$select,$date,$time,$comment]);
            if ($reserve_table) {
                $success_msg[] = 'Table booked';
            }else {
                $warning_msg[] = 'something went wrong';
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
    <title>Simarto - view product page</title>
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>reserve your table</h1>
            <a href="home.php">home</a><span><i class="bx bx-right-arrow-alt"></i>reservation</span>
        </div>
    </div>
    <div class="reservation-container">
        <img src="image/table.png">
        <div class="form-container">
            <form action="" method="post">
                <div class="title">
                    <span>RESERVATION</span>
                    <h1>Book A Table</h1>
                    <p>Just A Few Click To Make The Reservation Online For Saving Your Time And Money</p>
                </div>
                <div class="input-field">
                    <label>name <sup>*</sup></label>
                    <input type="text" name="name" required placeholder="Enter Your Name">
                </div>
                <div class="input-field">
                    <label>email <sup>*</sup></label>
                    <input type="text" name="email" required placeholder="Enter Your Email">
                </div>
                <div class="input-field">
                    <label>phone number <sup>*</sup></label>
                    <input type="text" name="number" required placeholder="Enter Your phonenumber">
                </div>
                <div class="input-field">
                    <label>select one <sup>*</sup></label>
                    <select name="select">
                        <option value="select one">select one</option>
                        <option value="select two">select two</option>
                        <option value="select three">select three</option>
                        <option value="select four">select four</option>
                    </select>
                </div>
                <div class="input-field">
                    <label>date <sup>*</sup></label>
                    <input type="date" name="date" required placeholder="select a date">
                </div>
                <div class="input-field">
                    <label>time <sup>*</sup></label>
                    <select name="time">
                        <option value="7 AM">7 AM</option>
                        <option value="8 AM">8 AM</option>
                        <option value="9 AM">9 AM</option>
                        <option value="10 AM">10 AM</option>
                    </select>
                </div>
                <div class="input-field">
                    <label>comment <sup>*</sup></label>
                    <textarea name="comment" cols="30" rows="10" required placeholder="add any comment"></textarea>
                </div>
                <input type="submit" name="book_table" value="book table" class="btn">
            </form>
        </div>
    </div>
    <?php include 'components/footer.php'; ?>
    <?php include 'components/dark.php'; ?>

    <script type="text/javascript" src="script.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <?php include 'components/alert.php';?>  
</body>
</html>