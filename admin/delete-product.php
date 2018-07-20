<?php session_start(); require_once('..\utils\connection.php'); require_once("..\utils\admin-check.php");
    
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $db->exec("DELETE FROM product_size WHERE (product_id = $id)");
        $db->exec("DELETE FROM product WHERE (id = $id)");
        header("location:display-product.php");
    } else {
        header("location:home.php");
    }
