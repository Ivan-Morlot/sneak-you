<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Utilisateurs</title>
</head>

<body>
    <form action="chercherEtudiant.php" method="post">
        <label for="recherche">Mot clé :</label>
        <input type="text" name="recherche">
        <button type="submit">Rechercher</button>
    </form>
    <?php
        require_once("connexion.php");
        $req = "SELECT * FROM etudiant";
        $recordset = mysqli_query($conn, $req) or die(mysqli_connect_error);
    ?>
        <table border="1">
            <tr>
                <td>Code</td>
                <td>Nom</td>
                <td>Email</td>
                <td>Photo</td>
                <?php if($_SESSION['niveau'] == 1) {?>
                <td></td>
                <td></td>
                <?php } ?>
            </tr>
            <?php while($etudiant = mysqli_fetch_assoc($recordset)) { ?>
            <tr>
                <td>
                    <?php echo $etudiant['code'] ?>
                </td>
                <td>
                    <?php echo $etudiant['nom'] ?>
                </td>
                <td>
                    <?php echo $etudiant['email'] ?>
                </td>
                <td><img src="images/<?php echo $etudiant['photo'] ?>"></td>
                <?php if($_SESSION['niveau'] == 1) {?>
                <td><a href="supprimerEtudiant.php?code=<?php echo $etudiant['code'] ?>">Supprimer</a></td>
                <td><a href="editerEtudiant.php?code=<?php echo $etudiant['code'] ?>">Editer</a></td>
                <?php } ?>
            </tr>
            <?php } ?>
        </table>
        <?php if($_SESSION['niveau'] == 1) {?> <a href="saisieEtudiant.php">Ajouter un étudiant</a><?php } ?>
        <a href="index.html">Déconnection</a>
</body>

</html>
