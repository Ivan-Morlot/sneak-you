<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Utilisateur ajouté</title>
</head>

<body>
    <?php
    
        if (isset($_FILES['photo']) && isset($_POST['nom']) && isset($_POST['email'])) {
            $dossierDest = 'images/';
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $nomPhoto = $_FILES['photo']['name'];
            require_once("connexion.php");
            move_uploaded_file($_FILES['photo']['tmp_name'], $dossierDest.$nomPhoto);
            $req = "INSERT INTO etudiant(nom,email,photo) VALUES ('$nom','$email','$nomPhoto')";
            mysqli_query($conn, $req) or die(mysqli_connect_error());
    ?>

        <table border="1">
            <tr>
                <td>Nom</td>
                <td>
                    <?php echo $nom ?>
                </td>
            </tr>
            <tr>
                <td>Email</td>
                <td>
                    <?php echo $email ?>
                </td>
            </tr>
            <tr>
                <td>Photo</td>
                <td><img src="images/<?php echo $nomPhoto ?>"></td>
            </tr>
        </table>

    <?php
        } else {
           echo 'erreur';
        }
    ?>
    <?php if($_SESSION['niveau'] == 1) {?> <a href="saisieEtudiant.php">Ajouter un étudiant</a> <?php } ?>
    <a href="afficherEtudiant.php">Afficher les étudiants</a>
    <a href="index.html">Déconnection</a>
</body>

</html>
