<?php session_start(); require_once("utils\connection.php"); require_once("utils\adminCheck.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Afficher les catégories</title>
</head>
<body>
    <form action="displayCategory.php" method="post">
        <label for="research">Recherche par nom :</label>
        <input type="text" name="research">
        <button type="submit">Rechercher</button>
    </form>
    <br>
<?php
    if(isset($_POST['research'])) {
        $search = trim($_POST['research']);
        $req = $db->query("SELECT * FROM category WHERE name LIKE '%$search%'");
    } else {
        $req = $db->query("SELECT * FROM category");
    }
?>
    <table border="1">
        <tr>
            <td>ID</td>
            <td>Nom</td>
            <td>Description</td>
            <td></td>
            <td></td>
        </tr>
<?php while($cat = $req->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td>
                <?php echo $cat['id'] ?>
            </td>
            <td>
                <?php echo $cat['name'] ?>
            </td>
            <td>
                <?php echo $cat['description'] ?>
            </td>
            <td><a href="deleteCategory.php?id=<?php echo $cat['id'] ?>">Supprimer</a></td>
            <td><a href="editCategory.php?id=<?php echo $cat['id'] ?>">Editer</a></td>
        </tr>
<?php }
    $req->closeCursor();
?>
    </table>
    <br>
    <a href="createCategory.php">Créer une nouvelle catégorie</a>
    <br><br>
    <a href="adminZone.php">Accueil admin</a>
    <br><br>
    <a href="utils/logout.php">Déconnexion</a>
    <script src="js/tools.js"></script>
</body>
</html>