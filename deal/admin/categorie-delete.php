<?php  // -------- Traitement des données --------------
require_once __DIR__ .'/../include/init.php';
adminSecurity();

$req = 'SELECT COUNT(*) FROM annonce WHERE categorie_id =' . (int)$_GET['id'];
$stmt = $pdo->query($req);
$cat = $stmt->fetchColumn();

if (empty($cat)) {
  $req = 'DELETE FROM categorie WHERE id = '.(int)$_GET['id'];
  $pdo->exec($req);

  $req = 'SELECT titre FROM categorie WHERE id ='.(int)$_GET['id'];
  $stmt = $pdo->query($req);
  $cat = $stmt->fetch();

  setFlashMessage("La catégorie '.$cat.' a bien été supprimée.");
} else {
  setFlashMessage("La catégorie '.$cat.' ne peut être supprimée car elle contient des produits.", 'error');
}
header('Location: categorie.php');
die;
