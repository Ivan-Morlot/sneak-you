<?php
  session_start();
  if(isset($_SESSION['login']))
    header('location:index.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../../favicon.ico">

  <title>Carousel Template for Bootstrap</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  <!-- Custom styles for this template -->
  <link href="css/account.css" rel="stylesheet">
  <link href="css/carousel.css" rel="stylesheet">
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
<?php if(isset($_SESSION['login'])) {?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <span class="glyphicon glyphicon-asterisk"></span>
                  Mon-compte
                  <span class="caret"></span>
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
    <form action="index.php" method="post" class="container2">
      <!---heading---->
      <header class="heading">
        Formulaire d'inscription
      </header>
      <hr>
      <!---Form starting---->
      <div class="row ">
        <!--- For Name---->
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <label class="firstname">Prénom :</label>
            </div>
            <div class="col-xs-8">
              <input type="text" name="fname" id="fname" placeholder="Enter your First Name" class="form-control ">
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <label class="lastname">Nom :</label>
            </div>
            <div class="col-xs-8">
              <input type="text" name="lname" id="lname" placeholder="Enter your Last Name" class="form-control last">
            </div>
          </div>
        </div>
        <!--   date de naissance -->
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <label class="pass">Birth date :</label>
            </div>
            <div class="col-xs-8">
              <input type="date" name="date" id="date" placeholder="20/02/1992" class="form-control">
            </div>
          </div>
        </div>
        <!-----For email---->
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <label class="mail">Email :</label>
            </div>
            <div class="col-xs-8">
              <input type="email" name="email" id="email" placeholder="Enter your email" class="form-control">
            </div>
          </div>
        </div>
        <!-----For Password and confirm password---->
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <label class="pass">Mot de passe :</label>
            </div>
            <div class="col-xs-8">
              <input type="password" name="password" id="password" placeholder="Enter your Password" class="form-control">
            </div>
          </div>
        </div>
        <!-----------For Phone number(mobile)-------->
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <label class="pass">Mobile :</label>
            </div>
            <div class="col-xs-8">
              <input type="tel" name="tel" id="tel" placeholder="06 45 12 54 84" class="form-control">
            </div>
          </div>
        </div>
        <!-----------For Phone number (fixe)-------->
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4">
              <label class="pass">Fixe :</label>
            </div>
            <div class="col-xs-8">
              <input type="tel" name="tel" id="tel" placeholder="+33" class="form-control">
            </div>
          </div>
        </div>
        <!--   gender     -->
        <div class="col-sm-12">
          <div class="row">
            <div class="col-xs-4 ">
              <label class="gender">Civilité:</label>
            </div>
            <div class="col-xs-4 male">
              <input type="radio" name="gender" id="boy" value="M">
              <label for="boy">M.</label>
            </div>

            <div class="col-xs-4 female">
              <input type="radio" name="gender" id="girl" value="F">
              <label for="girl">Mme.</label>
            </div>
          </div>
          <div class="col-sm-12">
            <button class="btn btn-warning" type="submit">S'inscire</button>
          </div>
        </div>
      </div>
    </form>
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
  <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
  <script src="js/holder.min.js"></script>
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="js/ie10-viewport-bug-workaround.js"></script>
  <script src="js/tools.js"></script>
</body>

</html>