<?php
  session_start();
  require_once '../utils/connection.php';
  require 'models/connectionModel.php';

  $model = new ConnectionModel($db);
  $result = NULL;
  
  if(isset($_SESSION['auth_level']) && $_SESSION['auth_level'] == '1')
    $model->redirectToHome();

  if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = md5($_POST['password']);
    $req = $model->searchCreds($login, $password);
        if($user = $req->fetch(PDO::FETCH_ASSOC)) {
            if($user['auth_level'] == '1') {
                $_SESSION['login'] = $user['email'];
                $_SESSION['auth_level'] = $user['auth_level'];
                header("location:home.php");
            } else {
                $result = 'unauth';
            }
        } else {
            $result = 'badcreds';
        }
  }

  require "vues/connectionVue.php";


 