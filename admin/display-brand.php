<?php session_start(); require_once("..\utils\connection.php"); require_once("..\utils\admin-check.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Afficher les marques</title>
</head>
<body>
    <form action="display-brand.php" method="post">
        <label for="research">Recherche par nom :</label>
        <input type="text" name="research">
        <button type="submit">Rechercher</button>
    </form>
    <br>
<?php
    if(isset($_POST['research'])) {
        $search = trim($_POST['research']);
        $req = $db->query("SELECT * FROM brand WHERE name LIKE '%$search%'");
    } else {
        $req = $db->query("SELECT * FROM brand");
    }
?>
    <table border="1">
        <tr>
            <td>ID</td>
            <td>Nom</td>
            <td></td>
            <td></td>
        </tr>
<?php while($brd = $req->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td>
                <?= $brd['id'] ?>
            </td>
            <td>
                <?= $brd['name'] ?>
            </td>
            <td><a href="delete-brand.php?id=<?= $brd['id'] ?>">Supprimer</a></td>
            <td><a href="edit-brand.php?id=<?= $brd['id'] ?>">Editer</a></td>
        </tr>
<?php }
    $req->closeCursor();
?>
    </table>
    <br>
    <a href="create-brand.php">Créer une nouvelle marque</a>
    <br><br>
    <a href="home.php">Accueil admin</a>
    <br><br>
    <a href="../utils/logout.php">Déconnexion</a>
    <script src="../js/tools.js"></script>
</body>
</html>