<?php

// Chercher la valeur de la case cliquée
$q = $db->prepare("SELECT valeur FROM coups WHERE id_partie =:id_partie AND case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie =:id_partie");
$q->execute(['id_partie' => $id_partie,
    'case_abscisse' => $case_abscisse,
    'case_ordonnee' => $case_ordonnee,
    'id_partie' => $id_partie
]);
$rq = $q->fetch();
$type_pion = $rq['valeur'];

// Chercher le nombre de coups joués
$q = $db->prepare("SELECT coup FROM partie WHERE id =:id_partie");
$q->execute(['id_partie' => $id_partie]);
$rq = $q->fetch();
$coup = $rq['coup'];


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


//Vérifier si il y a une victoire
if($scorej1>=20){
   // Suppression des cases de la partie
    $q = $db->prepare("DELETE FROM coups WHERE id_partie=:id_partie");
    $q->execute(['id_partie' => $id_partie]);
    // Mettre a jour le statut de la partie
    $q = $db->prepare("UPDATE partie SET statut = 0 WHERE id=:id_partie");     
    $q->execute(['id_partie' => $id_partie]);
    //Petit système de ranking afin de classer les joueurs
    $q = $db->prepare("SELECT rank FROM joueur WHERE id =:id");
    $q->execute(['id' => $idj1]);
    $rq = $q->fetch();
    $rankj1 = $rq['rank'];
    $rankj1=$rankj1+3;
    $q = $db->prepare("UPDATE joueur set rank=:rank WHERE id =:id");
    $q->execute(['rank' => $rankj1,
                'id' => $idj1]);
    $q = $db->prepare("SELECT rank FROM joueur WHERE id =:id");
    $q->execute(['id' => $idj2]);
    $rq = $q->fetch();
    $rankj2 = $rq['rank'];
    $rankj2=$rankj2-1; 
    $q = $db->prepare("UPDATE joueur set rank=:rank WHERE id =:id");
    $q->execute(['rank' => $rankj2,
                'id' => $idj2]); 
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
    //Petit système de ranking afin de classer les joueurs
    $q = $db->prepare("SELECT rank FROM joueur WHERE id =:id");
    $q->execute(['id' => $idj1]);
    $rq = $q->fetch();
    $rankj1 = $rq['rank'];
    $rankj1=$rankj1-1;
    $q = $db->prepare("UPDATE joueur set rank=:rank WHERE id =:id");
    $q->execute(['rank' => $rankj1,
                'id' => $idj1]);
    $q = $db->prepare("SELECT rank FROM joueur WHERE id =:id");
    $q->execute(['id' => $idj2]);
    $rq = $q->fetch();
    $rankj2 = $rq['rank'];
    $rankj2=$rankj2+3; 
    $q = $db->prepare("UPDATE joueur set rank=:rank WHERE id =:id");
    $q->execute(['rank' => $rankj2,
                'id' => $idj2]); 
    // Suprimer le cookie pour ne pas créer de problème si l'utilisateur lance une nouvelle partie
    setcookie('partie', $id_partie, time() - 3600);
    echo "<p>Le joueur 2 a gagné la partie !</p>";
    echo '<a href="index.php"><input type="submit" value="Retourner au menu principal"></a>';    
    exit(); 
}


if(($coup%2==0 && $pseudoj1==($_SESSION['pseudo'])) || ($coup%2==1 && $pseudoj2==($_SESSION['pseudo']))){

// Le joueur 1 sélectionne un pion
if($type_pion==2 && $coup%2==0){

    //Si les cases sont vides, alors on propose de les sélectionner
    $q = $db->prepare("UPDATE coups SET valeur = 3
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND valeur=0 AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse-1,
                'case_ordonnee' => $case_ordonnee-1,
                'id_partie' => $id_partie
                ]);
    $q = $db->prepare("UPDATE coups SET valeur = 3
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND valeur=0 AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse+1,
                'case_ordonnee' => $case_ordonnee-1,
                'id_partie' => $id_partie
                ]);


    //Si les cases sont occupées par l'adversaire, on regarde si on peut manger un pion  
    $q = $db->prepare("SELECT valeur FROM coups
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse-1,
                'case_ordonnee' => $case_ordonnee-1,
                'id_partie' => $id_partie
                 ]);
    $rq = $q->fetch();
    $vq1 = $rq['valeur'];
    $q = $db->prepare("SELECT valeur FROM coups
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse-2,
                'case_ordonnee' => $case_ordonnee-2,
                'id_partie' => $id_partie
                 ]);
    $rq = $q->fetch();
    $vq2 = $rq['valeur'];
    if($vq1==1 && $vq2==0){
        $q = $db->prepare("UPDATE coups SET valeur = 4
        WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
        ");
        $q->execute(['case_abscisse' => $case_abscisse-2,
                    'case_ordonnee' => $case_ordonnee-2,
                'id_partie' => $id_partie
                    ]);
    }
    $q = $db->prepare("SELECT valeur FROM coups
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse+1,
                'case_ordonnee' => $case_ordonnee-1,
                'id_partie' => $id_partie
                 ]);
    $rq = $q->fetch();
    $vq1 = $rq['valeur'];
    $q = $db->prepare("SELECT valeur FROM coups
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse+2,
                'case_ordonnee' => $case_ordonnee-2,
                'id_partie' => $id_partie
                 ]);
    $rq = $q->fetch();
    $vq2 = $rq['valeur'];
    if($vq1==1 && $vq2==0){
        $q = $db->prepare("UPDATE coups SET valeur = 4
        WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
        ");
        $q->execute(['case_abscisse' => $case_abscisse+2,
                    'case_ordonnee' => $case_ordonnee-2,
                    'id_partie' => $id_partie
                    ]);
    }
    $q = $db->prepare("SELECT valeur FROM coups
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse-1,
                'case_ordonnee' => $case_ordonnee+1,
                'id_partie' => $id_partie
                 ]);
    $rq = $q->fetch();
    $vq1 = $rq['valeur'];
    $q = $db->prepare("SELECT valeur FROM coups
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse-2,
                'case_ordonnee' => $case_ordonnee+2,
                'id_partie' => $id_partie
                 ]);
    $rq = $q->fetch();
    $vq2 = $rq['valeur'];
    if($vq1==1 && $vq2==0){
        $q = $db->prepare("UPDATE coups SET valeur = 4
        WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
        ");
        $q->execute(['case_abscisse' => $case_abscisse-2,
                    'case_ordonnee' => $case_ordonnee+2,
                    'id_partie' => $id_partie
                    ]);
    }
    $q = $db->prepare("SELECT valeur FROM coups
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse+1,
                'case_ordonnee' => $case_ordonnee+1,
                'id_partie' => $id_partie
                 ]);
    $rq = $q->fetch();
    $vq1 = $rq['valeur'];
    $q = $db->prepare("SELECT valeur FROM coups
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse+2,
                'case_ordonnee' => $case_ordonnee+2,
                'id_partie' => $id_partie
                 ]);
    $rq = $q->fetch();
    $vq2 = $rq['valeur'];
    if($vq1==1 && $vq2==0){
        $q = $db->prepare("UPDATE coups SET valeur = 4
        WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
        ");
        $q->execute(['case_abscisse' => $case_abscisse+2,
                    'case_ordonnee' => $case_ordonnee+2,
                    'id_partie' => $id_partie
                    ]);
    }
    
    

    
    $q = $db->prepare("UPDATE coups SET etat = 1 
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse,
                'case_ordonnee' => $case_ordonnee,
                'id_partie' => $id_partie
                ]);

// Le joueur 2 sélectionne un pion
}else if($type_pion==1 && $coup%2==1){
    
    //Si les cases sont vides, alors on propose de les sélectionner
    $q = $db->prepare("UPDATE coups SET valeur = 3
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND valeur=0 AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse-1,
                'case_ordonnee' => $case_ordonnee+1,
                'id_partie' => $id_partie
                ]);
    $q = $db->prepare("UPDATE coups SET valeur = 3 
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND valeur=0 AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse+1,
                'case_ordonnee' => $case_ordonnee+1,
                'id_partie' => $id_partie
                ]);

    //Si les cases sont occupées par l'adversaire, on regarde si on peut manger un pion
    
    $q = $db->prepare("SELECT valeur FROM coups
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse-1,
                'case_ordonnee' => $case_ordonnee-1,
                'id_partie' => $id_partie
                 ]);
    $rq = $q->fetch();
    $vq1 = $rq['valeur'];
    $q = $db->prepare("SELECT valeur FROM coups
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse-2,
                'case_ordonnee' => $case_ordonnee-2,
                'id_partie' => $id_partie
                 ]);
    $rq = $q->fetch();
    $vq2 = $rq['valeur'];
    if($vq1==2 && $vq2==0){
        $q = $db->prepare("UPDATE coups SET valeur = 4
        WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
        ");
        $q->execute(['case_abscisse' => $case_abscisse-2,
                    'case_ordonnee' => $case_ordonnee-2,
                    'id_partie' => $id_partie
                    ]);
    }
    $q = $db->prepare("SELECT valeur FROM coups
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse+1,
                'case_ordonnee' => $case_ordonnee-1,
                'id_partie' => $id_partie
                 ]);
    $rq = $q->fetch();
    $vq1 = $rq['valeur'];
    $q = $db->prepare("SELECT valeur FROM coups
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse+2,
                'case_ordonnee' => $case_ordonnee-2,
                'id_partie' => $id_partie
                 ]);
    $rq = $q->fetch();
    $vq2 = $rq['valeur'];
    if($vq1==2 && $vq2==0){
        $q = $db->prepare("UPDATE coups SET valeur = 4
        WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
        ");
        $q->execute(['case_abscisse' => $case_abscisse+2,
                    'case_ordonnee' => $case_ordonnee-2,
                    'id_partie' => $id_partie
                    ]);
    }
    $q = $db->prepare("SELECT valeur FROM coups
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse-1,
                'case_ordonnee' => $case_ordonnee+1,
                'id_partie' => $id_partie
                 ]);
    $rq = $q->fetch();
    $vq1 = $rq['valeur'];
    $q = $db->prepare("SELECT valeur FROM coups
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse-2,
                'case_ordonnee' => $case_ordonnee+2,
                'id_partie' => $id_partie
                 ]);
    $rq = $q->fetch();
    $vq2 = $rq['valeur'];
    if($vq1==2 && $vq2==0){
        $q = $db->prepare("UPDATE coups SET valeur = 4
        WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
        ");
        $q->execute(['case_abscisse' => $case_abscisse-2,
                    'case_ordonnee' => $case_ordonnee+2,
                    'id_partie' => $id_partie
                    ]);
    }
    $q = $db->prepare("SELECT valeur FROM coups
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse+1,
                'case_ordonnee' => $case_ordonnee+1,
                'id_partie' => $id_partie
                 ]);
    $rq = $q->fetch();
    $vq1 = $rq['valeur'];
    $q = $db->prepare("SELECT valeur FROM coups
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse+2,
                'case_ordonnee' => $case_ordonnee+2,
                'id_partie' => $id_partie
                 ]);
    $rq = $q->fetch();
    $vq2 = $rq['valeur'];
    if($vq1==2 && $vq2==0){
        $q = $db->prepare("UPDATE coups SET valeur = 4
        WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
        ");
        $q->execute(['case_abscisse' => $case_abscisse+2,
                    'case_ordonnee' => $case_ordonnee+2,
                    'id_partie' => $id_partie
                    ]);
    }
    
       
    $q = $db->prepare("UPDATE coups SET etat = 1 
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['case_abscisse' => $case_abscisse,
                'case_ordonnee' => $case_ordonnee,
                'id_partie' => $id_partie
                ]);

// Le joueur veut déplacer un pion
}else if($type_pion==3){
    // En fonction du tour on sait quel pion doit être affiché
    
    $q = $db->prepare("SELECT valeur FROM coups 
                    WHERE id_partie=:id_partie AND etat=1
                    ");      
    $q->execute(['id_partie' => $id_partie
    ]);
    $rq = $q->fetch();
    $suppr = $rq['valeur'];


    $q = $db->prepare("UPDATE coups SET valeur =:suppr  
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['suppr' => $suppr,
                'case_abscisse' => $case_abscisse,
                'case_ordonnee' => $case_ordonnee,
                'id_partie' => $id_partie
                ]);

    // On supprime toutes les propositions de cases, pour le prochain tour
    for($i=0;$i<=10;$i++){
        for($j=0;$j<=10;$j++){
            $q = $db->prepare("UPDATE coups SET valeur = 0  
                WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND valeur=3 AND id_partie=:id_partie
                ");     
            $q->execute(['case_abscisse' => $i,
                        'case_ordonnee' => $j,
                        'id_partie' => $id_partie
                ]);
            $q = $db->prepare("UPDATE coups SET valeur = 0  
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND valeur=4 AND id_partie=:id_partie
                    ");
                    
            $q->execute(['case_abscisse' => $i,
                        'case_ordonnee' => $j,
                        'id_partie' => $id_partie
            ]);
            // On supprime l'ancienne position du pion qui a été déplacé
            $q = $db->prepare("UPDATE coups SET valeur=0,etat=0  
                    WHERE id_partie=:id_partie AND etat=1
                    ");      
            $q->execute(['id_partie' => $id_partie
            ]);
            
            
        }
    }


    // On incrémente le nombre de coups de la partie
    $coup++;
    $q = $db->prepare("UPDATE partie SET coup =:coup
    WHERE id=:id_partie");
    $q->execute(['coup' => $coup,
                'id_partie' => $id_partie
                ]);

    // On cherche si il y a une dame
    for($i=0;$i<=10;$i++){
        $j=10;
            $q = $db->prepare("UPDATE coups SET valeur = 5  
                WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND valeur=1 AND id_partie=:id_partie
                ");     
            $q->execute(['case_abscisse' => $i,
                        'case_ordonnee' => $j,
                        'id_partie' => $id_partie
                ]);            
    }
    for($i=0;$i<=10;$i++){
        $j=1;
            $q = $db->prepare("UPDATE coups SET valeur = 6 
                WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND valeur=2 AND id_partie=:id_partie
                ");     
            $q->execute(['case_abscisse' => $i,
                        'case_ordonnee' => $j,
                        'id_partie' => $id_partie
                ]);            
    }

// Le joueur veut manger un pion             
}else if($type_pion==4){
    // Joueur 1 mange un pion
    if($coup%2==0){
        // Incrémenter le score du joueur 2
        $scorej1++;
        $q = $db->prepare("UPDATE partie SET score_joueur1 =:scorej1
        WHERE id=:id_partie");
        $q->execute(['scorej1' => $scorej1,
                    'id_partie' => $id_partie
                        ]);
    }else{
        $scorej2++;
        $q = $db->prepare("UPDATE partie SET score_joueur2 =:scorej2
        WHERE id=:id_partie");
        $q->execute(['scorej2' => $scorej2,
                    'id_partie' => $id_partie
                        ]);
    }

    // Changer la position du pion mangeur
    $q = $db->prepare("SELECT valeur,case_abscisse,case_ordonnee FROM coups
    WHERE etat=1 AND id_partie=:id_partie");
    $q->execute(['id_partie' => $id_partie]);
    $mangeur = $q->fetch();
    $suppr = $mangeur['valeur'];
    $amangeur = $mangeur['case_abscisse'];
    $omangeur = $mangeur['case_ordonnee'];
    $q = $db->prepare("UPDATE coups SET valeur = :suppr  
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute(['suppr' => $suppr,
                'case_abscisse' => $case_abscisse,
                    'case_ordonnee' => $case_ordonnee,
                'id_partie' => $id_partie
    ]);
    $q = $db->prepare("UPDATE coups SET etat=0, valeur=0
    WHERE etat=1 AND id_partie=:id_partie
    ");
    $q->execute([
                'id_partie' => $id_partie
    ]);

    $adiff=abs(abs($case_abscisse)-abs($amangeur));
    $odiff=abs(abs($case_ordonnee)-abs($omangeur));
    $q = $db->prepare("UPDATE coups SET valeur = 0  
    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
    ");
    $q->execute([
                'case_abscisse' => ($case_abscisse+$amangeur)/$adiff,
                    'case_ordonnee' => ($case_ordonnee+$omangeur)/$odiff,
                'id_partie' => $id_partie
    ]);

    // On supprime toutes les propositions de cases, pour le prochain tour
    for($i=0;$i<=10;$i++){
        for($j=0;$j<=10;$j++){
            $q = $db->prepare("UPDATE coups SET valeur = 0  
                WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND valeur=3 AND id_partie=:id_partie
                ");     
            $q->execute(['case_abscisse' => $i,
                        'case_ordonnee' => $j,
                        'id_partie' => $id_partie
                ]);
            $q = $db->prepare("UPDATE coups SET valeur = 0  
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND valeur=4 AND id_partie=:id_partie
                    ");
                    
            $q->execute(['case_abscisse' => $i,
                        'case_ordonnee' => $j,
                        'id_partie' => $id_partie
            ]);
            // On supprime l'ancienne position du pion qui a été déplacé
            $q = $db->prepare("UPDATE coups SET valeur=0,etat=0  
                    WHERE id_partie=:id_partie AND etat=1
                    ");      
            $q->execute(['id_partie' => $id_partie
            ]);
            
            
        }
    }

    // On incrémente le nombre de coups de la partie
    $coup++;
    $q = $db->prepare("UPDATE partie SET coup =:coup
    WHERE id=:id_partie");
    $q->execute(['coup' => $coup,
                'id_partie' => $id_partie
                ]);
        
        
    

        
    

    // On cherche si il y a une dame
    for($i=0;$i<=10;$i++){
        $j=10;
            $q = $db->prepare("UPDATE coups SET valeur = 5  
                WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND valeur=1 AND id_partie=:id_partie
                ");     
            $q->execute(['case_abscisse' => $i,
                        'case_ordonnee' => $j,
                        'id_partie' => $id_partie
                ]);            
    }
    for($i=0;$i<=10;$i++){
        $j=1;
            $q = $db->prepare("UPDATE coups SET valeur = 6 
                WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND valeur=2 AND id_partie=:id_partie
                ");     
            $q->execute(['case_abscisse' => $i,
                        'case_ordonnee' => $j,
                        'id_partie' => $id_partie
                ]);            
    }
    //Le joueur 1 selectionne une dame
}else if($type_pion==5 && $coup%2==1){
//Si les cases sont vides, alors on propose de les sélectionner
    for($i=1;$i<=11;$i++){
        $q = $db->prepare("SELECT valeur FROM coups
        WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
        ");
        $q->execute(['case_abscisse' => $case_abscisse-$i,
                    'case_ordonnee' => $case_ordonnee-$i,
                    'id_partie' => $id_partie
                    ]);
        $rq = $q->fetch();
        $vq = $rq['valeur'];
        //Tant que case vide, joueur peut sélectionner
        if($vq==0){
            $q = $db->prepare("UPDATE coups SET valeur = 3
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie
                    ");
            $q->execute(['case_abscisse' => $case_abscisse-$i,
                        'case_ordonnee' => $case_ordonnee-$i,
                        'id_partie' => $id_partie
                        ]);
        }
        // Si tombe sur un de ces pions, ne peut plus selectionner
        if($vq==1){
            $i=12;
        }
        // Si tombe sur pion adverse, peut manger le pion et ne peut plus selectionner après
        if($vq==2){
            $q = $db->prepare("UPDATE coups SET valeur = 4
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie AND valeur=0
                    ");
            $q->execute(['case_abscisse' => $case_abscisse-$i-1,
                        'case_ordonnee' => $case_ordonnee-$i-1,
                        'id_partie' => $id_partie
                        ]);
            $i=12;
        }
    }
    for($i=1;$i<=11;$i++){
        $q = $db->prepare("SELECT valeur FROM coups
        WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
        ");
        $q->execute(['case_abscisse' => $case_abscisse+$i,
                    'case_ordonnee' => $case_ordonnee-$i,
                    'id_partie' => $id_partie
                    ]);
        $rq = $q->fetch();
        $vq = $rq['valeur'];
        //Tant que case vide, joueur peut sélectionner
        if($vq==0){
            $q = $db->prepare("UPDATE coups SET valeur = 3
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie
                    ");
            $q->execute(['case_abscisse' => $case_abscisse+$i,
                        'case_ordonnee' => $case_ordonnee-$i,
                        'id_partie' => $id_partie
                        ]);
        }
        // Si tombe sur un de ces pions, ne peut plus selectionner
        if($vq==1){
            $i=12;
        }
        // Si tombe sur pion adverse, peut manger le pion et ne peut plus selectionner après
        if($vq==2){
            $q = $db->prepare("UPDATE coups SET valeur = 4
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie AND valeur=0
                    ");
            $q->execute(['case_abscisse' => $case_abscisse+$i+1,
                        'case_ordonnee' => $case_ordonnee-$i-1,
                        'id_partie' => $id_partie
                        ]);
            $i=12;
        }
    }
    for($i=1;$i<=11;$i++){
        $q = $db->prepare("SELECT valeur FROM coups
        WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
        ");
        $q->execute(['case_abscisse' => $case_abscisse-$i,
                    'case_ordonnee' => $case_ordonnee+$i,
                    'id_partie' => $id_partie
                    ]);
        $rq = $q->fetch();
        $vq = $rq['valeur'];
        //Tant que case vide, joueur peut sélectionner
        if($vq==0){
            $q = $db->prepare("UPDATE coups SET valeur = 3
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie
                    ");
            $q->execute(['case_abscisse' => $case_abscisse-$i,
                        'case_ordonnee' => $case_ordonnee+$i,
                        'id_partie' => $id_partie
                        ]);
        }
        // Si tombe sur un de ces pions, ne peut plus selectionner
        if($vq==1){
            $i=12;
        }
        // Si tombe sur pion adverse, peut manger le pion et ne peut plus selectionner après
        if($vq==2){
            $q = $db->prepare("UPDATE coups SET valeur = 4
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie AND valeur=0
                    ");
            $q->execute(['case_abscisse' => $case_abscisse-$i-1,
                        'case_ordonnee' => $case_ordonnee+$i+1,
                        'id_partie' => $id_partie
                        ]);
            $i=12;
        }
    }
    for($i=1;$i<=11;$i++){
        $q = $db->prepare("SELECT valeur FROM coups
        WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
        ");
        $q->execute(['case_abscisse' => $case_abscisse+$i,
                    'case_ordonnee' => $case_ordonnee+$i,
                    'id_partie' => $id_partie
                    ]);
        $rq = $q->fetch();
        $vq = $rq['valeur'];
        //Tant que case vide, joueur peut sélectionner
        if($vq==0){
            $q = $db->prepare("UPDATE coups SET valeur = 3
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie
                    ");
            $q->execute(['case_abscisse' => $case_abscisse+$i,
                        'case_ordonnee' => $case_ordonnee+$i,
                        'id_partie' => $id_partie
                        ]);
        }
        // Si tombe sur un de ces pions, ne peut plus selectionner
        if($vq==1){
            $i=12;
        }
        // Si tombe sur pion adverse, peut manger le pion et ne peut plus selectionner après
        if($vq==2){
            $q = $db->prepare("UPDATE coups SET valeur = 4
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie AND valeur=0
                    ");
            $q->execute(['case_abscisse' => $case_abscisse+$i+1,
                        'case_ordonnee' => $case_ordonnee+$i+1,
                        'id_partie' => $id_partie
                        ]);
            $i=12;
        }
    }
    //Signalez que c'est la piece à déplacer
    $q = $db->prepare("UPDATE coups SET etat = 1
                WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie
                ");
    $q->execute(['case_abscisse' => $case_abscisse,
                'case_ordonnee' => $case_ordonnee,
                'id_partie' => $id_partie
                ]);

    
}else if($type_pion==6 && $coup%2==0){
    //Si les cases sont vides, alors on propose de les sélectionner
    for($i=1;$i<=11;$i++){
        $q = $db->prepare("SELECT valeur FROM coups
        WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
        ");
        $q->execute(['case_abscisse' => $case_abscisse-$i,
                    'case_ordonnee' => $case_ordonnee-$i,
                    'id_partie' => $id_partie
                    ]);
        $rq = $q->fetch();
        $vq = $rq['valeur'];
        //Tant que case vide, joueur peut sélectionner
        if($vq==0){
            $q = $db->prepare("UPDATE coups SET valeur = 3
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie
                    ");
            $q->execute(['case_abscisse' => $case_abscisse-$i,
                        'case_ordonnee' => $case_ordonnee-$i,
                        'id_partie' => $id_partie
                        ]);
        }
        // Si tombe sur un de ces pions, ne peut plus selectionner
        if($vq==1){
            $i=12;
        }
        // Si tombe sur pion adverse, peut manger le pion et ne peut plus selectionner après
        if($vq==2){
            $q = $db->prepare("UPDATE coups SET valeur = 4
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie AND valeur=0
                    ");
            $q->execute(['case_abscisse' => $case_abscisse-$i-1,
                        'case_ordonnee' => $case_ordonnee-$i-1,
                        'id_partie' => $id_partie
                        ]);
            $i=12;
        }
    }
    for($i=1;$i<=11;$i++){
        $q = $db->prepare("SELECT valeur FROM coups
        WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
        ");
        $q->execute(['case_abscisse' => $case_abscisse+$i,
                    'case_ordonnee' => $case_ordonnee-$i,
                    'id_partie' => $id_partie
                    ]);
        $rq = $q->fetch();
        $vq = $rq['valeur'];
        //Tant que case vide, joueur peut sélectionner
        if($vq==0){
            $q = $db->prepare("UPDATE coups SET valeur = 3
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie
                    ");
            $q->execute(['case_abscisse' => $case_abscisse+$i,
                        'case_ordonnee' => $case_ordonnee-$i,
                        'id_partie' => $id_partie
                        ]);
        }
        // Si tombe sur un de ces pions, ne peut plus selectionner
        if($vq==1){
            $i=12;
        }
        // Si tombe sur pion adverse, peut manger le pion et ne peut plus selectionner après
        if($vq==2){
            $q = $db->prepare("UPDATE coups SET valeur = 4
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie AND valeur=0
                    ");
            $q->execute(['case_abscisse' => $case_abscisse+$i+1,
                        'case_ordonnee' => $case_ordonnee-$i-1,
                        'id_partie' => $id_partie
                        ]);
            $i=12;
        }
    }
    for($i=1;$i<=11;$i++){
        $q = $db->prepare("SELECT valeur FROM coups
        WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
        ");
        $q->execute(['case_abscisse' => $case_abscisse-$i,
                    'case_ordonnee' => $case_ordonnee+$i,
                    'id_partie' => $id_partie
                    ]);
        $rq = $q->fetch();
        $vq = $rq['valeur'];
        //Tant que case vide, joueur peut sélectionner
        if($vq==0){
            $q = $db->prepare("UPDATE coups SET valeur = 3
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie
                    ");
            $q->execute(['case_abscisse' => $case_abscisse-$i,
                        'case_ordonnee' => $case_ordonnee+$i,
                        'id_partie' => $id_partie
                        ]);
        }
        // Si tombe sur un de ces pions, ne peut plus selectionner
        if($vq==1){
            $i=12;
        }
        // Si tombe sur pion adverse, peut manger le pion et ne peut plus selectionner après
        if($vq==2){
            $q = $db->prepare("UPDATE coups SET valeur = 4
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie AND valeur=0
                    ");
            $q->execute(['case_abscisse' => $case_abscisse-$i-1,
                        'case_ordonnee' => $case_ordonnee+$i+1,
                        'id_partie' => $id_partie
                        ]);
            $i=12;
        }
    }
    for($i=1;$i<=11;$i++){
        $q = $db->prepare("SELECT valeur FROM coups
        WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee AND id_partie=:id_partie
        ");
        $q->execute(['case_abscisse' => $case_abscisse+$i,
                    'case_ordonnee' => $case_ordonnee+$i,
                    'id_partie' => $id_partie
                    ]);
        $rq = $q->fetch();
        $vq = $rq['valeur'];
        //Tant que case vide, joueur peut sélectionner
        if($vq==0){
            $q = $db->prepare("UPDATE coups SET valeur = 3
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie
                    ");
            $q->execute(['case_abscisse' => $case_abscisse+$i,
                        'case_ordonnee' => $case_ordonnee+$i,
                        'id_partie' => $id_partie
                        ]);
        }
        // Si tombe sur un de ces pions, ne peut plus selectionner
        if($vq==1){
            $i=12;
        }
        // Si tombe sur pion adverse, peut manger le pion et ne peut plus selectionner après
        if($vq==2){
            $q = $db->prepare("UPDATE coups SET valeur = 4
                    WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie AND valeur=0
                    ");
            $q->execute(['case_abscisse' => $case_abscisse+$i+1,
                        'case_ordonnee' => $case_ordonnee+$i+1,
                        'id_partie' => $id_partie
                        ]);
            $i=12;
        }
    }
    //Signalez que c'est la piece à déplacer
    $q = $db->prepare("UPDATE coups SET etat = 1
                WHERE case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee  AND id_partie=:id_partie
                ");
    $q->execute(['case_abscisse' => $case_abscisse,
                'case_ordonnee' => $case_ordonnee,
                'id_partie' => $id_partie
                ]);
}



}


?>