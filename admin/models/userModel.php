<?php
    function reqSearchUsr($db, $search) {
        return $db->query("SELECT * FROM customer WHERE lastname LIKE '%$search%'");
    }

    function reqAllUsr($db) {
        return $db->query("SELECT * FROM customer");
    }

    function insertUsr($db, $gender, $firstname, $lastname, $email, $password, $authLevel, $birthdate, $mainPhone, $secPhone, $address, $postalCode, $city, $addressSupp, $building, $staircase, $floor, $door) {
        return $db->exec("INSERT INTO `customer` (`id`,`gender`, `firstname`, `lastname`, `email`, `password`, `auth_level`, `birthdate`, `main_phone_number`, `secondary_phone_number`, `delivery_address`, `del_postal_code`, `del_city`, `del_address_supp`, `del_building`, `del_staircase`, `del_floor`, `del_door`, `billing_address`, `bil_postal_code`, `bil_city`, `bil_address_supp`, `bil_building`, `bil_staircase`, `bil_floor`, `bil_door`, `credit_card_holder`, `credit_card_number`, `credit_card_expiration`) VALUES (NULL, '$gender', '$firstname', '$lastname', '$email', '$password', '$authLevel', $birthdate, '$mainPhone', $secPhone, '$address', '$postalCode', '$city', $addressSupp, $building, $staircase, $floor, $door, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
    }

    function deleteUsr($db, $id) {
        return $db->exec("DELETE FROM customer WHERE (id = $id)");
    }

    function selectUsr($db, $id) {
        return $db->query("SELECT * FROM customer WHERE id = '$id'");
    }

    function dispUsrAuthLevel($authLevel) {
        if($authLevel == '0') {
            return "Utilisateur";
        } else if($authLevel == '1') {
            return "Administrateur";
        } else {
            return "N/A";
        }
    }