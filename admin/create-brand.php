<?php session_start(); require_once("..\utils\admin-check.php")?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une marque</title>
</head>
<body>
    <form enctype="multipart/form-data" action="add-brand.php" method="post">
        <table border="1">
            <tr>
                <td>Nom</td>
                <td><input type="text" name="name" maxlength="30" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Enregistrer"></td>
            </tr>
        </table>
    </form>
    <br>
    <a href="display-brand.php">Afficher les marques</a>
    <br><br>
    <a href="home.php">Accueil admin</a>
    <br><br>
    <a href="../utils/logout.php">Déconnexion</a>
    <script src="../js/tools.js"></script>
</body>
</html>