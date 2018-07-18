<?php

$maBase = array("toto" => "titi");
$login = $_POST['login'];
$pass = $_POST['pass'];


if (isset($maBase[$login]) && $maBase[$login] == $pass) {

        header("Location: mesinfos.php");
} else {
    header("Location: erreur.php");
    
}