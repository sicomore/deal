<?php  // -------- Traitement des données --------------
require_once __DIR__ .'/../include/init.php';
adminSecurity();

$req = 'SELECT count(*) FROM annonce WHERE categorie_id = '. (int)$_GET['id'];
$stmt = $pdo->query($req);
$nb = $stmt->fetchColumn();

$req = 'SELECT titre FROM categorie WHERE id ='.(int)$_GET['id'];
$stmt = $pdo->query($req);
$cat = $stmt->fetch();

if (!$nb) {
  if (!$cat) {
    setFlashMessage('Cette catégorie n\'existe pas ou plus.<br>Choisissez dans la liste.', 'error');

  } else {
    $req = 'DELETE FROM categorie WHERE id = '.(int)$_GET['id'];
    $pdo->exec($req);

    setFlashMessage('La catégorie '.$cat['titre'].' a bien été supprimée.');
  }

} else {
  setFlashMessage('La catégorie '.$cat['titre'].' ne peut être supprimée car elle contient des annonces.', 'error');
}
// displayFlashMessage();

header('Location: categorie.php');
die;
