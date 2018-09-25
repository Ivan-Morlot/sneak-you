<?php
  session_start();

  require_once "utils/connection.php";  

  $result = '';
  $showModal = false;

  if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = md5($_POST['password']);
    $req = $db->query("SELECT * FROM customer WHERE (email = '$login' AND password = '$password')");
    if($user = $req->fetch(PDO::FETCH_ASSOC)) {
      $_SESSION['login'] = $user['email'];
      $_SESSION['auth_level'] = $user['auth_level'];
      header("location:cart.php");
    } else {
      $result = '
        <div>
            <p class="connect-error">L\'identifiant et/ou le mot de passe n\'existe(nt) pas.</p>
        </div>
      ';
      $showModal = true;
    }
  }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>sne*k you - Panier</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-formhelpers-min.css" media="screen">
    <link rel="stylesheet" href="css/bootstrapValidator-min.css" />
    <link rel="stylesheet" href="css/bootstrap-side-notes.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="shortcut icon" href="img/favicon.ico">
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/cart.css" rel="stylesheet">
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap-min.js"></script>
    <script src="js/bootstrap-formhelpers-min.js"></script>
    <script type="text/javascript" src="js/bootstrapValidator-min.js"></script>
    <script type="text/javascript" src="js/cart-modal.js"></script>
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
        <div class="container">
            <div id="cart-container" class="row">
                <div class="col-sm-12 col-md-10 col-md-offset-1 ">
                    <h1>Votre panier</h1>
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th class="text-center ">Prix</th>
                                <th class="text-center ">Total</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
<?php
    if(isset($_SESSION['cart']) && isset($_GET['del'])) {
        $temp = array();
		$temp['product'] = array();
		$temp['product_qty'] = array();

        for($i = 0; $i < count($_SESSION['cart']['product']); $i++) {
            if ($i != $_GET['del']) {
                array_push($temp['product'], $_SESSION['cart']['product'][$i]);
                array_push($temp['product_qty'], $_SESSION['cart']['product_qty'][$i]);
            }
        }

        $_SESSION['cart'] = $temp;

        unset($temp);
    }

    $cartTotalPrice = 0;

    if(isset($_SESSION['cart']) && count($_SESSION['cart']['product']) > 0) {
        $nbPrd = count($_SESSION['cart']['product']);
        for($i = 0; $i < $nbPrd; $i++) {
            $prdSizeId = $_SESSION['cart']['product'][$i];
            $prdQty = $_SESSION['cart']['product_qty'][$i];

            $reqPrdId = $db->query("SELECT * FROM product_size ps WHERE ps.id = $prdSizeId");
            if($tempPrd = $reqPrdId->fetch(PDO::FETCH_ASSOC)) {
                $prdId = $tempPrd['product_id'];
                $dispSizeId = $tempPrd['size_id'];
            }

            $reqDispSize = $db->query("SELECT size FROM size WHERE id = $dispSizeId");
            if($tempSize = $reqDispSize->fetch(PDO::FETCH_ASSOC)){
                $dispSize = $tempSize['size'];
            }

            $reqPrd = $db->query("SELECT p.* FROM product p INNER JOIN product_size ps WHERE ps.product_id = $prdId AND p.id = $prdId");
            if($product = $reqPrd->fetch(PDO::FETCH_ASSOC));
            
            if(isset($product['is_on_promo']) && $product['is_on_promo'] == 1 && isset($product['promo_price'])) {
                $prdPrice = $product['promo_price'];
            } else {
                $prdPrice = $product['price'];
            }

            $prdTotalPrice = $prdPrice * (float)$prdQty;

            $cartTotalPrice += $prdTotalPrice;
?>
                            <tr>
                                <td class="col-sm-8 col-md-6 ">
                                    <div class="media ">
                                        <a class="thumbnail pull-left" href="# ">
                                            <img class="media-object " src="img/<?= $product['picture_name'] ?>" style="width: 72px; height: 72px; ">
                                        </a>
                                        <div class="media-body ">
                                            <h4 class="media-heading ">
                                                <a href="product.php"><?= $product['name'] ?></a>
                                            </h4>
                                            <h5 class="media-heading "> ref.
                                                <span><?= $product['ref'] ?></span>
                                            </h5>
                                            <span>Taille : </span>
                                            <span>
                                                <strong><?= $dispSize ?></strong>
                                            </span>
                                            <div class="text-success ">
                                                <strong><?php if(isset($product['is_available']) && $product['is_available'] == 1) { echo 'En stock'; } else { echo 'En réapprovisionnement' ; } ?></strong>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-sm-1 col-md-1 " style="text-align: center ">
                                    <input type="number" class="form-control" value="<?= $prdQty ?>" disabled>
                                </td>
                                <td class="col-sm-1 col-md-1 text-center ">
                                    <strong><?= $prdPrice ?>€</strong>
                                </td>
                                <td class="col-sm-1 col-md-1 text-center ">
                                    <strong><?= $prdTotalPrice ?>€</strong>
                                </td>
                                <td class="col-sm-1 col-md-1 ">
                                    <a class="btn btn-danger " href="cart.php?del=<?= $i ?>">
                                        <span class="glyphicon glyphicon-remove "></span> Retirer
                                    </a>
                                </td>
                            </tr>
<?php
        }
    } else {
?>
                            <tr>
                                <td>
                                    Votre panier est vide
                                </td>
                            </tr>
<?php } ?>
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>
                                    <h3>Total à payer</h3>
                                </td>
                                <td class="text-right ">
                                    <h3>
                                        <strong><?= $cartTotalPrice ?> €</strong>
                                    </h3>
                                </td>
                            </tr>
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>
                                    <a class="btn btn-default" href="product.php">
                                        <span class="glyphicon glyphicon-shopping-cart "></span> Continuer mon shopping
                                    </a>
                                </td>



                                <!-- Modal -->
                                <div class="modal fade" id="val-order-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <form action="" method="POST" id="payment-form" class="form-horizontal">
                                                    <div class="row row-centered">
                                                        <div class="col-md-12 col-md-offset-12">
                                                            <div class="page-header">
                                                                <h2 class="gdfg">Valider le paiement</h2>
                                                            </div>
                                                            <fieldset>

                                                                <!-- Form Name -->
                                                                <legend>Adresse de livraison</legend>

                                                                <!-- Street -->
                                                                <div class="form-group">
                                                                    <label class="col-sm-4 control-label" for="textinput">Rue</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="street" placeholder="ex: 2 avenue du Générale de Gaule" class="address form-control">
                                                                    </div>
                                                                </div>
                                                                <!-- Postcal Code -->
                                                                <div class="form-group">
                                                                    <label class="col-sm-4 control-label" for="textinput">Code Postal</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="zip" maxlength="9" placeholder="Postal Code" class="zip form-control">
                                                                    </div>
                                                                </div>
                                                                <!-- City -->
                                                                <div class="form-group">
                                                                    <label class="col-sm-4 control-label" for="textinput">Ville</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="city" placeholder="ex : Paris" class="city form-control">
                                                                    </div>
                                                                </div>




                                                                <!-- Country -->
                                                                <div class="form-group">
                                                                    <label class="col-sm-4 control-label" for="textinput">Pays</label>
                                                                    <div class="col-sm-6">
                                                                        <!--input type="text" name="country" placeholder="Country" class="country form-control"-->
                                                                        <div class="country bfh-selectbox bfh-countries" name="country" data-flags="true" data-filter="true"> </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Email -->
                                                                <div class="form-group">
                                                                    <label class="col-sm-4 control-label" for="textinput">Email</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="email" maxlength="65" placeholder="ex : dupond@gmail.com" class="email form-control">
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                            <fieldset>
                                                                <legend>Informations carte</legend>

                                                                <!-- Card Holder Name -->
                                                                <div class="form-group">
                                                                    <label class="col-sm-4 control-label" for="textinput">Nom du propriétaire</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="cardholdername" maxlength="70" placeholder="Card Holder Name" class="card-holder-name form-control">
                                                                    </div>
                                                                </div>

                                                                <!-- Card Number -->
                                                                <div class="form-group">
                                                                    <label class="col-sm-4 control-label" for="textinput">Numéro de la carte</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" id="cardnumber" maxlength="19" placeholder="Card Number" class="card-number form-control">
                                                                    </div>
                                                                </div>

                                                                <!-- Expiry-->
                                                                <div class="form-group">
                                                                    <label class="col-sm-4 control-label" for="textinput">
                                                                        Date d'expiration</label>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-inline">
                                                                            <select name="select2" data-stripe="exp-month" class="card-expiry-month stripe-sensitive required form-control">
                                                                                <option value="01" selected="selected">01</option>
                                                                                <option value="02">02</option>
                                                                                <option value="03">03</option>
                                                                                <option value="04">04</option>
                                                                                <option value="05">05</option>
                                                                                <option value="06">06</option>
                                                                                <option value="07">07</option>
                                                                                <option value="08">08</option>
                                                                                <option value="09">09</option>
                                                                                <option value="10">10</option>
                                                                                <option value="11">11</option>
                                                                                <option value="12">12</option>
                                                                            </select>
                                                                            <span> / </span>
                                                                            <select name="select2" data-stripe="exp-year" class="card-expiry-year stripe-sensitive required form-control">
                                                                            </select>
                                                                            <script type="text/javascript">
                                                                                var select = $(".card-expiry-year"),
                                                                                    year = new Date().getFullYear();

                                                                                for (var i = 0; i < 12; i++) {
                                                                                    select.append($("<option value='" + (i + year) + "' " + (i === 0 ? "selected" : "") + ">" + (i + year) + "</option>"))
                                                                                }
                                                                            </script>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- CVV -->
                                                                <div class="form-group">
                                                                    <label class="col-sm-4 control-label" for="textinput">Code de sécurité</label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" id="cvv" maxlength="3" class="card-cvc form-control">
                                                                    </div>
                                                                </div>



                                                                <!-- Submit -->
                                                                <div class="control-group">
                                                                    <div class="controls">
                                                                        <center>
                                                                        </center>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                            <button class="btn btn-success" type="submit">Commander</button>
                                                </form>
                                                </div>
                                                <div class="modal-header">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>

                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <td>
<?php if(isset($_SESSION['login'])) { ?>
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#val-order-modal" <?php if(!isset($_SESSION['cart']) || count($_SESSION['cart']['product']) <= 0) { echo 'disabled'; } ?>>
                                                Passer la commande
                                                <span class="glyphicon glyphicon-play"></span>
                                            </button>
<?php } else { ?>
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#connection-modal" <?php if(!isset($_SESSION['cart']) || count($_SESSION['cart']['product']) <= 0) { echo 'disabled'; } ?>>
                                                Se connecter et passer commande
                                                <span class="glyphicon glyphicon-play"></span>
                                            </button>
<?php } ?>
                                        </td>
                            </tr>
                        </tbody>
                    </table>
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

</body>

<!-- Modal-->
<div id="connection-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 id="exampleModalLabel" class="modal-title">Finalisez vos achats en vous connectant</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="cart.php">
                    <div class="form-group">
                        <label>Login :</label>
                        <br>
                        <input type="email" name="login" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Mot de passe :</label>
                        <br>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <?= $result ?>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Se connecter</button>
                    </div>
                </form>
                <span class="min-title">Pas encore de compte ?</span>
                <p>
                    <a href="register.php">Inscrivez-vous !</a>
                </p>
            </div>

        </div>
    </div>
</div>
<!--fin modal-->

<?php
    if ($showModal == true) 
        echo "<script>
            $('#connection-modal').removeClass('fade');
            $('#connection-modal').modal('show');
        </script>";
?>

</html>