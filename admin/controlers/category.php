<?php
    session_start();

    require_once "../admin-check.php";

    require_once "../../utils/connection.php";

    require "../models/categoryModel.php";
    
    if(isset($_POST['research'])) {
        $search = trim($_POST['research']);
        $req = reqSearch($db, $search);
    } else {
        $req = reqAll($db);
    }

    $result = "";
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
                        <td><a href="delete-category.php?id='.$cat['id'].'">Supprimer</a></td>
                        <td><a href="edit-category.php?id='.$cat['id'].'">Editer</a></td>
                    </tr>';
    }
    $req->closeCursor();

    require("../vues/categoryVue.php");