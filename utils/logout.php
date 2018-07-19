<?php
    session_start();
    if(isset($_SESSION['auth_level'])) $authLevel = $_SESSION['auth_level'];
    session_unset();
    session_destroy();
    if($authLevel == 1) $loc = 'location:..\admin.php';
    else $loc = 'location:..\index.php';
    header($loc);