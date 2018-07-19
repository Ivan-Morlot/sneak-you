<?php session_start(); require_once("utils\connection.php"); require_once("utils\adminCheck.php");

    if (isset($_POST['id']) &&
        isset($_POST['name'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $db->exec("UPDATE brand SET name = '$name' WHERE id='$id'");
        header("location:displayBrand.php");
    } else {
        header("location:adminZone.php");
    }