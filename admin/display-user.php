<?php session_start(); require_once("..\utils\connection.php"); require_once("..\utils\admin-check.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Afficher les utilisateurs</title>
</head>
<body>
    <form action="display-user.php" method="post">
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
            <td>Complément d'adresse</td>
            <td>Bâtiment</td>
            <td>Escalier</td>
            <td>Etage</td>
            <td>Porte</td>
            <td></td>
            <td></td>
        </tr>
<?php while($user = $req->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td>
                <?= $user['id'] ?>
            </td>
            <td>
                <?= $user['gender'] ?>
            </td>
            <td>
                <?= $user['prenom'] ?>
            </td>
            <td>
                <?= $user['nom'] ?>
            </td>
            <td>
                <?= $user['email'] ?>
            </td>
            <td>
                <?php if($user['auth_level'] == '0') {echo "Utilisateur";} else if($user['auth_level'] == '1') {echo "Administrateur";} else {echo "N/A";} ?>
            </td>
            <td>
                <?= $user['birthdate'] ?>
            </td>
            <td>
                <?= $user['main_phone_number'] ?>
            </td>
            <td>
                <?= $user['secondary_phone_number'] ?>
            </td>
            <td>
                <?= $user['delivery_address'] ?>
            </td>
            <td>
                <?= $user['del_postal_code'] ?>
            </td>
            <td>
                <?= $user['del_city'] ?>
            </td>
            <td>
                <?= $user['del_address_supp'] ?>
            </td>
            <td>
                <?= $user['del_building'] ?>
            </td>
            <td>
                <?= $user['del_staircase'] ?>
            </td>
            <td>
                <?= $user['del_floor'] ?>
            </td>
            <td>
                <?= $user['del_door'] ?>
            </td>
            <td><a href="delete-user.php?id=<?= $user['id'] ?>">Supprimer</a></td>
            <td><a href="edit-user.php?id=<?= $user['id'] ?>">Editer</a></td>
        </tr>
<?php }
    $req->closeCursor();
?>
    </table>
    <br>
    <a href="create-user.php">Créer un nouvel utilisateur</a>
    <br><br>
    <a href="home.php">Accueil admin</a>
    <br><br>
    <a href="../utils/logout.php">Déconnexion</a>
    <script src="../js/tools.js"></script>
</body>
</html>