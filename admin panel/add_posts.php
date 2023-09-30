<?php
    include '../components/connect.php';
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)) {
        header('location:admin_login.php');
    }

    //add product to database
    if (isset($_POST['publish'])) {
        $id = unique_id();
        $title = $_POST['title'];
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $content = $_POST['content'];
        $content = filter_var($content, FILTER_SANITIZE_STRING);

        $category = $_POST['category'];
        $category = filter_var($category, FILTER_SANITIZE_STRING);
        $status = 'active';

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_img/'.$image;

        $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ? AND id = ?");
        $select_image->execute([$image, $admin_id]);

        if (isset($image)) {
            if ($select_image->rowCount() > 0) {
                $warning_msg[] = 'image name repeated';
            }elseif ($image_size > 2000000) {
                $warning_msg[] = 'image size is too large';
            }else{
                move_uploaded_file($image_tmp_name, $image_folder);
            }
        }else{
            $image = '';
        }
        if ($select_image->rowCount() > 0 AND $image !='') {
            $warning_msg[] = 'please rename your image';
        }else{
            $insert_post = $conn->prepare("INSERT INTO `products`(id,name,price,image,category,product_detail,status) VALUES(?,?,?,?,?,?,?)");
            $insert_post->execute([$id, $title, $price, $image, $category, $content, $status]);
            $success_msg[] = 'product inserted successfully!';
        }

    }

    //save draft product to database
    if (isset($_POST['draft'])) {
        $id = unique_id();
        $title = $_POST['title'];
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $content = $_POST['content'];
        $content = filter_var($content, FILTER_SANITIZE_STRING);

        $category = $_POST['category'];
        $category = filter_var($category, FILTER_SANITIZE_STRING);
        $status = 'deactive';

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_img/'.$image;

        $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ? AND id = ?");
        $select_image->execute([$image, $admin_id]);

        if (isset($image)) {
            if ($select_image->rowCount() > 0) {
                $warning_msg[] = 'image name repeated';
            }elseif ($image_size > 2000000) {
                $warning_msg[] = 'image size is too large';
            }else{
                move_uploaded_file($image_tmp_name, $image_folder);
            }
        }else{
            $image = '';
        }
        if ($select_image->rowCount() > 0 AND $image !='') {
            $warning_msg[] = 'please rename your image';
        }else{
            $insert_post = $conn->prepare("INSERT INTO `products`(id,name,price,image,category,product_detail,status) VALUES(?,?,?,?,?,?,?)");
            $insert_post->execute([$id, $title, $price, $image, $category, $content, $status]);
            $success_msg[] = 'product save as draft!';
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
    <title>Admin - add product page</title>
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="post-editor">
            <h1 class="heading">add products</h1>
            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="input-field">
                        <label>product name<sup>*</sup></label>
                        <input type="text" name="title" maxlength="100" placeholder="add product name" required>
                    </div>
                    <div class="input-field">
                        <label>product price<sup>*</sup></label>
                        <input type="number" name="price" maxlength="100" placeholder="add product price" required>
                    </div>
                    <div class="input-field">
                        <label>product detail<sup>*</sup></label>
                        <textarea name="content" required maxlength="1000" placeholder="product detail"></textarea>
                    </div>
                    <div class="input-field">
                        <label>product category<sup>*</sup></label>
                        <select name="category" required>
                            <option selected disabled>-----Select Category-----</option>
                            <option value="what's hot">what's hot</option>
                            <option value="burgers">burgers</option>
                            <option value="chicken and salads">chicken and salads</option>
                            <option value="tacos,fries and sides">tacos,fries and sides</option>
                            <option value="breakfast">breakfast</option>
                            <option value="family dinner">family dinner</option>
                            <option value="shakes and dessert">shakes and dessert</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label>product image <sup>*</sup></label>
                        <input type="file" name="image" accept="image/*" required>
                    </div>
                    <div class="flex-btn">
                        <input type="submit" name="publish" value="publish now" class="btn">
                        <input type="submit" name="draft" value="save draft" class="btn">
                    </div>
                </form>
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