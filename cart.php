<?php
  session_start();

  require_once "utils/connection.php";
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
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap-side-notes.css" />
    <link rel="shortcut icon" href="img/favicon.ico">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/cart.css" rel="stylesheet">
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap-min.js"></script>
    <script src="js/bootstrap-formhelpers-min.js"></script>
    <script type="text/javascript" src="js/bootstrapValidator-min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#payment-form').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                submitHandler: function (validator, form, submitButton) {
                    // createToken returns immediately - the supplied callback submits the form if there are no errors
                    Stripe.card.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val(),
                        name: $('.card-holder-name').val(),
                        address_line1: $('.address').val(),
                        address_city: $('.city').val(),
                        address_zip: $('.zip').val(),
                        address_state: $('.state').val(),
                        address_country: $('.country').val()
                    }, stripeResponseHandler);
                    return false; // submit from callback
                },
                fields: {
                    street: {
                        validators: {
                            notEmpty: {
                                message: 'The street is required and cannot be empty'
                            },
                            stringLength: {
                                min: 6,
                                max: 96,
                                message: 'The street must be more than 6 and less than 96 characters long'
                            }
                        }
                    },
                    city: {
                        validators: {
                            notEmpty: {
                                message: 'The city is required and cannot be empty'
                            }
                        }
                    },
                    zip: {
                        validators: {
                            notEmpty: {
                                message: 'The zip is required and cannot be empty'
                            },
                            stringLength: {
                                min: 3,
                                max: 9,
                                message: 'The zip must be more than 3 and less than 9 characters long'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'The email address is required and can\'t be empty'
                            },
                            emailAddress: {
                                message: 'The input is not a valid email address'
                            },
                            stringLength: {
                                min: 6,
                                max: 65,
                                message: 'The email must be more than 6 and less than 65 characters long'
                            }
                        }
                    },
                    cardholdername: {
                        validators: {
                            notEmpty: {
                                message: 'The card holder name is required and can\'t be empty'
                            },
                            stringLength: {
                                min: 6,
                                max: 70,
                                message: 'The card holder name must be more than 6 and less than 70 characters long'
                            }
                        }
                    },
                    cardnumber: {
                        selector: '#cardnumber',
                        validators: {
                            notEmpty: {
                                message: 'The credit card number is required and can\'t be empty'
                            },
                            creditCard: {
                                message: 'The credit card number is invalid'
                            },
                        }
                    },
                    expMonth: {
                        selector: '[data-stripe="exp-month"]',
                        validators: {
                            notEmpty: {
                                message: 'The expiration month is required'
                            },
                            digits: {
                                message: 'The expiration month can contain digits only'
                            },
                            callback: {
                                message: 'Expired',
                                callback: function (value, validator) {
                                    value = parseInt(value, 10);
                                    var year = validator.getFieldElements('expYear').val(),
                                        currentMonth = new Date().getMonth() + 1,
                                        currentYear = new Date().getFullYear();
                                    if (value < 0 || value > 12) {
                                        return false;
                                    }
                                    if (year == '') {
                                        return true;
                                    }
                                    year = parseInt(year, 10);
                                    if (year > currentYear || (year == currentYear && value > currentMonth)) {
                                        validator.updateStatus('expYear', 'VALID');
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
                            }
                        }
                    },
                    expYear: {
                        selector: '[data-stripe="exp-year"]',
                        validators: {
                            notEmpty: {
                                message: 'The expiration year is required'
                            },
                            digits: {
                                message: 'The expiration year can contain digits only'
                            },
                            callback: {
                                message: 'Expired',
                                callback: function (value, validator) {
                                    value = parseInt(value, 10);
                                    var month = validator.getFieldElements('expMonth').val(),
                                        currentMonth = new Date().getMonth() + 1,
                                        currentYear = new Date().getFullYear();
                                    if (value < currentYear || value > currentYear + 100) {
                                        return false;
                                    }
                                    if (month == '') {
                                        return false;
                                    }
                                    month = parseInt(month, 10);
                                    if (value > currentYear || (value == currentYear && month > currentMonth)) {
                                        validator.updateStatus('expMonth', 'VALID');
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
                            }
                        }
                    },
                    cvv: {
                        selector: '#cvv',
                        validators: {
                            notEmpty: {
                                message: 'The cvv is required and can\'t be empty'
                            },
                            cvv: {
                                message: 'The value is not a valid CVV',
                                creditCardField: 'cardnumber'
                            }
                        }
                    },
                }
            });
        });
    </script>
    <script type="text/javascript">
        // this identifies your website in the createToken call below
        Stripe.setPublishableKey('<Stripe Publishable Key>');

        function stripeResponseHandler(status, response) {
            if (response.error) {
                // re-enable the submit button
                $('.submit-button').removeAttr("disabled");
                // show hidden div
                document.getElementById('a_x200').style.display = 'block';
                // show the errors on the form
                $(".payment-errors").php(response.error.message);
            } else {
                var form$ = $("#payment-form");
                // token contains id, last4, and card type
                var token = response['id'];
                // insert the token into the form so it gets submitted to the server
                form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                // and submit
                form$.get(0).submit();
            }
        }
    </script>
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
<?php if(isset($_SESSION['cart']) && count($_SESSION['cart']['product']) > 0) {
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
                                    <input type="number" class="form-control" value="<?= $prdQty ?>">
                                </td>
                                <td class="col-sm-1 col-md-1 text-center ">
                                    <strong><?= $prdPrice ?>€</strong>
                                </td>
                                <td class="col-sm-1 col-md-1 text-center ">
                                    <strong><?= $prdTotalPrice ?>€</strong>
                                </td>
                                <td class="col-sm-1 col-md-1 ">
                                    <button type="button " class="btn btn-danger " action="cart.php?del=<?= $i ?>">
                                        <span class="glyphicon glyphicon-remove "></span> Annuler
                                    </button>
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
                                    <h5>Total HT</h5>
                                </td>
                                <td class="text-right ">
                                    <h5>
                                        <strong>0 €</strong>
                                    </h5>
                                </td>
                            </tr>
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>
                                    <h5>Frais de livraison</h5>
                                </td>
                                <td class="text-right ">
                                    <h5>
                                        <strong>0 €</strong>
                                    </h5>
                                </td>
                            </tr>
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>
                                    <h3>Total à payer</h3>
                                </td>
                                <td class="text-right ">
                                    <h3>
                                        <strong>0 €</strong>
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
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#val-order-modal">
                                                Passer la commande
                                                <span class="glyphicon glyphicon-play"></span>
                                            </button>
<?php } else { ?>
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#connection-modal">
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
                <form>
                    <div class="form-group">
                        <label>Login :</label>
                        <br>
                        <input type="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Mot de passe :</label>
                        <br>
                        <input type="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Signin" class="btn btn-primary">
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

</html>