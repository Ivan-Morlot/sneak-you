<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Editer profil utilisateur</title>
</head>

<body>
    <?php
        $conn = mysqli_connect("localhost", "root", "", "examen2018") or die(mysqli_connect_error());
        $id = $_GET['id'];
        $req = "SELECT * FROM etudiant WHERE (id = $id)";
        $recordset = mysqli_query($conn, $req) or die(mysqli_connect_error);
    ?>
        <table border="1">
            <tr>
                <td>Id</td>
                <td>Nom</td>
                <td>Sexe</td>
                <td>Ville</td>
                <td>Passion</td>
                <td></td>
            </tr>
            <?php if($etudiant = mysqli_fetch_assoc($recordset)) { ?>
            <tr>
                <td>
                    <?php echo $etudiant['id'] ?>
                </td>
                <td>
                    <?php echo $etudiant['nom'] ?>
                </td>
                <td>
                    <?php echo $etudiant['sexe'] ?>
                </td>
                <td>
                    <?php echo $etudiant['ville'] ?>
                </td>
                <td>
                    <?php echo $etudiant['passion'] ?>
                </td>
                <td><a href="supprimerEtudiant.php?id=<?php echo $etudiant['id'] ?>">Supprimer</a></td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <form action="updateEtudiant.php" method="post">
        <label for="id">Id</label>
        <input type="text" name="id" value="<?php echo $id ?>" style="background-color: lightgrey" readonly>
        <br>
        <label for="nom">Editer le nom</label>
        <input type="text" name="nom" value="<?php echo $etudiant['nom'] ?>">
        <br>
        <label for="password">Editer le mot de passe</label>
        <input type="password" name="password" value="<?php echo $etudiant['password'] ?>">
        <br>
        <label for="sexe">Modifier le sexe</label>
        <input type="radio" name="sexe" id="f" value="F" <?php if($etudiant['sexe'] == 'F') echo 'checked' ?> >
        <label for="f">F</label>
        <input type="radio" name="sexe" id="m" value="M" <?php if($etudiant['sexe'] == 'M') echo 'checked' ?> >
        <label for="m">M</label>
        <br>
        <label for="ville">Modifier la ville</label>
        <select name="ville" id="ville">
            <option value="Paris" <?php if($etudiant['ville'] == 'Paris') echo 'selected' ?> >Paris</option>
            <option value="Marseille" <?php if($etudiant['ville'] == 'Marseille') echo 'selected' ?> >Marseille</option>
            <option value="Lyon" <?php if($etudiant['ville'] == 'Lyon') echo 'selected' ?> >Lyon</option>
        </select>
        <br>
        <label for="passion">Modifier la passion</label>
        <input type="radio" name="passion" id="ski" value="Ski" <?php if($etudiant['passion'] == 'Ski') echo 'checked' ?> >
        <label for="ski">Ski</label>
        <input type="radio" name="passion" id="tennis" value="Tennis" <?php if($etudiant['passion'] == 'Tennis') echo 'checked' ?> >
        <label for="tennis">Tennis</label>
        <input type="radio" name="passion" id="web" value="Web" <?php if($etudiant['passion'] == 'Web') echo 'checked' ?> >
        <label for="web">Web</label>
        <br><br>
        <button type="submit">Valider</button>
        <button type="reset">Annuler</button>
    </form>
</body>

</html>