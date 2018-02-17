<?php  // -------- Traitement des données --------------
require_once __DIR__ .'/../include/init.php';
adminSecurity();

// ------------------------------------------------------
// Si le membre est supprimé, il faut supprimer :
// - ses annonces
// - les notes qu'il a données
// - les notes qu'il a reçues
// - les commentaires qu'il a laissés
// ------------------------------------------------------

$req = 'SELECT COUNT(*) FROM annonce WHERE membre_id =' . (int)$_GET['id'];
$stmt = $pdo->query($req);
$annonce = $stmt->fetchColumn();

$req = 'SELECT pseudo FROM membre WHERE id ='.(int)$_GET['id'];
$stmt = $pdo->query($req);
$membreSupp = $stmt->fetchColumn();

if (empty($annonce)) {
  $req = 'DELETE FROM membre WHERE id = '.(int)$_GET['id'];
  $pdo->exec($req);

  setFlashMessage("Le membre $membreSupp a bien été supprimé.");
} else {
  setFlashMessage("Le membre $membreSupp ne peut être supprimé car il possède des annonces.", 'error');
}
header('Location: membre-edit.php');
die;
