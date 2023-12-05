<?php session_start(); ?>
<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="refresh" content="2" />
        <script src="https://kit.fontawesome.com/c66a18dd77.js" crossorigin="anonymous"></script>
        <title>Jeu de Dames UTBM</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            include 'header.php';
            include 'database.php';
            global $db;
            $cc1="red";
            $default="gray";
            $c1=$default;
            $c2=$default;
            $c3=$default;
            $c4=$default;
            $c5=$default;
            $c6=$default;
            $c7=$default;
            $c8=$default;
            $c9=$default;
            $c10=$default;
            $c11=$default;
            $c12=$default;
            $c13=$default;
            $c14=$default;
            $c15=$default;
            $c16=$default;
            $c17=$default;
            $c18=$default;
            $c19=$default;
            $c20=$default;
            $c21=$default;
            $c22=$default;
            $c23=$default;
            $c24=$default;
            $c25=$default;
            $c26=$default;
            $c27=$default;
            $c28=$default;
            $c29=$default;
            $c30=$default;
            $c31=$default;
            $c32=$default;
            $c33=$default;
            $c34=$default;
            $c35=$default;
            $c36=$default;
            $c37=$default;
            $c38=$default;
            $c39=$default;
            $c40=$default;
            $c41=$default;
            $c42=$default;
            $c43=$default;
            $c44=$default;
            $c45=$default;
            $c46=$default;
            $c47=$default;
            $c48=$default;
            $c49=$default;
            $c50=$default;

            $j=0;
            // Affichage informations pour joueurs
            $id_partie=$_SESSION['id_partie'];
            echo "Clé de connexion : ".$_SESSION['cle_connection']." | ";
            // Chercher le nombre de coups joués
            $q = $db->prepare("SELECT coup FROM partie WHERE id =:id_partie");
            $q->execute(['id_partie' => $id_partie]);
            $rq = $q->fetch();
            $coup = $rq['coup'];
            echo "Tour : ".$coup." | ";

            // Chercher les pseudos et scores des joueurs
            $q = $db->prepare("SELECT id_joueur1, id_joueur2,score_joueur1,score_joueur2 FROM partie WHERE id =:id_partie");
            $q->execute(['id_partie' => $id_partie]);
            $rq = $q->fetch();
            $scorej1 = $rq['score_joueur1'];
            $idj1 = $rq['id_joueur1'];
            $scorej2 = $rq['score_joueur2'];
            $idj2 = $rq['id_joueur2'];
            $q = $db->prepare("SELECT pseudo FROM joueur WHERE id =:id");
            $q->execute(['id' => $idj1]);
            $rq = $q->fetch();
            $pseudoj1 = $rq['pseudo'];
            $q = $db->prepare("SELECT pseudo FROM joueur WHERE id =:id");
            $q->execute(['id' => $idj2]);
            $rq = $q->fetch();
            $pseudoj2 = $rq['pseudo'];
            // Affichage
            echo $pseudoj1." : ".$scorej1." pts | ";
            echo $pseudoj2." : ".$scorej2." pts | ";
            if($coup%2==0){
                echo "a toi de jouer ". $pseudoj1;
            }else{
                echo "a toi de jouer ". $pseudoj2;
            }

            //Vérifier si il y a une victoire
            if($scorej1>=20){
            // Suppression des cases de la partie
                $q = $db->prepare("DELETE FROM coups WHERE id_partie=:id_partie");
                $q->execute(['id_partie' => $id_partie]);
                // Mettre a jour le statut de la partie
                $q = $db->prepare("UPDATE partie SET statut = 0 WHERE id=:id_partie");     
                $q->execute(['id_partie' => $id_partie]);
                // Suprimer le cookie pour ne pas créer de problème si l'utilisateur lance une nouvelle partie
                setcookie('partie', $id_partie, time() - 3600);
                echo "<p>Le joueur 1 a gagné la partie !</p>";
                echo '<a href="index.php"><input type="submit" value="Retourner au menu principal"></a>';    
                exit(); 
            }
            if($scorej2>=20){
            // Suppression des cases de la partie
                $q = $db->prepare("DELETE FROM coups WHERE id_partie=:id_partie");
                $q->execute(['id_partie' => $id_partie]);
                // Mettre a jour le statut de la partie
                $q = $db->prepare("UPDATE partie SET statut = 0 WHERE id=:id_partie");     
                $q->execute(['id_partie' => $id_partie]);
                // Suprimer le cookie pour ne pas créer de problème si l'utilisateur lance une nouvelle partie
                setcookie('partie', $id_partie, time() - 3600);
                echo "<p>Le joueur 2 a gagné la partie !</p>";
                echo '<a href="index.php"><input type="submit" value="Retourner au menu principal"></a>';    
                exit(); 
            }
            
            // Création des design des différents types de pions
            $pion2='<input class="pion" type="image" src="images/pion2.png" name="submit">';
            $pion1='<input class="pion" type="image" src="images/pion1.png" name="submit">';
            $pion2dame='<input class="pion" type="image" src="images/pion2dame.png" name="submit">';
            $pion1dame='<input class="pion" type="image" src="images/pion1dame.png" name="submit">';           
            $deplacements='<input class="bouton" style="background-color:green;" type="submit" name="button1" id="button1" value="">';    
            $manger='<input class="bouton" style="background-color:red;" type="submit" name="button1" id="button1" value="">';

            
        include 'liste_boutons.php';
        ?>

 

    <br>
    <form method="post">
    <input class="" style="background-color:red;" type="submit" name="arreter" id="arreter" value="Supprimer la partie">
    </form>
    <?php
    include 'arreter_partie.php';
    ?>
    
    <table class="table">
        <tbody>
            <tr>
                
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c46?>;">
                    <form method="post">
                        <input type="hidden" name="b46" value="50">
                    <?php  
                    $case_abscisse=2;
                    $case_ordonnee=10;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
    
                </td>
                <td class="td" style="background-color: <?=$c47?>;">
                    <form method="post">
                        <input type="hidden" name="b47" value="50">
                    <?php  
                    $case_abscisse=4;
                    $case_ordonnee=10;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c48?>;">
                    <form method="post">
                        <input type="hidden" name="b48" value="50">
                    <?php  
                    $case_abscisse=6;
                    $case_ordonnee=10;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c49?>;">
                    <form method="post">
                        <input type="hidden" name="b49" value="50">
                    <?php  
                    $case_abscisse=8;
                    $case_ordonnee=10;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c50?>;">
                    <form method="post">
                        <input type="hidden" name="b50" value="50">
                         <?php  
                    $case_abscisse=10;
                    $case_ordonnee=10;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
            </tr>
            <tr>
                <td class="td" style="background-color: <?=$c41?>;">
                    <form method="post">
                        <input type="hidden" name="b41" value="50">
                    <?php  
                    $case_abscisse=1;
                    $case_ordonnee=9;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c42?>;">
                    <form method="post">
                        <input type="hidden" name="b42" value="50">
                    <?php  
                    $case_abscisse=3;
                    $case_ordonnee=9;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c43?>;">
                    <form method="post">
                        <input type="hidden" name="b43" value="50">
                    <?php  
                    $case_abscisse=5;
                    $case_ordonnee=9;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c44?>;">
                    <form method="post">
                        <input type="hidden" name="b44" value="50">
                    <?php  
                    $case_abscisse=7;
                    $case_ordonnee=9;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c45?>;">
                   <form method="post">
                        <input type="hidden" name="b45" value="50">
                         <?php  
                    $case_abscisse=9;
                    $case_ordonnee=9;
                    include 'pion_affiche.php';

                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
            </tr>
            <tr>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c36?>;">
                    <form method="post">
                        <input type="hidden" name="b36" value="50">
                    <?php  
                    $case_abscisse=2;
                    $case_ordonnee=8;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c37?>;">
                    <form method="post">
                        <input type="hidden" name="b37" value="50">
                    <?php  
                    $case_abscisse=4;
                    $case_ordonnee=8;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c38?>;">
                    <form method="post">
                        <input type="hidden" name="b38" value="50">
                    <?php  
                    $case_abscisse=6;
                    $case_ordonnee=8;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c39?>;">
                    <form method="post">
                        <input type="hidden" name="b39" value="50">
                    <?php  
                    $case_abscisse=8;
                    $case_ordonnee=8;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c40?>;">
                    <form method="post">
                        <input type="hidden" name="b40" value="50">
                    <?php  
                    $case_abscisse=10;
                    $case_ordonnee=8;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
            </tr>
            <tr>
                <td class="td" style="background-color: <?=$c31?>;">
                    <form method="post">
                        <input type="hidden" name="b31" value="50">
                    <?php  
                    $case_abscisse=1;
                    $case_ordonnee=7;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c32?>;">
                    <form method="post">
                        <input type="hidden" name="b32" value="50">
                    <?php  
                    $case_abscisse=3;
                    $case_ordonnee=7;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c33?>;">
                    <form method="post">
                        <input type="hidden" name="b33" value="50">
                    <?php  
                    $case_abscisse=5;
                    $case_ordonnee=7;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c34?>;">
                    <form method="post">
                        <input type="hidden" name="b34" value="50">
                    <?php  
                    $case_abscisse=7;
                    $case_ordonnee=7;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c35?>;">
                    <form method="post">
                        <input type="hidden" name="b35" value="50">
                    <?php  
                    $case_abscisse=9;
                    $case_ordonnee=7;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
            </tr>
            <tr>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c26?>;">
                    <form method="post">
                        <input type="hidden" name="b26" value="50">
                    <?php  
                    $case_abscisse=2;
                    $case_ordonnee=6;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c27?>;">
                    <form method="post">
                        <input type="hidden" name="b27" value="50">
                    <?php  
                    $case_abscisse=4;
                    $case_ordonnee=6;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c28?>;">
                    <form method="post">
                        <input type="hidden" name="b28" value="50">
                    <?php  
                    $case_abscisse=6;
                    $case_ordonnee=6;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c29?>;">
                    <form method="post">
                        <input type="hidden" name="b29" value="50">
                    <?php  
                    $case_abscisse=8;
                    $case_ordonnee=6;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c30?>;">
                    <form method="post">
                        <input type="hidden" name="b30" value="50">
                    <?php  
                    $case_abscisse=10;
                    $case_ordonnee=6;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
            </tr>
            <tr>
                <td class="td" style="background-color: <?=$c21?>;">
                    <form method="post">
                        <input type="hidden" name="b21" value="50">
                    <?php  
                    $case_abscisse=1;
                    $case_ordonnee=5;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c22?>;">
                    <form method="post">
                        <input type="hidden" name="b22" value="50">
                    <?php  
                    $case_abscisse=3;
                    $case_ordonnee=5;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c23?>;">
                    <form method="post">
                        <input type="hidden" name="b23" value="50">
                    <?php  
                    $case_abscisse=5;
                    $case_ordonnee=5;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c24?>;">
                    <form method="post">
                        <input type="hidden" name="b24" value="50">
                    <?php  
                    $case_abscisse=7;
                    $case_ordonnee=5;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c25?>;">
                    <form method="post">
                        <input type="hidden" name="b25" value="50">
                    <?php  
                    $case_abscisse=9;
                    $case_ordonnee=5;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
            </tr>
            <tr>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c16?>;">
                    <form method="post">
                        <input type="hidden" name="b16" value="50">
                    <?php  
                    $case_abscisse=2;
                    $case_ordonnee=4;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c17?>;">
                    <form method="post">
                        <input type="hidden" name="b17" value="50">
                    <?php  
                    $case_abscisse=4;
                    $case_ordonnee=4;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c18?>;">
                    <form method="post">
                        <input type="hidden" name="b18" value="50">
                    <?php  
                    $case_abscisse=6;
                    $case_ordonnee=4;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c19?>;">
                    <form method="post">
                        <input type="hidden" name="b19" value="50">
                    <?php  
                    $case_abscisse=8;
                    $case_ordonnee=4;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c20?>;">
                    <form method="post">
                        <input type="hidden" name="b20" value="50">
                    <?php  
                    $case_abscisse=10;
                    $case_ordonnee=4;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
            </tr>
            <tr>
                <td class="td" style="background-color: <?=$c11?>;">
                    <form method="post">
                        <input type="hidden" name="b11" value="50">
                    <?php  
                    $case_abscisse=1;
                    $case_ordonnee=3;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c12?>;">
                    <form method="post">
                        <input type="hidden" name="b12" value="50">
                    <?php  
                    $case_abscisse=3;
                    $case_ordonnee=3;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c13?>;">
                    <form method="post">
                        <input type="hidden" name="b13" value="50">
                    <?php  
                    $case_abscisse=5;
                    $case_ordonnee=3;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c14?>;">
                    <form method="post">
                        <input type="hidden" name="b14" value="50">
                    <?php  
                    $case_abscisse=7;
                    $case_ordonnee=3;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c15?>;">
                    <form method="post">
                        <input type="hidden" name="b15" value="50">
                    <?php  
                    $case_abscisse=9;
                    $case_ordonnee=3;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
            </tr>
            <tr>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c6?>;">
                    <form method="post">
                        <input type="hidden" name="b6" value="50">
                    <?php  
                    $case_abscisse=2;
                    $case_ordonnee=2;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c7?>;">
                    <form method="post">
                        <input type="hidden" name="b7" value="50">
                    <?php  
                    $case_abscisse=4;
                    $case_ordonnee=2;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c8?>;">
                    <form method="post">
                        <input type="hidden" name="b8" value="50">
                    <?php  
                    $case_abscisse=6;
                    $case_ordonnee=2;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c9?>;">
                    <form method="post">
                        <input type="hidden" name="b9" value="50">
                    <?php  
                    $case_abscisse=8;
                    $case_ordonnee=2;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c10?>;">
                    <form method="post">
                        <input type="hidden" name="b10" value="50">
                    <?php  
                    $case_abscisse=10;
                    $case_ordonnee=2;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
            </tr>
            <tr>
                <td class="td" style="background-color: <?=$c1?>;">
                    <form method="post">
                        <input type="hidden" name="b1" value="50">
                    <?php  
                    $case_abscisse=1;
                    $case_ordonnee=1;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c2?>;">
                    <form method="post">
                        <input type="hidden" name="b2" value="50">
                    <?php  
                    $case_abscisse=3;
                    $case_ordonnee=1;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c3?>;">
                    <form method="post">
                        <input type="hidden" name="b3" value="50">
                    <?php  
                    $case_abscisse=5;
                    $case_ordonnee=1;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c4?>;">
                    <form method="post">
                        <input type="hidden" name="b4" value="50">
                    <?php  
                    $case_abscisse=7;
                    $case_ordonnee=1;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
                <td class="td" style="background-color: <?=$c5?>;">
                    <form method="post">
                        <input type="hidden" name="b5" value="50">
                    <?php  
                    $case_abscisse=9;
                    $case_ordonnee=1;
                    include 'pion_affiche.php';
                    ?>
                    </form>
                </td>
                <td class="td">
                    
                </td>
            </tr>
            
        </tbody>
    </table>

    
    </body>
</html>