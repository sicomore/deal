<?php  // -------- Traitement des données --------------
require_once __DIR__ .'/../include/init.php';
adminSecurity();

$req = 'SELECT photo FROM annonce WHERE id =' . (int)$_GET['id'];
$stmt = $pdo->query($req);
$photo = $stmt->fetchColumn();

if (!empty($photo)) {
  unlink(PHOTO_DIR . $photo);
}

$req = 'DELETE FROM annonce WHERE id = '.(int)$_GET['id'];
$pdo->exec($req);

setFlashMessage("L'annonce a bien été supprimée.");
header('Location: '.SITE_PATH.'admin/annonces.php');
die;
