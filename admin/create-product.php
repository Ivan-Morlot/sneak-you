<?php session_start(); require_once("..\utils\connection.php"); require_once("..\utils\admin-check.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un produit</title>
</head>
<body>
    <form enctype="multipart/form-data" action="add-product.php" method="post">
        <table border="1">
            <tr>
                <td>Référence</td>
                <td><input type="text" name="ref" maxlength="10" required></td>
            </tr>
            <tr>
                <td>Nom</td>
                <td><input type="text" name="name" maxlength="100" required></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><textarea name="description" maxlength="1000" cols="30" rows="5" style="resize:none"></textarea></td>
            </tr>
            <tr>
                <td>Prix</td>
                <td><input type="number" name="price" step="0.01" min="0" required></td>
            </tr>
            <tr>
                <td>Photo</td>
                <td><input type="hidden" name="MAX_FILE_SIZE" value="1000000"><input type="file" name="picture"></td>
            </tr>
            <tr>
                <td>Disponible</td>
                <td>
                    <input type="radio" name="is-available" id="avb-true" value="1">
                    <label for="avb-true">Oui</label>
                    <input type="radio" name="is-available" id="avb-false" value="0">
                    <label for="avb-false">Non</label>
                </td>
            </tr>
            <tr>
                <td>En promotion</td>
                <td>
                    <input type="radio" name="is-on-promo" class="prm-switch" id="prm-true" value="1">
                    <label for="prm-true">Oui</label>
                    <input type="radio" name="is-on-promo" class="prm-switch" id="prm-false" value="0">
                    <label for="prm-false">Non</label>
                </td>
            </tr>
            <tr>
                <td>Pourcent de réduction</td>
                <td><input type="number" name="reduction-percent" class="prm-options" step="1" min="0" max="100" disabled></td>
            </tr>
            <tr>
                <td>Prix après réduction</td>
                <td><input type="number" name="promo-price" class="prm-options" step="0.01" min="0" disabled></td>
            </tr>
            <tr>
                <td>En sélection</td>
                <td>
                    <input type="radio" name="is-in-selection" id="sel-true" value="1">
                    <label for="sel-true">Oui</label>
                    <input type="radio" name="is-in-selection" id="sel-false" value="0">
                    <label for="sel-false">Non</label>
                </td>
            </tr>
            <tr>
                <td>Marque</td>
                <td>
                    <select name="brand">
                        <option selected disabled></option>
<?php
    $req = $db->query("SELECT * FROM brand");
    while($brd = $req->fetch(PDO::FETCH_ASSOC)) {
?>
                        <option value="<?php echo $brd['id'] ?>"><?php echo $brd['name'] ?></option>
<?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Catégorie</td>
                <td>
                    <select name="category" required>
                        <option selected disabled></option>
<?php
    $req = $db->query("SELECT * FROM category");
    while($cat = $req->fetch(PDO::FETCH_ASSOC)) {
?>
                        <option value="<?php echo $cat['id'] ?>"><?php echo $cat['name'] ?></option>
<?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Tailles disponibles</td>
                <td>
                    <select multiple name="sizes[]" required>
                        <option selected disabled></option>
<?php
    $req = $db->query("SELECT * FROM size");
    while($siz = $req->fetch(PDO::FETCH_ASSOC)) {
?>
                        <option value="<?php echo $siz['id'] ?>"><?php echo $siz['size'] ?></option>
<?php } ?>
                    </select>

                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Enregistrer"></td>
            </tr>
        </table>
    </form>
    <br>
    <a href="display-product.php">Afficher les produits</a>
    <br><br>
    <a href="home.php">Accueil admin</a>
    <br><br>
    <a href="../utils/logout.php">Déconnexion</a>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/tools.js"></script>
</body>
</html>