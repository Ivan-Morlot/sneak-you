<?php
    if($_SESSION['auth_level'] != 1) header("location:index.php");