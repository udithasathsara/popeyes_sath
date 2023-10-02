<?php
    include 'components/connect.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }else {
        $user_id = '';
    }

    include 'components/add_wishlist.php';
    include 'components/add_cart.php';

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
    <title>Simarto - home page</title>
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <!----hero slider start----->
    <div class="slider-container">
        <div class="slider">
            <!----slide start----->
            <div class="slideBox active">
                <div class="textBox">
                    <h1>test sometime unique</h1>
                    <p>Italian Pizza Dough, Original Italian Tomato sauce, Mozzarella Cheese, Parmesan Cheese,
                         Ricotta Cheese & Original Italian Blue Cheese</p>
                    <div class="flex-btn">
                        <a href="menu.php" class="btn">view menu</a>
                        <a href="menu.php" class="btn">order now</a>
                    </div>
                </div>
                <div class="imgBox">
                    <img src="image/slider-2.png">
                </div>
            </div>
            <!----slide end----->
            <!----slide start----->
            <div class="slideBox">
                <div class="textBox">
                    <h1>extra spicy pizza</h1>
                    <p>Italian Pizza Dough, Original Italian Tomato sauce, Mozzarella Cheese, Parmesan Cheese,
                         Ricotta Cheese & Original Italian Blue Cheese</p>
                    <div class="flex-btn">
                        <a href="menu.php" class="btn">view menu</a>
                        <a href="menu.php" class="btn">order now</a>
                    </div>
                </div>
                <div class="imgBox">
                    <img src="image/slider-3.png">
                </div>
            </div>
            <!----slide end----->
            <!----slide start----->
            <div class="slideBox">
                <div class="textBox">
                    <h1>extra spicy pizza</h1>
                    <p>Italian Pizza Dough, Original Italian Tomato sauce, Mozzarella Cheese, Parmesan Cheese,
                         Ricotta Cheese & Original Italian Blue Cheese</p>
                    <div class="flex-btn">
                        <a href="menu.php" class="btn">view menu</a>
                        <a href="menu.php" class="btn">order now</a>
                    </div>
                </div>
                <div class="imgBox">
                    <img src="image/slider-4.png">
                </div>
            </div>
            <!----slide end----->
            <!----slide start----->
            <div class="slideBox">
                <div class="textBox">
                    <h1>extra spicy pizza</h1>
                    <p>Italian Pizza Dough, Original Italian Tomato sauce, Mozzarella Cheese, Parmesan Cheese,
                         Ricotta Cheese & Original Italian Blue Cheese</p>
                    <div class="flex-btn">
                        <a href="menu.php" class="btn">view menu</a>
                        <a href="menu.php" class="btn">order now</a>
                    </div>
                </div>
                <div class="imgBox">
                    <img src="image/slider-1.png">
                </div>
            </div>
            <!----slide end----->
        </div>
        <div class="controls">
            <li onclick="nextSlide();"><i class="bx bx-right-arrow-alt"></i></li>
            <li onclick="prevSlide();"><i class="bx bx-left-arrow-alt"></i></li>
        </div>
    </div>
    <!----category section----->
    <div class="category">
        <div class="title">
            <h1>top categories</h1>
            <p>Italian Pizza Dough, Original Italian Tomato sauce, Mozzarella Cheese, Parmesan Cheese,
                Ricotta Cheese & Original Italian Blue Cheese</p>
        </div>
        <div class="box-container">
            <div class="box">
                <div class="img-box">
                    <img src="image/food-35.png">
                </div>
                <p>what's hot</p>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="image/4.png">
                </div>
                <p>burger</p>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="image/food-18.png">
                </div>
                <p>chicken and salads</p>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="image/food-27.png">
                </div>
                <p>breakfast</p>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="image/food-36.png">
                </div>
                <p>dinner</p>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="image/food-42.png">
                </div>
                <p>deserts</p>
            </div>
        </div>
    </div>
    <!----container section----->
    <div class="container">
        <div class="box-container"> 
            <div class="box">
                <span>healthy food</span>
                <h1>save up to 50% off</h1>
                <p>Italian Pizza Dough, Original Italian Tomato sauce, Mozzarella Cheese, Parmesan Cheese,
                         Ricotta Cheese & Original Italian Blue Cheesev</p>
                <div class="flex-btn">
                    <a href="menu.php" class="btn">discover more</a>
                </div>
            </div>
            <div class="box">
                <img src="image/inner.png">
            </div>
        </div>
    </div>
    <!----container section----->
    <section class="products">
        <div class="title">
        <h1>top categories</h1>
            <p>Italian Pizza Dough, Original Italian Tomato sauce, Mozzarella Cheese, Parmesan Cheese,
                Ricotta Cheese & Original Italian Blue Cheese</p>
        </div>
        <?php include 'components/shop.php'; ?>
    </section>
    <div class="container">
        <div class="box-container"> 
            <div class="box">
                <img src="image/client.png">
            </div>
            <div class="box">
                <span>healthy food</span>
                <h1>save up to 50% off</h1>
                <p>Italian Pizza Dough, Original Italian Tomato sauce, Mozzarella Cheese, Parmesan Cheese,
                         Ricotta Cheese & Original Italian Blue Cheesev</p>
                <div class="flex-btn">
                    <a href="menu.php" class="btn">visit our menu</a>
                </div>
            </div>
        </div>
    </div>
    <div class="client">
        <div class="box-container">
            <div class="box">
                <img src="image/client.webp">
            </div>
            <div class="box">
                <img src="image/client0.webp">
            </div>
            <div class="box">
                <img src="image/client1.webp">
            </div>
            <div class="box">
                <img src="image/client2.webp">
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