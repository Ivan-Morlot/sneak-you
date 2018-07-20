<?php session_start(); require_once("..\utils\connection.php"); require_once("..\utils\admin-check.php");

    if (isset($_POST['id']) &&
        isset($_POST['name'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $db->exec("UPDATE product SET name = '$name' WHERE id='$id'");
        header("location:display-product.php");
    } else {
        header("location:home.php");
    }