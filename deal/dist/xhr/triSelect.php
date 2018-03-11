<?php

require_once __DIR__.'/../../include/init.php';
if (isset($_POST['triSelect'])) {

$req = 'SELECT a.*, m.pseudo, c.titre titre_categorie, r.nom nom_region FROM annonce a JOIN categorie c ON c.id = categorie_id JOIN membre m ON m.id = a.membre_id JOIN region r ON r.id = region_id ORDER BY '. $pdo->quote($_POST['triSelect']);
$stmt = $pdo->query($req);
$annonces = $stmt->fetchAll();

$triSelect = json_encode($annonces);
echo $triSelect;

};
