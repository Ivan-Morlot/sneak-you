<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Afficher Produit</title>
</head>
<body>
    <form action="afficherProduit.php" method="post">
        <label for="recherche">Marque, style, taille ...</label>
        <input type="text" name="recherche">
        <button type="submit">Rechercher</button>
    </form>
   <?php
    $mc = null;
    $conn = mysql_connect("localhost", "root", "") or die(mysql_error());
    mysql_select_db("db_boutique", $conn);

    if (isset($_POST['recherche'])) {
        $mc = trim($_POST['recherche']);
    }
    $req = "SELECT * FROM Product WHERE nom LIKE '%$mc%'";
    $recordset = mysql_query($req) or die(mysql_error());

    ?>
    <table border="1">
       <tr>
           <td>Code</td>
           <td>Nom</td>
           <td>Description</td>
           <td>stock</td>
           <td>price</td>
           <td>picture</td>
           <td>available</td>
           <td>promo</td>
           <td>selection</td>
           
       </tr>
        <?php while ($product = mysql_fetch_assoc($recordset)) { ?>
        <tr>
            <td><?php echo $product['code'] ?></td>
            <td><?php echo $product['name'] ?></td>
            <td><?php echo $product['description'] ?></td>
            <td><?php echo $product['stock'] ?></td>
            <td><?php echo $product['price'] ?></td>
            <td><?php echo $product['is_available'] ?></td>
            <td><?php echo $product['is_on_promo'] ?></td>
            <td><?php echo $product['is_in_selection'] ?></td>
            <td><a href="supprimerProduit.php?code=<?php echo $product['code'] ?>">Supprimer</a></td>
            <td><a href="editerProduit.php?code=<?php echo $product['code'] ?>">Editer</a></td>
        </tr>
        <?php 
    } ?>
    </table>
    <a href="index.html">Ajouter un produit</a><br>
    <a href="afficherProduit.php">Afficher les produits</a>
</body>
</html>