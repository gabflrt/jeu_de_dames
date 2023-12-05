<?php

    if(isset($_POST['formlogin']))
    {
        extract($_POST);

        if(!empty($mail) && !empty($mdp))
        {
            $q = $db->prepare("SELECT * FROM joueur WHERE mail = :mail");
            $q->execute(['mail' => $mail]);
            $result = $q->fetch();

            if($result == true){
                // Le compte existe
                $hashmdp = $result['mdp'];
                if(password_verify($mdp, $hashmdp)){
                    echo "<p>Vous venez de vous connecter avec l'adresse mail : ".$mail." !</p>";
                    $_SESSION['mail'] = $result['mail'];
                    $_SESSION['pseudo'] = $result['pseudo'];
                    $_SESSION['prenom'] = $result['prenom'];
                    $_SESSION['nom'] = $result['nom'];
                    $_SESSION['date_naissance'] = $result['date_naissance'];
                    setcookie('pseudo', $mail, time() + (30*24*3600));
                }else{
                    echo "Mot de passe incorrecte";
                }
            }else{
                echo "Aucun compte n'a été créé avec l'adresse mail : ".$mail." ...";
            }
        }
    }

?>