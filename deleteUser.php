<?php
    session_start();
    require_once('connexion.php');
    
    $code = $_GET['code'];
    mysqli_query($conn, "DELETE FROM etudiant WHERE (code = $code)") or die(mysqli_connect_error());
    header("location:afficherEtudiant.php");
