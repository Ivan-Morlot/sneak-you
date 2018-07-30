<?php
  session_start();

  require_once "../utils/connection.php";

  require "models/connectionModel.php";
  
  if(isset($_SESSION['auth_level']) && $_SESSION['auth_level'] == '1')
    header("location:home.php");
  
  $result = '';

  if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = md5($_POST['password']);
    $req = searchCreds($db, $login, $password);
    if($user = $req->fetch(PDO::FETCH_ASSOC)) {
        if($user['auth_level'] == '1') {
            $_SESSION['login'] = $user['email'];
            $_SESSION['auth_level'] = $user['auth_level'];
            header("location:home.php");
        } else {
            $result = '
                <div>
                <p class="error">Vous n\'êtes pas autorisé à accéder à cette partie du site, désolé !</p>
                <a class="error-link" href="../index.html">Retour à l\'accueil</a>
                </div>
            ';
        }
    } else {
        $result = '
            <div>
                <p class="error">L\'identifiant et/ou le mot de passe n\'existe(nt) pas.</p>
            </div>
        ';
    }
  }

  require "vues/connectionVue.php";


 