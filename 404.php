<?php
  session_start(); 
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>sne*k you - Page introuvable</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="css/404.css">
</head>

<body>
  <section class="error_section">
    <p class="error_section_subtitle">Oups, cette page n'a pas l'air bien dans ses sneakers !</p>
    <h1 class="error_title">
      <p>Page introuvable</p>
      Page introuvable
    </h1>
<?php if (isset($e)) { ?>
    <p>
      <?= $e->getMessage(); ?>
    </p>
<?php } ?>
    <a href="index.php" class="btn">Retour à l'accueil</a>
  </section>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/ie10-viewport-bug-workaround.js"></script>
  <script src="js/tools.js"></script>
  <script src="js/404.js"></script>
</body>

</html>