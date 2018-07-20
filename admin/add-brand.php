<?php session_start(); require_once("..\utils\connection.php"); require_once("..\utils\admin-check.php"); ?>

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
        header("location:home.php");
    }
?>
    <br>
    <a href="display-brand.php">Afficher les marques</a>
    <br>
    <a href="create-brand.php">Créer une autre marque</a>
    <br><br>
    <a href="home.php">Accueil admin</a>
    <br><br>
    <a href="../utils/logout.php">Déconnection</a>
    <script src="../js/tools.js"></script>
</body>
</html>