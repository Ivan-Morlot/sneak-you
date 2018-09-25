<?php
  session_start();

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
  <title>sne*k you - Accueil</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
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
                <form class="form-inline ml-auto p-2 bd-highlight" action="product.php">
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
    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img class="first-slide" src="img/mosaique_carrousel.png" alt="First slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Lorem, ipsum dolor.</h1>
              <p>Ab, beatae ipsam? Reprehenderit tenetur in quidem deserunt optio molestiae nisi enim at eos tempora labore
                eum inventore, non saepe rerum eius.</p>
              <p>
                <a class="btn btn-lg btn-primary" href="product.php" role="button">Découvrez nos produits</a>
              </p>
            </div>
          </div>
        </div>
<?php if(!isset($_SESSION['login'])) {?>
        <div class="item">
          <img class="second-slide" src="img/brizais_carrousel.png" alt="Second slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Lorem ipsum dolor sit.</h1>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.
                Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
              <p>
                <a class="btn btn-lg btn-primary" href="register.php" role="button">Inscrivez-vous aujourd'hui</a>
              </p>
            </div>
          </div>
        </div>
<?php } ?>
        <div class="item">
          <img class="third-slide" src="img/adidas_carrousel.png" alt="Third slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Lorem ipsum dolor sit amet.</h1>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.
                Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
              <p>
                <a class="btn btn-lg btn-primary" href="contact.php" role="button">Nous contacter</a>
              </p>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Précédent</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Suivant</span>
      </a>
    </div>

    <div class="container marketing">
      <div class="row">
        <div class="col-lg-12">
          <div class="row sells">
            <img src="img/bestseller.png" class="sells-img t1" alt="">
            <h2>En vedette</h2>
          </div>
        </div>
        <div class="row">
<?php
  $reqSelection = $db->query("SELECT * FROM product WHERE is_in_selection = 1");
  while($prdInSelection = $reqSelection->fetch(PDO::FETCH_ASSOC)) {
    $imgName = $prdInSelection['picture_name'];
?>
          <div class="col-6 col-md-4 ">
            <a href="product.php">
              <img src="img/<?= $imgName ?>" style="width:100%;" alt="produit" />
            </a>
          </div>
<?php } ?>
        </div>
        <div class="col-lg-12">
          <div class="row sells">
            <img src="img/promotion.png" class="sells-img t2" alt="">
            <h2>En promotion</h2>
          </div>
        </div>
        <div class="row">
<?php
  $reqPromo = $db->query("SELECT * FROM product WHERE is_on_promo = 1");
  while($prdOnPromo = $reqPromo->fetch(PDO::FETCH_ASSOC)) {
    $imgName = $prdOnPromo['picture_name'];
?>
          <div class="col-6 col-md-4 ">
            <a href="product.php">
              <img src="img/<?= $imgName ?>" style="width:100%;" alt="produit" />
            </a>
          </div>
<?php } ?>
        </div>
        <div class="col-lg-12">
          <a id="tousnosproduits" href="product.php">
            <h2 class="all-sells">Venez voir toutes nos sneakers !</h2>
            <img class="featurette-image img-responsive center-block" src="img/touslesproduits.jpg" style="width: 100%; mask-image: linear-gradient(rgba(0, 0, 0, 1.0), transparent); -webkit-mask-image: linear-gradient(rgba(0, 0, 0, 1.0), transparent);" alt="">
          </a>
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">Un e-shop à votre écoute

          </h2>
          <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo
            cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive center-block" src="img/blog-feb.jpg" alt="">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7 col-md-push-5">
          <h2 class="featurette-heading">Des chaussures qui vous ressemblent

          </h2>
          <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo
            cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
        </div>
        <div class="col-md-5 col-md-pull-7">
          <img class="featurette-image img-responsive center-block" src="img/lifestyle.jpg" alt="">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-12">
          <h2 class="featurette-heading">Les dernières tendances sur Instagram</h2>
        </div>
        <div class="col-md-3">
          <img class="featurette-image img-responsive center-block" src="img/grid_jean.jpg" alt="">
        </div>
        <div class="col-md-3">
          <img class="featurette-image img-responsive center-block" src="img/grid_jean2.jpg" alt="">
        </div>
        <div class="col-md-3">
          <img class="featurette-image img-responsive center-block" src="img/grid_pile.jpg" alt="">
        </div>
        <div class="col-md-3">
          <img class="featurette-image img-responsive center-block" src="img/grid_femme.jpg" alt="">
        </div>
        <div class="col-md-3">
          <img class="featurette-image img-responsive center-block" src="img/grid_repos.jpg" alt="">
        </div>
        <div class="col-md-3">
          <img class="featurette-image img-responsive center-block" src="img/grid_repos2.jpg" alt="">
        </div>
        <div class="col-md-3">
          <img class="featurette-image img-responsive center-block" src="img/grid_sansjean.jpg" alt="">
        </div>
        <div class="col-md-3">
          <img class="featurette-image img-responsive center-block" src="img/grid_voyage.jpg" alt="">
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
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/ie10-viewport-bug-workaround.js"></script>
  <script src="js/tools.js"></script>
</body>



</html>