<?php
  session_start();
  if(!isset($_SESSION['login']))
    header('location:index.php');

  require_once "utils/connection.php";  
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../../favicon.ico">
  <title>sne*k you - Profil</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
  <link href="css/profil.css" rel="stylesheet">
  <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>
<header>
    <div class="navbar-wrapper">
      <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
              aria-controls="navbar">
              <span class="sr-only">Menu</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">
              <img src="img/logo.png" class="nav-logo" alt="logo">
              <span>sne*k you</span>
            </a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li>
                <form class="form-inline ml-auto p-2 bd-highlight" style="margin-top: 0.8vh" action="product.php">
                  <div class="form-search form-inline ml-auto p-2 bd-highlight">
                    <input class="extended-searchbar form-control mr-sm-2" type="text" placeholder="Rechercher un modèle" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                      <span class="glyphicon glyphicon-search"></span>
                    </button>
                  </div>
                </form>
              </li>
              <li>
                <a href="product.php">E-shop sneakers</a>
              </li>
              <li>
                <a href="contact.php">Nous contacter</a>
              </li>
<?php if(!isset($_SESSION['login'])) {?>
              <li>
                <a href="register.php">S'inscrire</a>
              </li>
<?php } ?>
              <li>
                <a href="cart.php">
                  <span class="glyphicon glyphicon-shopping-cart"></span>
                  Mon panier
                </a>
              </li>
<?php if(isset($_SESSION['login'])) {
  $login = $_SESSION['login'];
  $reqUser = $db->query("SELECT * FROM customer WHERE email = '$login'");
  if($user = $reqUser->fetch(PDO::FETCH_ASSOC)) {
    $userName = $user['firstname']." ".$user['lastname'];
  }
?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <span class="glyphicon glyphicon-asterisk"></span> <?= $userName ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="profil.php">Profil</a>
                  </li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Compte</li>
                  <li>
                    <a href="connect.php">Utiliser un autre compte</a>
                  </li>
                  <li>
                    <a href="utils\logout.php">Se déconnecter</a>
                  </li>
                </ul>
              </li>
<?php } else { ?>
              <li>
                <a href="connect.php">Se connecter</a>
              </li>
<?php } ?>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header>

  <main>
    <div class="container">
      <div class="row">

        <div class="col-md-9">
          <div class="card">
            <div class="card-body profil-card">
              <div class="row">
                <div class="col-md-12">
                  <h4>Votre Profil</h4>
                  <hr>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 ">
                  <form class="profil-form">

                    <div class="form-group row">
                      <label for="name" class="col-4 col-form-label">Prénom</label>
                      <div class="col-8">
                        <input id="name" name="name" class="form-control here" type="text">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="lastname" class="col-4 col-form-label">Nom</label>
                      <div class="col-8">
                        <input id="lastname" name="lastname" class="form-control here" type="text">
                      </div>
                    </div>


                    <div class="form-group row">
                      <label for="email" class="col-4 col-form-label">E-mail</label>
                      <div class="col-8">
                        <input id="email" name="email" class="form-control here" required="required" type="text">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="lastname" class="col-4 col-form-label">Adresse de facturation</label>
                      <div class="col-8">
                        <input id="lastname" name="lastname" placeholder="ex : 2 avenue du Général de Gaulle" class="form-control here" type="text">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="lastname" class="col-4 col-form-label">Code postal</label>
                      <div class="col-8">
                        <input id="lastname" name="lastname" placeholder="ex : 75000" class="form-control here" type="text">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="lastname" class="col-4 col-form-label">Ville</label>
                      <div class="col-8">
                        <input id="lastname" name="lastname" placeholder="ex : Paris" class="form-control here" type="text">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="newpass" class="col-4 col-form-label">Nouveau mot de passe</label>
                      <div class="col-8">
                        <input id="newpass" name="newpass" class="form-control here" type="text">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="newpass" class="col-4 col-form-label">Confirmer le mot de passe</label>
                      <div class="col-8">
                        <input id="confirm-newpass" name="confirm-newpass" class="form-control here" type="text">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-4 col-8">
                        <button name="submit" type="submit" class="btn btn-primary">Enregister les modifications</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="section footer-classic context-dark bg-image">
    <div class="container">
      <div class="row row-30">
        <div class="col-md-4 col-xl-5">
          <div class="pr-xl-4">
            <h4>
              <a class="brand" href="index.php">
                <img class="brand-logo-light" src="img/logo.png" alt="" width="auto" height="37">
              </a>
            </h4>
            <p>
              <i>L'e-shop numéro 1 de vente de sneakers à travers le monde !</i>
            </p>
            <br>
          </div>
        </div>
        <div class="col-md-4">
          <h4>Nous retrouver</h4>
          <dl class="contact-list">
            <dt>Adresse :</dt>
            <dd>2 avenue du Général de Gaulle, 75000 Paris</dd>
          </dl>
          <dl class="contact-list">
            <dt>E-mail :</dt>
            <dd>
              <a href="mailto:#">contact@sneakyou.com</a>
            </dd>
          </dl>
          <dl class="contact-list">
            <dt>Tél. :</dt>
            <dd>
              <a href="tel:#">+0146521548</a>
              <span>/</span>
              <a href="tel:#">+094582154</a>
            </dd>
          </dl>
        </div>
        <div class="col-md-4 col-xl-3">
          <h4>Liens utiles</h4>
          <ul class="nav-list">
            <li class="partners">
              <a href="#">Nos partenaires</a>
            </li>
            <li class="facebook">
              <a href="#">Facebook</a>
            </li>
            <li class="twitter">
              <a href="#">Twitter</a>
            </li>
            <li class="instagram">
              <a href="#">Instagram</a>
            </li>
          </ul>
        </div>
      </div>
      <p class="rights pull-left">
        <span>©  </span>
        <span class="copyright-year">2018</span>
        <span> </span>
        <span>Sne*k you</span>
      </p>
      <p class="pull-right">
        <a href="#">Retour en haut</a>
      </p>
    </div>
  </footer>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/ie10-viewport-bug-workaround.js"></script>
</body>

</html>