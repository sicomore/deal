<?php  // -------- Traitement des données --------------
require_once __DIR__ .'/../include/init.php';
adminSecurity();

$errors = [];
$note = '';


if (!empty($_GET)) {

  if (!isset($_GET['id'])) {
    // if (!isset($_GET['id']) || !is_int($_GET['id'])) {
    $errors[] = "La page que vous recherchez n'existe pas.";

  } elseif ((int)$_GET['id'] == 0) {
    setFlashMessage('L\'id de la note ou l\'avis que vous recherchez n\'est pas valide.<br>Sélectionnez à nouveau dans la liste.', 'error');
    header('Location: notes.php');
    die;
  } else {
    $req = 'SELECT COUNT(*) FROM notes WHERE id = '.(int)$_GET['id'];
    $stmt = $pdo->query($req);
    $nb = $stmt->fetchColumn();

    if ($nb == 0) {
      $errors[] = 'La note n°'.(int)$_GET['id'].' que vous avez sélectionnée n\'existe pas ou plus.';
    } else {

      $req = 'SELECT n.id id, n.note note, n.avis avis, n.date_enregistrement date_enregistrement, mc.id idClient, mv.id idVendeur, mc.pseudo pseudoClient, mv.pseudo pseudoVendeur, mc.email mailClient, mv.email mailVendeur FROM notes n '
      .'JOIN membre mc ON mc.id = n.membre_id1 '
      .'JOIN membre mv ON mv.id = n.membre_id2 '
      .'WHERE n.id = '. (int)$_GET['id'];
      $stmt = $pdo->query($req);
      $note = $stmt->fetch();
    }
  }

  if (!empty($_POST)) {
    sanitizePost();
    extract($_POST);

    $req = 'UPDATE notes SET note = :note, avis = :avis WHERE id = :id';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':id', (int)$_GET['id']);
    $stmt->bindValue(':note', $note);
    $stmt->bindValue(':avis', $avis);
    $stmt->execute();

    setFlashMessage('La note ou l\'avis n°'.(int)$_GET['id'].' a bien été modifié(e).');
    header('Location: notes.php');
    die;

  }
} else {
  setFlashMessage('Vous devez absolument sélectionner une note ou un avis à modifier dans la liste', 'error');
  header('Location: notes.php');
  die;
}

// ----------------- Traitement de l'affichage -----------------
// ----------------- Traitement de l'affichage -----------------

include __DIR__ .'/../layout/top.php';
?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Edition des notes et avis</h1>
    </div>
  </div>

  <?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
      <p><strong>La page contient des erreurs</strong></p>
      <?= implode ('<br>', $errors); ?>
    </div>
  <?php endif; ?>

  <form method="post" id="notes">
    <div class="row">
      <div class="col-sm-4">

        <div class="col-sm-12 form-group">
          <label for="">Note n° : </label>
          <?= $note['id']; ?>
        </div>

        <div class="col-sm-12 form-group">
          <label for="">Note donnée au vendeur : </label>
          <?= $note['pseudoVendeur'].' - '.$note['idVendeur']?>
        </div>

        <div class="col-sm-12 form-group">
          <label for="">Par le client : </label>
          <?= $note['pseudoClient'].' - '.$note['idClient']?>
        </div>

        <div class="col-sm-12 form-group">
          <label for="">Enregistrée le : </label>
          <?= strftime('%d/%m/%Y',strtotime($note['date_enregistrement'])); ?>
        </div>
      </div>

      <div class="col-sm-8">
        <div class="col-sm-1 form-group">
          <label for="">Note</label>
          <input type="text" name="note" value="<?= $note['note']; ?>" class="form-control">
        </div>

        <div class="col-sm-7 form-group">
          <label for="">Avis</label>
          <textarea name="avis" value="<?= $note['avis']; ?>" rows="3" col="10" class="form-control"><?= $note['avis']; ?></textarea>
        </div>

        <div class="col-auto">
          <button class="btn btn-primary pull-right" type="submit" name="button">Enregistrer</button>
          <a href="commentaires.php" class="btn btn-default pull-right" type="cancel">Annuler</a>
        </div>
      </div>
    </div>
  </form>

</div>

<?php
include __DIR__ .'/../layout/bottom.php';
?>
