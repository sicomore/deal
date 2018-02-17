<?php  // -------- Traitement des données --------------
require_once __DIR__ .'/../include/init.php';
adminSecurity();

$errors = [];
$titre = $mots_cles = '';

if (!empty($_POST)) {
  sanitizePost();
  extract($_POST);

  if (empty($_POST['titre'])) {
    $errors[] = 'Renseigner le titre du produit';

  } else {
    $reqS = 'SELECT COUNT(*) FROM categorie WHERE titre = '.$pdo->quote($_POST['titre']);

    //On modifie la catégorie que l'on est en train de modifier
    if (isset($_GET['id'])) {
      $reqS .= ' AND id != '. (int)$_GET['id'];
    }

    $stmt = $pdo->query($reqS);
    $nb = $stmt->fetchColumn();

    if ($nb != 0) {
      $errors[] = "La catégorie $titre existe déjà. Veuillez en saisir une nouvelle.";
    }
    // if (!empty($_POST['mots_cles'])) {
    //   $req = 'SELECT mots_cles FROM categorie';
    //   $stmt = $pdo->query($req);
    //   $motsCles = $tmt->fetchAll();
    // }
  }


  if (empty($errors)) {
    if (isset($_GET['id'])) { // Modification
      $req = 'UPDATE categorie SET titre = :titre, mots_cles = :mots_cles WHERE id = :id';
      $stmt = $pdo->prepare($req);
      $stmt->bindValue(':id', $_GET['id']);
      // $stmt->bindValue(':titre', $titre);
      // $stmt->bindValue(':mots_cles', $mots_cles);
      // $stmt->execute();
    } else { // Création
      $req = 'INSERT INTO categorie (titre, mots_cles) VALUES (:titre, :mots_cles)';
      $stmt = $pdo->prepare($req);
    }
    $stmt->bindValue(':titre', $titre);
    $stmt->bindValue(':mots_cles', $mots_cles);
    $stmt->execute();
    setFlashMessage('La catégorie '.$_POST['titre'].' a bien été créée.');
    header('Location: categorie.php');
    die;
  }
  // Diffusion du message de confirmation et redirection vers la liste des catégories

} elseif (isset($_GET['id'])) {
  $req = 'SELECT titre, mots_cles FROM categorie WHERE id ='. (int)$_GET['id'];
  $stmt = $pdo->query($req);
  $categorie = $stmt->fetch();
  $titre = $categorie['titre'];
  $mots_cles = $categorie['mots_cles'];
}


// ----------------- Traitement de l'affichage -----------------
// ----------------- Traitement de l'affichage -----------------

include __DIR__ .'/../layout/top.php';
?>

<h1>Edition des catégories</h1>

<form method="post">
  <div class="row">
    <div class="col-sm-3 form-group form-inline">
      <label for="">Titre</label>
      <input type="text" name="titre" value="<?= $titre ?>" class="form-control">
    </div>
    <div class="col-sm-6 form-group form-inline">
      <label for="">Mots Clés</label>
        <input type="text" name="mots_cles" value="<?= $mots_cles; ?>" col="10" class="form-control">
        <!-- <textarea name="mots_cles" value="< ?= $mots_cles; ?>" rows="1" col="10" class="form-control"><?= $mots_cles; ?></textarea> -->
    </div>
    <div class="col-sm-3">
      <button class="btn btn-primary pull-right" type="submit" name="button">Enregistrer</button>
      <a href="categorie.php" class="btn btn-default pull-right" type="cancel">Annuler</a>
    </div>
  </div>
</form>

<?php
if (!empty($errors)) :
  ?>
  <div class="alert alert-danger">
    <p><strong>Le formulaire contient des erreurs</strong></p>
    <?= implode ('<br>', $errors); ?>
  </div>
  <?php
endif;
?>

<?php
include __DIR__ .'/../layout/bottom.php';
?>
