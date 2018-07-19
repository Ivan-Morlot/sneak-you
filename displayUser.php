<?php session_start(); require_once("utils\connection.php"); require_once("utils\adminCheck.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Afficher les utilisateurs</title>
</head>
<body>
    <form action="displayUser.php" method="post">
        <label for="research">Recherche par nom :</label>
        <input type="text" name="research">
        <button type="submit">Rechercher</button>
    </form>
    <br>
<?php
    if(isset($_POST['research'])) {
        $search = trim($_POST['research']);
        $req = $db->query("SELECT * FROM customer WHERE nom LIKE '%$search%'");
    } else {
        $req = $db->query("SELECT * FROM customer");
    }
?>
    <table border="1">
        <tr>
            <td>ID</td>
            <td>Civilité</td>
            <td>Prénom</td>
            <td>Nom</td>
            <td>E-mail</td>
            <td>Niveau d'accès au site</td>
            <td>Date de naissance</td>
            <td>Tél. principal</td>
            <td>Tél. secondaire</td>
            <td>Adresse</td>
            <td>Code postal</td>
            <td>Ville</td>
            <td></td>
            <td></td>
        </tr>
<?php while($user = $req->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td>
                <?php echo $user['id'] ?>
            </td>
            <td>
                <?php echo $user['gender'] ?>
            </td>
            <td>
                <?php echo $user['prenom'] ?>
            </td>
            <td>
                <?php echo $user['nom'] ?>
            </td>
            <td>
                <?php echo $user['email'] ?>
            </td>
            <td>
                <?php if($user['auth_level'] == 0) {echo "Utilisateur";} else if($user['auth_level'] == 1) {echo "Administrateur";} else {echo "N/A";} ?>
            </td>
            <td>
                <?php echo $user['birthdate'] ?>
            </td>
            <td>
                <?php echo $user['main_phone_number'] ?>
            </td>
            <td>
                <?php echo $user['secondary_phone_number'] ?>
            </td>
            <td>
                <?php echo $user['delivery_address'] ?>
            </td>
            <td>
                <?php echo $user['del_postal_code'] ?>
            </td>
            <td>
                <?php echo $user['del_city'] ?>
            </td>
            <td><a href="deleteUser.php?id=<?php echo $user['id'] ?>">Supprimer</a></td>
            <td><a href="editUser.php?id=<?php echo $user['id'] ?>">Editer</a></td>
        </tr>
<?php }
    $req->closeCursor();
?>
    </table>
    <br>
    <a href="adminZone.php">Accueil admin</a>
    <br>
    <a href="utils/logout.php">Déconnexion</a>
    <script src="js/tools.js"></script>
</body>
</html>