<?php
    function reqSearchBrd($db, $search) {
        return $db->query("SELECT * FROM brand WHERE name LIKE '%$search%'");
    }

    function reqAllBrd($db) {
        return $db->query("SELECT * FROM brand");
    }

    function insertBrd($db, $name) {
        return $db->exec("INSERT INTO `brand` (`id`, `name`) VALUES (NULL, '$name')");
    }

    function deleteBrd($db, $id) {
        return $db->exec("DELETE FROM brand WHERE (id = $id)");
    }

    function selectBrd($db, $id) {
        return $db->query("SELECT * FROM brand WHERE id = '$id'");
    }

    function selectBrdName($db, $id) {
        return $db->query("SELECT name FROM brand WHERE id = $id");
    }

    function updateBrd($db, $name, $id) {
        return $db->exec("UPDATE brand SET name = '$name' WHERE id='$id'");
    }