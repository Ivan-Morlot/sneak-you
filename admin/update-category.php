<?php session_start(); require_once("..\utils\connection.php"); require_once("..\utils\admin-check.php");

    if (isset($_POST['id']) &&
        isset($_POST['name'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        if(isset($_POST['description']) && $_POST['description'] != "") {$description = "'".$_POST['description']."'";} else {$description = 'NULL';}
        $db->exec("UPDATE category SET name = '$name', description = $description WHERE id='$id'");
        header("location:display-category.php");
    } else {
        header("location:home.php");
    }