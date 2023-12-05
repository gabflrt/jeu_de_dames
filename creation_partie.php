<?php 
//echo "creation de partie ouvert";
include 'database.php';
global $db;

// Initialisation SQL d'une partie dans table coup
//if(isset($_POST['recommencer'])) {

if(isset($_POST['creationpartie'])){
    extract($_POST);
    $pseudoj2=$pseudo;

    // Vérifier que le joueur invité existe
    $q = $db->prepare("SELECT id FROM joueur WHERE pseudo =:pseudoj2");
    $q->execute(['pseudoj2' => $pseudoj2]);
    $resultj2 = $q->fetch();
;
    if($resultj2 == true){
        if($_SESSION == true){
    // Générer chaine aléatoire qui servira d'identifiant pour la partie
    function genererChaineAleatoire($longueur = 10)
    {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longueurMax = strlen($caracteres);
    $chaineAleatoire = '';
    for ($i = 0; $i < $longueur; $i++)
    {
    $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
    }
    return $chaineAleatoire;
    }

    // Création de la partie dans la table 'partie'
    $pseudoj1=$_SESSION['pseudo'];
    $q = $db->prepare("SELECT id FROM joueur WHERE pseudo =:pseudoj1");
    $q->execute(['pseudoj1' => $pseudoj1]);
    $rq = $q->fetch();
    $idj1 = $rq['id'];
    $q = $db->prepare("SELECT id FROM joueur WHERE pseudo =:pseudoj2");
    $q->execute(['pseudoj2' => $pseudoj2]);
    $rq = $q->fetch();
    $idj2 = $rq['id'];
    $different=1;
    while($different==1){
        $cle_connection= genererChaineAleatoire(5);
        $q = $db->prepare("SELECT id FROM partie WHERE cle_connection = :cle_connection");
        $q->execute(['cle_connection' => $cle_connection]);
        $rq = $q->fetch();
        if($rq==true){
            $different=1;
        }else{
            $different=0;
        }

    }
    $cle_connection= genererChaineAleatoire(5);
    echo "<p>La partie a bien été crée, clé de la partie : ".$cle_connection. "</p>";
    echo '<a href="jeu.php"><input type="submit" value="Acceder à ma partie"></a>';    
    $coup=0;
    $scorej1=0;
    $scorej2=0;
    $statut=1;
    $couleur=0;
    
    $q = $db->prepare("INSERT INTO partie(cle_connection,id_joueur1,id_joueur2,
    score_joueur1, score_joueur2,coup,statut,couleur) 
    VALUES(:cle_connection,:id_joueur1,:id_joueur2,
    :score_joueur1,:score_joueur2,:coup,:statut,:couleur)");

    $q->execute([
        'cle_connection'=>$cle_connection,
        'id_joueur1'=>$idj1,
        'id_joueur2'=>$idj2,
        'score_joueur1'=>$scorej1,
        'score_joueur2'=>$scorej2,
        'coup'=>$coup,
        'statut'=>$statut,
        'couleur'=>$couleur
    ]);
        
    // Recherche de l'id de la partie créée
    $q = $db->prepare("SELECT id FROM partie WHERE cle_connection = :cle_connection");
    $q->execute(['cle_connection' => $cle_connection]);
    $rq = $q->fetch();
    $id_partie = $rq['id'];

    $_SESSION['cle_connection'] = $cle_connection;
    $_SESSION['id_partie'] = $id_partie;
    setcookie('partie', $id_partie, time() + (24*3600));
    
    // Création des cases correspondants à la partie créée
    $case_abscisse=1;
    $case_ordonnee=1;
    $valeur=0;
    $etat=0;
    $j=0;
    

    $q = $db->prepare("TRUNCATE TABLE `coups`");
    $q->execute([]);


    for ($i = 1; $i <= 50; $i++) {
        if($i<=20){
            $valeur=1;
        }else if($i>30){
            $valeur=2;
        }else{
            $valeur=0;
        }
        
        $q = $db->prepare("INSERT INTO coups(case_abscisse, case_ordonnee,valeur, etat, id_partie) VALUES(:case_abscisse,:case_ordonnee,:valeur,:etat,:id_partie)");
        
        $q->execute([
            'case_abscisse'=>$case_abscisse,
            'case_ordonnee'=>$case_ordonnee,
            'valeur'=>$valeur,
            'etat'=>$etat,
            'id_partie'=>$id_partie
        ]);
        $case_abscisse=$case_abscisse+2;
        if($i%5==0){
            $case_ordonnee++;
            if($j%2==0){
                $case_abscisse=2;
            }else{
                $case_abscisse=1;
            }
            $j++;
        
        }
        
        

    }
}else{
    echo "Veuillez vous conecter pour créer une partie";
}
}else{
    echo "Le joueur invité n'existe pas...";
}

}

if(isset($_POST['connexionpartie'])){
    extract($_POST);
    if($_SESSION == true){
    // Recherche de l'id de la partie à laquelle on veut se connecter
    $cle_connection=$cle_partie;
    $q = $db->prepare("SELECT statut FROM partie WHERE cle_connection = :cle_connection");
    $q->execute(['cle_connection' => $cle_partie]);
    $rq = $q->fetch();
    $vq = $rq['statut'];
    $q = $db->prepare("SELECT id FROM partie WHERE cle_connection = :cle_connection");
    $q->execute(['cle_connection' => $cle_partie]);
    $rq = $q->fetch();
    if($rq==true){
        if($vq==1){
        $id_partie = $rq['id'];
        $_SESSION['cle_connection'] = $cle_connection;
        $_SESSION['id_partie'] = $id_partie;
        setcookie('partie', $id_partie, time() + (24*3600));
        echo "<p>Vous avez bien rejoint la partie :".$cle_connection. "</p>";
        echo '<a href="jeu.php"><input type="submit" value="Acceder à ma partie"></a>';  
        }else{
            echo "La partie demandée a été terminée";
        }  
    }else{
        echo "La partie demandée n'existe pas";
    }
    
    }else{
        echo "Veuillez vous connecter pour rejoindre une partie";
    }

}

    
?>