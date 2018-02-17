<?php  // -------- Traitement des données --------------
require_once __DIR__ .'/../include/init.php';
adminSecurity();

$req = 'SELECT c.*, m.pseudo pseudo FROM commentaire c JOIN membre m ON m.id = c.membre_id ORDER BY c.id';
$stmt = $pdo->query($req);
$commentaires = $stmt->fetchAll();


// ----------------- Traitement de l'affichage -----------------------
// ----------------- Traitement de l'affichage -----------------------

include __DIR__ .'/../layout/top.php';
?>
<h1>Gestion des commentaires</h1>
<?php
displayFlashMessage();
?>

<table class="table table-bordered table-striped">
  <th colspan="4">
    Commentaires
  </th>
  <tr>
    <th class="col-xs-1">ID</th>
    <th class="col-xs-auto">Membre</th>
    <th class="col-xs-auto">ID annonce</th>
    <th class="col-xs-auto">Commentaire</th>
    <th class="col-xs-auto">Date d'enregistrement</th>
    <th class="col-xs-3">Options</th>
  </tr>

    <?php
    foreach ($commentaires as $commentaire) :
      ?>
      <tr>
        <td><?= $commentaire['id'] ?></td>
        <td><?= $commentaire['membre_id'].' - '.$commentaire['pseudo'] ?></td>
        <td><?= $commentaire['annonce_id'] ?></td>
        <td><?= $commentaire['commentaire'] ?></td>
        <td><?= $commentaire['date_enregistrement'] ?></td>
        <td>
          <a href="commentaire-edit.php?id=<?= $commentaire['id'] ?>" class="btn btn-primary">Modifier</a>
          <a href="commentaire-delete.php?id=<?= $commentaire['id'] ?>" class="btn btn-danger">Supprimer</a>
        </td>
      </tr>
      <?php
    endforeach;
    ?>

</table>

<?php
include __DIR__ .'/../layout/bottom.php';
?>
