<?php
    if(isset($_SESSION['auth_level']) && $_SESSION['auth_level'] != 1 || !isset($_SESSION['auth_level'])) header("location:..\index.php");