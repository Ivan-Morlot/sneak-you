<?php session_start(); require_once("..\utils\admin-check.php")?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title>Zone admin</title>
</head>
<body>
    <h1>Zone admin</h1>
    <a href="display-category.php">Afficher les catégories</a>
    <br>
    <a href="create-category.php">Créer une nouvelle catégorie</a>
    <br><br>
    <a href="display-brand.php">Afficher les marques</a>
    <br>
    <a href="create-brand.php">Créer une nouvelle marque</a>
    <br><br>
    <a href="display-user.php">Afficher les utilisateurs</a>
    <br>
    <a href="create-user.php">Créer un nouvel utilisateur</a>
    <br><br>
    <a href="../utils/logout.php">Déconnexion</a>
    <script src="../js/tools.js"></script>
  </body>
</html>