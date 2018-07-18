<?php

$provenance = $_SERVER['HTTP_REFERER'];
echo "Erreur d'authentification <br>";
echo "Cliquez <a href='$provenance'>ici</a> pour réessayer";