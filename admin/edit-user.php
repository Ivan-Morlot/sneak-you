<?php session_start(); require_once("..\utils\connection.php"); require_once("..\utils\admin-check.php"); ?>

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
            <td>Complément d'adresse</td>
            <td>Bâtiment</td>
            <td>Escalier</td>
            <td>Etage</td>
            <td>Porte</td>
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
                <?php if($user['auth_level'] == 0) {echo "Utilisateur";} else if($user['auth_level'] == 1) {echo "Administrateur";} else {echo "N/A";} ?>
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
            <td>
                <?php echo $user['del_address_supp'] ?>
            </td>
            <td>
                <?php echo $user['del_building'] ?>
            </td>
            <td>
                <?php echo $user['del_staircase'] ?>
            </td>
            <td>
                <?php echo $user['del_floor'] ?>
            </td>
            <td>
                <?php echo $user['del_door'] ?>
            </td>
            <td><a href="delete-user.php?id=<?php echo $user['id'] ?>">Supprimer</a></td>
        </tr>
        <?php } ?>
    </table>
    <br>
    <form action="update-user.php" method="post">
        <table border="1">
            <tr>
                <td>ID</td>
                <td><input type="text" name="id" value="<?php echo $id ?>" style="background-color: lightgrey" readonly></td>
            </tr>
            <tr>
                <td>Changer la civilité</td>
                <td>
                    <input type="radio" name="gender" id="f" value="F" <?php if($user['gender'] == 'F') echo 'checked' ?> required>
                    <label for="f">Mme</label>
                    <input type="radio" name="gender" id="m" value="M" <?php if($user['gender'] == 'M') echo 'checked' ?> required>
                    <label for="m">M.</label>
                </td>
            </tr>
            <tr>
                <td>Editer le prénom</td>
                <td><input type="text" name="prenom" maxlength="30" value="<?php echo $user['prenom'] ?>" required></td>
            </tr>
            <tr>
                <td>Editer le nom</td>
                <td><input type="text" name="nom" maxlength="30" value="<?php echo $user['nom'] ?>" required></td>
            </tr>
            <tr>
                <td>Editer l'e-mail</td>
                <td><input type="email" name="email" maxlength="50" id="email" onblur="checkEmail('confirm-email', 'email')" value="<?php echo $user['email'] ?>" required></td>
            </tr>
            <tr>
                <td>Confirmer l'e-mail</td>
                <td><input type="email" name="confirm-email" maxlength="50" id="confirm-email" onblur="checkEmail('confirm-email', 'email')" value="<?php echo $user['email'] ?>" required></td>
            </tr>
            <tr>
                <td>Changer le mot de passe</td>
                <td><input type="password" name="password" id="password" onblur="checkPassword('confirm-password', 'password')"></td>
            </tr>
            <tr>
                <td>Confirmer le mot de passe</td>
                <td><input type="password" name="confirm-password" id="confirm-password" onblur="checkPassword('confirm-password', 'password')"></td>
            </tr>
            <tr>
                <td>Changer le niveau d'accès au site</td>
                <td>
                    <select name="auth-level" required>
                        <option value="0" <?php if($user['auth_level'] == 0) echo 'selected' ?>>Utilisateur</option>
                        <option value="1" <?php if($user['auth_level'] == 1) echo 'selected' ?>>Administrateur</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Ajouter / Editer la date de naissance</td>
                <td><input type="date" name="birthdate" value="<?php echo $user['birthdate'] ?>"></td>
            </tr>
            <tr>
                <td>Editer le tél. principal</td>
                <td><input type="text" name="main-phone" maxlength="10" size="10" oninput="checkPhoneNumber(this)" value="<?php echo $user['main_phone_number'] ?>" required></td>
            </tr>
            <tr>
                <td>Ajouter / Editer le tél. secondaire</td>
                <td><input type="text" name="sec-phone" maxlength="10" size="10" oninput="checkPhoneNumber(this)" value="<?php echo $user['secondary_phone_number'] ?>"></td>
            </tr>
            <tr>
                <td>Editer l'adresse</td>
                <td><textarea name="address" maxlength="100" cols="30" rows="3" style="resize:none" required><?php echo $user['delivery_address'] ?></textarea></td>
            </tr>
            <tr>
                <td>Editer le code postal</td>
                <td><input type="text" name="postal-code" maxlength="5" size="5" oninput="checkPostalCode(this)" value="<?php echo $user['del_postal_code'] ?>" required></td>
            </tr>
            <tr>
                <td>Editer la ville</td>
                <td><input type="text" name="city" maxlength="30" value="<?php echo $user['del_city'] ?>" required></td>
            </tr>
            <tr>
                <td>Ajouter / Editer le complément d'adresse</td>
                <td><textarea name="address-supp" maxlength="100" cols="30" rows="2" style="resize:none"></textarea></td>
            </tr>
            <tr>
                <td>Ajouter / Editer :</td>
                <td>
                    <span>Bâtiment</span>
                    <span>Escalier</span>
                    <span>Etage</span>
                    <span>Porte</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="text" name="building" maxlength="3" size="3">
                    <input type="text" name="staircase" maxlength="3" size="3">
                    <input type="text" name="floor" maxlength="3" size="1">
                    <input type="text" name="door" maxlength="3" size="1">
                </td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit">Valider</button></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="reset">Annuler</button></td>
            </tr>
        </table>
    </form>
    <br>
    <a href="display-user.php">Afficher les utilisateurs</a>
    <br><br>
    <a href="home.php">Accueil admin</a>
    <br><br>
    <a href="../utils/logout.php">Déconnection</a>
    <script src="../js/tools.js"></script>
</body>
</html>