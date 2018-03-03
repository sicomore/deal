<?php  // -------- Traitement des données --------------
require_once __DIR__ .'/../include/init.php';
adminSecurity();

$req = 'SELECT c.*, m.pseudo pseudo FROM commentaire c '
.'JOIN membre m ON m.id = c.membre_id ORDER BY c.date_enregistrement DESC';
$stmt = $pdo->query($req);
$commentaires = $stmt->fetchAll();


// ----------------- Traitement de l'affichage -----------------------
// ----------------- Traitement de l'affichage -----------------------

include __DIR__ .'/../layout/top.php';
?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Gestion des commentaires</h1>
    </div>
  </div>

  <?php displayFlashMessage(); ?>

  <table class="table table-bordered table-striped">
    <th colspan="6">
      <h4>Commentaires</h4>
    </th>
    <tr>
      <th class="col-xs-1">ID</th>
      <th class="col-xs-auto">Membre</th>
      <th class="col-xs-auto">Annonce</th>
      <th class="col-xs-auto">Commentaire</th>
      <th class="col-xs-auto">Date d'édition</th>
      <th class="col-xs-1">Options</th>
    </tr>

    <?php
    foreach ($commentaires as $commentaire) :
      ?>
      <tr>
        <td><?= $commentaire['id'] ?></td>
        <td><?= $commentaire['membre_id'].' - '.$commentaire['pseudo'] ?></td>
        <td><?= $commentaire['annonce_id'] ?></td>
        <td><?= $commentaire['commentaire'] ?></td>
        <td><?= strftime('%d/%m/%Y',strtotime($commentaire['date_enregistrement'])); ?></td>
        <td>
          <a href="commentaire-edit.php?id=<?= $commentaire['id'] ?>" class="btn btn-primary">Modifier</a>
          <a href="commentaire-delete.php?id=<?= $commentaire['id'] ?>" class="btn btn-danger">Supprimer</a>
        </td>
      </tr>
      <?php
    endforeach;
    ?>

  </table>
</div>

<?php
include __DIR__ .'/../layout/bottom.php';
?>
