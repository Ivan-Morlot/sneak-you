<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Authentification administrateur</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/fontastic.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <link rel="stylesheet" href="../css/style.default.css" id="theme-stylesheet">
    <link rel="stylesheet" href="../css/admin.css">
  </head>
  <body>
    <div class="page login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <div class="col-lg-6">
              <div class="info d-flex align-items-center">
                <div class="content">
                  <div class="logo">
                    <h1>sne*k you</h1>
                    <p>Espace administrateur</p>
                    </div>
                    <?php if($result=='unauth'){echo'
                    <div>
                      <p class="error">Vous n\'êtes pas autorisé à accéder à cette partie du site, désolé !</p>
                      <a class="error-link" href="../index.php">Retour à l\'accueil</a>
                    </div>
                    ';}elseif($result=='badcreds'){echo'
                    <div>
                      <p class="error">L\'identifiant et/ou le mot de passe n\'existe(nt) pas.</p>
                    </div>
                    ';}?>
                </div>
              </div>
            </div>
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                  <form class="form-validate" action="index.php" method="post">
                    <div class="form-group">
                      <input id="register-username" type="text" name="login" required data-msg="Veuillez entrer votre e-mail administrateur" class="input-material">
                      <label for="register-username" class="label-material">Login</label>
                    </div>
                    <div class="form-group">
                      <input id="register-password" type="password" name="password" required data-msg="Veuillez entrer votre mot de passe" class="input-material">
                      <label for="register-password" class="label-material">Mot de passe</label>
                    </div>
                    <div class="form-group">
                      <button id="regidter" type="submit" name="registerSubmit" class="btn btn-primary">Se connecter</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"> </script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.cookie.js"> </script>
    <script src="../js/Chart.min.js"></script>
    <script src="../js/jquery.validate.min.js"></script>
    <script src="../js/front.js"></script>
    <script src="../js/tools.js"></script>
  </body>
</html>