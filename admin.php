<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Authentification administrateur</title>
</head>
<body>
    <form action="adminAuth.php" method="post">
        <table>
            <tr>
                <td>
                    <label for="login">Login :</label>
                </td>
                <td>
                    <input type="text" name="login">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="password">Mot de passe :</label>
                </td>
                <td>
                    <input type="password" name="password">
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit" style="display: block;">Valider</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>