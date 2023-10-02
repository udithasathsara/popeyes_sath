<?php
    //adding product in cart
    if (isset($_POST['add_to_cart'])) {
        if ($user_id != '') {
            $id = unique_id();
            $product_id = $_POST['product_id'];

            $qty = $_POST['qty'];
            $qty = filter_var($qty, FILTER_SANITIZE_STRING);

            $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id =?");
            $verify_cart->execute([$user_id, $product_id]);

            $max_cart_item = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $max_cart_item->execute([$user_id]);

            if ($verify_cart->rowCount() > 0) {
                $warning_msg[] = 'product already exist in your cart';
            }elseif ($max_cart_item->rowCount() > 20) {
                $warning_msg[] = 'cart is full';
            }else {
                $select_price = $conn->prepare("SELECT * FROM `products` WHERE id=? LIMIT 1");
                $select_price->execute([$product_id]);
                $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

                $insert_cart = $conn->prepare("INSERT INTO `cart` (id,user_id,product_id,price,qty) VALUES(?,?,?,?,?)");
                $insert_cart->execute([$id,$user_id,$product_id,$fetch_price['price'],$qty]);

                $success_msg[] = 'product added to cart';
            }
        }else {
            $warning_msg[] = 'please login first';
        }
    }
?>