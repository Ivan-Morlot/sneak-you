<? php
    
    session_start();

echo "

<!DOCTYPE html>
<html lang='fr'>
<head>
<meta charset='utf-8'>
<title>resume</title>
</head>
<body>
<p> Vous êtes : $_SESSION['login'] & PASS : $_SESSION['pass']; </p>
<p> Votre âge est : </p>
</body>
</html>


";