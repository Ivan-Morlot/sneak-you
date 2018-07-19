<?php session_start(); require_once("utils\connection.php"); require_once("utils\adminCheck.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Afficher les marques</title>
</head>
<body>
    <form action="displayBrand.php" method="post">
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
                <?php echo $brd['id'] ?>
            </td>
            <td>
                <?php echo $brd['name'] ?>
            </td>
            <td><a href="deleteBrand.php?id=<?php echo $brd['id'] ?>">Supprimer</a></td>
            <td><a href="editBrand.php?id=<?php echo $brd['id'] ?>">Editer</a></td>
        </tr>
<?php }
    $req->closeCursor();
?>
    </table>
    <br>
    <a href="createBrand.php">Créer une nouvelle marque</a>
    <br><br>
    <a href="adminZone.php">Accueil admin</a>
    <br><br>
    <a href="utils/logout.php">Déconnexion</a>
    <script src="js/tools.js"></script>
</body>
</html>