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
        </tr>
<?php if($prd = $req->fetch(PDO::FETCH_ASSOC)) { ?>
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
        </tr>
<?php }
    $req->closeCursor();
?>
    </table>
    <br>
    <form enctype="multipart/form-data" action="update-product.php" method="post">
        <table border="1">
            <tr>
                <td>ID</td>
                <td><input type="text" name="id" value="<?= $id ?>" style="background-color: lightgrey" readonly></td>
            </tr>
            <tr>
                <td>Editer la référence</td>
                <td><input type="text" name="ref" maxlength="10" required value="<?= $prd['ref'] ?>"></td>
            </tr>
            <tr>
                <td>Editer le nom</td>
                <td><input type="text" name="name" maxlength="100" required value="<?= $prd['name'] ?>"></td>
            </tr>
            <tr>
                <td>Editer la description</td>
                <td><textarea name="description" maxlength="1000" cols="30" rows="5" style="resize:none"><?= $prd['description'] ?></textarea></td>
            </tr>
            <tr>
                <td>Editer le prix (en €)</td>
                <td><input type="number" name="price" step="0.01" min="0" required value="<?= $prd['price'] ?>"></td>
            </tr>
            <tr>
                <td>Changer la photo</td>
                <td><input type="hidden" name="MAX_FILE_SIZE" value="1000000"><input type="file" name="picture"></td>
            </tr>
            <tr>
                <td>Disponible</td>
                <td>
                    <input type="radio" name="is-available" id="avb-true" value="1" <?php if($prd['is_available'] == '1') echo 'checked' ?>>
                    <label for="avb-true">Oui</label>
                    <input type="radio" name="is-available" id="avb-false" value="0" <?php if($prd['is_available'] == '0') echo 'checked' ?>>
                    <label for="avb-false">Non</label>
                </td>
            </tr>
            <tr>
                <td>En promotion</td>
                <td>
                    <input type="radio" name="is-on-promo" class="prm-switch" id="prm-true" value="1" <?php if($prd['is_on_promo'] == '1') echo 'checked' ?>>
                    <label for="prm-true">Oui</label>
                    <input type="radio" name="is-on-promo" class="prm-switch" id="prm-false" value="0" <?php if($prd['is_on_promo'] == '0') echo 'checked' ?>>
                    <label for="prm-false">Non</label>
                </td>
            </tr>
            <tr>
                <td>Pourcent de réduction</td>
                <td><input type="number" name="reduction-percent" class="prm-options" step="1" min="0" max="100" disabled value="<?= $prd['reduction_percent'] ?>"></td>
            </tr>
            <tr>
                <td>Prix après réduction (en €)</td>
                <td><input type="number" name="promo-price" class="prm-options" step="0.01" min="0" disabled value="<?= $prd['promo_price'] ?>"></td>
            </tr>
            <tr>
                <td>En sélection</td>
                <td>
                    <input type="radio" name="is-in-selection" id="sel-true" value="1" <?php if($prd['is_in_selection'] == '1') echo 'checked' ?>>
                    <label for="sel-true">Oui</label>
                    <input type="radio" name="is-in-selection" id="sel-false" value="0" <?php if($prd['is_in_selection'] == '0') echo 'checked' ?>>
                    <label for="sel-false">Non</label>
                </td>
            </tr>
            <tr>
                <td>Changer la marque</td>
                <td>
                    <select name="brand">
                        <option <?php if($prd['brand_id'] == 'NULL') echo 'selected' ?> disabled></option>
<?php
    $req = $db->query("SELECT * FROM brand");
    while($brd = $req->fetch(PDO::FETCH_ASSOC)) {
?>
                        <option value="<?= $brd['id'] ?>" <?php if($prd['brand_id'] == $brd['id']) echo 'selected' ?>><?= $brd['name'] ?></option>
<?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Changer la catégorie</td>
                <td>
                    <select name="category" required>
                        <option <?php if($prd['category_id'] == 'NULL') echo 'selected' ?> disabled></option>
<?php
    $req = $db->query("SELECT * FROM category");
    while($cat = $req->fetch(PDO::FETCH_ASSOC)) {
?>
                        <option value="<?= $cat['id'] ?>" <?php if($prd['category_id'] == $cat['id']) echo 'selected' ?>><?= $cat['name'] ?></option>
<?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Changer les tailles disponibles</td>
                <td>
                    <select multiple name="sizes[]" required>
<?php
    $req = $db->query("SELECT * FROM size");
    while($siz = $req->fetch(PDO::FETCH_ASSOC)) {
?>
                        <option value="<?= $siz['id'] ?>"><?= $siz['size'] ?></option>
<?php } ?>
                    </select>

                </td>
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