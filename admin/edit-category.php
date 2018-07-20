<?php session_start(); require_once("..\utils\connection.php"); require_once("..\utils\admin-check.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Editer catégorie</title>
</head>
<body>
<?php
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $req = $db->query("SELECT * FROM category WHERE id = '$id'");
    }
?>
    <table border="1">
        <tr>
            <td>ID</td>
            <td>Nom</td>
            <td>Description</td>
            <td></td>
        </tr>
<?php if($cat = $req->fetch(PDO::FETCH_ASSOC)) { ?>
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
            <td><a href="delete-category.php?id=<?php echo $cat['id'] ?>">Supprimer</a></td>
        </tr>
<?php } ?>
    </table>
    <br>
    <form action="update-category.php" method="post">
        <table border="1">
            <tr>
                <td>ID</td>
                <td><input type="text" name="id" value="<?php echo $id ?>" style="background-color: lightgrey" readonly></td>
            </tr>
            <tr>
                <td>Editer le nom</td>
                <td><input type="text" name="name" maxlength="30" value="<?php echo $cat['name'] ?>" required></td>
            </tr>
            <tr>
                <td>Editer la description</td>
                <td><textarea name="description" maxlength="1000" cols="30" rows="5" style="resize:none"><?php echo $cat['description'] ?></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit">Valider</button></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="reset">Annuler</button></td>
            </tr>
        </table>
    </form>
    <br>
    <a href="display-category.php">Afficher les catégories</a>
    <br><br>
    <a href="home.php">Accueil admin</a>
    <br><br>
    <a href="../utils/logout.php">Déconnection</a>
    <script src="../js/tools.js"></script>
</body>
</html>