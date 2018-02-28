<?php

// if (isset($_POST['tri-annonces'])) {
if (isset($_GET['tri_annonces'])) {
  require __DIR__ . '/connexion-bdd.php';

  // $pseudo = $_POST['pseudo'];
  // $mdp = $_POST['mdp'];

  $req = 'SELECT a.id annonceId, a.titre titre, a.prix prix, a.ville ville, a.code_postal code_postal, a.date_enregistrement parution, m.pseudo pseudo, c.titre categorie, r.nom region FROM annonce a JOIN categorie c ON c.id = categorie_id JOIN membre m ON m.id = a.membre_id JOIN region r ON r.id = region_id ORDER BY '.$_GET['tri_annonces']. ' LIMIT 5';
  $stmt = $pdo->query($req);
  $annonces = $stmt->fetchAll();
  // var_dump($annonces);
  echo '<br>';

  $tableauAnnonces = [];

  foreach ($annonces as $cle => $annonce) {
    $tableauAnnonces[] = $annonce['annonceId'];
    $tableauAnnonces[] = $annonce['titre'];
    $tableauAnnonces[] = $annonce['prix'];
    $tableauAnnonces[] = $annonce['ville'];
    $tableauAnnonces[] = $annonce['code_postal'];
    $tableauAnnonces[] = $annonce['parution'];
    $tableauAnnonces[] = $annonce['pseudo'];
    $tableauAnnonces[] = $annonce['categorie'];
    $tableauAnnonces[] = $annonce['region'];
  };
  echo json_encode($tableauAnnonces);


  $success = '<div class="col-sm-6 alert alert-success" id="reponse">Tableau passé</div>';
  //   $error = '<div class="col-sm-6 alert alert-danger" id="reponse">Le tableau est vide</div>';
  //
  //   if (!empty($annonces)) {
  //
  echo $success;
  //   } else {
  //     echo $error;
  //   }
  //
  // } else {
  //
  //   echo '<div class="col-sm-6 alert alert-primary" id="reponse">Vous devez sélectionner un ordre de tri</div>';
  //
  //
}
