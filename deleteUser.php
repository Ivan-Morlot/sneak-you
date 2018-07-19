<?php session_start(); require_once('utils\connection.php'); require_once("utils\adminCheck.php");
    
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $db->exec("DELETE FROM customer WHERE (id = $id)");
        header("location:displayUser.php");
    } else {
        header("location:adminZone.php");
    }
