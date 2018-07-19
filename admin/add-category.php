<?php session_start(); require_once("..\utils\connection.php"); require_once("..\utils\admin-check.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout d'une categorie</title>
</head>
<body>
<?php
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        if(isset($_POST['description']) && $_POST['description'] != "") {$dispDescription = $_POST['description']; $description = "'".$dispDescription."'";} else {$description = 'NULL';}
        $db->exec("INSERT INTO `category` (`id`, `name`, `description`) VALUES (NULL, '$name', $description)");
?>
    <p>Catégorie créée avec succès.</p>
    <p>Récapitulatif :</p>
    <table border="1">
        <tr>
            <td>Nom</td>
            <td>
                <?php echo $name ?>
            </td>
        </tr>
<?php if($description != 'NULL') { ?>
        <tr>
            <td>Description</td>
            <td>
                <?php echo $dispDescription ?>
            </td>
        </tr>
<?php } ?>
    </table>
    <br>
<?php
    } else {
        header("location:home.php");
    }
?>
    <a href="home.php">Accueil admin</a>
    <br>
    <a href="display-category.php">Afficher les catégories</a>
    <br>
    <a href="../utils/logout.php">Déconnection</a>
    <script src="../js/tools.js"></script>
</body>
</html>