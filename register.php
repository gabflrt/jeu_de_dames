<!DOCTYPE html>
<html>
    <head>
        <title>Inscription</title>
        <meta charset="utf-8">
        <script src="https://kit.fontawesome.com/c66a18dd77.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            include 'header.php'
        ?>
        
        <?php
        include 'database.php';
        global $db;
        ?>
        
        <fieldset>
            <p>Inscription <br></p>
            <form method="post">
                <input class="register" name="prenom" type="text" placeholder="Votre Prénom" required><br/>
                <input class="register" name="nom" type="text" placeholder="Votre Nom" required><br/>
                <input class="register" name="date_naissance" type="date" value="2003-06-29" min="1910-01-01" max="2022-05-01"  ><br/>
                <input class="register" name="pseudo" type="text" placeholder="Votre Pseudo" required><br/>
                <input id="mail_register" name="mail" type="text" placeholder="Votre Email" required><br/>
                <input class="register" name="mdp" type="password" placeholder="Votre Mot de passe" required><br/>
                <input class="register" name="mdp2" type="password" placeholder="Confirmer votre Mot de passe" required><br/>
                <input id="photo_de_profil" name="photo_de_profil" type="file" accept="image/*" ><br/>
            <p> <br> Genre : <br>
                <div>
                    <input type="radio" id="radio_button_1" name="gender" value="homme"> 
                    <label for="choixHomme">Homme</label>
    
                    <input type="radio" id="radio_button_2" name="gender" value="femme"> 
                    <label for="choixFemme">Femme</label>
    
                    <input type="radio" id="radio_button_3" name="gender" value="autre"> 
                    <label for="choixAutre">Autres</label>
                </div>
                <input type="submit" name="formsend" id="formsend" value="OK">
            </form>
            <?php 
                include 'signin.php';
            ?>
            
            </p>
        </fieldset>
    </body>
</html>