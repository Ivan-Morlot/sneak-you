<?php session_start(); require_once("utils\connection.php"); require_once("utils\adminCheck.php"); ?>

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
        if(isset($_POST['birthdate']) && $_POST['birthdate'] != 0) {$dispBirthdate = $_POST['birthdate']; $birthdate = "'".$dispBirthdate."'";} else {$birthdate = 'NULL';}
        if(isset($_POST['sec-phone']) && $_POST['sec-phone'] != 0) {$dispSecPhone = $_POST['sec-phone']; $secPhone = "'".$dispSecPhone."'";} else {$secPhone = 'NULL';}
        $db->exec("INSERT INTO `customer` (`id`,`gender`, `prenom`, `nom`, `email`, `password`, `auth_level`, `birthdate`, `main_phone_number`, `secondary_phone_number`, `delivery_address`, `del_postal_code`, `del_city`, `del_address_supp`, `del_building`, `del_staircase`, `del_floor`, `del_door`, `billing_address`, `bil_postal_code`, `bil_city`, `bil_address_supp`, `bil_building`, `bil_staircase`, `bil_floor`, `bil_door`, `credit_card_holder`, `credit_card_number`, `credit_card_expiration`) VALUES (NULL, '$gender', '$prenom', '$nom', '$email', '$password', '$authLevel', $birthdate, '$mainPhone', $secPhone, '$address', '$postalCode', '$city', NULL, NULL, NULL, NULL, NULL, '$address', '$postalCode', '$city', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
?>
    <p>Utilisateur créé avec succès.</p>
    <p>Récapitulatif :</p>
    <table border="1">
        <tr>
            <td>Civilité</td>
            <td>
                <?php echo $gender ?>
            </td>
        </tr>
        <tr>
            <td>Prénom</td>
            <td>
                <?php echo $prenom ?>
            </td>
        </tr>
        <tr>
            <td>Nom</td>
            <td>
                <?php echo $nom ?>
            </td>
        </tr>
        <tr>
            <td>E-mail</td>
            <td>
                <?php echo $email ?>
            </td>
        </tr>
        <tr>
            <td>Niveau d'accès au site</td>
            <td>
                <?php if($authLevel == 0) {echo "Utilisateur";} else if($authLevel == 1) {echo "Administrateur";} else {echo "N/A";} ?>
            </td>
        </tr>
<?php if($birthdate != 'NULL') { ?>
        <tr>
            <td>Date de naissance</td>
            <td>
                <?php echo $dispBirthdate ?>
            </td>
        </tr>
<?php } ?>
        <tr>
            <td>Tél. principal</td>
            <td>
                <?php echo $mainPhone ?>
            </td>
        </tr>
<?php if($secPhone != 'NULL') { ?>
        <tr>
            <td>Tél. secondaire</td>
            <td>
                <?php echo $dispSecPhone ?>
            </td>
        </tr>
<?php } ?>
        <tr>
            <td>Adresse</td>
            <td>
                <?php echo $address ?>
            </td>
        </tr>
        <tr>
            <td>Code postal</td>
            <td>
                <?php echo $postalCode ?>
            </td>
        </tr>
        <tr>
            <td>Ville</td>
            <td>
                <?php echo $city ?>
            </td>
        </tr>
    </table>
    <br>
<?php
    } else {
        header("location:adminZone.php");
    }
?>
    <a href="adminZone.php">Accueil admin</a>
    <br>
    <a href="displayUser.php">Afficher les utilisateurs</a>
    <br>
    <a href="utils/logout.php">Déconnection</a>
    <script src="js/tools.js"></script>
</body>
</html>