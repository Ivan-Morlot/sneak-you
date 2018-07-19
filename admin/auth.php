<?php session_start(); require_once("..\utils\connection.php");

    if (isset($_POST['login']) && isset($_POST['password'])) {
        $login = $_POST['login'];
        $password = md5($_POST['password']);
        $req = $db->query("SELECT * FROM customer WHERE (email = '$login' AND password = '$password')");
        if($user = $req->fetch(PDO::FETCH_ASSOC)) {
            if($user['auth_level'] == 1) {
                $_SESSION['login'] = $user['email'];
                $_SESSION['auth_level'] = $user['auth_level'];
                header("location:home.php");
            } else {
?>
                <!DOCTYPE html>
                <html lang="fr">
                <head>
                    <meta charset="UTF-8">
                    <title>Accès refusé</title>
                </head>
                <body>
                    <h1>Vous n'êtes pas autorisé à accéder à cette partie du site.</h1>
                    <a href="../index.php">Retour à l'accueil</a>
                    <script src="../js/tools.js"></script>
                </body>
                </html>
<?php
            }
        } else {
?>
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <title>Erreur d'identification</title>
            </head>
            <body>
                <h1>L'identifiant et/ou le mot de passe n'existe(nt) pas.</h1>
                <a href="index.php">Retour à l'écran de connexion</a>
                <script src="../js/tools.js"></script>
            </body>
            </html>
<?php
        }
    } else {
        header("location:home.php");
    }

