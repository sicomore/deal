<?php  // -------- Traitement des données --------------
require_once __DIR__ .'/../include/init.php';
adminSecurity();

$req = 'SELECT id FROM notes WHERE id = '.(int)$_GET['id'];
$stmt = $pdo->query($req);
$id = $stmt->fetch();

if (empty($id)) {
  setFlashMessage('Votre sélection n\'existe pas ou plus.<br>Choisissez dans la liste.', 'error');

} else {
  $req = 'DELETE FROM notes WHERE id = '.(int)$_GET['id'];
  $pdo->exec($req);

  setFlashMessage("La note a bien été supprimée.");
}

header('Location: notes.php');
die;
