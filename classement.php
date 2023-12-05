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
            include 'header.php';
            include 'database.php';
            global $db;
        ?>
        
        <h1>Classement des meilleurs joueurs</h1>
        <p>Voici les légendes du jeux de dames</p>
        
        

 
<table class="classement">
  <thead>
    <tr>
      <th>Pseudo</th>
      <th>Classement</th>
      <th>Score</th>
      <th>Parties jouées</th>
      <th>Parties gagnées</th>
    </tr>
  </thead>
  <?php
    $number=0;
    $rank_max=9999999999;
    $q = $db->prepare("SELECT * FROM joueur");
    $q->execute([]);
    $max = $q->RowCount();

    while ($number < $max):

    $number++;
    $q = $db->prepare("SELECT * FROM joueur WHERE rank<:rank_max ORDER BY rank DESC");
    $q->execute(['rank_max'=>$rank_max]);
    $rq = $q->fetch();
    $joueur = $rq['pseudo'];
    $level = $rq['rank'];
    $id = $rq['id'];
    $q = $db->prepare("SELECT COUNT(*) AS parties_jouees FROM partie WHERE id_joueur1=:id OR id_joueur2=:id");
    $q->execute(['id'=>$id]);
    $rq = $q->fetch();
    $parties_jouees=$rq['parties_jouees'];
    $q = $db->prepare("SELECT COUNT(*) AS parties_gagnes FROM partie WHERE (id_joueur1=:id AND score_joueur1>score_joueur2) OR (id_joueur2=:id AND score_joueur1<score_joueur2)");
    $q->execute(['id'=>$id]);
    $rq = $q->fetch();
    $parties_gagnes=$rq['parties_gagnes'];
    $rank_max=$level;
    echo '<tr >
       <td class="td">'.$joueur.'</td>
       <td class="td">'.$number.'</td>
       <td class="td">'.$level.'</td>
       <td class="td">'.$parties_jouees.'</td>
       <td class="td">'.$parties_gagnes.'</td>
   </tr>';
    endwhile;

  ?>
  
</table>


        
    </body>
</html>