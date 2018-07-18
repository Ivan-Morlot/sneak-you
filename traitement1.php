<?php

$maBase = array("toto" => "titi");
$login = $_POST['login'];
$pass = $_POST['pass'];
$provenance = $_SERVER['HTTP_REFERER'];

if (isset($maBase[$nom]) && $maBase[$login] == $pass) {
    echo "Bienvenue $login !";
} else {
    echo "Erreur d'authentification <br>";
    echo "Cliquez <a href='$provenance'>ici</a> pour réessayer";
}