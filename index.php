<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Jeu de Dames UTBM</title>
        <meta charset="utf-8">
        <script src="https://kit.fontawesome.com/c66a18dd77.js" crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">

    </head>
    <body>
        <?php
            include 'header.php'
        ?>
        
        <h1 class="tt"> Bienvenue dans ce jeu de Dames spécial UTBM </h1>
        <p> <?php 
        if($_SESSION == true){
            echo "Content de te revoir ".$_SESSION['prenom']."!";
        }else{
            echo "Veuillez vous <a href='login.php'>connecter</a> ou vous <a href='register.php'>inscrire</a> pour commencer";
        }
            ?></p>
        <p>Crée une partie</p>
            <form method="post">
                <input class="champ" id="pseudo" name="pseudo" type="text" placeholder="Jouer avec" required><br /><br />
                <input class="button" type="submit" name="creationpartie" id="creationpartie" value="Créer">
            </form>
        <p>Ou rejoint en une</p>
        <form method="post">
            <input class="champ" id="cle_partie" name="cle_partie" type="text" placeholder="Clé de la partie" required><br /><br />
            <input class="button" type="submit" name="connexionpartie" id="connexionpartie" value="Rejoindre">
        </form>
        <?php 
            include 'creation_partie.php';
        ?>
    </body>
</html>