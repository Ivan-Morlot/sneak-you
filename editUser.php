<?php session_start(); require_once("utils\connection.php"); require_once("utils\adminCheck.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Editer profil utilisateur</title>
</head>
<body>
<?php
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $req = $db->query("SELECT * FROM customer WHERE (id = $id)");
    }
?>
    <table border="1">
        <tr>
            <td>ID</td>
            <td>Civilité</td>
            <td>Prénom</td>
            <td>Nom</td>
            <td>E-mail</td>
            <td>Niveau d'accès au site</td>
            <td>Date de naissance</td>
            <td>Tél. principal</td>
            <td>Tél. secondaire</td>
            <td>Adresse</td>
            <td>Code postal</td>
            <td>Ville</td>
            <td></td>
        </tr>
<?php if($user = $req->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td>
                <?php echo $user['id'] ?>
            </td>
            <td>
                <?php echo $user['gender'] ?>
            </td>
            <td>
                <?php echo $user['prenom'] ?>
            </td>
            <td>
                <?php echo $user['nom'] ?>
            </td>
            <td>
                <?php echo $user['email'] ?>
            </td>
            <td>
                <?php echo $user['auth_level'] ?>
            </td>
            <td>
                <?php echo $user['birthdate'] ?>
            </td>
            <td>
                <?php echo $user['main_phone_number'] ?>
            </td>
            <td>
                <?php echo $user['secondary_phone_number'] ?>
            </td>
            <td>
                <?php echo $user['delivery_address'] ?>
            </td>
            <td>
                <?php echo $user['del_postal_code'] ?>
            </td>
            <td>
                <?php echo $user['del_city'] ?>
            </td>
            <td><a href="deleteUser.php?id=<?php echo $user['id'] ?>">Supprimer</a></td>
        </tr>
<?php } ?>
    </table>
    <br>
    <form action="updateUser.php" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" value="<?php echo $id ?>" style="background-color: lightgrey" readonly>
        <br>
        <label for="gender">Changer la civilité</label>
        <input type="radio" name="gender" id="f" value="F" <?php if($user['gender'] == 'F') echo 'checked' ?> required>
        <label for="f">Mme</label>
        <input type="radio" name="gender" id="m" value="M" <?php if($user['gender'] == 'M') echo 'checked' ?> required>
        <label for="m">M.</label>
        <br>
        <label for="nom">Editer le prénom</label>
        <input type="text" name="prenom" value="<?php echo $user['prenom'] ?>" required>
        <br>
        <label for="nom">Editer le nom</label>
        <input type="text" name="nom" value="<?php echo $user['nom'] ?>" required>
        <br>
        <label for="email">Editer l'e-mail</label>
        <input type="email" name="email" id="email" value="<?php echo $user['email'] ?>" required>
        <br>
        <label for="confirm-email">Confirmer l'e-mail</label>
        <input type="email" name="confirm-email" oninput="checkEmail(this)" value="<?php echo $user['email'] ?>" required>
        <br>
        <label for="password">Changer le mot de passe</label>
        <input type="password" name="password" id="password">
        <br>
        <label for="confirm-password">Confirmer le mot de passe</label>
        <input type="password" name="confirm-password" oninput="checkPassword(this)">
        <br>
        <label for="auth-level">Changer le niveau d'accès au site</label>
        <select name="auth-level" required>
            <option value="0" <?php if($user['auth_level'] == 0) echo 'selected' ?>>Utilisateur</option>
            <option value="1" <?php if($user['auth_level'] == 1) echo 'selected' ?>>Administrateur</option>
        </select>
        <br>
        <label for="birthdate">Ajouter / Editer la date de naissance</label>
        <input type="date" name="birthdate" value="<?php echo $user['birthdate'] ?>">
        <br>
        <label for="main-phone">Editer le tél. principal</label>
        <input type="text" name="main-phone" maxlength="10" oninput="checkPhoneNumber(this)" value="<?php echo $user['main_phone_number'] ?>" required>
        <br>
        <label for="sec-phone">Ajouter / Editer le tél. secondaire</label>
        <input type="text" name="sec-phone" maxlength="10" oninput="checkPhoneNumber(this)" value="<?php echo $user['secondary_phone_number'] ?>">
        <br>
        <label for="address">Editer l'adresse</label>
        <textarea name="address" cols="30" rows="3" style="resize:none" required><?php echo $user['delivery_address'] ?></textarea>
        <br>
        <label for="postal-code">Editer le code postal</label>
        <input type="text" name="postal-code" maxlength="5" oninput="checkPostalCode(this)" value="<?php echo $user['del_postal_code'] ?>" required>
        <br>
        <label for="city">Editer la ville</label>
        <input type="text" name="city" value="<?php echo $user['del_city'] ?>" required>
        <br>
        <button type="submit">Valider</button>
        <button type="reset">Annuler</button>
    </form>
    <br>
    <a href="adminZone.php">Accueil admin</a>
    <br>
    <a href="displayUser.php">Afficher les utilisateurs</a>
    <br>
    <a href="utils/logout.php">Déconnection</a>
    <script src="js/tools.js"></script>
</body>
</html>