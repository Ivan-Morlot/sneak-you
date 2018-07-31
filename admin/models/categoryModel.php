<?php
    function reqSearchCat($db, $search) {
        return $db->query("SELECT * FROM category WHERE name LIKE '%$search%'");
    }

    function reqAllCat($db) {
        return $db->query("SELECT * FROM category");
    }

    function insertCat($db, $name, $description) {
        return $db->exec("INSERT INTO `category` (`id`, `name`, `description`) VALUES (NULL, '$name', $description)");
    }

    function deleteCat($db, $id) {
        return $db->exec("DELETE FROM category WHERE (id = $id)");
    }

    function selectCat($db, $id) {
        return $db->query("SELECT * FROM category WHERE id = '$id'");
    }

    function selectCatName($db, $id) {
        return $db->query("SELECT name FROM category WHERE id = '$id'");
    }

    function updateCat($db, $name, $description, $id) {
        return $db->exec("UPDATE category SET name = '$name', description = $description WHERE id='$id'");
    }