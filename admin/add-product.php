<?php session_start(); require_once("..\utils\connection.php"); require_once("..\utils\admin-check.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout d'un produit</title>
</head>
<body>
<?php
    $uploaddir = "../img/";
    $uploadfile = $uploaddir.basename($_FILES['picture']['name']);
    if(move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile)) {
        echo "<p>L'image a été téléchargée avec succès.</p>";
    } else {
        echo "<p>Le téléchargement de l'image est impossible. Attaque potentielle par téléchargement de fichier ou fichier trop lourd.</p>";
    }

    if (isset($_POST['ref']) &&
        isset($_POST['name']) &&
        isset($_POST['price']) &&
        isset($_POST['category']) &&
        isset($_POST['sizes'])) {
        $ref = $_POST['ref'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        if(isset($_POST['description']) && $_POST['description'] != "") {$dispDescription = $_POST['description']; $description = "'".$dispDescription."'";} else {$description = 'NULL';}
        if(isset($_FILES['picture']) && $_FILES['picture']['name'] != "") {$dispPictureName = $_FILES['picture']['name']; $pictureName = "'".$dispPictureName."'";} else {$pictureName = 'NULL';}
        if(isset($_POST['is-available']) && $_POST['is-available'] != "") {$dispIsAvailable = $_POST['is-available']; $isAvailable = "'".$dispIsAvailable."'";} else {$isAvailable = 'NULL';}
        if(isset($_POST['is-on-promo']) && $_POST['is-on-promo'] != "") {$dispIsOnPromo = $_POST['is-on-promo']; $isOnPromo = "'".$dispIsOnPromo."'";} else {$isOnPromo = 'NULL';}
        if(isset($_POST['reduction-percent']) && $_POST['reduction-percent'] != "") {$dispReductionPercent = $_POST['reduction-percent']; $reductionPercent = "'".$dispReductionPercent."'";} else {$reductionPercent = 'NULL';}
        if(isset($_POST['promo-price']) && $_POST['promo-price'] != "") {$dispPromoPrice = $_POST['promo-price']; $promoPrice = "'".$dispPromoPrice."'";} else {$promoPrice = 'NULL';}
        if(isset($_POST['is-in-selection']) && $_POST['is-in-selection'] != "") {$dispIsInSelection = $_POST['is-in-selection']; $isInSelection = "'".$dispIsInSelection."'";} else {$isInSelection = 'NULL';}
        if(isset($_POST['brand']) && $_POST['brand'] != "") {$dispBrand = $_POST['brand']; $brand = "'".$dispBrand."'";} else {$brand = 'NULL';}
        $db->exec("INSERT INTO `product` (`id`, `ref`, `name`, `description`, `price`, `picture_name`, `is_available`, `is_on_promo`, `reduction_percent`, `promo_price`, `is_in_selection`, `brand_id`, `category_id`) VALUES (NULL, '$ref', '$name', $description, '$price', $pictureName, $isAvailable, $isOnPromo, $reductionPercent, $promoPrice, $isInSelection, $brand, '$category')");
        $req = $db->query("SELECT * FROM product WHERE ref = '$ref'");
        if($thisProduct = $req->fetch(PDO::FETCH_ASSOC)) {
            $thisProductId = $thisProduct['id'];
            $result = "";
            foreach($_POST['sizes'] as $productAvailableSize) {
                $result .= "INSERT INTO `product_size` (`id`, `stock`, `product_id`, `size_id`) VALUES (NULL, NULL, '$thisProductId', '$productAvailableSize'); ";
            }
            $db->exec("$result");
            echo '<p>Les tailles disponibles pour ce produit ont été associées avec succès.</p>';
        } else {
            echo '<p>Erreur lors de l\'association des tailles.</p>';
        }
?>
    <p>Produit créé avec succès.</p>
    <p>Récapitulatif :</p>
    <table border="1">
        <tr>
            <td>Référence</td>
            <td>
                <?php echo $ref ?>
            </td>
        </tr>
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
        <tr>
            <td>Prix</td>
            <td>
                <?php echo $price ?>
            </td>
        </tr>
<?php if($pictureName != 'NULL') { ?>
        <tr>
            <td>Photo</td>
            <td>
                <img src="../img/<?php echo $dispPictureName ?>" alt="<?php echo $dispPictureName ?>" width="400px">
            </td>
        </tr>
<?php } ?>
        <tr>
            <td>Disponible</td>
            <td>
                <?php if(isset($dispIsAvailable) && $dispIsAvailable == 0) {echo "Non";} else if(isset($dispIsAvailable) && $dispIsAvailable == 1) {echo "Oui";} else {echo "N/A";} ?>
            </td>
        </tr>
        <tr>
            <td>En promotion</td>
            <td>
                <?php if(isset($dispIsOnPromo) && $dispIsOnPromo == 0) {echo "Non";} else if(isset($dispIsOnPromo) && $dispIsOnPromo == 1) {echo "Oui";} else {echo "N/A";} ?>
            </td>
        </tr>
<?php if(isset($dispIsOnPromo) && $dispIsOnPromo == 1 && $reductionPercent != 'NULL' && $promoPrice != 'NULL') { ?>
        <tr>
            <td>Pourcent de réduction</td>
            <td>
                <?php echo $dispReductionPercent ?>
            </td>
        </tr>
        <tr>
            <td>Prix après réduction</td>
            <td>
                <?php echo $dispPromoPrice ?>
            </td>
        </tr>
<?php } ?>
        <tr>
            <td>En sélection</td>
            <td>
                <?php if(isset($dispIsInSelection) && $dispIsInSelection == 0) {echo "Non";} else if(isset($dispIsInSelection) && $dispIsInSelection == 1) {echo "Oui";} else {echo "N/A";} ?>
            </td>
        </tr>
<?php if($brand != 'NULL') { ?>
        <tr>
            <td>Marque</td>
            <td>
<?php
    $req = $db->query("SELECT * FROM brand WHERE id = $brand");
    if($brd = $req->fetch(PDO::FETCH_ASSOC)) {
        echo $brd['name'];
    }
?>
            </td>
        </tr>
<?php } ?>
        <tr>
            <td>Catégorie</td>
            <td>
<?php
    $req = $db->query("SELECT * FROM category WHERE id = '$category'");
    if($cat = $req->fetch(PDO::FETCH_ASSOC)) {
        echo $cat['name'];
    }
?>
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
    <a href="display-product.php">Afficher les produits</a>
    <br>
    <a href="create-product.php">Créer un autre produit</a>
    <br><br>
    <a href="home.php">Accueil admin</a>
    <br><br>
    <a href="../utils/logout.php">Déconnection</a>
    <script src="../js/tools.js"></script>
</body>
</html>