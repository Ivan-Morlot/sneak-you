<?php  ?>

    
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>mesinfos</title>
</head>
<body>
    <form action="resume.php" method="post">
    <label for="filiere">Votre filière</label>
        <input type="text" name="filiere" id="filiere">
        <br>
        <label for="age">Votre âge</label>
            <select name="age" id="age">
        <option value="15" selected>15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
                          <option value="30">30</option></select>
        <br>
               <label for="villes">Votre ville</label>
            <select name="villes" id="villes">
        <option value="" selected></option>
        <option value="Paris">Paris</option>
        <option value="Marseille">Marseille</option>
                                 <option value="Lille">Lille</option></select>
        <br>
        <button type="submit">Validez</button>
    </form>
</body>
</html>
