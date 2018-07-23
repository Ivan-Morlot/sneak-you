<?php session_start(); require_once("..\utils\connection.php"); require_once("..\utils\admin-check.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout d'un utilisateur</title>
</head>
<body>
<?php
    if (isset($_POST['gender']) &&
        isset($_POST['prenom']) &&
        isset($_POST['nom']) &&
        isset($_POST['email']) &&
        isset($_POST['password']) &&
        isset($_POST['auth-level']) &&
        isset($_POST['main-phone']) &&
        isset($_POST['address']) &&
        isset($_POST['postal-code']) &&
        isset($_POST['city'])) {
        $gender = $_POST['gender'];
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $authLevel = $_POST['auth-level'];
        $mainPhone = $_POST['main-phone'];
        $address = $_POST['address'];
        $postalCode = $_POST['postal-code'];
        $city = $_POST['city'];
        if(isset($_POST['birthdate']) && $_POST['birthdate'] != "") {$dispBirthdate = $_POST['birthdate']; $birthdate = "'".$dispBirthdate."'";} else {$birthdate = 'NULL';}
        if(isset($_POST['sec-phone']) && $_POST['sec-phone'] != "") {$dispSecPhone = $_POST['sec-phone']; $secPhone = "'".$dispSecPhone."'";} else {$secPhone = 'NULL';}
        if(isset($_POST['address_supp']) && $_POST['address_supp'] != "") {$dispAddressSupp = $_POST['address_supp']; $addressSupp = "'".$dispAddressSupp."'";} else {$addressSupp = 'NULL';}
        if(isset($_POST['building']) && $_POST['building'] != "") {$dispBuilding = $_POST['building']; $building = "'".$dispBuilding."'";} else {$building = 'NULL';}
        if(isset($_POST['staircase']) && $_POST['staircase'] != "") {$dispStaircase = $_POST['staircase']; $staircase = "'".$dispStaircase."'";} else {$staircase = 'NULL';}
        if(isset($_POST['floor']) && $_POST['floor'] != "") {$dispFloor = $_POST['floor']; $floor = "'".$dispFloor."'";} else {$floor = 'NULL';}
        if(isset($_POST['door']) && $_POST['door'] != "") {$dispDoor = $_POST['door']; $door = "'".$dispDoor."'";} else {$door = 'NULL';}
        $db->exec("INSERT INTO `customer` (`id`,`gender`, `prenom`, `nom`, `email`, `password`, `auth_level`, `birthdate`, `main_phone_number`, `secondary_phone_number`, `delivery_address`, `del_postal_code`, `del_city`, `del_address_supp`, `del_building`, `del_staircase`, `del_floor`, `del_door`, `billing_address`, `bil_postal_code`, `bil_city`, `bil_address_supp`, `bil_building`, `bil_staircase`, `bil_floor`, `bil_door`, `credit_card_holder`, `credit_card_number`, `credit_card_expiration`) VALUES (NULL, '$gender', '$prenom', '$nom', '$email', '$password', '$authLevel', $birthdate, '$mainPhone', $secPhone, '$address', '$postalCode', '$city', $addressSupp, $building, $staircase, $floor, $door, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
?>
    <p>Utilisateur créé avec succès.</p>
    <p>Récapitulatif :</p>
    <table border="1">
        <tr>
            <td>Civilité</td>
            <td>
                <?= $gender ?>
            </td>
        </tr>
        <tr>
            <td>Prénom</td>
            <td>
                <?= $prenom ?>
            </td>
        </tr>
        <tr>
            <td>Nom</td>
            <td>
                <?= $nom ?>
            </td>
        </tr>
        <tr>
            <td>E-mail</td>
            <td>
                <?= $email ?>
            </td>
        </tr>
        <tr>
            <td>Niveau d'accès au site</td>
            <td>
                <?php if($authLevel == '0') {echo "Utilisateur";} else if($authLevel == '1') {echo "Administrateur";} else {echo "N/A";} ?>
            </td>
        </tr>
<?php if($birthdate != 'NULL') { ?>
        <tr>
            <td>Date de naissance</td>
            <td>
                <?= $dispBirthdate ?>
            </td>
        </tr>
<?php } ?>
        <tr>
            <td>Tél. principal</td>
            <td>
                <?= $mainPhone ?>
            </td>
        </tr>
<?php if($secPhone != 'NULL') { ?>
        <tr>
            <td>Tél. secondaire</td>
            <td>
                <?= $dispSecPhone ?>
            </td>
        </tr>
<?php } ?>
        <tr>
            <td>Adresse</td>
            <td>
                <?= $address ?>
            </td>
        </tr>
        <tr>
            <td>Code postal</td>
            <td>
                <?= $postalCode ?>
            </td>
        </tr>
        <tr>
            <td>Ville</td>
            <td>
                <?= $city ?>
            </td>
        </tr>
<?php if($addressSupp != 'NULL') { ?>
        <tr>
            <td>Complément d'adresse</td>
            <td>
                <?= $dispAdressSupp ?>
            </td>
        </tr>
<?php } ?>
<?php if($building != 'NULL') { ?>
        <tr>
            <td>Bâtiment</td>
            <td>
                <?= $dispBuilding ?>
            </td>
        </tr>
<?php } ?>
<?php if($staircase != 'NULL') { ?>
        <tr>
            <td>Escalier</td>
            <td>
                <?= $dispStaircase ?>
            </td>
        </tr>
<?php } ?>
<?php if($floor != 'NULL') { ?>
        <tr>
            <td>Etage</td>
            <td>
                <?= $dispFloor ?>
            </td>
        </tr>
<?php } ?>
<?php if($door != 'NULL') { ?>
        <tr>
            <td>Porte</td>
            <td>
                <?= $dispDoor ?>
            </td>
        </tr>
<?php } ?>
    </table>
    <br>
<?php
    } else {
        header("location:home.php");
    }
?>
    <br>
    <a href="display-category.php">Afficher les utilisateurs</a>
    <br>
    <a href="create-category.php">Créer un autre utilisateur</a>
    <br><br>
    <a href="home.php">Accueil admin</a>
    <br><br>
    <a href="../utils/logout.php">Déconnection</a>
    <script src="../js/tools.js"></script>
</body>
</html>