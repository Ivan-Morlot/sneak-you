<?php
    function reqAllSiz($db) {
        return $db->query("SELECT * FROM size");
    }