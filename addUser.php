<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajout d'utilisateur</title>
</head>
<body>
    <form enctype="multipart/form-data" action="ajouterEtudiant.php" method="post">
        <table border="1">
            <tr>
                <td>Nom</td>
                <td><input type="text" name="nom"></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="text" name="email"></td>
            </tr>
            <tr>
                <td>Photo</td>
                <td><input type="file" name="photo"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Enregistrer"></td>
            </tr>
        </table>
    </form>
    <a href="afficherEtudiant.php">Afficher les étudiants</a>
    <a href="index.html">Déconnection</a>
</body>
</html>