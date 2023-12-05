<!DOCTYPE html>
<html>
    <head>
        <title>Jeu de Dames UTBM</title>
        <meta charset="utf-8">
        <script src="https://kit.fontawesome.com/c66a18dd77.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            include 'header.php'
        ?>
        
        <div class="regles">
        <h1>Règles du jeu de dames</h1>
        <h2>Règles générales</h2>
        <p>
            Chaque joueur possède 20 pions, soit blanc ou noir. Les blancs commencent toujours.
            <br>Chaque joueur va alors jouer à tour de rôle en déplaçant un de leur pion au choix devant eux d'une case en diagonale.
            <br>L'objectif est de se retrouver en présence d'un pion adverse diagonalement afin de sauter par dessus lui et occuper la case libre qui se situe après.
            <br> Une fois qu'il n'y a plus aucun pion dans une des deux équipes, la partie est fini !
        </p>

        <h2>Système de dames</h2>
        <p>
            Si vous arrivez à amener un pion jusqu'à l'autre bout du terrain, celui-ci deviendra alors une dame.
            <br>Une dame est très utile car elle permet de se déplacer diagonalement tout autant en avant qu'en arrière, mais aussi d'autant de cases qu'elle veut.
        </p>
        <h2>Détails sur la prise d'un pion</h2>
        <p>
            Durant un seul tour il est possible de prendre plusieurs pions ! Si sur votre chemin il y a plusieurs pions adverses vous pourrez alors en attraper plusieurs.
            <br>Cela est aussi possible si vous jouez une dame : vous pourrez prendre une pièce adverse, continuer à avancer en diagonale de X cases et reprendre un autre pion.
            <br>Il est aussi interdit de passer plus d'une fois au-dessus d'une pièce adverse.
            <br>Enfin, la prise du plus grand nombre de pièce est obligatoire : si vous avez un moyen dans un chemin de prendre 2 dames et dans un autre de prendre 3 pions, vous devrez forcément prendre les 3 pions.
        </p>

        <p>Bon jeu à tous, et que le meilleur gagne ! 😁🎉</p>
        </div>
    </body>
</html>