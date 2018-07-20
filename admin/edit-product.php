<?php session_start(); require_once("..\utils\connection.php"); require_once("..\utils\admin-check.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Editer produit</title>
</head>
<body>
<?php
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $req = $db->query("SELECT * FROM product WHERE id = '$id'");
    }
?>
    <table border="1">
        <tr>
            <td>ID</td>
            <td>Référence</td>
            <td>Nom</td>
            <td>Description</td>
            <td>Prix</td>
            <td>Photo</td>
            <td>Disponible</td>
            <td>En promotion</td>
            <td>Pourcent de réduction</td>
            <td>Prix après réduction</td>
            <td>En sélection</td>
            <td>Marque</td>
            <td>Catégorie</td>
            <td>Tailles disponibles</td>
            <td></td>
            <td></td>
        </tr>
<?php if($prd = $req->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td>
                <?php echo $prd['id'] ?>
            </td>
            <td>
                <?php echo $prd['ref'] ?>
            </td>
            <td>
                <?php echo $prd['name'] ?>
            </td>
            <td>
                <?php echo $prd['description'] ?>
            </td>
            <td>
                <?php echo $prd['price'] ?>
            </td>
            <td>
                <img src="../img/<?php echo $prd['picture_name'] ?>" alt="<?php echo $prd['picture_name'] ?>" width="400px">
            </td>
            <td>
                <?php if(isset($prd['is_available']) && $prd['is_available'] == 0) {echo "Non";} else if(isset($prd['is_available']) && $prd['is_available'] == 1) {echo "Oui";} else {echo "N/A";} ?>
            </td>
            <td>
                <?php if(isset($prd['is_on_promo']) && $prd['is_on_promo'] == 0) {echo "Non";} else if(isset($prd['is_on_promo']) && $prd['is_on_promo'] == 1) {echo "Oui";} else {echo "N/A";} ?>
            </td>
            <td>
                <?php echo $prd['reduction_percent'] ?>
            </td>
            <td>
                <?php echo $prd['promo_price'] ?>
            </td>
            <td>
                <?php if(isset($prd['is_in_selection']) && $prd['is_in_selection'] == 0) {echo "Non";} else if(isset($prd['is_in_selection']) && $prd['is_in_selection'] == 1) {echo "Oui";} else {echo "N/A";} ?>
            </td>
            <td>
<?php
    $brandId = $prd['brand_id'];
    $reqBrd = $db->query("SELECT * FROM brand WHERE id = '$brandId'");
    if($brd = $reqBrd->fetch(PDO::FETCH_ASSOC)) {
        echo $brd['name'];
    }
?>
            </td>
            <td>
<?php
    $categoryId = $prd['category_id'];
    $reqCat = $db->query("SELECT * FROM category WHERE id = '$categoryId'");
    if($cat = $reqCat->fetch(PDO::FETCH_ASSOC)) {
        echo $cat['name'];
    }
?>
            </td>
            <td>
<?php
    $productId = $prd['id'];
    $reqPrdSizes = $db->query("SELECT * FROM size s INNER JOIN product_size ps WHERE ps.product_id = '$productId' AND s.id = ps.size_id");
    while($prdSize = $reqPrdSizes->fetch(PDO::FETCH_ASSOC)) {
        echo $prdSize['size'].'<br>';
    }
?>
            </td>
            <td><a href="delete-product.php?id=<?php echo $prd['id'] ?>">Supprimer</a></td>
        </tr>
<?php }
    $req->closeCursor();
?>
    </table>
    <br>
    <form action="update-product.php" method="post">
        <table border="1">
            <tr>
                <td>ID</td>
                <td><input type="text" name="id" value="<?php echo $id ?>" style="background-color: lightgrey" readonly></td>
            </tr>
            <tr>
                <td>Editer le nom</td>
                <td><input type="text" name="name" maxlength="100" size="100" value="<?php echo $prd['name'] ?>" required></td>
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
    <a href="display-product.php">Afficher les produits</a>
    <br><br>
    <a href="home.php">Accueil admin</a>
    <br><br>
    <a href="../utils/logout.php">Déconnection</a>
    <script src="../js/tools.js"></script>
</body>
</html>