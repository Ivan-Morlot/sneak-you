<!DOCTYPE html>
   <html>
    <head>
        <title>Entrer Etudiant</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
           $conn=mysql_connect("localhost","root","") or die(mysql_error());
           mysql_select_db("db_boutique", $conn);
        ?>
        
        <?php
        
        if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['stock']) && isset($_POST['price'])&& isset($_POST['picture_name'])&& isset($_POST['is_available'])&& isset($_POST['is_on_promo'])&& isset($_POST['is_in_selection'])) {
           $name=$_POST['name'];
           $description=$_POST['description'];
           $stock=$_POST['stock'];
           $price=$_POST['price'];
           $picture=$_POST['picture_name'];
           $available=$_POST['is_available'];
           $promo=$_POST['is_on_promo'];
           $selection=$_POST['is_in_selection'];
           
           
           $req="INSERT INTO product(name,description,stock,price,picture_name,is_available,is_on_promo,is_in_selection) VALUES ('$name','$description','$stock','$price', '$picture', '$available', '$promo', '$selection')";
           mysql_query($req) or die(mysql_error());
        
           ?>
           
           <table border="1">
               <tr>
                   <td>Nom</td>
                   <td><?php echo $nom ?></td>
               </tr>
                 <tr>
                   <td>Description</td>
                   <td><?php echo $description ?></td>
               </tr>
                 <tr>
                   <td>Stock</td>
                   <td><?php echo $stock ?></td>
               </tr>
                 <tr>
                   <td>Prix</td>
                   <td><?php echo $price ?></td>
               </tr>
                 <tr>
                   <td>Image</td>
                   <td><?php echo $picture ?></td>
               </tr>
                 <tr>
                   <td>Disponibilité</td>
                   <td><?php echo $available ?></td>
               </tr>
                 <tr>
                   <td>Promo</td>
                   <td><?php echo $promo ?></td>
               </tr>
                 <tr>
                   <td>Selectionné</td>
                   <td><?php echo $selection ?></td>
               </tr>
               
           </table>
           <?php
        }else {
            echo "erreur";
        }
        ?>
        <a href="afficherProduit.php">Afficher les Produits</a>
    </body>
</html>
       