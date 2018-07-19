<?php session_start(); require_once("..\utils\connection.php"); require_once("..\utils\admin-check.php");

    if (isset($_POST['id']) &&
        isset($_POST['name'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $db->exec("UPDATE brand SET name = '$name' WHERE id='$id'");
        header("location:display-brand.php");
    } else {
        header("location:home.php");
    }