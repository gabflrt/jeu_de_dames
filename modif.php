<?php
        


        if(isset($_POST['formsend'])){
            extract($_POST);

            $identite=$_SESSION['pseudo'];
            $q = $db->prepare("SELECT id FROM joueur WHERE pseudo =:pseudo");
            $q->execute(['pseudo' => $identite]);
            $rq = $q->fetch();
            $id_joueur = $rq['id'];

            if(!empty($mdp) && !empty($mdp2)){
                if($mdp == $mdp2){
                    $options = [
                        'cost' => 12,
                    ];
                    $hashmdp = password_hash($mdp, PASSWORD_BCRYPT, $options);

                    $q = $db->prepare("UPDATE joueur SET mdp =:mdp WHERE id=:id");
                    $q->execute([
                        'id' => $id_joueur,
                        'mdp' => $hashmdp,
                    ]);
                    echo "Le mot de passe  a été modifié</br>";
                }else {
                    echo "Les deux mots de passe ne sont pas identiques";    
                } 
            }  
            
            if(!empty($prenom)){
                $q = $db->prepare("UPDATE joueur SET prenom =:prenom WHERE id=:id");
                $q->execute([
                    'id' => $id_joueur,
                    'prenom' => $prenom,
                ]);
                echo "Le prénom a bien été changée";
                $_SESSION['prenom'] = $prenom;   
            }

            if(!empty($nom)){
                $q = $db->prepare("UPDATE joueur SET nom =:nom WHERE id=:id");
                $q->execute([
                    'id' => $id_joueur,
                    'nom' => $nom,
                ]);
                echo "Le nom a bien été changée";
                $_SESSION['nom'] = $nom;
            }

            if(!empty($pseudo)){
                $verif_pseudo = $db->prepare("SELECT pseudo FROM joueur WHERE pseudo = :pseudo");
                $verif_pseudo->execute(['pseudo' => $pseudo]);
                $verif_pseudo_result = $verif_pseudo->rowCount();
                
                if($verif_pseudo_result == 0){
                    $q = $db->prepare("UPDATE joueur SET pseudo =:pseudo WHERE id=:id");
                    $q->execute([
                        'id' => $id_joueur,
                        'pseudo' => $pseudo,
                    ]);
                    echo "Le pseudo a bien été changé";
                    $_SESSION['pseudo'] = $pseudo;
                }else{
                    echo "Ce pseudo est déjà associée à un compte";
                }
            }

            if(!empty($mail)){
                $verif_mail = $db->prepare("SELECT mail FROM joueur WHERE mail = :mail");
                $verif_mail->execute(['mail' => $mail]);
                $verif_mail_result = $verif_mail->rowCount();
                if($verif_mail_result == 0){
                    $q = $db->prepare("UPDATE joueur SET mail =:mail WHERE id=:id");
                    $q->execute([
                        'id' => $id_joueur,
                        'mail' => $mail,
                    ]);
                    echo "L'adresse mail a bien été changée";
                    $_SESSION['mail'] = $mail;
                }else{
                    echo "Cette adresse mail est déjà associée à un compte";
                }
                
            }
    
        }
    ?>