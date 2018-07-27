<?php
    session_start();

    require_once "admin-check.php";

    require_once "../utils/connection.php";

    require "models/categoryModel.php";
    
    $result = "";

    if(isset($_POST['research'])) {
        $search = trim($_POST['research']);
        $req = reqSearch($db, $search);
    } else {
        $req = reqAll($db);
    }

    while($cat = $req->fetch(PDO::FETCH_ASSOC)) {
        $result .= '<tr>
                        <td>
                            '.$cat['id'].'
                        </td>
                        <td>
                            '.$cat['name'].'
                        </td>
                        <td>
                            '.$cat['description'].'
                        </td>
                        <td><a href="category.php?id='.$cat['id'].'&req=delete">Supprimer</a></td>
                        <td><a href="category.php?id='.$cat['id'].'&req=edit">Editer</a></td>
                    </tr>';
    }
    $req->closeCursor();


    /*if (isset($_POST['name'])) {
        $name = $_POST['name'];
        if(isset($_POST['description']) && $_POST['description'] != "") {$dispDescription = $_POST['description']; $description = "'".$dispDescription."'";} else {$description = 'NULL';}
        $db->exec("INSERT INTO `category` (`id`, `name`, `description`) VALUES (NULL, '$name', $description)");

    echo '<p>Catégorie créée avec succès.</p>
    <p>Récapitulatif :</p>
    <table border="1">
        <tr>
            <td>Nom</td>
            <td>
                <?= $name ?>
            </td>
        </tr>';
if($description != 'NULL') {
        echo '<tr>
            <td>Description</td>
            <td>
                <?= $dispDescription ?>
            </td>
        </tr>';
}
    echo '</table>
    <br>';
    } else {
        header("location:home.php");
    }*/

    $displayVue = '<table class="display-table">
                    <tr>
                        <td>ID</td>
                        <td>Nom</td>
                        <td>Description</td>
                        <td></td>
                        <td></td>
                    </tr>'
                    .$result
                .'</table>';
    $addingVue = '<form enctype="multipart/form-data" action="category.php" method="post">
					<table class="post-table">
						<tr>
							<td>Nom</td>
							<td><input type="text" name="name" maxlength="30" required></td>
						</tr>
						<tr>
							<td>Description</td>
							<td><textarea name="description" maxlength="1000" cols="30" rows="5" style="resize:none"></textarea></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="Enregistrer"></td>
						</tr>
					</table>
				</form>';

    require("vues/categoryVue.php");