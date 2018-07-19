<?php session_start(); require_once("utils\connection.php"); require_once("utils\adminCheck.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Editer marque</title>
</head>
<body>
<?php
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $req = $db->query("SELECT * FROM brand WHERE (id = $id)");
    }
?>
    <table border="1">
        <tr>
            <td>ID</td>
            <td>Nom</td>
            <td></td>
        </tr>
<?php if($brd = $req->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td>
                <?php echo $brd['id'] ?>
            </td>
            <td>
                <?php echo $brd['name'] ?>
            </td>
            <td><a href="deleteBrand.php?id=<?php echo $brd['id'] ?>">Supprimer</a></td>
        </tr>
<?php } ?>
    </table>
    <br>
    <form action="updateBrand.php" method="post">
        <table border="1">
            <tr>
                <td>ID</td>
                <td><input type="text" name="id" value="<?php echo $id ?>" style="background-color: lightgrey" readonly></td>
            </tr>
            <tr>
                <td>Editer le nom</td>
                <td><input type="text" name="name" maxlength="30" value="<?php echo $brd['name'] ?>" required></td>
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
    <a href="displayBrand.php">Afficher les marques</a>
    <br><br>
    <a href="adminZone.php">Accueil admin</a>
    <br><br>
    <a href="utils/logout.php">Déconnection</a>
    <script src="js/tools.js"></script>
</body>
</html>