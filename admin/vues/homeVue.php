<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>sne*k you - Admin</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="robots" content="all,follow">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/admin.css">
</head>

<body>
	<nav class="navbar navbar-default navbar-static-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Menu</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="home.php">
					sne*k you
				</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<form class="navbar-form navbar-left" method="GET" role="search">
					<div class="form-group">
						<input type="text" name="q" class="form-control" placeholder="Rechercher">
					</div>
					<button type="submit" class="btn btn-default">
						<i class="glyphicon glyphicon-search"></i>
					</button>
				</form>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="../index.php" target="_blank">Site public</a>
					</li>
					<li class="dropdown ">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							Profil
						<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li class="dropdown-header">MON COMPTE</li>
							<li>
								<a href="#">Paramètres</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="../utils/logout.php">Se déconnecter</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container-fluid main-container">
		<div class="col-md-2 sidebar">
			<ul class="nav nav-pills nav-stacked">
				<li>
					<a href="category.php">Gérer les catégories</a>
				</li>
				<li>
					<a href="brand.php">Gérer les marques</a>
				</li>
				<li>
					<a href="product.php">Gérer les produits</a>
				</li>
				<li>
					<a href="user.php">Gérer les utilisateurs</a>
				</li>
			</ul>
		</div>
		<div class="col-md-10 content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Assistant
				</div>
				<div class="panel-body">
					« <strong>Heureux de vous revoir maître !</strong> »
				</div>
			</div>
		</div>
		<div class="col-md-10 content">
			<div class="panel panel-default">
				<div class="panel-heading">
					Dashboard
				</div>
				<div class="panel-body">
					<p>
						<i>Rien pour le moment</i>
					</p>
				</div>
			</div>
		</div>
	</div>

	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.cookie.js"> </script>
	<script src="../js/front.js"></script>
	<script src="../js/tools.js"></script>

</body>

</html>