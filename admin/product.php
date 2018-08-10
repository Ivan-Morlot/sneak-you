<?php
    session_start();

    require_once "../utils/adminCheck.php";    
    
    require_once "../utils/connection.php";
    
    require "models/productModel.php";
    require "models/brandModel.php";
    require "models/sizeModel.php";
    require "models/categoryModel.php";
    
    $createDiv = '';
    
    $displayDiv = '';

    $result = '';

    $createDiv .= '
        <form enctype="multipart/form-data" action="product.php?req=create" method="post">
            <table class="post-table">
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
                    <td>Prix (en €)</td>
                    <td><input type="number" name="price" step="0.01" min="0" required></td>
                </tr>
                <tr>
                    <td>Photo</td>
                    <td><input type="hidden" name="MAX_FILE_SIZE" value="1000000"><input type="file" name="picture"></td>
                </tr>
                <tr>
                    <td>Disponible</td>
                    <td>
                        <input type="radio" name="is-available" id="avb-true" value="1" required>
                        <label for="avb-true">Oui</label>
                        <input type="radio" name="is-available" id="avb-false" value="0" required>
                        <label for="avb-false">Non</label>
                    </td>
                </tr>
                <tr>
                    <td>En promotion</td>
                    <td>
                        <input type="radio" name="is-on-promo" class="prm-switch" id="prm-true" value="1" required>
                        <label for="prm-true">Oui</label>
                        <input type="radio" name="is-on-promo" class="prm-switch" id="prm-false" value="0" required>
                        <label for="prm-false">Non</label>
                    </td>
                </tr>
                <tr>
                    <td>Pourcent de réduction</td>
                    <td><input type="number" name="reduction-percent" class="prm-options" step="1" min="0" max="100" disabled></td>
                </tr>
                <tr>
                    <td>Prix après réduction (en €)</td>
                    <td><input type="number" name="promo-price" class="prm-options" step="0.01" min="0" disabled></td>
                </tr>
                <tr>
                    <td>En sélection</td>
                    <td>
                        <input type="radio" name="is-in-selection" id="sel-true" value="1" required>
                        <label for="sel-true">Oui</label>
                        <input type="radio" name="is-in-selection" id="sel-false" value="0" required>
                        <label for="sel-false">Non</label>
                    </td>
                </tr>
                <tr>
                    <td>Marque</td>
                    <td>
                        <select name="brand">
                            <option selected disabled></option>
    ';
    $req = reqAllBrd($db);
    while($brd = $req->fetch(PDO::FETCH_ASSOC)) {
        $createDiv .= '<option value="'.$brd['id'].'">'.$brd['name'].'</option>';
    }
    $createDiv .= '
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Catégorie</td>
                    <td>
                        <select name="category" required>
                            <option selected disabled></option>
    ';
    $req = reqAllCat($db);
    while($cat = $req->fetch(PDO::FETCH_ASSOC)) {
        $createDiv .= '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
    }
    $createDiv .= '
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Tailles disponibles</td>
                    <td>
                        <select multiple name="sizes[]" required>
    ';
    $req = reqAllSiz($db);
    while($siz = $req->fetch(PDO::FETCH_ASSOC)) {
        $createDiv .= '<option value="'.$siz['id'].'">'.$siz['size'].'</option>';
    }
    $createDiv .= '
                        </select>

                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Enregistrer"></td>
                </tr>
            </table>
        </form>
    ';

    if (isset($_GET['req']) && $_GET['req'] == 'update' &&
        isset($_POST['id']) &&
        isset($_POST['ref']) &&
        isset($_POST['name']) &&
        isset($_POST['price']) &&
        isset($_POST['category']) &&
        isset($_POST['sizes'])) {
        $id = $_POST['id'];
        $ref = $_POST['ref'];
        
        $reqCheckRef = $db->query("SELECT ref FROM product WHERE ref = '$ref' AND id <> '$id'");
        if($tempCheckRef = $reqCheckRef->fetch(PDO::FETCH_ASSOC)) {
            $checkRef = $tempCheckRef['ref'];
        }

        if (!isset($checkRef) || $checkRef === "") {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $sizes = $_POST['sizes'];
            $optional = array();
            if(isset($_POST['description']) && $_POST['description'] != "") {$description = "'".$_POST['description']."'";} else {$description = 'NULL';}
            if(isset($_POST['is-available']) && $_POST['is-available'] != "") {$isAvailable = "'".$_POST['is-available']."'";} else {$isAvailable = 'NULL';}
            if(isset($_POST['is-on-promo']) && $_POST['is-on-promo'] != "") {$isOnPromo = "'".$_POST['is-on-promo']."'";} else {$isOnPromo = 'NULL';}
            if(isset($_POST['reduction-percent']) && $_POST['reduction-percent'] != "") {$reductionPercent = "'".$_POST['reduction-percent']."'";} else {$reductionPercent = 'NULL';}
            if(isset($_POST['promo-price']) && $_POST['promo-price'] != "") {$promoPrice = "'".$_POST['promo-price']."'";} else {$promoPrice = 'NULL';}
            if(isset($_POST['is-in-selection']) && $_POST['is-in-selection'] != "") {$isInSelection = "'".$_POST['is-in-selection']."'";} else {$isInSelection = 'NULL';}
            if(isset($_POST['brand']) && $_POST['brand'] != "") {$brand = "'".$_POST['brand']."'";} else {$brand = 'NULL';}
            if(isset($_FILES['picture']) && $_FILES['picture']['name'] != "") {
                $optional["picture_name"] = "'".$_FILES['picture']['name']."'";
            }
            updatePrd($db, $ref, $name, $description, $price, $isAvailable, $isOnPromo, $reductionPercent, $promoPrice, $isInSelection, $brand, $category, $id, $optional);
            deletePrdAllSizes($db, $id);
            insertPrdSizes($db, $id, $sizes);
            $displayDiv .= '
                <br><h4> Le produit "'.$name.'" a été édité avec succès.</h4>
            ';
        } else {
            $displayDiv .= '
                <br><h4>Edition impossible : référence déjà existante.</h4>
            ';
        }
    }

    if(isset($_GET['req']) && $_GET['req'] == 'delete' && isset($_GET['id'])) {
        $id = $_GET['id'];
        deletePrdAllSizes($db, $id);
        deletePrd($db, $id);
    }

    if (isset($_GET['req']) && $_GET['req'] == 'create' &&
        isset($_POST['ref']) &&
        isset($_POST['name']) &&
        isset($_POST['price']) &&
        isset($_POST['category']) &&
        isset($_POST['sizes'])) {
        $ref = $_POST['ref'];
        
        $reqCheckRef = $db->query("SELECT ref FROM product WHERE ref = '$ref'");
        if($tempCheckRef = $reqCheckRef->fetch(PDO::FETCH_ASSOC)) {
            $checkRef = $tempCheckRef['ref'];
        }

        if (!isset($checkRef) || $checkRef === "") {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $sizes = $_POST['sizes'];
            if(isset($_POST['description']) && $_POST['description'] != "") {$dispDescription = $_POST['description']; $description = "'".$dispDescription."'";} else {$description = 'NULL';}
            if(isset($_FILES['picture']) && $_FILES['picture']['name'] != "") {$dispPictureName = $_FILES['picture']['name']; $pictureName = "'".$dispPictureName."'";} else {$pictureName = 'NULL';}
            if(isset($_POST['is-available']) && $_POST['is-available'] != "") {$dispIsAvailable = $_POST['is-available']; $isAvailable = "'".$dispIsAvailable."'";} else {$isAvailable = 'NULL';}
            if(isset($_POST['is-on-promo']) && $_POST['is-on-promo'] != "") {$dispIsOnPromo = $_POST['is-on-promo']; $isOnPromo = "'".$dispIsOnPromo."'";} else {$isOnPromo = 'NULL';}
            if(isset($_POST['reduction-percent']) && $_POST['reduction-percent'] != "") {$dispReductionPercent = $_POST['reduction-percent']; $reductionPercent = "'".$dispReductionPercent."'";} else {$reductionPercent = 'NULL';}
            if(isset($_POST['promo-price']) && $_POST['promo-price'] != "") {$dispPromoPrice = $_POST['promo-price']; $promoPrice = "'".$dispPromoPrice."'";} else {$promoPrice = 'NULL';}
            if(isset($_POST['is-in-selection']) && $_POST['is-in-selection'] != "") {$dispIsInSelection = $_POST['is-in-selection']; $isInSelection = "'".$dispIsInSelection."'";} else {$isInSelection = 'NULL';}
            if(isset($_POST['brand']) && $_POST['brand'] != "") {$dispBrand = $_POST['brand']; $brand = "'".$dispBrand."'";} else {$brand = 'NULL';}
            insertPrd($db, $ref, $name, $description, $price, $pictureName, $isAvailable, $isOnPromo, $reductionPercent, $promoPrice, $isInSelection, $brand, $category);
            $req = selectPrdByRef($db, $ref);
            if($thisProduct = $req->fetch(PDO::FETCH_ASSOC)) {
                $thisProductId = $thisProduct['id'];
                insertPrdSizes($db, $thisProductId, $sizes);
            }
            $createDiv .= '
                <br><h4>Produit créé avec succès.</h4>
                <p><b>Récapitulatif :</b></p>
                <table class="post-table">
                    <tr>
                        <td>Référence</td>
                        <td>
                            '.$ref.'
                        </td>
                    </tr>
                    <tr>
                        <td>Nom</td>
                        <td>
                            '.$name.'
                        </td>
                    </tr>
            ';
            if($description != 'NULL') {
                $createDiv .= '
                    <tr>
                        <td>Description</td>
                        <td>
                            '.$dispDescription.'
                        </td>
                    </tr>
                ';
            }
            $createDiv .= '
                    <tr>
                        <td>Prix</td>
                        <td>
                            '.$price.'€
                        </td>
                    </tr>
            ';
            if($pictureName != 'NULL') {
                $createDiv .= '
                    <tr>
                        <td>Photo</td>
                        <td>
                            <img src="../img/'.$dispPictureName.'" alt="'.$dispPictureName.'" width="400px">
                        </td>
                    </tr>
                ';
            }
            $createDiv .= '
                    <tr>
                        <td>Disponible</td>
                        <td>
                            '.dispPrdBoolVal($dispIsAvailable).'
                        </td>
                    </tr>
                    <tr>
                        <td>En promotion</td>
                        <td>
                            '.dispPrdBoolVal($dispIsOnPromo).'
                        </td>
                    </tr>
            ';
            if(isset($dispIsOnPromo) && $dispIsOnPromo == '1' && $reductionPercent != 'NULL' && $promoPrice != 'NULL') {
                $createDiv .= '
                    <tr>
                        <td>Pourcent de réduction</td>
                        <td>
                            '.$dispReductionPercent.'%
                        </td>
                    </tr>
                    <tr>
                        <td>Prix après réduction</td>
                        <td>
                            '.$dispPromoPrice.'€
                        </td>
                    </tr>
                ';
            }
            $createDiv .= '
                    <tr>
                        <td>En sélection</td>
                        <td>
                            '.dispPrdBoolVal($dispIsInSelection).'
                        </td>
                    </tr>
            ';
            if($brand != 'NULL') {
                $createDiv .= '
                    <tr>
                        <td>Marque</td>
                        <td>
                ';
                $reqBrd = selectBrdName($db, $brand);
                if($brd = $reqBrd->fetch(PDO::FETCH_ASSOC)) {
                    $createDiv .=
                            $brd['name'].'
                        </td>
                    </tr>
                    ';
                }
            }
            $createDiv .= '
                    <tr>
                        <td>Catégorie</td>
                        <td>
            ';
            $reqCat = selectCatName($db, $category);
            if($cat = $reqCat->fetch(PDO::FETCH_ASSOC))
                $createDiv .= $cat['name'];
            $createDiv .= '
                        </td>
                    </tr>
                    <tr>
                        <td>Tailles disponibles</td>
                        <td>
            ';
            $reqPrdSizes = selectPrdAllSizes($db, $thisProductId);
            while($prdSize = $reqPrdSizes->fetch(PDO::FETCH_ASSOC)) {
                $createDiv .= $prdSize['size'].'<br>';
            }
            $createDiv .= '
                        </td>
                    </tr>
                </table>
            ';
        } else {
            $createDiv .= '
                <br><h4>Création impossible : référence déjà existante.</h4>
            ';
        }
    }

    if(isset($_GET['req']) && $_GET['req'] == 'edit' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $req = selectPrdById($db, $id);

        if($prd = $req->fetch(PDO::FETCH_ASSOC)) {
            $displayDiv .= '
                <table class="display-table">
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
                    <tr>
                        <td>
                            '.$prd['id'].'
                        </td>
                        <td>
                            '.$prd['ref'].'
                        </td>
                        <td>
                            '.$prd['name'].'
                        </td>
                        <td>
                            '.$prd['description'].'
                        </td>
                        <td>
                            '.$prd['price'].'€
                        </td>
                        <td>
                            <img src="../img/'.$prd['picture_name'].'" alt="'.$prd['picture_name'].'" width="400px">
                        </td>
                        <td>
                            '.dispPrdBoolVal($prd['is_available']).'
                        </td>
                        <td>
                            '.dispPrdBoolVal($prd['is_on_promo']).'
                        </td>
                        <td>
            ';
            if ($prd['reduction_percent'] != NULL)
                $displayDiv .= $prd['reduction_percent']."%";
            $displayDiv .= '
                        </td>
                        <td>
            ';
            if ($prd['promo_price'] != NULL)
                $displayDiv .= $prd['promo_price']."€";
            $displayDiv .= '
                        </td>
                        <td>
                            '.dispPrdBoolVal($prd['is_in_selection']).'
                        </td>
                        <td>
            ';
            $brandId = $prd['brand_id'];
            $reqBrd = selectBrdName($db, $brandId);
            if($brd = $reqBrd->fetch(PDO::FETCH_ASSOC)) {
                $displayDiv .= $brd['name'];
            }
            $displayDiv .= '
                        </td>
                        <td>
            ';
            $categoryId = $prd['category_id'];
            $reqCat = selectCatName($db, $categoryId);
            if($cat = $reqCat->fetch(PDO::FETCH_ASSOC)) {
                $displayDiv .= $cat['name'];
            }
            $displayDiv .= '
                        </td>
                        <td>
            ';
            $productId = $prd['id'];
            $reqPrdSizes = selectPrdAllSizes($db, $productId);
            while($prdSize = $reqPrdSizes->fetch(PDO::FETCH_ASSOC)) {
                $displayDiv .= $prdSize['size'].'<br>';
            }
            $displayDiv .= '
                        </td>
                        <div class="modal fade" id="confirm-del-modal-'.$prd['id'].'" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="exampleModalLabel">Supprimer un produit</h4>
                                </div>
                                <div class="modal-body">
                                    Vous êtes sur le point de supprimer le produit "'.$prd['name'].'".
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-primary" href="product.php?req=delete&id='.$prd['id'].'">Supprimer</a>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <td><a href="#" data-toggle="modal" data-target="#confirm-del-modal-'.$prd['id'].'">Supprimer</a></td>
                    </tr>
                </table>
                <br>
                <form action="product.php?req=update&id='.$prd['id'].'" method="post">
                    <table class="post-table">
                        <tr>
                            <td>ID</td>
                            <td><input type="text" name="id" value="'.$id.'" style="background-color: lightgrey" readonly></td>
                        </tr>
                        <tr>
                            <td>Editer la référence</td>
                            <td><input type="text" name="ref" maxlength="10" required value="'.$prd['ref'].'"></td>
                        </tr>
                        <tr>
                            <td>Editer le nom</td>
                            <td><input type="text" name="name" maxlength="100" required value="'.$prd['name'].'"></td>
                        </tr>
                        <tr>
                            <td>Editer la description</td>
                            <td><textarea name="description" maxlength="1000" cols="30" rows="5" style="resize:none">'.$prd['description'].'</textarea></td>
                        </tr>
                        <tr>
                            <td>Editer le prix (en €)</td>
                            <td><input type="number" name="price" step="0.01" min="0" required value="'.$prd['price'].'"></td>
                        </tr>
                        <tr>
                            <td>Changer la photo</td>
                            <td><input type="hidden" name="MAX_FILE_SIZE" value="1000000"><input type="file" name="picture"></td>
                        </tr>
                        <tr>
                            <td>Disponible</td>
                            <td>
                                <input type="radio" name="is-available" id="avb-true" value="1" '.dispPrdBoolCheckbox($prd['is_available'], '1').' required>
                                <label for="avb-true">Oui</label>
                                <input type="radio" name="is-available" id="avb-false" value="0" '.dispPrdBoolCheckbox($prd['is_available'], '0').' required>
                                <label for="avb-false">Non</label>
                            </td>
                        </tr>
                        <tr>
                            <td>En promotion</td>
                            <td>
                                <input type="radio" name="is-on-promo" class="prm-switch" id="prm-true" value="1" '.dispPrdBoolCheckbox($prd['is_on_promo'], '1').' required>
                                <label for="prm-true">Oui</label>
                                <input type="radio" name="is-on-promo" class="prm-switch" id="prm-false" value="0" '.dispPrdBoolCheckbox($prd['is_on_promo'], '0').' required>
                                <label for="prm-false">Non</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Pourcent de réduction</td>
                            <td><input type="number" name="reduction-percent" class="prm-options" step="1" min="0" max="100" disabled value="'.$prd['reduction_percent'].'"></td>
                        </tr>
                        <tr>
                            <td>Prix après réduction (en €)</td>
                            <td><input type="number" name="promo-price" class="prm-options" step="0.01" min="0" disabled value="'.$prd['promo_price'].'"></td>
                        </tr>
                        <tr>
                            <td>En sélection</td>
                            <td>
                                <input type="radio" name="is-in-selection" id="sel-true" value="1" '.dispPrdBoolCheckbox($prd['is_in_selection'], '1').' required>
                                <label for="sel-true">Oui</label>
                                <input type="radio" name="is-in-selection" id="sel-false" value="0" '.dispPrdBoolCheckbox($prd['is_in_selection'], '0').' required>
                                <label for="sel-false">Non</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Changer la marque</td>
                            <td>
                                <select name="brand">
                                    <option '.dispPrdSelectSelected($prd['brand_id'], 'NULL').' disabled></option>
            ';
            $req = reqAllBrd($db);
            while($brd = $req->fetch(PDO::FETCH_ASSOC)) {
                $displayDiv .= '
                                    <option value="'.$brd['id'].'" '.dispPrdSelectSelected($prd['brand_id'], $brd['id']).'>'.$brd['name'].'</option>
                ';
            }
            $displayDiv .= '
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Changer la catégorie</td>
                            <td>
                                <select name="category" required>
                                    <option '.dispPrdSelectSelected($prd['category_id'], 'NULL').' disabled></option>
            ';
            $req = reqAllCat($db);
            while($cat = $req->fetch(PDO::FETCH_ASSOC)) {
                $displayDiv .= '
                                    <option value="'.$cat['id'].'" '.dispPrdSelectSelected($prd['category_id'], $cat['id']).'>'.$cat['name'].'</option>
                ';
            }
            $displayDiv .= '
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Changer les tailles disponibles</td>
                            <td>
                                <select multiple name="sizes[]" required>
            ';
            $req = reqAllSiz($db);
            while($siz = $req->fetch(PDO::FETCH_ASSOC)) {
                $displayDiv .= '
                                    <option value="'.$siz['id'].'">'.$siz['size'].'</option>
                ';
            }
            $displayDiv .= '
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
            ';
        }
    } else {
        if(isset($_POST['research'])) {
            $search = trim($_POST['research']);
            $req = reqSearchPrd($db, $search);
        } else {
            $req = reqAllPrd($db);
        }

        while($prd = $req->fetch(PDO::FETCH_ASSOC)) {
            $result .= '<tr>
                            <td>
                                '.$prd['id'].'
                            </td>
                            <td>
                                '.$prd['ref'].'
                            </td>
                            <td>
                                '.$prd['name'].'
                            </td>
                            <td>
                                '.$prd['description'].'
                            </td>
                            <td>
                                '.$prd['price'].'€
                            </td>
                            <td>
                                <img src="../img/'.$prd['picture_name'].'" alt="'.$prd['picture_name'].'" width="400px">
                            </td>
                            <td>
                                '.dispPrdBoolVal($prd['is_available']).'
                            </td>
                            <td>
                                '.dispPrdBoolVal($prd['is_on_promo']).'
                            </td>
                            <td>
            ';
            if ($prd['reduction_percent'] != NULL) {
                $result .= $prd['reduction_percent']."%";
            }
            $result .= '
                            </td>
                            <td>
            ';
            if ($prd['promo_price'] != NULL) {
                $result .= $prd['promo_price']."€";
            }
            $result .= '
                            </td>
                            <td>
                                '.dispPrdBoolVal($prd['is_in_selection']).'
                            </td>
                            <td>
            ';
            if (isset($prd['brand_id'])) {
                $reqBrd = selectBrdName($db, $prd['brand_id']);
                if($brd = $reqBrd->fetch(PDO::FETCH_ASSOC))
                    $result .= $brd['name'];
            }
            $result .= '
                        </td>
                        <td>
            ';
            $reqCat = selectCatName($db, $prd['category_id']);
            if($cat = $reqCat->fetch(PDO::FETCH_ASSOC))
                $result .= $cat['name'];
            $result .= '
                            </td>
                            <td>
            ';
            $reqPrdSizes = selectPrdAllSizes($db, $prd['id']);
            while($prdSize = $reqPrdSizes->fetch(PDO::FETCH_ASSOC)) {
                $result .= $prdSize['size'].'<br>';
            }
            $result .= '
                            </td>
                            <div class="modal fade" id="confirm-del-modal-'.$prd['id'].'" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title" id="exampleModalLabel">Supprimer un produit</h4>
                                    </div>
                                    <div class="modal-body">
                                        Vous êtes sur le point de supprimer le produit "'.$prd['name'].'".
                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-primary" href="product.php?req=delete&id='.$prd['id'].'">Supprimer</a>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <td><a href="#" data-toggle="modal" data-target="#confirm-del-modal-'.$prd['id'].'">Supprimer</a></td>
                            <td><a href="product.php?id='.$prd['id'].'&req=edit">Editer</a></td>
                        </tr>
            ';
        }
        $req->closeCursor();
        $displayDiv .= '
            <table class="display-table">
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
                '.$result.'
            </table>
        ';
    }

    require("vues/productVue.php");