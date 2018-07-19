<?php session_start(); require_once('utils\connection.php'); require_once("utils\adminCheck.php");
    
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $db->exec("DELETE FROM category WHERE (id = $id)");
        header("location:displayCategory.php");
    } else {
        header("location:adminZone.php");
    }
