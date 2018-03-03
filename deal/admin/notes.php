<?php  // -------- Traitement des données --------------
require_once __DIR__ .'/../include/init.php';
adminSecurity();

$req = 'SELECT n.id id, n.note note, n.avis avis, n.date_enregistrement date_enregistrement, mc.id idClient, mv.id idVendeur, mc.pseudo pseudoClient, mv.pseudo pseudoVendeur, mc.email mailClient, mv.email mailVendeur FROM notes n '
.'JOIN membre mc ON mc.id = n.membre_id1 '
.'JOIN membre mv ON mv.id = n.membre_id2 '
.'ORDER BY n.date_enregistrement DESC';
$stmt = $pdo->query($req);
$notes = $stmt->fetchAll();


// ----------------- Traitement de l'affichage -----------------------
// ----------------- Traitement de l'affichage -----------------------

include __DIR__ .'/../layout/top.php';
?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Gestion des notes et avis</h1>
    </div>
  </div>

  <?php displayFlashMessage(); ?>

  <table class="table table-bordered table-striped">
    <th colspan="7">
      <h4>Notes et Avis</h4>
    </th>
    <tr>
      <th class="col-xs-1">ID</th>
      <th class="col-xs-auto">Vendeur</th>
      <th class="col-xs-auto">Note</th>
      <th class="col-xs-auto">Avis</th>
      <th class="col-xs-auto">Client</th>
      <th class="col-xs-auto">Date d'enregistrement</th>
      <th class="col-xs-1">Options</th>
    </tr>

    <?php
    foreach ($notes as $note) :
      ?>
      <tr>
        <td><?= $note['id']; ?></td>
        <td><?= $note['pseudoVendeur'].' - '.$note['idVendeur'].' - '. $note['mailVendeur']; ?></td>
        <td><?= $note['note'] ?></td>
        <td><?= $note['avis'] ?></td>
        <td><?= $note['pseudoClient'].' - '.$note['idClient'].' - '.$note['mailClient']; ?></td>
        <td><?= strftime('%d/%m/%Y',strtotime($note['date_enregistrement'])); ?></td>
        <td>
          <a href="note-edit.php?id=<?= $note['id'] ?>" class="btn btn-primary">Modifier</a>
          <a href="note-delete.php?id=<?= $note['id'] ?>" class="btn btn-danger">Supprimer</a>
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
