<?php session_start(); require_once("..\utils\connection.php"); require_once("..\utils\admin-check.php");

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
        if(isset($_POST['birthdate']) && $_POST['birthdate'] != "") {$birthdate = "'".$_POST['birthdate']."'";} else {$birthdate = 'NULL';}
        if(isset($_POST['sec-phone']) && $_POST['sec-phone'] != "") {$secPhone = "'".$_POST['sec-phone']."'";} else {$secPhone = 'NULL';}
        if(isset($_POST['address_supp']) && $_POST['address_supp'] != "") {$addressSupp = "'".$_POST['address_supp']."'";} else {$addressSupp = 'NULL';}
        if(isset($_POST['building']) && $_POST['building'] != "") {$building = "'".$_POST['building']."'";} else {$building = 'NULL';}
        if(isset($_POST['staircase']) && $_POST['staircase'] != "") {$staircase = "'".$_POST['staircase']."'";} else {$staircase = 'NULL';}
        if(isset($_POST['floor']) && $_POST['floor'] != "") {$floor = "'".$_POST['floor']."'";} else {$floor = 'NULL';}
        if(isset($_POST['door']) && $_POST['door'] != "") {$door = "'".$_POST['door']."'";} else {$door = 'NULL';}
        if(isset($_POST['password']) && $_POST['password'] != "") {
            $password = md5($_POST['password']);
            $db->exec("UPDATE customer SET gender = '$gender', prenom = '$prenom', nom = '$nom', email = '$email', password = '$password', auth_level = '$authLevel', birthdate = $birthdate, main_phone_number = '$mainPhone', secondary_phone_number = $secPhone, delivery_address = '$address', del_postal_code = '$postalCode', del_city = '$city', del_address_supp = $addressSup, del_building = $building, del_staircase = $staircase, del_floor = $floor, del_door = $door WHERE id='$id'");
        } else {
            $db->exec("UPDATE customer SET gender = '$gender', prenom = '$prenom', nom = '$nom', email = '$email', auth_level = '$authLevel', birthdate = $birthdate, main_phone_number = '$mainPhone', secondary_phone_number = $secPhone, delivery_address = '$address', del_postal_code = '$postalCode', del_city = '$city', del_address_supp = $addressSup, del_building = $building, del_staircase = $staircase, del_floor = $floor, del_door = $door WHERE id='$id'");
        }
        header("location:display-user.php");
    } else {
        header("location:home.php");
    }