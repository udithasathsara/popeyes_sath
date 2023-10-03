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
    <title>Simarto - contact us page</title>
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>contact us</h1>
            <a href="home.php">home</a><span><i class="bx bx-right-arrow-alt"></i>contact us</span>
        </div>
    </div>
    <div class="services">
        <div class="box-container">
            <div class="box">
                <img src="image/0.png">
                <div>
                    <h1>Free Shipping fast</h1>
                    Since 1979 with years of experience and commitment to our customers, 
                </div>
            </div>
            <div class="box">
                <img src="image/1.png">
                <div>
                    <h1>money back & gurantee</h1>
                    Since 1979 with years of experience and commitment to our customers, 
                </div>
            </div>
            <div class="box">
                <img src="image/2.png">
                <div>
                    <h1>online support 24</h1>
                    Since 1979 with years of experience and commitment to our customers, 
                </div>
            </div>
        </div>
    </div>
    <div class="contact">
        <div class="form-container">
            <form action="" method="post">
                <div class="img-box"><img src="image/contact.png"></div>
                <div class="title">
                    <h1>Drop Us A Line</h1>
                    <p style="text-align: center;">Since 1979 with years of experience and commitment to our customers,</p>
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
                    <label>subject <sup>*</sup></label>
                    <input type="text" name="subject" required placeholder="reason">
                </div> 
                <div class="input-field">
                    <label>comment <sup>*</sup></label>
                    <textarea name="message" cols="30" rows="10" required placeholder="add any comment"></textarea>
                </div>
                <input type="submit" name="send_message" value="send message" class="btn">
            </form>
        </div>
    </div>
    <div class="address">
        <div class="title">
            <h1>our contact</h1>
            <p>Since 1979 with years of experience and commitment to our customers,</p>
        </div>
        <div class="box-container">
            <div class="box">
                <i class="bx bxs-map-alt"></i>
                <div>
                    <h4>address</h4>
                    <p>Gorakana Road,Panadura,Sri Lanka <br>20/6</p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-phone-incoming"></i>
                <div>
                    <h4>phone number</h4>
                    <p>0774687925</p>
                </div>
            </div>
            <div class="box">
                <i class="bx bxs-envelope"></i>
                <div>
                    <h4>email</h4>
                    <p>sathsarajmu0077@gmail.com</p>
                </div>
            </div>
        </div>
    </div>
    <?php include 'components/footer.php'; ?>
    <?php include 'components/dark.php'; ?>

    <script type="text/javascript" src="script.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <?php include 'components/alert.php';?>  
</body>
</html>