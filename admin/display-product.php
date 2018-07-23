<?php session_start(); require_once("..\utils\connection.php"); require_once("..\utils\admin-check.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Afficher les produits</title>
</head>
<body>
    <form action="display-product.php" method="post">
        <label for="research">Recherche par nom :</label>
        <input type="text" name="research">
        <button type="submit">Rechercher</button>
    </form>
    <br>
<?php
    if(isset($_POST['research'])) {
        $search = trim($_POST['research']);
        $req = $db->query("SELECT * FROM product WHERE name LIKE '%$search%'");
    } else {
        $req = $db->query("SELECT * FROM product");
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
<?php while($prd = $req->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td>
                <?= $prd['id'] ?>
            </td>
            <td>
                <?= $prd['ref'] ?>
            </td>
            <td>
                <?= $prd['name'] ?>
            </td>
            <td>
                <?= $prd['description'] ?>
            </td>
            <td>
                <?= $prd['price'] ?>€
            </td>
            <td>
                <img src="../img/<?= $prd['picture_name'] ?>" alt="<?= $prd['picture_name'] ?>" width="400px">
            </td>
            <td>
                <?php if(isset($prd['is_available']) && $prd['is_available'] == '0') {echo "Non";} else if(isset($prd['is_available']) && $prd['is_available'] == '1') {echo "Oui";} else {echo "N/A";} ?>
            </td>
            <td>
                <?php if(isset($prd['is_on_promo']) && $prd['is_on_promo'] == '0') {echo "Non";} else if(isset($prd['is_on_promo']) && $prd['is_on_promo'] == '1') {echo "Oui";} else {echo "N/A";} ?>
            </td>
            <td>
<?php
    if ($prd['reduction_percent'] != NULL) {
        echo $prd['reduction_percent']."%";
    }
?>
            </td>
            <td>
<?php
    if ($prd['promo_price'] != NULL) {
        echo $prd['promo_price']."€";
    }
?>
            </td>
            <td>
                <?php if(isset($prd['is_in_selection']) && $prd['is_in_selection'] == '0') {echo "Non";} else if(isset($prd['is_in_selection']) && $prd['is_in_selection'] == '1') {echo "Oui";} else {echo "N/A";} ?>
            </td>
            <td>
<?php
    $brandId = $prd['brand_id'];
    $reqBrd = $db->query("SELECT name FROM brand WHERE id = '$brandId'");
    if($brd = $reqBrd->fetch(PDO::FETCH_ASSOC)) {
        echo $brd['name'];
    }
?>
            </td>
            <td>
<?php
    $categoryId = $prd['category_id'];
    $reqCat = $db->query("SELECT name FROM category WHERE id = '$categoryId'");
    if($cat = $reqCat->fetch(PDO::FETCH_ASSOC)) {
        echo $cat['name'];
    }
?>
            </td>
            <td>
<?php
    $productId = $prd['id'];
    $reqPrdSizes = $db->query("SELECT size FROM size s INNER JOIN product_size ps WHERE ps.product_id = '$productId' AND s.id = ps.size_id");
    while($prdSize = $reqPrdSizes->fetch(PDO::FETCH_ASSOC)) {
        echo $prdSize['size'].'<br>';
    }
?>
            </td>
            <td><a href="delete-product.php?id=<?= $prd['id'] ?>">Supprimer</a></td>
            <td><a href="edit-product.php?id=<?= $prd['id'] ?>">Editer</a></td>
        </tr>
<?php }
    $req->closeCursor();
?>
    </table>
    <br>
    <a href="create-product.php">Créer un nouveau produit</a>
    <br><br>
    <a href="home.php">Accueil admin</a>
    <br><br>
    <a href="../utils/logout.php">Déconnexion</a>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/tools.js"></script>
</body>
</html>