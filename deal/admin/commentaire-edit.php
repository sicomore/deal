<?php  // -------- Traitement des données --------------
require_once __DIR__ .'/../include/init.php';
adminSecurity();

$errors = [];
$commentaire = '';


if (!empty($_GET)) {

  if (!isset($_GET['id'])) {
    // if (!isset($_GET['id']) || !is_int($_GET['id'])) {
    $errors[] = "La page que vous recherchez n'existe pas.";

  } elseif ((int)$_GET['id'] == 0) {
    setFlashMessage('L\'id du commentaire que vous recherchez n\'est pas valide.<br>Sélectionnez un commentaire dans la liste.', 'error');
    header('Location: commentaires.php');
    die;
  } else {
    $req = 'SELECT COUNT(*) FROM commentaire WHERE id = '.(int)$_GET['id'];
    $stmt = $pdo->query($req);
    $nb = $stmt->fetchColumn();

    if ($nb == 0) {
      $errors[] = 'Le commentaire n°'.(int)$_GET['id'].' que vous avez sélectionné n\'existe pas ou plus.';
    } else {
      $req = 'SELECT c.id id, m.pseudo pseudo, c.annonce_id idAnnonce, commentaire, c.date_enregistrement date_enregistrement '
      .'FROM commentaire c JOIN annonce a ON a.id = c.annonce_id '
      .'JOIN membre m ON m.id = a.membre_id WHERE c.id = '. (int)$_GET['id'];
      $stmt = $pdo->query($req);
      $commentaire = $stmt->fetch();
    }
  }

  if (!empty($_POST)) {
    sanitizePost();
    extract($_POST);

    $req = 'UPDATE commentaire SET commentaire = :commentaire WHERE id = :id';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':id', (int)$_GET['id']);
    $stmt->bindValue(':commentaire', $commentaire);
    $stmt->execute();

    setFlashMessage('Le commentaire n°'.(int)$_GET['id'].' a bien été modifié.');
    header('Location: commentaires.php');
    die;

  }
} else {
  setFlashMessage('Vous devez absolument sélectionner un commentaire à modifier dans la liste', 'error');
  header('Location: commentaires.php');
  die;
}

// ----------------- Traitement de l'affichage -----------------
// ----------------- Traitement de l'affichage -----------------

include __DIR__ .'/../layout/top.php';
?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Edition des commentaires</h1>
    </div>
  </div>

  <?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
      <p><strong>La page contient des erreurs</strong></p>
      <?= implode ('<br>', $errors); ?>
    </div>
  <?php endif; ?>

  <form method="post" id="commentaire">
    <div class="row">
      <div class="col-sm-4">

        <div class="col-sm-12 form-group">
          <div class="col-xs-4">
            <label for="">ID</label>
          </div>
          <div class="col-xs-8">
            <p><?= $commentaire['id']; ?></p>
          </div>
        </div>

        <div class="col-sm-12 form-group">
          <div class="col-xs-4">
            <label for="">Membre</label>
          </div>
          <div class="col-xs-8">
            <p><?= $commentaire['pseudo']; ?></p>
          </div>
        </div>

        <div class="col-sm-12 form-group">
          <div class="col-xs-4">
            <label for="">Annonce n°</label>
          </div>
          <div class="col-xs-8">
            <p><?= $commentaire['idAnnonce']; ?></p>
          </div>
        </div>

        <div class="col-sm-12 form-group">
          <div class="col-xs-4">
            <label for="">Date édition</label>
          </div>
          <div class="col-xs-8">
            <p><?= strftime('%d/%m/%Y',strtotime($commentaire['date_enregistrement'])); ?></p>
          </div>
        </div>
      </div>

      <div class="col-sm-8">
        <div class="col-sm-9 form-group">
          <label for="">Commentaire</label>
          <textarea name="commentaire" value="<?= $commentaire['commentaire']; ?>" rows="5" col="10" class="form-control"><?= $commentaire['commentaire']; ?></textarea>
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
