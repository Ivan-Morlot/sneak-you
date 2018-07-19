<?php session_start(); require_once("utils\connection.php"); require_once("utils\adminCheck.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout d'une marque</title>
</head>
<body>
<?php
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $db->exec("INSERT INTO `brand` (`id`, `name`) VALUES (NULL, '$name')");
?>
    <p>Marque créée avec succès.</p>
    <p>Récapitulatif :</p>
    <table border="1">
        <tr>
            <td>Nom</td>
            <td>
                <?php echo $name ?>
            </td>
        </tr>
    </table>
    <br>
<?php
    } else {
        header("location:adminZone.php");
    }
?>
    <a href="adminZone.php">Accueil admin</a>
    <br>
    <a href="displayBrand.php">Afficher les marques</a>
    <br>
    <a href="utils/logout.php">Déconnection</a>
    <script src="js/tools.js"></script>
</body>
</html>