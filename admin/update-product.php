<?php session_start(); require_once("..\utils\connection.php"); require_once("..\utils\admin-check.php");

    if (isset($_POST['id']) &&
        isset($_POST['ref']) &&
        isset($_POST['name']) &&
        isset($_POST['price']) &&
        isset($_POST['category']) &&
        isset($_POST['sizes'])) {
        $id = $_POST['id'];
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
        $db->exec("UPDATE product SET ref = '$ref', name = '$name', price = '$price', category_id = '$category', description = $description, picture_name = $pictureName, is_available = $isAvailable, is_on_promo = $isOnPromo, reduction_percent = $reductionPercent, promo_price = $promoPrice, is_in_selection = $isInSelection, brand_id = $brand WHERE id='$id'");
        $req = $db->query("SELECT size FROM size s INNER JOIN product_size ps WHERE ps.product_id = '$id' AND s.id = ps.size_id");
        while($productDbSize = $req->fetch(PDO::FETCH_ASSOC)) {
            foreach($_POST['sizes'] as $productNewSize) {
                if($productNewSize = $productDbSize){
                    
                }
            }
        }
        header("location:display-product.php");
    } else {
        header("location:home.php");
    }