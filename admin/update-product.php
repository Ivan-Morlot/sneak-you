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
        if(isset($_POST['description']) && $_POST['description'] != "") {$description = "'".$_POST['description']."'";} else {$description = 'NULL';}
        if(isset($_POST['is-available']) && $_POST['is-available'] != "") {$isAvailable = "'".$_POST['is-available']."'";} else {$isAvailable = 'NULL';}
        if(isset($_POST['is-on-promo']) && $_POST['is-on-promo'] != "") {$isOnPromo = "'".$_POST['is-on-promo']."'";} else {$isOnPromo = 'NULL';}
        if(isset($_POST['reduction-percent']) && $_POST['reduction-percent'] != "") {$reductionPercent = "'".$_POST['reduction-percent']."'";} else {$reductionPercent = 'NULL';}
        if(isset($_POST['promo-price']) && $_POST['promo-price'] != "") {$promoPrice = "'".$_POST['promo-price']."'";} else {$promoPrice = 'NULL';}
        if(isset($_POST['is-in-selection']) && $_POST['is-in-selection'] != "") {$isInSelection = "'".$_POST['is-in-selection']."'";} else {$isInSelection = 'NULL';}
        if(isset($_POST['brand']) && $_POST['brand'] != "") {$brand = "'".$_POST['brand']."'";} else {$brand = 'NULL';}
        if(isset($_FILES['picture']) && $_FILES['picture']['name'] != "") {
            $dispPictureName = $_FILES['picture']['name'];
            $pictureName = "'".$dispPictureName."'";
            $db->exec("UPDATE product SET ref = '$ref', name = '$name', price = '$price', category_id = '$category', description = $description, picture_name = $pictureName, is_available = $isAvailable, is_on_promo = $isOnPromo, reduction_percent = $reductionPercent, promo_price = $promoPrice, is_in_selection = $isInSelection, brand_id = $brand WHERE id='$id'");
        } else {
            $db->exec("UPDATE product SET ref = '$ref', name = '$name', price = '$price', category_id = '$category', description = $description, is_available = $isAvailable, is_on_promo = $isOnPromo, reduction_percent = $reductionPercent, promo_price = $promoPrice, is_in_selection = $isInSelection, brand_id = $brand WHERE id='$id'");
        }
        $result = "";
        $reqDbSize = $db->query("SELECT size FROM size s INNER JOIN product_size ps WHERE ps.product_id = '$id' AND s.id = ps.size_id");
        while($productDbSize = $reqDbSize->fetch(PDO::FETCH_ASSOC)) {
            foreach($_POST['sizes'] as $productAvailableSize) {
                if($productAvailableSize != $productDbSize) {
                    $result .= "INSERT INTO `product_size` (`id`, `stock`, `product_id`, `size_id`) VALUES (NULL, NULL, '$id', '$productAvailableSize'); ";
                }
            }
        }
        $db->exec("$result");
        header("location:display-product.php");
    } else {
        header("location:home.php");
    }