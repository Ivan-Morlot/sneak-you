<?php session_start(); require_once("utils\adminCheck.php")?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Zone admin</title>
</head>
<body>
    <h1>Zone admin</h1>
    <a href="createUser.php">Créer un nouvel utilisateur</a>
    <br>
    <a href="displayUser.php">Afficher les utilisateurs</a>
    <br>
    <a href="utils/logout.php">Déconnexion</a>
    <script src="js/tools.js"></script>
</body>
</html>