<?php

    function reqSearch($db, $search) {
        return $db->query("SELECT * FROM category WHERE name LIKE '%$search%'");
    }

    function reqAll($db) {
        return $db->query("SELECT * FROM category");
    }