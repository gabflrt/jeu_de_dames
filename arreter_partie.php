<?php 
if(isset($_POST['arreter'])) {
    
    // Suppression des cases de la partie
    $q = $db->prepare("DELETE FROM coups WHERE id_partie=:id_partie");
    $q->execute(['id_partie' => $id_partie]);
    // Mettre a jour le statut de la partie
    $q = $db->prepare("UPDATE partie SET statut = 0 WHERE id=:id_partie");     
    $q->execute(['id_partie' => $id_partie]);
    // Suprimer le cookie pour ne pas créer de problème si l'utilisateur lance une nouvelle partie
    setcookie('partie', $id_partie, time() - 3600);
    echo "<p>La partie a bien été supprimée !</p>";
    echo '<a href="index.php"><input type="submit" value="Retourner au menu principal"></a>';    

    exit();


}  
?>