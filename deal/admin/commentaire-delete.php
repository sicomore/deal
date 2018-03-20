<?php  // -------- Traitement des données --------------
require_once __DIR__ .'/../include/init.php';
adminSecurity();

$req = 'SELECT COUNT(*) FROM commentaire WHERE id = ' . (int)$_GET['id'];
$stmt = $pdo->query($req);
$comment = $stmt->fetchColumn();

if ($comment == 1) {
  $req = 'DELETE FROM commentaire WHERE id = '.(int)$_GET['id'];
  $pdo->exec($req);

  setFlashMessage("Le commentaire ".(int)$_GET['id']." a bien été supprimé.");
} else {
  setFlashMessage("Le commentaire que vous avez sélectionné n'existe pas ou plus.", 'error');
}

header('Location: commentaires.php');
die;
