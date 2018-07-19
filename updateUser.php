<?php session_start(); require_once("utils\connection.php"); require_once("utils\adminCheck.php");

    if (isset($_POST['id']) &&
        isset($_POST['gender']) &&
        isset($_POST['prenom']) &&
        isset($_POST['nom']) &&
        isset($_POST['email']) &&
        isset($_POST['auth-level']) &&
        isset($_POST['main-phone']) &&
        isset($_POST['address']) &&
        isset($_POST['postal-code']) &&
        isset($_POST['city'])) {
        $id = $_POST['id'];
        $gender = $_POST['gender'];
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $authLevel = $_POST['auth-level'];
        $mainPhone = $_POST['main-phone'];
        $address = $_POST['address'];
        $postalCode = $_POST['postal-code'];
        $city = $_POST['city'];
        if(isset($_POST['birthdate']) && $_POST['birthdate'] != 0) {$dispBirthdate = $_POST['birthdate']; $birthdate = "'".$dispBirthdate."'";} else {$birthdate = 'NULL';}
        if(isset($_POST['sec-phone']) && $_POST['sec-phone'] != 0) {$dispSecPhone = $_POST['sec-phone']; $secPhone = "'".$dispSecPhone."'";} else {$secPhone = 'NULL';}
        if(isset($_POST['password']) && $_POST['password'] != 0) {
            $password = md5($_POST['password']);
            $db->exec("UPDATE customer SET gender = '$gender', prenom = '$prenom', nom = '$nom', email = '$email', password = '$password', auth_level = '$authLevel', birthdate = $birthdate, main_phone_number = '$mainPhone', secondary_phone_number = $secPhone, delivery_address = '$address', del_postal_code = '$postalCode', del_city = '$city' WHERE id='$id'");
        } else {
            $db->exec("UPDATE customer SET gender = '$gender', prenom = '$prenom', nom = '$nom', email = '$email', auth_level = '$authLevel', birthdate = $birthdate, main_phone_number = '$mainPhone', secondary_phone_number = $secPhone, delivery_address = '$address', del_postal_code = '$postalCode', del_city = '$city' WHERE id='$id'");
        }
        header("location:displayUser.php");
    } else {
        header("location:adminZone.php");
    }