<?php
    try {
        $db = new PDO("mysql:host=localhost;dbname=db_boutique;charset=utf8", "root", "");
    } catch (PDOException $e) {
        echo '<h3>Oups ! Nous avons rencontré un problème...</h3>';
        echo '<p>' . $e->getMessage() . '</p>';
    }