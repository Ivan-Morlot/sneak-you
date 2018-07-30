<?php
    function reqSearch($db, $search) {
        return $db->query("SELECT * FROM brand WHERE name LIKE '%$search%'");
    }

    function reqAll($db) {
        return $db->query("SELECT * FROM brand");
    }

    function insertBrd($db, $name, $description){
        return $db->exec("INSERT INTO `brand` (`id`, `name`) VALUES (NULL, '$name')");
    }

    function deleteBrd($db, $id) {
        return $db->exec("DELETE FROM brand WHERE (id = $id)");
    }

    function selectBrd($db, $id) {
        return $db->query("SELECT * FROM brand WHERE id = '$id'");
    }

    function updateBrd($db, $name, $description, $id) {
        return $db->exec("UPDATE brand SET name = '$name' WHERE id='$id'");
    }