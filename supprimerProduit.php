<!DOCTYPE html>
   <html>
    <head>
        <title>Supprimer Etudiant</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
          $conn=mysql_connect("localhost","root","") or die(mysql_error());
           mysql_select_db("examen2018", $conn);
        $code=$_GET['code'];
        $req ="DELETE FROM etudiant WHERE (code=$code)";
        
        mysql_query($req) or die(mysql_error);
        header("location:afficherEtudiant.php");
            ?>

    </body>
</html>
       