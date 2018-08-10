<?php
    session_start();

    require_once "../utils/adminCheck.php";    
    
    require_once "../utils/connection.php";
    
    require "models/categoryModel.php";
    
    $createDiv = '';
    
    $displayDiv = '';

    $result = '';

    $createDiv .= '
        <form enctype="multipart/form-data" action="category.php?req=create" method="post">
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
        </form>
    ';

    if (isset($_GET['req']) && $_GET['req'] == 'update' &&
        isset($_POST['id']) &&
        isset($_POST['name'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        if(isset($_POST['description']) && $_POST['description'] != "") {
            $description = "'".$_POST['description']."'";
        } else {
            $description = 'NULL';
        }
        updateCat($db, $name, $description, $id);
        $displayDiv .= '
            <br><h4> La catégorie "'.$name.'" a été éditée avec succès.</h4>
        ';
    }

    if(isset($_GET['req']) && $_GET['req'] == 'delete' && isset($_GET['id'])) {
        $id = $_GET['id'];
        deleteCat($db, $id);
    }

    if (isset($_GET['req']) && $_GET['req'] == 'create' &&
        isset($_POST['name'])) {
        $name = $_POST['name'];
        if(isset($_POST['description']) && $_POST['description'] != "") {
            $dispDescription = $_POST['description'];
            $description = "'".$dispDescription."'";
        } else {
            $description = 'NULL';
        }
        insertCat($db, $name, $description);
        $createDiv .= '
            <br><h4>Catégorie créée avec succès.</h4>
            <p><b>Récapitulatif :</b></p>
            <table class="post-table">
                <tr>
                    <td>Nom</td>
                    <td>
                    '.$name.'
                    </td>
                </tr>
        ';
        if($description != 'NULL') {
            $createDiv .= '
                <tr>
                    <td>Description</td>
                    <td>
                        '.$dispDescription.'
                    </td>
                </tr>
            ';
        }
        $createDiv .= '
            </table>
        ';
    }

    if(isset($_GET['req']) && $_GET['req'] == 'edit' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $req = selectCat($db, $id);

        if($cat = $req->fetch(PDO::FETCH_ASSOC)) {
            $displayDiv .= '
                <table class="display-table">
                    <tr>
                        <td>ID</td>
                        <td>Nom</td>
                        <td>Description</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            '.$cat['id'].'
                        </td>
                        <td>
                            '.$cat['name'].'
                        </td>
                        <td>
                            '.$cat['description'].'
                        </td>
                        <div class="modal fade" id="confirm-del-modal-'.$cat['id'].'" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="exampleModalLabel">Supprimer une catégorie</h4>
                                </div>
                                <div class="modal-body">
                                    Vous êtes sur le point de supprimer la catégorie "'.$cat['name'].'".
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-primary" href="category.php?req=delete&id='.$cat['id'].'">Supprimer</a>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <td><a href="#" data-toggle="modal" data-target="#confirm-del-modal-'.$cat['id'].'">Supprimer</a></td>
                    </tr>
                </table>
                <br>
                <form action="category.php?req=update&id='.$cat['id'].'" method="post">
                    <table class="post-table">
                        <tr>
                            <td>ID</td>
                            <td><input type="text" name="id" value="'.$id.'" style="background-color: lightgrey" readonly></td>
                        </tr>
                        <tr>
                            <td>Editer le nom</td>
                            <td><input type="text" name="name" maxlength="30" value="'.$cat['name'].'" required></td>
                        </tr>
                        <tr>
                            <td>Editer la description</td>
                            <td><textarea name="description" maxlength="1000" cols="30" rows="5" style="resize:none">'.$cat['description'].'</textarea></td>
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
            ';
        }
    } else {
        if(isset($_POST['research'])) {
            $search = trim($_POST['research']);
            $req = reqSearchCat($db, $search);
        } else {
            $req = reqAllCat($db);
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
                            <div class="modal fade" id="confirm-del-modal-'.$cat['id'].'" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title" id="exampleModalLabel">Supprimer une catégorie</h4>
                                    </div>
                                    <div class="modal-body">
                                        Vous êtes sur le point de supprimer la catégorie "'.$cat['name'].'".
                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-primary" href="category.php?req=delete&id='.$cat['id'].'">Supprimer</a>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <td><a href="#" data-toggle="modal" data-target="#confirm-del-modal-'.$cat['id'].'">Supprimer</a></td>
                            <td><a href="category.php?id='.$cat['id'].'&req=edit">Editer</a></td>
                        </tr>';
        }
        $req->closeCursor();
        $displayDiv .= '
            <table class="display-table">
                <tr>
                    <td>ID</td>
                    <td>Nom</td>
                    <td>Description</td>
                    <td></td>
                    <td></td>
                </tr>
                '.$result.'
            </table>
        ';
    }

    require("vues/categoryVue.php");