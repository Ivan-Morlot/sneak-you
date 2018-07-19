<?php session_start(); require_once("utils\adminCheck.php")?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une catégorie</title>
</head>
<body>
    <form enctype="multipart/form-data" action="addCategory.php" method="post">
        <table border="1">
            <tr>
                <td>Nom</td>
                <td><input type="text" name="name" maxlength="30" required></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><textarea name="description" maxlength="1000" cols="30" rows="5" style="resize:none"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Enregistrer"></td>
            </tr>
        </table>
    </form>
    <br>
    <a href="displayCategory.php">Afficher les catégories</a>
    <br><br>
    <a href="adminZone.php">Accueil admin</a>
    <br><br>
    <a href="utils/logout.php">Déconnexion</a>
    <script src="js/tools.js"></script>
</body>
</html>