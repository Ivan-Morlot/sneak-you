<?php session_start(); require_once('..\utils\connection.php'); require_once("..\utils\admin-check.php");
    
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $db->exec("DELETE FROM customer WHERE (id = $id)");
        header("location:display-user.php");
    } else {
        header("location:home.php");
    }
