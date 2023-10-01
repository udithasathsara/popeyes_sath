<?php
    include 'connect.php';

    session_start();
    session_unset();
    session_destroy();
    header('location:../admin panel/admin_login.php');


?>