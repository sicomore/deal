<?php

require_once __DIR__ .'/../include/init.php';
echo __DIR__ .'/../include/init.php';

if (!empty($_POST)) {

  $req = 'SELECT * FROM tri';
  $stmt = $pdo->query($req);
  $tris = $stmt->fetchAll();

  return $tris;

}



// $req = 'SELECT a.*, m.pseudo, c.titre titre_categorie, r.nom nom_region FROM annonce a JOIN categorie c ON c.id = categorie_id JOIN membre m ON m.id = a.membre_id JOIN region r ON r.id = region_id ORDER BY '. $triSelect;
// $stmt = $pdo->query($req);
// $annonces = $stmt->fetchAll();
