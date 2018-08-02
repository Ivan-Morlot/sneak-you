<?php
  session_start();

  require_once "utils/connection.php";

  $products = array();
  $prdCatNames = array();
  $prdBrdNames = array();
  $prdSizIds = array();
  
  $reqCat = $db->query("SELECT * FROM category");
  $reqBrd = $db->query("SELECT * FROM brand");
  
  $reqPrd = $db->query("SELECT * FROM product");
  $reqPrdCount = $db->query("SELECT count(*) FROM product");
  
  if($prdCount = $reqPrdCount->fetch(PDO::FETCH_ASSOC));
  
  while($prd = $reqPrd->fetch(PDO::FETCH_ASSOC)) {
	for($i = 1; $i <= (int)$prdCount['count(*)']; $i++) {
		$productId = $prd['id'];
		$productCatId = $prd['category_id'];
		$productBrdId = $prd['brand_id'];
		
		$products[$productId] = $prd;
		
		$reqPrdCatName = $db->query("SELECT name FROM category WHERE id = $productCatId");
		$reqPrdBrdName = $db->query("SELECT name FROM brand WHERE id = $productBrdId");
		$reqPrdSizes = $db->query("SELECT ps.id FROM product_size ps INNER JOIN size s WHERE ps.product_id = '$productId' AND ps.size_id = s.id");
		
		if($tempCat = $reqPrdCatName->fetch(PDO::FETCH_ASSOC)) {
			$prdCatNames[$productId] = $tempCat['name'];
		}
		if($tempBrd = $reqPrdBrdName->fetch(PDO::FETCH_ASSOC)) {
			$prdBrdNames[$productId] = $tempBrd['name'];
		}

		$tempIds = array();
		while($oneOfThisPrdSizes = $reqPrdSizes->fetch(PDO::FETCH_ASSOC)) {
			$tempIds[] = $oneOfThisPrdSizes['id'];
		}
		$reqPrdSizes->closeCursor();

		$prdSizIds[$productId] = implode(",", $tempIds);
	}
  }
  $reqPrd->closeCursor();
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
	<title>sne*k you - E-shop</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link href="css/modal.css" rel="stylesheet">
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
<?php if(isset($_POST['ordered-prd'])) {
	$orderedPrd = (string)$_POST['ordered-prd'];
	if(!isset($_SESSION['cart'])) {
		$_SESSION['cart'] = array();
		$_SESSION['cart']['product'] = array();
		$_SESSION['cart']['product_qty'] = array();
	}
	
	if (isset($_SESSION['cart'])) {
		$productPos = array_search($orderedPrd, $_SESSION['cart']['product']);
		if ($productPos !== false) {
			$_SESSION['cart']['product_qty'][$productPos] += 1 ;
		} else {
			array_push( $_SESSION['cart']['product'],$orderedPrd);
			array_push( $_SESSION['cart']['product_qty'],1);
		}
	}
?>
		<div class="added-to-cart fadeout">
			<i class="fa fa-check" aria-hidden="true"></i> Produit ajouté au panier
		</div>
<?php } ?>
		<section id="portfolio-container" class="padding-60">
			<div id="product-container" class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="text-center">
							<h1 class="padding-b-25">
								<i>Choose your sneakers !</i>
							</h1>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="text-center">
						<div class="toolbar mb2 mt2 padding-b-25" style="display: flex; flex-wrap: wrap">
							<button class="btn fil-cat btn-tmp" data-rel="month">Sélection du mois</button>
							<button class="btn fil-cat btn-tmp" data-rel="promo">En promotion</button>
						</div>
					</div>
					<div class="text-center">
						<div class="toolbar mb2 mt2 padding-b-25" style="display: flex; flex-wrap: wrap">
<?php while($cat = $reqCat->fetch(PDO::FETCH_ASSOC)) { ?>
							<button class="btn fil-cat btn-cat" data-rel="<?= str_replace(' ','',strtolower($cat['name'])) ?>"><?= $cat['name'] ?></button>
<?php } ?>
							<div class="dropdown">
								<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
								aria-expanded="false">
								Marques <span class="caret"></span>
							</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
<?php while($brd = $reqBrd->fetch(PDO::FETCH_ASSOC)) { ?>
								<button class="btn dropdown-item fil-cat btn-brd" data-rel="<?= str_replace(' ','',strtolower($brd['name'])) ?>"><?= $brd['name'] ?></button>
<?php } ?>
							</div>
							</div>
							<button class="btn fil-cat btn-all active" data-rel="all-cat">Tout</button>
						</div>
					</div>
<?php foreach($products as $product) {
	$thisProductId = $product['id'];
?>			
					<div class="modal fade" id="<?= $product['ref'] ?>" tabindex="-1" role="dialog" aria-labelledby="<?= $product['ref'] ?>" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-body">
									<div class="card">
										<div class="container-fliud">
											<div class="wrapper row">
												<div class="preview col-md-6">
													<div class="preview-pic tab-content">
														<div class="tab-pane active" id="<?= $product['ref'] ?>-pic-1">
															<img src="img/<?= $product['picture_name'] ?>" />
														</div>
													</div>
												</div>
												<div class="details col-md-6">
													<h3 class="product-title"><?= $product['name'] ?></h3>
													<div class="rating">
														<div class="stars">
															<span class="fa fa-star checked"></span>
															<span class="fa fa-star checked"></span>
															<span class="fa fa-star checked"></span>
															<span class="fa fa-star"></span>
															<span class="fa fa-star"></span>
														</div>
														<span class="review-no">Pas encore de revue</span>
													</div>
													<p class="product-description"><?= $product['description'] ?></p>
													<h4 class="price">Prix :
														<span><?= $product['price'] ?>€</span>
													</h4>
													<p class="vote">
														<strong>100%</strong> de nos utilisateurs ont aimé ce produit !
														<strong>(1 vote(s))</strong>
													</p>
													<h5 class="sizes">Taille à commander :</h5>
													<form action="product.php" method="post">
														<select name="ordered-prd" required>
															<option selected disabled value="">Sélectionnez une taille</option>
<?php
		$prdSizeIds = explode(",", $prdSizIds[$thisProductId]);

		foreach($prdSizeIds as $prdSizeId) {
			$reqPrdSize = $db->query("SELECT * FROM product_size WHERE id = '$prdSizeId'");
			if($prdSize = $reqPrdSize->fetch(PDO::FETCH_ASSOC)) {
				$sizeId = $prdSize['size_id'];
			}
			$reqSizeName = $db->query("SELECT size FROM size WHERE id = '$sizeId'");
			if($sizeName = $reqSizeName->fetch(PDO::FETCH_ASSOC)) {
?>
															<option value="<?= $prdSizeId ?>"><?= $sizeName['size'] ?></option>
<?php 	
			}
		}
?>
														</select>
														<br><br>
														<div class="action">
															<button class="add-to-cart btn btn-default" type="submit">Ajouter au panier</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
<?php } ?>
					<div style="clear:both;"></div>
					<div id="portfolio">
<?php foreach($products as $product) {
		$productId = $product['id'];
		$classes = str_replace(' ','',strtolower($prdCatNames[$productId]))." ";
		
		if(isset($prdBrdNames[$productId])) {
			$classes .= str_replace(' ','',strtolower($prdBrdNames[$productId]))." ";			
		}

		if(isset($product['is_in_selection']) && $product['is_in_selection'] == '1')
			$classes .= "month ";

		if(isset($product['is_on_promo']) && $product['is_on_promo'] == '1')
			$classes .= "promo ";
?>
					<div class="tile scale-anm all-tmp all-cat all-brd <?=$classes?>advertising">
						<a href="" data-toggle="modal" data-target="#<?= $product['ref'] ?>">
							<img src="img/<?= $product['picture_name'] ?>" alt="" />
						</a>
					</div>
<?php } ?>
					</div>
					<div style="clear:both;"></div>
				</div>
			</div>
		</section>
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
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="js/ie10-viewport-bug-workaround.js"></script>
	<script src="js/tools.js"></script>
</body>

</html>