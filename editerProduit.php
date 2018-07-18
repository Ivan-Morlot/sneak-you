<?php   
    try
{
    $bdd = new PDO('mysql:host=localhost;dbname=examen2018','root','');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);}
 catch(Exception $e){
            echo '<h3>Oups ! Nous avons rencontré un problème...</h3>';
            echo '<p>' . $e->getMessage() . '</p>';            
        }

 
     
if(isset($_POST['nom']) && isset($_POST['sexe']) && isset($_POST['ville']) && isset($_POST['passion']))
{
    $sql = 'UPDATE `etudiant`
        SET
            `nom` = \''.$_POST['nom'].'\'
            `sexe` = \''.$_POST['sexe'].'\'
            `ville` = \''.$_POST['ville'].'\'
            `passion` = \''.$_POST['passion'].'\'
        WHERE
            `code` = '.$_POST['code'];
             
        }
 
 
 
 
$reponse = $bdd->query('SELECT * FROM etudiant WHERE code='.$_GET['code']);
$donnees = $reponse->fetch();
echo '<form action="" method="post">
<input type="text" name="nome" value="'.$donnees['nom'].'"/>
<input type="radio" name="sexe" value="'.$donnees['sexe'].'"/>
<select name="ville" value="'.$donnees['ville'].'"/>
<input type="radio" name="passion" value="'.$donnees['passion'].'"/>
<input type="hidden" name="code" value="'.$donnees['code'].'"/>
<input type="submit"/>';
    
 
?>
      <!DOCTYPE>
      <html>
          <body>
              <a href="afficherEtudiant.php">Afficher les étudiants</a>
          </body>
      </html>
      
      