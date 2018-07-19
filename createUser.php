<?php session_start(); require_once("utils\adminCheck.php")?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un utilisateur</title>
</head>
<body>
    <form enctype="multipart/form-data" action="addUser.php" method="post">
        <table border="1">
            <tr>
                <td>Civilité</td>
                <td>
                    <input type="radio" name="gender" id="f" value="F" required>
                    <label for="f">Mme</label>
                    <input type="radio" name="gender" id="m" value="M" required>
                    <label for="m">M.</label>
                </td>
            </tr>
            <tr>
                <td>Prénom</td>
                <td><input type="text" name="prenom" maxlength="30" required></td>
            </tr>
            <tr>
                <td>Nom</td>
                <td><input type="text" name="nom" maxlength="30" required></td>
            </tr>
            <tr>
                <td>E-mail</td>
                <td><input type="email" name="email" id="email" onblur="checkEmail('confirm-email', 'email')" required></td>
            </tr>
            <tr>
                <td>Confirmer l'e-mail</td>
                <td><input type="email" name="confirm-email" maxlength="50" id="confirm-email" onblur="checkEmail('confirm-email', 'email')" required></td>
            </tr>
            <tr>
                <td>Mot de passe</td>
                <td><input type="password" name="password" id="password" onblur="checkPassword('confirm-password', 'password')" required></td>
            </tr>
            <tr>
                <td>Confirmer le mot de passe</td>
                <td><input type="password" name="confirm-password" id="confirm-password" onblur="checkPassword('confirm-password', 'password')" required></td>
            </tr>
            <tr>
                <td>Niveau d'accès au site</td>
                <td>
                    <select name="auth-level" required>
                        <option selected disabled></option>
                        <option value="0">Utilisateur</option>
                        <option value="1">Administrateur</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Date de naissance</td>
                <td><input type="date" name="birthdate"></td>
            </tr>
            <tr>
                <td>Tél. principal</td>
                <td><input type="text" name="main-phone" maxlength="10"  size="10" oninput="checkPhoneNumber(this)" required></td>
            </tr>
            <tr>
                <td>Tél. secondaire</td>
                <td><input type="text" name="sec-phone" maxlength="10"  size="10" oninput="checkPhoneNumber(this)"></td>
            </tr>
            <tr>
                <td>Adresse</td>
                <td><textarea name="address" maxlength="100" cols="30" rows="3" style="resize:none" required></textarea></td>
            </tr>
            <tr>
                <td>Code postal</td>
                <td><input type="text" name="postal-code" maxlength="5" size="5" oninput="checkPostalCode(this)" required></td>
            </tr>
            <tr>
                <td>Ville</td>
                <td><input type="text" name="city" maxlength="30" required></td>
            </tr>
            <tr>
                <td>Complément d'adresse</td>
                <td><textarea name="address-supp" maxlength="100" cols="30" rows="2" style="resize:none"></textarea></td>
            </tr>
            <tr>
                <td></td>
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
                <td><input type="submit" value="Enregistrer"></td>
            </tr>
        </table>
    </form>
    <br>
    <a href="displayUser.php">Afficher les utilisateurs</a>
    <br><br>
    <a href="adminZone.php">Accueil admin</a>
    <br><br>
    <a href="utils/logout.php">Déconnexion</a>
    <script src="js/tools.js"></script>
</body>
</html>