<?php
    session_start();

    require_once "admin-check.php";
    
    require_once "../utils/connection.php";
    
    require "models/userModel.php";
    
    $createDiv = '';
    
    $displayDiv = '';

    $result = '';

    $createDiv .= '
        <form enctype="multipart/form-data" action="user.php?req=create" method="post">
            <table class="post-table">
                <tr>
                    <td>Civilité</td>
                    <td>
                        <input type="radio" name="gender" id="f" value="F" required>
                        <label for="f">Mme</label>
                        <input type="radio" name="gender" id="m" value="M" required>
                        <label for="m">M.</label>
                    </td>
                </tr>
                <tr>
                    <td>Prénom</td>
                    <td><input type="text" name="firstname" maxlength="30" required></td>
                </tr>
                <tr>
                    <td>Nom</td>
                    <td><input type="text" name="lastname" maxlength="30" required></td>
                </tr>
                <tr>
                    <td>E-mail</td>
                    <td><input type="email" name="email" id="email" onblur="checkEmail(\'confirm-email\', \'email\')" required></td>
                </tr>
                <tr>
                    <td>Confirmer l\'e-mail</td>
                    <td><input type="email" name="confirm-email" maxlength="50" id="confirm-email" onblur="checkEmail(\'confirm-email\', \'email\')" required></td>
                </tr>
                <tr>
                    <td>Mot de passe</td>
                    <td><input type="password" name="password" id="password" onblur="checkPassword(\'confirm-password\', \'password\')" required></td>
                </tr>
                <tr>
                    <td>Confirmer le mot de passe</td>
                    <td><input type="password" name="confirm-password" id="confirm-password" onblur="checkPassword(\'confirm-password\', \'password\')" required></td>
                </tr>
                <tr>
                    <td>Niveau d\'accès au site</td>
                    <td>
                        <select name="auth-level" required>
                            <option selected disabled></option>
                            <option value="0">Utilisateur</option>
                            <option value="1">Administrateur</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Date de naissance</td>
                    <td><input type="date" name="birthdate"></td>
                </tr>
                <tr>
                    <td>Tél. principal</td>
                    <td><input type="text" name="main-phone" maxlength="10"  size="10" oninput="checkPhoneNumber(this)" required></td>
                </tr>
                <tr>
                    <td>Tél. secondaire</td>
                    <td><input type="text" name="sec-phone" maxlength="10"  size="10" oninput="checkPhoneNumber(this)"></td>
                </tr>
                <tr>
                    <td>Adresse</td>
                    <td><textarea name="address" maxlength="100" cols="30" rows="3" style="resize:none"></textarea></td>
                </tr>
                <tr>
                    <td>Code postal</td>
                    <td><input type="text" name="postal-code" maxlength="5" size="5" oninput="checkPostalCode(this)"></td>
                </tr>
                <tr>
                    <td>Ville</td>
                    <td><input type="text" name="city" maxlength="30"></td>
                </tr>
                <tr>
                    <td>Complément d\'adresse</td>
                    <td><textarea name="address-supp" maxlength="100" cols="30" rows="2" style="resize:none"></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <span>Bâtiment</span>
                        <span>Escalier</span>
                        <span>Etage</span>
                        <span>Porte</span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="text" name="building" maxlength="3" size="3">
                        <input type="text" name="staircase" maxlength="3" size="3">
                        <input type="text" name="floor" maxlength="3" size="1">
                        <input type="text" name="door" maxlength="3" size="1">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Enregistrer"></td>
                </tr>
            </table>
        </form>
    ';

    if(isset($_GET['req']) && $_GET['req'] == 'delete' && isset($_GET['id'])) {
        $id = $_GET['id'];
        deleteUsr($db, $id);
    }

    if (isset($_GET['req']) && $_GET['req'] == 'create' &&
        isset($_POST['gender']) &&
        isset($_POST['firstname']) &&
        isset($_POST['lastname']) &&
        isset($_POST['email']) &&
        isset($_POST['password']) &&
        isset($_POST['auth-level']) &&
        isset($_POST['main-phone'])) {
        $email = $_POST['email'];
        
        $reqCheckEmail = $db->query("SELECT email FROM customer WHERE email = '$email'");
        if($tempCheckEmail = $reqCheckEmail->fetch(PDO::FETCH_ASSOC)) {
            $checkEmail = $tempCheckEmail['email'];
        }

        if (!isset($checkEmail) || $checkEmail === "") {
            $gender = $_POST['gender'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $password = md5($_POST['password']);
            $authLevel = $_POST['auth-level'];
            $mainPhone = $_POST['main-phone'];
            if(isset($_POST['address']) && $_POST['address'] != "") {$dispAddress = $_POST['address']; $address = "'".$dispAddress."'";} else {$address = 'NULL';}
            if(isset($_POST['postal-code']) && $_POST['postal-code'] != "") {$dispPostalCode = $_POST['postal-code']; $postalCode = "'".$dispPostalCode."'";} else {$postalCode = 'NULL';}
            if(isset($_POST['city']) && $_POST['city'] != "") {$dispCity = $_POST['city']; $city = "'".$dispCity."'";} else {$city = 'NULL';}
            if(isset($_POST['birthdate']) && $_POST['birthdate'] != "") {$dispBirthdate = $_POST['birthdate']; $birthdate = "'".$dispBirthdate."'";} else {$birthdate = 'NULL';}
            if(isset($_POST['sec-phone']) && $_POST['sec-phone'] != "") {$dispSecPhone = $_POST['sec-phone']; $secPhone = "'".$dispSecPhone."'";} else {$secPhone = 'NULL';}
            if(isset($_POST['address_supp']) && $_POST['address_supp'] != "") {$dispAddressSupp = $_POST['address_supp']; $addressSupp = "'".$dispAddressSupp."'";} else {$addressSupp = 'NULL';}
            if(isset($_POST['building']) && $_POST['building'] != "") {$dispBuilding = $_POST['building']; $building = "'".$dispBuilding."'";} else {$building = 'NULL';}
            if(isset($_POST['staircase']) && $_POST['staircase'] != "") {$dispStaircase = $_POST['staircase']; $staircase = "'".$dispStaircase."'";} else {$staircase = 'NULL';}
            if(isset($_POST['floor']) && $_POST['floor'] != "") {$dispFloor = $_POST['floor']; $floor = "'".$dispFloor."'";} else {$floor = 'NULL';}
            if(isset($_POST['door']) && $_POST['door'] != "") {$dispDoor = $_POST['door']; $door = "'".$dispDoor."'";} else {$door = 'NULL';}
            insertUsr($db, $gender, $firstname, $lastname, $email, $password, $authLevel, $birthdate, $mainPhone, $secPhone, $address, $postalCode, $city, $addressSupp, $building, $staircase, $floor, $door);
            $createDiv .= '
                <br><h4>Utilisateur créée avec succès.</h4>
                <p><b>Récapitulatif :</b></p>
                <table class="post-table">
                    <tr>
                        <td>Civilité</td>
                        <td>
                            '.$gender.'
                        </td>
                    </tr>
                    <tr>
                        <td>Prénom</td>
                        <td>
                            '.$firstname.'
                        </td>
                    </tr>
                    <tr>
                        <td>Nom</td>
                        <td>
                            '.$lastname.'
                        </td>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td>
                            '.$email.'
                        </td>
                    </tr>
                    <tr>
                        <td>Niveau d\'accès au site</td>
                        <td>
                            '.dispUsrAuthLevel($authLevel).'
                        </td>
                    </tr>
            ';
            if($birthdate != 'NULL')
                $createDiv .= '
                    <tr>
                        <td>Date de naissance</td>
                        <td>
                            '.$dispBirthdate.'
                        </td>
                    </tr>
                ';
            $createDiv .= '
                    <tr>
                        <td>Tél. principal</td>
                        <td>
                            '.$mainPhone.'
                        </td>
                    </tr>
            ';
            if($secPhone != 'NULL')
                $createDiv .= '
                    <tr>
                        <td>Tél. secondaire</td>
                        <td>
                            '.$dispSecPhone.'
                        </td>
                    </tr>
                ';
            if($address != 'NULL')
                $createDiv .= '
                    <tr>
                        <td>Adresse</td>
                        <td>
                            '.$dispAddress.'
                        </td>
                    </tr>
                ';
            if($postalCode != 'NULL')
                $createDiv .= '
                    <tr>
                        <td>Code postal</td>
                        <td>
                            '.$dispPostalCode.'
                        </td>
                    </tr>
                ';
            if($city != 'NULL')
                $createDiv .= '
                    <tr>
                        <td>Ville</td>
                        <td>
                            '.$dispCity.'
                        </td>
                    </tr>
                ';
            if($addressSupp != 'NULL')
                $createDiv .= '
                    <tr>
                        <td>Complément d\'adresse</td>
                        <td>
                            '.$dispAdressSupp.'
                        </td>
                    </tr>
                ';
            if($building != 'NULL')
                $createDiv .= '
                    <tr>
                        <td>Bâtiment</td>
                        <td>
                            '.$dispBuilding.'
                        </td>
                    </tr>
                ';
            if($staircase != 'NULL')
                $createDiv .= '
                    <tr>
                        <td>Escalier</td>
                        <td>
                            '.$dispStaircase.'
                        </td>
                    </tr>
                ';
            if($floor != 'NULL')
                $createDiv .= '
                    <tr>
                        <td>Etage</td>
                        <td>
                            '.$dispFloor.'
                        </td>
                    </tr>
                ';
            if($door != 'NULL')
                $createDiv .= '
                    <tr>
                        <td>Porte</td>
                        <td>
                            '.$dispDoor.'
                        </td>
                    </tr>
                ';
            $createDiv .= '
                </table>
            ';
        } else {
            $createDiv .= '
                <br><h4>Création impossible : e-mail déjà existant.</h4>
            ';
        }
    }

    if(isset($_POST['research'])) {
        $search = trim($_POST['research']);
        $req = reqSearchUsr($db, $search);
    } else {
        $req = reqAllUsr($db);
    }

    while($usr = $req->fetch(PDO::FETCH_ASSOC)) {
        $result .= '<tr>
                        <td>
                            '.$usr['id'].'
                        </td>
                        <td>
                            '.$usr['gender'].'
                        </td>
                        <td>
                            '.$usr['firstname'].'
                        </td>
                        <td>
                            '.$usr['lastname'].'
                        </td>
                        <td>
                            '.$usr['email'].'
                        </td>
                        <td>
                            '.dispUsrAuthLevel($usr['auth_level']).'
                        </td>
                        <td>
                            '.$usr['birthdate'].'
                        </td>
                        <td>
                            '.$usr['main_phone_number'].'
                        </td>
                        <td>
                            '.$usr['secondary_phone_number'].'
                        </td>
                        <td>
                            '.$usr['delivery_address'].'
                        </td>
                        <td>
                            '.$usr['del_postal_code'].'
                        </td>
                        <td>
                            '.$usr['del_city'].'
                        </td>
                        <td>
                            '.$usr['del_address_supp'].'
                        </td>
                        <td>
                            '.$usr['del_building'].'
                        </td>
                        <td>
                            '.$usr['del_staircase'].'
                        </td>
                        <td>
                            '.$usr['del_floor'].'
                        </td>
                        <td>
                            '.$usr['del_door'].'
                        </td>
                        <div class="modal fade" id="confirm-del-modal-'.$usr['id'].'" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="exampleModalLabel">Supprimer un utilisateur</h4>
                                </div>
                                <div class="modal-body">
                                    Vous êtes sur le point de supprimer l\'utilisateur "'.$usr['firstname'].' '.$usr['lastname'].'".
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-primary" href="user.php?req=delete&id='.$usr['id'].'">Supprimer</a>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <td><a href="#" data-toggle="modal" data-target="#confirm-del-modal-'.$usr['id'].'">Supprimer</a></td>
                    </tr>';
    }
    $req->closeCursor();
    $displayDiv .= '
        <table class="display-table">
            <tr>
                <td>ID</td>
                <td>Civilité</td>
                <td>Prénom</td>
                <td>Nom</td>
                <td>E-mail</td>
                <td>Niveau d\'accès au site</td>
                <td>Date de naissance</td>
                <td>Tél. principal</td>
                <td>Tél. secondaire</td>
                <td>Adresse</td>
                <td>Code postal</td>
                <td>Ville</td>
                <td>Complément d\'adresse</td>
                <td>Bâtiment</td>
                <td>Escalier</td>
                <td>Etage</td>
                <td>Porte</td>
                <td></td>
            </tr>
            '.$result.'
        </table>
    ';

    require("vues/userVue.php");