<?php
  session_start();

  require_once "utils/connection.php";

  $result = '
    <form action="register.php?req=register" method="post" class="container2">
      <div class="heading">
        Formulaire d\'inscription
      </div>
      <hr>
      <div class="row">
            <div class="col-xs-4 ">
              <label class="gender">Civilité<span class="rqd">*</span> :</label>
            </div>
            <div class="col-xs-4 male">
              <input type="radio" name="gender" id="boy" value="M" required>
              <label for="man">M.</label>
            </div>
            <div class="col-xs-4 female">
              <input type="radio" name="gender" id="girl" value="F" required>
              <label for="woman">Mme.</label>
            </div>
          </div>
      </div>
      <div class="row ">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <label class="firstname">Prénom<span class="rqd">*</span> :</label>
            </div>
            <div class="col-xs-8">
              <input type="text" name="firstname" maxlength="30" required class="form-control">
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <label class="lastname">Nom<span class="rqd">*</span> :</label>
            </div>
            <div class="col-xs-8">
            <input type="text" name="lastname" maxlength="30" required class="form-control">
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <label class="mail">E-mail<span class="rqd">*</span> :</label>
            </div>
            <div class="col-xs-8">
              <input type="email" name="email" id="email" onblur="checkEmail(\'confirm-email\', \'email\')" required class="form-control">
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <label class="mail">Confirmer l\'e-mail<span class="rqd">*</span> :</label>
            </div>
            <div class="col-xs-8">
              <input type="email" name="confirm-email" maxlength="50" id="confirm-email" onblur="checkEmail(\'confirm-email\', \'email\')" required class="form-control">
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <label class="pass">Mot de passe<span class="rqd">*</span> :</label>
            </div>
            <div class="col-xs-8">
            <input type="password" name="password" id="password" onblur="checkPassword(\'confirm-password\', \'password\')" required class="form-control">
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <label class="pass">Confirmer le mot de passe<span class="rqd">*</span> :</label>
            </div>
            <div class="col-xs-8">
            <input type="password" name="confirm-password" id="confirm-password" onblur="checkPassword(\'confirm-password\', \'password\')" required class="form-control">
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <label class="pass">Date de naissance :</label>
            </div>
            <div class="col-xs-8">
              <input type="date" name="birthdate" class="form-control">
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <label class="pass">Tél. principal<span class="rqd">*</span> :</label>
            </div>
            <div class="col-xs-8">
            <input type="text" name="main-phone" maxlength="10"  size="10" oninput="checkPhoneNumber(this)" required class="form-control">
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <label class="pass">Tél. secondaire :</label>
            </div>
            <div class="col-xs-8">
            <input type="text" name="sec-phone" maxlength="10"  size="10" oninput="checkPhoneNumber(this)" class="form-control">
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <p class="rqd">* champs requis</p>
            </div>
            <div class="col-xs-8">
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="col-sm-12">
            <button class="btn btn-warning" type="submit">S\'inscire</button>
          </div>
        </div>
      </div>
    </form>
  ';

  if (!isset($_SESSION['login']) && isset($_GET['req']) && $_GET['req'] == 'register' &&
    isset($_POST['gender']) &&
    isset($_POST['firstname']) &&
    isset($_POST['lastname']) &&
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['main-phone'])) {
    $email = $_POST['email'];
    
    $reqCheckEmail = $db->query("SELECT email FROM customer WHERE email = '$email'");
    if($tempCheckEmail = $reqCheckEmail->fetch(PDO::FETCH_ASSOC)) {
        $checkEmail = $tempCheckEmail['email'];
    }

    if (!isset($checkEmail) || $checkEmail === "") {
        $authLevel = 0;
        $gender = $_POST['gender'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $password = md5($_POST['password']);
        $mainPhone = $_POST['main-phone'];
        if(isset($_POST['birthdate']) && $_POST['birthdate'] != "") {$dispBirthdate = $_POST['birthdate']; $birthdate = "'".$dispBirthdate."'";} else {$birthdate = 'NULL';}
        if(isset($_POST['sec-phone']) && $_POST['sec-phone'] != "") {$dispSecPhone = $_POST['sec-phone']; $secPhone = "'".$dispSecPhone."'";} else {$secPhone = 'NULL';}
        $db->exec("INSERT INTO `customer` (`id`,`gender`, `firstname`, `lastname`, `email`, `password`, `auth_level`, `birthdate`, `main_phone_number`, `secondary_phone_number`, `delivery_address`, `del_postal_code`, `del_city`, `del_address_supp`, `del_building`, `del_staircase`, `del_floor`, `del_door`, `billing_address`, `bil_postal_code`, `bil_city`, `bil_address_supp`, `bil_building`, `bil_staircase`, `bil_floor`, `bil_door`, `credit_card_holder`, `credit_card_number`, `credit_card_expiration`) VALUES (NULL, '$gender', '$firstname', '$lastname', '$email', '$password', '$authLevel', $birthdate, '$mainPhone', $secPhone, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
        $_SESSION['login'] = $email;
        $_SESSION['auth_level'] = $authLevel;
        $result = '
            <div class="container2">
              <div class="heading">
                Inscription réussie
              </div>
              <p class="pass">Bienvenue !</p>
            </div>
          ';
    } else {
      $result = '
        <div class="container2">
          <div class="heading">
            Inscription échouée
          </div>
          <p class="pass">Cet e-mail existe déjà.</p>
        </div>
      ';
    }
  } else if(isset($_SESSION['login'])) {
    header('location:index.php');
  }
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
  <title>sne*k you - Inscription</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
  <link href="css/account.css" rel="stylesheet">
  <link href="css/carousel.css" rel="stylesheet">
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
    <?= $result ?>
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
  <script src="js/tools.js"></script>
</body>

</html>