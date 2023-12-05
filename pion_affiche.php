<?php
$q = $db->prepare("SELECT valeur FROM coups WHERE id_partie =:id_partie AND case_abscisse=:case_abscisse AND case_ordonnee=:case_ordonnee");
                    $q->execute(['id_partie' => $id_partie,
                                'case_abscisse' => $case_abscisse,
                                'case_ordonnee' => $case_ordonnee
                    ]);
                    $rq = $q->fetch();
                    $vq = $rq['valeur'];
                    if($vq==2){
                        echo $pion2;
                    }else if($vq==1){
                        echo $pion1;
                        //echo ${"pion".$case_abscisse."_".$case_ordonnee};
                    }else if($vq==3){
                        echo $deplacements;
                    }else if($vq==4){
                        echo $manger;
                    }else if($vq==5){
                        echo $pion1dame;
                    }else if($vq==6){
                        echo $pion2dame;
                    }
                    ?>
                    