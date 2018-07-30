<?php
    function searchCreds($db, $login, $password) {
        return $db->query("SELECT * FROM customer WHERE (email = '$login' AND password = '$password')");
    }