<?php
    session_start();

    require_once "../utils/adminCheck.php";
    
    require_once "../utils/connection.php";
    
    require "models/brandModel.php";
    
    $createDiv = '';
    
    $displayDiv = '';

    $result = '';

    $createDiv .= '
        <form enctype="multipart/form-data" action="brand.php?req=create" method="post">
            <table class="post-table">
                <tr>
                    <td>Nom</td>
                    <td><input type="text" name="name" maxlength="30" required></td>
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
        updateBrd($db, $name, $id);
        $displayDiv .= '
            <br><h4> La marque "'.$name.'" a été éditée avec succès.</h4>
        ';
    }

    if(isset($_GET['req']) && $_GET['req'] == 'delete' && isset($_GET['id'])) {
        $id = $_GET['id'];
        deleteBrd($db, $id);
    }

    if (isset($_GET['req']) && $_GET['req'] == 'create' &&
        isset($_POST['name'])) {
        $name = $_POST['name'];
        insertBrd($db, $name);
        $createDiv .= '
            <br><h4>Marque créée avec succès.</h4>
            <p><b>Récapitulatif :</b></p>
            <table class="post-table">
                <tr>
                    <td>Nom</td>
                    <td>
                    '.$name.'
                    </td>
                </tr>   
            </table>
        ';
    }

    if(isset($_GET['req']) && $_GET['req'] == 'edit' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $req = selectBrd($db, $id);

        if($brd = $req->fetch(PDO::FETCH_ASSOC)) {
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
                            '.$brd['id'].'
                        </td>
                        <td>
                            '.$brd['name'].'
                        </td>
                        <div class="modal fade" id="confirm-del-modal-'.$brd['id'].'" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="exampleModalLabel">Supprimer une marque</h4>
                                </div>
                                <div class="modal-body">
                                    Vous êtes sur le point de supprimer la marque "'.$brd['name'].'".
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-primary" href="brand.php?req=delete&id='.$brd['id'].'">Supprimer</a>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <td><a href="#" data-toggle="modal" data-target="#confirm-del-modal-'.$brd['id'].'">Supprimer</a></td>
                    </tr>
                </table>
                <br>
                <form action="brand.php?req=update&id='.$brd['id'].'" method="post">
                    <table class="post-table">
                        <tr>
                            <td>ID</td>
                            <td><input type="text" name="id" value="'.$id.'" style="background-color: lightgrey" readonly></td>
                        </tr>
                        <tr>
                            <td>Editer le nom</td>
                            <td><input type="text" name="name" maxlength="30" value="'.$brd['name'].'" required></td>
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
            $req = reqSearchBrd($db, $search);
        } else {
            $req = reqAllBrd($db);
        }

        while($brd = $req->fetch(PDO::FETCH_ASSOC)) {
            $result .= '<tr>
                            <td>
                                '.$brd['id'].'
                            </td>
                            <td>
                                '.$brd['name'].'
                            </td>
                            <div class="modal fade" id="confirm-del-modal-'.$brd['id'].'" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title" id="exampleModalLabel">Supprimer une marque</h4>
                                    </div>
                                    <div class="modal-body">
                                        Vous êtes sur le point de supprimer la marque "'.$brd['name'].'".
                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-primary" href="brand.php?req=delete&id='.$brd['id'].'">Supprimer</a>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <td><a href="#" data-toggle="modal" data-target="#confirm-del-modal-'.$brd['id'].'">Supprimer</a></td>
                            <td><a href="brand.php?id='.$brd['id'].'&req=edit">Editer</a></td>
                        </tr>';
        }
        $req->closeCursor();
        $displayDiv .= '
            <table class="display-table">
                <tr>
                    <td>ID</td>
                    <td>Nom</td>
                    <td></td>
                    <td></td>
                </tr>
                '.$result.'
            </table>
        ';
    }

    require("vues/brandVue.php");