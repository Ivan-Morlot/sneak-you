<?php
    function reqSearchPrd($db, $search) {
        return $db->query("SELECT * FROM product WHERE name LIKE '%$search%'");
    }

    function reqAllPrd($db) {
        return $db->query("SELECT * FROM product");
    }

    function insertPrd($db, $ref, $name, $description, $price, $pictureName, $isAvailable, $isOnPromo, $reductionPercent, $promoPrice, $isInSelection, $brand, $category) {
        return $db->exec("INSERT INTO `product` (`id`, `ref`, `name`, `description`, `price`, `picture_name`, `is_available`, `is_on_promo`, `reduction_percent`, `promo_price`, `is_in_selection`, `brand_id`, `category_id`) VALUES (NULL, '$ref', '$name', $description, '$price', $pictureName, $isAvailable, $isOnPromo, $reductionPercent, $promoPrice, $isInSelection, $brand, '$category')");
    }

    function insertPrdSizes($db, $productId, $postedSizes) {
        $result = "";
        foreach($postedSizes as $productAvailableSize) {
            $result .= "INSERT INTO `product_size` (`id`, `stock`, `product_id`, `size_id`) VALUES (NULL, NULL, '$productId', '$productAvailableSize'); ";
        }
        return $db->exec("$result");
    }

    function deletePrd($db, $id) {
        return $db->exec("DELETE FROM product WHERE (id = $id)");
    }

    function deletePrdAllSizes($db, $id) {
        return $db->exec("DELETE FROM product_size WHERE (product_id = $id)");
    }

    function selectPrdById($db, $id) {
        return $db->query("SELECT * FROM product WHERE id = '$id'");
    }

    function selectPrdByRef($db, $ref) {
        return $db->query("SELECT * FROM product WHERE ref = '$ref'");
    }

    function selectPrdAllSizes($db, $productId) {
        return $db->query("SELECT size FROM size s INNER JOIN product_size ps WHERE ps.product_id = '$productId' AND s.id = ps.size_id");
    }

    function updatePrd($db, $ref, $name, $description, $price, $isAvailable, $isOnPromo, $reductionPercent, $promoPrice, $isInSelection, $brand, $category, $id, $optional) {
        $result = "UPDATE product SET ref = '$ref', name = '$name', price = '$price', category_id = '$category', description = $description";
        if (isset($optional["picture_name"]))
            $result .= ", picture_name = $pictureName";
        $result .= ", is_available = $isAvailable, is_on_promo = $isOnPromo, reduction_percent = $reductionPercent, promo_price = $promoPrice, is_in_selection = $isInSelection, brand_id = $brand WHERE id='$id'";
        return $db->exec($result);
    }

    /*function updatePrdSizes($db, $productId, $postedSizes) {
        $result = "";
        $reqDbSize = selectPrdAllSizes($db, $productId);
        while($productDbSize = $reqDbSize->fetch(PDO::FETCH_ASSOC)) {
            foreach($postedSizes as $productAvailableSize) {
                $tempReq = $db->query("SELECT count(*) FROM product_size WHERE product_id = $productId AND size_id = $productAvailableSize");
                $temp = $tempReq->fetch(PDO::FETCH_ASSOC);
                if($temp['count(*)'] == 0 && $productAvailableSize != $productDbSize) {
                    $result .= "INSERT INTO `product_size` (`id`, `stock`, `product_id`, `size_id`) VALUES (NULL, NULL, '$productId', '$productAvailableSize'); ";
                }
            }
        }
        return $db->exec("$result");
    }*/

    function dispPrdBoolVal($bool) {
        if(isset($bool) && $bool == '0') {
            return "Non";
        } else if(isset($bool) && $bool == '1') {
            return "Oui";
        } else if(!isset($bool)){
            return "N/A";
        }
    }

    function dispPrdBoolCheckbox($bool, $val) {
        if($bool == $val)
            return "checked";
    }

    function dispPrdSelectSelected($val1, $val2) {
        if($val1 == $val2)
            return "selected";
    }