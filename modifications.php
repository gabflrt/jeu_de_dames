<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Modification des données personnelles</title>
        <meta charset="utf-8">
        <script src="https://kit.fontawesome.com/c66a18dd77.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php
            include 'header.php'
        ?>
        
        <?php
        include 'database.php';
        global $db;
        ?>
        
        
        <p>Modification des données personnelles <br></p>
        <form method="post">
            <input id="prenom" name="prenom" type="text" placeholder="Prénom : <?=$_SESSION['prenom']?>" ><br/>
            <input id="nom" name="nom" type="text" placeholder="Nom : <?=$_SESSION['nom']?>" ><br/>
            <p>Date de naissance</p>
            <input id="date_naissance" name="date_naissance" type="date" value="<?=$_SESSION['date_naissance']?>" min="1910-01-01" max="2022-05-01"  ><br/>
            <input id="pseudo" name="pseudo" type="text" placeholder="Pseudo : <?=$_SESSION['pseudo']?>" ><br/>
            <input id="mail" name="mail" type="text" placeholder="Mail : <?=$_SESSION['mail']?>" ><br/>
            <input id="mdp" name="mdp" type="password" placeholder="Votre nouveau Mot de passe" ><br/>
            <input id="mdp2" name="mdp2" type="password" placeholder="Confirmer votre nouveau Mot de passe" ><br/>
            <p>Photo de profil</p>
            <input id="photo_de_profil" name="photo_de_profil" type="file" accept="image/*" ><br/>
            <input type="submit" name="formsend" id="formsend" value="OK">
        </form>
        <?php 
            include 'modif.php';
        ?>
        
        </p>
    </body>
</html>