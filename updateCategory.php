<?php session_start(); require_once("utils\connection.php"); require_once("utils\adminCheck.php");

    if (isset($_POST['id']) &&
        isset($_POST['name'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        if(isset($_POST['description']) && $_POST['description'] != "") {$dispDescription = $_POST['description']; $description = "'".$dispDescription."'";} else {$description = 'NULL';}
        $db->exec("UPDATE category SET name = '$name', description = $description WHERE id='$id'");
        header("location:displayCategory.php");
    } else {
        header("location:adminZone.php");
    }