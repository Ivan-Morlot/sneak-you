<?php session_start(); require_once("utils\adminCheck.php")?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Zone admin</title>
</head>
<body>
    <h1>Zone admin</h1>
    <a href="displayCategory.php">Afficher les catégories</a>
    <br>
    <a href="createCategory.php">Créer une nouvelle catégorie</a>
    <br><br>
    <a href="displayBrand.php">Afficher les marques</a>
    <br>
    <a href="createBrand.php">Créer une nouvelle marque</a>
    <br><br>
    <a href="displayUser.php">Afficher les utilisateurs</a>
    <br>
    <a href="createUser.php">Créer un nouvel utilisateur</a>
    <br><br>
    <a href="utils/logout.php">Déconnexion</a>
    <script src="js/tools.js"></script>
  </body>
</html>